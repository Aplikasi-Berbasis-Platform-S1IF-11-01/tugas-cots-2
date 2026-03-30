# 📚 Aplikasi CRUD Mahasiswa
### Tugas Praktikum Web | Node.js + Express + Bootstrap 5 + jQuery + DataTables

---

## 🗂️ Struktur Folder Project

```
praktikum-crud/
│
├── server.js              ← File utama, menjalankan server Express
├── package.json           ← Konfigurasi project & daftar dependency
│
├── routes/
│   └── mahasiswa.js       ← Semua endpoint API (CRUD)
│
├── views/
│   ├── index.html         ← Halaman 1: Dashboard
│   ├── form.html          ← Halaman 2: Form Tambah/Edit
│   └── tabel.html         ← Halaman 3: Tabel DataTables
│
├── public/
│   └── css/
│       └── style.css      ← Custom CSS
│
└── data/
    └── mahasiswa.json     ← "Database" penyimpanan data (JSON)
```

---

## 🛠️ Teknologi yang Digunakan

| Teknologi     | Kegunaan                         |
|---------------|----------------------------------|
| Node.js       | Runtime JavaScript server-side   |
| Express.js    | Framework web server             |
| Bootstrap 5   | Framework CSS (styling & layout) |
| jQuery 3.7    | Library JavaScript (AJAX, DOM)   |
| DataTables    | jQuery Plugin tabel interaktif   |
| JSON File     | Penyimpanan data sederhana       |

---

## 🚀 Cara Menjalankan Aplikasi

### Prasyarat
- Node.js sudah terinstall (versi 14 ke atas)
- Terminal / Command Prompt

### Langkah-langkah

```bash
# 1. Masuk ke folder project
cd praktikum-crud

# 2. Install dependency (hanya pertama kali)
npm install

# 3. Jalankan server
npm start
# atau: node server.js

# 4. Buka browser, akses:
#    http://localhost:3000
```

---

## 📄 Penjelasan Halaman

### Halaman 1: Dashboard (`/`)
- Menampilkan statistik: total mahasiswa, aktif, jurusan, rata-rata IPK
- Menggunakan jQuery AJAX untuk mengambil data dari API
- File: `views/index.html`

### Halaman 2: Form (`/form`)
- Form untuk **Tambah** data mahasiswa baru
- Juga digunakan untuk **Edit** data (akses via `/form?edit=ID`)
- Validasi form menggunakan Bootstrap 5 built-in validation
- File: `views/form.html`

### Halaman 3: Tabel (`/tabel`)
- Menampilkan semua data menggunakan **jQuery DataTables Plugin**
- Fitur: pencarian, paginasi, pengurutan kolom otomatis
- Tombol Edit (redirect ke form) dan Hapus (konfirmasi modal)
- File: `views/tabel.html`

---

## 🔌 API Endpoints

| Method | URL                       | Fungsi            |
|--------|---------------------------|-------------------|
| GET    | `/api/mahasiswa`          | Ambil semua data  |
| GET    | `/api/mahasiswa/:id`      | Ambil satu data   |
| POST   | `/api/mahasiswa`          | Tambah data baru  |
| PUT    | `/api/mahasiswa/:id`      | Update data       |
| DELETE | `/api/mahasiswa/:id`      | Hapus data        |

### Format Response JSON

```json
// GET /api/mahasiswa (format DataTables)
{
  "draw": 1,
  "recordsTotal": 5,
  "recordsFiltered": 5,
  "data": [
    {
      "id": "1",
      "nama": "Budi Santoso",
      "nim": "2021001",
      "jurusan": "Teknik Informatika",
      "ipk": "3.75",
      "email": "budi@mahasiswa.ac.id",
      "status": "Aktif"
    }
  ]
}
```

---

## 💡 Fitur CRUD

| Fitur  | Cara Kerja |
|--------|-----------|
| Create | Form `/form` → Submit → jQuery AJAX POST → API → Simpan ke JSON |
| Read   | DataTables → AJAX GET ke API → Tampilkan di tabel |
| Update | Klik Edit → `/form?edit=ID` → Isi form → PUT ke API |
| Delete | Klik Hapus → Modal konfirmasi → AJAX DELETE → API → Reload tabel |

---

## 📝 Script Presentasi (Panduan Video ±10 Menit)

### Bagian 1: Intro (1 menit)
> "Selamat datang di presentasi tugas praktikum web. Saya akan memperkenalkan aplikasi Sistem Informasi Mahasiswa yang dibangun dengan Node.js, Express, Bootstrap 5, jQuery, dan DataTables."

### Bagian 2: Struktur Project (2 menit)
- Tunjukkan struktur folder di VS Code / File Explorer
- Jelaskan fungsi setiap file:
  - `server.js` → titik masuk aplikasi
  - `routes/mahasiswa.js` → API endpoint CRUD
  - `views/*.html` → halaman frontend
  - `data/mahasiswa.json` → penyimpanan data

### Bagian 3: Demo Halaman (5 menit)

**Dashboard (`/`)**
> "Halaman pertama adalah dashboard yang menampilkan statistik mahasiswa. Data diambil menggunakan jQuery AJAX dari endpoint API."

**Form Tambah (`/form`)**
> "Halaman kedua adalah form input. Saya akan menambah data mahasiswa baru."
- Demo: Isi form → klik Simpan → lihat alert sukses

**Tabel (`/tabel`)**
> "Halaman ketiga menggunakan jQuery Plugin DataTables. Fiturnya sudah termasuk pencarian, paginasi, dan sorting otomatis."
- Demo: Cari data → ganti jumlah per halaman → klik kolom untuk sort

**Edit Data**
> "Untuk edit, klik tombol kuning. Form akan terisi otomatis dengan data yang ada."
- Demo: Edit nama/jurusan → simpan → lihat perubahan di tabel

**Hapus Data**
> "Untuk hapus, klik tombol merah. Akan muncul konfirmasi sebelum data benar-benar dihapus."
- Demo: Klik hapus → konfirmasi → data hilang dari tabel

### Bagian 4: Penjelasan Kode (2 menit)

**Server (server.js)**
> "server.js adalah file utama Express. Di sini kita setup middleware, routing halaman, dan routing API."

**API Routes (routes/mahasiswa.js)**
> "Semua logika CRUD ada di sini. Untuk READ menggunakan GET, CREATE dengan POST, UPDATE dengan PUT, dan DELETE dengan method DELETE. Data disimpan dalam file JSON."

**DataTables (tabel.html)**
> "DataTables diinisialisasi dengan konfigurasi `ajax` yang mengarah ke API kita. Format respons JSON harus memiliki properti `data` yang berisi array."

**AJAX jQuery (form.html)**
> "Di form.html, jQuery menangkap event submit, mengumpulkan data form, dan mengirimnya ke API menggunakan `$.ajax()` tanpa reload halaman."

### Penutup
> "Demikian presentasi aplikasi CRUD Mahasiswa. Terima kasih."

---

## 🔧 Troubleshooting

**Port sudah dipakai:**
```bash
# Ganti PORT di server.js (baris: const PORT = 3000)
# Atau kill proses di port 3000:
npx kill-port 3000
```

**Module not found:**
```bash
npm install  # Jalankan ulang
```

**Data tidak muncul di tabel:**
- Pastikan file `data/mahasiswa.json` ada dan formatnya valid
- Cek console browser untuk error AJAX
