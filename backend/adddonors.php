<?php
include('conn.php');

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
$message = isset($_POST['message']) ? $_POST['message'] : '';

if (empty($name) || empty($email) || $amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap atau jumlah tidak valid']);
    exit();
}

$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO donors (name, email, amount, message, date) VALUES ('$name', '$email', $amount, '$message', '$date')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Donasi berhasil!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $conn->error]);
}

$conn->close();
?>
