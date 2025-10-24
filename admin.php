<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Kelola Data Buku</h2>

<!-- Form Tambah Buku -->
<form method="POST" action="">
    <input type="text" name="id_buku" placeholder="ID Buku" required>
    <input type="text" name="kategori" placeholder="Kategori" required>
    <input type="text" name="nama_buku" placeholder="Nama Buku" required>
    <input type="number" name="harga" placeholder="Harga" required>
    <input type="number" name="stok" placeholder="Stok" required>
    <select name="id_penerbit" required>
        <option value="">--Pilih Penerbit--</option>
        <?php
        $penerbit = $koneksi->query("SELECT * FROM penerbit");
        while ($p = $penerbit->fetch_assoc()) {
            echo "<option value='{$p['id_penerbit']}'>{$p['nama']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="tambah">Tambah</button>
</form>

<?php
// Tambah buku
if (isset($_POST['tambah'])) {
    $sql = "INSERT INTO buku VALUES (
        '{$_POST['id_buku']}',
        '{$_POST['kategori']}',
        '{$_POST['nama_buku']}',
        '{$_POST['harga']}',
        '{$_POST['stok']}',
        '{$_POST['id_penerbit']}')";
    if ($koneksi->query($sql)) echo "<p>✅ Buku berhasil ditambahkan!</p>";
}
?>

<!-- Tabel Buku -->
<table border="1" cellpadding="8">
    <tr>
        <th>ID Buku</th>
        <th>Kategori</th>
        <th>Nama Buku</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Penerbit</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = $koneksi->query("SELECT buku.*, penerbit.nama_penerbit AS nama_penerbit FROM buku 
                             JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit");
    while ($row = $data->fetch_assoc()) :
    ?>
    <tr>
        <td><?= $row['id_buku']; ?></td>
        <td><?= $row['kategori']; ?></td>
        <td><?= $row['nama_buku']; ?></td>
        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= $row['stok']; ?></td>
        <td><?= $row['nama_penerbit']; ?></td>
        <td><a href="?hapus=<?= $row['id_buku']; ?>" onclick="return confirm('Hapus buku ini?')">Hapus</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Hapus buku
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM buku WHERE id_buku='$id'");
    echo "<meta http-equiv='refresh' content='0; url=admin.php'>";
}
?>

<?php include 'includes/footer.php'; ?>
