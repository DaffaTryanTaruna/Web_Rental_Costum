<?php
session_start();
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
    $user = mysqli_fetch_assoc($q);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $user['nama'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Login gagal';
    }
}
?>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

"Belum punya akun? <a href='register.php'>Register dulu</a>";

<?php if (!empty($error)) echo $error; ?>