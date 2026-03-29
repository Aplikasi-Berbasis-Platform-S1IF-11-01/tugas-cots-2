const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();

app.set('view engine', 'ejs');
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const DATA_FILE = './data.json';

// Fungsi baca/tulis data
const readData = () => {
    try {
        return JSON.parse(fs.readFileSync(DATA_FILE, 'utf8'));
    } catch (err) {
        return [];
    }
};
const writeData = (data) => fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));

// --- ROUTES ---

// 1. READ (Halaman Utama)
app.get('/', (req, res) => res.render('index'));

// 2. CREATE & UPDATE (Halaman Form)
app.get('/form', (req, res) => {
    const id = req.query.id;
    let editData = null;
    if (id) {
        const products = readData();
        editData = products.find(p => p.id == id);
    }
    res.render('form', { editData });
});

// API JSON untuk DataTables
app.get('/api/produk', (req, res) => {
    res.json({ data: readData() });
});

// Proses Simpan (Create & Update)
app.post('/api/produk', (req, res) => {
    let products = readData();
    const { id, nama, kategori, harga } = req.body;

    if (id) { // Jika ada ID, berarti UPDATE
        const index = products.findIndex(p => p.id == id);
        if (index !== -1) {
            products[index] = { id: parseInt(id), nama, kategori, harga: parseInt(harga) };
        }
    } else { // Jika tidak ada ID, berarti CREATE
        products.push({ id: Date.now(), nama, kategori, harga: parseInt(harga) });
    }
    
    writeData(products);
    res.redirect('/');
});

// 3. DELETE
app.get('/api/produk/delete/:id', (req, res) => {
    let products = readData();
    products = products.filter(p => p.id != req.params.id);
    writeData(products);
    res.redirect('/');
});

app.listen(3000, () => console.log('Server running: http://localhost:3000'));