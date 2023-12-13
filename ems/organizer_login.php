<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/organizer_login.css">
    <title>Organizer Login - Eventify</title>
</head>
<body>
    <div class="login-container">
        <h1 class="step-title">Welcome to Eventify</h1>
        <form id="login-form" action="organizer_login_process.php" method="post">
            <div class="step" id="step-email">
                <label for="email">Enter your email</label>
                <input type="email" id="email" name="email" required>
                <button id="btn-email">Next</button>
            </div>
            <div class="step" id="step-password">
                <label for="password">Enter your password</label>
                <input type="password" id="password" name="password" required>
                <button id="btn-password" type="submit">Login</button>
            </div>
        </form>
        <div class="register-button">
            <a href="organizer_register.php">Register as an Organizer</a>
        </div>
    </div>
    
    <script src="js/organizer_login.js"></script>
</body>
</html>
