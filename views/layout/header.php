<!-- layouts/header.php -->
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 25px; background-color: #A4DD00; color: #FFFADC; font-family: Arial, sans-serif; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
    <h2 style="margin: 0; font-weight: bold;">RENTAL COSTUM</h2>
    <div>
        <?php if (isset($_SESSION['admin'])): ?>
            <span style="color: #333;">Halo, <?= $_SESSION['admin']['username'] ?? 'Admin' ?></span>
            <a href="../auth/logout.php" style="margin-left: 20px; background-color: #B6F500; color: #333; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-weight: bold;" onmouseover="this.style.backgroundColor='#98CD00'" onmouseout="this.style.backgroundColor='#B6F500'">Logout</a>
        <?php elseif (isset($_SESSION['user'])): ?>
            <span style="color: #333;">Halo, <?= $_SESSION['user']['username'] ?? 'User' ?></span>
            <a href="../auth/logout.php" style="margin-left: 20px; background-color: #B6F500; color: #333; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-weight: bold;" onmouseover="this.style.backgroundColor='#98CD00'" onmouseout="this.style.backgroundColor='#B6F500'">Logout</a>
        <?php else: ?>
            <a href="auth/login.php" style="background-color: #B6F500; color: #333; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-weight: bold;" onmouseover="this.style.backgroundColor='#98CD00'" onmouseout="this.style.backgroundColor='#B6F500'">Login</a>
        <?php endif; ?>
    </div>
</div>
