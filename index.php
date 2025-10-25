<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Daftar Buku</h2>

<form method="GET" action="">
    <input type="text" name="cari" placeholder="Cari nama buku..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
    <button type="submit">Cari</button>
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

<table>
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

<?php include 'includes/footer.php'; ?>
