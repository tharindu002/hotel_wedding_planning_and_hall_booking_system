<?php
session_start();
include 'includes/dbconnection.php';

// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}

// Handle image upload
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = "images/gallery/" . basename($imageName);
    
    if (move_uploaded_file($imageTmp, $imagePath)) {
        $stmt = $conn->prepare("INSERT INTO gallery_table (Pic_Title, Pic_Description, Image_Preview) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $imagePath);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM gallery_table WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = "images/gallery/" . basename($imageName);
        move_uploaded_file($imageTmp, $imagePath);

        $stmt = $conn->prepare("UPDATE gallery_table SET Pic_Title = ?, Pic_Description = ?, Image_Preview = ? WHERE ID = ?");
        $stmt->bind_param("sssi", $title, $description, $imagePath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE gallery_table SET Pic_Title = ?, Pic_Description = ? WHERE ID = ?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .gallery-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        form.inline-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        form.inline-form input[type="text"],
        form.inline-form textarea {
            flex: 1;
        }

        /* Updated Modal Styles */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            padding: 30px;
            box-sizing: border-box;
        }

        .modal-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .modal-content {
            max-width: calc(100% - 60px);
            max-height: calc(100% - 60px);
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(255,255,255,0.3);
            opacity: 0;
            transform: scale(0.7);
            transition: opacity 0.3s, transform 0.3s;
        }

        .modal-content.show {
            opacity: 1;
            transform: scale(1);
        }

        .close-btn {
            position: absolute;
            top: 0;
            right: 0;
            color: red;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1060;
            padding: 10px;
        }
    </style>
</head>
<body class="p-4 bg-light">

    <div class="container">
        <h2 class="mb-4">Add New Picture</h2>
        <form class="inline-form" action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required class="form-control">
            <input type="text" name="description" placeholder="Description" required class="form-control">
            <input type="file" name="image" required class="form-control">
            <button type="submit" name="add" class="btn btn-success">Upload</button>
        </form>

        <hr>

        <h3 class="mb-4">Wedding Gallery</h3>
        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM gallery_table ORDER BY ID DESC");
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="col-md-4 mb-4">
                <div class="card gallery-card">
                    <img 
                        src="<?= htmlspecialchars($row['Image_Preview']) ?>" 
                        data-full="<?= htmlspecialchars($row['Image_Preview']) ?>" 
                        alt="Image" 
                        class="card-img-top" 
                        onclick="showModal(this)">

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['Pic_Title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($row['Pic_Description']) ?></p>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                            <input type="text" name="title" value="<?= htmlspecialchars($row['Pic_Title']) ?>" class="form-control mb-1" required>
                            <input type="text" name="description" value="<?= htmlspecialchars($row['Pic_Description']) ?>" class="form-control mb-1" required>
                            <input type="file" name="image" class="form-control mb-1">
                            <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
                            <a href="?delete=<?= $row['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this image?');">Delete</a>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="custom-modal">
        <span class="close-btn" onclick="hideModal()">&times;</span>
        <div class="modal-container">
            <img class="modal-content" id="modalImage">
        </div>
    </div>

    <script>
    function showModal(imgElement) {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");

        // Use full resolution image if available
        const fullSrc = imgElement.getAttribute("data-full") || imgElement.src;

        modal.style.display = "block";
        modalImg.src = fullSrc;
        
        // Trigger reflow to enable transition
        setTimeout(() => {
            modalImg.classList.add('show');
        }, 10);
    }

    function hideModal() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        
        modalImg.classList.remove('show');
        
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }

    // Close modal if clicked outside the image
    document.getElementById("imageModal").addEventListener('click', function(event) {
        if (event.target.id === "imageModal") {
            hideModal();
        }
    });
    </script>
</body>
</html>