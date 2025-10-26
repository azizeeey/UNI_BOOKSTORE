<?php include 'includes/header.php'; ?>
<?php include 'config/koneksi.php'; ?>

<h2>Laporan Pengadaan Buku</h2>
<p>Berikut daftar buku dengan stok paling sedikit (<= 20):</p>

<div class="card">
<table class="table table-striped table-hover">
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
        <td><?= htmlspecialchars($row['nama_buku']); ?></td>
        <td><?= htmlspecialchars($row['nama_penerbit']); ?></td>
        <td><?= htmlspecialchars($row['stok']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
