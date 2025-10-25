<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Tambah Buku</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $id = $koneksi->real_escape_string($_POST['id_buku']);
    $kategori = $koneksi->real_escape_string($_POST['kategori']);
    $nama = $koneksi->real_escape_string($_POST['nama_buku']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $idp = $koneksi->real_escape_string($_POST['id_penerbit']);

    $sql = "INSERT INTO buku (id_buku,kategori,nama_buku,harga,stok,id_penerbit) VALUES (
        '$id', '$kategori', '$nama', $harga, $stok, '$idp')";
    if ($koneksi->query($sql)) {
        echo "<meta http-equiv='refresh' content='0; url=admin.php?status=success_add'>";
        exit;
    } else {
        echo '<div class="notification danger">Gagal menyimpan: ' . htmlspecialchars($koneksi->error) . '</div>';
    }
}
?>

<div class="card" style="max-width:720px;">
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
            echo "<option value='".htmlspecialchars($p['id_penerbit'])."'>".htmlspecialchars($p['nama_penerbit'])."</option>";
        }
        ?>
    </select>
    <div style="display:flex;gap:.5rem;">
        <button type="submit" name="simpan" class="btn">Simpan</button>
        <a href="admin.php" class="btn secondary">Batal</a>
    </div>
</form>
</div>
