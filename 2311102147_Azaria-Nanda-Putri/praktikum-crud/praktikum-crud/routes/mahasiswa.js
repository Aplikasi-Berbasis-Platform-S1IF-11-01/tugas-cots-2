// ============================================================
// routes/mahasiswa.js - Route API untuk data Mahasiswa
// Berisi semua endpoint CRUD (Create, Read, Update, Delete)
// ============================================================

const express = require('express');
const router  = express.Router();
const fs      = require('fs');
const path    = require('path');

// Path ke file data JSON (sebagai "database" sederhana)
const DATA_FILE = path.join(__dirname, '../data/mahasiswa.json');

// ============================================================
// HELPER FUNCTION
// Fungsi pembantu untuk membaca dan menyimpan data JSON
// ============================================================

// Membaca semua data dari file JSON
function bacaData() {
  const isi = fs.readFileSync(DATA_FILE, 'utf8');
  return JSON.parse(isi);
}

// Menyimpan data ke file JSON
function simpanData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), 'utf8');
}

// Membuat ID unik sederhana berdasarkan timestamp
function buatId() {
  return Date.now().toString();
}

// ============================================================
// READ - GET /api/mahasiswa
// Mengambil semua data mahasiswa (untuk DataTables)
// ============================================================
router.get('/', (req, res) => {
  try {
    const data = bacaData();

    // DataTables membutuhkan format respons khusus
    res.json({
      draw: 1,          // Nomor render DataTables
      recordsTotal: data.length,
      recordsFiltered: data.length,
      data: data        // Array data mahasiswa
    });

  } catch (error) {
    res.status(500).json({ success: false, message: 'Gagal membaca data', error: error.message });
  }
});

// ============================================================
// READ SINGLE - GET /api/mahasiswa/:id
// Mengambil satu data mahasiswa berdasarkan ID (untuk form edit)
// ============================================================
router.get('/:id', (req, res) => {
  try {
    const data       = bacaData();
    const mahasiswa  = data.find(m => m.id === req.params.id);

    if (!mahasiswa) {
      return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }

    res.json({ success: true, data: mahasiswa });

  } catch (error) {
    res.status(500).json({ success: false, message: 'Gagal mengambil data', error: error.message });
  }
});

// ============================================================
// CREATE - POST /api/mahasiswa
// Menambah data mahasiswa baru
// ============================================================
router.post('/', (req, res) => {
  try {
    const { nama, nim, jurusan, ipk, email, status } = req.body;

    // Validasi: pastikan field wajib tidak kosong
    if (!nama || !nim || !jurusan || !ipk || !email) {
      return res.status(400).json({ success: false, message: 'Semua field wajib diisi!' });
    }

    const data = bacaData();

    // Cek duplikasi NIM
    const nimSudahAda = data.find(m => m.nim === nim);
    if (nimSudahAda) {
      return res.status(400).json({ success: false, message: 'NIM sudah terdaftar!' });
    }

    // Buat objek mahasiswa baru
    const mahasiswaBaru = {
      id:      buatId(),    // ID unik
      nama:    nama.trim(),
      nim:     nim.trim(),
      jurusan: jurusan.trim(),
      ipk:     ipk,
      email:   email.trim(),
      status:  status || 'Aktif'
    };

    // Tambahkan ke array dan simpan
    data.push(mahasiswaBaru);
    simpanData(data);

    res.status(201).json({ success: true, message: 'Data berhasil ditambahkan!', data: mahasiswaBaru });

  } catch (error) {
    res.status(500).json({ success: false, message: 'Gagal menambah data', error: error.message });
  }
});

// ============================================================
// UPDATE - PUT /api/mahasiswa/:id
// Mengupdate data mahasiswa berdasarkan ID
// ============================================================
router.put('/:id', (req, res) => {
  try {
    const { nama, nim, jurusan, ipk, email, status } = req.body;
    const data = bacaData();

    // Cari index data yang akan diupdate
    const index = data.findIndex(m => m.id === req.params.id);

    if (index === -1) {
      return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }

    // Cek duplikasi NIM (kecuali data sendiri)
    const nimDuplikat = data.find(m => m.nim === nim && m.id !== req.params.id);
    if (nimDuplikat) {
      return res.status(400).json({ success: false, message: 'NIM sudah digunakan mahasiswa lain!' });
    }

    // Update data (gabungkan data lama dengan data baru)
    data[index] = {
      ...data[index],   // Pertahankan field yang tidak diubah
      nama:    nama.trim(),
      nim:     nim.trim(),
      jurusan: jurusan.trim(),
      ipk:     ipk,
      email:   email.trim(),
      status:  status || 'Aktif'
    };

    simpanData(data);

    res.json({ success: true, message: 'Data berhasil diupdate!', data: data[index] });

  } catch (error) {
    res.status(500).json({ success: false, message: 'Gagal mengupdate data', error: error.message });
  }
});

// ============================================================
// DELETE - DELETE /api/mahasiswa/:id
// Menghapus data mahasiswa berdasarkan ID
// ============================================================
router.delete('/:id', (req, res) => {
  try {
    const data  = bacaData();
    const index = data.findIndex(m => m.id === req.params.id);

    if (index === -1) {
      return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }

    // Simpan nama untuk pesan konfirmasi
    const namaMahasiswa = data[index].nama;

    // Hapus data dari array menggunakan splice
    data.splice(index, 1);
    simpanData(data);

    res.json({ success: true, message: `Data ${namaMahasiswa} berhasil dihapus!` });

  } catch (error) {
    res.status(500).json({ success: false, message: 'Gagal menghapus data', error: error.message });
  }
});

module.exports = router;
