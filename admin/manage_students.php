<?php
session_start();
require 'config.php';

if (!isset($_SESSION['adminID'])) {
    header("Location: login.php");
    exit;
}

// Handle Add/Edit/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            // Add student logic
            $stmt = $conn->prepare("INSERT INTO Student (firstName, lastName, dob, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $_POST['firstName'], $_POST['lastName'], $_POST['dob'], $_POST['email']);
            $stmt->execute();
        } elseif ($_POST['action'] == 'edit') {
            // Edit student logic
            $stmt = $conn->prepare("UPDATE Student SET firstName = ?, lastName = ?, dob = ?, email = ? WHERE studentID = ?");
            $stmt->bind_param("ssssi", $_POST['firstName'], $_POST['lastName'], $_POST['dob'], $_POST['email'], $_POST['studentID']);
            $stmt->execute();
        } elseif ($_POST['action'] == 'delete') {
            // Delete student logic
            $stmt = $conn->prepare("DELETE FROM Student WHERE studentID = ?");
            $stmt->bind_param("i", $_POST['studentID']);
            $stmt->execute();
        }
    }
}

// Fetch students
$students = $conn->query("SELECT * FROM Student");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="manage-container">
        <h2>Manage Students</h2>
        <button id="addStudent">Add New Student</button>
        
        <!-- Add Student Form -->
        <div id="addStudentForm" style="display: none;">
            <h3>Add New Student</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" required>
                
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" required>
                
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                
                <button type="submit">Submit</button>
                <button type="button" id="cancelAdd">Cancel</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $student['studentID']; ?></td>
                    <td><?php echo $student['firstName']; ?></td>
                    <td><?php echo $student['lastName']; ?></td>
                    <td><?php echo $student['dob']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td>
                        <button class="editStudent" data-id="<?php echo $student['studentID']; ?>">Edit</button>
                        <button class="deleteStudent" data-id="<?php echo $student['studentID']; ?>">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Show the add student form when the Add New Student button is clicked
            $('#addStudent').click(function() {
                $('#addStudentForm').show();
            });

            // Hide the add student form when the Cancel button is clicked
            $('#cancelAdd').click(function() {
                $('#addStudentForm').hide();
            });

            $('.editStudent').click(function() {
                var studentID = $(this).data('id');
                // Example logic for showing a form to edit a student
                alert('Edit Student ID: ' + studentID);
                // Implement form pre-fill and display logic here
            });

            $('.deleteStudent').click(function() {
                var studentID = $(this).data('id');
                if (confirm("Are you sure you want to delete this student?")) {
                    $.post('manage_students.php', { action: 'delete', studentID: studentID }, function(response) {
                        location.reload();
                    });
                }
            });
        });
    </script>
</body>
</html>
