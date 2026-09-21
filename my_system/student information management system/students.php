<?php

require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$search = trim($_GET["search"] ?? "");

if ($search !== "") {

    $searchTerm = "%" . $search . "%";

    $stmt = $conn->prepare(
        "SELECT *
         FROM students
         WHERE student_id LIKE ?
         OR first_name LIKE ?
         OR middle_name LIKE ?
         OR last_name LIKE ?
         OR course LIKE ?
         ORDER BY id DESC"
    );

    $stmt->bind_param(
        "sssss",
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query(
        "SELECT *
         FROM students
         ORDER BY id DESC"
    );
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

    <title>Students</title>

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

                <h1>Student Records</h1>

                <p>
                    Manage student information
                </p>

            </div>

            <a href="add_student.php" class="btn primary">
                + Add Student
            </a>

        </div>

        <div class="content-box">

            <form class="search-form" method="GET">

                <input
                    type="text"
                    name="search"
                    placeholder="Search student..."
                    value="<?= htmlspecialchars($search) ?>"
                >

                <button type="submit" class="btn primary">
                    Search
                </button>

                <a href="students.php" class="btn secondary">
                    Clear
                </a>

            </form>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Section</th>
                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($student = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars(
                                        $student["student_id"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $student["last_name"] . ", " .
                                        $student["first_name"] . " " .
                                        $student["middle_name"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $student["gender"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $student["course"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $student["year_level"]
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $student["section"]
                                    ) ?>
                                </td>

                                <td class="actions">

                                    <a
                                        href="view_student.php?id=<?= $student["id"] ?>"
                                        class="small-btn view"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="edit_student.php?id=<?= $student["id"] ?>"
                                        class="small-btn edit"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="delete_student.php?id=<?= $student["id"] ?>"
                                        class="small-btn delete"
                                        onclick="return confirm('Are you sure you want to delete this student?')"
                                    >
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7" class="empty">
                                No students found.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>
