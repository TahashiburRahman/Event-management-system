<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/organizer_register.css">
    <link href="https://fonts.googleapis.com/css2?family=Your+Fancy+Font&display=swap" rel="stylesheet">
    <title>Organizer Registration - Eventify</title>
</head>
<body>
<div class="logo-container">
    <h1 class="logo">Eventify</h1>
</div>
    <h1>Organizer Registration</h1>
    <form action="register_organizer_process.php" method="post">
        <label for="organization_name">Organization Name:</label>
        <input type="text" id="organization_name" name="organization_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        <br>
        <button type="submit">Register</button>
    </form>
    <br>
    <div id="login-link-container">
        <a href="#" class="jump-link">Already joined as an organization? Login here</a>
    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const passwordInput = document.getElementById("password");
        const confirmPasswordInput = document.getElementById("confirm_password");
        const submitButton = document.querySelector("button");

        // Disable the submit button by default
        submitButton.disabled = true;

        // Enable the submit button only if passwords match
        confirmPasswordInput.addEventListener("keyup", function() {
            if (passwordInput.value === confirmPasswordInput.value) {
                submitButton.disabled = false;
                confirmPasswordInput.style.borderColor = "#00C853"; // Green border
            } else {
                submitButton.disabled = true;
                confirmPasswordInput.style.borderColor = "#FF5722"; // Red border
            }
        });

        // Form validation
        form.addEventListener("submit", function(event) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                event.preventDefault();
                alert("Passwords do not match!");
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
    // Your existing code...

    const loginLinkContainer = document.getElementById("login-link-container");

    loginLinkContainer.addEventListener("click", function(event) {
        event.preventDefault();

        // Slide up the link container
        loginLinkContainer.style.transition = "2s";
        loginLinkContainer.style.transform = "translateY(-100%)";

        // Redirect after the sliding effect
        setTimeout(function() {
            window.location.href = "organizer_login.php";
        }, 500); // Adjust the timing to match the transition duration
    });
});

</script>

</body>
</html>
