<?php
// Include koneksi database
include 'conn.php'; // pastikan file conn.php sudah ada dan koneksi ke DB berjalan

// Query untuk mengambil data dari tabel events_status
$sql = "SELECT * FROM events_status";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    // Ambil setiap baris dan masukkan ke array
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    // Kirimkan data sebagai JSON
    echo json_encode($events);
} else {
    echo json_encode([]); // Jika tidak ada data, kembalikan array kosong
}

$conn->close();
?>
