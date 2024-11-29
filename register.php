<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "missing_persons";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$gender = $_POST['gender'];
$firID = $_POST['firID'];
$registeredBy = $_POST['registeredBy'];



$targetDir = "uploads/"; 
$targetFile = $targetDir . basename($_FILES["photo"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

$allowedTypes = array('jpg', 'png', 'jpeg', 'gif');

if (in_array($imageFileType, $allowedTypes)) {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        
        $sql = "INSERT INTO registrations (name, gender, fir_id, registered_by, photo)
                VALUES ('$name', '$gender', '$firID', '$registeredBy','$targetFile')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the photo.";
    }
} else {
    echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
}

$conn->close();
?>
