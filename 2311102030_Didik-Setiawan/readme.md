

<div align="center">
  <br />
  <h1>LAPORAN PRAKTIKUM <br>APLIKASI BERBASIS PLATFORM</h1>
  <br />
  <h3>COTS-2 <br> </h3>
  <br />
  <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2F1.bp.blogspot.com%2F-vb7jyBjK-sM%2FXXfKp51LrjI%2FAAAAAAAACts%2FEjcXzlgZwSswNWXsBHMyX-6aav1mjA77QCPcBGAYYCw%2Fs1600%2FLogo_Telkom_University_potrait.png&f=1&nofb=1&ipt=9d030d54102ea96369d39fe491220e0536195abc8ee443279c1a420302206400" alt="Logo Telkom" width="300"> 
  <br /><br /><br />
  
  <h3>Disusun Oleh :</h3>
  <p>
    <strong>Didik Setiawan</strong><br>
    <strong>2311102030</strong><br>
    <strong>IF-11-REG-01</strong>
  </p>
  <br />
  
  <h3>Dosen Pengampu :</h3>
  <p><strong>Dimas Fanny Hebrasianto Permadi, S.ST., M.Kom</strong></p>
  <br />
  
  <h4>Asisten Praktikum :</h4>
  <strong>Apri Pandu Wicaksono</strong> <br>
  <strong>Rangga Pradarrell Fathi</strong>
  <br />
  
  <h3>LABORATORIUM HIGH PERFORMANCE<br>FAKULTAS INFORMATIKA<br>UNIVERSITAS TELKOM PURWOKERTO<br>2026</h3>
</div>

---

## DASAR TEORI

Dalam pengembangan sistem pendataan berbasis web ini, terdapat beberapa teknologi dan konsep utama yang digunakan:

* **Node.js & Express.js**
  Node.js adalah lingkungan eksekusi lintas platform yang memungkinkan JavaScript berjalan di sisi server (*backend*). Sementara itu, Express.js adalah kerangka kerja (*framework*) web yang sangat ringan dan fleksibel untuk Node.js, dirancang khusus untuk mempermudah pembuatan aplikasi web dan *Application Programming Interface* (API) melalui fitur *routing* dan *middleware*.

* **EJS (Embedded JavaScript Templating)**
  EJS adalah *template engine* yang memadukan kode JavaScript langsung ke dalam markup HTML. Teknologi ini memungkinkan server untuk menyisipkan data secara dinamis ke dalam halaman web sebelum halaman tersebut dikirimkan dan ditampilkan pada peramban (*browser*) klien.

* **DataTables & jQuery**
  DataTables adalah *plug-in* tangguh untuk pustaka jQuery yang digunakan untuk memanipulasi tabel HTML standar. Dengan DataTables, tabel statis dapat diubah menjadi tabel interaktif yang dilengkapi dengan fitur pengurutan (*sorting*), pencarian (*searching*), dan pembagian halaman (*pagination*) secara otomatis dan instan di sisi klien.

* **AJAX (Asynchronous JavaScript and XML)**
  AJAX adalah serangkaian teknik pengembangan web yang memungkinkan aplikasi berkomunikasi dengan server di latar belakang. Dengan metode ini, pertukaran data (seperti proses menghapus baris data) dapat dilakukan secara asinkron tanpa harus memuat ulang (*refresh*) keseluruhan halaman web, sehingga menghasilkan pengalaman pengguna yang lebih mulus.

* **Bootstrap 5**
  Bootstrap adalah kerangka kerja CSS sumber terbuka (*open-source*) yang berfokus pada pengembangan *front-end* yang responsif dan *mobile-first*. Penggunaannya membantu mempercepat proses *styling* antarmuka, seperti pembuatan tombol, formulir, dan struktur tata letak.

* **Konsep CRUD**
  CRUD adalah singkatan dari *Create* (Menambah), *Read* (Membaca/Menampilkan), *Update* (Memperbarui), dan *Delete* (Menghapus). Keempat operasi ini merupakan fondasi dasar dari hampir semua sistem manajemen data dan aplikasi yang berinteraksi dengan basis data.




## Deskripsi

Aplikasi ini adalah **Sistem Pendataan Mahasiswa** berbasis web yang dibangun menggunakan Node.js dan kerangka kerja Express. Aplikasi ini dirancang untuk melakukan operasi CRUD (Create, Read, Update, Delete) sederhana pada data mahasiswa. 

Fitur utama dari aplikasi ini meliputi:
* **Tampil Data Interaktif:** Menampilkan daftar mahasiswa menggunakan DataTables yang mendukung fitur pencarian (*searching*) dan pembagian halaman (*pagination*) secara instan.
* **Tambah & Edit Data:** Formulir dinamis yang dibangun menggunakan Bootstrap 5 dan dirender oleh EJS untuk menambah mahasiswa baru atau memperbarui data yang sudah ada.
* **Hapus Data Asinkron:** Penghapusan data dilakukan menggunakan metode AJAX di latar belakang, sehingga tabel diperbarui tanpa perlu memuat ulang keseluruhan halaman.

Data mahasiswa saat ini disimpan secara sementara (*dummy database*) di dalam memori server menggunakan *array* JavaScript.



## STRUKTUR FOLDER

Berikut adalah struktur direktori dari proyek aplikasi ini:

```text
tugas-praktikum-web/
├── node_modules/           # Direktori berisi dependensi library Node.js (otomatis dibuat setelah npm install)
├── views/                  # Direktori berisi file template tampilan aplikasi
│   ├── edit.ejs            # Halaman formulir untuk mengedit data mahasiswa
│   ├── index.ejs           # Halaman utama yang memuat tabel data mahasiswa
│   └── tambah.ejs          # Halaman formulir untuk menambah data mahasiswa baru
├── app.js                  # File utama aplikasi (server Express, routing, dan logika CRUD)
├── package-lock.json       # File yang mengunci versi spesifik dari setiap dependensi
├── package.json            # File konfigurasi project (daftar dependensi dan script npm)
```



## KODE PROGRAM

### 1. `app.js`

```
const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const port = 3000;

// ============================================================
// PATH FILE JSON (penyimpanan permanen)
// ============================================================
const DB_PATH = path.join(__dirname, 'mahasiswa.json');

// Helper: baca data dari file JSON
function bacaData() {
    const raw = fs.readFileSync(DB_PATH, 'utf-8');
    return JSON.parse(raw);
}

// Helper: simpan data ke file JSON
function simpanData(data) {
    fs.writeFileSync(DB_PATH, JSON.stringify(data, null, 2), 'utf-8');
}

// ============================================================
// MIDDLEWARE
// ============================================================
app.set('view engine', 'ejs');
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// ============================================================
// ROUTING HALAMAN (3 Halaman Utama)
// ============================================================

// Halaman Tabel Mahasiswa
app.get('/', (req, res) => res.render('index'));

// Halaman Form Tambah
app.get('/tambah', (req, res) => res.render('tambah'));

// Halaman Form Edit
app.get('/edit/:id', (req, res) => {
    const mahasiswa = bacaData();
    const mhs = mahasiswa.find(m => m.id === parseInt(req.params.id));
    if (mhs) res.render('edit', { mhs });
    else res.status(404).send('Data tidak ditemukan');
});

// ============================================================
// REST API ENDPOINTS
// ============================================================

// READ: Ambil semua data → response JSON (untuk DataTables AJAX)
app.get('/api/mahasiswa', (req, res) => {
    const mahasiswa = bacaData();
    res.json({ data: mahasiswa });
});

// CREATE: Tambah data baru → simpan ke mahasiswa.json
app.post('/api/tambah', (req, res) => {
    const mahasiswa = bacaData();
    const { nim, nama, jurusan } = req.body;
    const newId = mahasiswa.length > 0 ? mahasiswa[mahasiswa.length - 1].id + 1 : 1;
    mahasiswa.push({ id: newId, nim, nama, jurusan });
    simpanData(mahasiswa);

    if (req.headers['content-type'] && req.headers['content-type'].includes('application/json')) {
        res.json({ success: true });
    } else {
        res.redirect('/');
    }
});

// UPDATE: Edit data → simpan ke mahasiswa.json
app.post('/api/edit/:id', (req, res) => {
    const mahasiswa = bacaData();
    const id = parseInt(req.params.id);
    const { nim, nama, jurusan } = req.body;
    const index = mahasiswa.findIndex(m => m.id === id);

    if (index !== -1) {
        mahasiswa[index] = { id, nim, nama, jurusan };
        simpanData(mahasiswa);

        if (req.headers['content-type'] && req.headers['content-type'].includes('application/json')) {
            res.json({ success: true });
        } else {
            res.redirect('/');
        }
    } else {
        res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }
});

// DELETE: Hapus data → simpan ke mahasiswa.json
app.delete('/api/hapus/:id', (req, res) => {
    let mahasiswa = bacaData();
    const id = parseInt(req.params.id);
    const sebelum = mahasiswa.length;
    mahasiswa = mahasiswa.filter(m => m.id !== id);

    if (mahasiswa.length < sebelum) {
        simpanData(mahasiswa);
        res.json({ success: true });
    } else {
        res.status(404).json({ success: false, message: 'Data tidak ditemukan' });
    }
});

// ============================================================
// START SERVER
// ============================================================
app.listen(port, () => {
    console.log(`Aplikasi berjalan di http://localhost:${port}`);
});

```
#### penjelasan kode
Kode tersebut merupakan aplikasi backend menggunakan Express.js yang mengelola data mahasiswa dengan penyimpanan permanen pada file JSON (mahasiswa.json) melalui modul fs. Data dibaca menggunakan fungsi bacaData() dan disimpan kembali menggunakan simpanData(), sehingga perubahan data tetap tersimpan meskipun server restart. Aplikasi menyediakan routing halaman menggunakan EJS untuk menampilkan halaman utama, tambah, dan edit data, serta endpoint REST API untuk operasi CRUD: GET /api/mahasiswa untuk membaca data, POST /api/tambah untuk menambah data baru, POST /api/edit/:id untuk memperbarui data berdasarkan ID, dan DELETE /api/hapus/:id untuk menghapus data. Selain itu, terdapat pengecekan header Content-Type untuk menentukan apakah response dikirim sebagai JSON atau redirect ke halaman utama, sehingga aplikasi dapat digunakan baik melalui form HTML maupun request API.

---

### 2. `index.ejs`

```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Data Mahasiswa</h3>

    <a href="/tambah" class="btn btn-primary mb-3">Tambah Data</a>

    <table id="tableMahasiswa" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Yakin hapus <strong id="namaHapus"></strong>?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
let idHapus = null;
let table;

$(document).ready(function () {

    table = $('#tableMahasiswa').DataTable({
        ajax: {
            url: '/api/mahasiswa',
            dataSrc: 'data'
        },
        columns: [
            {
                data: null,
                render: (data, type, row, meta) => meta.row + 1
            },
            { data: 'nim' },
            { data: 'nama' },
            { data: 'jurusan' },
            {
                data: null,
                render: function (data) {
                    return `
                        <a href="/edit/${data.id}" class="btn btn-sm btn-warning">Edit</a>
                        <button class="btn btn-sm btn-danger btn-hapus"
                            data-id="${data.id}"
                            data-nama="${data.nama}">
                            Hapus
                        </button>
                    `;
                }
            }
        ]
    });

    // klik tombol hapus
    $('#tableMahasiswa').on('click', '.btn-hapus', function () {
        idHapus = $(this).data('id');
        $('#namaHapus').text($(this).data('nama'));
        new bootstrap.Modal('#modalHapus').show();
    });

    // konfirmasi hapus
    $('#btnKonfirmasiHapus').click(function () {
        $.ajax({
            url: '/api/hapus/' + idHapus,
            type: 'DELETE',
            success: function () {
                table.ajax.reload(null, false);
                bootstrap.Modal.getInstance(document.getElementById('modalHapus')).hide();
                alert('Data berhasil dihapus');
            },
            error: function () {
                alert('Gagal menghapus data');
            }
        });
    });

});
</script>

</body>
</html>
```
#### penjelasan kode
Kode HTML tersebut merupakan halaman utama untuk menampilkan data mahasiswa menggunakan Bootstrap dan DataTables, dan jQuery yang terhubung dengan API backend. Data ditampilkan dalam tabel yang diambil secara AJAX dari endpoint /api/mahasiswa, lalu ditampilkan dengan kolom nomor urut, NIM, Nama, Jurusan, serta tombol aksi Edit dan Hapus. Tombol Edit mengarahkan ke halaman /edit/:id, sedangkan tombol Hapus memunculkan modal konfirmasi Bootstrap sebelum menghapus data. Proses penghapusan dilakukan dengan request AJAX DELETE ke endpoint /api/hapus/:id, kemudian tabel direload tanpa refresh halaman. Modal digunakan untuk meningkatkan UX dengan memastikan pengguna mengonfirmasi sebelum data benar-benar dihapus.

---
### 3. `edit.ejs`

```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Edit Mahasiswa</h3>

    <p class="text-muted">
        Sedang mengedit: <strong><%= mhs.nama %></strong> (ID: <%= mhs.id %>)
    </p>

    <form id="formEdit" action="/api/edit/<%= mhs.id %>" method="POST">

        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" value="<%= mhs.nim %>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<%= mhs.nama %>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select name="jurusan" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>

                <% const jurusanList = ['Teknik Informatika','Sistem Informasi','Teknik Elektro','Teknik Industri','Manajemen']; %>
                <% jurusanList.forEach(function(j) { %>
                    <option value="<%= j %>" <%= mhs.jurusan === j ? 'selected' : '' %>>
                        <%= j %>
                    </option>
                <% }); %>

            </select>
        </div>

        <button type="submit" class="btn btn-warning">Simpan</button>
        <a href="/" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- jQuery Validate -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#formEdit').validate({
        rules: {
            nim: { required: true, minlength: 3 },
            nama: { required: true, minlength: 3 },
            jurusan: { required: true }
        },
        messages: {
            nim: "NIM wajib diisi",
            nama: "Nama wajib diisi",
            jurusan: "Jurusan wajib dipilih"
        },
        errorClass: "text-danger",
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>

</body>
</html>
```

#### `penjelasan kode`
menampilkan data mahasiswa yang sedang diedit (NIM, Nama, dan Jurusan) yang diambil dari variabel mhs dari server, kemudian ditampilkan secara otomatis pada input form. Form mengirimkan data menggunakan metode POST ke endpoint /api/edit/:id untuk memperbarui data berdasarkan ID. Dropdown jurusan dibuat dinamis menggunakan array dan EJS, serta nilai yang sesuai akan otomatis terpilih. Validasi form dilakukan di sisi client menggunakan jquery.validate dengan aturan bahwa NIM dan Nama minimal 3 karakter dan semua field wajib diisi. Tersedia tombol Simpan untuk menyimpan perubahan dan tombol Kembali untuk kembali ke halaman utama tanpa menyimpan perubahan




### 4. `tambah.ejs`

```
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Tambah Mahasiswa</h3>

    <form id="formTambah" action="/api/tambah" method="POST">

        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select name="jurusan" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Teknik Elektro">Teknik Elektro</option>
                <option value="Teknik Industri">Teknik Industri</option>
                <option value="Manajemen">Manajemen</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="/" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- jQuery Validate -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#formTambah').validate({
        rules: {
            nim: { required: true },
            nama: { required: true },
            jurusan: { required: true }
        },
        messages: {
            nim: "NIM wajib diisi",
            nama: "Nama wajib diisi",
            jurusan: "Jurusan wajib dipilih"
        },
        errorClass: "text-danger",
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>

</body>
</html>
```
#### penjelasan kode
Form ini mengirim data ke endpoint /api/tambah dengan metode POST untuk menyimpan data baru yang berisi NIM, Nama, dan Jurusan yang dipilih dari dropdown. Validasi form dilakukan di sisi client menggunakan jquery.validate, sehingga setiap field wajib diisi sebelum form bisa dikirim, dengan pesan error ditampilkan jika ada input yang kosong. Tampilan dibuat responsif dan rapi menggunakan Bootstrap, serta terdapat tombol Simpan untuk menambahkan data dan tombol Kembali untuk kembali ke halaman utama tanpa menyimpan data.

---



## CARA MENJALANKAN APLIKASI

1. Pastikan **Node.js** telah terinstal di komputer.
2. Buka terminal pada direktori *root* proyek dan instal dependensi paket:
   ```bash
   npm install express ejs
3. Jalankan server aplikasi
    ```bash
    node app.js
4. Buka Web browser dan akses alamat http://localhost:3000

## tampilan
tampilan halaman utama
![Alt 1](https://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123514.png)

tampilan saat melakukan penambahan data
![Alt 2](https://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123711.png)

tampilan seletalah menambahkan data
![Alt 5](https://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123741.png)


melakukan update data
![Alt 3](https://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123835.png)

setelah melakukan update data
![Alt 6](https://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123855.png)


melakukan delate data
![Alt 4](http://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123912.png)

setelah melakukan delate data
![Alt 4](https://raw.githubusercontent.com/didiksetia1/asset/refs/heads/main/Screenshot%202026-03-29%20123932.png)

##  Link vidio Penjelasan Code
[link vidio](https://drive.google.com/drive/folders/1L5Cx4xnHtg3Whw3wueBVLdk_cUkYODpw?usp=sharing)


##  refrensi
1. **Node.js Foundation**. (2026). *Node.js Documentation*. Diakses dari https://nodejs.org/en/docs/
2. **Express API**. (2026). *Express - Node.js web application framework*. Diakses dari https://expressjs.com/
3. **EJS**. (2026). *Embedded JavaScript Templating*. Diakses dari https://ejs.co/
4. **Bootstrap Team**. (2026). *Bootstrap 5.3 Documentation*. Diakses dari https://getbootstrap.com/docs/5.3/
5. **The jQuery Foundation**. (2026). *jQuery API Documentation*. Diakses dari https://api.jquery.com/
6. **SpryMedia Ltd**. (2026). *DataTables Manual*. Diakses dari https://datatables.net/manual/
7. **Mozilla Developer Network (MDN)**. (2026). *AJAX - Web developer guides*. Diakses dari https://developer.mozilla.org/en-US/docs/Web/Guide/AJAX
