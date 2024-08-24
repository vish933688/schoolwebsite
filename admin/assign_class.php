<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $className = $_POST['className'];
    $classTeacher = $_POST['classTeacher'];
    $studentIDs = $_POST['studentIDs'];

    // Insert the class information into the Class table
    $stmt = $conn->prepare("INSERT INTO Class (className, classTeacher) VALUES (?, ?)");
    $stmt->bind_param("ss", $className, $classTeacher);
    $stmt->execute();
    $classID = $stmt->insert_id;
    $stmt->close();

    // Insert the students into the ClassStudent table
    $stmt = $conn->prepare("INSERT INTO ClassStudent (classID, studentID) VALUES (?, ?)");
    foreach ($studentIDs as $studentID) {
        $stmt->bind_param("ii", $classID, $studentID);
        $stmt->execute();
    }
    $stmt->close();

    echo "Class and students have been successfully assigned.";
}
?>
