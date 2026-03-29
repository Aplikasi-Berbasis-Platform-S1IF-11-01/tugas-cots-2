const express = require('express');
const fs      = require('fs');
const path    = require('path');

const app  = express();
const PORT = 3000;
const DATA = path.join(__dirname, 'data', 'products.json');

// ── Middleware ──────────────────────────────────────────────
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// ── Helper: baca / tulis JSON ───────────────────────────────
function readData()      { return JSON.parse(fs.readFileSync(DATA, 'utf-8')); }
function writeData(data) { fs.writeFileSync(DATA, JSON.stringify(data, null, 2)); }

// ══════════════════════════════════════════════════════════════
//  PAGES
// ══════════════════════════════════════════════════════════════

// Halaman 1 – Dashboard / Tabel Data
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'index.html'));
});

// Halaman 2 – Form Tambah Produk
app.get('/tambah', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'tambah.html'));
});

// Halaman 3 – Detail Produk
app.get('/detail/:id', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'detail.html'));
});

// Halaman 4 – Form Edit Produk
app.get('/edit/:id', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'edit.html'));
});

// ══════════════════════════════════════════════════════════════
//  API – CRUD
// ══════════════════════════════════════════════════════════════

// READ – ambil semua produk (JSON untuk DataTable)
app.get('/api/products', (req, res) => {
  const products = readData();
  res.json({ data: products });
});

// READ – ambil satu produk by ID
app.get('/api/products/:id', (req, res) => {
  const products = readData();
  const product  = products.find(p => p.id === parseInt(req.params.id));
  if (!product) return res.status(404).json({ error: 'Produk tidak ditemukan' });
  res.json(product);
});

// CREATE – tambah produk baru
app.post('/api/products', (req, res) => {
  const products = readData();
  const { nama, kategori, harga, stok } = req.body;

  if (!nama || !kategori || !harga || !stok) {
    return res.status(400).json({ error: 'Semua field wajib diisi' });
  }

  const newId = products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1;
  const today = new Date().toISOString().split('T')[0];

  const newProduct = {
    id: newId,
    nama: nama.trim(),
    kategori,
    harga: parseInt(harga),
    stok: parseInt(stok),
    createdAt: today
  };

  products.push(newProduct);
  writeData(products);
  res.status(201).json({ success: true, data: newProduct });
});

// UPDATE – edit produk
app.put('/api/products/:id', (req, res) => {
  const products = readData();
  const idx      = products.findIndex(p => p.id === parseInt(req.params.id));
  if (idx === -1) return res.status(404).json({ error: 'Produk tidak ditemukan' });

  const { nama, kategori, harga, stok } = req.body;
  if (!nama || !kategori || !harga || !stok) {
    return res.status(400).json({ error: 'Semua field wajib diisi' });
  }

  products[idx] = {
    ...products[idx],
    nama: nama.trim(),
    kategori,
    harga: parseInt(harga),
    stok: parseInt(stok)
  };

  writeData(products);
  res.json({ success: true, data: products[idx] });
});

// DELETE – hapus produk
app.delete('/api/products/:id', (req, res) => {
  const products = readData();
  const idx      = products.findIndex(p => p.id === parseInt(req.params.id));
  if (idx === -1) return res.status(404).json({ error: 'Produk tidak ditemukan' });

  const deleted = products.splice(idx, 1)[0];
  writeData(products);
  res.json({ success: true, data: deleted });
});

// ── Start Server ────────────────────────────────────────────
app.listen(PORT, () => {
  console.log(`✅ SportZone berjalan di http://localhost:${PORT}`);
});
