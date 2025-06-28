<?php
require_once '../config/koneksi.php';

class KostumModel {
    public function getAll() {
        global $conn;
        $result = mysqli_query($conn, "SELECT * FROM kostum");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function tambah($nama, $harga, $foto) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO kostum(nama, harga, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nama, $harga, $foto);
        $stmt->execute();
    }
}
?>