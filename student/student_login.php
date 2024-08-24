<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentID = $_POST['studentID'];
    $dob = $_POST['dob'];
    $name = $_POST['name'];

    // Verify student credentials
    $query = "SELECT * FROM Student WHERE studentID = ? AND dob = ? AND CONCAT(firstName, ' ', lastName) = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $studentID, $dob, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['studentID'] = $studentID;
        header("Location: student_dashboard.php");
    } else {
        $error = "Invalid Student ID, Date of Birth, or Name!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Student Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="student_login.php" method="POST">
            <label for="studentID">Student ID:</label>
            <input type="text" name="studentID" required>
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required>
            <label for="name">Full Name:</label>
            <input type="text" name="name" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
