<?php
require_once '../../config/database.php';

// Autentikasi user
if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Validasi ID kostum
if (!isset($_GET['id'])) {
    echo "Kostum tidak ditemukan.";
    exit;
}

$kostum_id = intval($_GET['id']);
$query = "SELECT * FROM kostum WHERE id = $kostum_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Kostum tidak tersedia.";
    exit;
}

$kostum = mysqli_fetch_assoc($result);

// Proses form transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $durasi = intval($_POST['durasi']);
    $total_harga = $durasi * $kostum['harga'];

    $insert = mysqli_query($conn, "INSERT INTO transaksi (user_id, kostum_id, tanggal_sewa, durasi, total_harga, status) 
                                   VALUES ($user_id, $kostum_id, '$tanggal_sewa', $durasi, $total_harga, 'pending')");

    if ($insert) {
        $transaksi_id = mysqli_insert_id($conn);
        echo "<script>alert('Transaksi berhasil!'); window.location.href='pembayaran.php?id=$transaksi_id';</script>";
    } else {
        echo "Gagal menyimpan transaksi: " . mysqli_error($conn);
    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Transaksi</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .form-transaksi {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border: 2px solid #A4DD00;
            padding: 20px;
            border-radius: 10px;
        }

        .form-transaksi h2 {
            color: #98CD00;
        }

        .form-transaksi input,
        .form-transaksi button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
        }

        .form-transaksi button {
            background-color: #A4DD00;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .form-transaksi button:hover {
            background-color: #8AC400;
        }
    </style>
</head>

<body>
    <div class="form-transaksi">
        <h2>Sewa: <?= htmlspecialchars($kostum['nama_kostum']) ?></h2>
        <form method="post">
            <label>Tanggal Sewa</label>
            <input type="date" name="tanggal_sewa" required>

            <label>Durasi (hari)</label>
            <input type="number" name="durasi" min="1" required>

            <button type="submit">Kirim Transaksi</button>
        </form>
    </div>
</body>

</html>