<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // User is not logged in, redirect to login page
    header("Location: user_login.php");
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

// Fetch event type names, organizer names, and prices
$sql = "SELECT oep.price, et.name AS event_type_name, o.organization_name, o.id AS organizer_id, et.id AS event_type_id
        FROM organizer_event_prices oep
        JOIN event_types et ON oep.event_type_id = et.id
        JOIN organizers o ON oep.organizer_id = o.id
        ORDER BY event_type_name, price ASC"; // Order by event type and lowest price first
$result = $conn->query($sql);

// Handle event request submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $event_type_name = $_POST["event_type_name"];
    $organizer_id = $_POST["organizer_id"];
    $organization_name = $_POST["organization_name"];
    $event_date = $_POST["event_date"];
    $event_price = $_POST["event_price"];

    // Insert request into events table
    $insert_sql = "INSERT INTO events (user_id, event_type_name, organizer_id, organization_name, event_date, event_price) 
                VALUES ('$user_id', '$event_type_name', '$organizer_id', '$organization_name', '$event_date', '$event_price')";
    
    if ($conn->query($insert_sql) === TRUE) {
        // Event requested successfully
        header("Location: organization_details.php?organizer_id=$organizer_id");
        exit();
    } else {
        // Error occurred
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}
// Fetch user's first name
$user_id = $_SESSION["user_id"];
$user_sql = "SELECT first_name FROM users WHERE id = '$user_id'";
$user_result = $conn->query($user_sql);
$user_row = $user_result->fetch_assoc();
$user_first_name = $user_row["first_name"];
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_dash.css">
    <title>User Dashboard - Eventify</title>
</head>
<body>
    <header>
        <h1>Welcome <?php echo $user_first_name; ?>,</h1>
    </header>
    <nav>
        <ul>
            <li><a href="edit_profile.php">Profile</a></li>
            <li><a href="user_logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <h2 style="text-align: center;">User Dashboard</h2>
        
        <h3 style="text-align: center;">Event Types and Prices</h3>
        <table>
            <thead>
                <tr>
                    <th>Organization</th>
                    <th>Event Type</th>
                    <th>Price</th>
                    <th>Event Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["organization_name"]; ?></td>
                        <td><?php echo $row["event_type_name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="event_type_name" value="<?php echo $row["event_type_name"]; ?>">
                                <input type="hidden" name="organizer_id" value="<?php echo $row["organizer_id"]; ?>">
                                <input type="hidden" name="organization_name" value="<?php echo $row["organization_name"]; ?>">
                                <input type="hidden" name="event_price" value="<?php echo $row["price"]; ?>">
                                <input type="date" name="event_date" required>
                        </td>
                        <td>
                                <button type="submit">Request</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
