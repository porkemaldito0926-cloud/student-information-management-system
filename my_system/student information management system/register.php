
<?php

require_once "config.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST["student_id"] ?? "");
    $full_name = trim($_POST["full_name"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($student_id === "" || $full_name === "" || $username === "" || $password === "") {

        $error = "Please complete all fields.";

    } else {

        // Check if username already exists
        $check = $conn->prepare(
            "SELECT id FROM student_users WHERE username = ? LIMIT 1"
        );

        if (!$check) {

            $error = "Database error: " . $conn->error;

        } else {

            $check->bind_param("s", $username);
            $check->execute();

            $result = $check->get_result();

            if ($result->num_rows > 0) {

                $error = "Username already exists. Please choose another username.";

            } else {

                // Hash password before saving
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO student_users
                        (student_id, username, password, full_name)
                        VALUES (?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);

                if (!$stmt) {

                    $error = "Database error: " . $conn->error;

                } else {

                    $stmt->bind_param(
                        "ssss",
                        $student_id,
                        $username,
                        $hashed_password,
                        $full_name
                    );

                    if ($stmt->execute()) {

                        $success = "Registration successful! You can now login.";

                    } else {

                        if ($stmt->errno === 1062) {
                            $error = "Username already exists. Please choose another username.";
                        } else {
                            $error = "Registration failed. Please try again.";
                        }

                    }

                    $stmt->close();
                }
            }

            $check->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body class="login-page">

<div class="login-container">

    <div class="login-box">

        <h1>Student Registration</h1>

        <p class="login-subtitle">
            Create your student account
        </p>

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

            <label>Student ID</label>

            <input
                type="text"
                name="student_id"
                placeholder="Enter Student ID"
                required
            >

            <label>Full Name</label>

            <input
                type="text"
                name="full_name"
                placeholder="Enter Full Name"
                required
            >

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Create Username"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Create Password"
                required
            >

            <button type="submit" class="btn primary full">
                Register
            </button>

        </form>

        <p class="login-help">
            Already registered?
            <a href="student_login.php">Go to Student Login</a>
        </p>

    </div>

</div>

</body>
</html>

