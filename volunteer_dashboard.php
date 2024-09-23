<?php
include 'db_connect.php';
session_start();

$email = $_SESSION['email'];

// Fetch volunteer profile along with wing, mentor, and team leader details
$sql = "
    SELECT v.volunteer_id, v.name AS volunteer_name, v.email, v.phone_number, v.date_of_joining, 
           w.wing_name, m.name AS mentor_name, tl.team_leader_id, tl.name AS team_leader_name
    FROM volunteer v
    JOIN team_leader tl ON v.team_leader_id = tl.team_leader_id
    JOIN mentor m ON tl.mentor_id = m.mentor_id
    JOIN wing w ON m.wing_id = w.wing_id
    WHERE v.email = '$email'
";
$result = $conn->query($sql);

$teamLeaderNames = [];

if ($row = $result->fetch_assoc()) {
    $volunteer_id = $row['volunteer_id'];
    // Store team leader name
    $teamLeaderNames[] = $row['team_leader_name'];
}

// Fetch all unique team leaders for the same wing
$sql_team_leaders = "
    SELECT DISTINCT tl.name AS team_leader_name 
    FROM team_leader tl
    JOIN mentor m ON tl.mentor_id = m.mentor_id
    JOIN wing w ON m.wing_id = w.wing_id
    WHERE w.wing_id = (SELECT wing_id FROM mentor WHERE mentor_id = (SELECT mentor_id FROM team_leader WHERE team_leader_id = (SELECT team_leader_id FROM volunteer WHERE email='$email')))
";
$result_team_leaders = $conn->query($sql_team_leaders);

while ($team_leader_row = $result_team_leaders->fetch_assoc()) {
    if (!in_array($team_leader_row['team_leader_name'], $teamLeaderNames)) {
        $teamLeaderNames[] = $team_leader_row['team_leader_name'];
    }
}

// Count the number of days present for the volunteer
$sql_attendance = "SELECT COUNT(*) as present_days FROM attendance WHERE volunteer_id=$volunteer_id AND status='Present'";
$result_attendance = $conn->query($sql_attendance);
$attendance_row = $result_attendance->fetch_assoc();
$presentDays = $attendance_row['present_days'];

// Fetch total attendance records to calculate percentage
$sql_total_attendance = "SELECT COUNT(*) as total_days FROM attendance WHERE volunteer_id=$volunteer_id";
$result_total_attendance = $conn->query($sql_total_attendance);
$total_attendance_row = $result_total_attendance->fetch_assoc();
$totalDays = $total_attendance_row['total_days'];

// Calculate attendance percentage
$attendancePercentage = ($totalDays > 0) ? ($presentDays / $totalDays) * 100 : 0;

// Fetch attendance records
$sql_attendance_records = "SELECT date, status FROM attendance WHERE volunteer_id=$volunteer_id";
$result_attendance_records = $conn->query($sql_attendance_records);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard</title>
    <link rel="stylesheet" href="css/volunteer_dashboard.css">
    <link rel="stylesheet" href="css/mentor_dashboard.css">
</head>

<body id="vin">
    <!-- Profile Section -->
    <nav class="headof">
        <div><img src="./css/CHRIST LOGO.png" />
            <h1> Welcome, <?php echo htmlspecialchars($row['volunteer_name']); ?>!</h1>
        </div>

        <a href="logout.php">Logout</a>
    </nav>
    <div class="dashboard-container">
        <h1>Volunteer Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($row['volunteer_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone_number']); ?></p>
        <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($row['date_of_joining']); ?></p>
        <p><strong>Wing Name:</strong> <?php echo htmlspecialchars($row['wing_name']); ?></p>
        <p><strong>Mentor Name:</strong> <?php echo htmlspecialchars($row['mentor_name']); ?></p>
        <p><strong>Team Leaders:</strong> <?php echo htmlspecialchars(implode(", ", $teamLeaderNames)); ?></p>
    </div>

    <!-- Attendance Section -->
    <div class="dashboard-container-attendance">
        <h2>Attendance Record</h2>
        <?php if ($presentDays > 0): ?>
            <table border="1">
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php while ($attendanceRow = $result_attendance_records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attendanceRow['date']); ?></td>
                        <td><?php echo htmlspecialchars($attendanceRow['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <h3>Total Days Present: <?php echo htmlspecialchars($presentDays); ?></h3>
            <h3>Attendance Percentage: <?php echo number_format($attendancePercentage, 2); ?>%</h3>
        <?php else: ?>
            <p>No events attended yet.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Build By MSC AIML </p>
    </footer>

</body>

</html>