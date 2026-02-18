<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';
$equipments = mysqli_query($conn, 'SELECT e.*, c.nama_kategori FROM equipment e LEFT JOIN categories c ON c.id=e.kategori_id ORDER BY e.nama_alat');
include '../includes/header.php'; include '../includes/sidebar.php';
?>
<h3 class="mb-3">Daftar Alat Laboratorium</h3>
<div class="card border-0 shadow-sm"><div class="card-body table-responsive"><table class="table table-hover"><thead><tr><th>Nama Alat</th><th>Kategori</th><th>Tersedia</th><th>Kondisi</th><th>Lokasi</th></tr></thead><tbody>
<?php while($e=mysqli_fetch_assoc($equipments)): ?>
<tr><td><?= htmlspecialchars($e['nama_alat']); ?></td><td><?= htmlspecialchars($e['nama_kategori'] ?? '-'); ?></td><td><?= $e['jumlah_tersedia']; ?></td><td><?= htmlspecialchars($e['kondisi']); ?></td><td><?= htmlspecialchars($e['lokasi']); ?></td></tr>
<?php endwhile; ?>
</tbody></table></div></div>
<?php include '../includes/footer.php'; ?>
