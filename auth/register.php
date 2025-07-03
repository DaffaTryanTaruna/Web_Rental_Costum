<?php
require_once '../config/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Gunakan bcrypt di aplikasi nyata
    $role = $_POST['role'];

    // Cek apakah email sudah digunakan
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FFFADC;
            margin: 0;
            padding: 0;
        }

        .register-container {
            max-width: 420px;
            margin: 80px auto;
            background-color: white;
            border: 2px solid #A4DD00;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #98CD00;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 12px;
            margin-bottom: 18px;
            border: 2px solid #B6F500;
            border-radius: 8px;
            font-size: 16px;
        }

        select {
            padding: 12px;
            margin-bottom: 18px;
            border: 2px solid #B6F500;
            border-radius: 8px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #B6F500;
            color: #333;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #98CD00;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .message.error {
            color: red;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #A4DD00;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Register</h2>

    <?php if (isset($error)): ?>
        <p class="message error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <!-- Gunakan dropdown untuk role agar lebih aman -->
        <select name="role" required>
            <option value="">-- Pilih Peran --</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Daftar</button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>
