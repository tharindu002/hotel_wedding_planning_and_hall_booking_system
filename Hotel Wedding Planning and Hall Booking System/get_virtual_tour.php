<?php
include 'includes/dbconnection.php';

if (isset($_GET['hall'])) {
    $hall = $_GET['hall'];

    $stmt = $conn->prepare("SELECT youtube_url FROM virtual_tours WHERE hall_name = ?");
    $stmt->bind_param("s", $hall);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['url' => $row['youtube_url']]);
    } else {
        echo json_encode(['url' => '']);
    }
}
?>
