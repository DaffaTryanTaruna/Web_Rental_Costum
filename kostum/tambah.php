<?php
require_once '../model/KostumModel.php';
$model = new KostumModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto'];

    $namaFile = '';
    if (in_array($foto['type'], ['image/jpeg', 'image/png'])) {
        $namaFile = time() . '-' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], '../uploads/' . $namaFile);
    }

    $model->tambah($nama, $harga, $namaFile);
    header('Location: list.php');
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="nama" placeholder="Nama Kostum" required><br>
    <input type="number" name="harga" placeholder="Harga Sewa" required><br>
    <input type="file" name="foto" required><br>
    <button type="submit">Simpan</button>
</form>