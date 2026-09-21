<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM students WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    header("Location: students.php");
    exit;
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

    <title>Student Profile</title>

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

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="students.php" class="active">
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

                <h1>Student Profile</h1>

                <p>
                    <?= htmlspecialchars(
                        $student["first_name"] . " " .
                        $student["last_name"]
                    ) ?>
                </p>

            </div>

            <div>

                <a
                    href="edit_student.php?id=<?= $student["id"] ?>"
                    class="btn primary"
                >
                    Edit
                </a>

                <a
                    href="students.php"
                    class="btn secondary"
                >
                    Back
                </a>

            </div>

        </div>

        <div class="profile-card">

            <div class="profile-header">

                <div class="avatar">
                    <?= strtoupper(
                        substr($student["first_name"], 0, 1)
                    ) ?>
                </div>

                <div>

                    <h2>
                        <?= htmlspecialchars(
                            $student["first_name"] . " " .
                            $student["middle_name"] . " " .
                            $student["last_name"]
                        ) ?>
                    </h2>

                    <p>
                        Student ID:
                        <b>
                            <?= htmlspecialchars(
                                $student["student_id"]
                            ) ?>
                        </b>
                    </p>

                </div>

            </div>

            <div class="details-grid">

                <div>
                    <strong>Gender</strong>
                    <span><?= htmlspecialchars($student["gender"]) ?></span>
                </div>

                <div>
                    <strong>Birth Date</strong>
                    <span><?= htmlspecialchars($student["birth_date"]) ?></span>
                </div>

                <div>
                    <strong>Contact Number</strong>
                    <span><?= htmlspecialchars($student["contact_number"]) ?></span>
                </div>

                <div>
                    <strong>Email</strong>
                    <span><?= htmlspecialchars($student["email"]) ?></span>
                </div>

                <div>
                    <strong>Course</strong>
                    <span><?= htmlspecialchars($student["course"]) ?></span>
                </div>

                <div>
                    <strong>Year Level</strong>
                    <span><?= htmlspecialchars($student["year_level"]) ?></span>
                </div>

                <div>
                    <strong>Section</strong>
                    <span><?= htmlspecialchars($student["section"]) ?></span>
                </div>

                <div class="full-width">
                    <strong>Address</strong>
                    <span><?= htmlspecialchars($student["address"]) ?></span>
                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>
