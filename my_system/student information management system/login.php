<?php

require_once "config.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
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
            "SELECT id, username, password, full_name
             FROM users
             WHERE username = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["full_name"] = $user["full_name"];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Invalid username or password.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Student Information System</title>

    <link rel="stylesheet" href="assets/style.css">

</head>

<body class="login-page">

<div class="login-container">

    <div class="login-box">

        <h1>Student Information System</h1>

        <p class="login-subtitle">
            Administrator Login
        </p>

        <?php if ($error): ?>

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
            Default: <b>admin</b> / <b>password</b>
        </p>

    </div>

</div>

</body>
</html>
