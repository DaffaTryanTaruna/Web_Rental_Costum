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
        * {
            box-sizing: border-box;
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
            margin-bottom: 20px;
            font-size: 28px;
        }

        .search-box {
            margin-bottom: 30px;
            position: relative;
            border: 2px solid #B6F500;
            /* atau gunakan var(--green-light) jika pakai variable */
            border-radius: 10px;
            /* opsional agar sudut lebih halus */
            padding: 8px;
            /* opsional agar isinya tidak terlalu mepet */
        }


        .search-box input {
            width: 100%;
            padding: 12px 16px;
            padding-right: 40px;
            border: 2px solid var(--green-light);
            border-radius: 10px;
            font-size: 16px;
            outline: none;
            background-color: var(--white);
        }

        .kostum-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .kostum-card {
            background-color: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: 2px solid var(--green-medium);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .kostum-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .kostum-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .kostum-card h4 {
            margin: 16px 0 8px;
            font-size: 18px;
            color: var(--green-dark);
        }

        .kostum-card p {
            margin-bottom: 16px;
            font-weight: bold;
            color: var(--text-dark);
        }

        @media (max-width: 600px) {
            h2 {
                font-size: 24px;
            }

            .kostum-card img {
                height: 180px;
            }
        }
    </style>
</head>

<body>
    <?php include '../views/layout/header.php'; ?>

    <div class="container">
        <h2>Dashboard Produk Kostum</h2>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Cari nama kostum...">
        </div>

        <div class="kostum-grid" id="kostumGrid">
            <?php foreach ($kostum_data as $kostum): ?>
                <a href="../views/kostum/detail.php?id=<?= $kostum['id'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="kostum-card" data-nama="<?= strtolower($kostum['nama_kostum']) ?>">
                        <img src="../uploads/<?= $kostum['gambar'] ?>" alt="<?= $kostum['nama_kostum'] ?>">
                        <h4><?= $kostum['nama_kostum'] ?></h4>
                        <p>Rp<?= number_format($kostum['harga'], 0, ',', '.') ?>/hari</p>
                    </div>
                </a>
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