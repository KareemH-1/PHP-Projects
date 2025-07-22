<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

$setting = $_POST['setting'] ?? '';

if (!in_array($setting, ['dark_mode', 'arabic_mode'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid setting']);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Shop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$sql = "SELECT $setting FROM settings LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $current_value = $row[$setting];
    $new_value = $current_value ? 0 : 1; 
    
    $update_sql = "UPDATE settings SET $setting = ? LIMIT 1";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $new_value);
    
    if ($stmt->execute()) {
        // Update session
        $_SESSION[$setting] = $new_value;
        
        echo json_encode([
            'success' => true,
            'dark_mode' => $_SESSION['dark_mode'] ?? 0,
            'arabic_mode' => $_SESSION['arabic_mode'] ?? 0
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update setting']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Settings not found']);
}

$conn->close();
?>