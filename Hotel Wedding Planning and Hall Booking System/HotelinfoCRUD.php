<?php
session_start();
require_once 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Fetch data
$result = $conn->query("SELECT * FROM hotel_info");

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $opening_time = $_POST['opening_time'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE hotel_info SET address=?, phone_number=?, email=?, opening_time=?, location_url=? WHERE id=?");
    $stmt->bind_param("sssssi", $address, $phone, $email, $opening_time, $location, $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Hotel info updated successfully!');</script>";
        // ✅ Redirect after POST
    header("Location: HotelinfoCRUD.php?updated=1");
    exit();
}

// Handle Delete
// if (isset($_GET['delete'])) {
//     $id = intval($_GET['delete']);
//     $conn->query("DELETE FROM hotel_info WHERE id = $id");
//     echo "<script>alert('Hotel info deleted.'); window.location.href='HotelinfoCRUD.php';</script>";
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Info CRUD</title>
        <style>
        :root {
            --primary: #ff69b4;
            --primary-light: #ffb6c1;
            --primary-dark: #c71585;
            --secondary: #f8f9fa;
            --success: #d4edda;
            --success-text: #155724;
            --dark: #343a40;
            --light: #f8f9fa;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #fafafa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        h2 {
            color: var(--primary-dark);
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-light);
            font-size: 2rem;
        }

        .alert {
            padding: 15px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            animation: fadeOut 3s forwards;
            animation-delay: 2s;
        }

        .alert-success {
            background-color: var(--success);
            color: var(--success-text);
            border-left: 5px solid #28a745;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        th {
            background-color: var(--primary);
            color: white;
            text-align: left;
            padding: 15px;
            font-weight: 600;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border 0.3s;
            font-size: 0.9rem;
            background-color: #fafafa;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 105, 180, 0.2);
        }

        textarea {
            min-height: 60px;
            resize: vertical;
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .action-cell {
            display: flex;
            gap: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        .form-row {
            position: relative;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .container {
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                min-width: 120px;
            }
            
            h2 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 10px;
            }
            
            h2 {
                font-size: 1.5rem;
                margin-bottom: 20px;
            }
            
            th, td {
                padding: 10px;
            }
            
            button {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }

        /* Animations */
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; visibility: hidden; }
        }

        /* Modern touches */
        .logo-area {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary-dark);
            letter-spacing: -1px;
        }

        .logo span {
            color: var(--dark);
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="logo-area">
        <div class="logo">Hotel<span>Info</span></div>
    </div>

    <div class="header">
        <h2>Insertion Table</h2>
        <a href="admin-dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

    <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success">
        ✅ Hotel information updated successfully!
    </div>
    <?php endif; ?>

<table>
    <tr>
        <th>Address</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Opening Time</th>
        <th>Location URL</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <form method="post" action="HotelinfoCRUD.php">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td class="form-row">
                            <input type="text" name="address" value="<?= htmlspecialchars($row['address']) ?>">
                        </td>
                        <td class="form-row">
                            <input type="text" name="phone" value="<?= htmlspecialchars($row['phone_number']) ?>">
                        </td>
                        <td class="form-row">
                            <input type="text" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                        </td>
                        <td class="form-row">
                            <input type="text" name="opening_time" value="<?= htmlspecialchars($row['opening_time']) ?>">
                        </td>
                        <td class="form-row">
                            <textarea name="location"><?= htmlspecialchars($row['location_url']) ?></textarea>
                        </td>
                        <td class="action-cell">
                            <button type="submit" name="update">Update</button>
                        </td>
                    </form>
        </tr>
    <?php } ?>
</table>

<footer>
    Hotel Wedding Management & Hall Booking System &copy; <?= date('Y') ?>
</footer>

</body>

<?php if (isset($_GET['updated'])): ?>
<script>
    setTimeout(function() {
        window.location.href = "HotelinfoCRUD.php"; // remove the ?updated=1
    }, 3000); // 3 seconds
</script>
<?php endif; ?>

</html>
