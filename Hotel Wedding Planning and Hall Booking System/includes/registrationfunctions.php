<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'dbconnection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $fullname = $conn->real_escape_string(trim($_POST['fullname']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $nic = $conn->real_escape_string(trim($_POST['nic']));
    $address = $conn->real_escape_string(trim($_POST['address']));
    // $dob = $conn->real_escape_string(trim($_POST['dob']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Initialize errors array
    $errors = [];
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count > 0) {
        $errors[] = "Email is already registered";
    }
    
    // Check if phone already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count > 0) {
        $errors[] = "Phone number is already registered";
    }
    
    // Check if NIC already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE nic = ?");
    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count > 0) {
        $errors[] = "NIC number is already registered";
    }
    
    // If there are no errors, insert the user
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare SQL and bind parameters
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, nic, address, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname, $email, $phone, $nic, $address, $hashed_password);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful
            echo json_encode(['success' => true, 'message' => 'Registration successful!']);
            exit;
        } else {
            // If there was an error with the SQL execution
            $errors[] = "Registration failed: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    // If there are errors, return them as JSON
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }
}

// If it's not a POST request or some other issue
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../index.php");
    exit;
}
?>