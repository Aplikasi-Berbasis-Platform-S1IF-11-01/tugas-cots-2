/* 2311102138_Rico Ade Pratama */

// [POIN A.2]: Menggunakan Framework NodeJS dengan library Express
const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const port = 3000;

// [POIN A.3]: Konfigurasi EJS sebagai Template Engine untuk merender halaman
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// [POIN A.5]: Path/Jalur utama menuju database file berformat JSON
const dataPath = path.join(__dirname, 'data.json');

/* Helper untuk membaca data dari file JSON */
const readData = () => {
    try {
        const rawData = fs.readFileSync(dataPath, 'utf-8');
        return JSON.parse(rawData);
    } catch (err) {
        return []; 
    }
};

/* Helper untuk menyimpan data kembali ke file JSON Menggunakan format JSON.stringify */
const writeData = (data) => {
    fs.writeFileSync(dataPath, JSON.stringify(data, null, 2), 'utf-8');
};

// [POIN A.3]: ROUTING HALAMAN UTAMA
app.get('/', (req, res) => {
    res.render('index');
}); 

app.get('/tabel', (req, res) => {
    res.render('tabel');
});

app.get('/tambah', (req, res) => {
    res.render('from'); 
});

app.get('/edit/:id', (req, res) => {
    const items = readData();
    const item = items.find(i => i.id == req.params.id);
    if (!item) return res.status(404).send('Data tidak ditemukan');
    res.render('edit', { item: item });
});

// [POIN A.5]: API & FUNGSIONALITAS CRUD

/* [READ]: Endpoint API menyediakan data format JSON dikonsumsi oleh JQuery. */
app.get('/api/produk', (req, res) => {
    res.json({ data: readData() });
});

/* [CREATE]: Proses menambahkan produk baru ke dalam database JSON. */
app.post('/tambah', (req, res) => {
    const items = readData();
    const newItem = {
        id: Date.now(),
        nama: req.body.nama,
        kategori: req.body.kategori,
        stok: Number(req.body.stok) || 0,
        harga: Number(req.body.harga) || 0
    };
    items.push(newItem);
    writeData(items);
    res.redirect('/tabel'); 
});

/* [UPDATE]: Proses memperbarui data produk. */
app.post('/edit/:id', (req, res) => {
    let items = readData();
    const index = items.findIndex(i => i.id == req.params.id);
    if (index !== -1) {
        items[index].nama = req.body.nama;
        items[index].kategori = req.body.kategori;
        items[index].stok = Number(req.body.stok) || 0;
        items[index].harga = Number(req.body.harga) || 0;
        writeData(items);
    }
    res.redirect('/tabel');
});

/* [DELETE]: Proses menghapus data, dipanggil menggunakan metode AJAX DELETE dari JQuery (Poin A.4). */
app.delete('/hapus/:id', (req, res) => {
    let items = readData();
    items = items.filter(i => i.id != req.params.id);
    writeData(items);
    res.json({ success: true, message: 'Data berhasil dihapus dari JSON' });
});

// START SERVER
app.listen(port, () => {
    console.log(`Server jalan di http://localhost:${port}`);
    console.log(`Log: Database JSON siap digunakan.`);
});