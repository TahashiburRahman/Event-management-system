<?php
session_start();

if (!isset($_SESSION["organizer_id"])) {
    header("Location: organizer_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    $organizerId = $_SESSION["organizer_id"];
    $eventTypeId = $_POST["event_type_id"];
    $newPrice = $_POST["new_price"];

    // Check if there's already a price entry for this organizer and event type
    $checkSql = "SELECT * FROM organizer_event_prices WHERE organizer_id = $organizerId AND event_type_id = $eventTypeId";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Update existing price
        $updateSql = "UPDATE organizer_event_prices SET price = $newPrice WHERE organizer_id = $organizerId AND event_type_id = $eventTypeId";
        if ($conn->query($updateSql) === TRUE) {
            header("Location: organizer_dashboard.php"); // Redirect back to dashboard
        } else {
            echo "Error updating price: " . $conn->error;
        }
    } else {
        // Insert new price entry
        $insertSql = "INSERT INTO organizer_event_prices (organizer_id, event_type_id, price) VALUES ($organizerId, $eventTypeId, $newPrice)";
        if ($conn->query($insertSql) === TRUE) {
            header("Location: organizer_dashboard.php"); // Redirect back to dashboard
        } else {
            echo "Error inserting price: " . $conn->error;
        }
    }

    $conn->close();
} else {
    header("Location: organizer_dashboard.php"); // Redirect back to dashboard
}
?>
