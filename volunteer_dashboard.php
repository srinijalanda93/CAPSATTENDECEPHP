<?php
include 'db_connect.php';
session_start();

$email = $_SESSION['email'];

// Fetch volunteer profile
$sql = "SELECT * FROM volunteer WHERE email='$email'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    echo "Volunteer Profile:<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Phone: " . $row['phone_number'] . "<br>";
    echo "Date of Joining: " . $row['date_of_joining'] . "<br><br>";
}

// Count the number of days present
$sql = "SELECT COUNT(*) as present_days FROM attendance WHERE volunteer_id=" . $row['volunteer_id'] . " AND status='Present'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    echo "Days Present: " . $row['present_days'];
}
?>
