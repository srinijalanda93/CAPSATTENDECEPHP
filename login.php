<?php
include 'db_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Check for login credentials in all roles
    $role = null;

    // Check coordinator table
    $sql = "SELECT * FROM coordinator WHERE email='$email' AND phone_number='$phone_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $role = 'coordinator';
    }

    // Check mentor table
    $sql = "SELECT * FROM mentor WHERE email='$email' AND phone_number='$phone_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $role = 'mentor';
    }

    // Check team leader table
    $sql = "SELECT * FROM team_leader WHERE email='$email' AND phone_number='$phone_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $role = 'team_leader';
    }

    // Check volunteer table
    $sql = "SELECT * FROM volunteer WHERE email='$email' AND phone_number='$phone_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $role = 'volunteer';
    }

    if ($role) {
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // Redirect to respective dashboard
        header("Location: " . $role . "_dashboard.php");
    } else {
        $login_error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="css/login.css">
    <script>
        function validateForm() {
            const email = document.forms["loginForm"]["email"].value;
            const phoneNumber = document.forms["loginForm"]["phone_number"].value;

            // Basic email validation
            if (!email.includes("@")) {
                alert("Please enter a valid email.");
                return false;
            }

            // Phone number validation (ensure it is a number)
            if (isNaN(phoneNumber) || phoneNumber.length < 10) {
                alert("Please enter a valid phone number.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <!-- PHP error message -->
    <?php if (isset($login_error)): ?>
        <div class="error"><?php echo $login_error; ?></div>
    <?php endif; ?>

    <!-- HTML Form -->
    <form name="loginForm" method="POST" action="login.php" onsubmit="return validateForm()">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="phone_number" placeholder="Phone Number" required>
        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>
