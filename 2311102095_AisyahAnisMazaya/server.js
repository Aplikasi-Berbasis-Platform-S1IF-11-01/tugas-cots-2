const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const expressLayouts = require('express-ejs-layouts');
const app = express();
/**
 * Nama  : Aisyah Anis Mazaya
 * NIM   : 2311102095
 * Kelas : IF-11-REG01
 */

// Konfigurasi EJS & Layouts
app.use(expressLayouts);
app.set('view engine', 'ejs');
app.set('layout', 'layout');

// Middleware
app.use(express.static('public'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

const DATA_FILE = './data.json';

// Helper untuk baca/tulis JSON
const readData = () => {
    try {
        if (!fs.existsSync(DATA_FILE)) fs.writeFileSync(DATA_FILE, '[]');
        return JSON.parse(fs.readFileSync(DATA_FILE));
    } catch (e) { return []; }
};
const writeData = (data) => fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));

// 1. Halaman Daftar Data (Tabel)
app.get('/', (req, res) => res.render('table'));

// 2. Halaman Form bisa memodifikasi
app.get('/form', (req, res) => {
    const editId = req.query.id; 
    let productToEdit = null;

    if (editId) {
        const products = readData();
        // Cari data 
        productToEdit = products.find(p => p.id == editId);
    }
    // Kirim data ke view. Jika null, berarti form tambah baru.
    res.render('form', { productData: productToEdit });
});

//  Read (Untuk DataTables)
app.get('/api/products', (req, res) => {
    res.json({ data: readData() });
});

//  Create
app.post('/api/products', (req, res) => {
    const products = readData();
    // Gunakan timestamp sebagai ID unik
    const newProduct = { id: Date.now(), ...req.body };
    products.push(newProduct);
    writeData(products);
    res.json({ success: true, message: 'Data berhasil ditambahkan!' });
});

//  Update 
app.put('/api/products/:id', (req, res) => {
    let products = readData();
    const idParam = req.params.id;
    
    // Cari index data yang akan diupdate
    const index = products.findIndex(p => p.id == idParam);
    
    if (index !== -1) {
        // Pertahankan ID lama update sisa datanya
        products[index] = { id: parseInt(idParam), ...req.body };
        writeData(products);
        res.json({ success: true, message: 'Data berhasil diupdate!' });
    } else {
        res.status(404).json({ success: false, message: 'Data tidak ditemukan.' });
    }
});

//  Delete
app.delete('/api/products/:id', (req, res) => {
    let products = readData();
    products = products.filter(p => p.id != req.params.id);
    writeData(products);
    res.json({ success: true });
});

app.listen(3000, () => console.log('Server Toko Picu Muj Muj jalan di http://localhost:3000'));