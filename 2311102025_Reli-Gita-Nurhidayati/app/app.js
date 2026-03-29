// ============================================================
// Tugas 2 Praktikum - Aplikasi CRUD Mahasiswa
// NIM  : 2311102025
// Nama : Reli Gita Nurhidayati
// ============================================================

const express = require('express');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = 3000;
const DATA_FILE = path.join(__dirname, 'data', 'mahasiswa.json');

app.set('view engine', 'ejs');
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static('public'));

function readData() { return JSON.parse(fs.readFileSync(DATA_FILE, 'utf-8') || '[]'); }
function writeData(data) { fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2)); }

// Halaman Tabel
app.get('/', (req, res) => res.render('index'));

// API JSON untuk DataTables
app.get('/api/mahasiswa', (req, res) => res.json({ data: readData() }));

// Halaman Form Tambah
app.get('/tambah', (req, res) => res.render('tambah'));

// Simpan data baru
app.post('/tambah', (req, res) => {
    const data = readData();
    const { nim, nama, jurusan, angkatan, ipk } = req.body;
    data.push({ id: Date.now().toString(), nim, nama, jurusan, angkatan, ipk });
    writeData(data);
    res.redirect('/');
});

// Halaman Form Edit
app.get('/edit/:id', (req, res) => {
    const mahasiswa = readData().find(m => m.id === req.params.id);
    if (!mahasiswa) return res.redirect('/');
    res.render('edit', { mahasiswa });
});

// Simpan perubahan
app.post('/edit/:id', (req, res) => {
    const data = readData();
    const idx = data.findIndex(m => m.id === req.params.id);
    if (idx !== -1) {
        const { nim, nama, jurusan, angkatan, ipk } = req.body;
        data[idx] = { ...data[idx], nim, nama, jurusan, angkatan, ipk };
        writeData(data);
    }
    res.redirect('/');
});

// Hapus data
app.post('/hapus/:id', (req, res) => {
    writeData(readData().filter(m => m.id !== req.params.id));
    res.json({ success: true });
});

app.listen(PORT, () => console.log(`Server: http://localhost:${PORT}`));