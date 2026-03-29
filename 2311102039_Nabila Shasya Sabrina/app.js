const express = require('express');
const fs = require('fs');
const bodyParser = require('body-parser');
const app = express();

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

const DATA_FILE = './data/cheesecake.json';

function readData() {
  return JSON.parse(fs.readFileSync(DATA_FILE));
}

function writeData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2));
}

// ROUTES VIEW
app.get('/', (req, res) => res.render('index'));
app.get('/form', (req, res) => res.render('form'));
app.get('/data', (req, res) => res.render('data'));

app.get('/edit/:id', (req, res) => {
  const data = readData();
  const item = data.find(d => d.id == req.params.id);
  res.render('edit', { item });
});

// API
app.get('/api/cheesecake', (req, res) => {
  res.json(readData());
});

app.post('/api/cheesecake', (req, res) => {
  const data = readData();
  const newItem = {
    id: Date.now(),
    name: req.body.name,
    price: req.body.price,
    stock: req.body.stock
  };
  data.push(newItem);
  writeData(data);
  res.json(newItem);
});

app.put('/api/cheesecake/:id', (req, res) => {
  let data = readData();
  data = data.map(d => d.id == req.params.id ? {
    ...d,
    name: req.body.name,
    price: req.body.price,
    stock: req.body.stock
  } : d);
  writeData(data);
  res.sendStatus(200);
});

app.delete('/api/cheesecake/:id', (req, res) => {
  let data = readData();
  data = data.filter(d => d.id != req.params.id);
  writeData(data);
  res.sendStatus(200);
});

app.listen(3000, () => console.log('http://localhost:3000'));