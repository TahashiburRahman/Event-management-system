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

// Get organizer ID
$organizerId = $_SESSION["organizer_id"];

function getOrganizationName($conn, $organizerId) {
    $sql = "SELECT organization_name FROM organizers WHERE id = $organizerId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row["organization_name"];
    }

    return "Organizer"; // Default name if not found
}

// Fetch event types' names from the database
$sql = "SELECT id, name FROM event_types";
$result = $conn->query($sql);

$eventTypes = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventTypes[] = $row;
    }
}

// Fetch organizer's event prices from the database
$sql = "SELECT event_type_id, price FROM organizer_event_prices WHERE organizer_id = $organizerId";
$result = $conn->query($sql);

$eventPrices = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventPrices[$row["event_type_id"]] = $row["price"];
    }
}

// Fetch event requests for the organizer
$sql = "SELECT e.id AS event_id, e.event_type_name, e.event_date, e.event_price, u.contact, u.email, e.status
        FROM events e
        JOIN users u ON e.user_id = u.id
        WHERE e.organizer_id = $organizerId";
$result = $conn->query($sql);

$eventRequests = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventRequests[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/organizer_dash.css">

    <title>Organizer Dashboard - Eventify</title>
</head>
<body>
<header>
    <h1>Organizer Dashboard</h1>
</header>
    <nav>
        <ul>
            <li> <a href="organizer_profile.php" class="profile-button">Profile</a></li>
            <li><a href="organizer_logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
    <h2><?php echo getOrganizationName($conn, $organizerId); ?></h2>

        <!-- Display Event Types and Prices Form -->
        <h3>Event Types and Prices</h3>
        <table>
            <tr>
                <th>Event Type</th>
                <th>Price</th>
                <th>Update Price</th>
            </tr>
            <?php foreach ($eventTypes as $eventType): ?>
            <tr>
                <td><?php echo $eventType['name']; ?></td>
                <td>
                    <?php
                    $price = isset($eventPrices[$eventType['id']]) ? $eventPrices[$eventType['id']] : 0;
                    echo $price;
                    ?>
                </td>
                <td>
                <form action="update_event_price.php" method="post">
                        <input type="hidden" name="event_type_id" value="<?php echo $eventType['id']; ?>">
                        <input type="number" name="new_price" value="<?php echo $price; ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

<!-- Display Event Requests -->
<h3>Event Requests</h3>
<table>
    <tr>
        <th>Event Type</th>
        <th>Event Date</th>
        <th>Event Price</th>
        <?php if (!empty($eventRequests) && isset($eventRequests[0]['status']) && $eventRequests[0]['status'] === 'accepted'): ?>
            <th>Contact</th>
            <th>Email</th>
        <?php endif; ?>
        <th>Action</th>
    </tr>
    <?php foreach ($eventRequests as $request): ?>
    <tr>
        <td><?php echo $request['event_type_name']; ?></td>
        <td><?php echo $request['event_date']; ?></td>
        <td><?php echo $request['event_price']; ?></td>
        <?php if (!empty($eventRequests) && isset($request['status']) && $request['status'] === 'accepted'): ?>
            <td><?php echo $request['contact']; ?></td>
            <td><?php echo $request['email']; ?></td>
            <td>
                <!-- Display a message indicating that the event has been accepted -->
                <strong>Accepted</strong>
            </td>
        <?php else: ?>
            <td>
                <form action="process_event_request.php" method="post">
                    <input type="hidden" name="event_id" value="<?php echo $request['event_id']; ?>">
                    <button type="submit" name="action" value="accept">Accept</button>
                    <button type="submit" name="action" value="decline">Decline</button>
                </form>
            </td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>
    </main>
</body>
</html>
