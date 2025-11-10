<?php
session_start();
require_once 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $hall_name = $_POST['hall_name'];
        $youtube_url = $_POST['youtube_url'];

        // Check if hall already has a video
        $check = $conn->prepare("SELECT id FROM virtual_tours WHERE hall_name = ?");
        $check->bind_param("s", $hall_name);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "This hall already has a video. You can only update or delete it."]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO virtual_tours (hall_name, youtube_url) VALUES (?, ?)");
        $stmt->bind_param("ss", $hall_name, $youtube_url);
        $stmt->execute();

        echo json_encode(["status" => "success"]);

    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $youtube_url = $_POST['youtube_url'];

        $stmt = $conn->prepare("UPDATE virtual_tours SET youtube_url = ? WHERE id = ?");
        $stmt->bind_param("si", $youtube_url, $id);
        $stmt->execute();

        echo json_encode(["status" => "success"]);

    } elseif ($action === 'delete') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM virtual_tours WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["status" => "success"]);

    } elseif ($action === 'fetch') {
        $result = $conn->query("SELECT * FROM virtual_tours");
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virtual Tour CRUD</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">Virtual Tour Video Manager</h2>

    <form id="addForm" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="hall_name" class="form-label">Hall Name</label>
                <select class="form-select" id="hall_name" name="hall_name" required>
                    <option value="">Select a Hall</option>
                    <option value="grand-ballroom">Grand Ballroom</option>
                    <option value="royal-garden">Royal Garden</option>
                    <option value="ocean-view">Ocean View Terrace</option>
                </select>
            </div>
            <div class="col-md-5">
                <label for="youtube_url" class="form-label">YouTube Video URL</label>
                <input type="url" class="form-control" id="youtube_url" name="youtube_url" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Add Video</button>
            </div>
        </div>
    </form>

    <div id="message"></div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Hall Name</th>
            <th>YouTube URL</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="videoTable"></tbody>
    </table>
</div>

<script>
function loadVideos() {
    $.post('virtual_tour_crud.php', {action: 'fetch'}, function(data) {
        const videos = JSON.parse(data);
        let usedHalls = [];
        $('#videoTable').empty();

        videos.forEach(video => {
            usedHalls.push(video.hall_name);
            $('#videoTable').append(`
                <tr>
                    <td>${video.id}</td>
                    <td>${video.hall_name}</td>
                    <td><a href="${video.youtube_url}" target="_blank">${video.youtube_url}</a></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editVideo(${video.id}, '${video.youtube_url}')">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteVideo(${video.id})">Delete</button>
                    </td>
                </tr>
            `);
        });

        // Disable used hall names in dropdown
        $('#hall_name option').prop('disabled', false);
        usedHalls.forEach(hall => {
            $(`#hall_name option[value='${hall}']`).prop('disabled', true);
        });
    });
}

$('#addForm').on('submit', function(e) {
    e.preventDefault();
    $.post('virtual_tour_crud.php', $(this).serialize() + '&action=add', function(res) {
        const result = JSON.parse(res);
        $('#message').html(`<div class="alert alert-${result.status === 'success' ? 'success' : 'danger'}">${result.message || result.status}</div>`);
        if (result.status === 'success') {
            $('#addForm')[0].reset();
            loadVideos();
        }
    });
});

function editVideo(id, currentUrl) {
    const newUrl = prompt("Enter new YouTube URL", currentUrl);
    if (newUrl) {
        $.post('virtual_tour_crud.php', {action: 'edit', id, youtube_url: newUrl}, function(res) {
            loadVideos();
        });
    }
}

function deleteVideo(id) {
    if (confirm("Are you sure you want to delete this video?")) {
        $.post('virtual_tour_crud.php', {action: 'delete', id}, function(res) {
            loadVideos();
        });
    }
}

$(document).ready(() => loadVideos());
</script>
</body>
</html>
