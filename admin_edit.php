<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<?php
if (!isset($_GET['edit'])) {
    echo "<meta http-equiv='refresh' content='0; url=admin.php'>";
    exit;
}
$idEdit = $koneksi->real_escape_string($_GET['edit']);
$res = $koneksi->query("SELECT * FROM buku WHERE id_buku='$idEdit'");
if (!$res || $res->num_rows === 0) {
    echo "<meta http-equiv='refresh' content='0; url=admin.php'>";
    exit;
}
$r = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $id = $koneksi->real_escape_string($_POST['id_buku']);
    $kategori = $koneksi->real_escape_string($_POST['kategori']);
    $nama = $koneksi->real_escape_string($_POST['nama_buku']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $idp = $koneksi->real_escape_string($_POST['id_penerbit']);

    $sql = "UPDATE buku SET kategori='$kategori', nama_buku='$nama', harga=$harga, stok=$stok, id_penerbit='$idp' WHERE id_buku='$id'";
    if ($koneksi->query($sql)) {
        echo "<meta http-equiv='refresh' content='0; url=admin.php?status=success_update'>";
        exit;
    } else {
        echo '<div class="notification danger">Gagal update: ' . htmlspecialchars($koneksi->error) . '</div>';
    }
}
?>

<h2>Edit Buku</h2>

<div class="card" style="max-width:720px;">
<form method="POST" action="">
    <input type="hidden" name="id_buku" value="<?= htmlspecialchars($r['id_buku']); ?>">
    <div class="mb-3">
        <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($r['kategori']); ?>" required>
    </div>
    <div class="mb-3">
        <input type="text" name="nama_buku" class="form-control" value="<?= htmlspecialchars($r['nama_buku']); ?>" required>
    </div>
    <div class="mb-3">
        <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($r['harga']); ?>" required>
    </div>
    <div class="mb-3">
        <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($r['stok']); ?>" required>
    </div>
    <div class="mb-3">
        <select name="id_penerbit" class="form-select" required>
            <?php
            $penerbit = $koneksi->query("SELECT * FROM penerbit");
            while ($p = $penerbit->fetch_assoc()) {
                $sel = $p['id_penerbit'] == $r['id_penerbit'] ? 'selected' : '';
                echo "<option value='".htmlspecialchars($p['id_penerbit'])."' $sel>".htmlspecialchars($p['nama_penerbit'])."</option>";
            }
            ?>
        </select>
    </div>
    <div style="display:flex;gap:.5rem;">
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        <a href="admin.php" class="btn btn-secondary">Batal</a>
    </div>
</form>
</div>
