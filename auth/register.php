<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // gunakan hashing lebih aman seperti bcrypt di project nyata
    $role = $_POST['role'];

    // Cek apakah email sudah terdaftar
    $cek = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($cek->num_rows > 0) {
        $error = "Email sudah digunakan.";
    } else {
        $conn->query("INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");
        header("Location: login.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    Nama: <input type="text" name="nama" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Role: <input type="role" name="role" required><br>
    <button type="submit">Daftar</button>
</form>
<p>Sudah punya akun? <a href="login.php">Login</a></p>
</body>
</html>
