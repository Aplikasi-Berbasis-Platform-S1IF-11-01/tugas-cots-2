const express = require('express');
const fs = require('fs');
const app = express();

app.use(express.json({limit: '10mb'}));
app.use(express.static('public'));

const FILE = './data.json';

function readData() {
    try {
        if (!fs.existsSync(FILE)) {
            fs.writeFileSync(FILE, '[]');
        }
        return JSON.parse(fs.readFileSync(FILE));
    } catch {
        return [];
    }
}

function writeData(data) {
    fs.writeFileSync(FILE, JSON.stringify(data, null, 2));
}

// GET
app.get('/api/buah', (req, res) => {
    res.json(readData());
});

// POST
app.post('/api/buah', (req, res) => {
    let data = readData();

    if (!req.body.nama) {
        return res.status(400).json({message:'Nama wajib diisi'});
    }

    const newData = {
        id: Date.now() + Math.floor(Math.random()*1000),
        nama: req.body.nama,
        kategori: req.body.kategori,
        harga: parseInt(req.body.harga) || 0,
        satuan: req.body.satuan || 'kg',
        gambar: req.body.gambar || ''
    };

    data.push(newData);
    writeData(data);

    res.json({message:'Berhasil tambah'});
});

// PUT
app.put('/api/buah/:id', (req, res) => {
    let data = readData();
    let found = false;

    data = data.map(d => {
        if (d.id == req.params.id) {
            found = true;
            return {
                ...d,
                nama: req.body.nama,
                kategori: req.body.kategori,
                harga: parseInt(req.body.harga) || d.harga,
                satuan: req.body.satuan || d.satuan,
                gambar: req.body.gambar || d.gambar
            };
        }
        return d;
    });

    if (!found) {
        return res.status(404).json({message:'Data tidak ditemukan'});
    }

    writeData(data);
    res.json({message:'Berhasil update'});
});

// DELETE
app.delete('/api/buah/:id', (req, res) => {
    let data = readData();
    const newData = data.filter(d => d.id != req.params.id);

    if (newData.length === data.length) {
        return res.status(404).json({message:'Data tidak ditemukan'});
    }

    writeData(newData);
    res.json({message:'Berhasil hapus'});
});

app.listen(3000, () => {
    console.log("Server jalan di http://localhost:3000");
});