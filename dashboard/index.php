<?php
require_once '../config/database.php';

// Cek apakah user sudah login dan berperan sebagai 'user'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil semua kostum yang tersedia
$kostum = $conn->query("SELECT k.*, kategori.nama_kategori 
                        FROM kostum k 
                        LEFT JOIN kategori ON k.kategori_id = kategori.id 
                        WHERE k.stok > 0 AND k.status = 'tersedia'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User - Rental Kostum</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { margin-top: 0; }
    </style>
</head>
<body>

<h2>Selamat datang, <?= $_SESSION['user']['nama'] ?>!</h2>
<p><a href="../auth/logout.php">Logout</a></p>

<h3>Daftar Kostum Tersedia</h3>

<table>
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama Kostum</th>
            <th>Kategori</th>
            <th>Harga/Hari</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $kostum->fetch_assoc()): ?>
        <tr>
            <td><img src="../assets/img/<?= $row['gambar'] ?>" width="80"></td>
            <td><?= $row['nama_kostum'] ?></td>
            <td><?= $row['nama_kategori'] ?></td>
            <td>Rp<?= number_format($row['harga_per_hari']) ?></td>
            <td><?= $row['stok'] ?></td>
            <td><a href="../transaksi/sewa.php?id=<?= $row['id'] ?>">Sewa</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
