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
    $stok_limit = 20;
    $stmt = $koneksi->prepare("SELECT buku.nama_buku, penerbit.nama_penerbit AS nama_penerbit, buku.stok 
                           FROM buku 
                           JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit
                           WHERE buku.stok <= ?
                           ORDER BY buku.stok ASC");
    $stmt->bind_param("i", $stok_limit);
    $stmt->execute();
    $result = $stmt->get_result();
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
