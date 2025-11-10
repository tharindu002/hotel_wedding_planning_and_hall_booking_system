<?php
session_start();
include('includes/dbconnection.php');

// Admin Auth Check
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: Usertable.php");
    exit;
}

// 🔄 AJAX Live Search Response Block
if (isset($_POST['ajax']) && $_POST['ajax'] == 'search') {
    $search = $conn->real_escape_string($_POST['query']);
    $sql = "SELECT * FROM users 
            WHERE fullname LIKE '%$search%' 
               OR email LIKE '%$search%' 
               OR nic LIKE '%$search%' 
            ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['nic']}</td>
                <td>{$row['address']}</td>
                
                <td><code>{$row['password']}</code></td>
                <td>
                    <a href='?delete={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No results found.</td></tr>";
    }
    exit; // 🔚 Stop further HTML output for AJAX
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User List</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff0f5; font-family: 'Segoe UI', sans-serif; }
        .navbar { background-color: #ff69b4 !important; }
        .navbar-brand, .nav-link { color: white !important; }
        .card { border-radius: 1rem; box-shadow: 0 0 30px rgba(255, 105, 180, 0.2); }
        .table thead { background-color: #ff69b4; color: white; }
        .btn-danger { background-color: #ff4d6d; border: none; }
        .btn-danger:hover { background-color: #cc0033; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">User List</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="card p-4">
        <h4 class="mb-4">Registered Users</h4>

        <!-- 🔍 Live Search Field -->
        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Search by name, email or NIC">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC/Passport Number</th>
                        <th>Address</th>
                        
                        <th>Hashed Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <?php
                    $users = $conn->query("SELECT * FROM users ORDER BY id DESC");
                    if ($users->num_rows > 0):
                        while ($row = $users->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['fullname'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['nic'] ?></td>
                        <td><?= $row['address'] ?></td>
                        
                        <td><code><?= $row['password'] ?></code></td>
                        <td>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="8">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
            url: 'Usertable.php',
            method: 'POST',
            data: {
                ajax: 'search',
                query: query
            },
            success: function(data) {
                $('#userTableBody').html(data);
            }
        });
    });
});
</script>

</body>
</html>
