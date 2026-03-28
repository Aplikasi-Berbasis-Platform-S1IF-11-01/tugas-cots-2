// Nama  : Annisa Al Jauhar
// NIM   : 2311102014
// Kelas : S1 IF-11-REG01

const express = require('express');
const router = express.Router();
const fs = require('fs');
const path = require('path');

const dataPath = path.join(__dirname, '../data/buku.json');

// Fungsi baca data
function readData() {
    const raw = fs.readFileSync(dataPath);
    return JSON.parse(raw);
}

// Fungsi simpan data
function saveData(data) {
    fs.writeFileSync(dataPath, JSON.stringify(data, null, 2));
}

// READ - Halaman utama tampil semua buku
router.get('/', (req, res) => {
    const buku = readData();
    res.render('index', { buku });
});

// Halaman form tambah buku
router.get('/tambah', (req, res) => {
    res.render('tambah');
});

// CREATE - Proses tambah buku
router.post('/tambah', (req, res) => {
    const buku = readData();
    const { judul, pengarang, tahun, genre, stok } = req.body;
    const id = Date.now().toString();
    buku.push({ id, judul, pengarang, tahun, genre, stok });
    saveData(buku);
    res.redirect('/');
});

// Halaman form edit buku
router.get('/edit/:id', (req, res) => {
    const buku = readData();
    const item = buku.find(b => b.id === req.params.id);
    if (!item) return res.redirect('/');
    res.render('edit', { item });
});

// UPDATE - Proses edit buku
router.post('/edit/:id', (req, res) => {
    const buku = readData();
    const index = buku.findIndex(b => b.id === req.params.id);
    if (index !== -1) {
        const { judul, pengarang, tahun, genre, stok } = req.body;
        buku[index] = { id: req.params.id, judul, pengarang, tahun, genre, stok };
        saveData(buku);
    }
    res.redirect('/');
});

// DELETE - Hapus buku
router.post('/hapus/:id', (req, res) => {
    let buku = readData();
    buku = buku.filter(b => b.id !== req.params.id);
    saveData(buku);
    res.redirect('/');
});

// API JSON untuk DataTable
router.get('/api/buku', (req, res) => {
    const buku = readData();
    res.json(buku);
});

module.exports = router;