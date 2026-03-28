<div align="center">
  <br />

  <h1>LAPORAN PRAKTIKUM <br>
  APLIKASI BERBASIS PLATFORM
  </h1>

  <br />

  <h3>TUGAS COTS 2 <br>
  </h3>

  <br />

  <img width="512" height="512" alt="logo" src="https://github.com/user-attachments/assets/22ae9b17-5e73-48a6-b5dd-281e6c70613e" />


  <br />
  <br />
  <br />

  <h3>Disusun Oleh :</h3>

  <p>
    <strong>Boutefhika Nuha Ziyadatul Khair</strong><br>
    <strong>2311102316</strong><br>
    <strong>S1 IF-11-01</strong>
  </p>

  <br />

  <h3>Dosen Pengampu :</h3>

  <p>
    <strong>Dimas Fanny Hebrasianto Permadi, S.ST., M.Kom</strong>
  </p>
  
  <br />
  <br />
    <h4>Asisten Praktikum :</h4>
    <strong>Apri Pandu Wicaksono </strong> <br>
    <strong>Rangga Pradarrell Fathi</strong>
  <br />

  <h3>LABORATORIUM HIGH PERFORMANCE
 <br>FAKULTAS INFORMATIKA <br>UNIVERSITAS TELKOM PURWOKERTO <br>2026</h3>
</div>

<hr>


# Dasar Teori
**CRUD (Create, Read, Update, Delete)** adalah empat operasi dasar yang digunakan untuk mengelola data dalam suatu aplikasi. Dalam pengembangan web, konsep ini memungkinkan pengguna untuk menambah, menampilkan, mengubah, dan menghapus data secara dinamis melalui interaksi antara client dan server.

**Bootstrap** merupakan framework CSS open-source yang menyediakan berbagai komponen antarmuka siap digunakan, seperti navbar, card, form, tombol, modal, serta sistem grid yang responsif. Dengan Bootstrap, proses pembuatan tampilan menjadi lebih cepat, konsisten, dan modern.

**jQuery** adalah library JavaScript yang dirancang untuk mempermudah manipulasi DOM, pengelolaan event, pembuatan animasi, serta komunikasi AJAX. Sintaksnya yang sederhana membantu developer dalam membangun interaksi dinamis pada halaman web.

**jQuery DataTables** adalah plugin dari jQuery yang digunakan untuk meningkatkan fungsi tabel HTML, seperti fitur pencarian (search), pengurutan data (sorting), dan pagination. Selain itu, DataTables juga mendukung pengambilan data dalam format JSON melalui AJAX.

**JSON (JavaScript Object Notation)** merupakan format pertukaran data yang ringan, terstruktur, dan mudah dibaca. JSON banyak digunakan dalam aplikasi web modern sebagai media komunikasi antara client dan server.

**Node.js** adalah lingkungan runtime JavaScript yang memungkinkan eksekusi kode JavaScript di luar browser, sehingga dapat digunakan untuk membangun aplikasi backend.

**Express JS** merupakan framework backend berbasis Node.js yang digunakan untuk mengembangkan aplikasi web dan REST API. Express menyediakan fitur seperti routing, middleware, serta pengelolaan request dan response. Pada aplikasi ini, Express berperan dalam menangani proses CRUD dan menyediakan endpoint berbasis JSON yang digunakan oleh frontend.

**Chart.js** adalah library JavaScript yang digunakan untuk membuat visualisasi data dalam bentuk grafik interaktif di browser. Dalam aplikasi ini, Chart.js dimanfaatkan pada halaman dashboard untuk menampilkan statistik mahasiswa dalam bentuk bar chart, donut chart, dan line chart.

# Deskripsi Aplikasi
Aplikasi yang dibuat adalah Sistem Data Mahasiswa PuTi berbasis web menggunakan Node.js (Express JS), Bootstrap, jQuery, DataTables, dan Chart.js. Aplikasi ini dirancang untuk memenuhi ketentuan tugas praktikum, yaitu memiliki minimal tiga halaman utama, memanfaatkan data JSON untuk tabel, serta menyediakan fitur CRUD lengkap.

Fitur utama dari aplikasi ini adalah:
* Halaman Form Input Data Mahasiswa
* Halaman Tabel Data Mahasiswa dengan fitur CRUD
* Halaman Dashboard Statistik & Visualisasi Grafik
* Tabel interaktif menggunakan jQuery DataTables
* Visualisasi data menggunakan Chart.js (bar chart, donut chart, line chart)
* Data disimpan pada file JSON lokal (db.json)
* REST API endpoint untuk operasi CRUD

Data mahasiswa disimpan pada file db.json sebagai media penyimpanan sederhana tanpa memerlukan database eksternal.

# Struktur Folder Project


| File / Folder            | Keterangan |
|-------------------------|-----------|
| `server.js`             | File utama server Express JS yang berisi konfigurasi server, middleware, serta seluruh route CRUD REST API. |
| `package.json`          | File konfigurasi project Node.js yang memuat informasi project dan daftar dependency yang digunakan. |
| `data/db.json`          | File penyimpanan data mahasiswa dalam format JSON array yang berfungsi sebagai database sederhana. |
| `public/index.html`     | Halaman Form Input untuk pendaftaran mahasiswa baru, dilengkapi validasi dan stat card ringkasan. |
| `public/data.html`      | Halaman Data Mahasiswa berupa tabel interaktif menggunakan DataTables dengan fitur edit dan hapus (modal Bootstrap). |
| `public/dashboard.html` | Halaman Dashboard yang menampilkan statistik dan visualisasi data mahasiswa menggunakan Chart.js (bar chart, donut chart, dan line chart). |

# Cara Running Aplikasi
1.	Pastikan Node.js sudah terinstal pada laptop.
2.	Buka folder project di terminal atau VS Code.
3.	Install dependency:
    ```
  	npm install
5.	Jalankan Server:
    ```
    node server.js
7.	Buka browser dan akses
    ```
  	http://localhost:3000

# Kode Program
package.json
```
{
  "name": "-input-mahasiswa-baru",
  "version": "1.0.0",
  "description": "Tugas COTS 2",
  "main": "server.js",
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1",
    "start": "node server.js"
  },
  "keywords": [],
  "author": "Boutefhika Nuha Ziyadatul Khair - 2311102316",
  "license": "ISC",
  "type": "commonjs",
  "dependencies": {
    "body-parser": "^2.2.2",
    "cors": "^2.8.6",
    "express": "^5.2.1"
  },
  "devDependencies": {}
}
```
Deskripsi
File package.json digunakan sebagai konfigurasi utama project Node.js. File ini berisi nama project, versi, deskripsi, file utama, script yang dapat dijalankan, dan daftar dependency. Dependency yang digunakan adalah express untuk membangun server backend dan cors untuk mengizinkan akses cross-origin dari halaman HTML statis. Script start memungkinkan server dijalankan menggunakan perintah npm start.

Backend server.js
```
const express = require("express")
const fs = require("fs")
const app = express()

app.use(express.json())
app.use(express.static("public"))

const DB = "./data/db.json"

function readDB() {
    if (!fs.existsSync(DB)) fs.writeFileSync(DB, "[]")
    return JSON.parse(fs.readFileSync(DB))
}
function writeDB(data) {
    fs.writeFileSync(DB, JSON.stringify(data, null, 2))
}

// READ
app.get("/mahasiswa", (req, res) => {
    res.json(readDB())
})

// CREATE
app.post("/mahasiswa", (req, res) => {
    const data = readDB()
    const { nim, nama, jurusan, angkatan, email } = req.body
    if (!nim || !nama || !jurusan) return res.status(400).json({ message: "Data tidak lengkap" })
    if (data.find(m => m.nim === nim)) return res.status(400).json({ message: "NIM sudah ada" })
    data.push({ nim, nama, jurusan, angkatan, email, createdAt: new Date().toISOString() })
    writeDB(data)
    res.json({ message: "Data berhasil ditambah" })
})

// GET BY NIM
app.get("/mahasiswa/:nim", (req, res) => {
    const data = readDB()
    const mhs = data.find(m => m.nim === req.params.nim)
    if (!mhs) return res.status(404).json({ message: "Data tidak ditemukan" })
    res.json(mhs)
})

// UPDATE
app.put("/mahasiswa/:nim", (req, res) => {
    let data = readDB()
    const idx = data.findIndex(m => m.nim === req.params.nim)
    if (idx === -1) return res.status(404).json({ message: "Data tidak ditemukan" })
    data[idx] = { ...data[idx], ...req.body, nim: req.params.nim }
    writeDB(data)
    res.json({ message: "Data berhasil diupdate" })
})

// DELETE
app.delete("/mahasiswa/:nim", (req, res) => {
    let data = readDB()
    data = data.filter(m => m.nim !== req.params.nim)
    writeDB(data)
    res.json({ message: "Data berhasil dihapus" })
})

app.listen(3000, () => console.log("✅ Server jalan di http://localhost:3000"))
```
Deskripsi
File server.js merupakan inti backend aplikasi. Pada bagian awal dilakukan import library express, path, fs, dan cors. Library express digunakan untuk membuat server HTTP, path untuk mengelola path file, fs untuk membaca dan menulis file JSON, serta cors untuk mengizinkan akses dari frontend HTML statis.

Middleware yang digunakan adalah cors() untuk cross-origin, express.json() untuk membaca request body JSON, dan express.static() untuk melayani file HTML dari folder public.

Fungsi readData() membaca file db.json dan mengembalikan array kosong jika terjadi error. Fungsi writeData() menyimpan perubahan data ke file JSON.

Route REST API yang tersedia:
* GET /mahasiswa — mengembalikan seluruh data mahasiswa dalam format JSON array
* GET /mahasiswa/:nim — mengembalikan satu data berdasarkan NIM
* POST /mahasiswa — menambahkan data baru, dengan pengecekan duplikasi NIM
* PUT /mahasiswa/:nim — memperbarui data mahasiswa berdasarkan NIM
* DELETE /mahasiswa/:nim — menghapus data mahasiswa berdasarkan NIM

File Data data/db.json
```
```
Deskripsi
File db.json berperan sebagai database sederhana berbasis file. Data disimpan sebagai array JSON, di mana setiap elemen merupakan objek mahasiswa dengan atribut nim, nama, jurusan, angkatan, email, dan createdAt. File ini dibaca dan ditulis langsung oleh server.js menggunakan modul fs bawaan Node.js.

Halaman Form Input (public/index.html)
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuTi — Input Mahasiswa Baru</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --blue-50:  #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --teal-400: #2dd4bf;
            --teal-500: #14b8a6;
            --slate-50:  #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --red-100:  #fee2e2;
            --red-600:  #dc2626;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--slate-50);
            color: var(--slate-800);
            min-height: 100vh;
        }

        /* ─── NAVBAR ─────────────────────────────── */
        .puti-navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            height: 60px;
            background: white;
            border-bottom: 1px solid var(--slate-200);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 1px 4px rgba(15,23,42,.05);
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.6rem;
            text-decoration: none;
            font-size: 1rem; font-weight: 800; color: var(--slate-900);
        }
        .nav-brand .logo {
            width: 34px; height: 34px;
            background: var(--blue-600);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .nav-brand .wordmark { color: var(--blue-600); }
        .nav-links { display: flex; gap: 4px; }
        .nav-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            text-decoration: none; color: var(--slate-500);
            transition: all .15s;
        }
        .nav-btn:hover { background: var(--slate-100); color: var(--slate-700); }
        .nav-btn.active { background: var(--blue-600); color: white !important; }
        .nav-btn i { font-size: 0.85rem; }

        /* ─── PAGE ───────────────────────────────── */
        .page { padding-top: 80px; padding-bottom: 3rem; }

        /* ─── PAGE HEADER ────────────────────────── */
        .page-header {
            padding: 1.75rem 0 1.5rem;
            border-bottom: 1px solid var(--slate-200);
            margin-bottom: 1.5rem;
        }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.7rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
            color: var(--blue-600);
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-radius: 6px;
            padding: 3px 10px;
            margin-bottom: 0.65rem;
        }
        .page-header h1 { font-size: 1.55rem; font-weight: 800; color: var(--slate-900); line-height: 1.25; }
        .page-header p { font-size: 0.83rem; color: var(--slate-500); margin-top: 0.3rem; }

        /* ─── STAT CARDS ─────────────────────────── */
        .stat-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex; align-items: center; gap: 0.9rem;
            height: 100%;
        }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .si-blue  { background: var(--blue-50);  color: var(--blue-600); }
        .si-teal  { background: #f0fdfa;          color: var(--teal-500); }
        .si-slate { background: var(--slate-100); color: var(--slate-600); }
        .stat-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.65rem; font-weight: 700;
            line-height: 1; color: var(--slate-900);
        }
        .stat-label {
            font-size: 0.68rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .06em;
            color: var(--slate-400); margin-top: 3px;
        }

        /* ─── CARD ───────────────────────────────── */
        .puti-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            overflow: hidden;
        }
        .puti-card-head {
            display: flex; align-items: center; gap: 8px;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--slate-100);
        }
        .card-head-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--blue-50); color: var(--blue-600);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; flex-shrink: 0;
        }
        .card-head-title {
            font-size: 0.83rem; font-weight: 700; color: var(--slate-700);
            text-transform: uppercase; letter-spacing: .05em;
        }

        /* ─── FORM FIELDS ────────────────────────── */
        .field label {
            display: block;
            font-size: 0.76rem; font-weight: 600; color: var(--slate-500);
            margin-bottom: 6px;
        }
        .field .form-control,
        .field .form-select {
            height: 40px;
            border: 1.5px solid var(--slate-200);
            border-radius: 8px;
            padding: 0 12px;
            font-family: 'Plus Jakarta Sans', inherit;
            font-size: 0.85rem; color: var(--slate-800);
            background: var(--slate-50);
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        .field .form-control:focus,
        .field .form-select:focus {
            border-color: var(--blue-500);
            background: white;
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }
        .field .form-control::placeholder { color: var(--slate-400); }
        #nim { font-family: 'JetBrains Mono', monospace; font-size: 0.83rem; letter-spacing: .03em; }

        /* ─── SUBMIT BUTTON ──────────────────────── */
        .btn-submit {
            display: inline-flex; align-items: center; gap: 7px;
            height: 40px; padding: 0 22px;
            background: var(--blue-600); color: white;
            border: none; border-radius: 9px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.86rem; font-weight: 700;
            cursor: pointer; white-space: nowrap;
            box-shadow: 0 1px 3px rgba(37,99,235,.25), 0 4px 12px rgba(37,99,235,.2);
            transition: all .15s;
        }
        .btn-submit:hover { background: var(--blue-700); box-shadow: 0 2px 6px rgba(37,99,235,.35), 0 6px 18px rgba(37,99,235,.25); }
        .btn-submit:disabled { opacity: .65; cursor: not-allowed; }

        /* ─── INFO NOTE ──────────────────────────── */
        .info-note {
            display: flex; align-items: center; gap: 8px;
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-radius: 8px;
            padding: 9px 12px;
        }
        .info-note i { color: var(--blue-500); font-size: 0.9rem; flex-shrink: 0; }
        .info-note p { font-size: 0.78rem; color: var(--slate-600); line-height: 1.45; margin: 0; }

        /* ─── RECENT LIST ────────────────────────── */
        .btn-all {
            display: inline-flex; align-items: center; gap: 5px;
            height: 30px; padding: 0 12px;
            background: var(--slate-100); color: var(--slate-600);
            border-radius: 7px; text-decoration: none;
            font-size: 0.78rem; font-weight: 600;
            transition: all .15s;
        }
        .btn-all:hover { background: var(--blue-50); color: var(--blue-600); }

        .r-empty { padding: 3rem 1.5rem; text-align: center; color: var(--slate-400); }
        .r-empty i { font-size: 2rem; display: block; margin-bottom: 8px; opacity: .4; }
        .r-empty p { font-size: 0.83rem; }

        .r-item {
            display: grid;
            grid-template-columns: 38px 1fr auto auto;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--slate-100);
            transition: background .12s;
        }
        .r-item:last-child { border-bottom: none; }
        .r-item:hover { background: var(--slate-50); }

        .avatar {
            width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-400));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; color: white;
        }
        .r-name { font-size: 0.86rem; font-weight: 600; color: var(--slate-800); }
        .r-sub  { font-size: 0.73rem; color: var(--slate-400); margin-top: 2px; }
        .jurusan-badge {
            font-size: 0.7rem; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
            background: var(--blue-50); color: var(--blue-700);
            white-space: nowrap;
        }
        .nim-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem;
            padding: 3px 8px; border-radius: 5px;
            background: var(--slate-100); color: var(--slate-600);
            white-space: nowrap;
        }

        /* ─── TOAST ──────────────────────────────── */
        .toast-wrap {
            position: fixed; top: 68px; right: 1.25rem;
            z-index: 9999; display: flex; flex-direction: column; gap: 8px;
            pointer-events: none;
        }
        .puti-toast {
            display: flex; align-items: center; gap: 9px;
            padding: 10px 16px; border-radius: 10px;
            font-size: 0.84rem; font-weight: 600;
            min-width: 240px;
            box-shadow: 0 4px 20px rgba(15,23,42,.12);
            animation: tin .28s cubic-bezier(.34,1.56,.64,1);
            pointer-events: all;
        }
        @keyframes tin { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
        .puti-toast.success { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
        .puti-toast.error   { background: var(--red-100); border: 1px solid #fca5a5; color: var(--red-600); }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="puti-navbar">
    <a href="/" class="nav-brand">
        <div class="logo">🎓</div>
        <span class="wordmark">PuTi</span>
    </a>
    <div class="nav-links">
        <a href="index.html" class="nav-btn active"><i class="bi bi-plus-circle-fill"></i> Input</a>
        <a href="data.html" class="nav-btn"><i class="bi bi-table"></i> Data</a>
        <a href="dashboard.html" class="nav-btn"><i class="bi bi-bar-chart-fill"></i> Dashboard</a>
    </div>
</nav>

<div class="toast-wrap" id="toastWrap"></div>

<div class="container page" style="max-width:960px">

    <!-- Page Header -->
    <div class="page-header">
        <div class="eyebrow"><i class="bi bi-mortarboard-fill"></i> Input Mahasiswa Baru</div>
        <h1>Tambah Data Mahasiswa Baru</h1>
        <p>Isi formulir di bawah untuk mendaftarkan mahasiswa ke dalam sistem.</p>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <div class="stat-icon si-blue"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-num" id="statTotal">0</div>
                    <div class="stat-label">Total Mahasiswa</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <div class="stat-icon si-teal"><i class="bi bi-building"></i></div>
                <div>
                    <div class="stat-num" id="statJurusan">0</div>
                    <div class="stat-label">Jurusan</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <div class="stat-icon si-slate"><i class="bi bi-calendar3"></i></div>
                <div>
                    <div class="stat-num" id="statAngkatan">0</div>
                    <div class="stat-label">Angkatan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="puti-card mb-4">
        <div class="puti-card-head">
            <div class="card-head-icon"><i class="bi bi-person-plus-fill"></i></div>
            <div class="card-head-title">Form Pendaftaran</div>
        </div>
        <div class="p-4">
            <form id="formMhs">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4 field">
                        <label>NIM</label>
                        <input type="text" id="nim" class="form-control" placeholder="2021001234" required>
                    </div>
                    <div class="col-12 col-md-4 field">
                        <label>Nama Lengkap</label>
                        <input type="text" id="nama" class="form-control" placeholder="Nama sesuai KTP" required>
                    </div>
                    <div class="col-12 col-md-4 field">
                        <label>Jurusan</label>
                        <select id="jurusan" class="form-select" required>
                            <option value="">— Pilih Jurusan —</option>
                            <option>Teknik Informatika</option>
                            <option>Sistem Informasi</option>
                            <option>Teknik Elektro</option>
                            <option>Desain Komunikasi Visual</option>
                            <option>Teknik Industri</option>
                            <option>Sains Data</option>
                            <option>Teknik Telekomunikasi</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 field">
                        <label>Angkatan</label>
                        <select id="angkatan" class="form-select">
                            <option value="">— Tahun —</option>
                            <option>2025</option><option>2024</option><option>2023</option>
                            <option>2022</option><option>2021</option><option>2020</option>
                            <option>2019</option><option>2018</option><option>2017</option>
                            <option>2016</option><option>2015</option><option>2014</option>
                            <option>2013</option><option>2012</option><option>2011</option>
                            <option>2010</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 field">
                        <label>Email</label>
                        <input type="email" id="email" class="form-control" placeholder="mahasiswa@email.com">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <i class="bi bi-cloud-upload-fill"></i> Simpan Mahasiswa
                    </button>
                    <div class="info-note flex-grow-1">
                        <i class="bi bi-info-circle-fill"></i>
                        <p>NIM tidak dapat diubah setelah disimpan. Pastikan data sudah benar sebelum menyimpan.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Card -->
    <div class="puti-card">
        <div class="puti-card-head">
            <div class="card-head-icon"><i class="bi bi-clock-history"></i></div>
            <div class="card-head-title d-flex align-items-center justify-content-between w-100">
                <span>Data Mahasiswa Terbaru</span>
                <a href="data.html" class="btn-all">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div id="recentList">
            <div class="r-empty"><i class="bi bi-inbox"></i><p>Belum ada data mahasiswa.</p></div>
        </div>
    </div>

</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showToast(msg, type = 'success') {
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
        const t = $(`<div class="puti-toast ${type}"><i class="bi ${icon}"></i>${msg}</div>`);
        $('#toastWrap').append(t);
        setTimeout(() => t.fadeOut(300, () => t.remove()), 3200);
    }

    function initials(n) {
        return n.trim().split(/\s+/).slice(0, 2).map(w => w[0]).join('').toUpperCase();
    }

    function loadData() {
        $.get('/mahasiswa', function(data) {
            $('#statTotal').text(data.length);
            $('#statJurusan').text([...new Set(data.map(m => m.jurusan).filter(Boolean))].length);
            $('#statAngkatan').text([...new Set(data.map(m => m.angkatan).filter(Boolean))].length);

            const recent = data.slice(-12).reverse();
            if (!recent.length) {
                $('#recentList').html('<div class="r-empty"><i class="bi bi-inbox"></i><p>Belum ada data mahasiswa.</p></div>');
                return;
            }
            const rows = recent.map(m => `
                <div class="r-item">
                    <div class="avatar">${initials(m.nama)}</div>
                    <div>
                        <div class="r-name">${m.nama}</div>
                        <div class="r-sub">${m.angkatan ? m.angkatan + ' · ' : ''}${m.email || ''}</div>
                    </div>
                    <span class="jurusan-badge">${m.jurusan || '—'}</span>
                    <span class="nim-tag">${m.nim}</span>
                </div>
            `).join('');
            $('#recentList').html(`<div>${rows}</div>`);
        });
    }

    loadData();

    $('#formMhs').submit(function(e) {
        e.preventDefault();
        const $btn = $('#btnSubmit');
        $btn.html('<i class="bi bi-hourglass-split"></i> Menyimpan...').prop('disabled', true);
        $.ajax({
            url: '/mahasiswa', method: 'POST', contentType: 'application/json',
            data: JSON.stringify({
                nim: $('#nim').val().trim(),
                nama: $('#nama').val().trim(),
                jurusan: $('#jurusan').val(),
                angkatan: $('#angkatan').val(),
                email: $('#email').val().trim()
            }),
            success: function() {
                showToast('Data berhasil disimpan! 🎉');
                $('#formMhs')[0].reset();
                loadData();
            },
            error: function(e) {
                showToast(e.responseJSON?.message || 'Gagal menyimpan data.', 'error');
            },
            complete: function() {
                $btn.html('<i class="bi bi-cloud-upload-fill"></i> Simpan Mahasiswa').prop('disabled', false);
            }
        });
    });
</script>
</body>
</html>
```

Halaman Data Mahasiswa (public/data.html)
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuTi — Data Mahasiswa</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        :root {
            --blue-50:  #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --teal-500: #14b8a6;
            --orange-500: #f97316;
            --red-50:   #fef2f2;
            --red-200:  #fecaca;
            --red-500:  #ef4444;
            --red-600:  #dc2626;
            --slate-50:  #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--slate-50);
            color: var(--slate-800);
            min-height: 100vh;
        }

        /* ─── NAVBAR ─────────────────────────────── */
        .puti-navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            height: 60px;
            background: white;
            border-bottom: 1px solid var(--slate-200);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 1px 4px rgba(15,23,42,.05);
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.6rem;
            text-decoration: none;
            font-size: 1rem; font-weight: 800; color: var(--slate-900);
        }
        .nav-brand .logo {
            width: 34px; height: 34px;
            background: var(--blue-600); border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .nav-brand .wordmark { color: var(--blue-600); }
        .nav-links { display: flex; gap: 4px; }
        .nav-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            text-decoration: none; color: var(--slate-500);
            transition: all .15s;
        }
        .nav-btn:hover { background: var(--slate-100); color: var(--slate-700); }
        .nav-btn.active { background: var(--blue-600); color: white !important; }
        .nav-btn i { font-size: 0.85rem; }

        /* ─── PAGE ───────────────────────────────── */
        .page { padding-top: 80px; padding-bottom: 3rem; }

        /* ─── PAGE HEADER ────────────────────────── */
        .page-header {
            padding: 1.75rem 0 1.5rem;
            border-bottom: 1px solid var(--slate-200);
            margin-bottom: 1.5rem;
        }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.7rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
            color: var(--blue-600);
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-radius: 6px;
            padding: 3px 10px;
            margin-bottom: 0.65rem;
        }
        .page-header h1 { font-size: 1.55rem; font-weight: 800; color: var(--slate-900); line-height: 1.25; }
        .page-header p  { font-size: 0.83rem; color: var(--slate-500); margin-top: 0.3rem; margin-bottom: 0; }

        /* ─── STAT CARDS ─────────────────────────── */
        .stat-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex; align-items: center; gap: 0.9rem;
            height: 100%;
        }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 1rem;
        }
        .si-blue  { background: var(--blue-50);  color: var(--blue-600); }
        .si-teal  { background: #f0fdfa;          color: var(--teal-500); }
        .si-slate { background: var(--slate-100); color: var(--slate-600); }
        .stat-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.65rem; font-weight: 700; line-height: 1; color: var(--slate-900);
        }
        .stat-label {
            font-size: 0.68rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .06em;
            color: var(--slate-400); margin-top: 3px;
        }

        /* ─── BUTTON ADD ─────────────────────────── */
        .btn-add {
            display: inline-flex; align-items: center; gap: 7px;
            height: 40px; padding: 0 20px;
            background: var(--blue-600); color: white;
            border: none; border-radius: 9px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.86rem; font-weight: 700;
            text-decoration: none; white-space: nowrap;
            box-shadow: 0 1px 3px rgba(37,99,235,.25), 0 4px 12px rgba(37,99,235,.2);
            transition: all .15s; flex-shrink: 0;
        }
        .btn-add:hover { background: var(--blue-700); color: white; }

        /* ─── PUTI CARD ──────────────────────────── */
        .puti-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            overflow: hidden;
        }
        .puti-card-head {
            display: flex; align-items: center; gap: 8px;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--slate-100);
        }
        .card-head-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--blue-50); color: var(--blue-600);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; flex-shrink: 0;
        }
        .card-head-title {
            font-size: 0.83rem; font-weight: 700; color: var(--slate-700);
            text-transform: uppercase; letter-spacing: .05em;
        }

        /* ─── DATATABLES OVERRIDES ───────────────── */
        .table-wrap { padding: 0.75rem 1.5rem 1.5rem; overflow-x: auto; }
        table.dataTable { border-collapse: separate !important; border-spacing: 0 !important; width: 100% !important; }
        table.dataTable thead th {
            background: var(--slate-50) !important;
            color: var(--slate-500) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.7rem !important; font-weight: 700 !important;
            text-transform: uppercase !important; letter-spacing: .06em !important;
            padding: 10px 12px !important;
            border: none !important;
            border-bottom: 1.5px solid var(--slate-200) !important;
            white-space: nowrap;
        }
        table.dataTable tbody tr { background: transparent !important; }
        table.dataTable tbody tr:hover td { background: var(--slate-50) !important; }
        table.dataTable tbody td {
            padding: 11px 12px !important; border: none !important;
            border-bottom: 1px solid var(--slate-100) !important;
            color: var(--slate-800) !important;
            font-size: 0.85rem !important; vertical-align: middle !important;
        }
        table.dataTable tbody tr:last-child td { border-bottom: none !important; }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: var(--slate-50) !important;
            border: 1.5px solid var(--slate-200) !important;
            border-radius: 8px !important;
            color: var(--slate-800) !important;
            padding: 6px 10px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.83rem !important; outline: none !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--blue-500) !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--slate-400) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.8rem !important; padding: 8px 0 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: white !important; border: 1px solid var(--slate-200) !important;
            border-radius: 7px !important; color: var(--slate-600) !important;
            margin: 0 2px !important; padding: 4px 10px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important; font-size: 0.82rem !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--blue-600) !important; border-color: var(--blue-600) !important; color: white !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            background: var(--blue-50) !important; border-color: var(--blue-200) !important; color: var(--blue-600) !important;
        }

        /* ─── BADGES ─────────────────────────────── */
        .nim-tag {
            font-family: 'JetBrains Mono', monospace; font-size: 0.73rem;
            padding: 3px 8px; border-radius: 5px;
            background: var(--slate-100); color: var(--slate-600);
        }
        .jurusan-badge {
            font-size: 0.7rem; font-weight: 600;
            padding: 3px 9px; border-radius: 20px;
            background: var(--blue-50); color: var(--blue-700); white-space: nowrap;
        }
        .angkatan-badge {
            font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;
            padding: 3px 8px; border-radius: 5px;
            background: #fff7ed; color: var(--orange-500);
        }
        .avatar {
            width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-400));
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; color: white; margin-right: 8px;
        }
        .name-cell { display: flex; align-items: center; }
        .name-text { font-weight: 600; color: var(--slate-800); }

        /* ─── ACTION BUTTONS ─────────────────────── */
        .btn-act {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 7px;
            border: none; cursor: pointer; font-size: 0.8rem; transition: all .15s;
        }
        .btn-act.edit { background: var(--blue-50);  color: var(--blue-600); }
        .btn-act.edit:hover { background: var(--blue-100); }
        .btn-act.del  { background: var(--red-50);   color: var(--red-500); }
        .btn-act.del:hover  { background: var(--red-200); }

        /* ─── MODAL (Bootstrap override) ────────── */
        .modal-content {
            border: 1px solid var(--slate-200) !important;
            border-radius: 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .modal-backdrop { backdrop-filter: blur(4px); }
        .puti-modal-icon {
            width: 44px; height: 44px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: 1rem;
        }
        .puti-modal-icon.edit-icon { background: var(--blue-50); color: var(--blue-600); }
        .puti-modal-icon.del-icon  { background: var(--red-50);  color: var(--red-500); }
        .modal-title-custom { font-size: 1.1rem; font-weight: 800; color: var(--slate-900); }
        .modal-sub { font-size: 0.81rem; color: var(--slate-400); }

        .mfield label {
            display: block; font-size: 0.76rem; font-weight: 600;
            color: var(--slate-500); margin-bottom: 5px;
        }
        .mfield .form-control,
        .mfield .form-select {
            height: 40px; border: 1.5px solid var(--slate-200); border-radius: 8px;
            padding: 0 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem; color: var(--slate-800);
            background: var(--slate-50); outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .mfield .form-control:focus,
        .mfield .form-select:focus {
            border-color: var(--blue-500); background: white;
            box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
        }
        .mfield .form-control[readonly] { opacity: .5; cursor: not-allowed; }

        .btn-modal-cancel {
            padding: 0 18px; height: 40px;
            background: var(--slate-100); border: none; border-radius: 8px;
            color: var(--slate-600); font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all .15s;
        }
        .btn-modal-cancel:hover { background: var(--slate-200); }
        .btn-modal-save {
            flex: 1; height: 40px;
            background: var(--blue-600); border: none; border-radius: 8px;
            color: white; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: all .15s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-modal-save:hover { background: var(--blue-700); }
        .btn-modal-del {
            flex: 1; height: 40px;
            background: var(--red-500); border: none; border-radius: 8px;
            color: white; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: all .15s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-modal-del:hover { background: var(--red-600); }

        /* ─── TOAST ──────────────────────────────── */
        .toast-wrap {
            position: fixed; top: 68px; right: 1.25rem;
            z-index: 99999; display: flex; flex-direction: column; gap: 8px;
            pointer-events: none;
        }
        .puti-toast {
            display: flex; align-items: center; gap: 9px;
            padding: 10px 16px; border-radius: 10px;
            font-size: 0.84rem; font-weight: 600; min-width: 240px;
            box-shadow: 0 4px 20px rgba(15,23,42,.12);
            animation: tin .28s cubic-bezier(.34,1.56,.64,1);
            pointer-events: all;
        }
        @keyframes tin { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
        .puti-toast.success { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
        .puti-toast.error   { background: var(--red-50); border: 1px solid var(--red-200); color: var(--red-600); }

        .empty-state { padding: 3rem; text-align: center; color: var(--slate-400); }
        .empty-state i { font-size: 2rem; display: block; margin-bottom: 8px; opacity: .35; }
        .empty-state p { font-size: 0.83rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="puti-navbar">
    <a href="/" class="nav-brand">
        <div class="logo">🎓</div><span class="wordmark">PuTi</span>
    </a>
    <div class="nav-links">
        <a href="index.html" class="nav-btn"><i class="bi bi-plus-circle-fill"></i> Input</a>
        <a href="data.html" class="nav-btn active"><i class="bi bi-table"></i> Data</a>
        <a href="dashboard.html" class="nav-btn"><i class="bi bi-bar-chart-fill"></i> Dashboard</a>
    </div>
</nav>

<div class="toast-wrap" id="toastWrap"></div>

<!-- ─── EDIT MODAL (Bootstrap) ─────────────────────── -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="puti-modal-icon edit-icon"><i class="bi bi-pencil-fill"></i></div>
            <div class="modal-title-custom mb-1">Edit Mahasiswa</div>
            <div class="modal-sub mb-3">Perbarui informasi data mahasiswa</div>

            <div class="row g-2 mb-2">
                <div class="col-6 mfield">
                    <label>NIM</label>
                    <input id="editNim" class="form-control" readonly>
                </div>
                <div class="col-6 mfield">
                    <label>Angkatan</label>
                    <select id="editAngkatan" class="form-select">
                        <option value="">— Tahun —</option>
                        <option>2025</option><option>2024</option><option>2023</option>
                        <option>2022</option><option>2021</option><option>2020</option>
                        <option>2019</option><option>2018</option><option>2017</option>
                        <option>2016</option><option>2015</option><option>2014</option>
                        <option>2013</option><option>2012</option><option>2011</option>
                        <option>2010</option>
                    </select>
                </div>
            </div>
            <div class="mfield mb-2">
                <label>Nama Lengkap</label>
                <input id="editNama" class="form-control" placeholder="Nama lengkap">
            </div>
            <div class="mfield mb-2">
                <label>Jurusan</label>
                <select id="editJurusan" class="form-select">
                    <option value="">— Pilih Jurusan —</option>
                    <option>Teknik Informatika</option>
                    <option>Sistem Informasi</option>
                    <option>Teknik Elektro</option>
                    <option>Teknik Sipil</option>
                    <option>Manajemen</option>
                    <option>Akuntansi</option>
                    <option>Hukum</option>
                    <option>Kedokteran</option>
                </select>
            </div>
            <div class="mfield mb-3">
                <label>Email</label>
                <input id="editEmail" type="email" class="form-control" placeholder="email@example.com">
            </div>
            <div class="d-flex gap-2">
                <button class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button class="btn-modal-save" onclick="saveEdit()"><i class="bi bi-cloud-check-fill"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- ─── DELETE MODAL (Bootstrap) ──────────────────── -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <div class="modal-content p-4">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="puti-modal-icon del-icon"><i class="bi bi-trash3-fill"></i></div>
            <div class="modal-title-custom mb-1">Hapus Data?</div>
            <div class="modal-sub mb-3" id="deleteDesc">Data ini akan dihapus permanen dan tidak bisa dikembalikan.</div>
            <div class="d-flex gap-2">
                <button class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button class="btn-modal-del" onclick="confirmDelete()"><i class="bi bi-trash3"></i> Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- ─── PAGE ───────────────────────────────────────── -->
<div class="container page" style="max-width:960px">

    <!-- Page Header -->
    <div class="page-header d-flex align-items-end justify-content-between flex-wrap gap-3">
        <div>
            <div class="eyebrow"><i class="bi bi-table"></i> Manajemen Data</div>
            <h1>Data Mahasiswa</h1>
            <p>Kelola seluruh data mahasiswa yang terdaftar dalam sistem.</p>
        </div>
        <a href="index.html" class="btn-add"><i class="bi bi-plus-lg"></i> Tambah Mahasiswa</a>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <div class="stat-icon si-blue"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-num" id="statTotal">—</div>
                    <div class="stat-label">Total Mahasiswa</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <div class="stat-icon si-teal"><i class="bi bi-building"></i></div>
                <div>
                    <div class="stat-num" id="statJurusan">—</div>
                    <div class="stat-label">Jurusan</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="stat-card">
                <div class="stat-icon si-slate"><i class="bi bi-calendar3"></i></div>
                <div>
                    <div class="stat-num" id="statAngkatan">—</div>
                    <div class="stat-label">Angkatan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="puti-card">
        <div class="puti-card-head">
            <div class="card-head-icon"><i class="bi bi-list-ul"></i></div>
            <div class="card-head-title">Daftar Mahasiswa</div>
        </div>
        <div class="table-wrap">
            <table id="tableMhs" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th><th>NIM</th><th>Nama</th><th>Jurusan</th>
                        <th>Angkatan</th><th>Email</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    let table, deleteNim = null;
    let editModalInstance, deleteModalInstance;

    function showToast(msg, type = 'success') {
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
        const t = $(`<div class="puti-toast ${type}"><i class="bi ${icon}"></i>${msg}</div>`);
        $('#toastWrap').append(t);
        setTimeout(() => t.fadeOut(300, () => t.remove()), 3500);
    }

    function initials(n) {
        return n.trim().split(/\s+/).slice(0, 2).map(w => w[0]).join('').toUpperCase();
    }

    function loadStats(data) {
        $('#statTotal').text(data.length);
        $('#statJurusan').text([...new Set(data.map(m => m.jurusan).filter(Boolean))].length);
        $('#statAngkatan').text([...new Set(data.map(m => m.angkatan).filter(Boolean))].length);
    }

    $(document).ready(function () {
        editModalInstance   = new bootstrap.Modal(document.getElementById('editModal'));
        deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteModal'));

        table = $('#tableMhs').DataTable({
            ajax: {
                url: '/mahasiswa',
                dataSrc: function (json) { loadStats(json); return json; }
            },
            columns: [
                { data: null, render: (d, t, r, m) => `<span style="color:var(--slate-400);font-family:'JetBrains Mono',monospace;font-size:0.76rem">${m.row + 1}</span>` },
                { data: 'nim',     render: d => `<span class="nim-tag">${d}</span>` },
                { data: 'nama',    render: d => `<div class="name-cell"><div class="avatar">${initials(d)}</div><span class="name-text">${d}</span></div>` },
                { data: 'jurusan', render: d => d ? `<span class="jurusan-badge">${d}</span>` : `<span style="color:var(--slate-300)">—</span>` },
                { data: 'angkatan',render: d => d ? `<span class="angkatan-badge">${d}</span>` : `<span style="color:var(--slate-300)">—</span>` },
                { data: 'email',   render: d => d ? `<a href="mailto:${d}" style="color:var(--blue-600);font-size:0.83rem;text-decoration:none">${d}</a>` : `<span style="color:var(--slate-300)">—</span>` },
                { data: null, render: d => `<div style="display:flex;gap:6px"><button class="btn-act edit" onclick="openEdit('${d.nim}')" title="Edit"><i class="bi bi-pencil"></i></button><button class="btn-act del" onclick="openDelete('${d.nim}','${d.nama}')" title="Hapus"><i class="bi bi-trash3"></i></button></div>` }
            ],
            language: {
                search: '', searchPlaceholder: '🔍 Cari mahasiswa...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                emptyTable: '<div class="empty-state"><i class="bi bi-inbox"></i><p>Belum ada data mahasiswa</p></div>',
                paginate: { previous: '‹', next: '›' }
            },
            pageLength: 10, order: [[0, 'asc']]
        });
    });

    function openEdit(nim) {
        $.get('/mahasiswa/' + nim, function (d) {
            $('#editNim').val(d.nim);
            $('#editNama').val(d.nama);
            $('#editJurusan').val(d.jurusan);
            $('#editAngkatan').val(d.angkatan);
            $('#editEmail').val(d.email);
            editModalInstance.show();
        });
    }

    function saveEdit() {
        const nim = $('#editNim').val();
        $.ajax({
            url: '/mahasiswa/' + nim, method: 'PUT', contentType: 'application/json',
            data: JSON.stringify({
                nama: $('#editNama').val().trim(),
                jurusan: $('#editJurusan').val(),
                angkatan: $('#editAngkatan').val(),
                email: $('#editEmail').val().trim()
            }),
            success: function () {
                editModalInstance.hide();
                table.ajax.reload(null, false);
                showToast('Data berhasil diperbarui! ✨');
            },
            error: function () { showToast('Gagal memperbarui data.', 'error'); }
        });
    }

    function openDelete(nim, nama) {
        deleteNim = nim;
        $('#deleteDesc').text(`Data "${nama}" (NIM: ${nim}) akan dihapus permanen.`);
        deleteModalInstance.show();
    }

    function confirmDelete() {
        if (!deleteNim) return;
        $.ajax({
            url: '/mahasiswa/' + deleteNim, method: 'DELETE',
            success: function () {
                deleteModalInstance.hide();
                deleteNim = null;
                table.ajax.reload(null, false);
                showToast('Data berhasil dihapus. 🗑️');
            },
            error: function () { showToast('Gagal menghapus data.', 'error'); }
        });
    }
</script>
</body>
</html>
```

Halaman Dashboard (public/dashboard.html)
```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuTi — Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --blue-50:   #eff6ff;
            --blue-100:  #dbeafe;
            --blue-200:  #bfdbfe;
            --blue-400:  #60a5fa;
            --blue-500:  #3b82f6;
            --blue-600:  #2563eb;
            --blue-700:  #1d4ed8;
            --teal-400:  #2dd4bf;
            --teal-500:  #14b8a6;
            --orange-400:#fb923c;
            --orange-500:#f97316;
            --violet-500:#8b5cf6;
            --violet-400:#a78bfa;
            --green-500: #22c55e;
            --green-400: #4ade80;
            --red-500:   #ef4444;
            --slate-50:  #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--slate-50);
            color: var(--slate-800);
            min-height: 100vh;
        }

        /* ─── NAVBAR ─────────────────────────────── */
        .puti-navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            height: 60px;
            background: white;
            border-bottom: 1px solid var(--slate-200);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 1px 4px rgba(15,23,42,.05);
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.6rem;
            text-decoration: none;
            font-size: 1rem; font-weight: 800; color: var(--slate-900);
        }
        .nav-brand .logo {
            width: 34px; height: 34px;
            background: var(--blue-600);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .nav-brand .wordmark { color: var(--blue-600); }
        .nav-links { display: flex; gap: 4px; }
        .nav-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600;
            text-decoration: none; color: var(--slate-500);
            transition: all .15s;
        }
        .nav-btn:hover { background: var(--slate-100); color: var(--slate-700); }
        .nav-btn.active { background: var(--blue-600); color: white !important; }
        .nav-btn i { font-size: 0.85rem; }

        /* ─── PAGE ───────────────────────────────── */
        .page { padding-top: 80px; padding-bottom: 3rem; }

        /* ─── PAGE HEADER ────────────────────────── */
        .page-header {
            padding: 1.75rem 0 1.5rem;
            border-bottom: 1px solid var(--slate-200);
            margin-bottom: 1.5rem;
        }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.7rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
            color: var(--blue-600);
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-radius: 6px;
            padding: 3px 10px;
            margin-bottom: 0.65rem;
        }
        .page-header h1 { font-size: 1.55rem; font-weight: 800; color: var(--slate-900); line-height: 1.25; }
        .page-header p  { font-size: 0.83rem; color: var(--slate-500); margin-top: 0.3rem; margin-bottom: 0; }

        /* ─── STAT CARDS ─────────────────────────── */
        .stat-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex; align-items: center; gap: 0.9rem;
            height: 100%;
            transition: box-shadow .2s;
        }
        .stat-card:hover { box-shadow: 0 4px 16px rgba(15,23,42,.08); }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }
        .si-blue   { background: var(--blue-50);  color: var(--blue-600); }
        .si-teal   { background: #f0fdfa;          color: var(--teal-500); }
        .si-slate  { background: var(--slate-100); color: var(--slate-600); }
        .si-orange { background: #fff7ed;           color: var(--orange-500); }
        .si-violet { background: #f5f3ff;           color: var(--violet-500); }
        .stat-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.65rem; font-weight: 700;
            line-height: 1; color: var(--slate-900);
        }
        .stat-label {
            font-size: 0.68rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .06em;
            color: var(--slate-400); margin-top: 3px;
        }
        .stat-trend {
            display: inline-flex; align-items: center; gap: 3px;
            font-size: 0.72rem; font-weight: 600;
            margin-top: 4px;
        }
        .trend-up   { color: var(--green-500); }
        .trend-down { color: var(--red-500); }

        /* ─── PUTI CARD ──────────────────────────── */
        .puti-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            overflow: hidden;
        }
        .puti-card-head {
            display: flex; align-items: center; gap: 8px;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--slate-100);
        }
        .card-head-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--blue-50); color: var(--blue-600);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; flex-shrink: 0;
        }
        .card-head-title {
            font-size: 0.83rem; font-weight: 700; color: var(--slate-700);
            text-transform: uppercase; letter-spacing: .05em;
        }
        .card-head-sub {
            font-size: 0.75rem; color: var(--slate-400); font-weight: 400;
            text-transform: none; letter-spacing: 0; margin-left: 6px;
        }
        .card-body-pad { padding: 1.25rem 1.5rem; }

        /* ─── CHART CONTAINERS ───────────────────── */
        .chart-wrap { position: relative; width: 100%; }
        .chart-wrap canvas { max-width: 100%; }

        /* ─── LOADING SKELETON ───────────────────── */
        .skeleton {
            background: linear-gradient(90deg, var(--slate-100) 25%, var(--slate-50) 50%, var(--slate-100) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 6px;
        }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* ─── TOP LIST ───────────────────────────── */
        .top-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid var(--slate-100);
        }
        .top-item:last-child { border-bottom: none; }
        .top-rank {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem; font-weight: 700;
            width: 22px; text-align: center;
            color: var(--slate-400); flex-shrink: 0;
        }
        .top-rank.gold   { color: #f59e0b; }
        .top-rank.silver { color: var(--slate-400); }
        .top-rank.bronze { color: #b45309; }
        .top-bar-wrap { flex: 1; }
        .top-label { font-size: 0.82rem; font-weight: 600; color: var(--slate-700); margin-bottom: 4px; }
        .top-bar-bg { height: 6px; background: var(--slate-100); border-radius: 99px; overflow: hidden; }
        .top-bar-fill {
            height: 100%; border-radius: 99px;
            background: linear-gradient(90deg, var(--blue-500), var(--blue-400));
            transition: width 1s cubic-bezier(.34,1.56,.64,1);
        }
        .top-count {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem; font-weight: 700;
            color: var(--slate-600); flex-shrink: 0;
        }

        /* ─── ANGKATAN GRID ──────────────────────── */
        .angkatan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 8px;
        }
        .angkatan-chip {
            background: var(--slate-50);
            border: 1.5px solid var(--slate-200);
            border-radius: 10px;
            padding: 10px 6px;
            text-align: center;
            transition: all .15s;
        }
        .angkatan-chip:hover { border-color: var(--blue-300); background: var(--blue-50); }
        .angkatan-year {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem; font-weight: 700;
            color: var(--slate-700);
        }
        .angkatan-count {
            font-size: 0.7rem; color: var(--slate-400); font-weight: 600;
            margin-top: 2px;
        }

        /* ─── DONUT LEGEND ───────────────────────── */
        .legend-item {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 0;
        }
        .legend-dot {
            width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
        }
        .legend-label { font-size: 0.8rem; color: var(--slate-600); flex: 1; }
        .legend-val {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem; font-weight: 700;
            color: var(--slate-700);
        }
        .legend-pct {
            font-size: 0.72rem; color: var(--slate-400); margin-left: 4px;
        }

        /* ─── EMPTY STATE ────────────────────────── */
        .empty-dash { padding: 2.5rem; text-align: center; color: var(--slate-400); }
        .empty-dash i { font-size: 1.8rem; display: block; margin-bottom: 8px; opacity: .35; }
        .empty-dash p { font-size: 0.82rem; }

        /* ─── TOAST ──────────────────────────────── */
        .toast-wrap {
            position: fixed; top: 68px; right: 1.25rem;
            z-index: 9999; display: flex; flex-direction: column; gap: 8px;
            pointer-events: none;
        }

        /* ─── REFRESH BTN ────────────────────────── */
        .btn-refresh {
            display: inline-flex; align-items: center; gap: 5px;
            height: 30px; padding: 0 12px;
            background: var(--slate-100); color: var(--slate-600);
            border: none; border-radius: 7px;
            font-size: 0.78rem; font-weight: 600;
            cursor: pointer; transition: all .15s;
        }
        .btn-refresh:hover { background: var(--blue-50); color: var(--blue-600); }
        .btn-refresh.spinning i { animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ─── TIMESTAMP ──────────────────────────── */
        .ts-badge {
            font-size: 0.72rem; color: var(--slate-400);
            display: flex; align-items: center; gap: 4px;
        }
        .ts-badge i { font-size: 0.7rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="puti-navbar">
    <a href="/" class="nav-brand">
        <div class="logo">🎓</div>
        <span class="wordmark">PuTi</span>
    </a>
    <div class="nav-links">
        <a href="index.html" class="nav-btn"><i class="bi bi-plus-circle-fill"></i> Input</a>
        <a href="data.html" class="nav-btn"><i class="bi bi-table"></i> Data</a>
        <a href="dashboard.html" class="nav-btn active"><i class="bi bi-bar-chart-fill"></i> Dashboard</a>
    </div>
</nav>

<div class="toast-wrap" id="toastWrap"></div>

<div class="container page" style="max-width:960px">

    <!-- Page Header -->
    <div class="page-header d-flex align-items-end justify-content-between flex-wrap gap-3">
        <div>
            <div class="eyebrow"><i class="bi bi-bar-chart-fill"></i> Statistik & Analitik</div>
            <h1>Dashboard Mahasiswa</h1>
            <p>Ringkasan data dan visualisasi statistik seluruh mahasiswa terdaftar.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="ts-badge" id="lastUpdate"><i class="bi bi-clock"></i> Memuat...</div>
            <button class="btn-refresh" id="btnRefresh" onclick="loadAll()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
    </div>

    <!-- KPI Stats Row -->
    <div class="row g-3 mb-4" id="kpiRow">
        <div class="col-6 col-sm-3">
            <div class="stat-card">
                <div class="stat-icon si-blue"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-num" id="kpiTotal">—</div>
                    <div class="stat-label">Total Mahasiswa</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="stat-card">
                <div class="stat-icon si-teal"><i class="bi bi-building"></i></div>
                <div>
                    <div class="stat-num" id="kpiJurusan">—</div>
                    <div class="stat-label">Jurusan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="stat-card">
                <div class="stat-icon si-orange"><i class="bi bi-calendar3"></i></div>
                <div>
                    <div class="stat-num" id="kpiAngkatan">—</div>
                    <div class="stat-label">Angkatan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="stat-card">
                <div class="stat-icon si-violet"><i class="bi bi-envelope-fill"></i></div>
                <div>
                    <div class="stat-num" id="kpiEmail">—</div>
                    <div class="stat-label">Punya Email</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 1: Bar Chart + Donut Chart -->
    <div class="row g-3 mb-3">
        <!-- Bar: Mahasiswa per Jurusan -->
        <div class="col-12 col-md-7">
            <div class="puti-card h-100">
                <div class="puti-card-head">
                    <div class="card-head-icon"><i class="bi bi-bar-chart-fill"></i></div>
                    <div>
                        <span class="card-head-title">Mahasiswa per Jurusan</span>
                    </div>
                </div>
                <div class="card-body-pad">
                    <div class="chart-wrap" style="height:260px">
                        <canvas id="chartJurusan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donut: Distribusi Jurusan -->
        <div class="col-12 col-md-5">
            <div class="puti-card h-100">
                <div class="puti-card-head">
                    <div class="card-head-icon"><i class="bi bi-pie-chart-fill"></i></div>
                    <div><span class="card-head-title">Proporsi Jurusan</span></div>
                </div>
                <div class="card-body-pad">
                    <div class="chart-wrap" style="height:160px; margin-bottom:12px">
                        <canvas id="chartDonut"></canvas>
                    </div>
                    <div id="legendDonut"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Line Chart Angkatan + Top Jurusan List -->
    <div class="row g-3 mb-3">
        <!-- Line: Tren per Angkatan -->
        <div class="col-12 col-md-7">
            <div class="puti-card h-100">
                <div class="puti-card-head">
                    <div class="card-head-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <div><span class="card-head-title">Tren Penerimaan per Angkatan</span></div>
                </div>
                <div class="card-body-pad">
                    <div class="chart-wrap" style="height:220px">
                        <canvas id="chartAngkatan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Jurusan Ranking -->
        <div class="col-12 col-md-5">
            <div class="puti-card h-100">
                <div class="puti-card-head">
                    <div class="card-head-icon"><i class="bi bi-trophy-fill"></i></div>
                    <div><span class="card-head-title">Ranking Jurusan</span></div>
                </div>
                <div class="card-body-pad" id="topJurusanList">
                    <div class="empty-dash"><i class="bi bi-hourglass-split"></i><p>Memuat data...</p></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Angkatan Grid -->
    <div class="puti-card">
        <div class="puti-card-head">
            <div class="card-head-icon"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            <div><span class="card-head-title">Sebaran Angkatan</span></div>
        </div>
        <div class="card-body-pad">
            <div class="angkatan-grid" id="angkatanGrid">
                <div class="empty-dash" style="grid-column:1/-1"><i class="bi bi-hourglass-split"></i><p>Memuat...</p></div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // ── Chart instances ───────────────────────────
    let chartJurusan = null, chartDonut = null, chartAngkatan = null;

    // ── Color palette ─────────────────────────────
    const PALETTE = [
        '#3b82f6','#14b8a6','#f97316','#8b5cf6',
        '#22c55e','#ef4444','#eab308','#06b6d4',
        '#ec4899','#64748b'
    ];

    function hexToRgba(hex, a) {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        return `rgba(${r},${g},${b},${a})`;
    }

    // ── Chart defaults ────────────────────────────
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    // ── Helpers ───────────────────────────────────
    function groupBy(arr, key) {
        return arr.reduce((acc, item) => {
            const k = item[key] || '—';
            acc[k] = (acc[k] || 0) + 1;
            return acc;
        }, {});
    }

    function sortedEntries(obj, dir = 'desc') {
        return Object.entries(obj).sort((a, b) => dir === 'desc' ? b[1] - a[1] : a[1] - b[1]);
    }

    // ── Render KPIs ───────────────────────────────
    function renderKPI(data) {
        $('#kpiTotal').text(data.length);
        $('#kpiJurusan').text([...new Set(data.map(m => m.jurusan).filter(Boolean))].length);
        $('#kpiAngkatan').text([...new Set(data.map(m => m.angkatan).filter(Boolean))].length);
        $('#kpiEmail').text(data.filter(m => m.email && m.email.trim()).length);

        const now = new Date();
        $('#lastUpdate').html(`<i class="bi bi-clock"></i> ${now.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'})}`);
    }

    // ── Bar Chart: per Jurusan ────────────────────
    function renderBarJurusan(data) {
        const grouped = groupBy(data, 'jurusan');
        const entries = sortedEntries(grouped);
        const labels  = entries.map(e => e[0]);
        const values  = entries.map(e => e[1]);
        const colors  = labels.map((_, i) => PALETTE[i % PALETTE.length]);

        if (chartJurusan) chartJurusan.destroy();
        const ctx = document.getElementById('chartJurusan').getContext('2d');
        chartJurusan = new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Mahasiswa',
                    data: values,
                    backgroundColor: colors.map(c => hexToRgba(c, 0.85)),
                    borderColor: colors,
                    borderWidth: 1.5,
                    borderRadius: 7,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f8fafc',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} mahasiswa`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, maxRotation: 30 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 1, font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ── Donut Chart: proporsi ─────────────────────
    function renderDonut(data) {
        const grouped = groupBy(data, 'jurusan');
        const entries = sortedEntries(grouped).slice(0, 6);
        const labels  = entries.map(e => e[0]);
        const values  = entries.map(e => e[1]);
        const total   = values.reduce((a, b) => a + b, 0);
        const colors  = labels.map((_, i) => PALETTE[i % PALETTE.length]);

        if (chartDonut) chartDonut.destroy();
        const ctx = document.getElementById('chartDonut').getContext('2d');
        chartDonut = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors.map(c => hexToRgba(c, 0.88)),
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f8fafc',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => ` ${ctx.parsed} mahasiswa (${Math.round(ctx.parsed / total * 100)}%)`
                        }
                    }
                }
            }
        });

        // Legend
        const html = entries.map((e, i) => `
            <div class="legend-item">
                <div class="legend-dot" style="background:${colors[i]}"></div>
                <div class="legend-label">${e[0]}</div>
                <span class="legend-val">${e[1]}</span>
                <span class="legend-pct">${Math.round(e[1] / total * 100)}%</span>
            </div>
        `).join('');
        $('#legendDonut').html(html);
    }

    // ── Line Chart: tren angkatan ─────────────────
    function renderLineAngkatan(data) {
        const grouped = groupBy(data, 'angkatan');
        const entries = Object.entries(grouped)
            .filter(e => e[0] !== '—')
            .sort((a, b) => parseInt(a[0]) - parseInt(b[0]));
        const labels = entries.map(e => e[0]);
        const values = entries.map(e => e[1]);

        if (chartAngkatan) chartAngkatan.destroy();
        if (!labels.length) return;

        const ctx = document.getElementById('chartAngkatan').getContext('2d');
        const grad = ctx.createLinearGradient(0, 0, 0, 220);
        grad.addColorStop(0, 'rgba(59,130,246,0.25)');
        grad.addColorStop(1, 'rgba(59,130,246,0.01)');

        chartAngkatan = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Mahasiswa',
                    data: values,
                    borderColor: '#3b82f6',
                    backgroundColor: grad,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f8fafc',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} mahasiswa`
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 1, font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ── Top Jurusan Ranking List ──────────────────
    function renderTopJurusan(data) {
        const grouped = groupBy(data, 'jurusan');
        const entries = sortedEntries(grouped).slice(0, 6);
        if (!entries.length) {
            $('#topJurusanList').html('<div class="empty-dash"><i class="bi bi-inbox"></i><p>Belum ada data.</p></div>');
            return;
        }
        const max = entries[0][1];
        const rankClasses = ['gold','silver','bronze','','',''];
        const rankIcons   = ['🥇','🥈','🥉','4','5','6'];
        const html = entries.map((e, i) => `
            <div class="top-item">
                <div class="top-rank ${rankClasses[i]}">${rankIcons[i]}</div>
                <div class="top-bar-wrap">
                    <div class="top-label">${e[0]}</div>
                    <div class="top-bar-bg">
                        <div class="top-bar-fill" data-width="${Math.round(e[1]/max*100)}%" style="width:0%"></div>
                    </div>
                </div>
                <div class="top-count">${e[1]}</div>
            </div>
        `).join('');
        $('#topJurusanList').html(html);
        // Animate bars
        setTimeout(() => {
            $('.top-bar-fill').each(function() {
                $(this).css('width', $(this).data('width'));
            });
        }, 80);
    }

    // ── Angkatan Grid ─────────────────────────────
    function renderAngkatanGrid(data) {
        const grouped = groupBy(data, 'angkatan');
        const entries = Object.entries(grouped)
            .filter(e => e[0] !== '—')
            .sort((a, b) => parseInt(b[0]) - parseInt(a[0]));
        if (!entries.length) {
            $('#angkatanGrid').html('<div class="empty-dash" style="grid-column:1/-1"><i class="bi bi-inbox"></i><p>Belum ada data angkatan.</p></div>');
            return;
        }
        const html = entries.map(e => `
            <div class="angkatan-chip">
                <div class="angkatan-year">${e[0]}</div>
                <div class="angkatan-count">${e[1]} mhs</div>
            </div>
        `).join('');
        $('#angkatanGrid').html(html);
    }

    // ── MAIN LOAD ─────────────────────────────────
    function loadAll() {
        const $btn = $('#btnRefresh');
        $btn.addClass('spinning');
        $.get('/mahasiswa', function(data) {
            renderKPI(data);
            if (!data.length) {
                $('#chartJurusan').closest('.puti-card').find('.card-body-pad').html(
                    '<div class="empty-dash"><i class="bi bi-inbox"></i><p>Belum ada data mahasiswa.</p></div>'
                );
                return;
            }
            renderBarJurusan(data);
            renderDonut(data);
            renderLineAngkatan(data);
            renderTopJurusan(data);
            renderAngkatanGrid(data);
        }).fail(function() {
            // Demo mode: tampilkan data contoh jika endpoint belum ada
            const demo = [
                {nim:'2021001',nama:'Andi',jurusan:'Teknik Informatika',angkatan:'2021',email:'andi@mail.com'},
                {nim:'2021002',nama:'Budi',jurusan:'Sistem Informasi',angkatan:'2021',email:'budi@mail.com'},
                {nim:'2022001',nama:'Citra',jurusan:'Teknik Informatika',angkatan:'2022',email:'citra@mail.com'},
                {nim:'2022002',nama:'Dina',jurusan:'Sains Data',angkatan:'2022',email:''},
                {nim:'2023001',nama:'Eko',jurusan:'Teknik Elektro',angkatan:'2023',email:'eko@mail.com'},
                {nim:'2023002',nama:'Fani',jurusan:'Teknik Informatika',angkatan:'2023',email:'fani@mail.com'},
                {nim:'2023003',nama:'Galih',jurusan:'Sistem Informasi',angkatan:'2023',email:''},
                {nim:'2024001',nama:'Hana',jurusan:'Sains Data',angkatan:'2024',email:'hana@mail.com'},
                {nim:'2024002',nama:'Ivan',jurusan:'Teknik Telekomunikasi',angkatan:'2024',email:'ivan@mail.com'},
                {nim:'2024003',nama:'Joko',jurusan:'Teknik Informatika',angkatan:'2024',email:'joko@mail.com'},
                {nim:'2025001',nama:'Kiki',jurusan:'Desain Komunikasi Visual',angkatan:'2025',email:'kiki@mail.com'},
                {nim:'2025002',nama:'Lina',jurusan:'Teknik Industri',angkatan:'2025',email:''},
            ];
            renderKPI(demo);
            renderBarJurusan(demo);
            renderDonut(demo);
            renderLineAngkatan(demo);
            renderTopJurusan(demo);
            renderAngkatanGrid(demo);
        }).always(function() {
            $btn.removeClass('spinning');
        });
    }

    $(document).ready(function() {
        loadAll();
    });
</script>
</body>
</html>
```

# Alur CRUD pada Aplikasi
1. Create (Tambah Data)
   Pengguna membuka halaman Form Input (index.html), mengisi field NIM, Nama Lengkap, Jurusan, Angkatan, dan Email, lalu menekan tombol Simpan Mahasiswa. Data dikirim ke server melalui AJAX POST ke endpoint /mahasiswa dan disimpan ke file db.json. Setelah berhasil, toast notifikasi sukses muncul dan daftar terbaru langsung diperbarui.
3. Read (Tampil Data)
   Pengguna membuka halaman Data (data.html). DataTables mengambil data JSON dari endpoint GET /mahasiswa secara otomatis menggunakan konfigurasi ajax. Data ditampilkan dalam tabel dengan fitur pencarian, sorting, dan pagination. Halaman Dashboard juga membaca data yang sama untuk visualisasi grafik.
4. Update (Edit Data)
Pengguna menekan tombol Edit pada baris data di tabel. Modal Bootstrap muncul menampilkan form yang sudah terisi data lama (diambil via GET /mahasiswa/:nim). Setelah diperbarui dan tombol Simpan ditekan, data dikirim ke server melalui AJAX PUT ke /mahasiswa/:nim dan tabel diperbarui tanpa reload halaman.
5. Delete (Hapus Data)
Pengguna menekan tombol Hapus pada baris data. Modal konfirmasi Bootstrap muncul menampilkan nama dan NIM mahasiswa yang akan dihapus. Setelah dikonfirmasi, AJAX DELETE dikirim ke /mahasiswa/:nim. Data dihapus dari file JSON dan tabel langsung diperbarui.

# Screenshot Website
1. Halaman Form Input Mahasiswa (index.html)

2. Halaman Data Mahasiswa (data.html)

3. Modal Edit Data Mahasiswa
   
5. Modal Konfirmasi Hapus Data
   
7. Halaman Dashboard Statistik (dashboard.html)

# Kesimpulan
Pada tugas COTS-2 ini telah berhasil dibuat aplikasi web bertema Sistem Data Mahasiswa (PuTi) menggunakan Express JS, Bootstrap 5, jQuery, jQuery DataTables, dan Chart.js. Aplikasi ini telah memenuhi seluruh ketentuan tugas praktikum karena memiliki tiga halaman utama fungsional, yaitu halaman Form Input, halaman Data Mahasiswa, dan halaman Dashboard Statistik.

Fitur CRUD berjalan dengan baik: Create melalui form input AJAX, Read melalui tabel DataTables yang mengambil data JSON dari endpoint, Update melalui modal edit Bootstrap, dan Delete melalui modal konfirmasi dengan AJAX DELETE. Semua operasi dilakukan secara asinkron tanpa reload halaman.

Halaman Dashboard menambahkan nilai lebih pada aplikasi dengan menampilkan visualisasi statistik menggunakan Chart.js, sehingga data mahasiswa dapat dianalisis secara visual. Walaupun data masih disimpan dalam file JSON, aplikasi ini sudah menunjukkan implementasi dasar konsep CRUD dan REST API berbasis client-server yang baik.

# Link Video Presentasi
