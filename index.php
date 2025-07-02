
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
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
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
    <?php include 'dashboard/header.php'; ?>

    <div class="container">
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

