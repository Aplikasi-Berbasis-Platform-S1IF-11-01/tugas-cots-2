const express = require('express');
const path = require('path');

const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use('/public', express.static(path.join(__dirname, 'public')));

let accessoriesProducts = [
    {
        id: 1,
        nama: 'Kalung Diamond Rose Gold',
        brand: 'Aurora Jewelry',
        kategori: 'Kalung',
        harga: 1250000,
        stok: 5
    },
    {
        id: 2,
        nama: 'Cincin Perak Solitaire',
        brand: 'LuxeJoy',
        kategori: 'Cincin',
        harga: 850000,
        stok: 12
    },
    {
        id: 3,
        nama: 'Jam Tangan Petite Sterling',
        brand: 'Chrono Queen',
        kategori: 'Jam Tangan',
        harga: 1750000,
        stok: 8
    }
];

let nextId = 4;

// Route Halaman Utama
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'home.html'));
});

// Route Halaman Form
app.get('/form', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'form.html'));
});

// Route Halaman Tabel
app.get('/table', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'table.html'));
});

// --- API UNTUK DATATABLES (JSON) ---

// Ambil semua data
app.get('/api/products', (req, res) => {
    res.json(accessoriesProducts);
});

// Ambil 1 data untuk Edit
app.get('/api/products/:id', (req, res) => {
    const id = parseInt(req.params.id);
    const product = accessoriesProducts.find(item => item.id === id);
    if (!product) return res.status(404).json({ message: 'Data tidak ditemukan' });
    res.json(product);
});

// Tambah Data (Create)
app.post('/api/products', (req, res) => {
    const { nama, brand, kategori, harga, stok } = req.body;
    const newProduct = {
        id: nextId++,
        nama,
        brand,
        kategori,
        harga: parseInt(harga),
        stok: parseInt(stok)
    };
    accessoriesProducts.push(newProduct);
    res.json({ message: 'Aksesoris berhasil ditambahkan!' });
});

// Update Data (Update)
app.put('/api/products/:id', (req, res) => {
    const id = parseInt(req.params.id);
    const { nama, brand, kategori, harga, stok } = req.body;
    const index = accessoriesProducts.findIndex(item => item.id === id);
    
    if (index !== -1) {
        accessoriesProducts[index] = { id, nama, brand, kategori, harga: parseInt(harga), stok: parseInt(stok) };
        res.json({ message: 'Data aksesoris berhasil diperbarui!' });
    } else {
        res.status(404).json({ message: 'Gagal update, data tidak ditemukan' });
    }
});

// Hapus Data (Delete)
app.delete('/api/products/:id', (req, res) => {
    const id = parseInt(req.params.id);
    accessoriesProducts = accessoriesProducts.filter(item => item.id !== id);
    res.json({ message: 'Aksesoris berhasil dihapus!' });
});

app.listen(port, () => {
    console.log(`Server GlowJewels berjalan di http://localhost:${port}`);
});