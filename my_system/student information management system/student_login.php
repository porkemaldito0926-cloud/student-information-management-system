
<?php

require_once "config.php";

if (isset($_SESSION['student_user_id'])) {
    header("Location: student_dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {

        $error = "Please enter username and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, student_id, username, password, full_name
             FROM student_users
             WHERE username = ?
             LIMIT 1"
        );

        if (!$stmt) {

            $error = "Database error: " . $conn->error;

        } else {

            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();
            $student = $result->fetch_assoc();

            if ($student && password_verify($password, $student["password"])) {

                session_regenerate_id(true);

                $_SESSION["student_user_id"] = $student["id"];
                $_SESSION["student_id"] = $student["student_id"];
                $_SESSION["username"] = $student["username"];
                $_SESSION["full_name"] = $student["full_name"];

                header("Location: student_dashboard.php");
                exit;

            } else {

                $error = "Invalid username or password.";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Login</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body class="login-page">

<div class="login-container">

    <div class="login-box">

        <h1>Student Information System</h1>

        <p class="login-subtitle">
            Student Login
        </p>

        <?php if ($error !== ""): ?>

            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required
            >

            <button type="submit" class="btn primary full">
                Login
            </button>

        </form>

        <p class="login-help">
            Not registered yet?
            <a href="register.php">Create Student Account</a>
        </p>

    </div>

</div>

</body>
</html>

