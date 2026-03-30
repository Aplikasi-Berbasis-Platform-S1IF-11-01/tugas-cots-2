const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();

app.use(bodyParser.json());
app.use(express.static('public'));

const DATA_FILE = './data/data.json';

// ambil data
app.get('/api/data', (req, res) => {
    const data = JSON.parse(fs.readFileSync(DATA_FILE));
    res.json(data);
});

// tambah data
app.post('/api/data', (req, res) => {
    const data = JSON.parse(fs.readFileSync(DATA_FILE));
    const newItem = req.body;
    newItem.id = Date.now();
    data.push(newItem);

    fs.writeFileSync(DATA_FILE, JSON.stringify(data));
    res.json({message: "Data berhasil ditambah"});
});

// hapus data
app.delete('/api/data/:id', (req, res) => {
    let data = JSON.parse(fs.readFileSync(DATA_FILE));
    data = data.filter(item => item.id != req.params.id);

    fs.writeFileSync(DATA_FILE, JSON.stringify(data));
    res.json({message: "Data dihapus"});
});

// edit data
app.put('/api/data/:id', (req, res) => {
    let data = JSON.parse(fs.readFileSync(DATA_FILE));

    data = data.map(item => {
        if(item.id == req.params.id){
            return { ...item, ...req.body };
        }
        return item;
    });

    fs.writeFileSync(DATA_FILE, JSON.stringify(data));
    res.json({message: "Data diupdate"});
});

app.listen(3000, () => console.log("Server jalan di http://localhost:3000"));
