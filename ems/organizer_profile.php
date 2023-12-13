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

// Fetch other profile details from the database
$sql = "SELECT email, contact, location FROM organizers WHERE id = $organizerId";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $email = $row["email"];
    $contact = $row["contact"];
    $location = $row["location"];
} else {
    $error = "Failed to fetch profile details.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = $_POST["email"];
    $newContact = $_POST["contact"];
    $newPassword = $_POST["password"];
    $newLocation = $_POST["location"];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the profile in the database
    $updateSql = "UPDATE organizers SET email = '$newEmail', contact = '$newContact', password = '$hashedPassword', location = '$newLocation' WHERE id = $organizerId";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect to dashboard after successful update
        header("Location: organizer_dashboard.php");
        exit();
    } else {
        $error = "Failed to update profile.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Profile - Eventify</title>
    <link rel="stylesheet" href="css/organizer_profile.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="organizer_dashboard.php" class="dashboard-link">Dashboard</a>
        </div>
    </header>
    <main>
        <div class="profile-container">
            <h2 class="profile-heading">Edit Profile</h2>
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <form class="profile-form" method="post">
                <label class="profile-label" for="email">Email:</label>
                <input class="profile-input" type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                
                <label class="profile-label" for="contact">Contact:</label>
                <input class="profile-input" type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required>
                
                <label class="profile-label" for="password">Password:</label>
                <input class="profile-input" type="password" id="password" name="password" required>
                
                <label class="profile-label" for="location">Location:</label>
                <input class="profile-input" type="text" id="location" name="location" value="<?php echo $location; ?>">
                
                <button class="profile-button" type="submit">Update Profile</button>
            </form>
            <a href="upload_image.php" class="upload-button">Upload Image</a>
        </div>
    </main>
</body>
</html>
