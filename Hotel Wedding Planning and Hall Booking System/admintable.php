<?php
session_start();
require_once 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Fetch all admins
$admins = $conn->query("SELECT * FROM admins");

// Add new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // ⚠️ Plain text
    $conn->query("INSERT INTO admins (username, password) VALUES ('$username', '$password')");
    header("Location: admintable.php");
    exit;
}

// Update admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {
    $id = $_POST['admin_id'];
    $username = $_POST['username'];
    $password = $_POST['password']; // ⚠️ Plain text
    $conn->query("UPDATE admins SET username='$username', password='$password' WHERE id=$id");
    header("Location: admintable.php");
    exit;
}

// Delete admin
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM admins WHERE id=$id");
    header("Location: admintable.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Admin Accounts</h2>

    <!-- Create Admin -->
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-md-4">
            <button type="submit" name="add_admin" class="btn btn-primary w-100">Add Admin</button>
        </div>
    </form>

    <!-- Admin Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Username</th><th>Password</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($admin = $admins->fetch_assoc()): ?>
                <tr>
                    <td><?= $admin['id'] ?></td>
                    <td><?= htmlspecialchars($admin['username']) ?></td>
                    <td><?= htmlspecialchars($admin['password']) ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-id="<?= $admin['id'] ?>" 
                            data-username="<?= $admin['username'] ?>"
                            data-password="<?= $admin['password'] ?>">
                            Edit
                        </button>
                        <a href="?delete=<?= $admin['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <input type="hidden" name="admin_id" id="editAdminId">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" type="button"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" id="editUsername" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="text" class="form-control" name="password" id="editPassword" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="update_admin" class="btn btn-success">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const username = button.getAttribute('data-username');
        const password = button.getAttribute('data-password');

        document.getElementById('editAdminId').value = id;
        document.getElementById('editUsername').value = username;
        document.getElementById('editPassword').value = password;
    });
</script>
</body>
</html>
