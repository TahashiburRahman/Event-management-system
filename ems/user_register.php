<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_register.css">
    <title>User Registration - Eventify</title>
</head>
<body>
    <div class="registration-container">
    <div class="registration-content">
        <h1>User Registration</h1>
        <form action="register_user_process.php" method="post">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Register</button>
        </form>
            <p>Already have an account? <a href="user_login.php"><b>Login</b></a></p>
    </div>
        <div class="registration-image">
            <img src="img/Eventifyflyer.png" alt="Eventify Flyer">
        </div>
        
</div>
</body>
</html>
