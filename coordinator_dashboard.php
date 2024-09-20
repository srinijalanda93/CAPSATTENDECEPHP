<?php
include 'db_connect.php';
session_start();

$email = $_SESSION['email'];

// Fetch coordinator profile
$sql = "SELECT * FROM coordinator WHERE email='$email'";
$result = $conn->query($sql);
$coordinator = $result->fetch_assoc();

// Fetch mentor details
$sql = "SELECT name, email, date_of_joining FROM mentor";
$mentors = $conn->query($sql);

// Fetch team leader details
$sql = "SELECT name, email, date_of_joining FROM team_leader";
$team_leaders = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background: linear-gradient(to right, #1E90FF, white);
            /* Blue to white gradient */
            color: black;
            padding: 10px;
            width: 100%;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header a {
            font-size: 20px;
            color: black;
            text-decoration: none;
        }

        .header a:hover {
            color: red;
            font-weight: 600;
        }

        h1 {
            margin: 0;
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
        }

        .profile-info,
        .table-container {
            margin-bottom: 20px;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table-container th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>

    <header>
        <h1>Welcome, <?php echo $coordinator['name']; ?>!</h1>
        <a href="logout.php">Logout</a>
    </header>

    <div class="container">
        <div class="profile-info">
            <h2>Coordinator Profile</h2>
            <p><strong>Name:</strong> <?php echo $coordinator['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $coordinator['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $coordinator['phone_number']; ?></p>
            <p><strong>Date of Joining:</strong> <?php echo $coordinator['date_of_joining']; ?></p>
        </div>

        <div class="table-container">
            <h2>Mentor Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Joining</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($mentor = $mentors->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $mentor['name']; ?></td>
                            <td><?php echo $mentor['email']; ?></td>
                            <td><?php echo $mentor['date_of_joining']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h2>Team Leader Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Joining</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($team_leader = $team_leaders->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $team_leader['name']; ?></td>
                            <td><?php echo $team_leader['email']; ?></td>
                            <td><?php echo $team_leader['date_of_joining']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>