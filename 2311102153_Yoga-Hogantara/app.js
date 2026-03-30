const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs'); 
const path = require('path');
const app = express();
const PORT = 3000;

const DATA_FILE = path.join(__dirname, 'data', 'data.json');

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

const readData = () => {
    try {
        const data = fs.readFileSync(DATA_FILE, 'utf8');
        return JSON.parse(data);
    } catch (err) { return []; }
};

const writeData = (data) => {
    fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));
};

// ROUTES
app.get('/', (req, res) => res.render('index'));
app.get('/form', (req, res) => res.render('form'));
app.get('/data', (req, res) => res.render('data'));
app.get('/edit/:id', (req, res) => {
    const students = readData();
    const student = students.find(s => s.id == req.params.id);
    student ? res.render('edit', { student }) : res.redirect('/data');
});

// API
app.get('/api/students', (req, res) => res.json({ data: readData() }));
app.post('/api/students', (req, res) => {
    let students = readData();
    const { id, nama, nim, jurusan } = req.body;
    if (id) {
        const index = students.findIndex(s => s.id == id);
        if (index !== -1) students[index] = { id: Number(id), nama, nim, jurusan };
    } else {
        students.push({ id: Date.now(), nama, nim, jurusan });
    }
    writeData(students); 
    res.json({ message: "Berhasil!" });
});
app.delete('/api/students/:id', (req, res) => {
    let students = readData();
    students = students.filter(s => s.id != req.params.id);
    writeData(students); 
    res.json({ message: "Dihapus!" });
});

app.listen(PORT, () => {
    console.log(`URL: http://localhost:${PORT}`);
  
});