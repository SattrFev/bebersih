<?php

include 'conn.php'; 

$sql = "SELECT * FROM events_status";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    echo json_encode($events);
} else {
    echo json_encode([]); 
}

$conn->close();
?>