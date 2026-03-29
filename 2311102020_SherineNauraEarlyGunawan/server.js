const express = require('express');
const mysql = require('mysql2');
const path = require('path');
const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static('public'));

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'db_kampus'
});

db.connect((err) => {
    if (err) throw err;
    console.log('Database Connected!');
});


// READ: Ambil data 
app.get('/api/mahasiswa', (req, res) => {
    db.query('SELECT * FROM mahasiswa ORDER BY id DESC', (err, results) => {
        if (err) throw err;
        res.json({ data: results });
    });
});

// CREATE & UPDATE: Simpan data 
app.post('/api/mahasiswa/save', (req, res) => {
    const { id, nim, nama, jurusan } = req.body;
    if (id) {
        const sql = 'UPDATE mahasiswa SET nim=?, nama=?, jurusan=? WHERE id=?';
        db.query(sql, [nim, nama, jurusan, id], () => res.json({ status: 'success' }));
    } else {
        const sql = 'INSERT INTO mahasiswa (nim, nama, jurusan) VALUES (?, ?, ?)';
        db.query(sql, [nim, nama, jurusan], () => res.json({ status: 'success' }));
    }
});

// DELETE: Hapus data
app.post('/api/mahasiswa/delete/:id', (req, res) => {
    db.query('DELETE FROM mahasiswa WHERE id = ?', [req.params.id], () => {
        res.json({ status: 'success' });
    });
});

const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server nyala di: http://localhost:${PORT}`);
});