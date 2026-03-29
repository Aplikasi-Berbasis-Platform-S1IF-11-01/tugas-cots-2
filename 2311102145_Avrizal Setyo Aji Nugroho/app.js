const express = require("express");
const app = express();
const bodyParser = require("body-parser");

app.set("view engine", "ejs");
app.use(bodyParser.urlencoded({ extended: true }));

// Data dummy 
let dataMahasiswa = [
  { id: 1, nama: "Avrizal Setyo Aji Nugroho", nim: "2311102145", kelas: "APLIKASI BERBASIS PLATFORM PS1IF-11-REG01" },
];

// Halaman Utama: Tabel Data
app.get("/", (req, res) => res.render("index"));

// Halaman Form: Input Data
app.get("/tambah", (req, res) => res.render("tambah"));

// Endpoint JSON: Wajib untuk DataTables
app.get("/api/data", (req, res) => res.json({ data: dataMahasiswa }));

// Proses Simpan Data (Create)
// Halaman Tambah
app.get('/tambah', (req, res) => {
    res.render('tambah'); // Render file tambah.ejs
});

// Halaman Edit (Ambil data dulu)
app.get('/edit/:id', (req, res) => {
    const data = dataMahasiswa.find(d => d.id == req.params.id);
    res.render('edit', { data: data }); // Render file edit.ejs
});

// Route Simpan (Untuk Tambah)
app.post('/simpan', (req, res) => {
    const { nama, nim, kelas } = req.body;
    dataMahasiswa.push({ id: Date.now(), nama, nim, kelas });
    res.redirect('/');
});

// Route Update (Untuk Edit)
app.post('/update', (req, res) => {
    const { id, nama, nim, kelas } = req.body;
    const index = dataMahasiswa.findIndex(d => d.id == id);
    dataMahasiswa[index] = { id: parseInt(id), nama, nim, kelas };
    res.redirect('/');
});

// Proses Hapus (Delete)
app.get("/hapus/:id", (req, res) => {
  dataMahasiswa = dataMahasiswa.filter((d) => d.id != req.params.id);
  res.redirect("/");
});

app.listen(3000, () =>
  console.log("Tugas 2 berjalan di http://localhost:3000"),
);
