<?php
require_once '../config/koneksi.php';
$keyword = $_GET['q'];
$data = [];
$q = mysqli_query($conn, "SELECT * FROM kostum WHERE nama LIKE '%$keyword%'");
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}
header('Content-Type: application/json');
echo json_encode($data);
?>