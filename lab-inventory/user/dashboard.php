<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';
$userId = (int)$_SESSION['user_id'];
$totalAlat = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) total FROM equipment'))['total'] ?? 0;
$peminjamanSaya = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM borrowings WHERE user_id=$userId"))['total'] ?? 0;
$aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM borrowings WHERE user_id=$userId AND status='disetujui'"))['total'] ?? 0;

include '../includes/header.php'; include '../includes/sidebar.php';
?>
<h3 class="mb-4">Dashboard Pengguna</h3>
<div class="row g-3">
    <div class="col-md-4"><div class="card border-0 shadow-sm stat-card"><div class="card-body"><i class="bi bi-tools text-primary"></i><h6>Total Alat</h6><h3><?= $totalAlat; ?></h3></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm stat-card"><div class="card-body"><i class="bi bi-journal-bookmark text-success"></i><h6>Pengajuan Saya</h6><h3><?= $peminjamanSaya; ?></h3></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm stat-card"><div class="card-body"><i class="bi bi-hourglass-split text-warning"></i><h6>Masih Dipinjam</h6><h3><?= $aktif; ?></h3></div></div></div>
</div>
<?php include '../includes/footer.php'; ?>
