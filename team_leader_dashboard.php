<?php
include 'db_connect.php';
session_start();


$email = $_SESSION['email'];

// Fetch team leader profile and wing name
$sql = "SELECT team_leader.name AS team_leader_name, team_leader.email, team_leader.phone_number, team_leader.date_of_joining, wing.wing_name 
        FROM team_leader 
        JOIN wing ON team_leader.wing_id = wing.wing_id 
        WHERE team_leader.email = '$email'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    $teamLeaderName = $row['team_leader_name'];
    $teamLeaderEmail = $row['email'];
    $teamLeaderPhone = $row['phone_number'];
    $teamLeaderDateOfJoining = $row['date_of_joining'];
    $wingName = $row['wing_name'];
} else {
    echo "Team leader not found!";
}

// Adding new volunteer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_volunteer'])) {
    $volunteer_id = $_POST['volunteer_id'];
    $name = $_POST['name'];
    $volunteer_email = $_POST['volunteer_email'];
    $phone = $_POST['phone'];
    $date_of_joining = $_POST['date_of_joining'];

    $sql = "INSERT INTO volunteer (volunteer_id, name, email, phone_number, team_leader_id, date_of_joining)
            VALUES ('$volunteer_id', '$name', '$volunteer_email', '$phone', 
            (SELECT team_leader_id FROM team_leader WHERE email='$email'), '$date_of_joining')";
    if ($conn->query($sql) === TRUE) {
        $addVolunteerMessage = "Volunteer added successfully!";
    } else {
        $addVolunteerMessage = "Error: " . $conn->error;
    }
}

// Marking attendance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_attendance'])) {
    $volunteer_id = $_POST['volunteer_id'];
    $attendance_status = $_POST['attendance_status'];
    $date = date('Y-m-d'); // Current date

    $sql = "INSERT INTO attendance (volunteer_id, status, date)
            VALUES ('$volunteer_id', '$attendance_status', '$date')
            ON DUPLICATE KEY UPDATE status='$attendance_status'";

    if ($conn->query($sql) === TRUE) {
        $attendanceMessage = "Attendance marked successfully!";
    } else {
        $attendanceMessage = "Error: " . $conn->error;
    }
}


// Fetch all volunteers under the team leader
$volunteerSql = "SELECT * FROM volunteer WHERE team_leader_id = (SELECT team_leader_id FROM team_leader WHERE email='$email')";
$volunteerResult = $conn->query($volunteerSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Leader Dashboard</title>
    <link rel="stylesheet" href="css/team_leader_dashboard.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addVolunteerMessage = "<?php echo isset($addVolunteerMessage) ? addslashes($addVolunteerMessage) : ''; ?>";
            if (addVolunteerMessage) {
                alert(addVolunteerMessage);
            }

            const attendanceMessage = "<?php echo isset($attendanceMessage) ? addslashes($attendanceMessage) : ''; ?>";
            if (attendanceMessage) {
                alert(attendanceMessage);
            }
        });
    </script>
</head>

<body>
    <nav id='head'>
        <div><img src="./css/CHRIST LOGO.png" />
            <h1> Welcome, <?php echo htmlspecialchars($teamLeaderName); ?>!</h1>
        </div>

        <a href="logout.php">Logout</a>
    </nav>

    <section class='BodyTop'>
        <section class="dashboard-container">
            <div id="left">
                <div id="profile-section">
                    <h2>Profile Details</h2>
                    <div class="position-info">
                        <h3>Position:</h3>
                        <span>Team Leader</span>
                    </div>
                    <div class="profile-info">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($teamLeaderName); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($teamLeaderEmail); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($teamLeaderPhone); ?></p>
                        <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($teamLeaderDateOfJoining); ?></p>
                        <p><strong>Wing Name:</strong> <?php echo htmlspecialchars($wingName); ?></p>
                    </div>
                </div>
            </div>
            <div id="right">
                <img src="./css/CHRIST LOGO.png" alt="logo">
            </div>
        </section>

        <div class="section-container">
            <h2>Add New Volunteer</h2>
            <form name="volunteerForm" method="POST">
                <label for="volunteer_id">Volunteer ID:</label>
                <input type="number" id="volunteer_id" name="volunteer_id" required>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="volunteer_email">Email:</label>
                <input type="email" id="volunteer_email" name="volunteer_email" required>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
                <label for="date_of_joining">Date of Joining:</label>
                <input type="date" id="date_of_joining" name="date_of_joining" required>
                <input type="submit" name="add_volunteer" value="Add Volunteer">
            </form>
        </div>

        <div class="section-container">
            <h2>Delete Volunteer</h2>
            <form method="POST">
                <label for="volunteer_id_delete">Select Volunteer to Delete:</label>
                <select id="volunteer_id_delete" name="volunteer_id_delete" required>
                    <!-- Populate this select with volunteers -->
                    <?php while ($volunteerRow = $volunteerResult->fetch_assoc()): ?>
                        <option value="<?php echo $volunteerRow['volunteer_id']; ?>">
                            <?php echo $volunteerRow['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="submit" name="delete_volunteer" value="Delete Volunteer">
            </form>
        </div>

        <div class="section-container">
            <h2>Take Attendance</h2>
            <?php if ($volunteerResult->num_rows > 0): ?>
                <form method="POST">
                    <label for="volunteer_id">Select Volunteer:</label>
                    <select id="volunteer_id" name="volunteer_id" required>
                        <?php while ($volunteerRow = $volunteerResult->fetch_assoc()): ?>
                            <option value="<?php echo $volunteerRow['volunteer_id']; ?>">
                                <?php echo $volunteerRow['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <label for="attendance_status">Attendance:</label>
                    <select id="attendance_status" name="attendance_status" required>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                    </select>
                    <input type="submit" name="mark_attendance" value="Mark Attendance">
                </form>
            <?php else: ?>
                <p>No volunteers found. Please add a volunteer first.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Build By MSC AIML </p>
    </footer>


</body>

</html>