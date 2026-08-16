<?php
// ============================================================
// receive_data.php
// ESP32 sends sensor data here via HTTP POST
// Path: C:/xampp/htdocs/plant_monitor/api/receive_data.php
// ============================================================
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "plant_monitor");
if ($conn->connect_error) { die(json_encode(["status"=>"error"])); }

// Default user_id = 1 (the logged-in user)
$user_id      = 1;
$temperature  = floatval($_POST["temperature"]   ?? 0);
$humidity     = floatval($_POST["humidity"]      ?? 0);
$soil         = intval($_POST["soil_moisture"]   ?? 0);
$pump_status  = intval($_POST["pump_status"]     ?? 0);
$pump_mode    = $conn->real_escape_string($_POST["pump_mode"] ?? "auto");

$sql  = "INSERT INTO sensor_data (user_id, temperature, humidity, soil_moisture, pump_status, pump_mode)
         VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iddiis", $user_id, $temperature, $humidity, $soil, $pump_status, $pump_mode);

echo $stmt->execute()
    ? json_encode(["status"=>"success"])
    : json_encode(["status"=>"error", "msg"=>$stmt->error]);

$stmt->close(); $conn->close();
?>
