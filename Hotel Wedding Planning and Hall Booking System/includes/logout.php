<?php
// Include session helper
require_once 'session_helper.php';

// Logout user
logout($conn);
checkRememberMe($conn);

// Redirect to homepage
header("Location: ../index.php");
exit;
?>