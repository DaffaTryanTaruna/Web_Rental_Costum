<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        if($data['role']=="admin"){
            $_SESSION['admin'] = $data;
            $_SESSION['email'] = $email;
            header("Location: ../admin/admin.php");
        } else if($data['role']=="user"){
            $_SESSION['user'] = $data;
            $_SESSION['email'] = $email;
            header("Location: ../dashboard/user.php");
        }
        exit;
    } else {
        echo "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (isset($_GET['success'])) echo "<p style='color:green;'>Registrasi berhasil! Silakan login.</p>"; ?>
<form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<p>Belum punya akun? <a href="register.php">Daftar</a></p>
</body>
</html>
