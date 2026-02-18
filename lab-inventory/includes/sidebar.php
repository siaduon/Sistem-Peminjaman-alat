<?php $isAdmin = ($_SESSION['role'] ?? '') === 'admin'; ?>
<aside class="col-lg-2 col-md-3 sidebar bg-dark text-white min-vh-100 p-3">
    <h6 class="text-uppercase text-secondary">Menu</h6>
    <ul class="nav flex-column gap-1">
        <li class="nav-item"><a class="nav-link text-white" href="<?= $isAdmin ? '/lab-inventory/admin/dashboard.php' : '/lab-inventory/user/dashboard.php'; ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= $isAdmin ? '/lab-inventory/admin/equipment.php' : '/lab-inventory/user/equipment.php'; ?>"><i class="bi bi-tools me-2"></i>Data Alat</a></li>
        <?php if ($isAdmin): ?>
            <li class="nav-item"><a class="nav-link text-white" href="/lab-inventory/admin/categories.php"><i class="bi bi-tags me-2"></i>Kategori</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/lab-inventory/admin/borrowings.php"><i class="bi bi-arrow-left-right me-2"></i>Peminjaman</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/lab-inventory/admin/users.php"><i class="bi bi-people me-2"></i>Pengguna</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/lab-inventory/admin/borrowings.php?laporan=1"><i class="bi bi-clipboard-data me-2"></i>Laporan</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link text-white" href="/lab-inventory/user/borrow.php"><i class="bi bi-journal-plus me-2"></i>Peminjaman</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/lab-inventory/user/history.php"><i class="bi bi-clock-history me-2"></i>Riwayat</a></li>
        <?php endif; ?>
        <li class="nav-item mt-2"><a class="nav-link text-danger" href="/lab-inventory/auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
    </ul>
</aside>
<main class="col-lg-10 col-md-9 p-4">
