<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<?php
if (!isset($_GET['edit'])) {
    echo "<meta http-equiv='refresh' content='0; url=admin.php'>";
    exit;
}

$stmt = $koneksi->prepare("SELECT * FROM buku WHERE id_buku = ?");
$stmt->bind_param("s", $_GET['edit']);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows === 0) {
    echo "<meta http-equiv='refresh' content='0; url=admin.php'>";
    exit;
}
$r = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $stmt = $koneksi->prepare("UPDATE buku SET kategori = ?, nama_buku = ?, harga = ?, stok = ?, id_penerbit = ? WHERE id_buku = ?");
    $stmt->bind_param("ssiiss", $_POST['kategori'], $_POST['nama_buku'], $_POST['harga'], $_POST['stok'], $_POST['id_penerbit'], $_POST['id_buku']);

    if ($stmt->execute()) {
        echo "<meta http-equiv='refresh' content='0; url=admin.php?status=success_update'>";
        exit;
    } else {
        echo '<div class="notification danger">Gagal update: ' . htmlspecialchars($stmt->error) . '</div>';
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
            $penerbit_stmt = $koneksi->prepare("SELECT * FROM penerbit");
            $penerbit_stmt->execute();
            $penerbit = $penerbit_stmt->get_result();
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
