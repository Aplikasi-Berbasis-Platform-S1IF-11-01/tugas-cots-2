const express = require("express");
const fs = require("fs");
const path = require("path");

const app = express();
const PORT = 3000;
const dataFile = path.join(__dirname, "data", "products.json");

app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "views"));

app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static(path.join(__dirname, "public")));

function readProducts() {
  try {
    const data = fs.readFileSync(dataFile, "utf8");
    return JSON.parse(data);
  } catch (error) {
    return [];
  }
}

function writeProducts(products) {
  fs.writeFileSync(dataFile, JSON.stringify(products, null, 2), "utf8");
}

function getSummary(products) {
  const totalProduk = products.length;
  const totalHarga = products.reduce((sum, item) => sum + Number(item.harga), 0);
  const kategoriAktif = new Set(products.map((item) => item.kategori.toLowerCase())).size;

  return {
    totalProduk,
    totalHarga,
    kategoriAktif
  };
}

// HALAMAN
app.get("/", (req, res) => {
  const products = readProducts();
  const summary = getSummary(products);
  res.render("dashboard", { title: "Dashboard", summary });
});

app.get("/form", (req, res) => {
  res.render("form", { title: "Form Input Produk" });
});

app.get("/data", (req, res) => {
  res.render("data", { title: "Data Produk" });
});

// API JSON
app.get("/api/products", (req, res) => {
  const products = readProducts();
  res.json({ data: products });
});

app.get("/api/products/:id", (req, res) => {
  const id = Number(req.params.id);
  const products = readProducts();
  const product = products.find((item) => item.id === id);

  if (!product) {
    return res.status(404).json({ message: "Data tidak ditemukan." });
  }

  res.json(product);
});

app.post("/api/products", (req, res) => {
  const { namaProduk, kategori, harga } = req.body;

  if (!namaProduk || !kategori || !harga) {
    return res.status(400).json({ message: "Semua field wajib diisi." });
  }

  const products = readProducts();
  const newProduct = {
    id: Date.now(),
    namaProduk,
    kategori,
    harga: Number(harga)
  };

  products.push(newProduct);
  writeProducts(products);

  res.json({ message: "Data berhasil ditambahkan.", product: newProduct });
});

app.put("/api/products/:id", (req, res) => {
  const id = Number(req.params.id);
  const { namaProduk, kategori, harga } = req.body;

  const products = readProducts();
  const index = products.findIndex((item) => item.id === id);

  if (index === -1) {
    return res.status(404).json({ message: "Data tidak ditemukan." });
  }

  products[index] = {
    id,
    namaProduk,
    kategori,
    harga: Number(harga)
  };

  writeProducts(products);
  res.json({ message: "Data berhasil diupdate." });
});

app.delete("/api/products/:id", (req, res) => {
  const id = Number(req.params.id);
  const products = readProducts();
  const filteredProducts = products.filter((item) => item.id !== id);

  if (filteredProducts.length === products.length) {
    return res.status(404).json({ message: "Data tidak ditemukan." });
  }

  writeProducts(filteredProducts);
  res.json({ message: "Data berhasil dihapus." });
});

app.listen(PORT, () => {
  console.log(`Server berjalan di http://localhost:${PORT}`);
});