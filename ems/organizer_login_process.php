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
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Create and execute the SQL query to fetch organizer data
    $sql = "SELECT * FROM organizers WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify password hash
        if (password_verify($password, $row["password"])) {
            // Successful login
            session_start();
            $_SESSION["organizer_id"] = $row["id"];
            header("Location: organizer_dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        // Organizer not found, redirect to registration
        header("Location: index.php");
    }
}

// Close the database connection
$conn->close();
?>
