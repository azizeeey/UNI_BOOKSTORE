<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Tambah Buku</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $stmt = $koneksi->prepare("INSERT INTO buku (id_buku, kategori, nama_buku, harga, stok, id_penerbit) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiis", $_POST['id_buku'], $_POST['kategori'], $_POST['nama_buku'], $_POST['harga'], $_POST['stok'], $_POST['id_penerbit']);

    if ($stmt->execute()) {
        echo "<meta http-equiv='refresh' content='0; url=admin.php?status=success_add'>";
        exit;
    } else {
        echo '<div class="notification danger">Gagal menyimpan: ' . htmlspecialchars($stmt->error) . '</div>';
    }
}
?>

<div class="card" style="max-width:720px;">
<form method="POST" action="">
    <div class="mb-3">
        <input type="text" name="id_buku" class="form-control" placeholder="ID Buku" required>
    </div>
    <div class="mb-3">
        <input type="text" name="kategori" class="form-control" placeholder="Kategori" required>
    </div>
    <div class="mb-3">
        <input type="text" name="nama_buku" class="form-control" placeholder="Nama Buku" required>
    </div>
    <div class="mb-3">
        <input type="number" name="harga" class="form-control" placeholder="Harga" required>
    </div>
    <div class="mb-3">
        <input type="number" name="stok" class="form-control" placeholder="Stok" required>
    </div>
    <div class="mb-3">
        <select name="id_penerbit" class="form-select" required>
            <option value="">--Pilih Penerbit--</option>
            <?php
            $penerbit_stmt = $koneksi->prepare("SELECT * FROM penerbit");
            $penerbit_stmt->execute();
            $penerbit = $penerbit_stmt->get_result();
            while ($p = $penerbit->fetch_assoc()) {
                echo "<option value='".htmlspecialchars($p['id_penerbit'])."'>".htmlspecialchars($p['nama_penerbit'])."</option>";
            }
            ?>
        </select>
    </div>
</form>
</div>
