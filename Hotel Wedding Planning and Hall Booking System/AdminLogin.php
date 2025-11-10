<?php
session_start();
require_once 'includes/dbconnection.php';

$admin_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_username = $_POST['admin_username'] ?? '';
    $admin_password = $_POST['admin_password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if ($admin_password === $admin['password']) { // Replace with password_verify() if hashed
            $_SESSION['adminlogged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin_username;
            header("Location: AdminD.php");
            exit;
        } else {
            $admin_error = "Invalid password.";
        }
    } else {
        $admin_error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFA6E7;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }

        .login-title {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .login-icon {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-icon i {
            font-size: 60px;
            color: #00D4F5;
            background-color: #FFF;
            padding: 20px;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 212, 245, 0.3);
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #ddd;
            padding: 12px 20px;
            height: 55px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #00D4F5;
            box-shadow: 0 0 0 0.25rem rgba(0, 212, 245, 0.25);
        }

        .login-button {
            background-color: #00D4F5;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 1.1rem;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background-color: #00B8D4;
            transform: scale(1.03);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #00D4F5;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .error-msg {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 15px;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 25px;
                margin: 0 15px;
            }

            .login-icon i {
                font-size: 50px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h2 class="login-title">Admin Login</h2>

        <?php if (!empty($admin_error)): ?>
            <div class="error-msg"><?= htmlspecialchars($admin_error) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="admin_username" placeholder="Username" required>
                <label for="username"><i class="fas fa-user me-2"></i>Username</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" name="admin_password" placeholder="Password" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="login-button">Log In</button>
            </div>

            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
