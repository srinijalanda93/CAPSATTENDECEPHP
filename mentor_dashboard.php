<?php
include 'db_connect.php';
session_start();

$email = $_SESSION['email'];

// Initialize message variables
$updateMessage = "";
$deleteMessage = "";

// Fetch mentor profile
$sql = "SELECT * FROM mentor WHERE email='$email'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    $mentorName = $row['name'];
    $mentorEmail = $row['email'];
    $mentorPhone = $row['phone_number'];
    $mentorWingId = $row['wing_id'];
    $mentorDateOfJoining = $row['date_of_joining'];

    // Fetch wing name
    $sqlWing = "SELECT wing_name FROM wing WHERE wing_id='$mentorWingId'";
    $resultWing = $conn->query($sqlWing);
    $wingName = $resultWing->fetch_assoc()['wing_name'];
}

// Update attendance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_attendance'])) {
    $volunteer_id = $_POST['volunteer_id'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $sql = "UPDATE attendance SET status='$status' WHERE volunteer_id=$volunteer_id AND date='$date'";
    if ($conn->query($sql) === TRUE) {
        $updateMessage = "Attendance updated successfully!";
    } else {
        $updateMessage = "Error: " . $conn->error;
    }
}

// Delete volunteer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_volunteer'])) {
    $volunteer_id = $_POST['volunteer_id'];

    // First, delete related attendance records
    $sqlDeleteAttendance = "DELETE FROM attendance WHERE volunteer_id=$volunteer_id";
    if ($conn->query($sqlDeleteAttendance) === TRUE) {
        // Then, delete the volunteer record
        $sqlDeleteVolunteer = "DELETE FROM volunteer WHERE volunteer_id=$volunteer_id";
        if ($conn->query($sqlDeleteVolunteer) === TRUE) {
            $deleteMessage = "Volunteer deleted successfully!";
        } else {
            $deleteMessage = "Error: " . $conn->error;
        }
    } else {
        $deleteMessage = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <link rel="stylesheet" href="./css/mentor_dashboard.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch messages from PHP variables
            const updateMessage = "<?php echo addslashes($updateMessage); ?>";
            const deleteMessage = "<?php echo addslashes($deleteMessage); ?>";

            // Display messages
            if (updateMessage) {
                alert(updateMessage);
            }
            if (deleteMessage) {
                alert(deleteMessage);
            }
        });

        function validateAttendanceForm() {
            const volunteerId = document.forms["attendanceForm"]["volunteer_id"].value;
            const status = document.forms["attendanceForm"]["status"].value;
            const date = document.forms["attendanceForm"]["date"].value;

            if (isNaN(volunteerId) || volunteerId <= 0) {
                alert("Please enter a valid volunteer ID.");
                return false;
            }

            if (status === "" || (status !== "Present" && status !== "Absent")) {
                alert("Please enter a valid status (Present or Absent).");
                return false;
            }

            if (new Date(date) > new Date()) {
                alert("Date cannot be in the future.");
                return false;
            }

            return true;
        }

        function validateDeleteForm() {
            const volunteerId = document.forms["deleteForm"]["volunteer_id"].value;

            if (isNaN(volunteerId) || volunteerId <= 0) {
                alert("Please enter a valid volunteer ID.");
                return false;
            }

            return confirm("Are you sure you want to delete this volunteer?");
        }
    </script>
</head>

<body>
    <nav class="headof">
        <div><img src="./css/CHRIST LOGO.png" />
            <h1> Welcome, <?php echo htmlspecialchars($mentorName); ?>!</h1>
        </div>

        <a href="logout.php">Logout</a>
    </nav>
    <section class='BodyTop'>
        <div class="dashboard-container">
            <div class="profile-section">
                <h2>Profile Details</h2>
                <div class="position-info">
                    <h3>Position:</h3>
                    <span>Mentor</span>
                </div>
                <div class="profile-info">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($mentorName); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($mentorEmail); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($mentorPhone); ?></p>
                    <p><strong>Wing:</strong> <?php echo htmlspecialchars($wingName); ?></p>
                    <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($mentorDateOfJoining); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="sep">
        <div class="update-section section">
            <h2>Update Attendance</h2>
            <form name="attendanceForm" method="POST" onsubmit="return validateAttendanceForm()">
                <label for="volunteer_id">Volunteer ID:</label>
                <input type="number" id="volunteer_id" name="volunteer_id" required>

                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <input type="submit" name="update_attendance" value="Update Attendance">
            </form>
        </div>



        <div class="delete-section section">
            <h2>Delete Volunteer</h2>
            <form name="deleteForm" method="POST" onsubmit="return validateDeleteForm()">
                <label for="volunteer_id">Volunteer ID:</label>
                <input type="number" id="volunteer_id" name="volunteer_id" required>
                <input type="submit" name="delete_volunteer" value="Delete Volunteer">
            </form>
        </div>

    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Build By MSC AIML </p>
    </footer>
</body>


</html>