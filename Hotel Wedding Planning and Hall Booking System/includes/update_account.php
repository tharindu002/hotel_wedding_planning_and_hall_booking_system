<?php
session_start();
require_once 'dbconnection.php';

header('Content-Type: application/json');

// Assuming user ID is stored in session
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'errors' => ['User not logged in.']]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Prepare fields if they are not empty
    $fieldsToUpdate = [];
    $params = [];
    $types = "";
    $errors = [];

    // Validate and add only non-empty fields
    $inputFields = [
        'fullname' => 's',
        'email' => 's',
        'phone' => 's',
        'nic' => 's',
        'address' => 's',
    ];

    foreach ($inputFields as $field => $type) {
        if (isset($_POST[$field]) && trim($_POST[$field]) !== '') {
            $value = trim($_POST[$field]);
            $fieldsToUpdate[$field] = $conn->real_escape_string($value);
            $params[] = $value;
            $types .= $type;
        }
    }

    if (empty($fieldsToUpdate)) {
        echo json_encode(['success' => false, 'errors' => ['No fields to update.']]);
        exit;
    }

    // Check uniqueness only for email, phone, NIC
    foreach (['email' => 'Email', 'phone' => 'Phone number', 'nic' => 'NIC number'] as $field => $label) {
        if (isset($fieldsToUpdate[$field])) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE $field = ? AND id != ?");
            $stmt->bind_param("si", $fieldsToUpdate[$field], $user_id);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $errors[] = "$label is already registered.";
            }
        }
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // Build dynamic SQL
    $sqlParts = [];
    foreach ($fieldsToUpdate as $field => $_) {
        $sqlParts[] = "$field = ?";
    }

    $sql = "UPDATE users SET " . implode(", ", $sqlParts) . " WHERE id = ?";
    $params[] = $user_id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Account updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'errors' => ['Update failed: ' . $stmt->error]]);
    }

    $stmt->close();
}
?>
