const express = require('express');
const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static('public')); 


let mahasiswa = [
    { id: 1, nama: "Dekanjuy", nim: "112233", jurusan: "Teknik Informatika" },
    { id: 2, nama: "Ricul", nim: "445566", jurusan: "Sistem Informasi" }
];



app.get('/api/mahasiswa', (req, res) => {
    res.json(mahasiswa);
});


app.get('/api/mahasiswa/:id', (req, res) => {
    const data = mahasiswa.find(m => m.id === parseInt(req.params.id));
    res.json(data);
});


app.post('/api/mahasiswa', (req, res) => {
    const newData = {
        id: mahasiswa.length > 0 ? mahasiswa[mahasiswa.length - 1].id + 1 : 1,
        nama: req.body.nama,
        nim: req.body.nim,
        jurusan: req.body.jurusan
    };
    mahasiswa.push(newData);
    res.json({ message: "Data berhasil ditambahkan!", data: newData });
});


app.put('/api/mahasiswa/:id', (req, res) => {
    const index = mahasiswa.findIndex(m => m.id === parseInt(req.params.id));
    if (index !== -1) {
        mahasiswa[index] = { id: parseInt(req.params.id), ...req.body };
        res.json({ message: "Data berhasil diupdate!" });
    } else {
        res.status(404).json({ message: "Data tidak ditemukan" });
    }
});


app.delete('/api/mahasiswa/:id', (req, res) => {
    mahasiswa = mahasiswa.filter(m => m.id !== parseInt(req.params.id));
    res.json({ message: "Data berhasil dihapus!" });
});

app.listen(port, () => {
    console.log(`Aplikasi berjalan di http://localhost:${port}`);
});
