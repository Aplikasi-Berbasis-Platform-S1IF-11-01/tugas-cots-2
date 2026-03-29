const express = require('express');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(express.static('public'));

app.set('view engine', 'ejs');

let dataAntrian = [
  {
    id: 1,
    nama: 'Ibu Sulastri',
    umur: 61,
    keluhan: 'Cek tekanan darah',
    antrian: 'A-001'
  },
  {
    id: 2,
    nama: 'Bapak Karyono',
    umur: 67,
    keluhan: 'Nyeri sendi',
    antrian: 'A-002'
  },
  {
    id: 3,
    nama: 'Ibu Marni',
    umur: 63,
    keluhan: 'Kontrol gula darah',
    antrian: 'A-003'
  }
];

function generateId2311102001() {
  if (dataAntrian.length === 0) {
    return 1;
  }
  return dataAntrian[dataAntrian.length - 1].id + 1;
}

function generateNomorAntrian() {
  const nomor = dataAntrian.length + 1;
  return `A-${String(nomor).padStart(3, '0')}`;
}

app.get('/', (req, res) => {
  res.render('home');
});

app.get('/form', (req, res) => {
  res.render('form');
});

app.get('/data', (req, res) => {
  res.render('data');
});

app.get('/api/antrian', (req, res) => {
  res.json(dataAntrian);
});

app.get('/api/antrian/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const pasien = dataAntrian.find(item => item.id === id);

  if (!pasien) {
    return res.status(404).json({ message: 'Data tidak ditemukan' });
  }

  res.json(pasien);
});

app.post('/api/antrian', (req, res) => {
  const { nama, umur, keluhan } = req.body;

  if (!nama || !umur || !keluhan) {
    return res.status(400).json({ message: 'Semua field wajib diisi' });
  }

  const dataBaru = {
    id: generateId2311102001(),
    nama,
    umur,
    keluhan,
    antrian: generateNomorAntrian()
  };

  dataAntrian.push(dataBaru);

  res.json({ message: 'Data antrian berhasil ditambahkan' });
});

app.put('/api/antrian/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const { nama, umur, keluhan } = req.body;

  const index = dataAntrian.findIndex(item => item.id === id);

  if (index === -1) {
    return res.status(404).json({ message: 'Data tidak ditemukan' });
  }

  dataAntrian[index] = {
    id,
    nama,
    umur,
    keluhan,
    antrian: dataAntrian[index].antrian
  };

  res.json({ message: 'Data antrian berhasil diupdate' });
});

app.delete('/api/antrian/:id', (req, res) => {
  const id = parseInt(req.params.id);

  dataAntrian = dataAntrian.filter(item => item.id !== id);

  res.json({ message: 'Data antrian berhasil dihapus' });
});

app.listen(port, () => {
  console.log(`Server berjalan di http://localhost:${port}`);
});