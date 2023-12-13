<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "ems";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"]; // New field
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Simple password validation
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create and execute the SQL query to insert user data
    $sql = "INSERT INTO users (first_name, last_name, email, contact, password) 
            VALUES ('$first_name', '$last_name', '$email', '$contact', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
        header("Location: user_dashboard.php");
    } else {
        // Error occurred
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
