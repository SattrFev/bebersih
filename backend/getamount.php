<?php
require_once "conn.php"; // pastiin file ini connect ke db

$sql = "SELECT SUM(amount) AS total_amount FROM donors";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode(["total" => $row['total_amount']]);
} else {
    echo json_encode(["total" => 0]);
}

$conn->close();
?>
