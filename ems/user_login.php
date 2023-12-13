<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_login.css">
    <title>User Login - Eventify</title>
</head>
<body>
    <div class="login-container">
        <h1 class="header-text">Eventify</h1> 
        <form action="user_login_process.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="user_register.php">Register</a></p>
    </div>
</body>
</html>
