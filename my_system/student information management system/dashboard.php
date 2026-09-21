<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$total_students = 0;
$total_male = 0;
$total_female = 0;

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM students"
);

if ($row = $result->fetch_assoc()) {
    $total_students = $row["total"];
}

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM students
     WHERE gender = 'Male'"
);

if ($row = $result->fetch_assoc()) {
    $total_male = $row["total"];
}

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM students
     WHERE gender = 'Female'"
);

if ($row = $result->fetch_assoc()) {
    $total_female = $row["total"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Student IMS</h2>

        <div class="user-info">
            <?= htmlspecialchars($_SESSION["full_name"]) ?>
        </div>

        <nav>

            <a href="dashboard.php" class="active">
                Dashboard
            </a>

            <a href="students.php">
                Students
            </a>

            <a href="add_student.php">
                Add Student
            </a>

            <a href="logout.php" class="logout">
                Logout
            </a>

        </nav>

    </aside>

    <main class="main">

        <div class="topbar">

            <div>
                <h1>Dashboard</h1>
                <p>Student Information Management System</p>
            </div>

        </div>

        <div class="cards">

            <div class="card blue">

                <div class="card-title">
                    Total Students
                </div>

                <div class="card-number">
                    <?= $total_students ?>
                </div>

            </div>

            <div class="card green">

                <div class="card-title">
                    Male Students
                </div>

                <div class="card-number">
                    <?= $total_male ?>
                </div>

            </div>

            <div class="card pink">

                <div class="card-title">
                    Female Students
                </div>

                <div class="card-number">
                    <?= $total_female ?>
                </div>

            </div>

        </div>

        <div class="content-box">

            <h2>Quick Actions</h2>

            <div class="quick-actions">

                <a href="add_student.php" class="btn primary">
                    + Add Student
                </a>

                <a href="students.php" class="btn secondary">
                    View Students
                </a>

            </div>

        </div>

    </main>

</div>

</body>
</html>
