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

// Process editing organizer information
if (isset($_POST["edit_organizer"])) {
    $organizer_id = $_POST["organizer_id"];
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

// Process deleting an organizer
if (isset($_GET["delete_organizer"])) {
    $organizer_id = $_GET["delete_organizer"];

    // Delete the organizer from the database
    $delete_sql = "DELETE FROM organizers WHERE id = $organizer_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Organizer deleted successfully.";
    } else {
        echo "Error deleting organizer: " . $conn->error;
    }
}

// Fetch the list of organizers
$sql = "SELECT * FROM organizers";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Organizers - Admin Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Manage Organizers</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
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
        <!-- List of organizers -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Organization Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["organization_name"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["contact"]; ?></td>
                            <td><?php echo $row["location"]; ?></td>
                            <td>
                                <a href="edit_organizer.php?organizer_id=<?php echo $row["id"]; ?>" class="btn btn-primary">Edit</a>
                                <a href="?delete_organizer=<?php echo $row["id"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this organizer?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No organizers found.</p>
        <?php endif; ?>
    </main>

    <!-- Add Bootstrap JS and jQuery (Make sure to include them at the bottom of the body) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
