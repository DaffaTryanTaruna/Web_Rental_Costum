<!-- layouts/header.php -->
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #333; color: white;">
    <h2>Rental Kostum</h2>
    <div>
        <?php if (isset($_SESSION['admin'])): ?>
            <span>Halo, <?= $_SESSION['admin']['username'] ?? 'Admin' ?></span>
            <a href="../auth/logout.php" style="margin-left: 15px; color: red; text-decoration: none;">Logout</a>
        <?php elseif (isset($_SESSION['user'])): ?>
        <span>Halo, <?= $_SESSION['user']['username'] ?? 'User' ?></span>
        <a href="../auth/logout.php" style="margin-left: 15px; color: red; text-decoration: none;">Logout</a>
        <?php else: ?>
            <a href="auth/login.php" style="color: white; text-decoration: none;">Login</a>
        <?php endif; ?>
    </div>
</div>
