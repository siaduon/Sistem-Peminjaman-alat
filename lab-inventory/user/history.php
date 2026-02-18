<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';
$userId = (int)$_SESSION['user_id'];
$history = mysqli_query($conn, "SELECT b.*, e.nama_alat FROM borrowings b LEFT JOIN equipment e ON e.id=b.equipment_id WHERE b.user_id=$userId ORDER BY b.id DESC");
include '../includes/header.php'; include '../includes/sidebar.php';
?>
<h3 class="mb-3">Riwayat Peminjaman Saya</h3>
<div class="card border-0 shadow-sm"><div class="card-body table-responsive"><table class="table table-bordered"><thead><tr><th>Alat</th><th>Jumlah</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th></tr></thead><tbody>
<?php while($h=mysqli_fetch_assoc($history)): ?>
<tr><td><?= htmlspecialchars($h['nama_alat']); ?></td><td><?= $h['jumlah']; ?></td><td><?= $h['tanggal_pinjam']; ?></td><td><?= $h['tanggal_kembali']; ?></td><td><span class="badge bg-<?= $h['status']==='disetujui'?'success':($h['status']==='menunggu'?'warning text-dark':($h['status']==='ditolak'?'danger':'secondary')); ?>"><?= $h['status']; ?></span></td></tr>
<?php endwhile; ?>
</tbody></table></div></div>
<?php include '../includes/footer.php'; ?>
