const express = require('express');
const cors = require('cors');
const path = require('path');

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// =============================================
// IN-MEMORY DATABASE (simulasi database)
// =============================================
let mahasiswaData = [
  { id: 1, nim: "2021001", nama: "Khalisa Amelia", jurusan: "Teknik Informatika", angkatan: 2021, ipk: 3.75, status: "Aktif" },
  { id: 2, nim: "2021002", nama: "Naya Putwi", jurusan: "Sistem Informasi", angkatan: 2021, ipk: 3.50, status: "Aktif" },
  { id: 3, nim: "2020001", nama: "Liya Khoirunnisa", jurusan: "Teknik Elektro", angkatan: 2020, ipk: 3.90, status: "Aktif" },
];
let nextId = 3;

// =============================================
// REST API ENDPOINTS
// =============================================

// GET semua data (dengan format JSON untuk DataTables)
app.get('/api/mahasiswa', (req, res) => {
  res.json({
    success: true,
    data: mahasiswaData,
    total: mahasiswaData.length
  });
});

// GET data by ID
app.get('/api/mahasiswa/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const mahasiswa = mahasiswaData.find(m => m.id === id);

  if (!mahasiswa) {
    return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  }

  res.json({ success: true, data: mahasiswa });
});

// POST - Create data baru
app.post('/api/mahasiswa', (req, res) => {
  const { nim, nama, jurusan, angkatan, ipk, status } = req.body;

  // Validasi
  if (!nim || !nama || !jurusan || !angkatan) {
    return res.status(400).json({ success: false, message: 'NIM, Nama, Jurusan, dan Angkatan wajib diisi!' });
  }

  // Cek NIM duplikat
  const nimExist = mahasiswaData.find(m => m.nim === nim);
  if (nimExist) {
    return res.status(400).json({ success: false, message: 'NIM sudah terdaftar!' });
  }

  const newMahasiswa = {
    id: nextId++,
    nim,
    nama,
    jurusan,
    angkatan: parseInt(angkatan),
    ipk: parseFloat(ipk) || 0,
    status: status || 'Aktif'
  };

  mahasiswaData.push(newMahasiswa);

  res.status(201).json({
    success: true,
    message: 'Data mahasiswa berhasil ditambahkan!',
    data: newMahasiswa
  });
});

// PUT - Update data
app.put('/api/mahasiswa/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const index = mahasiswaData.findIndex(m => m.id === id);

  if (index === -1) {
    return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  }

  const { nim, nama, jurusan, angkatan, ipk, status } = req.body;

  // Validasi
  if (!nim || !nama || !jurusan || !angkatan) {
    return res.status(400).json({ success: false, message: 'NIM, Nama, Jurusan, dan Angkatan wajib diisi!' });
  }

  // Cek NIM duplikat (kecuali diri sendiri)
  const nimExist = mahasiswaData.find(m => m.nim === nim && m.id !== id);
  if (nimExist) {
    return res.status(400).json({ success: false, message: 'NIM sudah digunakan mahasiswa lain!' });
  }

  mahasiswaData[index] = {
    ...mahasiswaData[index],
    nim,
    nama,
    jurusan,
    angkatan: parseInt(angkatan),
    ipk: parseFloat(ipk) || 0,
    status: status || 'Aktif'
  };

  res.json({
    success: true,
    message: 'Data mahasiswa berhasil diperbarui!',
    data: mahasiswaData[index]
  });
});

// DELETE - Hapus data
app.delete('/api/mahasiswa/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const index = mahasiswaData.findIndex(m => m.id === id);

  if (index === -1) {
    return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  }

  const deleted = mahasiswaData.splice(index, 1)[0];

  res.json({
    success: true,
    message: `Data mahasiswa "${deleted.nama}" berhasil dihapus!`,
    data: deleted
  });
});

// GET statistik untuk dashboard
app.get('/api/statistik', (req, res) => {
  const total = mahasiswaData.length;
  const aktif = mahasiswaData.filter(m => m.status === 'Aktif').length;
  const cuti = mahasiswaData.filter(m => m.status === 'Cuti').length;
  const tidakAktif = mahasiswaData.filter(m => m.status === 'Tidak Aktif').length;
  const avgIpk = total > 0
    ? (mahasiswaData.reduce((sum, m) => sum + m.ipk, 0) / total).toFixed(2)
    : 0;

  const jurusanCount = {};
  mahasiswaData.forEach(m => {
    jurusanCount[m.jurusan] = (jurusanCount[m.jurusan] || 0) + 1;
  });

  res.json({
    success: true,
    data: { total, aktif, cuti, tidakAktif, avgIpk, jurusanCount }
  });
});

// Fallback ke index.html
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.listen(PORT, () => {
  console.log(`\n✅ Server berjalan di http://localhost:${PORT}`);
  console.log(`📋 API tersedia di http://localhost:${PORT}/api/mahasiswa`);
  console.log(`\nTekan Ctrl+C untuk menghentikan server\n`);
});
