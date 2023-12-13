<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image - Eventify</title>
    <link rel="stylesheet" href="css/upload_image.css">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="header-logo">Eventify</a>
        </div>
    </header>
    <main>
        <div class="upload-container">
            <h2 class="upload-heading">Upload Image</h2>
            <form class="upload-form" enctype="multipart/form-data" method="post" action="upload_image_handler.php">
                <input class="upload-input" type="file" name="image" accept="image/*" onchange="previewImage()">
                <img class="image-preview" src="#" alt="Image Preview">
                <button class="upload-button" type="submit">Upload</button>
            </form>
            <div class="header-buttons">
                <a href="organizer_profile.php" class="upload-button">Back to Profile</a>
            </div>
        </div>
    </main>
    <script>
        function previewImage() {
            var preview = document.querySelector('.image-preview');
            var fileInput = document.querySelector('input[type="file"]');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
