const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = 3000;

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

const DATA_FILE = path.join(__dirname, 'data', 'digidaw.json');

function ensureDataFile() {
  const dataDir = path.join(__dirname, 'data');
  if (!fs.existsSync(dataDir)) {
    fs.mkdirSync(dataDir, { recursive: true });
  }

  if (!fs.existsSync(DATA_FILE)) {
    fs.writeFileSync(DATA_FILE, '[]', 'utf8');
  }
}

function readData() {
  ensureDataFile();
  try {
    const raw = fs.readFileSync(DATA_FILE, 'utf8');
    return JSON.parse(raw || '[]');
  } catch (error) {
    console.error('Gagal membaca data JSON:', error.message);
    return [];
  }
}

function writeData(data) {
  ensureDataFile();
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), 'utf8');
}

// Halaman
app.get('/', (req, res) => {
  res.render('index', { title: 'DigiDaw Dashboard' });
});

app.get('/form', (req, res) => {
  res.render('form', { title: 'Form DigiDaw' });
});

app.get('/data', (req, res) => {
  res.render('data', { title: 'Data DigiDaw' });
});

// API JSON untuk DataTables
app.get('/api/items', (req, res) => {
  const items = readData();
  res.json({ data: items });
});

app.get('/api/items/:id', (req, res) => {
  const items = readData();
  const id = Number(req.params.id);
  const item = items.find((i) => Number(i.id) === id);

  if (!item) {
    return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  }

  res.json(item);
});

app.post('/api/items', (req, res) => {
  const items = readData();

  const newId = items.length > 0
    ? Math.max(...items.map((i) => Number(i.id))) + 1
    : 1;

  const newItem = {
    id: newId,
    nama: req.body.nama || '',
    kategori: req.body.kategori || '',
    harga: Number(req.body.harga) || 0,
    status: req.body.status || 'Aktif',
    deskripsi: req.body.deskripsi || ''
  };

  items.push(newItem);
  writeData(items);

  res.json({
    success: true,
    message: 'Data berhasil ditambahkan',
    data: newItem
  });
});

app.put('/api/items/:id', (req, res) => {
  const items = readData();
  const id = Number(req.params.id);
  const index = items.findIndex((i) => Number(i.id) === id);

  if (index === -1) {
    return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  }

  items[index] = {
    ...items[index],
    nama: req.body.nama || items[index].nama,
    kategori: req.body.kategori || items[index].kategori,
    harga: Number(req.body.harga) || 0,
    status: req.body.status || items[index].status,
    deskripsi: req.body.deskripsi || items[index].deskripsi
  };

  writeData(items);

  res.json({
    success: true,
    message: 'Data berhasil diupdate',
    data: items[index]
  });
});

app.delete('/api/items/:id', (req, res) => {
  const items = readData();
  const id = Number(req.params.id);
  const filtered = items.filter((i) => Number(i.id) !== id);

  if (filtered.length === items.length) {
    return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  }

  writeData(filtered);

  res.json({
    success: true,
    message: 'Data berhasil dihapus'
  });
});

app.listen(PORT, () => {
  console.log(`DigiDaw berjalan di http://localhost:${PORT}`);
});