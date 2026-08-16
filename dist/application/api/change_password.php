<?php
session_start();
header('Content-Type: application/json');

include '../config/conn.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$role = $_SESSION['role'];
$table = ($role === 'admin') ? 'admin' : 'user';

$current_password = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';
$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

if (empty($current_password) || empty($new_password)) {
    echo json_encode(['status' => 'error', 'message' => 'Please provide both current and new password.']);
    exit;
}

$current_password_hashed = md5($current_password);
$new_password_hashed = md5($new_password);

$stmt = $conn->prepare("SELECT id FROM $table WHERE id = ? AND password = ?");
$stmt->bind_param("is", $user_id, $current_password_hashed);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Password matches, update it
    $update_stmt = $conn->prepare("UPDATE $table SET password = ? WHERE id = ?");
    $update_stmt->bind_param("si", $new_password_hashed, $user_id);
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error during update.']);
    }
    $update_stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect current password.']);
}

$stmt->close();
$conn->close();
?>
