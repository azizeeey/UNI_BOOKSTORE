<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Laporan Pengadaan Buku</h2>
<p>Berikut daftar buku dengan stok paling sedikit (<= 20):</p>

<table border="1" cellpadding="8">
    <tr>
        <th>Nama Buku</th>
        <th>Penerbit</th>
        <th>Stok</th>
    </tr>

    <?php
    $query = "SELECT buku.nama_buku, penerbit.nama_penerbit AS nama_penerbit, buku.stok 
              FROM buku 
              JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
              WHERE buku.stok <= 20 
              ORDER BY buku.stok ASC";
    $result = $koneksi->query($query);
    while ($row = $result->fetch_assoc()) :
    ?>
    <tr>
        <td><?= $row['nama_buku']; ?></td>
        <td><?= $row['nama_penerbit']; ?></td>
        <td><?= $row['stok']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
