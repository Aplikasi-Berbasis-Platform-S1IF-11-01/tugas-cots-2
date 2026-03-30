const express = require('express');
const fs = require('fs');
const path = require('path');
const { v4: uuidv4 } = require('uuid');

const app = express();
const PORT = 3000;
const DATA_FILE = path.join(__dirname, 'data', 'mahasiswa.json');

// ─── Middleware ────────────────────────────────────────────────────────────────
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// ─── Helper: Read & Write JSON ─────────────────────────────────────────────────
function readData() {
  try {
    const raw = fs.readFileSync(DATA_FILE, 'utf-8');
    return JSON.parse(raw);
  } catch {
    return [];
  }
}

function writeData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), 'utf-8');
}

// ─── API Routes ────────────────────────────────────────────────────────────────

// GET all mahasiswa
app.get('/api/mahasiswa', (req, res) => {
  const data = readData();
  res.json({ success: true, data });
});

// GET single mahasiswa by id
app.get('/api/mahasiswa/:id', (req, res) => {
  const data = readData();
  const item = data.find(d => d.id === req.params.id);
  if (!item) return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
  res.json({ success: true, data: item });
});

// POST create mahasiswa
app.post('/api/mahasiswa', (req, res) => {
  const { nim, nama, jurusan, angkatan, ipk, status } = req.body;

  if (!nim || !nama || !jurusan || !angkatan || !ipk || !status) {
    return res.status(400).json({ success: false, message: 'Semua field wajib diisi' });
  }

  const data = readData();

  // Check duplicate NIM
  if (data.find(d => d.nim === nim)) {
    return res.status(409).json({ success: false, message: 'NIM sudah terdaftar' });
  }

  const newItem = {
    id: uuidv4(),
    nim,
    nama,
    jurusan,
    angkatan: parseInt(angkatan),
    ipk: parseFloat(ipk),
    status,
    createdAt: new Date().toISOString()
  };

  data.push(newItem);
  writeData(data);
  res.status(201).json({ success: true, message: 'Data berhasil ditambahkan', data: newItem });
});

// PUT update mahasiswa
app.put('/api/mahasiswa/:id', (req, res) => {
  const { nim, nama, jurusan, angkatan, ipk, status } = req.body;
  const data = readData();
  const idx = data.findIndex(d => d.id === req.params.id);

  if (idx === -1) return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });

  // Check duplicate NIM (exclude self)
  const duplicate = data.find(d => d.nim === nim && d.id !== req.params.id);
  if (duplicate) {
    return res.status(409).json({ success: false, message: 'NIM sudah digunakan oleh mahasiswa lain' });
  }

  data[idx] = {
    ...data[idx],
    nim,
    nama,
    jurusan,
    angkatan: parseInt(angkatan),
    ipk: parseFloat(ipk),
    status,
    updatedAt: new Date().toISOString()
  };

  writeData(data);
  res.json({ success: true, message: 'Data berhasil diperbarui', data: data[idx] });
});

// DELETE mahasiswa
app.delete('/api/mahasiswa/:id', (req, res) => {
  const data = readData();
  const idx = data.findIndex(d => d.id === req.params.id);

  if (idx === -1) return res.status(404).json({ success: false, message: 'Data tidak ditemukan' });

  const deleted = data.splice(idx, 1)[0];
  writeData(data);
  res.json({ success: true, message: 'Data berhasil dihapus', data: deleted });
});

// ─── Root Redirect ─────────────────────────────────────────────────────────────
app.get('/', (req, res) => {
  res.redirect('/table.html');
});

// ─── Start Server ──────────────────────────────────────────────────────────────
app.listen(PORT, () => {
  console.log(`\n🚀  Server berjalan di http://localhost:${PORT}`);
  console.log(`📋  Halaman Tabel  → http://localhost:${PORT}/table.html`);
  console.log(`📝  Halaman Form   → http://localhost:${PORT}/form.html\n`);
});
