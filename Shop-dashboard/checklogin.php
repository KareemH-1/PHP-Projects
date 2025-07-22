<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php?error=1");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Shop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pass = trim($_POST['pass']);
if (empty($pass)) {
    die("Password is required.");
}

$sql = "SELECT password, dark_mode, arabic_mode FROM settings LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    if (hash('sha256', $pass) === $row['password']) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['dark_mode'] = $row['dark_mode'];
        $_SESSION['arabic_mode'] = $row['arabic_mode'];
        header("Location: dashboard.php");
        exit();
    } 
    else {
        header("Location: login.php?error=1");
        exit();
    }
} 
else {
    header("Location: login.php?error=2");
    exit();
}

$conn->close();
?>
