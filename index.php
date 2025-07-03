<?php
require_once 'config/database.php';

// Ambil semua data kostum
$query = "SELECT * FROM kostum";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Rental Kostum</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .hero-banner {
            width: 100%;
            max-width: 100%;
            margin-bottom: 30px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .hero-banner img {
            width: 100%;
            height: auto;
            /* Tinggi mengikuti rasio gambar */
            display: block;
            object-fit: cover;
            object-position: center;
            border-radius: 12px;
        }


        .hero-text {
            position: absolute;
            top: 75%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 45px;
            font-weight: bold;
            text-shadow: 2px 2px #000000;
            text-align: center;
        }


        .kostum-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .kostum-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background-color: #fff;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
        }

        .kostum-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .kostum-card h4 {
            margin: 10px 0 5px;
        }

        .kostum-card p {
            margin: 0;
        }
    </style>
</head>

<body>
    <?php include 'views/layout/header.php'; ?>

    <div class="container">
        <div class="hero-banner">
            <img src="assets/banner.jpg" alt="Banner Rental Kostum">
            <div class="hero-text">TRANSFORMASI SEKEJAP <br> COSPLAY MAKSIMAL</div>
        </div>

        <h2>Dashboard Produk Kostum</h2>
        <div class="kostum-grid">
            <?php while ($kostum = mysqli_fetch_assoc($result)): ?>
                <div class="kostum-card">
                    <img src="uploads/<?= $kostum['gambar'] ?>" alt="<?= $kostum['nama_kostum'] ?>">
                    <h4><?= $kostum['nama_kostum'] ?></h4>
                    <p>Harga: Rp<?= number_format($kostum['harga'], 0, ',', '.') ?>/hari</p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>