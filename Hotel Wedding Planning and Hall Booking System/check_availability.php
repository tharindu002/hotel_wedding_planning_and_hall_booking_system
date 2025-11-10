<?php
// Connect to DB
include 'includes/dbconnection.php';

// Sanitize input
$hall_id = isset($_GET['hall_id']) ? (int) $_GET['hall_id'] : 0;
$month   = isset($_GET['month']) ? (int) $_GET['month'] : -1;
$year    = isset($_GET['year']) ? (int) $_GET['year'] : 0;

// Validate month range
if ($month < 0 || $month > 11 || $year < 2020 || $hall_id < 1 || $hall_id > 3) {
    echo json_encode([]);
    exit;
}

// Map hall ID to venue name
$hallNames = [
    1 => 'grand-ballroom',
    2 => 'royal-garden',
    3 => 'ocean-view-terrace'
];
$hallName = $hallNames[$hall_id] ?? '';

// Format date range
$monthPadded = str_pad($month + 1, 2, "0", STR_PAD_LEFT); // JS month is 0-indexed
$start_date = "$year-$monthPadded-01";
$end_date = date("Y-m-t", strtotime($start_date));

// SQL to check bookings where venues like hall name
$sql = "SELECT booking_date FROM custom_packages 
        WHERE booking_date BETWEEN ? AND ? 
        AND venues LIKE ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode([]);
    exit;
}

$like_param = "%$hallName%";
$stmt->bind_param("sss", $start_date, $end_date, $like_param);
$stmt->execute();
$result = $stmt->get_result();

// Build array of booked day numbers (e.g., 1, 5, 20)
$bookedDates = [];
while ($row = $result->fetch_assoc()) {
    $bookedDates[] = (int) date('j', strtotime($row['booking_date']));
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($bookedDates);
?>
