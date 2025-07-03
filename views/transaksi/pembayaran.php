<?php
require_once '../../config/database.php';

// Autentikasi user
if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Validasi transaksi milik user
if (!isset($_GET['id'])) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

$transaksi_id = intval($_GET['id']);
$query = "SELECT t.*, k.nama_kostum FROM transaksi t 
          JOIN kostum k ON t.kostum_id = k.id 
          WHERE t.id = $transaksi_id AND t.user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Transaksi tidak ditemukan atau bukan milik Anda.";
    exit;
}

$transaksi = mysqli_fetch_assoc($result);

// Proses upload bukti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bukti = $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];
    $bukti_baru = uniqid() . '_' . $bukti;

    if (move_uploaded_file($tmp, '../../bukti/' . $bukti_baru)) {
        $update = mysqli_query($conn, "UPDATE transaksi 
            SET bukti_pembayaran = '$bukti_baru', status = 'diproses' 
            WHERE id = $transaksi_id");

        if ($update) {
            echo "<script>alert('Bukti pembayaran berhasil diupload!'); window.location='../../dashboard/user.php';</script>";
        } else {
            echo "Gagal menyimpan bukti: " . mysqli_error($conn);
        }
    } else {
        echo "Upload gagal.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Pembayaran</title>
    <style>
        .form-box {
            max-width: 500px;
            margin: auto;
            background: #fff;
            border: 2px solid #A4DD00;
            padding: 20px;
            border-radius: 10px;
            margin-top: 40px;
        }

        .form-box h2 {
            color: #98CD00;
        }

        .form-box input, .form-box button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
        }

        .form-box button {
            background: #A4DD00;
            color: #fff;
            border: none;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Pembayaran untuk: <?= htmlspecialchars($transaksi['nama_kostum']) ?></h2>
        <p>Total: Rp<?= number_format($transaksi['total_harga'], 0, ',', '.') ?></p>
        <form method="post" enctype="multipart/form-data">
            <label>Upload Bukti Pembayaran (jpg/png/pdf):</label>
            <input type="file" name="bukti" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
