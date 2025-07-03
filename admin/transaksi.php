<?php
require_once '../config/database.php';

// Autentikasi admin
if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Jika admin klik tombol "Selesaikan"
if (isset($_GET['selesai'])) {
    $id = intval($_GET['selesai']);
    mysqli_query($conn, "UPDATE transaksi SET status = 'selesai' WHERE id = $id");
    header("Location: transaksi.php");
    exit;
}

// Ambil data transaksi dan relasinya
$query = "
SELECT t.*, u.nama AS nama_user, k.nama_kostum 
FROM transaksi t
JOIN users u ON t.user_id = u.id
JOIN kostum k ON t.kostum_id = k.id
ORDER BY t.created_at DESC
";
$transaksi = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Kelola Transaksi</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th {
            background-color: #A4DD00;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .btn-selesai {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-selesai:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include '../views/layout/header.php'; ?>
    <div class="container">
        <h2>Kelola Transaksi Sewa</h2>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Kostum</th>
                    <th>Tanggal Sewa</th>
                    <th>Durasi</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($transaksi)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_user']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kostum']) ?></td>
                        <td><?= $row['tanggal_sewa'] ?></td>
                        <td><?= $row['durasi'] ?> hari</td>
                        <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td>
                            <?php if ($row['bukti_pembayaran']): ?>
                                <a href="../bukti/<?= $row['bukti_pembayaran'] ?>" target="_blank">Lihat Bukti</a>
                            <?php else: ?>
                                <em>Belum Ada</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['bukti_pembayaran'] && $row['status'] !== 'selesai'): ?>
                                <a href="?selesai=<?= $row['id'] ?>" class="btn-selesai" onclick="return confirm('Tandai transaksi ini sebagai selesai?')">Selesai</a>
                            <?php else: ?>
                                <em>-</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
