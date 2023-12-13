<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_login.css">
    <title>Admin Login - Eventify</title>
</head>
<body>
    <div class="login-container">
        <header>
            <h1 class="header-text">Eventify Admin</h1>
        </header>
        <form action="admin_login_process.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Login</button>
        </form>
        <a href="../index.php" class="home-button">Home</a>
    </div>
</body>
</html>
