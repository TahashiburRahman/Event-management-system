<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $targetDir = "uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = basename($_FILES["image"]["name"]);
    $uniqueName = uniqid() . "_" . $fileName;
    $targetFilePath = $targetDir . $uniqueName;

    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ems";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            session_start();
            $organizerId = $_SESSION["organizer_id"];

            $sql = "INSERT INTO uploads (organizer_id, image_path) VALUES ('$organizerId', '$targetFilePath')";

            if ($conn->query($sql) === TRUE) {
                echo "File uploaded successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    }
} else {
    header("Location: upload_image.php");
    exit();
}
?>
