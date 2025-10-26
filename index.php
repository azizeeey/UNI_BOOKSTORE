<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Daftar Buku</h2>

<form method="GET" action="" class="mb-4">
    <div class="input-group">
        <input type="text" name="cari" class="form-control" placeholder="Cari nama buku..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
    </div>
</form>

<?php
$cari_raw = isset($_GET['cari']) ? $_GET['cari'] : '';
$cari = $koneksi->real_escape_string($cari_raw);
$query = "SELECT buku.*, penerbit.nama_penerbit AS nama_penerbit 
          FROM buku 
          JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit 
          WHERE buku.nama_buku LIKE '%$cari%'";
$result = $koneksi->query($query);
?>

<div class="card">
<table class="table table-striped table-hover">
    <tr>
        <th>ID Buku</th>
        <th>Kategori</th>
        <th>Nama Buku</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Penerbit</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
        <td><?= htmlspecialchars($row['id_buku']); ?></td>
        <td><?= htmlspecialchars($row['kategori']); ?></td>
        <td><?= htmlspecialchars($row['nama_buku']); ?></td>
        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= htmlspecialchars($row['stok']); ?></td>
        <td><?= htmlspecialchars($row['nama_penerbit']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

<?php include 'includes/footer.php'; ?>
