const express = require('express');
const path = require('path'); 
const app = express();
const PORT = 4000;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

let products = [
    { id: 1, nama: 'DLSR 750D', kategori: 'Canon', harga: 5000000 },
    { id: 2, nama: 'A6400', kategori: 'SONY', harga: 10000000 },
    { id: 3, nama: 'DLSR 650D', kategori: 'CANON', harga: 4200000 }
];
let nextId = 4;

// 1. READ ALL (Untuk Tabel)
app.get('/api/products', (req, res) => res.json(products));

// 2. READ ONE (Untuk isi form saat Edit)
app.get('/api/products/:id', (req, res) => {
    const product = products.find(p => p.id === parseInt(req.params.id));
    if (product) res.json(product);
    else res.status(404).json({ message: 'Produk tidak ditemukan' });
});

// 3. CREATE
app.post('/api/products', (req, res) => {
    const { nama, kategori, harga } = req.body;
    const newProduct = { id: nextId++, nama, kategori, harga: parseInt(harga) };
    products.push(newProduct);
    res.json({ message: 'Produk berhasil ditambahkan' });
});

// 4. UPDATE
app.put('/api/products/:id', (req, res) => {
    const id = parseInt(req.params.id);
    const index = products.findIndex(p => p.id === id);
    if (index !== -1) {
        products[index] = { id, nama: req.body.nama, kategori: req.body.kategori, harga: parseInt(req.body.harga) };
        res.json({ message: 'Produk berhasil diupdate' });
    }
});

// 5. DELETE
app.delete('/api/products/:id', (req, res) => {
    products = products.filter(p => p.id !== parseInt(req.params.id));
    res.json({ message: 'Produk berhasil dihapus' });
});

app.listen(PORT, () => console.log(`Server jalan di http://localhost:${PORT}`));