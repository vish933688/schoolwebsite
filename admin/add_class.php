<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Students to Class</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Assign Students to Class</h2>
        
        <form action="assign_class.php" method="POST">
            <div class="form-group">
                <label for="className">Class Name:</label>
                <input type="text" id="className" name="className" required>
            </div>

            <div class="form-group">
                <label for="classTeacher">Class Teacher:</label>
                <input type="text" id="classTeacher" name="classTeacher" required>
            </div>

            <div class="form-group">
                <label for="studentSelect">Select Students:</label>
                <select id="studentSelect" name="studentIDs[]" multiple required>
                    <?php
                    require 'config.php';
                    $result = $conn->query("SELECT * FROM Student");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['studentID'] . "'>" . $row['firstName'] . " " . $row['lastName'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit">Assign to Class</button>
        </form>
    </div>
</body>
</html>
