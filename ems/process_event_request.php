<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["organizer_id"])) {
    // User is not logged in, redirect to login page
    header("Location: organizer_login.php");
    exit();
}

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
    $eventId = $_POST["event_id"];
    $action = $_POST["action"];
    
    if ($action === "accept") {
        // Update the event request status to "accepted"
        $updateSql = "UPDATE events SET status = 'accepted' WHERE id = $eventId";
        $conn->query($updateSql);
        
        // Set the flag to show contact and email columns
        $showContactEmail = true;
    } elseif ($action === "decline") {
        // Delete the event request from the database
        $deleteSql = "DELETE FROM events WHERE id = $eventId";
        $conn->query($deleteSql);
    }
    
    // Redirect back to the dashboard
    header("Location: organizer_dashboard.php");
    exit();
}
?>
