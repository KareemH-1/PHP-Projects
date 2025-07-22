<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 1) {
                echo '<div class="error-message">Incorrect password.</div>';
            } elseif ($error == 2) {
                echo '<div class="error-message">Settings not found.</div>';
            } else {
                echo '<div class="error-message">An error occurred. Please try again.</div>';
            }
        }
        ?>
        <form method="POST" action="checklogin.php">
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="pass" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
        <p class="default-password">Default password: admin123</p>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>