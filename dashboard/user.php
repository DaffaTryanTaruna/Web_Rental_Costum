<?php
require_once '../config/database.php';

// Ambil semua data kostum
$query = "SELECT * FROM kostum";
$result = mysqli_query($conn, $query);
$kostum_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $kostum_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User - Dashboard Kostum</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        :root {
            --bg-main: #FFFADC;
            --green-light: #B6F500;
            --green-medium: #A4DD00;
            --green-dark: #98CD00;
            --text-dark: #333;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-main);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px 20px;
        }

        h2 {
            color: var(--green-dark);
            margin-bottom: 10px;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--green-light);
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        .kostum-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .kostum-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.2s ease;
            border: 2px solid var(--green-medium);
            height: 350px;
        }

        .kostum-card:hover {
            transform: translateY(-5px);
        }

        .kostum-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .kostum-card h4 {
            margin: 12px 0 6px;
            color: var(--green-dark);
        }

        .kostum-card p {
            margin-bottom: 12px;
            font-weight: bold;
            color: var(--text-dark);
        }
    </style>
</head>

<body>
    <?php include '../dashboard/header.php'; ?>

    <div class="container">
        <h2>Dashboard Produk Kostum</h2>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari nama kostum...">
        </div>

        <div class="kostum-grid" id="kostumGrid">
            <?php foreach ($kostum_data as $kostum): ?>
                <div class="kostum-card" data-nama="<?= strtolower($kostum['nama_kostum']) ?>">
                    <img src="../uploads/<?= $kostum['gambar'] ?>" alt="<?= $kostum['nama_kostum'] ?>">
                    <h4><?= $kostum['nama_kostum'] ?></h4>
                    <p>Rp<?= number_format($kostum['harga'], 0, ',', '.') ?>/hari</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const kostumCards = document.querySelectorAll('.kostum-card');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            kostumCards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                card.style.display = nama.includes(keyword) ? 'block' : 'none';
            });
        });
    </script>
</body>

</html>
