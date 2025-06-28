<?php
require_once 'config/koneksi.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    // Validasi
    if (empty($nama) || empty($email) || empty($password) || empty($konfirmasi)) {
        $error = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid!";
    } elseif ($password !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah email sudah ada
        $cek = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO user(nama, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hash);
            if ($stmt->execute()) {
                $success = "Registrasi berhasil. <a href='login.php'>Login di sini</a>";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }
    }
}
?>

<h2>Registrasi Akun</h2>
<?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>
<?php if ($success): ?><p style="color:green"><?= $success ?></p><?php endif; ?>

<form method="post">
    <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
    <input type="email" name="email" placeholder="Email Aktif" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="konfirmasi" placeholder="Konfirmasi Password" required><br>
    <button type="submit">Daftar</button>
</form>
