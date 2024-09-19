<?php
$servername = "localhost"; // or your MySQL host
$username = "root"; // default XAMPP MySQL user
$password = ""; // XAMPP default has no password
$dbname = "caps_christ_attendance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>
