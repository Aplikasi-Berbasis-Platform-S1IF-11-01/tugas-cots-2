const express = require("express");
const app = express();
const path = require("path");

app.set("view engine", "ejs");
app.use(express.static(path.join(__dirname, "public")));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Database Dummy (Data Buku)
let dataBuku = [
  {
    id: "1",
    judul: "Bumi",
    kategori: "Fiksi",
    pengarang: "Tere Liye",
    tahun: "2014",
  },
  {
    id: "2",
    judul: "Atomic Habits",
    kategori: "Non-Fiksi",
    pengarang: "James Clear",
    tahun: "2018",
  },
  {
    id: "3",
    judul: "Clean Code",
    kategori: "Teknologi",
    pengarang: "Robert C. Martin",
    tahun: "2008",
  },
];

// --- ROUTES NAVIGASI ---

// 1. DASHBOARD
app.get("/", (req, res) => {
  const totalBuku = dataBuku.length;
  // Menghitung jumlah kategori unik
  const jumlahKategori = [...new Set(dataBuku.map((item) => item.kategori))]
    .length;
  // Contoh filter buku terbitan terbaru (misal di atas 2020)
  const bukuBaru = dataBuku.filter(
    (item) => parseInt(item.tahun) >= 2020,
  ).length;

  res.render("dashboard", {
    page: "dashboard",
    total: totalBuku,
    jumlahKategori: jumlahKategori,
    bukuBaru: bukuBaru,
  });
});

// 2. DAFTAR BUKU
app.get("/buku", (req, res) => {
  res.render("listdata", { page: "buku" });
});

// 3. TAMBAH DATA (Form dengan Dropdown)
app.get("/tambah", (req, res) => {
  res.render("form", { page: "tambah" });
});

// 4. EDIT DATA
app.get("/edit/:id", (req, res) => {
  const buku = dataBuku.find((d) => d.id === req.params.id);
  if (buku) {
    res.render("edit", { item: buku, page: "buku" });
  } else {
    res.status(404).send("Buku tidak ditemukan");
  }
});

// --- API CRUD (JSON) ---
app.get("/api/buku", (req, res) => res.json({ data: dataBuku }));

app.post("/api/buku", (req, res) => {
  const newEntry = { id: Date.now().toString(), ...req.body };
  dataBuku.push(newEntry);
  res.json({ status: "success", message: "Buku berhasil ditambahkan!" });
});

app.put("/api/buku/:id", (req, res) => {
  const index = dataBuku.findIndex((d) => d.id === req.params.id);
  if (index !== -1) {
    dataBuku[index] = { id: req.params.id, ...req.body };
    res.json({ status: "success", message: "Data buku berhasil diperbarui!" });
  } else {
    res.status(404).json({ status: "error" });
  }
});

app.delete("/api/buku/:id", (req, res) => {
  dataBuku = dataBuku.filter((d) => d.id !== req.params.id);
  res.json({ status: "success", message: "Buku berhasil dihapus!" });
});

app.listen(5000, () => console.log("Server running at http://localhost:5000"));
