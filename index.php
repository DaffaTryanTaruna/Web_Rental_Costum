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


        h2 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .kostum-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
        }

        .kostum-card {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kostum-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .kostum-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .kostum-card h4 {
            font-size: 20px;
            margin: 15px 10px 5px;
        }

        .kostum-card p {
            margin: 0 10px 15px;
            color: #777;
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