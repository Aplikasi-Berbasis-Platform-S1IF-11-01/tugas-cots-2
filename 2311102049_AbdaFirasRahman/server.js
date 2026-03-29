/**
 * Nama  : Abda Firas Rahman
 * NIM   : 2311102049
 * Kelas : IF-11-REG01
 */
const express = require('express');
const app = express();
const port = 3000;

app.set('view engine', 'ejs');
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

let dataInventaris = [];
app.get('/', (req, res) => res.render('index'));
app.get('/data', (req, res) => res.render('data'));
app.get('/form', (req, res) => res.render('form', { item: null }));

app.get('/edit/:id', (req, res) => {
    const item = dataInventaris.find(i => i.id == req.params.id);
    if (item) {
        res.render('form', { item });
    } else {
        res.redirect('/data');
    }
});

//  Bagian READ
app.get('/api/inventaris', (req, res) => {
    res.json(dataInventaris);
});

// Proses Simpan Data DAN UPDATE
app.post('/simpan', (req, res) => {
    const { id, kode, nama, kategori, kondisi, jumlah } = req.body;

    if (id) {
        // Mode Edit
        const index = dataInventaris.findIndex(i => i.id == id);
        if (index !== -1) {
            dataInventaris[index] = { id: parseInt(id), kode, nama, kategori, kondisi, jumlah: parseInt(jumlah) };
        }
    } else {
        //Generate ID otomatis
        const newId = dataInventaris.length > 0 ? Math.max(...dataInventaris.map(i => i.id)) + 1 : 1;
        dataInventaris.push({ id: newId, kode, nama, kategori, kondisi, jumlah: parseInt(jumlah) });
    }
    res.redirect('/data');
});

// Proses Hapus Data
app.get('/hapus/:id', (req, res) => {
    dataInventaris = dataInventaris.filter(i => i.id != req.params.id);
    res.redirect('/data');
});

app.listen(port, () => {
    console.log(`[SERVER] Running at http://localhost:${port}`);
});