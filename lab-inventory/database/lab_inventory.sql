CREATE DATABASE IF NOT EXISTS lab_inventory;
USE lab_inventory;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin','user') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_alat VARCHAR(150) NOT NULL,
    kategori_id INT NULL,
    jumlah_total INT NOT NULL,
    jumlah_tersedia INT NOT NULL,
    kondisi VARCHAR(100) NOT NULL,
    lokasi VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_equipment_category FOREIGN KEY (kategori_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    equipment_id INT NOT NULL,
    jumlah INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NOT NULL,
    status ENUM('menunggu','disetujui','ditolak','dikembalikan') DEFAULT 'menunggu',
    approved_by INT NULL,
    CONSTRAINT fk_borrow_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_borrow_equipment FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE,
    CONSTRAINT fk_borrow_approver FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (nama, username, password, role) VALUES
('Administrator Lab', 'admin', 'admin123', 'admin'),
('Pengguna Lab', 'user', 'user123', 'user')
ON DUPLICATE KEY UPDATE nama=VALUES(nama), password=VALUES(password), role=VALUES(role);

INSERT INTO categories (id, nama_kategori) VALUES
(1, 'Mikrobiologi'),
(2, 'Hematologi'),
(3, 'Kimia Klinik')
ON DUPLICATE KEY UPDATE nama_kategori=VALUES(nama_kategori);

INSERT INTO equipment (nama_alat, kategori_id, jumlah_total, jumlah_tersedia, kondisi, lokasi) VALUES
('Mikroskop Binokuler', 1, 12, 10, 'Baik', 'Lab Mikrobiologi Ruang A'),
('Sentrifus Digital', 2, 8, 6, 'Baik', 'Lab Hematologi Ruang B'),
('Spektrofotometer', 3, 5, 4, 'Sangat Baik', 'Lab Kimia Klinik Ruang C')
;
