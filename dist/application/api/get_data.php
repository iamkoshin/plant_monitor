<?php
// ============================================================
// get_data.php
// Dashboard fetches latest sensor readings and history
// ============================================================
header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../config/conn.php';
// Latest single reading — shared data, visible to all users
$latest_q = "SELECT * FROM sensor_data ORDER BY created_at DESC LIMIT 1";
$stmt     = $conn->prepare($latest_q);
$stmt->execute();
$latest   = $stmt->get_result()->fetch_assoc();

// Last 20 readings for chart — shared data, visible to all users
$hist_q = "SELECT temperature, humidity, soil_moisture, pump_status, created_at
            FROM sensor_data ORDER BY created_at DESC LIMIT 20";
$stmt2  = $conn->prepare($hist_q);
$stmt2->execute();
$rows   = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

// Current pump command
$pump_row  = $conn->query("SELECT command FROM pump_commands LIMIT 1")->fetch_assoc();

echo json_encode([
    "latest"       => $latest,
    "history"      => array_reverse($rows),
    "pump_command" => $pump_row["command"] ?? "auto"
]);
$conn->close();
