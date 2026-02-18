<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';
$msg = '';
if (isset($_POST['pinjam'])) {
    $userId = (int)$_SESSION['user_id'];
    $equipmentId = (int)$_POST['equipment_id'];
    $jumlah = (int)$_POST['jumlah'];
    $tglPinjam = mysqli_real_escape_string($conn, $_POST['tanggal_pinjam']);
    $tglKembali = mysqli_real_escape_string($conn, $_POST['tanggal_kembali']);
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_tersedia FROM equipment WHERE id=$equipmentId"));
    if ($cek && $jumlah > 0 && $jumlah <= $cek['jumlah_tersedia']) {
        mysqli_query($conn, "INSERT INTO borrowings (user_id,equipment_id,jumlah,tanggal_pinjam,tanggal_kembali,status) VALUES ($userId,$equipmentId,$jumlah,'$tglPinjam','$tglKembali','menunggu')");
        $msg = '<div class="alert alert-success">Pengajuan peminjaman berhasil dikirim.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Jumlah pinjam melebihi stok tersedia.</div>';
    }
}
$equipments = mysqli_query($conn, 'SELECT * FROM equipment WHERE jumlah_tersedia > 0 ORDER BY nama_alat');
include '../includes/header.php'; include '../includes/sidebar.php';
?>
<h3 class="mb-3">Pengajuan Peminjaman Alat</h3>
<?= $msg; ?>
<div class="card border-0 shadow-sm"><div class="card-body">
<form method="post" class="row g-3">
    <div class="col-md-6"><label class="form-label">Pilih Alat</label><select class="form-select" name="equipment_id" required><option value="">Pilih Alat</option><?php while($e=mysqli_fetch_assoc($equipments)): ?><option value="<?= $e['id']; ?>"><?= htmlspecialchars($e['nama_alat']); ?> (Stok: <?= $e['jumlah_tersedia']; ?>)</option><?php endwhile; ?></select></div>
    <div class="col-md-3"><label class="form-label">Jumlah</label><input type="number" name="jumlah" class="form-control" min="1" required></div>
    <div class="col-md-3"><label class="form-label">Tanggal Pinjam</label><input type="date" name="tanggal_pinjam" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Tanggal Kembali</label><input type="date" name="tanggal_kembali" class="form-control" required></div>
    <div class="col-12"><button class="btn btn-primary" name="pinjam"><i class="bi bi-send"></i> Pinjam</button></div>
</form>
</div></div>
<?php include '../includes/footer.php'; ?>
