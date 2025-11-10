<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'dbconnection.php';

// Accept only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Get and sanitize inputs
$email = $conn->real_escape_string(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

$response = [];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = [
        'success' => false,
        'message' => 'Invalid email format'
    ];
    echo json_encode($response);
    exit;
}

// Check if user exists
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $response = [
        'success' => false,
        'message' => 'Invalid credentials'
    ];
    echo json_encode($response);
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    $response = [
        'success' => false,
        'message' => 'Invalid credentials'
    ];
    echo json_encode($response);
    exit;
}

// Delete user account
$deleteStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$deleteStmt->bind_param("i", $user['id']);
$deleteStmt->execute();

// Destroy session and remove cookie if present
session_destroy();
setcookie('remember_token', '', time() - 3600, '/');

$response = [
    'success' => true,
    'message' => 'Your account has been deleted'
];
echo json_encode($response);
exit;
