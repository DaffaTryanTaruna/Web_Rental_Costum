<?php
require_once '../../config/database.php';

if (!isset($_GET['id'])) {
    echo "Kostum tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM kostum WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Kostum tidak ditemukan.";
    exit;
}

$kostum = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Kostum</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FFFADC;
            margin: 0;
            padding: 20px;
        }

        .detail-container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            border: 2px solid #A4DD00;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .detail-container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .detail-info {
            margin-top: 20px;
        }

        .detail-info h2 {
            color: #98CD00;
        }

        .detail-info p {
            font-size: 18px;
            color: #333;
        }

        .btn-sewa {
            display: inline-block;
            background-color: #A4DD00;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
        }

        .btn-sewa:hover {
            background-color: #98CD00;
        }
    </style>
</head>

<body>
    <div class="detail-container">
        <img src="../../uploads/<?= $kostum['gambar'] ?>" alt="<?= $kostum['nama_kostum'] ?>">
        <div class="detail-info">
            <h2><?= $kostum['nama_kostum'] ?></h2>
            <p><strong>Harga:</strong> Rp<?= number_format($kostum['harga'], 0, ',', '.') ?>/hari</p>
            <p><strong>Deskripsi:</strong> <?= nl2br(htmlspecialchars($kostum['deskripsi'])) ?></p>
            <a href="../transaksi/sewa.php?id=<?= $kostum['id'] ?>" class="btn-sewa">Sewa Sekarang</a>
            <a href="../../dashboard/user.php"
                style="display: inline-block; margin-top: 20px; color: white; background-color: #A4DD00; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Kembali</a>
        </div>
    </div>
</body>

</html>