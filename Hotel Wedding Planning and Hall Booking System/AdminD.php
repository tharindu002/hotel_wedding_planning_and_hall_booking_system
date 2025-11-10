<?php
session_start();
require_once 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0F0C29, #302B63, #FF1493);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            min-height: 100vh;
            padding: 20px 0;
        }

        .dashboard-container {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(255, 20, 147, 0.6);
            padding: 40px;
            max-width: 500px;
            width: 90%;
            margin: 0 auto;
            animation: fadeIn 1s ease-in-out;
            max-height: 95vh;
            overflow-y: auto;
            /* Custom scrollbar styles */
            scrollbar-width: thin;
            scrollbar-color: #FF69B4 rgba(255, 255, 255, 0.1);
        }

        /* Custom scrollbar for Webkit browsers */
        .dashboard-container::-webkit-scrollbar {
            width: 8px;
        }

        .dashboard-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .dashboard-container::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #FF1493, #FF69B4);
            border-radius: 10px;
        }

        .dashboard-title {
            font-size: 2.8rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
            color: #FF69B4;
            text-shadow: 0 0 10px #FF69B4;
            position: sticky;
            top: 0;
            padding: 10px 0;
            background: rgba(15, 12, 41, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            margin-top: 0;
            z-index: 100;
        }

        .dashboard-button {
            background: linear-gradient(45deg, #FF1493, #FF69B4);
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 14px;
            font-size: 1.2rem;
            font-weight: 600;
            box-shadow: 0 0 10px #FF69B4;
            transition: all 0.3s ease-in-out;
            margin-bottom: 15px;
        }

        .dashboard-button:hover {
            background: linear-gradient(45deg, #FF69B4, #FF1493);
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 0 20px #FF69B4;
        }

        .button-container {
            padding-bottom: 20px;
        }

        @media (max-width: 576px) {
            .dashboard-title {
                font-size: 2rem;
            }

            .dashboard-button {
                font-size: 1rem;
                padding: 12px;
            }
            
            .dashboard-container {
                padding: 25px;
            }
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <div class="button-container d-grid gap-3">
            <button class="dashboard-button" onclick="location.href='feedbacks_table.php'">Users Feedbacks</button>
            <button class="dashboard-button" onclick="location.href='rud_contact_messages.php'">Users Contacts</button>
            <button class="dashboard-button" onclick="location.href='admintable.php'">Admin Control</button>
            <button class="dashboard-button" onclick="location.href='Usertable.php'">User Details</button>
            <button class="dashboard-button" onclick="location.href='customerbookingscrudadminside.php'">User Bookings</button>
            <button class="dashboard-button" onclick="location.href='imagemodifytable.php'">Gallery Update ( For Halls )</button>
            <button class="dashboard-button" onclick="location.href='galleryfunctionscrudtable.php'">Gallery Update ( Hotel Gallery )</button>
            <button class="dashboard-button" onclick="location.href='virtual_tour_crud.php'">Virtual Tour Update</button>
            <button class="dashboard-button" onclick="location.href='ru_table.php'">Prices Update</button>
            <button class="dashboard-button" onclick="location.href='HotelinfoCRUD.php'">Hotel Information Update</button>
            <!-- You can add more buttons here -->
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>