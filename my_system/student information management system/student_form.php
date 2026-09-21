
<?php

require_once "config.php";

if (!isset($_SESSION["student_user_id"])) {
    header("Location: student_login.php");
    exit;
}

$error = "";
$success = "";

$account_student_id = $_SESSION["student_id"];
$account_full_name = $_SESSION["full_name"];
$account_username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST["student_id"] ?? "");
    $first_name = trim($_POST["first_name"] ?? "");
    $middle_name = trim($_POST["middle_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $gender = trim($_POST["gender"] ?? "");
    $birth_date = $_POST["birth_date"] ?? null;
    $address = trim($_POST["address"] ?? "");
    $contact_number = trim($_POST["contact_number"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $year_level = trim($_POST["year_level"] ?? "");
    $section = trim($_POST["section"] ?? "");

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

        if (!$stmt) {

            $error = "Database error: " . $conn->error;

        } else {

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

                $success = "Student information saved successfully!";

            } else {

                if ($stmt->errno === 1062) {
                    $error = "This Student ID already exists.";
                } else {
                    $error = "Unable to save student information.";
                }

            }

            $stmt->close();
        }
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

    <title>Student Information Form</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Student IMS</h2>

        <div class="user-info">
            <?= htmlspecialchars($account_full_name) ?>
        </div>

        <nav>

            <a href="student_dashboard.php">
                Dashboard
            </a>

            <a href="student_form.php" class="active">
                Student Form
            </a>

            <a href="logout.php" class="logout">
                Logout
            </a>

        </nav>

    </aside>

    <main class="main">

        <div class="topbar">

            <div>

                <h1>Student Information Form</h1>

                <p>Complete your student information</p>

            </div>

        </div>

        <div class="content-box">

            <?php if ($error !== ""): ?>

                <div class="alert error">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <?php if ($success !== ""): ?>

                <div class="alert success">
                    <?= htmlspecialchars($success) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="form-grid">

                    <div class="form-group">

                        <label>Student ID *</label>

                        <input
                            type="text"
                            name="student_id"
                            value="<?= htmlspecialchars($account_student_id) ?>"
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
                        Submit Information
                    </button>

                    <a
                        href="student_dashboard.php"
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

