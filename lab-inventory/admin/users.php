<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../config/database.php';

if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "INSERT INTO users (nama, username, password, role) VALUES ('$nama','$username','$password','$role')");
}

if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username', password='$password', role='$role' WHERE id=$id");
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
}

$users = mysqli_query($conn, 'SELECT * FROM users ORDER BY id DESC');
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Pengguna</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle"></i> Tambah</button>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>ID</th><th>Nama</th><th>Username</th><th>Password</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?= $u['id']; ?></td><td><?= htmlspecialchars($u['nama']); ?></td><td><?= htmlspecialchars($u['username']); ?></td><td><?= htmlspecialchars($u['password']); ?></td><td><span class="badge bg-info text-dark"><?= $u['role']; ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $u['id']; ?>">Edit</button>
                        <a href="?hapus=<?= $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?')">Hapus</a>
                    </td>
                </tr>
                <div class="modal fade" id="edit<?= $u['id']; ?>"><div class="modal-dialog"><form method="post" class="modal-content"><div class="modal-header"><h5>Edit Pengguna</h5></div><div class="modal-body">
                    <input type="hidden" name="id" value="<?= $u['id']; ?>">
                    <input class="form-control mb-2" name="nama" value="<?= htmlspecialchars($u['nama']); ?>" required>
                    <input class="form-control mb-2" name="username" value="<?= htmlspecialchars($u['username']); ?>" required>
                    <input class="form-control mb-2" name="password" value="<?= htmlspecialchars($u['password']); ?>" required>
                    <select class="form-select" name="role"><option value="admin" <?= $u['role']==='admin'?'selected':''; ?>>admin</option><option value="user" <?= $u['role']==='user'?'selected':''; ?>>user</option></select>
                </div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button><button class="btn btn-primary" name="edit">Simpan</button></div></form></div></div>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah"><div class="modal-dialog"><form method="post" class="modal-content"><div class="modal-header"><h5>Tambah Pengguna</h5></div><div class="modal-body">
    <input class="form-control mb-2" name="nama" placeholder="Nama" required>
    <input class="form-control mb-2" name="username" placeholder="Username" required>
    <input class="form-control mb-2" name="password" placeholder="Password" required>
    <select class="form-select" name="role" required><option value="">Pilih Role</option><option value="admin">admin</option><option value="user">user</option></select>
</div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button><button class="btn btn-primary" name="tambah">Simpan</button></div></form></div></div>
<?php include '../includes/footer.php'; ?>
