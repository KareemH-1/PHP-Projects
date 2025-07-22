<?php
$conn = new mysqli("localhost", "root", "", "backend");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$username = trim($_POST['username']);
$password = $_POST['password'];

$errors = [];

if (empty($email) || empty($username) || empty($password)) {
    $errors[] = "All fields are required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters.";
}

if (empty($errors)) {
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $errors[] = "Email is already registered.";
    }

    $check->close();
}

if (empty($errors)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo " Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    foreach ($errors as $err) {
        echo " $err<br>";
    }
}

$conn->close();
?>
