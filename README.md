# IoT Plant Monitoring & Irrigation System

An IoT-based plant production and management system built as a final year project at the **University of Somalia (UNISO)**.

An **ESP32** reads temperature, humidity and soil moisture from a live plant, drives a water pump through a relay, and pushes every reading to a **PHP + MySQL** web dashboard over Wi-Fi. From the dashboard you can watch the readings update in real time and switch the pump between **auto**, **manual on**, and **manual off**.

---

## Features

- **Live sensor dashboard** — temperature, humidity, soil moisture and pump status, refreshed automatically with charts (ApexCharts).
- **Automatic irrigation** — the ESP32 turns the pump on whenever soil moisture drops below the configured threshold (default 40%).
- **Manual pump override** — send `on` / `off` / `auto` from the web dashboard; the ESP32 polls for the command each cycle.
- **On-device LCD** — a 16x2 I2C display shows readings and pump state without needing the web app.
- **Status LEDs** — a green LED lights while the pump runs and a red one while it's idle, readable at a glance from across the room.
- **Sensor reports** — browse all historical readings, filter by a custom date range, and export.
- **Role-based accounts** — separate `admin` and `user` logins. Admins can manage both user and admin accounts.
- **Change password** for the logged-in account.

---

## Tech Stack

| Layer | Technology |
| --- | --- |
| Firmware | ESP32 (Arduino C++), DHT11, capacitive/resistive soil sensor, relay module, I2C LCD |
| Backend | PHP 8 (procedural + MySQLi), JSON APIs |
| Database | MySQL / MariaDB |
| Frontend | Bootstrap 5 (Datta Able template), vanilla JS, ApexCharts, SweetAlert2 |
| Server | XAMPP (Apache + MySQL) |

---

## Hardware

| Component | ESP32 Pin |
| --- | --- |
| DHT11 (temperature & humidity) | GPIO 4 |
| Soil moisture sensor (analog out) | GPIO 34 |
| Relay module (water pump) | GPIO 26 |
| Green status LED (pump running) | GPIO 17 |
| Red status LED (pump idle) | GPIO 2 |
| I2C LCD 16x2 — SDA | GPIO 21 |
| I2C LCD 16x2 — SCL | GPIO 22 |

Libraries required: `WiFi`, `HTTPClient`, `DHT sensor library`, `Wire`, `LiquidCrystal_I2C`.

**The relay is active-LOW** — `RELAY_PIN` goes LOW to switch the pump ON, HIGH to switch it OFF. Invert those writes if your relay board is active-HIGH.

**Calibrate the soil sensor** to your own probe. `Soil_Dry = 3300` and `Soil_Wet = 1400` in `loop()` map the raw ADC reading to a percentage; read `soilRaw` on the Serial Monitor with the probe dry and then in water, and substitute your values.

---

## Project Structure

```
plant_monitor/
├── login.php                     # Login page (entry point)
├── logout.php                    # Destroys the session
├── plant_monitor.sql             # Database schema + sample data
├── esp32_code/
│   └── main.cpp                  # ESP32 firmware
└── dist/
    ├── application/
    │   ├── api/                  # JSON endpoints
    │   │   ├── receive_data.php      # ESP32 → server (POST readings)
    │   │   ├── get_pump_command.php  # ESP32 → server (GET pump command)
    │   │   ├── set_pump_command.php  # dashboard → server (set pump command)
    │   │   ├── get_data.php          # latest reading + last 20 for charts
    │   │   ├── login.php             # authenticates admin then user
    │   │   ├── users.php             # user CRUD
    │   │   ├── admin.php             # admin CRUD
    │   │   ├── sensor_report.php     # historical / date-filtered report
    │   │   └── change_password.php
    │   ├── config/               # DB connection + input validation
    │   ├── views/                # dashboard, users, admin, reports, layout partials
    │   └── js/                   # page scripts
    └── assets/                   # template CSS, JS, fonts, images
```

---

## Database Schema

| Table | Purpose |
| --- | --- |
| `user` | End-user accounts (`id`, `username`, `password`, `email`, `created_at`) |
| `admin` | Administrator accounts (same shape as `user`) |
| `sensor_data` | Every reading: `temperature`, `humidity`, `soil_moisture`, `pump_status`, `pump_mode`, `created_at`, FK → `user.id` |
| `pump_commands` | Single row holding the current command: `on`, `off`, or `auto` |

---

## Setup

### 1. Web application

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Clone this repository into your `htdocs` folder:
   ```bash
   git clone https://github.com/<your-username>/plant_monitor.git
   ```
   so the path is `C:/xampp/htdocs/plant_monitor`.
3. Open [phpMyAdmin](http://localhost/phpmyadmin), create a database named **`plant_monitor`**, and import `plant_monitor.sql`.
4. Check the credentials in [dist/application/config/conn.php](dist/application/config/conn.php) match your MySQL setup (defaults to user `root` with no password — the XAMPP default).
5. Visit **http://localhost/plant_monitor/login.php**.

### 2. ESP32 firmware

The firmware is a [PlatformIO](https://platformio.org/) source file (`main.cpp`, including `<Arduino.h>`) rather than an Arduino `.ino` sketch.

1. Install the **PlatformIO IDE** extension in VS Code, create an ESP32 project, and place [esp32_code/main.cpp](esp32_code/main.cpp) in its `src/` folder. Add the libraries listed above to `lib_deps`.
   *Using the Arduino IDE instead?* Rename `main.cpp` to `esp32_plant_monitor.ino`, put it in a folder of the same name, and delete the `#include <Arduino.h>` line and the two forward declarations — the Arduino IDE adds those itself.
2. Find your computer's local IP (`ipconfig` on Windows → IPv4 Address).
3. Replace the placeholders at the top of the file with your own values:
   ```cpp
   const char* WIFI_SSID     = "WIFI_NAME";
   const char* WIFI_PASSWORD = "WIFI_PASSWORD";

   const char* SERVER_URL   = "http://YOUR_LAPTOP_IP/plant_monitor/dist/application/api/receive_data.php";
   const char* PUMP_CMD_URL = "http://YOUR_LAPTOP_IP/plant_monitor/dist/application/api/get_pump_command.php";
   ```
4. The ESP32 and your computer must be on the **same Wi-Fi network**, and Windows Firewall must allow inbound connections on port 80.
5. Wire the components per the pin table, upload, and open the Serial Monitor at **115200 baud** to confirm it connects and posts data.

---

## How It Works

```
                  every 5s
  ┌────────┐  POST readings   ┌──────────────────┐        ┌──────────┐
  │ ESP32  │ ───────────────► │ receive_data.php │ ─────► │  MySQL   │
  │ DHT11  │                  └──────────────────┘        │sensor_   │
  │ Soil   │                                              │  data    │
  │ Relay  │  GET command     ┌──────────────────────┐    └────┬─────┘
  │ LCD    │ ◄─────────────── │ get_pump_command.php │ ◄───────┤
  └────────┘                  └──────────────────────┘         │
                                                               │
  ┌────────────┐  poll        ┌──────────────┐                 │
  │ Dashboard  │ ───────────► │ get_data.php │ ────────────────┘
  │  (browser) │              └──────────────┘
  │            │  set mode    ┌──────────────────────┐
  │            │ ───────────► │ set_pump_command.php │
  └────────────┘              └──────────────────────┘
```

1. Every 5 seconds the ESP32 reads all three sensors and updates the LCD and status LEDs.
2. It calls `get_pump_command.php`. If the command is `on` or `off`, the relay follows it in **manual** mode. If it's `auto`, the relay follows the moisture threshold.
3. It POSTs the reading and pump state to `receive_data.php`, which inserts a row into `sensor_data`.
4. The dashboard polls `get_data.php` for the latest reading plus the last 20 for the charts, and writes new commands via `set_pump_command.php`.

---

## Default Login

The imported SQL dump ships with demo accounts. Sign in as:

| Role | Username | Password |
| --- | --- | --- |
| Admin | `admin` | `123` |
| User | `omar` | `123` |

**Change these immediately** if you deploy anywhere beyond your local machine.

---

## Author

**Koshin** — University of Somalia (UNISO), Final Year Project.

## License

Released for educational purposes.
