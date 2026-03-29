# 🎓 SIAKAD — Sistem Informasi Akademik Mahasiswa

Aplikasi web CRUD manajemen data mahasiswa berbasis **Node.js (Express)** dengan **Bootstrap 5**, **jQuery**, dan **DataTables**.

---

## 📋 Fitur

| Fitur | Keterangan |
|-------|-----------|
| ✅ Dashboard | Kartu statistik + DataTable via AJAX/JSON |
| ✅ Tambah Mahasiswa | Form dengan validasi jQuery Validate |
| ✅ Edit Mahasiswa | Form pre-filled, validasi duplikat NIM |
| ✅ Hapus Mahasiswa | Konfirmasi SweetAlert2, AJAX DELETE |
| ✅ Detail Mahasiswa | Profil lengkap + JSON preview |
| ✅ DataTables | Pencarian, sorting, pagination, data JSON |
| ✅ Responsive | Sidebar collapsible untuk mobile |

---

## 🛠️ Teknologi

- **Backend**: Node.js + Express.js
- **Templating**: EJS
- **Storage**: JSON File (`data/mahasiswa.json`)
- **Frontend**: Bootstrap 5.3 + Bootstrap Icons
- **jQuery**: v3.7.1
- **jQuery Plugins**: 
  - DataTables 1.13 (bootstrap5 skin)
  - jQuery Validation 1.19
  - SweetAlert2 (popup alerts)
- **Font**: Plus Jakarta Sans + JetBrains Mono

---

## 🚀 Cara Menjalankan

### Prasyarat
- Node.js v16+ terpasang

### Langkah

```bash
# 1. Masuk ke folder proyek
cd mahasiswa-app

# 2. Install dependensi
npm install

# 3. Jalankan aplikasi
npm start

# Atau dengan auto-reload (install nodemon dulu):
npm install -g nodemon
npm run dev
```

Buka browser: **http://localhost:3000**

---

## 📁 Struktur Proyek

```
mahasiswa-app/
├── app.js                  ← Server utama (Express routes + API)
├── package.json
├── data/
│   └── mahasiswa.json      ← Penyimpanan data (JSON)
├── views/
│   ├── header.ejs          ← Sidebar + Topbar
│   ├── footer.ejs          ← Scripts + Modal
│   ├── index.ejs           ← Halaman Dashboard (DataTable)
│   ├── form.ejs            ← Halaman Tambah/Edit
│   └── detail.ejs          ← Halaman Detail Mahasiswa
└── public/
    ├── css/style.css       ← Custom styling
    └── js/main.js          ← jQuery logic + DataTables + CRUD
```

---

## 🌐 Endpoint API

| Method | URL | Keterangan |
|--------|-----|-----------|
| GET | `/api/mahasiswa` | Ambil semua data (JSON) |
| GET | `/api/mahasiswa/:id` | Ambil satu data |
| DELETE | `/api/mahasiswa/:id` | Hapus data (AJAX) |
| POST | `/tambah` | Simpan data baru |
| POST | `/edit/:id` | Update data |

---

## 📝 Halaman

| No | URL | Fungsi |
|----|-----|--------|
| 1 | `/` | Dashboard + Tabel Data |
| 2 | `/tambah` | Form Tambah Mahasiswa |
| 3 | `/edit/:id` | Form Edit Mahasiswa |
| 4 | `/detail/:id` | Detail Mahasiswa |
