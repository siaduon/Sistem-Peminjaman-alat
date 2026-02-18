<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header('Location: ../auth/login.php'); exit; }
require_once '../config/database.php';
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    mysqli_query($conn, "INSERT INTO categories (nama_kategori) VALUES ('$nama')");
}
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    mysqli_query($conn, "UPDATE categories SET nama_kategori='$nama' WHERE id=$id");
}
if (isset($_GET['hapus'])) { $id=(int)$_GET['hapus']; mysqli_query($conn, "DELETE FROM categories WHERE id=$id"); }
$categories = mysqli_query($conn, 'SELECT * FROM categories ORDER BY id DESC');
include '../includes/header.php'; include '../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h3>Kategori</h3><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKategori">Tambah</button></div>
<div class="card border-0 shadow-sm"><div class="card-body table-responsive"><table class="table"><thead><tr><th>ID</th><th>Nama Kategori</th><th>Aksi</th></tr></thead><tbody>
<?php while($c=mysqli_fetch_assoc($categories)): ?>
<tr><td><?= $c['id']; ?></td><td><?= htmlspecialchars($c['nama_kategori']); ?></td><td><button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $c['id']; ?>">Edit</button> <a class="btn btn-sm btn-danger" href="?hapus=<?= $c['id']; ?>" onclick="return confirm('Hapus kategori?')">Hapus</a></td></tr>
<div class="modal fade" id="edit<?= $c['id']; ?>"><div class="modal-dialog"><form class="modal-content" method="post"><div class="modal-header"><h5>Edit Kategori</h5></div><div class="modal-body"><input type="hidden" name="id" value="<?= $c['id']; ?>"><input class="form-control" name="nama_kategori" value="<?= htmlspecialchars($c['nama_kategori']); ?>" required></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" name="edit">Simpan</button></div></form></div></div>
<?php endwhile; ?>
</tbody></table></div></div>
<div class="modal fade" id="addKategori"><div class="modal-dialog"><form class="modal-content" method="post"><div class="modal-header"><h5>Tambah Kategori</h5></div><div class="modal-body"><input class="form-control" name="nama_kategori" placeholder="Nama Kategori" required></div><div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" name="tambah">Simpan</button></div></form></div></div>
<?php include '../includes/footer.php'; ?>
