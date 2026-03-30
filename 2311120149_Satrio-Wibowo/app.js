const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Mapping Object (Database Sementara)
let products = {}; 
let nextId = 1;

// --- RUTE HALAMAN (VIEWS) ---
app.get('/', (req, res) => res.render('index', { page: 'home' }));
app.get('/form', (req, res) => res.render('index', { page: 'form' }));
app.get('/tabel', (req, res) => res.render('index', { page: 'tabel' }));

// --- API CRUD (JSON) ---
app.get('/api/products', (req, res) => res.json({ data: Object.values(products) }));

app.post('/api/products', (req, res) => {
    const id = nextId++;
    const { nama, kategori, harga } = req.body;
    products[id] = { id, nama, kategori, harga: parseInt(harga).toLocaleString('id-ID') };
    res.json({ success: true });
});

app.get('/api/products/:id', (req, res) => res.json(products[req.params.id]));

app.post('/api/products/update/:id', (req, res) => {
    const id = req.params.id;
    const { nama, kategori, harga } = req.body;
    if (products[id]) {
        products[id] = { id, nama, kategori, harga: parseInt(harga).toLocaleString('id-ID') };
        res.json({ success: true });
    }
});

app.delete('/api/products/:id', (req, res) => {
    delete products[req.params.id];
    res.json({ success: true });
});

app.listen(port, () => {
    console.log(`Server jalan di http://localhost:${port}`);
});