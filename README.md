# News Portal Website

Website portal berita yang telah dibuat oleh @glngaadttya ini bertujuan untuk digunakan membantu & mempermudah mengerjakan **tugas sekolah**.

---

## ✨ Fitur Utama

- **Auto Create Database** - Database otomatis terbuat saat pertama kali diakses
- **Memberikan Berita Terbaru** - Data berita langsung dari API Kompas terkini
- **Menggunakan Sistem Otomatis** - Update berita otomatis (tanpa perlu menambahkan manual)
- **Design Modern, Simple, Responsive** - Tampilan profesional dengan kategori filter dan mobile-friendly

---

## 📦 Tutorial Instalasi XAMPP

### **Langkah 1: Install XAMPP**
1. Download XAMPP dari [apachefriends.org](https://www.apachefriends.org)
2. Install dengan pengaturan default
3. Biarkan semua komponen terpilih (Apache, MySQL, PHP, phpMyAdmin)

### **Langkah 2: Setup Project**
1. Buka folder XAMPP: `C:\xampp\htdocs\`
2. Buat folder baru: `portal-berita`
3. Copy semua file project ke dalam folder tersebut

### **Langkah 3: Jalankan XAMPP**
1. Buka **XAMPP Control Panel** dari Start Menu
2. Klik **Start** untuk:
   - **Apache** (akan berwarna hijau)
   - **MySQL** (akan berwarna hijau)

### **Langkah 4: Install Database**
1. Buka browser
2. Akses: `http://localhost/portal-berita/install.php`
3. Tunggu sampai muncul pesan "Installation Complete"
4. Klik tombol **Launch News Portal**

### **Langkah 5: Update Berita Pertama**
1. Setelah installasi, portal akan otomatis load berita
2. Jika belum ada berita, akses: `http://localhost/portal-berita/update.php`
3. Tunggu beberapa detik, kemudian kembali ke portal

---

## 🚀 Cara Menggunakan

### **Mengakses Portal:**
- Buka browser
- Ketik: `http://localhost/portal-berita/`
- Portal akan otomatis menampilkan berita terkini

### **Filter Berita:**
- Klik kategori di atas grid berita untuk filter
- Klik **Semua** untuk menampilkan semua berita

### **Membaca Berita:**
- Klik **Baca Artikel** pada card berita
- Artikel akan terbuka di tab baru (website Kompas)

---

## ⚙️ Troubleshooting

### **Masalah 1: Apache tidak bisa start**

``` bash
Error: Apache shutdown unexpectedly
```
**Solusi:**
1. Cek port 80 tidak dipakai
2. Di XAMPP Control Panel → Config → Apache (httpd.conf)
3. Cari `Listen 80` ubah jadi `Listen 8080`
4. Akses: `http://localhost:8080/portal-berita/`

### **Masalah 2: Database error**

``` bash
Table doesn't exist / Connection failed
```

**Solusi:**
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database manual: `portal_berita`
3. Akses install.php lagi

### **Masalah 3: Tidak ada berita muncul**
**Solusi:**
1. Pastikan internet terhubung
2. Akses: `http://localhost/portal-berita/update.php`
3. Refresh halaman portal

### **Masalah 4: Folder tidak ditemukan**
**Solusi:**
1. Pastikan folder ada di `C:\xampp\htdocs\portal-berita\`
2. Cek penamaan folder (case sensitive)

---

## 📁 Struktur Project

``` text
portal-berita/
├── config/
│ └── database.php # Konfigurasi database
├── includes/
│ ├── functions.php # Fungsi utama (fetch API, database)
│ └── init.php # Inisialisasi sistem
├── assets/
│ ├── css/
│ │ └── style.css # Styling profesional
│ └── js/
│ └── script.js # Interaktivitas & auto-update
├── index.php # Halaman utama portal
├── install.php # Setup database otomatis
├── update.php # Update berita manual (hidden)
└── README.md # Dokumentasi ini
```


### © 2026 NewsHub Portal

