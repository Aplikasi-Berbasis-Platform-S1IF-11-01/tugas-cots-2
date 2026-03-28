const express = require("express");
const path = require("path");
const fs = require("fs");
const methodOverride = require("method-override");

const app = express();
const PORT = 3000;
const DATA_FILE = path.join(__dirname, "data", "mahasiswa.json");

// Middleware
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(methodOverride("_method"));
app.use(express.static(path.join(__dirname, "public")));

// EJS
app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

// Fungsi baca data JSON
function readData() {
  try {
    const data = fs.readFileSync(DATA_FILE, "utf-8");
    return JSON.parse(data);
  } catch (error) {
    return [];
  }
}

// Fungsi simpan data JSON
function writeData(data) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(data, null, 2), "utf-8");
}

// Fungsi buat ID unik sederhana
function generateId() {
  return Date.now().toString();
}

// =====================
// ROUTE HALAMAN
// =====================

// Beranda
app.get("/", (req, res) => {
  res.render("index", { title: "Beranda" });
});

// Halaman form input
app.get("/mahasiswa/form", (req, res) => {
  res.render("form", { title: "Form Input Mahasiswa" });
});

// Halaman data tabel
app.get("/mahasiswa/data", (req, res) => {
  res.render("data", { title: "Data Mahasiswa" });
});

// Halaman edit
app.get("/mahasiswa/edit/:id", (req, res) => {
  const mahasiswa = readData();
  const data = mahasiswa.find((item) => item.id === req.params.id);

  if (!data) {
    return res.status(404).send("Data tidak ditemukan");
  }

  res.render("edit", {
    title: "Edit Data Mahasiswa",
    mahasiswa: data
  });
});

// =====================
// ROUTE API / CRUD
// =====================

// READ JSON untuk DataTables
app.get("/api/mahasiswa", (req, res) => {
  const mahasiswa = readData();
  res.json({ data: mahasiswa });
});

// CREATE
app.post("/mahasiswa", (req, res) => {
  const mahasiswa = readData();

  const dataBaru = {
    id: generateId(),
    nim: req.body.nim,
    nama: req.body.nama,
    jurusan: req.body.jurusan,
    angkatan: req.body.angkatan,
    email: req.body.email
  };

  mahasiswa.push(dataBaru);
  writeData(mahasiswa);

  res.redirect("/mahasiswa/data");
});

// UPDATE
app.put("/mahasiswa/:id", (req, res) => {
  const mahasiswa = readData();
  const index = mahasiswa.findIndex((item) => item.id === req.params.id);

  if (index === -1) {
    return res.status(404).send("Data tidak ditemukan");
  }

  mahasiswa[index] = {
    ...mahasiswa[index],
    nim: req.body.nim,
    nama: req.body.nama,
    jurusan: req.body.jurusan,
    angkatan: req.body.angkatan,
    email: req.body.email
  };

  writeData(mahasiswa);
  res.redirect("/mahasiswa/data");
});

// DELETE
app.delete("/mahasiswa/:id", (req, res) => {
  const mahasiswa = readData();
  const hasilFilter = mahasiswa.filter((item) => item.id !== req.params.id);

  writeData(hasilFilter);
  res.redirect("/mahasiswa/data");
});

// Jalankan server
app.listen(PORT, () => {
  console.log(`Server berjalan di http://localhost:${PORT}`);
});