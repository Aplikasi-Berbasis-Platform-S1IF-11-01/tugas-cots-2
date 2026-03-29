const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const port = 3000;

// ============================================================
// PATH FILE JSON (penyimpanan permanen)
// ============================================================
const DB_PATH = path.join(__dirname, 'mahasiswa.json');

// Helper: baca data dari file JSON
function bacaData() {
    const raw = fs.readFileSync(DB_PATH, 'utf-8');
    return JSON.parse(raw);
}

// Helper: simpan data ke file JSON
function simpanData(data) {
    fs.writeFileSync(DB_PATH, JSON.stringify(data, null, 2), 'utf-8');
}

// ============================================================
// MIDDLEWARE
// ============================================================
app.set('view engine', 'ejs');
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// ============================================================
// ROUTING HALAMAN (3 Halaman Utama)
// ============================================================

// Halaman Tabel Mahasiswa
app.get('/', (req, res) => res.render('index'));

// Halaman Form Tambah
app.get('/tambah', (req, res) => res.render('tambah'));

// Halaman Form Edit
app.get('/edit/:id', (req, res) => {
    const mahasiswa = bacaData();
    const mhs = mahasiswa.find(m => m.id === parseInt(req.params.id));
    if (mhs) res.render('edit', { mhs });
    else res.status(404).send('Data tidak ditemukan');
});

// ============================================================
// REST API ENDPOINTS
// ============================================================

// READ: Ambil semua data → response JSON (untuk DataTables AJAX)
app.get('/api/mahasiswa', (req, res) => {
    const mahasiswa = bacaData();
    res.json({ data: mahasiswa });
});

// CREATE: Tambah data baru → simpan ke mahasiswa.json
app.post('/api/tambah', (req, res) => {
    const mahasiswa = bacaData();
    const { nim, nama, jurusan } = req.body;
    const newId = mahasiswa.length > 0 ? mahasiswa[mahasiswa.length - 1].id + 1 : 1;
    mahasiswa.push({ id: newId, nim, nama, jurusan });
    simpanData(mahasiswa);

    if (req.headers['content-type'] && req.headers['content-type'].includes('application/json')) {
        res.json({ success: true });
    } else {
        res.redirect('/');
    }
});

// UPDATE: Edit data → simpan ke mahasiswa.json
app.post('/api/edit/:id', (req, res) => {
    const mahasiswa = bacaData();
    const id = parseInt(req.params.id);
    const { nim, nama, jurusan } = req.body;
    const index = mahasiswa.findIndex(m => m.id === id);

    if (index !== -1) {
        mahasiswa[index] = { id, nim, nama, jurusan };
        simpanData(mahasiswa);

        if (req.headers['content-type'] && req.headers['content-type'].includes('application/json')) {
            res.json({ success: true });
        } else {
            res.redirect('/');
        }
    } else {
        res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }
});

// DELETE: Hapus data → simpan ke mahasiswa.json
app.delete('/api/hapus/:id', (req, res) => {
    let mahasiswa = bacaData();
    const id = parseInt(req.params.id);
    const sebelum = mahasiswa.length;
    mahasiswa = mahasiswa.filter(m => m.id !== id);

    if (mahasiswa.length < sebelum) {
        simpanData(mahasiswa);
        res.json({ success: true });
    } else {
        res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }
});

// ============================================================
// START SERVER
// ============================================================
app.listen(port, () => {
    console.log(`Aplikasi berjalan di http://localhost:${port}`);
});