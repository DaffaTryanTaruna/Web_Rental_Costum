<?php
require_once '../config/koneksi.php';

class TransaksiModel {
    public function tambah($id_kostum, $penyewa, $tgl_sewa, $tgl_kembali) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO transaksi(id_kostum, nama_penyewa, tanggal_sewa, tanggal_kembali) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_kostum, $penyewa, $tgl_sewa, $tgl_kembali);
        $stmt->execute();
    }
}
?>