<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST["student_id"]);
    $first_name = trim($_POST["first_name"]);
    $middle_name = trim($_POST["middle_name"]);
    $last_name = trim($_POST["last_name"]);
    $gender = trim($_POST["gender"]);
    $birth_date = $_POST["birth_date"] ?: null;
    $address = trim($_POST["address"]);
    $contact_number = trim($_POST["contact_number"]);
    $email = trim($_POST["email"]);
    $course = trim($_POST["course"]);
    $year_level = trim($_POST["year_level"]);
    $section = trim($_POST["section"]);

    if (
        $student_id === "" ||
        $first_name === "" ||
        $last_name === ""
    ) {

        $error = "Student ID, first name and last name are required.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO students
            (
                student_id,
                first_name,
                middle_name,
                last_name,
                gender,
                birth_date,
                address,
                contact_number,
                email,
                course,
                year_level,
                section
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssssssssss",
            $student_id,
            $first_name,
            $middle_name,
            $last_name,
            $gender,
            $birth_date,
            $address,
            $contact_number,
            $email,
            $course,
            $year_level,
            $section
        );

        if ($stmt->execute()) {

            header("Location: students.php");
            exit;

        } else {

            $error = "Unable to save student. Student ID may already exist.";

        }

        $stmt->close();
    }
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

    <title>Add Student</title>

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

            <a href="students.php">
                Students
            </a>

            <a href="add_student.php" class="active">
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

                <h1>Add Student</h1>

                <p>Enter student information</p>

            </div>

        </div>

        <div class="content-box">

            <?php if ($error): ?>

                <div class="alert error">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="form-grid">

                    <div class="form-group">

                        <label>Student ID *</label>

                        <input
                            type="text"
                            name="student_id"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>First Name *</label>

                        <input
                            type="text"
                            name="first_name"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>Middle Name</label>

                        <input
                            type="text"
                            name="middle_name"
                        >

                    </div>

                    <div class="form-group">

                        <label>Last Name *</label>

                        <input
                            type="text"
                            name="last_name"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>Gender</label>

                        <select name="gender">

                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Birth Date</label>

                        <input
                            type="date"
                            name="birth_date"
                        >

                    </div>

                    <div class="form-group">

                        <label>Contact Number</label>

                        <input
                            type="text"
                            name="contact_number"
                        >

                    </div>

                    <div class="form-group">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                        >

                    </div>

                    <div class="form-group">

                        <label>Course</label>

                        <input
                            type="text"
                            name="course"
                            placeholder="BS Information Technology"
                        >

                    </div>

                    <div class="form-group">

                        <label>Year Level</label>

                        <select name="year_level">

                            <option value="">Select Year</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Section</label>

                        <input
                            type="text"
                            name="section"
                            placeholder="A"
                        >

                    </div>

                    <div class="form-group full-width">

                        <label>Address</label>

                        <textarea
                            name="address"
                            rows="4"
                        ></textarea>

                    </div>

                </div>

                <div class="form-buttons">

                    <button
                        type="submit"
                        class="btn primary"
                    >
                        Save Student
                    </button>

                    <a
                        href="students.php"
                        class="btn secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>
