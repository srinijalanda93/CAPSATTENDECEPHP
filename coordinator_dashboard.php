<?php
include 'db_connect.php';
session_start();

$email = $_SESSION['email'];

// Fetch coordinator profile
$sql = "SELECT * FROM coordinator WHERE email='$email'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    echo "Coordinator Profile:<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Phone: " . $row['phone_number'] . "<br>";
    echo "Date of Joining: " . $row['date_of_joining'] . "<br><br>";
}

// Fetch mentor details
echo "Mentor Details:<br>";
$sql = "SELECT name, email, date_of_joining FROM mentor";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Date of Joining: " . $row['date_of_joining'] . "<br><br>";
}

// Fetch team leader details
echo "Team Leader Details:<br>";
$sql = "SELECT name, email, date_of_joining FROM team_leader";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Date of Joining: " . $row['date_of_joining'] . "<br><br>";
}
?>
