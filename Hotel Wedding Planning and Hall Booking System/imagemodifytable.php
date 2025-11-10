<?php
session_start();
include 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Handle New Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_new'])) {
    $title = $_POST['title'];
    $info = $_POST['info'];
    $imagePath = "";

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "images/";
        $filename = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    if ($imagePath !== "") {
        $stmt = $conn->prepare("INSERT INTO picedit (title, info, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $info, $imagePath);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: imagemodifytable.php");
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $info = $_POST['info'];
    $imagePath = "";

    if (!empty($_FILES['new_image']['name'])) {
        $targetDir = "images/";
        $filename = basename($_FILES["new_image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $filename;

        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    if ($imagePath !== "") {
        $stmt = $conn->prepare("UPDATE picedit SET title = ?, info = ?, image_path = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $info, $imagePath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE picedit SET title = ?, info = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $info, $id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: imagemodifytable.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #e91e63;
            --primary-light: #f48fb1;
            --primary-dark: #c2185b;
            --accent-color: #ff80ab;
        }
        
        body {
            background-color: #fce4ec;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 20px;
            padding-bottom: 40px;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-dark) !important;
        }
        
        .container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
        }
        
        h2 {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 10px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .form-label {
            font-weight: 500;
            color: #333;
        }
        
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(233, 30, 99, 0.25);
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .table thead {
            background-color: var(--primary-color);
            color: white;
        }
        
        .table-hover tbody tr:hover {
            background-color: #fce4ec;
        }
        
        .img-thumbnail {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }
        
        .custom-file-button input[type="file"] {
            position: relative;
            opacity: 1;
        }
        
        .custom-file-button input[type="file"]::file-selector-button {
            background-color: var(--primary-light);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .custom-file-button input[type="file"]::file-selector-button:hover {
            background-color: var(--primary-color);
        }
        
        .divider {
            height: 3px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 2rem 0;
        }
        
        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        footer {
            background-color: var(--primary-dark);
            color: white;
            padding: 15px 0;
            text-align: center;
            border-radius: 0 0 15px 15px;
            margin-top: 20px;
        }
        
        /* Image Preview Modal Styles */
                .image-preview-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.9);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
            margin: auto;
            display: block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            cursor: default;
            animation: zoom 0.6s;
        }
        
        .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
            z-index: 1001;
            background-color: rgba(233, 30, 99, 0.7);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 0;
        }
        
        .close-btn:hover {
            background-color: rgba(194, 24, 91, 0.9);
        }
        
        .preview-caption {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            color: #ccc;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            font-size: 18px;
        }
        
        /* Animation */
        @keyframes zoom {
            from {transform: scale(0.5); opacity: 0;}
            to {transform: scale(1); opacity: 1;}
        }
        
        .modal-content, .preview-caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        
        .img-thumbnail {
            cursor: pointer;
            transition: opacity 0.3s;
        }
        
        .img-thumbnail:hover {
            opacity: 0.8;
        }

        
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-images me-2"></i>Image Gallery Manager
        </a>
    </div>
</nav>

<div class="container">
    <h2><i class="fas fa-plus-circle me-2"></i>Add New Image</h2>
    
    <form action="imagemodifytable.php" method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="col-md-6">
            <label for="info" class="form-label">Information</label>
            <input type="text" class="form-control" id="info" name="info">
        </div>
        
        <div class="col-12">
            <label for="image" class="form-label">Choose Image</label>
            <div class="custom-file-button">
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
        </div>
        
        <div class="col-12 mt-3">
            <button type="submit" name="submit_new" class="btn btn-primary">
                <i class="fas fa-upload me-1"></i> Upload
            </button>
        </div>
    </form>
</div>

<div class="divider"></div>

<div class="container">
    <h2><i class="fas fa-table me-2"></i>Image Gallery</h2>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Information</th>
                    <th>Preview</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM picedit";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <form action='imagemodifytable.php' method='POST' enctype='multipart/form-data'>
                            <td>
                                <input type='text' class='form-control' name='title' value='" . htmlspecialchars($row['title']) . "'>
                            </td>
                            <td>
                                <input type='text' class='form-control' name='info' value='" . htmlspecialchars($row['info']) . "'>
                            </td>
                            <td>
                                <img src='" . htmlspecialchars($row['image_path']) . "' class='img-thumbnail mb-2 preview-image' onclick=\"showPreview('" . htmlspecialchars($row['image_path']) . "', '" . htmlspecialchars($row['title']) . "')\">
                                <div class='custom-file-button'>
                                    <input type='file' class='form-control form-control-sm' name='new_image'>
                                </div>
                            </td>
                            <td>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='submit_update' class='btn btn-primary btn-sm'>
                                    <i class='fas fa-save me-1'></i> Update
                                </button>
                            </td>
                        </form>
                    </tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>



<footer class="container">
    <p class="mb-0">&copy; <?php echo date('Y'); ?> Image Gallery Manager</p>
</footer>

<!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="image-preview-modal">
        <span class="close-btn">&times;</span>
        <img class="modal-content" id="previewImage">
        <div id="previewCaption" class="preview-caption"></div>
    </div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Get the modal
        const modal = document.getElementById("imagePreviewModal");
        const modalImg = document.getElementById("previewImage");
        const captionText = document.getElementById("previewCaption");
        const closeBtn = document.getElementsByClassName("close-btn")[0];

        // Function to show the preview modal
        function showPreview(imgSrc, imgTitle) {
            modal.style.display = "flex";
            modalImg.src = imgSrc;
            captionText.innerHTML = imgTitle;
        }

        // Close the modal when the × is clicked
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside the image
        modal.onclick = function(event) {
            if (event.target === modal || event.target === captionText) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>