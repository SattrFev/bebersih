<?php
$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = '';      
$db_name = 'db_bebersih';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    last_login DATETIME,
    failed_attempts INT DEFAULT 0,
    locked_until DATETIME
)";

if (!$conn->query($sql)) {
    die("Error creating users table: " . $conn->error);
}

$check_admin = $conn->query("SELECT * FROM users WHERE username = 'admin'");
if ($check_admin->num_rows == 0) {
    // Create default admin user with password 'admin123'
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('admin', '$hashed_password')";
    if (!$conn->query($sql)) {
        die("Error creating admin user: " . $conn->error);
    }
}
?>