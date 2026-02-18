<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';

if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_alat']);
    $kategori = (int)$_POST['kategori_id'];
    $total = (int)$_POST['jumlah_total'];
    $tersedia = (int)$_POST['jumlah_tersedia'];
    $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    mysqli_query($conn, "INSERT INTO equipment (nama_alat,kategori_id,jumlah_total,jumlah_tersedia,kondisi,lokasi) VALUES ('$nama',$kategori,$total,$tersedia,'$kondisi','$lokasi')");
}
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_alat']);
    $kategori = (int)$_POST['kategori_id'];
    $total = (int)$_POST['jumlah_total'];
    $tersedia = (int)$_POST['jumlah_tersedia'];
    $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    mysqli_query($conn, "UPDATE equipment SET nama_alat='$nama', kategori_id=$kategori, jumlah_total=$total, jumlah_tersedia=$tersedia, kondisi='$kondisi', lokasi='$lokasi' WHERE id=$id");
}
if (isset($_GET['hapus'])) { $id=(int)$_GET['hapus']; mysqli_query($conn, "DELETE FROM equipment WHERE id=$id"); }

$equipments = mysqli_query($conn, 'SELECT e.*, c.nama_kategori FROM equipment e LEFT JOIN categories c ON c.id=e.kategori_id ORDER BY e.id DESC');
$categories = mysqli_query($conn, 'SELECT * FROM categories ORDER BY nama_kategori');
$catList=[]; while($x=mysqli_fetch_assoc($categories)){$catList[]=$x;}
include '../includes/header.php'; include '../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h3>Data Alat</h3><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEquipment">Tambah</button></div>
<div class="card border-0 shadow-sm"><div class="card-body table-responsive"><table class="table table-hover"><thead><tr><th>Nama Alat</th><th>Kategori</th><th>Total</th><th>Tersedia</th><th>Kondisi</th><th>Lokasi</th><th>Aksi</th></tr></thead><tbody>
<?php while($e=mysqli_fetch_assoc($equipments)): ?>
<tr><td><?= htmlspecialchars($e['nama_alat']); ?></td><td><?= htmlspecialchars($e['nama_kategori'] ?? '-'); ?></td><td><?= $e['jumlah_total']; ?></td><td><?= $e['jumlah_tersedia']; ?></td><td><?= htmlspecialchars($e['kondisi']); ?></td><td><?= htmlspecialchars($e['lokasi']); ?></td><td><button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $e['id']; ?>">Edit</button> <a href="?hapus=<?= $e['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data alat?')">Hapus</a></td></tr>
<div class="modal fade" id="edit<?= $e['id']; ?>"><div class="modal-dialog"><form method="post" class="modal-content"><div class="modal-header"><h5>Edit Data Alat</h5></div><div class="modal-body"><input type="hidden" name="id" value="<?= $e['id']; ?>"><input class="form-control mb-2" name="nama_alat" value="<?= htmlspecialchars($e['nama_alat']); ?>" required><select class="form-select mb-2" name="kategori_id" required><?php foreach($catList as $cat): ?><option value="<?= $cat['id']; ?>" <?= $cat['id']==$e['kategori_id']?'selected':''; ?>><?= htmlspecialchars($cat['nama_kategori']); ?></option><?php endforeach; ?></select><div class="row g-2"><div class="col"><input type="number" class="form-control" name="jumlah_total" value="<?= $e['jumlah_total']; ?>" required></div><div class="col"><input type="number" class="form-control" name="jumlah_tersedia" value="<?= $e['jumlah_tersedia']; ?>" required></div></div><input class="form-control my-2" name="kondisi" value="<?= htmlspecialchars($e['kondisi']); ?>" required><input class="form-control" name="lokasi" value="<?= htmlspecialchars($e['lokasi']); ?>" required></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" name="edit">Simpan</button></div></form></div></div>
<?php endwhile; ?>
</tbody></table></div></div>

<div class="modal fade" id="addEquipment"><div class="modal-dialog"><form method="post" class="modal-content"><div class="modal-header"><h5>Tambah Data Alat</h5></div><div class="modal-body"><input class="form-control mb-2" name="nama_alat" placeholder="Nama Alat" required><select class="form-select mb-2" name="kategori_id" required><option value="">Pilih Kategori</option><?php foreach($catList as $cat): ?><option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['nama_kategori']); ?></option><?php endforeach; ?></select><div class="row g-2"><div class="col"><input type="number" class="form-control" name="jumlah_total" placeholder="Jumlah Total" required></div><div class="col"><input type="number" class="form-control" name="jumlah_tersedia" placeholder="Jumlah Tersedia" required></div></div><input class="form-control my-2" name="kondisi" placeholder="Kondisi" required><input class="form-control" name="lokasi" placeholder="Lokasi" required></div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button><button class="btn btn-primary" name="tambah">Simpan</button></div></form></div></div>
<?php include '../includes/footer.php'; ?>
