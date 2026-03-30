const express = require('express');
const app = express();
const path = require('path');

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Mengizinkan akses file statis di folder 'public'
app.use(express.static('public'));

// Data Dummy Sementara (In-Memory Database)
let pets = [
    { id: 1, name: "Snowy", type: "Kucing", breed: "Persia", age: 2, owner: "Shiva" },
    { id: 2, name: "Kimo", type: "Anjing", breed: "Poodle", age: 3, owner: "Nara" }
];

// --- ENDPOINT API (JSON) ---

// 1. READ: Ambil semua data (Format khusus untuk DataTables)
app.get('/api/pets', (req, res) => {
    res.json({ data: pets });
});

// 2. READ: Ambil data spesifik berdasarkan ID
app.get('/api/pets/:id', (req, res) => {
    const pet = pets.find(p => p.id == req.params.id);
    if (!pet) return res.status(404).json({ message: "Hewan tidak ditemukan" });
    res.json(pet);
});

// 3. CREATE: Tambah data hewan baru
app.post('/api/pets', (req, res) => {
    const newPet = {
        id: pets.length > 0 ? Math.max(...pets.map(p => p.id)) + 1 : 1,
        name: req.body.name,
        type: req.body.type,
        breed: req.body.breed,
        age: parseInt(req.body.age),
        owner: req.body.owner
    };
    pets.push(newPet);
    res.status(201).json({ message: "Data hewan berhasil ditambahkan!", pet: newPet });
});

// 4. UPDATE: Ubah data hewan
app.put('/api/pets/:id', (req, res) => {
    const pet = pets.find(p => p.id == req.params.id);
    if (!pet) return res.status(404).json({ message: "Hewan tidak ditemukan" });
    
    pet.name = req.body.name;
    pet.type = req.body.type;
    pet.breed = req.body.breed;
    pet.age = parseInt(req.body.age);
    pet.owner = req.body.owner;
    
    res.json({ message: "Data hewan berhasil diperbarui!", pet });
});

// 5. DELETE: Hapus data hewan
app.delete('/api/pets/:id', (req, res) => {
    const petIndex = pets.findIndex(p => p.id == req.params.id);
    if (petIndex === -1) return res.status(404).json({ message: "Hewan tidak ditemukan" });
    
    pets.splice(petIndex, 1);
    res.json({ message: "Data hewan berhasil dihapus!" });
});

// Jalankan Server
const PORT = 3000;
app.listen(PORT, () => console.log(`Server aktif di http://localhost:${PORT}/data.html`));