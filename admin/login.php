<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminID = $_POST['adminID'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Admin WHERE adminID = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $adminID, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['adminID'] = $adminID;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid Admin ID or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="adminID">Admin ID:</label>
            <input type="text" name="adminID" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
