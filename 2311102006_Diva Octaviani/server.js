const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = 3000;

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(bodyParser.json());

app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type');
    if (req.method === 'OPTIONS') return res.sendStatus(200);
    next();
});

app.use(express.static('public'));

const DB_PATH = path.join(__dirname, 'data.json');

const getDB = () => {
    if (!fs.existsSync(DB_PATH)) {
        fs.writeFileSync(DB_PATH, JSON.stringify({ products: [], nextId: 1 }, null, 2));
    }
    return JSON.parse(fs.readFileSync(DB_PATH));
};

const saveDB = (data) => {
    fs.writeFileSync(DB_PATH, JSON.stringify(data, null, 2));
};

// Page Routes
app.get('/', (req, res) => res.render('home'));
app.get('/tambah', (req, res) => res.render('tambah'));
app.get('/produk', (req, res) => res.render('produk'));

// API Routes
app.get('/api/products', (req, res) => {
    const db = getDB();
    res.json({ data: db.products });
});

app.post('/api/products', (req, res) => {
    const db = getDB();
    const { nama, kategori, harga } = req.body;
    const newProduct = { id: db.nextId, nama, kategori, harga: Number(harga) };
    db.products.push(newProduct);
    db.nextId++;
    saveDB(db);
    res.json({ success: true, message: 'Produk ditambahkan' });
});

app.put('/api/products/:id', (req, res) => {
    const db = getDB();
    const id = parseInt(req.params.id);
    const { nama, kategori, harga } = req.body;
    const index = db.products.findIndex(p => p.id === id);
    if (index !== -1) {
        db.products[index] = { id, nama, kategori, harga: Number(harga) };
        saveDB(db);
        res.json({ success: true });
    } else {
        res.status(404).json({ success: false });
    }
});

app.delete('/api/products/:id', (req, res) => {
    const db = getDB();
    const id = parseInt(req.params.id);
    db.products = db.products.filter(p => p.id !== id);
    saveDB(db);
    res.json({ success: true });
});

app.listen(PORT, () => {
    console.log(`Server La'Vabie berjalan di http://localhost:${PORT}`);
});