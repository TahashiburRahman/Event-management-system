<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["admin_id"])) {
    // Admin is not logged in, redirect to login page
    header("Location: admin_login.php");
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

// Get the organizer ID from the query string
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
}

// Process updating organizer information
if (isset($_POST["update_organizer"])) {
    $new_org_name = $_POST["new_org_name"];
    $new_email = $_POST["new_email"];
    $new_contact = $_POST["new_contact"];
    $new_location = $_POST["new_location"];

    // Update organizer information in the database
    $update_sql = "UPDATE organizers SET organization_name = '$new_org_name', email = '$new_email', contact = '$new_contact', location = '$new_location' WHERE id = $organizer_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Organizer information updated successfully.";
    } else {
        echo "Error updating organizer information: " . $conn->error;
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
    <title>Edit Organizer - Admin Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Edit Organizer</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_organizers.php">Back to Manage Organizers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Back to Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <!-- Edit organizer form -->
        <?php if ($organizer): ?>
            <form action="edit_organizer.php?organizer_id=<?php echo $organizer_id; ?>" method="post">
                <div class="form-group">
                    <label for="new_org_name">Organization Name:</label>
                    <input type="text" class="form-control" id="new_org_name" name="new_org_name" value="<?php echo $organizer["organization_name"]; ?>" required>
                </div>
                <div class="form-group">
                    <label for="new_email">Email:</label>
                    <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo $organizer["email"]; ?>" required>
                </div>
                <div class="form-group">
                    <label for="new_contact">Contact:</label>
                    <input type="text" class="form-control" id="new_contact" name="new_contact" value="<?php echo $organizer["contact"]; ?>" required>
                </div>
                <div class="form-group">
                    <label for="new_location">Location:</label>
                    <input type="text" class="form-control" id="new_location" name="new_location" value="<?php echo $organizer["location"]; ?>" required>
                </div>
                <button type="submit" name="update_organizer" class="btn btn-primary">Update Organizer</button>
            </form>
        <?php else: ?>
            <p>Organizer not found.</p>
        <?php endif; ?>
    </main>

    <!-- Add Bootstrap JS and jQuery (Make sure to include them at the bottom of the body) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
