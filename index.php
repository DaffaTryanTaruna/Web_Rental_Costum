<?php
require_once 'config/database.php';
$kostum = $conn->query("SELECT k.*, c.nama_kategori FROM kostum k 
                        LEFT JOIN kategori c ON k.kategori_id = c.id 
                        WHERE k.status = 'tersedia'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rental Kostum</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- opsional -->
    <style>
        body { font-family: Arial; padding: 20px; }
        .kostum { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; width: 300px; display: inline-block; vertical-align: top; }
        .kostum img { max-width: 100%; height: 200px; object-fit: cover; }
        .topnav a { margin-right: 15px; }
    </style>
</head>
<body>

<h1>Selamat Datang di Rental Kostum</h1>
<div class="topnav">
    <a href="auth/login.php">Login</a>
    <a href="auth/register.php">Daftar</a>
</div>

<h2>Daftar Kostum Tersedia</h2>

<?php while($k = $kostum->fetch_assoc()): ?>
<div class="kostum">
    <img src="assets/img/<?= $k['gambar'] ?>" alt="<?= $k['nama_kostum'] ?>">
    <h3><?= $k['nama_kostum'] ?></h3>
    <p>Kategori: <?= $k['nama_kategori'] ?></p>
    <p>Harga: Rp <?= number_format($k['harga_per_hari']) ?>/hari</p>
    <p>Stok: <?= $k['stok'] ?></p>
</div>
<?php endwhile; ?>

</body>
</html>
