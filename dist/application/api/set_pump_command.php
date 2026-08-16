<?php
// ============================================================
// set_pump_command.php
// Dashboard sends pump command here via POST
// ============================================================
header("Content-Type: application/json");
$conn    = new mysqli("localhost", "root", "", "plant_monitor");
$command = $_POST["command"] ?? "auto";

if (!in_array($command, ["on","off","auto"])) {
    echo json_encode(["status"=>"error","msg"=>"Invalid command"]);
    exit;
}

$stmt = $conn->prepare("UPDATE pump_commands SET command=? WHERE id=1");
$stmt->bind_param("s", $command);
echo $stmt->execute()
    ? json_encode(["status"=>"success","command"=>$command])
    : json_encode(["status"=>"error"]);
$stmt->close(); $conn->close();
?>
