// ============================================================
// server.js - File utama aplikasi Node.js Express
// Tugas Praktikum: Aplikasi CRUD Mahasiswa
// ============================================================

// Import modul yang dibutuhkan
const express = require('express');
const path    = require('path');
const fs      = require('fs');

// Inisialisasi aplikasi Express
const app  = express();
const PORT = 3000;

// ============================================================
// MIDDLEWARE - Konfigurasi Express
// ============================================================

// Mengizinkan Express membaca body JSON dari request
app.use(express.json());

// Mengizinkan Express membaca form data (urlencoded)
app.use(express.urlencoded({ extended: true }));

// Menyajikan file statis dari folder "public"
// (CSS, JS, gambar, dll bisa diakses langsung)
app.use(express.static(path.join(__dirname, 'public')));

// ============================================================
// ROUTING - Menghubungkan URL ke file view (halaman HTML)
// ============================================================

// Halaman 1: Dashboard / Beranda
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'index.html'));
});

// Halaman 2: Form Tambah Data
app.get('/form', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'form.html'));
});

// Halaman 3: Tabel Data
app.get('/tabel', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'tabel.html'));
});

// ============================================================
// API ROUTES - Import dari file routes/mahasiswa.js
// Semua endpoint CRUD ada di sini
// ============================================================
const mahasiswaRoutes = require('./routes/mahasiswa');
app.use('/api/mahasiswa', mahasiswaRoutes);

// ============================================================
// JALANKAN SERVER
// ============================================================
app.listen(PORT, () => {
  console.log('===========================================');
  console.log(` Server berjalan di: http://localhost:${PORT}`);
  console.log('===========================================');
  console.log(' Halaman tersedia:');
  console.log(`   - Dashboard : http://localhost:${PORT}/`);
  console.log(`   - Form      : http://localhost:${PORT}/form`);
  console.log(`   - Tabel     : http://localhost:${PORT}/tabel`);
  console.log('===========================================');
});
