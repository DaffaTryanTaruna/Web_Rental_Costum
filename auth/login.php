<?php
require_once '../config/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if ($result->num_rows === 1) {
        $data = $result->fetch_assoc();
        if ($data['role'] == "admin") {
            $_SESSION['admin'] = $data;
            $_SESSION['email'] = $email;
            header("Location: ../admin/admin.php");
        } else if ($data['role'] == "user") {
            $_SESSION['user'] = $data;
            $_SESSION['email'] = $email;
            header("Location: ../dashboard/user.php");
        }
        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FFFADC;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
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

        input[type="email"],
        input[type="password"] {
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

        .message.success {
            color: green;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #A4DD00;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <p class="message error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="message success">Registrasi berhasil! Silakan login.</p>
    <?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar</a>
    </div>
</div>

</body>
</html>
