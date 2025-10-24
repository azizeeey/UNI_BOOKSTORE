<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Daftar Buku</h2>

<form method="GET" action="">
    <input type="text" name="cari" placeholder="Cari nama buku..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
    <button type="submit">Cari</button>
</form>

<?php
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = "SELECT buku.*, penerbit.nama_penerbit AS nama_penerbit 
          FROM buku 
          JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit 
          WHERE buku.nama_buku LIKE '%$cari%'";

$result = $koneksi->query($query);
?>

<table border="1" cellpadding="8">
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
        <td><?= $row['id_buku']; ?></td>
        <td><?= $row['kategori']; ?></td>
        <td><?= $row['nama_buku']; ?></td>
        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= $row['stok']; ?></td>
        <td><?= $row['nama_penerbit']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
