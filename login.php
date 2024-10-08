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
    <section id="upper">
        <img src="./css/loginimage.png" alt="upperimage" srcset="">
    </section>
    <section id="lower">
        <h2>Welcome to CAPS </h2>
        <div id="combine">
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

            <div id="capintro">
                <!-- <img src="./css/CAPS LOGO.png" alt="logo"> -->
                <p>CAPS, or the Centre for Academic and Professional Support,
                    is designed for students, educators, and professionals
                    within the CHRIST community who are eager to enhance their
                    academic, scholarly, and professional skills. Whether you’re
                    a student striving to excel in your studies, a researcher looking
                    to master advanced writing techniques, or someone seeking guidance
                    on professional communication, CAPS is your go-to resource.
                    Our services cater to a wide range of needs through various modalities,
                    including peer training, one-on-one coaching, e-learning modules,
                    and psychometric assessments. </p>
            </div>
        </div>

    </section>




</body>

</html>