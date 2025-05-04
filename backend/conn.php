<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_bebersih';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'gagal konek ke mysql']));
}

$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci");

$conn->select_db($dbname);

function tableExists($conn, $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    return $result && $result->num_rows > 0;
}

// bikin semua table kalau belum ada
$tables = ['donors', 'events', 'events_status', 'users'];

foreach ($tables as $table) {
    if (!tableExists($conn, $table)) {
        // bikin struktur database sesuai script lo
        $sql = file_get_contents(__DIR__ . '/setup_db.sql');
        if (!$conn->multi_query($sql)) {
            die(json_encode(['success' => false, 'message' => 'gagal bikin struktur db/table']));
        }
        // habisin semua hasil multi_query
        while ($conn->more_results() && $conn->next_result()) { $conn->use_result(); }
        break;
    }
}
?>
