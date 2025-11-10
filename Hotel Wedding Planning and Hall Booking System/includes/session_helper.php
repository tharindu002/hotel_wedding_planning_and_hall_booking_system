<?php

// Include database connection
require_once 'dbconnection.php';

/**
 * Check if user is logged in
 * 
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Get the current user's full name
 * 
 * @return string|null
 */
function getCurrentUserName() {
    return isset($_SESSION['fullname']) ? $_SESSION['fullname'] : null;
}

/**
 * Get the current user's ID
 * 
 * @return int|null
 */
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Check remember me cookie and log user in if valid
 * 
 * @param mysqli $conn Database connection
 * @return bool
 */
function checkRememberMe($conn) {
    if (!isLoggedIn() && isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        
        // Check if token exists in database
        $stmt = $conn->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['nic'] = $user['nic'];
            $_SESSION['address'] = $user['address'];
            $_SESSION['logged_in'] = true;
            
            return true;
        }
        
        $stmt->close();
    }
    
    return false;
}

/**
 * Logout the current user
 * 
 * @param mysqli $conn Database connection
 * @return void
 */
function logout($conn) {
    // Clear remember token if exists
    if (isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
    }
    
    // Clear cookie
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }
    
    // Destroy session
    session_unset();
    session_destroy();
}

// Add the remember_token column to users table if it doesn't exist
// This is a one-time operation
function addRememberTokenColumn($conn) {
    $result = $conn->query("SHOW COLUMNS FROM `users` LIKE 'remember_token'");
    if ($result->num_rows === 0) {
        $conn->query("ALTER TABLE `users` ADD `remember_token` VARCHAR(255) NULL AFTER `password`");
    }
}

// Run on include
addRememberTokenColumn($conn);
?>