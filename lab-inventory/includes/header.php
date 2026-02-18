<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris dan Peminjaman Alat Laboratorium Kedokteran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/lab-inventory/assets/css/style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="#">
            <i class="bi bi-hospital"></i> Sistem Inventaris Laboratorium
        </a>
        <div class="ms-auto text-white d-flex align-items-center gap-3">
            <span><i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username'] ?? 'Tamu'); ?></span>
            <a href="/lab-inventory/auth/logout.php" class="btn btn-sm btn-outline-light">Keluar</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
