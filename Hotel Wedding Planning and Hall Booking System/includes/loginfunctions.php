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
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : '';
    
    // Initialize response array
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
    $stmt = $conn->prepare("SELECT id, fullname, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Handle remember me
            if ($remember == 'true') {
                // Generate a token
                $token = bin2hex(random_bytes(16));
                
                // Set cookie for 30 days
                $cookie_expiry = time() + (86400 * 30); // 30 days
                setcookie('remember_token', $token, $cookie_expiry, '/');
                
                // Store the token in database (you may need to add a remember_token column)
                // This is simplified - a more secure implementation would store a hashed token
                $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $stmt->bind_param("si", $token, $user['id']);
                $stmt->execute();
            }
            
            // Success response
            $response = [
                'success' => true,
                'message' => 'Login successfully you ' . $user['fullname'],
                'fullname' => $user['fullname']
            ];
        } else {
            // Wrong password
            $response = [
                'success' => false,
                'message' => 'Incorrect password'
            ];
        }
    } else {
        // User not found
        $response = [
            'success' => false,
            'message' => 'Email not registered'
        ];
    }
    
    $stmt->close();
    echo json_encode($response);
    exit;
}

// If it's not a POST request
header("Location: ../index.php");
exit;
?>