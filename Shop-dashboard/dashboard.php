<?php
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$dark_mode = $_SESSION['dark_mode'] ?? 0;
$arabic_mode = $_SESSION['arabic_mode'] ?? 0;

$themeClass = $dark_mode ? 'dark' : 'light';
$direction = $arabic_mode ? 'rtl' : 'ltr';
?>

<!DOCTYPE html>
<html lang="en" dir="<?= $direction ?>">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body.light { background-color: #fff; color: #000; }
        body.dark { background-color: #121212; color: #f0f0f0; }
    </style>
</head>
<body class="<?= $themeClass ?>">
    <h1>Welcome to the Dashboard</h1>
    <p>Your theme is set to <strong><?= $themeClass ?></strong>.</p>
    <p>Language mode: <strong><?= $arabic_mode ? 'Arabic' : 'English' ?></strong></p>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
