<?php
session_start();
include 'includes/dbconnection.php';
// Protect this page (admin only)
if (!isset($_SESSION['adminlogged_in']) || $_SESSION['adminlogged_in'] !== true) {
    header("Location: adminlogin.php");
    exit;
}
// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $new_price = $_POST['price'];
    $stmt = $conn->prepare("UPDATE ru_table SET price = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_price, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ru_table.php");
    exit();
}
// Fetch data
$sql = "SELECT * FROM ru_table";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RU Table</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-pink: #ff66b2;
            --secondary-pink: #ff99cc;
            --light-pink: #ffcce6;
            --dark-pink: #cc0066;
            --background-pink: #fff0f7;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-pink);
            padding-top: 2rem;
        }
        
        /* Responsive Table Styles */
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 20px rgba(255, 102, 178, 0.15);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary-pink);
            color: white;
            font-weight: 600;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.2rem;
        }
        
        .table {
            margin-bottom: 0;
            color: #666;
        }
        
        .table thead th {
            border-bottom: 2px solid var(--secondary-pink);
            background-color: var(--light-pink);
            color: var(--dark-pink);
            font-weight: 600;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(255, 204, 230, 0.3);
        }
        
        .btn-update {
            background-color: var(--primary-pink);
            border: none;
            color: white;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .btn-update:hover {
            background-color: var(--dark-pink);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 102, 178, 0.3);
        }
        
        .form-control {
            border-radius: 25px;
            border: 1px solid var(--secondary-pink);
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.25rem rgba(255, 102, 178, 0.25);
        }
        
        .page-title {
            color: var(--dark-pink);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
        }
        
        .back-link {
            color: var(--dark-pink);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            color: var(--primary-pink);
        }
        
        /* Mobile Card View */
        .mobile-card-view {
            display: none;
        }
        
        .mobile-pricing-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            padding: 15px;
        }
        
        .mobile-pricing-card .info-label {
            font-weight: 600;
            color: var(--dark-pink);
            margin-bottom: 10px;
        }
        
        .mobile-pricing-card .price-input-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .mobile-pricing-card .input-group-text {
            background-color: var(--light-pink);
            border: 1px solid var(--secondary-pink);
            color: var(--dark-pink);
        }
        
        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .desktop-table-view {
                display: none;
            }
            
            .mobile-card-view {
                display: block;
            }
        }
        
        @media (min-width: 769px) {
            .desktop-table-view {
                display: table;
            }
            
            .mobile-card-view {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="page-title"><i class="fas fa-table me-2"></i>RU Price Table</h1>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-dollar-sign me-2"></i>Pricing Information</span>
                        <a href="admin_dashboard.php" class="back-link"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="desktop-table-view table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Information</th>
                                    <th>Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Reset the result pointer
                                $result->data_seek(0);
                                while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <form method="POST" action="ru_table.php">
                                            <td><?php echo htmlspecialchars($row['information']); ?></td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="fas fa-rupee-sign"></i></span>
                                                    <input type="number" class="form-control" name="price" value="<?php echo $row['price']; ?>" required>
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="submit" name="update" class="btn btn-update">
                                                    <i class="fas fa-edit me-1"></i> Update
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Card View -->
                    <div class="mobile-card-view p-3">
                        <?php 
                        // Reset the result pointer again
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()): ?>
                            <div class="mobile-pricing-card">
                                <div class="info-label"><?php echo htmlspecialchars($row['information']); ?></div>
                                <form method="POST" action="ru_table.php">
                                    <div class="price-input-group">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                            <input type="number" class="form-control" name="price" value="<?php echo $row['price']; ?>" required>
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        </div>
                                        <button type="submit" name="update" class="btn btn-update mt-2 w-100">
                                            <i class="fas fa-edit me-1"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>