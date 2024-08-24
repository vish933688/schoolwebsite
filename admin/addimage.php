<?php
if (isset($_POST['upload'])) {
    // Define target directories
    $eventDir = "uploads/events/";
    $galleryDir = "uploads/gallery/";
    
    // Create directories if they don't exist
    if (!file_exists($eventDir)) {
        mkdir($eventDir, 0777, true);
    }
    if (!file_exists($galleryDir)) {
        mkdir($galleryDir, 0777, true);
    }

    // Determine the target directory based on selected section
    $imageType = $_POST['imageType'];
    $targetDir = $imageType == "event" ? $eventDir : $galleryDir;
    
    $targetFile = $targetDir . basename($_FILES["imageFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (5MB maximum)
    if ($_FILES["imageFile"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload the file
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["imageFile"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
