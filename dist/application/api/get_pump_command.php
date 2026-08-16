<?php
// ============================================================
// get_pump_command.php
// ESP32 calls this (GET) to check current pump command
// Returns: "on", "off", or "auto"
// ============================================================
$conn = new mysqli("localhost", "root", "", "plant_monitor");
if ($conn->connect_error) { echo "auto"; exit; }

$result = $conn->query("SELECT command FROM pump_commands ORDER BY id DESC LIMIT 1");
$row    = $result->fetch_assoc();
echo $row ? $row["command"] : "auto";
$conn->close();
?>
