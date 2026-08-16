<?php
// ============================================================
// login.php
// Simple login for Admin and User
// ============================================================
session_start();
header("Content-Type: application/json");

include __DIR__ . '/../config/conn.php';
$username = $conn->real_escape_string($_POST["username"] ?? "");
$password = MD5($_POST["password"] ?? "");

// Check admin first
$admin = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'")->fetch_assoc();
if ($admin) {
    $_SESSION["role"] = "admin";
    $_SESSION["username"] = $admin["username"];
    $_SESSION["email"] = $admin["email"];
    $_SESSION["user_id"] = $admin["id"];
    echo json_encode(["status" => "success", "role" => "admin"]);
    exit;
}

// Check user
$user = $conn->query("SELECT * FROM user WHERE username='$username' AND password='$password'")->fetch_assoc();
if ($user) {
    $_SESSION["role"] = "user";
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    echo json_encode(["status" => "success", "role" => "user"]);
    exit;
}

echo json_encode(["status" => "error", "msg" => "Invalid username or password"]);
$conn->close();
