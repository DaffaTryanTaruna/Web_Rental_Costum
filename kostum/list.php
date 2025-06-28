<?php
require_once '../model/KostumModel.php';
$kostum = new KostumModel();
$data = $kostum->getAll();
?>
<h2>Daftar Kostum</h2>
<a href="tambah.php">Tambah Kostum</a><br><br>
<input type="text" id="search" placeholder="Cari kostum...">
<div id="hasil">
<?php foreach ($data as $k): ?>
    <p><?= $k['nama'] ?> - Rp<?= $k['harga'] ?></p>
<?php endforeach; ?>
</div>
<script>
document.getElementById('search').addEventListener('keyup', function() {
    let query = this.value;
    fetch('../ajax/search_kostum.php?q=' + query)
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(k => {
                html += `<p>${k.nama} - Rp${k.harga}</p>`;
            });
            document.getElementById('hasil').innerHTML = html;
        });
});
</script>