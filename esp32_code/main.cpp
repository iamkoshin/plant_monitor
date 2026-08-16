#include <Arduino.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

// ── Wi-Fi Credentials ──────────────────────────────────────
const char* WIFI_SSID     = "WIFI_NAME";      
const char* WIFI_PASSWORD = "WIFI_PASSWORD";  

// ── Server URLs ────────────────────────────────────────────
// Find your laptop IP: open CMD → type ipconfig → look for IPv4
const char* SERVER_URL      = "http://YOUR_LAPTOP_IP/plant_monitor/dist/application/api/receive_data.php";
const char* PUMP_CMD_URL    = "http://YOUR_LAPTOP_IP/plant_monitor/dist/application/api/get_pump_command.php";

// ── Pin Definitions ────────────────────────────────────────
#define DHT_PIN        4    // DHT11 data pin     → GPIO 4
#define SOIL_PIN       34   // Soil moisture AOUT → GPIO 34
#define RELAY_PIN      26   // Relay IN           → GPIO 26
#define green_led      17
#define red_led      2

// ── LCD Setup (I2C address 0x27, 16 columns, 2 rows) ───────
LiquidCrystal_I2C lcd(0x27, 16, 2);

// ── Settings ───────────────────────────────────────────────
#define DHT_TYPE           DHT11
#define MOISTURE_THRESHOLD 40      // Auto-irrigate below 40%
#define SEND_INTERVAL      5000    // Send data every 5 seconds

DHT dht(DHT_PIN, DHT_TYPE);
unsigned long lastSendTime = 0;
bool pumpRunning = false;

// Forward declarations for helper functions
void sendData(float temp, float hum, int soil, bool pump, String mode);
String getPumpCommand();

// ──────────────────────────────────────────────────────────
void setup() {
  Serial.begin(115200);
  delay(500);

  // ── Pin modes ──────────────────────────────────────────
  pinMode(RELAY_PIN, OUTPUT);
  pinMode(green_led, OUTPUT);
  pinMode(red_led, OUTPUT);
  digitalWrite(RELAY_PIN, HIGH);   // Pump OFF at start
  digitalWrite(green_led, LOW);           // LED OFF at start
  digitalWrite(red_led, LOW);             // LED OFF at start
  // ── Init LCD ───────────────────────────────────────────
  Wire.begin(21, 22);             // SDA=21, SCL=22
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Plant Monitor");
  lcd.setCursor(0, 1);
  lcd.print("Starting...");
  delay(2000);
  lcd.clear();

  // ── Init DHT ───────────────────────────────────────────
  dht.begin();

  // ── Connect to Wi-Fi ───────────────────────────────────
  lcd.setCursor(0, 0);
  lcd.print("Connecting WiFi");
  Serial.println("Connecting to Wi-Fi...");
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 20) {
    delay(500);
    Serial.print(".");
    attempts++;
  }

  lcd.clear();
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\nWi-Fi Connected!");
    Serial.println(WiFi.localIP());
    lcd.setCursor(0, 0);
    lcd.print("WiFi Connected!");
    lcd.setCursor(0, 1);
    lcd.print(WiFi.localIP());
    delay(2000);
  } else {
    Serial.println("\nWi-Fi FAILED.");
    lcd.setCursor(0, 0);
    lcd.print("WiFi Failed!");
    lcd.setCursor(0, 1);
    lcd.print("Check Settings");
    delay(2000);
  }

  lcd.clear();
}

// ──────────────────────────────────────────────────────────
void loop() {
  unsigned long now = millis();

  if (now - lastSendTime >= SEND_INTERVAL) {
    lastSendTime = now;

    // ── 1. Read Sensors ──────────────────────────────────
    float temperature = dht.readTemperature();
    float humidity    = dht.readHumidity();

    
    int Soil_Dry = 3300;  
    int Soil_Wet = 1400;  
    int soilRaw     = analogRead(SOIL_PIN);
    int soilPercent = map(soilRaw, Soil_Dry, Soil_Wet, 0, 100);
    soilPercent     = constrain(soilPercent, 0, 100);

    if (isnan(temperature) || isnan(humidity)) {
      Serial.println("ERROR: DHT11 read failed!");
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("Sensor Error!");
      return;
    }

    Serial.println("──────────────────────────");
    Serial.printf("Temp     : %.1f C\n",  temperature);
    Serial.printf("Humidity : %.1f %%\n", humidity);
    Serial.printf("Soil     : %d %%\n",   soilPercent);

    // ── 2. Update LCD ────────────────────────────────────
    // Line 1: Temperature and Humidity
    lcd.setCursor(0, 0);
    lcd.print("T:");
    lcd.print(temperature, 1);
    lcd.print("C H:");
    lcd.print(humidity, 0);
    lcd.print("%  ");

    // Line 2: Soil moisture and pump status
    lcd.setCursor(0, 1);
    lcd.print("Soil:");
    lcd.print(soilPercent);
    lcd.print("% P:");

    // ── 3. Irrigation Logic ──────────────────────────────
    String pumpMode = "auto";
    String manualCmd = getPumpCommand();

    if (manualCmd == "on") {
      digitalWrite(RELAY_PIN, LOW);
      pumpRunning = true;
      pumpMode    = "manual";
      lcd.print("ON(M)");
      Serial.println("Pump: ON (Manual)");
      digitalWrite(green_led, HIGH); 
      digitalWrite(red_led, LOW); 
    } else if (manualCmd == "off") {
      digitalWrite(RELAY_PIN, HIGH);
      pumpRunning = false;
      pumpMode    = "manual";
      lcd.print("OFF(M)");
      Serial.println("Pump: OFF (Manual)");
      digitalWrite(green_led, LOW); 
      digitalWrite(red_led, HIGH);  
    } else {
      // Auto mode
      if (soilPercent < MOISTURE_THRESHOLD) {
        digitalWrite(RELAY_PIN, LOW);
        pumpRunning = true;
        lcd.print("ON(A) ");
        Serial.println("Pump: ON (Auto - dry)");
        digitalWrite(green_led, HIGH); 
        digitalWrite(red_led, LOW);    
      } else {
        digitalWrite(RELAY_PIN, HIGH);
        pumpRunning = false;
        lcd.print("OFF   ");
        Serial.println("Pump: OFF (Auto - ok)");
        digitalWrite(green_led, LOW); 
        digitalWrite(red_led, HIGH);  
      }
    }

    // ── 4. Send to Server ────────────────────────────────
    sendData(temperature, humidity, soilPercent, pumpRunning, pumpMode);
  }
}

// ──────────────────────────────────────────────────────────
// Send sensor data to PHP server
// ──────────────────────────────────────────────────────────
void sendData(float temp, float hum, int soil, bool pump, String mode) {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("Wi-Fi lost. Skipping send.");
    return;
  }

  HTTPClient http;
  http.begin(SERVER_URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  String body = "temperature="   + String(temp, 1);
  body       += "&humidity="     + String(hum, 1);
  body       += "&soil_moisture="+ String(soil);
  body       += "&pump_status="  + String(pump ? "1" : "0");
  body       += "&pump_mode="    + mode;

  int code = http.POST(body);
  Serial.printf("Server response: %d\n", code);
  http.end();
}

// ──────────────────────────────────────────────────────────
// Get manual pump command from dashboard
// Returns "on", "off", or "auto"
// ──────────────────────────────────────────────────────────
String getPumpCommand() {
  if (WiFi.status() != WL_CONNECTED) return "auto";

  HTTPClient http;
  http.begin(PUMP_CMD_URL);
  int code = http.GET();
  String response = "auto";

  if (code == 200) {
    response = http.getString();
    response.trim();
  }
  http.end();
  return response;
}
