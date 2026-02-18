# Sistem Inventaris dan Peminjaman Alat Laboratorium Kedokteran

Aplikasi web berbasis PHP procedural, MySQL, dan Bootstrap 5 untuk manajemen inventaris serta peminjaman alat laboratorium kedokteran.

## Fitur Utama
- Login multi-role (admin dan user) menggunakan session PHP.
- Dashboard admin dan user.
- CRUD Pengguna, Kategori, dan Data Alat (admin).
- Pengajuan peminjaman alat (user).
- Persetujuan, penolakan, dan pengembalian alat (admin).
- Laporan peminjaman.

## Struktur Folder
Semua source code ada di folder `lab-inventory/` sesuai kebutuhan:
- `config/`
- `auth/`
- `admin/`
- `user/`
- `includes/`
- `assets/`
- `database/lab_inventory.sql`

## Cara Menjalankan (XAMPP)
1. Salin folder repo ke `htdocs`.
2. Buka `phpMyAdmin` lalu import `lab-inventory/database/lab_inventory.sql`.
3. Akses: `http://localhost/Sistem-Peminjaman-alat/lab-inventory/`.

## Akun Default
- Admin: `admin / admin123`
- User: `user / user123`
