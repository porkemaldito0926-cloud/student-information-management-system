
<?php

require_once "config.php";

// Check if student is logged in
if (!isset($_SESSION["student_user_id"])) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION["student_id"];
$username = $_SESSION["username"];
$full_name = $_SESSION["full_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <h2>Student IMS</h2>

        <div class="user-info">
            <?= htmlspecialchars($full_name) ?>
        </div>

        <nav>

            <a href="student_dashboard.php" class="active">
                Dashboard
            </a>

            <a href="student_form.php">
                Student Form
            </a>

            <a href="logout.php" class="logout">
                Logout
            </a>

        </nav>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main">

        <div class="topbar">

            <div>

                <h1>Student Dashboard</h1>

                <p>Welcome to your student account</p>

            </div>

        </div>


        <div class="content-box">

            <h2>
                Welcome, <?= htmlspecialchars($full_name) ?>!
            </h2>

            <p>
                You are successfully logged in to the Student Information System.
            </p>


            <!-- STUDENT ACCOUNT INFORMATION -->

            <div class="card">

                <h3>Account Information</h3>

                <p>
                    <strong>Student ID:</strong>
                    <?= htmlspecialchars($student_id) ?>
                </p>

                <p>
                    <strong>Username:</strong>
                    <?= htmlspecialchars($username) ?>
                </p>

                <p>
                    <strong>Full Name:</strong>
                    <?= htmlspecialchars($full_name) ?>
                </p>

            </div>


            <!-- STUDENT FORM BUTTON -->

            <div class="card">

                <h3>Student Information</h3>

                <p>
                    Please complete your student information form.
                </p>

                <a
                    href="student_form.php"
                    class="btn primary"
                >
                    Complete Student Information
                </a>

            </div>


            <!-- LOGOUT -->

            <div class="form-buttons">

                <a
                    href="logout.php"
                    class="btn secondary"
                >
                    Logout
                </a>

            </div>

        </div>

    </main>

</div>

</body>
</html>

