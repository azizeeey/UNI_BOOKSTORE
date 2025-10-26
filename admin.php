<?php
// tambahkan koneksi sebelum output agar bisa redirect dengan header()
include 'config/koneksi.php';

// Handle delete via POST (dikerjakan sebelum ada output)
// Ganti ke prepared statement dan cek affected_rows
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_confirm'])) {
    $idToDelete = $_POST['hapus_confirm'];
    $stmt = $koneksi->prepare("DELETE FROM buku WHERE id_buku = ?");
    if ($stmt) {
        $stmt->bind_param('s', $idToDelete);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                header('Location: admin.php?status=success_delete');
                exit;
            } else {
                // tidak ada record dihapus
                $stmt->close();
                header('Location: admin.php?status=error');
                exit;
            }
        } else {
            $stmt->close();
            header('Location: admin.php?status=error');
            exit;
        }
    } else {
        header('Location: admin.php?status=error');
        exit;
    }
}

include 'includes/header.php'; 
?>

<h2>Kelola Data Buku</h2>

<?php
// Notification berdasarkan query param (render dengan struktur toast lengkap)
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status === 'success_add') {
        echo '<div class="notification success"><span class="icon">✔</span><span class="msg">Buku berhasil ditambahkan.</span><button type="button" class="close-btn">&times;</button></div>';
    } elseif ($status === 'success_update') {
        echo '<div class="notification success"><span class="icon">✔</span><span class="msg">Buku berhasil diupdate.</span><button type="button" class="close-btn">&times;</button></div>';
    } elseif ($status === 'success_delete') {
        echo '<div class="notification danger"><span class="icon">✔</span><span class="msg">Buku berhasil dihapus.</span><button type="button" class="close-btn">&times;</button></div>';
    } elseif ($status === 'error') {
        echo '<div class="notification danger"><span class="icon">⚠</span><span class="msg">Terjadi kesalahan.</span><button type="button" class="close-btn">&times;</button></div>';
    }
}
?>

<!-- tombol untuk menuju form tambah (redirect ke halaman form) -->
<p>
    <a href="admin_add.php" id="addBtn" class="btn btn-primary">Tambah Buku</a>
</p>

<!-- Modal konfirmasi hapus: ubah menjadi form POST -->
<div id="confirmModal" class="modal" aria-hidden="true" style="display:none;">
    <div class="modal-content card">
        <h3 style="margin-top:0;color:var(--danger)">Konfirmasi Hapus</h3>
        <p>Apakah Anda yakin ingin menghapus buku ini? Aksi ini tidak dapat dikembalikan.</p>
        <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:1rem;">
            <a href="#" id="confirmCancel" class="btn btn-secondary">Batal</a>

            <!-- form POST untuk konfirmasi hapus (pastikan action jelas) -->
            <form method="POST" id="deleteForm" action="admin.php" style="margin:0;">
                <input type="hidden" name="hapus_confirm" id="hapus_confirm" value="">
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Tabel Buku -->
<div class="card">
<table class="table table-striped table-hover">
    <tr>
        <th>ID Buku</th>
        <th>Kategori</th>
        <th>Nama Buku</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Penerbit</th>
        <th>Aksi</th>
    </tr>
    <?php
    $stmt = $koneksi->prepare("SELECT buku.*, penerbit.nama_penerbit AS nama_penerbit FROM buku JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit");
    $stmt->execute();
    $data = $stmt->get_result();
    while ($row = $data->fetch_assoc()) :
    ?>
    <tr>
        <td><?= htmlspecialchars($row['id_buku']); ?></td>
        <td><?= htmlspecialchars($row['kategori']); ?></td>
        <td><?= htmlspecialchars($row['nama_buku']); ?></td>
        <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= htmlspecialchars($row['stok']); ?></td>
        <td><?= htmlspecialchars($row['nama_penerbit']); ?></td>
        <td>
            <a href="admin_edit.php?edit=<?= urlencode($row['id_buku']); ?>" title="Edit" class="btn btn-sm btn-outline-primary" aria-label="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <a href="#" data-id="<?= htmlspecialchars($row['id_buku']); ?>" title="Hapus" class="btn btn-sm btn-outline-danger confirm-delete" aria-label="Hapus">
                <i class="fas fa-trash-alt"></i>
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

<?php include 'includes/footer.php'; ?>
