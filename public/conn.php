<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_bebersih';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'gagal konek ke mysql']));
}
