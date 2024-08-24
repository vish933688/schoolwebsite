<?php
session_start();
require 'config.php';

if (!isset($_SESSION['studentID'])) {
    header("Location: student_login.php");
    exit;
}

$studentID = $_SESSION['studentID'];

// Fetch student details
$query = "SELECT * FROM Student WHERE studentID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $studentID);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

// Fetch subjects, assignments, and teacher details
$query = "SELECT s.subjectName, s.subjectCode, a.assignmentTitle, 
                 t.firstName AS teacherFirstName, t.lastName AS teacherLastName 
          FROM Assignment a
          JOIN Subject s ON a.subjectID = s.subjectID
          JOIN Teacher t ON a.teacherID = t.teacherID
          WHERE a.studentID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $studentID);
$stmt->execute();
$subjects = $stmt->get_result();

// Fetch fees structure
$query = "SELECT * FROM Fees WHERE studentID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $studentID);
$stmt->execute();
$fees = $stmt->get_result()->fetch_assoc();

// Fetch student results
$query = "SELECT s.subjectName, r.grade, r.examDate 
          FROM Result r
          JOIN Subject s ON r.subjectID = s.subjectID
          WHERE r.studentID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $studentID);
$stmt->execute();
$results = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $student['firstName'] . ' ' . $student['lastName']; ?>!</h2>

        <h3>Subjects and Assignments</h3>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Subject Code</th>
                    <th>Assignment</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($subject = $subjects->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $subject['subjectName']; ?></td>
                    <td><?php echo $subject['subjectCode']; ?></td>
                    <td><?php echo $subject['assignmentTitle']; ?></td>
                    <td><?php echo $subject['teacherFirstName'] . ' ' . $subject['teacherLastName']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Fees Structure</h3>
        <table>
            <tr>
                <th>Tuition Fees</th>
                <td><?php echo $fees['tuitionFees']; ?></td>
            </tr>
            <tr>
                <th>Lab Fees</th>
                <td><?php echo $fees['labFees']; ?></td>
            </tr>
            <tr>
                <th>Other Fees</th>
                <td><?php echo $fees['otherFees']; ?></td>
            </tr>
            <tr>
                <th>Total Fees</th>
                <td><?php echo $fees['totalFees']; ?></td>
            </tr>
        </table>

        <h3>Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Exam Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($result = $results->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $result['subjectName']; ?></td>
                    <td><?php echo $result['grade']; ?></td>
                    <td><?php echo $result['examDate']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button id="printAssignments">Print Assignments</button>
        <button id="printResults">Print Results</button>

        <script>
            $('#printAssignments').click(function() {
                window.print();
            });

            $('#printResults').click(function() {
                window.print();
            });
        </script>

        <a href="student_logout.php">Logout</a>
    </div>
</body>
</html>
