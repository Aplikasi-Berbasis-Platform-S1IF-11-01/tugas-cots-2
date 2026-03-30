const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const PORT = 3000;

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Database Sementara (Array)
let dataMahasiswa = [
    { id: 1, nama: "Mohammad Alfan", nim: "2311102170", prodi: "S1 Informatika" }
];

// --- ROUTES ---
app.get('/', (req, res) => res.render('index'));

// Endpoint API JSON (Syarat Wajib Poin 5)
app.get('/api/mahasiswa', (req, res) => {
    res.json({ data: dataMahasiswa });
});

app.get('/tambah', (req, res) => res.render('form', { mhs: null }));

app.post('/api/mahasiswa', (req, res) => {
    dataMahasiswa.push({ id: Date.now(), ...req.body });
    res.redirect('/');
});

app.get('/edit/:id', (req, res) => {
    const mhs = dataMahasiswa.find(d => d.id == req.params.id);
    res.render('form', { mhs });
});

app.post('/api/mahasiswa/update/:id', (req, res) => {
    const index = dataMahasiswa.findIndex(d => d.id == req.params.id);
    if (index !== -1) dataMahasiswa[index] = { id: parseInt(req.params.id), ...req.body };
    res.redirect('/');
});

app.get('/api/mahasiswa/delete/:id', (req, res) => {
    dataMahasiswa = dataMahasiswa.filter(d => d.id != req.params.id);
    res.redirect('/');
});

app.listen(PORT, () => console.log(`Server running: http://localhost:${PORT}`));