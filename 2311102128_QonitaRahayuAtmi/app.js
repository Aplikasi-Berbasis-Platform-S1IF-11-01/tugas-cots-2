// Qonita Rahayu Atmi - 2311102128

const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');
const { v4: uuidv4 } = require('uuid');

const app = express();
const PORT = 3001;
const DATA_FILE = path.join(__dirname, 'data', 'produk.json');

app.use(express.static(path.join(__dirname, 'public')));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Fungsi untuk membaca data
function readData() {
  try { return JSON.parse(fs.readFileSync(DATA_FILE, 'utf-8')); }
  catch (e) { return []; }
}

// Fungsi untuk menulis data
function writeData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), 'utf-8');
}

// API untuk data produk
// Untuk membaca data produk keseluruhan
app.get('/api/produk', (req, res) => {
  res.json({ data: readData() });
});

// Untuk membaca data produk berdasarkan id
app.get('/api/produk/:id', (req, res) => {
  const item = readData().find(p => p.id === req.params.id);
  if (!item) return res.status(404).json({ error: 'Produk tidak ditemukan' });
  res.json(item);
});

// Untuk menambahkan data produk
app.post('/api/produk', (req, res) => {
  const produk = readData();
  const { kode, nama, merk, kategori, harga, stok, satuan, deskripsi, tanggal_masuk } = req.body;
  if (!kode || !nama || !merk || !kategori || harga === undefined || stok === undefined)
    return res.status(400).json({ error: 'Semua field wajib harus diisi!' });
  if (produk.find(p => p.kode === kode))
    return res.status(400).json({ error: 'Kode produk sudah digunakan!' });
  const newItem = {
    id: uuidv4(), kode, nama, merk, kategori,
    harga: parseInt(harga), stok: parseInt(stok),
    satuan: satuan || 'Pcs', deskripsi: deskripsi || '',
    tanggal_masuk: tanggal_masuk || new Date().toISOString().split('T')[0]
  };
  produk.push(newItem);
  writeData(produk);
  res.json({ success: true, message: 'Produk berhasil ditambahkan!', data: newItem });
});

// Untuk memperbarui data produk berdasarkan id
app.put('/api/produk/:id', (req, res) => {
  const produk = readData();
  const idx = produk.findIndex(p => p.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: 'Produk tidak ditemukan' });
  const { kode, nama, merk, kategori, harga, stok, satuan, deskripsi, tanggal_masuk } = req.body;
  if (produk.find(p => p.kode === kode && p.id !== req.params.id))
    return res.status(400).json({ error: 'Kode produk sudah digunakan!' });
  produk[idx] = { ...produk[idx], kode, nama, merk, kategori,
    harga: parseInt(harga), stok: parseInt(stok),
    satuan: satuan || 'Pcs', deskripsi: deskripsi || '', tanggal_masuk };
  writeData(produk);
  res.json({ success: true, message: `Produk "${nama}" berhasil diperbarui!`, data: produk[idx] });
});

// Untuk menghapus data produk berdasarkan id
app.delete('/api/produk/:id', (req, res) => {
  const produk = readData();
  const idx = produk.findIndex(p => p.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: 'Produk tidak ditemukan' });
  const nama = produk[idx].nama;
  produk.splice(idx, 1);
  writeData(produk);
  res.json({ success: true, message: `Produk "${nama}" berhasil dihapus!` });
});

// SPA fallback — semua route ke index.html
// berfungsi untuk memastikan bahwa semua permintaan yang tidak cocok dengan API akan diarahkan ke index.html
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// Menjalankan server
app.listen(PORT, () => {
  console.log(`\nGlowStock berjalan di: http://localhost:${PORT}\n`);
});
