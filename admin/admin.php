<?php
require_once '../config/database.php';

// Cek apakah user sudah login dan berperan sebagai 'user'
if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}