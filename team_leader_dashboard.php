<?php
include 'db_connect.php';
session_start();

$email = $_SESSION['email'];

// Fetch team leader profile
$sql = "SELECT * FROM team_leader WHERE email='$email'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    echo "Team Leader Profile:<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Phone: " . $row['phone_number'] . "<br>";
    echo "Date of Joining: " . $row['date_of_joining'] . "<br><br>";
}

// Adding new volunteer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_volunteer'])) {
    $name = $_POST['name'];
    $volunteer_email = $_POST['volunteer_email'];
    $phone = $_POST['phone'];
    $date_of_joining = $_POST['date_of_joining'];

    $sql = "INSERT INTO volunteer (name, email, phone_number, team_leader_id, date_of_joining)
            VALUES ('$name', '$volunteer_email', '$phone', (SELECT team_leader_id FROM team_leader WHERE email='$email'), '$date_of_joining')";
    if ($conn->query($sql) === TRUE) {
        echo "Volunteer added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Form to add new volunteer
?>
<form method="POST">
    <input type="text" name="name" placeholder="Volunteer Name" required><br>
    <input type="email" name="volunteer_email" placeholder="Volunteer Email" required><br>
    <input type="text" name="phone" placeholder="Volunteer Phone" required><br>
    <input type="date" name="date_of_joining" required><br>
    <input type="submit" name="add_volunteer" value="Add Volunteer">
</form>
