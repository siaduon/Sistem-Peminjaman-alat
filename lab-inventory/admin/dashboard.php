<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../config/database.php';

$totalAlat = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM equipment'))['total'] ?? 0;
$totalPengguna = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'] ?? 0;
$totalPeminjaman = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM borrowings'))['total'] ?? 0;
$totalDipinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(jumlah),0) AS total FROM borrowings WHERE status='disetujui'"))['total'] ?? 0;

include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Dashboard Admin</h3>
</div>
<div class="row g-3">
    <div class="col-md-6 col-xl-3"><div class="card stat-card border-0 shadow-sm"><div class="card-body"><i class="bi bi-tools text-primary"></i><h6>Total Alat</h6><h3><?= $totalAlat; ?></h3></div></div></div>
    <div class="col-md-6 col-xl-3"><div class="card stat-card border-0 shadow-sm"><div class="card-body"><i class="bi bi-people text-success"></i><h6>Total Pengguna</h6><h3><?= $totalPengguna; ?></h3></div></div></div>
    <div class="col-md-6 col-xl-3"><div class="card stat-card border-0 shadow-sm"><div class="card-body"><i class="bi bi-journal-check text-warning"></i><h6>Total Peminjaman</h6><h3><?= $totalPeminjaman; ?></h3></div></div></div>
    <div class="col-md-6 col-xl-3"><div class="card stat-card border-0 shadow-sm"><div class="card-body"><i class="bi bi-box-seam text-danger"></i><h6>Total Alat Dipinjam</h6><h3><?= $totalDipinjam; ?></h3></div></div></div>
</div>
<?php include '../includes/footer.php'; ?>
