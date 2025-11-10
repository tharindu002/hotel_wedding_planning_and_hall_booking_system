<?php
require_once 'includes/dbconnection.php';
require_once 'includes/session_helper.php';

checkRememberMe($conn);

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit;
}

$User_id = $_SESSION['user_id'];

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM custom_packages WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $User_id);
    $stmt->execute();
    header("Location: customerbookingscrud.php");
    header("Location: index.php#packages");
    exit;
}

// Fetch user-specific bookings
$stmt = $conn->prepare("SELECT * FROM custom_packages WHERE user_id = ?");
$stmt->bind_param("i", $User_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS with pinky theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #fff0f5;
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            margin-top: 30px;
            color: #d63384;
            text-align: center;
            font-weight: bold;
        }

        table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        thead {
            background-color: #f8d7da;
        }

        th {
            color: #d63384;
        }

        td, th {
            vertical-align: middle !important;
            text-align: center;
        }

        .btn-delete {
            background-color: #d63384;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c2185b;
        }

        .table-responsive {
            margin: 30px auto;
            max-width: 95%;
        }

        p {
            text-align: center;
            color: #555;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>My Custom Bookings</h2>

        <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Venues</th>
                        <th>Guests</th>
                        <th>Meal</th>
                        <th>Menu</th>
                        <th>Extras</th>
                        <th>Decor</th>
                        <th>Total (Rs.)</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['package_name']) ?></td>
                            <td><?= htmlspecialchars($row['booking_date']) ?></td>
                            <td><?= htmlspecialchars($row['venues']) ?></td>
                            <td><?= htmlspecialchars($row['guests']) ?></td>
                            <td><?= htmlspecialchars($row['meal_type']) ?></td>
                            <td><?= htmlspecialchars($row['menu_type']) ?></td>
                            <td><?= htmlspecialchars($row['additional_food']) ?></td>
                            <td><?= htmlspecialchars($row['decorations']) ?></td>
                            <td><?= number_format($row['total_cost']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <a class="btn btn-delete" href="customerbookingscrud.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete and recreate this booking?')">
                                    Delete & ReCreate
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>You haven't made any bookings yet.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
