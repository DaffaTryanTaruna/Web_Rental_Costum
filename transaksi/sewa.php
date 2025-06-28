<?php
require_once '../model/TransaksiModel.php';
require_once '../model/KostumModel.php';

$kostumModel = new KostumModel();
$transaksiModel = new TransaksiModel();

$kostum = $kostumModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kostum = $_POST['id_kostum'];
    $penyewa = $_POST['penyewa'];
    $tgl_sewa = $_POST['tgl_sewa'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $transaksiModel->tambah($id_kostum, $penyewa, $tgl_sewa, $tgl_kembali);
    echo "Transaksi berhasil disimpan.";
}
?>
<form method="post">
    <select name="id_kostum">
        <?php foreach ($kostum as $k): ?>
        <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="text" name="penyewa" placeholder="Nama Penyewa" required><br>
    <input type="date" name="tgl_sewa" required><br>
    <input type="date" name="tgl_kembali" required><br>
    <button type="submit">Sewa</button>
</form>