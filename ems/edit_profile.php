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

// Fetch user's information
$user_id = $_SESSION["user_id"];
$user_sql = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = $conn->query($user_sql);
$user_row = $user_result->fetch_assoc();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $password = $_POST["password"]; // Password as entered by the user

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update user information in the database
    $update_sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', contact = '$contact', password = '$hashed_password' WHERE id = '$user_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        // Profile updated successfully
        header("Location: user_dashboard.php");
        exit();
    } else {
        // Error occurred
        echo "Error: " . $update_sql . "<br>" . $conn->error;
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
    <link rel="stylesheet" href="css/user_dash.css">
    <title>Edit Profile - Eventify</title>
</head>
<body>
    <header>
        <h1>Edit Profile</h1>
    </header>
    <nav>
        <ul>
            <li><a href="user_dashboard.php">Back to Dashboard</a></li>
            <li><a href="user_logout.php">Logout</a></li>
        </ul>
    </nav>
    <main>
        <h2>Edit Your Profile</h2>
        
        <form action="" method="post">
            <label for="first_name">First Name:</label><br>
            <input type="text" name="first_name" value="<?php echo $user_row["first_name"]; ?>" required>
            <br>
            <label for="last_name">Last Name:</label><br>
            <input type="text" name="last_name" value="<?php echo $user_row["last_name"]; ?>" required>
            <br>
            <label for="email">Email:</label><br>
            <input type="email" name="email" value="<?php echo $user_row["email"]; ?>" required>
            <br>
            <label for="contact">Contact:</label><br>
            <input type="text" name="contact" value="<?php echo $user_row["contact"]; ?>" required>
            <br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Save Changes</button>
        </form>
    </main>
</body>
</html>
