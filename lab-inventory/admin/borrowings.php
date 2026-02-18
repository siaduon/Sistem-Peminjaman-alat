<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';

if (isset($_GET['aksi'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    $aksi = $_GET['aksi'];
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM borrowings WHERE id=$id"));
    if ($data) {
        if ($aksi === 'setujui' && $data['status'] === 'menunggu') {
            mysqli_query($conn, "UPDATE borrowings SET status='disetujui', approved_by=" . (int)$_SESSION['user_id'] . " WHERE id=$id");
            mysqli_query($conn, "UPDATE equipment SET jumlah_tersedia = jumlah_tersedia - " . (int)$data['jumlah'] . " WHERE id=" . (int)$data['equipment_id']);
        } elseif ($aksi === 'tolak' && $data['status'] === 'menunggu') {
            mysqli_query($conn, "UPDATE borrowings SET status='ditolak', approved_by=" . (int)$_SESSION['user_id'] . " WHERE id=$id");
        } elseif ($aksi === 'kembalikan' && $data['status'] === 'disetujui') {
            mysqli_query($conn, "UPDATE borrowings SET status='dikembalikan' WHERE id=$id");
            mysqli_query($conn, "UPDATE equipment SET jumlah_tersedia = jumlah_tersedia + " . (int)$data['jumlah'] . " WHERE id=" . (int)$data['equipment_id']);
        }
    }
}

$borrowings = mysqli_query($conn, "SELECT b.*, u.nama AS nama_user, e.nama_alat, a.nama AS nama_approver
FROM borrowings b
LEFT JOIN users u ON u.id=b.user_id
LEFT JOIN equipment e ON e.id=b.equipment_id
LEFT JOIN users a ON a.id=b.approved_by
ORDER BY b.id DESC");

include '../includes/header.php'; include '../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?= isset($_GET['laporan']) ? 'Laporan Peminjaman' : 'Manajemen Peminjaman'; ?></h3>
</div>
<div class="card border-0 shadow-sm"><div class="card-body table-responsive"><table class="table table-striped align-middle"><thead><tr><th>Peminjam</th><th>Alat</th><th>Jumlah</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th><th>Disetujui Oleh</th><?php if(!isset($_GET['laporan'])): ?><th>Aksi</th><?php endif; ?></tr></thead><tbody>
<?php while($b=mysqli_fetch_assoc($borrowings)): ?>
<tr><td><?= htmlspecialchars($b['nama_user']); ?></td><td><?= htmlspecialchars($b['nama_alat']); ?></td><td><?= $b['jumlah']; ?></td><td><?= $b['tanggal_pinjam']; ?></td><td><?= $b['tanggal_kembali']; ?></td><td><span class="badge bg-<?= $b['status']==='disetujui'?'success':($b['status']==='menunggu'?'warning text-dark':($b['status']==='ditolak'?'danger':'secondary')); ?>"><?= $b['status']; ?></span></td><td><?= htmlspecialchars($b['nama_approver'] ?? '-'); ?></td><?php if(!isset($_GET['laporan'])): ?><td>
<?php if($b['status']==='menunggu'): ?><a href="?aksi=setujui&id=<?= $b['id']; ?>" class="btn btn-sm btn-success">Setujui</a> <a href="?aksi=tolak&id=<?= $b['id']; ?>" class="btn btn-sm btn-danger">Tolak</a><?php elseif($b['status']==='disetujui'): ?><a href="?aksi=kembalikan&id=<?= $b['id']; ?>" class="btn btn-sm btn-primary">Kembalikan</a><?php else: ?>-<?php endif; ?></td><?php endif; ?></tr>
<?php endwhile; ?>
</tbody></table></div></div>
<?php include '../includes/footer.php'; ?>
