<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login-styles.css">
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
                echo '<div class="error-message">Database connection failed./div>';
            } else {
                echo '<div class="error-message">An error occurred. Please try again.</div>';
            }
        }
        ?>
        <form method="POST" action="checklogin.php">
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="pass" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
        </form>
        <p class="default-password">Default password: admin123</p>
    </div>
</body>
</html>