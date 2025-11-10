<?php
session_start();
include 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'], $_POST['csrf_token'])) {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $id = intval($_POST['delete_id']);
        $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        die("Invalid CSRF token");
    }
}

// Get all messages
$result = $conn->query("SELECT * FROM contact_messages");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .action-btn {
            padding: 6px 12px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
            text-decoration: none;
        }
        .delete-btn {
            background: #dc3545;
        }
    </style>
</head>
<body>
    <h2>Contact Messages</h2>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Subject</th><th>Message</th><th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['subject']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="submit" class="action-btn delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
