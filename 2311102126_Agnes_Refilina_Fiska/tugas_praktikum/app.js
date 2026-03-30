const express = require('express');
const app = express();
const bodyParser = require('body-parser');

// Setting agar bisa baca folder views dan input dari form
app.set('view engine', 'ejs');
app.use(bodyParser.urlencoded({ extended: true }));

// Database Sederhana (Array JSON)
let dataMahasiswa = [
    { id: 1, nama: "Budi Santoso", nim: "2024001", prodi: "Informatika" },
    { id: 2, nama: "Siti Aminah", nim: "2024002", prodi: "Sistem Informasi" }
];

// ROUTE 1: Halaman Utama (Menampilkan Tabel)
app.get('/', (req, res) => {
    res.render('index');
});

// ROUTE 2: API JSON (Wajib sesuai instruksi: DataTables ambil data dari sini)
app.get('/api/mahasiswa', (req, res) => {
    res.json({ data: dataMahasiswa });
});

// ROUTE 3: Halaman Form Tambah Data
app.get('/tambah', (req, res) => {
    res.render('form');
});

// ROUTE 4: Proses Simpan Data (Create)
app.post('/simpan', (req, res) => {
    const { nama, nim, prodi } = req.body;
    dataMahasiswa.push({ id: Date.now(), nama, nim, prodi });
    res.redirect('/');
});

// ROUTE 5: Proses Hapus Data (Delete)
app.get('/hapus/:id', (req, res) => {
    dataMahasiswa = dataMahasiswa.filter(m => m.id != req.params.id);
    res.redirect('/');
});

// ROUTE 6: Proses Update Data (Update)
app.post('/update', (req, res) => {
    const { id, nama, nim, prodi } = req.body;
    const index = dataMahasiswa.findIndex(m => m.id == id);
    if (index !== -1) {
        dataMahasiswa[index] = { id: parseInt(id), nama, nim, prodi };
    }
    res.redirect('/');
});

// Jalankan Server
app.listen(3000, () => {
    console.log('Aplikasi sukses berjalan di http://localhost:3000');
});