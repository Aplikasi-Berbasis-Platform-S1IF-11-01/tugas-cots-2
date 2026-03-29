const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = 3000;

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

const dataPath = path.join(__dirname, 'data', 'products.json');

// Fungsi baca data dari file JSON
function readProducts() {
    try {
        const data = fs.readFileSync(dataPath, 'utf8');
        return JSON.parse(data);
    } catch (error) {
        console.error('Gagal membaca products.json:', error);
        return [];
    }
}

// Fungsi simpan data ke file JSON
function writeProducts(data) {
    try {
        fs.writeFileSync(dataPath, JSON.stringify(data, null, 2), 'utf8');
    } catch (error) {
        console.error('Gagal menulis products.json:', error);
    }
}

// ROUTES
app.get('/', (req, res) => {
    res.render('index');
});

app.get('/add', (req, res) => {
    res.render('add');
});

// API JSON untuk DataTables
app.get('/api/skincare', (req, res) => {
    const skincareData = readProducts();
    res.json({ data: skincareData });
});

// CREATE
app.post('/api/skincare', (req, res) => {
    const { nama, brand, kategori, harga } = req.body;

    if (!nama || !brand || !kategori || !harga) {
        return res.status(400).send('Data produk belum lengkap.');
    }

    const skincareData = readProducts();

    const newProduct = {
        id: Date.now().toString(),
        nama: nama.trim(),
        brand: brand.trim(),
        kategori: kategori.trim(),
        harga: Number(harga)
    };

    skincareData.push(newProduct);
    writeProducts(skincareData);

    res.redirect('/');
});

// GET DATA BY ID (Untuk Edit)
app.get('/edit/:id', (req, res) => {
    const skincareData = readProducts();
    const product = skincareData.find(p => p.id === req.params.id);

    if (!product) {
        return res.redirect('/');
    }

    res.render('edit', { product });
});

// UPDATE
app.post('/update/:id', (req, res) => {
    const { nama, brand, kategori, harga } = req.body;
    const skincareData = readProducts();

    const index = skincareData.findIndex(p => p.id === req.params.id);

    if (index === -1) {
        return res.redirect('/');
    }

    if (!nama || !brand || !kategori || !harga) {
        return res.status(400).send('Data produk belum lengkap.');
    }

    skincareData[index] = {
        id: req.params.id,
        nama: nama.trim(),
        brand: brand.trim(),
        kategori: kategori.trim(),
        harga: Number(harga)
    };

    writeProducts(skincareData);

    res.redirect('/');
});

// DELETE
app.get('/delete/:id', (req, res) => {
    let skincareData = readProducts();
    skincareData = skincareData.filter(p => p.id !== req.params.id);
    writeProducts(skincareData);

    res.redirect('/');
});

app.listen(PORT, () => {
    console.log(`Novel Glow Skin aktif di http://localhost:${PORT}`);
});