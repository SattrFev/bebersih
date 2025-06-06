<?php
include('conn.php');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, email, amount, message, date FROM donors ORDER BY date DESC";
$result = $conn->query($sql);
$donors = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $donors[] = $row;
  }
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($donors);
