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

if (isset($_GET["organizer_id"])) {
    $organizer_id = $_GET["organizer_id"];

    // Fetch organizer details using the provided organizer_id
    $sql = "SELECT * FROM organizers WHERE id = $organizer_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $organizer = $result->fetch_assoc();
    } else {
        $organizer = null;
    }

    // Fetch uploaded images for the organizer
    $imageSql = "SELECT * FROM uploads WHERE organizer_id = $organizer_id";
    $imageResult = $conn->query($imageSql);
    $images = [];

    if ($imageResult->num_rows > 0) {
        while ($row = $imageResult->fetch_assoc()) {
            $images[] = $row["image_path"];
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/organizer_details.css">
    <title>Organization Details - Eventify</title>
</head>
<body>
    <header>
        <h1>Organization Details</h1>
    </header>
    <nav>
        <ul>
            <li><a href="user_dashboard.php">Back to Dashboard</a></li>
            <li><a href="user_logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <?php if ($organizer): ?>
            <p><strong>Organization Name:</strong> <?php echo $organizer["organization_name"]; ?></p>
            <p><strong>Email:</strong> <?php echo $organizer["email"]; ?></p>
            <p><strong>Contact:</strong> <?php echo $organizer["contact"]; ?></p>
            <p><strong>Location:</strong> <?php echo $organizer["location"]; ?></p>
            
            <!-- Display uploaded images -->
            <?php if (!empty($images)): ?>
                <h2>Uploaded Images</h2>
                <div class="image-container">
                    <?php foreach ($images as $imagePath): ?>
                        <img src="<?php echo $imagePath; ?>" alt="Image">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Organization not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
