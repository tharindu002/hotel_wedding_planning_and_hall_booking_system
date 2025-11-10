<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root {
  --primary-pink: #ff69b4;
  --secondary-pink: #ff99cc;
  --accent-pink: #ff1493;
  --dark-text: #4a4a4a;
  --light-text: #ffffff;
}

body {
  background: linear-gradient(135deg, #fff5f5 0%, #ffe6f2 100%);
  min-height: 100vh;
}

/* Enhanced Alert Styles */
.alert {
  padding: 1.5rem 2rem;
  margin: 2rem auto;
  border-radius: 15px;
  font-family: 'Poppins', sans-serif;
  font-size: 1.1rem;
  max-width: 800px;
  box-shadow: 0 10px 30px rgba(255,105,180,0.15);
  border: none;
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.alert::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 8px;
  height: 100%;
  background: var(--accent-pink);
}

.alert-success {
  background: linear-gradient(135deg, #e6ffed 0%, #d1ffe1 100%);
  color: var(--dark-text);
}

.alert-danger {
  background: linear-gradient(135deg, #ffe6e6 0%, #ffd9d9 100%);
  color: var(--dark-text);
}

.alert i {
  margin-right: 15px;
  font-size: 1.5rem;
}

/* Custom Button Styles */
.btn-pink {
  background: var(--primary-pink);
  color: var(--light-text);
  padding: 12px 30px;
  border-radius: 25px;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  box-shadow: 0 5px 15px rgba(255,105,180,0.3);
}

.btn-pink:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255,105,180,0.4);
  background: var(--accent-pink);
  color: var(--light-text);
}

/* Outline Button Style */
.btn-outline-pink {
  border: 2px solid var(--primary-pink);
  color: var(--primary-pink);
  padding: 12px 30px;
  border-radius: 25px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-outline-pink:hover {
  background: var(--primary-pink);
  color: var(--light-text);
  box-shadow: 0 5px 15px rgba(255,105,180,0.3);
}

/* Button Group Spacing */
.d-grid.gap-3 {
  gap: 1.5rem !important;
  max-width: 400px;
  margin: 0 auto;
}

/* Icon Alignment */
.fa-edit, .fa-home {
  font-size: 1.1rem;
  vertical-align: middle;
}

/* Responsive Design */
@media (max-width: 768px) {
  .alert {
    font-size: 1rem;
    padding: 1.2rem;
    margin: 1.5rem 10px;
  }
  
  .btn-pink {
    width: 100%;
    margin: 10px 0;
  }
}

/* Animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.alert {
  animation: fadeIn 0.6s ease-out;
}

/* Neomorphic Container */
.container-neo {
  background: #fff;
  border-radius: 20px;
  box-shadow: 20px 20px 60px #d9d9d9,
             -20px -20px 60px #ffffff;
  padding: 2rem;
  margin: 2rem auto;
  max-width: 800px;
  transition: transform 0.3s ease;
}

.container-neo:hover {
  transform: translateY(-5px);
}
</style>

<title>Executing Booking</title>

<?php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/session_helper.php';

checkRememberMe($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['form_type']) && $_POST['form_type'] === "venue-form" && isset($_POST['Package_Name'], $_POST['Booking_Date'], $_POST['venues'], $_POST['Number_of_g'], $_POST['Mealtype'], $_POST['menu-type'], $_POST['additional_food'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "You must be logged in to submit this form.";
        exit;
    }

    $User_id = htmlspecialchars($_SESSION['user_id']);
    $Package_Name = htmlspecialchars($_POST['Package_Name']);
    $Booking_Date = htmlspecialchars($_POST['Booking_Date']);
    $Number_of_g = htmlspecialchars($_POST['Number_of_g']);
    $Venues = array_map('htmlspecialchars', $_POST['venues']);
    $Mealtype = htmlspecialchars($_POST['Mealtype']);
    $Menu_selection = htmlspecialchars($_POST['menu-type']);
    $additional_food = array_map('htmlspecialchars', $_POST['additional_food']);
    $Decorations = isset($_POST['Decorations']) ? array_map('htmlspecialchars', $_POST['Decorations']) : array();
    $Total_Cost = isset($_POST['Total_Cost']) ? htmlspecialchars($_POST['Total_Cost']) : '0';

    // Check for duplicate venues on the selected date (MySQLi version)
foreach ($Venues as $venue) {
    // Prepare statement
    $stmt = $conn->prepare("SELECT id FROM custom_packages WHERE Booking_Date = ? AND FIND_IN_SET(?, venues) > 0");
    
    // Bind parameters (දත්ත ආරක්ෂිතව bind කිරීම)
    $stmt->bind_param("ss", $Booking_Date, $venue); 
    
    // Execute and check
    $stmt->execute();
    $stmt->store_result(); // Result store කිරීම අත්‍යවශ්‍යයි!
    
    if ($stmt->num_rows > 0) { // num_rows භාවිතා කරන්න
        echo "<div class='container-neo text-center'>";
        echo "<div class='alert alert-danger'><i class='fas fa-exclamation-triangle'></i> '";
        echo "<div class='alert alert-danger'>'" . htmlspecialchars($venue) . "' venue/venues has already been booked on $Booking_Date Please choose another day or another venue</div>";
        echo "<a href='index.php#packages' class='btn btn-pink'><i class='fas fa-edit me-2'></i>Edit your Booking</a>";
        exit;
    }
    
    $stmt->close(); // Statement close කිරීම
}

    // Prepare data for insertion (venues stored without spaces)
    $VenuesList = implode(",", $Venues);
    $Additional_foodList = implode(", ", $additional_food);
    $DecorationsList = implode(", ", $Decorations);

    // Save to database
    try {
        $sql = "INSERT INTO custom_packages (user_id, package_name, booking_date, venues, guests, meal_type, menu_type, additional_food, decorations, total_cost, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $User_id, 
            $Package_Name, 
            $Booking_Date, 
            $VenuesList, 
            $Number_of_g, 
            $Mealtype, 
            $Menu_selection, 
            $Additional_foodList, 
            $DecorationsList, 
            $Total_Cost
        ]);
        
        echo "<div class='container-neo text-center'>";
        echo "<div class='alert alert-danger'><i class='fa-regular fa-circle-check'></i>";
        echo "<div class='alert alert-success'>Your custom package has been successfully submitted! We will contact you shortly.</div>";
        echo "<a href='index.php' class='btn btn-pink'><i class='fas fa-home me-2'></i>Back to Home</a>";
        
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>There was an error saving your custom package. Please try again later.</div>";
    }

} else {
    echo "Missing data or form not submitted correctly.";
}
?>