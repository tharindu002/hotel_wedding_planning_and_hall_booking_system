<?php
session_start();
include("includes/dbconnection.php");

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Fetch feedbacks
$sql = "SELECT id, name, email, rating, message, created_at FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);

// // Handle Delete
// if (isset($_GET['delete'])) {
//     $id = intval($_GET['delete']);
//     $conn->query("DELETE FROM feedbacks WHERE id = $id");
//     header("Location: http://localhost/Myfileshere(4)/Hotel%20V9/feedbacks_table.php");
//     exit();
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedbacks Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        thead {
            background-color: #007BFF;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9f5ff;
        }

        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            td {
                position: relative;
                padding-left: 50%;
                border-bottom: 1px solid #ddd;
            }

            td::before {
                position: absolute;
                top: 12px;
                left: 15px;
                width: 45%;
                white-space: nowrap;
                font-weight: bold;
                color: #555;
            }

            td:nth-of-type(1)::before { content: "ID"; }
            td:nth-of-type(2)::before { content: "Name"; }
            td:nth-of-type(3)::before { content: "Email"; }
            td:nth-of-type(4)::before { content: "Rating"; }
            td:nth-of-type(5)::before { content: "Message"; }
            td:nth-of-type(6)::before { content: "Created At"; }
        }
    </style>
</head>
<body>

<h2>Feedbacks</h2>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <!-- <th>Name</th>
                <th>Email</th> -->
                <th>Rating</th>
                <th>Message</th>
                <th>Created At</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <!--<td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td> -->
                        <td><?= htmlspecialchars($row['rating']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <!-- <td>
                    <a href="?delete=<?= $row['id'] ?>" class="action-btn delete-btn">Delete</a>
                </td> -->
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No feedbacks found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
