<?php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/session_helper.php';

checkRememberMe($conn);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin authentication
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Delete logic
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM custom_packages WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: customerbookingscrudadminside.php");
    exit;
}

// AJAX search block
if (isset($_POST['ajax']) && $_POST['ajax'] === 'search') {
    $search = $conn->real_escape_string($_POST['query']);
    $sql = "
        SELECT cp.*, u.fullname , u.nic
        FROM custom_packages cp
        LEFT JOIN users u ON cp.user_id = u.id
        WHERE u.fullname LIKE '%$search%' OR u.nic LIKE '%$search%'
        ORDER BY cp.booking_date DESC
    ";
    $result = $conn->query($sql);

    if (!$result) {
        echo "<tr><td colspan='14'>Query failed: " . $conn->error . "</td></tr>";
        exit;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['user_id']}</td>
                <td>" . htmlspecialchars($row['fullname'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['nic'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['package_name']) . "</td>
                <td>" . htmlspecialchars($row['booking_date']) . "</td>
                <td>" . htmlspecialchars($row['venues']) . "</td>
                <td>" . htmlspecialchars($row['guests']) . "</td>
                <td>" . htmlspecialchars($row['meal_type']) . "</td>
                <td>" . htmlspecialchars($row['menu_type']) . "</td>
                <td>" . htmlspecialchars($row['additional_food']) . "</td>
                <td>" . htmlspecialchars($row['decorations']) . "</td>
                <td>" . number_format($row['total_cost']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
                <td>
                    <a class='btn btn-delete' href='?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='14'>No results found.</td></tr>";
    }
    exit;
}

// Default (full) list query
$query = "
    SELECT cp.*, u.fullname , u.nic
    FROM custom_packages cp
    LEFT JOIN users u ON cp.user_id = u.id
    ORDER BY cp.booking_date DESC
";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Custom Bookings (Admin View)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff0f5; font-family: 'Segoe UI', sans-serif; }
        h2 { margin-top: 30px; color: #d63384; text-align: center; font-weight: bold; }
        table { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        thead { background-color: #f8d7da; }
        th { color: #d63384; }
        td, th { vertical-align: middle !important; text-align: center; }
        .btn-delete { background-color: #d63384; color: white; padding: 6px 12px; border: none; border-radius: 8px; transition: 0.3s ease; }
        .btn-delete:hover { background-color: #c2185b; }
        .table-responsive { margin: 30px auto; max-width: 95%; }
        #search { max-width: 400px; margin: 0 auto 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>All Custom Bookings (Admin View)</h2>

    <!-- 🔍 Search Box -->
    <input type="text" id="search" class="form-control" placeholder="Search by Full Name or NIC">

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>NIC Number</th>
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
            <tbody id="bookingTableBody">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['fullname'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['nic'] ?? 'N/A') ?></td>
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
                            <a class="btn btn-delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="14">No bookings found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery (for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#search').on('keyup', function () {
        const query = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'customerbookingscrudadminside.php',
            data: { ajax: 'search', query: query },
            success: function (data) {
                $('#bookingTableBody').html(data);
            }
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
