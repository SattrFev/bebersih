<?php
header("Content-Type: application/json");
require_once "conn.php";

$sql = "SELECT * FROM events ORDER BY date ASC";
$result = mysqli_query($conn, $sql);

$events = [];

if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
      "title" => $row["title"],
      "date" => $row["date"],
      "time" => $row["time"],
      "location" => $row["location"],
      "image" => $row["image"],
      "formurl" => $row["formurl"]
    ];
  }
}

echo json_encode($events);
?>
