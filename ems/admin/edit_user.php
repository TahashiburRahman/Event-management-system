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

// Get the user ID from the query string
if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    // Fetch user details using the provided user_id
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        $user = null;
    }
}

// Process updating user information
if (isset($_POST["update_user"])) {
    $new_first_name = $_POST["new_first_name"];
    $new_last_name = $_POST["new_last_name"];
    $new_email = $_POST["new_email"];
    $new_contact = $_POST["new_contact"];

    // Update user information in the database
    $update_sql = "UPDATE users SET first_name = '$new_first_name', last_name = '$new_last_name', email = '$new_email', contact = '$new_contact' WHERE id = $user_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "User information updated successfully.";
    } else {
        echo "Error updating user information: " . $conn->error;
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
    <title>Edit User - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <header>
        <h1>Edit User</h1>
    </header>
    <nav>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="manage_users.php">Back to Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">Back to Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <main>
        <!-- Edit user form -->
        <?php if ($user): ?>
            <form action="edit_user.php?user_id=<?php echo $user_id; ?>" method="post" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="new_first_name" class="form-label">First Name:</label>
                    <input type="text" id="new_first_name" name="new_first_name" value="<?php echo $user["first_name"]; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_last_name" class="form-label">Last Name:</label>
                    <input type="text" id="new_last_name" name="new_last_name" value="<?php echo $user["last_name"]; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_email" class="form-label">Email:</label>
                    <input type="email" id="new_email" name="new_email" value="<?php echo $user["email"]; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_contact" class="form-label">Contact:</label>
                    <input type="text" id="new_contact" name="new_contact" value="<?php echo $user["contact"]; ?>" class="form-control" required>
                </div>
                <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
            </form>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
