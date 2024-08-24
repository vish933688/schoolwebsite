<?php
session_start();
require 'config.php';

if (!isset($_SESSION['adminID'])) {
    header("Location: login.php");
    exit;
}

$adminID = $_SESSION['adminID'];

// Fetch admin details
$query = "SELECT * FROM Admin WHERE adminID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $adminID);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $admin['firstName'] . ' ' . $admin['lastName']; ?>!</h2>
        <nav>
            <ul>
                <li><a href="manage_students.php">Manage Students</a></li>
                <li><a href="manage_teachers.php">Manage Teachers</a></li>
                <li><a href="manage_subjects.php">Manage Subjects</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
