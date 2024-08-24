<?php
var_dump($results->fetch_assoc());

session_start();
require '../config.php';

if (!isset($_SESSION['studentID'])) {
    header("Location: ../student/student_login.php");
    exit;
}

$studentID = $_SESSION['studentID'];

// Fetch student details
$query = "SELECT * FROM Student WHERE studentID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $studentID);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

// Fetch results, subjects, and teacher details
$query = "SELECT Subject.subjectName, Subject.subjectCode, Result.grade, 
                 Result.percentage, Teacher.firstName AS teacherFirstName, 
                 Teacher.lastName AS teacherLastName 
          FROM Result 
          JOIN Subject ON Result.subjectID = Subject.subjectID 
          JOIN Teacher ON Subject.teacherID = Teacher.teacherID 
          WHERE Result.studentID = ?";
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
    <title>Student Result</title>
    <link rel="stylesheet" href="../styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="result-container">
        <h2>Student Result</h2>
        <div class="student-info">
            <h3><?php echo $student['firstName'] . ' ' . $student['lastName']; ?></h3>
            <p>Student ID: <?php echo $student['studentID']; ?></p>
        </div>

        <h3>Subject Grades</h3>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Subject Code</th>
                    <th>Grade</th>
                    <th>Percentage</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results->num_rows > 0) : ?>
                    <?php while ($result = $results->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $result['subjectName']; ?></td>
                        <td><?php echo $result['subjectCode']; ?></td>
                        <td><?php echo $result['grade']; ?></td>
                        <td><?php echo $result['percentage']; ?>%</td>
                        <td><?php echo $result['teacherFirstName'] . ' ' . $result['teacherLastName']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No results found for this student.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button id="printResult">Print Result</button>
        <a href="../student/student_dashboard.php">Back to Dashboard</a>
    </div>

    <script>
        $('#printResult').click(function() {
            window.print();
        });
    </script>
</body>
</html>
