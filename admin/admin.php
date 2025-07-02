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
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // Nama file baru agar unik
    $gambar_baru = uniqid() . '_' . $gambar;

    // Pindahkan file ke folder uploads (folder berada di luar folder admin)
    if (move_uploaded_file($tmp, '../uploads/' . $gambar_baru)) {
        $query = "INSERT INTO kostum (nama_kostum, harga, gambar) 
                  VALUES ('$nama', '$harga', '$gambar_baru')";

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

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['name'];
        $gambar_baru = uniqid() . '_' . $gambar;
        move_uploaded_file($tmp, '../uploads/' . $gambar_baru);

        $query = "UPDATE kostum SET nama_kostum='$nama', harga='$harga', gambar='$gambar_baru' WHERE id=$id";
    } else {
        $query = "UPDATE kostum SET nama_kostum='$nama', harga='$harga' WHERE id=$id";
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
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php include '../dashboard/header.php'; ?>
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
            <input type="file" name="gambar" <?= isset($edit_data) ? '' : 'required' ?>>
            <?php if (isset($edit_data)): ?>
                <p><small>Abaikan file jika tidak ingin mengganti gambar.</small></p>
                <button type="submit" name="update">Update Kostum</button>
                <a href="admin.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="tambah">Tambah Kostum</button>
            <?php endif; ?>
        </form>


        <h3>Daftar kostum</h3>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($kostum)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama_kostum'] ?></td>
                    <td><?= $row['harga'] ?></td>
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