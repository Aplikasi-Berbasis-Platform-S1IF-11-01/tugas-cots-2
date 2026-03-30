<div align="center">
  <br />
  <h1>LAPORAN PRAKTIKUM <br>APLIKASI BERBASIS PLATFORM</h1>
  <br />
  <h3>Tugas COTS-2 <br></h3>
  <br />
  <br />
 <img src="assets/logo.jpeg" alt ="logo" width = "300"> 
  <br />
  <br />
  <h3>Disusun Oleh :</h3>
  <p>
    <strong>Yoga Hogantara</strong><br>
    <strong>2311102153</strong><br>
    <strong>S1 IF-11-01</strong>
  </p>
  <br />
  <br />
  <h3>Dosen Pengampu :</h3>
  <p>
    <strong>Dimas Fanny Hebrasianto Permadi, S.ST., M.Kom</strong>
  </p>
  <br />
  <br />
  <h4>Asisten Praktikum :</h4>
  <strong>Apri Pandu Wicaksono</strong> <br>
  <strong>Rangga Pradarrell Fathi</strong>
  <br />
  <h3>LABORATORIUM HIGH PERFORMANCE
 <br>FAKULTAS INFORMATIKA <br>UNIVERSITAS TELKOM PURWOKERTO <br>2026</h3>
</div>

---

## 1. Dasar Teori

**CRUD (Create, Read, Update, Delete)** merupakan empat operasi utama yang digunakan untuk mengelola data dalam sebuah aplikasi. Pada pengembangan aplikasi web, konsep CRUD digunakan agar pengguna dapat menambahkan data, menampilkan data, memperbarui data, serta menghapus data secara dinamis

**Bootstrap** adalah framework CSS bersifat open-source yang menyediakan berbagai komponen antarmuka siap pakai, seperti form, tombol, navbar, dan card.Pada proyek ini, Bootstrap digunakan untuk membangun tema *Dark Mode* yang responsif

**jQuery** adalah library JavaScript yang digunakan untuk mempermudah manipulasi DOM dan AJAX. Dengan jQuery, interaksi pada halaman web seperti penghapusan data dapat dilakukan tanpa memuat ulang seluruh halaman

**jQuery DataTables** merupakan plugin yang berfungsi untuk meningkatkan fitur pada elemen `<table>` HTML, seperti pencarian data (*search*), pengurutan (*sorting*), dan pembagian halaman (*pagination*) secara otomatis.

**JSON (JavaScript Object Notation)** adalah format pertukaran data yang ringan dan mudah dibaca.Data mahasiswa disimpan dalam file `data.json` untuk dikelola oleh server.

**Node.js & Express JS** adalah runtime dan framework backend yang digunakan untuk membangun aplikasi web, menangani request HTTP, routing, dan menyediakan endpoint data JSON.

**EJS (Embedded JavaScript Templates)** adalah template engine yang digunakan untuk membuat halaman HTML dinamis dengan menyisipkan data dari server langsung ke halaman menggunakan sintaks tertentu

---

## 2. Kode Program

### A. `package.json`

```json
{
  "name": "tugas2",
  "version": "1.0.0",
  "description": "",
  "main": "index.js",
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1"
  },
  "keywords": [],
  "author": "",
  "license": "ISC",
  "type": "commonjs",
  "dependencies": {
    "body-parser": "^2.2.2",
    "ejs": "^5.0.1",
    "express": "^5.2.1"
  }
}

```

**Penjelasan `package.json`**

file `package.json` untuk sebuah proyek Node.js bernama tugas2 dengan versi 1.0.0, yang berfungsi sebagai “identitas” sekaligus pengatur dependensi proyek. Bagian "main": "index.js" menunjukkan file utama yang akan dijalankan, sedangkan "scripts" berisi perintah yang bisa dijalankan lewat terminal, meskipun di sini hanya ada script test sederhana yang belum dipakai. Proyek ini menggunakan sistem modul "commonjs" (standar Node.js klasik), dan memiliki beberapa library penting di "dependencies" seperti express untuk membuat server web, ejs sebagai template engine agar bisa menampilkan halaman dinamis, serta body-parser untuk membaca data dari request (misalnya dari form).

---

### B. Backend `app.js`

```javascript
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
```

**Penjelasan `app.js`**

File `app.js` merupakan inti dari aplikasi karena di dalamnya terdapat konfigurasi server Express, middleware, fungsi pengelolaan data JSON, routing halaman, serta API untuk operasi CRUD data mahasiswa.

Pada bagian awal, dilakukan import library express, body-parser, fs, dan path. Library express digunakan untuk membuat server, body-parser untuk membaca data dari request (baik form maupun JSON), fs untuk membaca dan menulis file sebagai penyimpanan data, serta path untuk mengatur lokasi file secara aman.

`express.static('public')` digunakan agar file statis seperti CSS dan gambar bisa diakses dari folder public.
`bodyParser.urlencoded({ extended: true })` membaca data dari form HTML.
`bodyParser.json()` membaca data dalam format JSON dari request.

EJS diaktifkan sebagai template engine menggunakan app.set('view engine', 'ejs'), sehingga server dapat merender halaman dinamis seperti index, form, data, dan edit dari folder views.

Fungsi `readData()` digunakan untuk membaca isi file JSON dan mengubahnya menjadi object JavaScript, serta akan mengembalikan array kosong jika terjadi error (misalnya file belum ada). Fungsi writeData() digunakan untuk menyimpan atau memperbarui data ke dalam file JSON dengan format yang rapi.

Pada bagian routing, terdapat beberapa endpoint untuk menampilkan halaman seperti / (halaman utama), /form (form input), /data (menampilkan data), dan /edit/:id (mengedit data berdasarkan id). Jika data tidak ditemukan, maka akan diarahkan kembali ke halaman data.

API untuk operasi CRUD:

`GET /api/students`  mengambil seluruh data mahasiswa.
`POST /api/students` menambahkan data baru atau mengedit data jika id sudah ada.
`DELETE /api/students/:id` menghapus data berdasarkan id.

Terakhir, server dijalankan pada port 3000 dan dapat diakses melalui http://localhost:3000.



---

### C. File Data `data/data.json`

Kondisi awal (kosong):

```json
[]
```

Contoh isi setelah data ditambahkan:

```json
[
  {
    "id": 1774789879130,
    "nama": "Yoga Hogantara",
    "nim": "2311102153",
    "jurusan": "Teknik Informatika"
  }
]
```

**Penjelasan `data.json`**

File `data.json` berfungsi sebagai media penyimpanan data sederhana. awalnya file ini berisi array kosong. Setelah pengguna menambahkan data melalui form, data mahasiswa akan disimpan sebagai objek JSON di dalam array tersebut. Setiap objek memiliki atribut `id`, `nim`, `nama`, `jurusan`. File ini berperan seperti database sederhana dalam aplikasi.

---

### D. Header `views/partials/header.ejs`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YHOTA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body { 
            background-color: #121212; 
            color: #f8f9fa !important; 
            font-family: 'Segoe UI', sans-serif; 
        }

        .navbar { 
            border-bottom: 1px solid #333; 
            background-color: #121212 !important; 
            padding: 25px 0; 
        }
        .navbar-brand { 
            font-weight: 900; 
            letter-spacing: 4px; 
            color: #ffffff !important; 
            font-size: 1.5rem; 
            text-decoration: none;
        }

        .nav-custom-group {
            display: flex;
            flex-direction: row;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link-custom { 
            color: #f8f9fa !important; 
            font-size: 0.8rem; 
            letter-spacing: 2px; 
            font-weight: 700; 
            text-decoration: none;
            transition: 0.3s;
            opacity: 0.7;
        }
        .nav-link-custom:hover { 
            opacity: 1; 
        }

        .main-card { background-color: #1e1e1e; border: 1px solid #333; border-radius: 8px; padding: 25px; }
        h1, h2, h3, h4, h5, label { color: #ffffff !important; }

        input, select, .dataTables_filter input { background: #2a2a2a !important; border: 1px solid #444 !important; color: #ffffff !important; }
        table.dataTable { color: #f8f9fa !important; }
        .text-muted { color: #888 !important; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="/">YHOTA</a>
            
            <div class="nav-custom-group">
                <a class="nav-link-custom" href="/">HOME</a>
                <a class="nav-link-custom" href="/data">DATABASE</a>
                <a class="nav-link-custom" href="/form">ADD NEW</a>
            </div>
        </div>
    </nav>
```

**Penjelasan `header.ejs`**

File `header.ejs` digunakan sebagai bagian atas (header) yang dipakai ulang di setiap halaman. Di dalamnya sudah mencakup struktur awal HTML, bagian `<head>`, pemanggilan CSS seperti Bootstrap dan DataTables, serta navbar untuk navigasi antar halaman. Dengan menggunakan partial seperti ini, penulisan kode jadi lebih rapi karena tidak perlu mengulang header di setiap file. Selain itu, penggunaan `<%= title %>` memungkinkan judul halaman berubah secara otomatis sesuai halaman yang sedang dibuka.

---

### E. Footer `views/partials/footer.ejs`

```html
<footer class="container mt-5 py-4 border-top border-secondary text-center">
        <p class="text-muted small">Yoga Hogantara 2311102153</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</body>
</html>
```

**Penjelasan `footer.ejs`**

File `footer.ejs` merupakan partial untuk bagian bawah setiap halaman. Di dalamnya terdapat elemen `<footer>` yang berisi teks identitas dengan styling sederhana seperti jarak (margin, padding), garis atas, dan posisi teks di tengah agar terlihat rapi. Tulisan di dalamnya menggunakan kelas text-muted dan small sehingga tampil lebih halus dan tidak terlalu mencolok.

---

### F. Halaman Beranda `views/index.ejs`

```html
<%- include('partials/header') %>
<div class="container text-center py-5">
    <h1 class="display-4 fw-bold text-white mb-3">Yhota Database anjay</h1>
    <p class="text-muted lead mb-5">Sistem management mahasiswa Yhota</p>
    <div class="d-flex justify-content-center gap-3">
        <a href="/data" class="btn btn-outline-light px-4 py-2">LIHAT DATA</a>
        <a href="/form" class="btn btn-light px-4 py-2">INPUT BARU</a>
    </div>
</div>
<%- include('partials/footer') %>
```

**Penjelasan `index.ejs`**

File `index.ejs` berfungsi sebagai halaman utama atau tampilan awal saat aplikasi dibuka. Di halaman ini ditampilkan judul aplikasi, teknologi yang digunakan, identitas mahasiswa, serta tombol navigasi yang mengarah ke halaman form input dan halaman data. Halaman ini dibuat sebagai pengenalan agar pengguna punya gambaran dulu tentang aplikasi sebelum menggunakan fitur-fitur utamanya.

---

### G. Halaman Form Input `views/form.ejs`

```html
<%- include('partials/header') %>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="main-card shadow-lg p-5">
                <h3 class="fw-bold mb-4 text-center">ENTRY DATA</h3>
                <form id="formAction">
                    <div class="mb-3">
                        <label class="small text-muted mb-2">NOMOR INDUK MAHASISWA</label>
                        <input type="text" name="nim" class="form-control" required placeholder="Contoh: 231110XXXX">
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted mb-2">NAMA LENGKAP</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Masukkan Nama">
                    </div>
                    <div class="mb-4">
                        <label class="small text-muted mb-2">JURUSAN</label>
                        <input type="text" name="jurusan" class="form-control" required placeholder="Ketik Jurusan (ex: Informatika)">
                    </div>
                    <button type="submit" class="btn btn-light w-100 fw-bold py-3 text-dark">SAVE DATA</button>
                </form>
            </div>
        </div>
    </div>
</div>

<%- include('partials/footer') %>

<script>
    $('#formAction').on('submit', function(e) {
        e.preventDefault();
        $.ajax({ 
            url: '/api/students', 
            type: 'POST', 
            data: $(this).serialize(), 
            success: () => { 
                alert('Data Berhasil Ditambah!'); 
                window.location.href = '/data'; 
            } 
        });
    });
</script>
```

**Penjelasan `form.ejs`**

File `form.ejs` menampilkan halaman form untuk menambahkan data mahasiswa yang menggunakan EJS dengan bantuan partial header dan footer agar tampilan lebih konsisten. Di bagian utama terdapat form sederhana dengan tiga input yaitu NIM, nama lengkap, dan jurusan yang wajib diisi, lalu disusun rapi menggunakan Bootstrap agar terlihat lebih modern.
Saat tombol “SAVE DATA” ditekan, data tidak langsung reload halaman, melainkan dikirim menggunakan jQuery AJAX ke endpoint /api/students dengan metode POST. Jika proses berhasil, akan muncul notifikasi lalu otomatis diarahkan ke halaman data untuk melihat hasil yang sudah ditambahkan.

---

### H. Halaman Data `views/data.ejs`

```html
<%- include('partials/header') %>
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2>DATABASE</h2>
            </div>
        </div>
        <div class="main-card shadow-lg">
            <table id="myTable" class="table w-100" style="color: #f0ead6;">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>JURUSAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <%- include('partials/footer') %>
        <script>
            $(document).ready(function () {
                const table = $('#myTable').DataTable({
                    ajax: '/api/students',
                    columns: [
                        { data: 'nim' },
                        { data: 'nama', render: (d) => d.toUpperCase() },
                        { data: 'jurusan' },
                        {
                            data: 'id',
                            render: (data) => `
                                <div class="btn-group">
                                    <a href="/edit/${data}" class="btn btn-sm" style="background:#d4a017; color:#ffffff !important; font-weight:bold; border:none;">EDIT</a>
                                    <button class="btn btn-sm" style="background:#a30000; color:#ffffff !important; font-weight:bold; border:none;" onclick="hapus(${data})">HAPUS</button>
                                </div>`
                        }
                    ]
                });
                window.hapus = (id) => {
                    if (confirm('Hapus data?')) $.ajax({ url: `/api/students/${id}`, type: 'DELETE', success: () => table.ajax.reload() });
                };
            });
        </script>
```

**Penjelasan `data.ejs`**

File `data.ejs` menampilkan data mahasiswa dalam bentuk tabel. menggunakan EJS, dengan bantuan partial header dan footer agar tampilan tetap konsisten. Di bagian utama terdapat judul “DATABASE” dan sebuah tabel yang akan menampilkan seluruh data dari file JSON.
Tabel tersebut menggunakan plugin DataTables sehingga data bisa ditampilkan secara dinamis melalui AJAX dari endpoint /api/students. Kolom yang ditampilkan meliputi NIM, nama (yang otomatis dibuat huruf besar), jurusan, dan aksi. Pada kolom aksi tersedia tombol EDIT untuk mengarah ke halaman edit, serta tombol HAPUS yang akan menghapus data berdasarkan id. Proses hapus dilakukan menggunakan jQuery AJAX dengan method DELETE, dan setelah data berhasil dihapus, tabel akan otomatis diperbarui tanpa perlu reload halaman.

---

### I. Halaman Edit `views/edit.ejs`

```html
<%- include('partials/header') %>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="main-card shadow-lg p-5" style="border-color: #d4a017;">
                <h3 class="fw-bold mb-4 text-center" style="color: #d4a017;">EDIT DATA</h3>
                <form id="formEdit">
                    <input type="hidden" name="id" value="<%= student.id %>">
                    <div class="mb-3">
                        <label class="small text-muted mb-2">NIM</label>
                        <input type="text" name="nim" class="form-control" value="<%= student.nim %>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted mb-2">NAMA</label>
                        <input type="text" name="nama" class="form-control" value="<%= student.nama %>" required>
                    </div>
                    <div class="mb-4">
                        <label class="small text-muted mb-2">JURUSAN</label>
                        <input type="text" name="jurusan" class="form-control" value="<%student.jurusan%>" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold py-3" style="background:#d4a017; color:#ffffff !important; border:none;">UPDATE DATA</button>
                </form>
            </div>
        </div>
    </div>
</div>
<%- include('partials/footer') %>
<script>
    $('#formEdit').on('submit', function(e) {
        e.preventDefault();
        $.ajax({ url: '/api/students', type: 'POST', data: $(this).serialize(), success: () => { alert('Terupdate!'); window.location.href = '/data'; } });
    });
</script>
```

**Penjelasan `edit.ejs`**

File `edit.ejs` menampilkan halaman edit data mahasiswa.engguna dapat mengubah data melalui input dan dropdown jurusan, lalu menekan tombol “UPDATE DATA”. Saat dikirim, data diproses menggunakan jQuery AJAX ke endpoint /api/students dengan metode POST, dan karena ada id, sistem akan menganggapnya sebagai proses update. Jika berhasil, akan muncul notifikasi dan pengguna diarahkan kembali ke halaman data.

---

## 3. Screenshot Website

1. Tampilan Awal Halaman
![](assets/1.PNG)
2. Halaman Form Input Mahasiswa
![](assets/2.PNG)
3. Halaman Data Mahasiswa
![](assets/3.PNG)
4. Halaman Edit Data Mahasiswa
![](assets/4.PNG)
5. Hasil Update Data
![](assets/5.PNG)
6. Proses Hapus Data
![](assets/6.PNG)
---

## 4. Kesimpulan

Pada tugas COTS 2 ini berhasil dibuat aplikasi web sederhana bertema Sistem Data Mahasiswa menggunakan **Express JS**, **Bootstrap**, **jQuery**, dan **DataTables**. Aplikasi ini sudah memenuhi kebutuhan praktikum karena memiliki halaman form, tabel data, serta fitur CRUD lengkap, dengan data ditampilkan dalam format JSON melalui API.

Express JS membantu membuat backend lebih terstruktur, sementara Bootstrap, jQuery, dan DataTables membuat tampilan lebih responsif dan interaktif. Walaupun masih menggunakan file JSON sebagai penyimpanan, aplikasi ini sudah cukup menunjukkan konsep dasar CRUD berbasis client-server.
---

## 5. Referensi

1. https://expressjs.com
2. https://nodejs.org
3. https://getbootstrap.com
4. https://jquery.com
5. https://datatables.net
6. https://ejs.co

## 6. Link Video Presentasi
[https://drive.google.com/file/d/10lFjz_mV8Ch9Q_6vXwfb9Qz64nvECWdJ/view?usp=sharing]

