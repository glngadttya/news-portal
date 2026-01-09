<?php
require_once 'config/database.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$sql = "
CREATE DATABASE IF NOT EXISTS " . DB_NAME . ";
USE " . DB_NAME . ";

CREATE TABLE IF NOT EXISTS berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(500) NOT NULL,
    link VARCHAR(500) NOT NULL,
    image TEXT,
    category VARCHAR(100),
    date VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE,
    value TEXT
);

INSERT IGNORE INTO settings (name, value) VALUES ('next_update', DATE_ADD(NOW(), INTERVAL 2 HOUR));
";

if ($conn->multi_query($sql)) {
    echo "<h2>Instalasi Berhasil!</h2>";
    echo "<p>Database dan tabel berhasil dibuat.</p>";
    echo "<a href='index.php'>Mulai Portal Berita</a> | ";
    echo "<a href='update.php'>Update Berita Pertama</a>";
} else {
    echo "<h2>Error Instalasi</h2>";
    echo "<p>" . $conn->error . "</p>";
}
?>