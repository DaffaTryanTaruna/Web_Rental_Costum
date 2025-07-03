<?php
require_once '../config/database.php';

// Autentikasi admin
if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Tambah kostum
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_kostum'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // Nama file baru agar unik
    $gambar_baru = uniqid() . '_' . $gambar;

    // Pindahkan file ke folder uploads (folder berada di luar folder admin)
    if (move_uploaded_file($tmp, '../uploads/' . $gambar_baru)) {
        $query = "INSERT INTO kostum (nama_kostum, harga, deskripsi, gambar) 
                  VALUES ('$nama', '$harga', '$deskripsi', '$gambar_baru')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Data berhasil disimpan!";
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar.";
    }
}


// Hapus kostum
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM kostum WHERE id=$id");
    header("Location: admin.php");
    exit;
}

// Ambil Data kostum
$kostum = mysqli_query($conn, "SELECT * FROM kostum");

// Edit kostum
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $result_edit = mysqli_query($conn, "SELECT * FROM kostum WHERE id = $id_edit");
    if (mysqli_num_rows($result_edit) == 1) {
        $edit_data = mysqli_fetch_assoc($result_edit);
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_kostum'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['name'];
        $gambar_baru = uniqid() . '_' . $gambar;
        move_uploaded_file($tmp, '../uploads/' . $gambar_baru);

        $query = "UPDATE kostum SET nama_kostum='$nama', harga='$harga', deskripsi='$deskripsi', gambar='$gambar_baru' WHERE id=$id";
    } else {
        $query = "UPDATE kostum SET nama_kostum='$nama', harga='$harga', deskripsi='$deskripsi' WHERE id=$id";
    }

    $result = mysqli_query($conn, $query);
    header("Location: admin.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - CRUD kostum</title>
    <style>
        .action-bar {
            margin-bottom: 20px;
            margin-top: 20px;
            text-align: left;
        }

        .btn-transaksi {
            background-color: #1abc9c;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-transaksi:hover {
            background-color: #16a085;
        }

        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Container utama */
        .container {
            max-width: 960px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        /* Judul */
        .container h2,
        .container h3 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        /* Formulir */
        .form-box {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .form-box input[type="text"],
        .form-box input[type="number"],
        .form-box input[type="file"],
        .form-box textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: 0.2s;
        }

        .form-box input:focus,
        .form-box textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        .form-box button {
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .form-box button:hover {
            background-color: #2980b9;
        }

        .form-box a {
            display: inline-block;
            margin-top: 5px;
            color: #e74c3c;
            text-decoration: none;
        }

        .form-box a:hover {
            text-decoration: underline;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        td img {
            border-radius: 6px;
        }

        /* Tombol aksi */
        td a {
            margin-right: 8px;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Alert pesan */
        .alert.success {
            background-color: #2ecc71;
            padding: 10px;
            border-radius: 6px;
            color: white;
            margin-bottom: 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }

            .form-box {
                gap: 10px;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            tr {
                margin-bottom: 15px;
            }

            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                font-weight: bold;
                text-align: left;
            }

            th {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php include '../views/layout/header.php'; ?>
    <div class="container">
        <h2>Kelola kostum (Kostum)</h2>
        <?php if (!empty($pesan))
            echo "<p class='alert success'>$pesan</p>"; ?>

        <form method="post" enctype="multipart/form-data" class="form-box">
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
            <input type="text" name="nama_kostum" placeholder="Nama Kostum"
                value="<?= $edit_data['nama_kostum'] ?? '' ?>" required>
            <input type="number" name="harga" placeholder="Harga / Hari" value="<?= $edit_data['harga'] ?? '' ?>"
                required>
            <textarea name="deskripsi" placeholder="Deskripsi Kostum" rows="4"
                required><?= $edit_data['deskripsi'] ?? '' ?></textarea>
            <input type="file" name="gambar" <?= isset($edit_data) ? '' : 'required' ?>>
            <?php if (isset($edit_data)): ?>
                <p><small>Abaikan file jika tidak ingin mengganti gambar.</small></p>
                <button type="submit" name="update">Update Kostum</button>
                <a href="admin.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="tambah">Tambah Kostum</button>
            <?php endif; ?>
        </form>

        
        <div class="action-bar">
            <a href="transaksi.php" class="btn-transaksi">Kelola Transaksi</a>
        </div>

        <h3>Daftar kostum</h3>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($kostum)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama_kostum'] ?></td>
                    <td><?= $row['harga'] ?></td>
                    <td><?= $row['deskripsi'] ?></td>
                    <td>
                        <?php if ($row['gambar']): ?>
                            <img src="../uploads/<?= $row['gambar'] ?>" width="60">
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="?edit=<?= $row['id'] ?>">Edit</a> |
                        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus kostum ini?')">Hapus</a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>