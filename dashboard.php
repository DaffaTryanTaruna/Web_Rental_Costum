<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
echo "Selamat datang, " . $_SESSION['nama'];
?>
<ul>
    <li><a href="kostum/list.php">Kelola Kostum</a></li>
    <li><a href="transaksi/sewa.php">Transaksi Sewa</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>