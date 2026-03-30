<div align="center">
  <br />
  <h1>LAPORAN PRAKTIKUM <br>APLIKASI BERBASIS PLATFORM</h1>
  <br />
  <h3>TUGAS COTS 2</h3>
  <br />
  <img src="assets/Logo Tel-u.png" alt="Logo" width="300"> 
  <br />
  <br />
  <br />
  <h3>Disusun Oleh :</h3>
  <p>
    <strong>M. Faleno Albar Firjatulloh</strong><br>
    <strong>2311102207</strong><br>
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
    <strong> Apri Pandu Wicaksono </strong> <br>
    <strong>Rangga Pradarrell Fathi</strong>
  <br />
  <br />
  <br />
  <br />
  <h3>LABORATORIUM HIGH PERFORMANCE
 <br>FAKULTAS INFORMATIKA <br>UNIVERSITAS TELKOM PURWOKERTO <br>2026</h3>
</div>

---

## 1\. Dasar Teori

  * **CRUD (Create, Read, Update, Delete)**: Konsep dasar pengelolaan data. Digunakan untuk menambah, menampilkan, mengubah, dan menghapus data produk secara fleksibel antara pengguna dan server.
  * **Bootstrap**: Framework CSS untuk membuat antarmuka yang responsif dan terstruktur menggunakan komponen siap pakai seperti tombol dan layout.
  * **jQuery**: Library JavaScript untuk mempermudah manipulasi elemen HTML, pengelolaan event, serta integrasi dengan plugin DataTables.
  * **jQuery DataTables**: Plugin untuk menampilkan tabel interaktif dengan fitur pencarian, pengurutan, dan pagination menggunakan data format JSON.
  * **JSON (JavaScript Object Notation)**: Format pertukaran data ringan yang digunakan sebagai media penyimpanan permanen dalam aplikasi ini.
  * **Node.js**: Runtime JavaScript di sisi server yang menangani permintaan client serta mengelola pembacaan dan penulisan file.
  * **Express JS**: Framework backend di atas Node.js untuk mempermudah pembuatan server, pengelolaan routing, dan penyediaan API endpoint.
  * **File System (fs)**: Modul bawaan Node.js untuk mengelola file JSON sebagai tempat penyimpanan data hasil operasi CRUD.
  * **AJAX (Asynchronous JavaScript and XML)**: Teknik pengambilan data dari server secara asinkron sehingga tampilan dapat diperbarui tanpa memuat ulang (reload) halaman.

-----

## 2\. Deskripsi Aplikasi

Aplikasi web ini dibangun menggunakan **Node.js** dengan framework **Express** sebagai backend. Antarmuka pengguna memanfaatkan **Bootstrap**, **jQuery**, dan **DataTables** untuk menciptakan pengalaman yang interaktif.

Aplikasi ini memiliki tiga halaman utama dengan penerapan konsep CRUD:

1.  **Halaman Dashboard**: Menampilkan tabel data produk interaktif (Pencarian, Pengurutan, Pagination).
2.  **Halaman Tambah Produk**: Form input untuk memasukkan data produk baru.
3.  **Halaman Edit Produk**: Form untuk memperbarui data produk lama berdasarkan ID.

**Fitur Utama:**

  * **Create**: Menambah data produk baru.
  * **Read**: Menampilkan data dalam tabel interaktif.
  * **Update**: Mengubah data produk yang ada.
  * **Delete**: Menghapus data produk dari sistem.

Penyimpanan data dilakukan secara lokal menggunakan file `data.json` di dalam folder data dengan bantuan modul `fs`.

-----

## 3\. Struktur Folder Project

```bash
TUGAS-COTS2/
├── assets/
├── node_modules/
├── views/
│   ├── form.html
│   ├── home.html
│   └── table.html
├── app.js
├── package.json
├── package-lock.json
└── README.md
```

> **Penjelasan Alur Struktur:**
> File utama `app.js` berfungsi sebagai pusat pengendali aplikasi. Folder `public` (atau `views` pada struktur di atas) digunakan untuk menyimpan file HTML yang akan dirender oleh server.

-----

## 4\. Cara Menjalankan Aplikasi

Langkah-langkah menjalankan aplikasi **Glow Jewels**:

1.  **Buka Folder Project**: Gunakan VS Code dan pastikan Node.js sudah terinstal.
2.  **Install Dependency**: Jalankan perintah `npm install`.
3.  **Jalankan Server**: Gunakan perintah `npm start` atau `node app.js`.
4.  **Akses Browser**: Buka tautan `http://localhost:3000`.
5.  **Interaksi**: Gunakan fitur Tambah, Edit, dan Hapus pada antarmuka yang tersedia.

-----

## 5\. Kode Program

### A. `package.json`

```json
{
  "name": "abp",
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
    "express": "^5.2.1"
  }
}
```

**Penjelasan:** File konfigurasi utama untuk proyek Node.js adalah file "package.json". File ini berisi informasi dasar proyek, file utama yang dijalankan, script yang dapat digunakan, dan daftar dependency yang dibutuhkan oleh aplikasi.

Pada aplikasi ini, bagian "nama" menunjukkan nama proyek dan "versi" menunjukkan versi aplikasi. Deskripsi singkat tentang aplikasi yang dibuat, yang merupakan aplikasi web CRUD untuk produk skincare yang menggunakan Express, EJS, Bootstrap, jQuery, dan DataTables, terletak di bagian "description".


File utama aplikasi adalah "app.js", yang ditunjukkan oleh baris "main" "app.js". Selain itu, script "start" node app.js" digunakan pada bagian "scripts" agar aplikasi dapat dijalankan dengan perintah "npm start".

Dalam bagian "type", "commonjs" menunjukkan bahwa proyek ini menggunakan modul CommonJS. Di bagian "dependencies", aplikasi menggunakan beberapa library utama, seperti:

- `express` digunakan sebagai framework backend untuk membangun server dan routing.  
- `ejs` digunakan sebagai template engine untuk menampilkan halaman dinamis.  
- `body-parser` digunakan untuk membaca data yang dikirim dari form maupun request dalam format JSON.  

Dengan adanya file `package.json`, pengelolaan dependency dan proses menjalankan aplikasi menjadi lebih terstruktur dan mudah.

-----

### B. `app.js`

```javascript
const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();

app.use(bodyParser.json());
app.use(express.static('public'));

const DATA_FILE = './data/data.json';

// ambil data
app.get('/api/data', (req, res) => {
    const data = JSON.parse(fs.readFileSync(DATA_FILE));
    res.json(data);
});

// tambah data
app.post('/api/data', (req, res) => {
    const data = JSON.parse(fs.readFileSync(DATA_FILE));
    const newItem = req.body;
    newItem.id = Date.now();
    data.push(newItem);

    fs.writeFileSync(DATA_FILE, JSON.stringify(data));
    res.json({message: "Data berhasil ditambah"});
});

// hapus data
app.delete('/api/data/:id', (req, res) => {
    let data = JSON.parse(fs.readFileSync(DATA_FILE));
    data = data.filter(item => item.id != req.params.id);

    fs.writeFileSync(DATA_FILE, JSON.stringify(data));
    res.json({message: "Data dihapus"});
});

// edit data
app.put('/api/data/:id', (req, res) => {
    let data = JSON.parse(fs.readFileSync(DATA_FILE));

    data = data.map(item => {
        if(item.id == req.params.id){
            return { ...item, ...req.body };
        }
        return item;
    });

    fs.writeFileSync(DATA_FILE, JSON.stringify(data));
    res.json({message: "Data diupdate"});
});

app.listen(3000, () => console.log("Server jalan di http://localhost:3000"));

```

**Penjelasan:** Kode app.js merupakan bagian backend dari aplikasi web yang dibuat menggunakan Node.js dan framework Express untuk mengelola data produk dengan konsep CRUD (Create, Read, Update, Delete). Pada awal kode, dilakukan import module seperti Express untuk server, body-parser untuk membaca data JSON dari client, serta fs untuk mengakses file. Aplikasi menggunakan middleware agar dapat menerima data JSON dan menampilkan file statis dari folder public. Data disimpan dalam file data.json, sehingga tidak memerlukan database.

Selanjutnya, terdapat beberapa endpoint API yaitu GET untuk mengambil data, POST untuk menambahkan data baru dengan ID unik, DELETE untuk menghapus data berdasarkan ID, dan PUT untuk memperbarui data yang sudah ada. Setiap proses dilakukan dengan membaca file JSON, memodifikasi data, lalu menyimpannya kembali. Terakhir, server dijalankan pada port 3000 sehingga aplikasi dapat diakses melalui browser.

-----

### C. `public/index.html`

```html
<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery + DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body class="container mt-4">

<h2>Data Produk</h2>
<a href="form.html" class="btn btn-primary mb-3">Tambah Data</a>

<table id="table" class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>

<script>
$(document).ready(function(){
    $('#table').DataTable({
        ajax: {
            url: '/api/data',
            dataSrc: ''
        },
        columns: [
            { data: 'nama' },
            { data: 'harga' },
            {
                data: null,
                render: function(data){
                    return `
                        <button class="btn btn-danger btn-sm delete" data-id="${data.id}">Hapus</button>
                        <a href="edit.html?id=${data.id}" class="btn btn-warning btn-sm">Edit</a>
                    `;
                }
            }
        ]
    });

    $('#table').on('click', '.delete', function(){
        const id = $(this).data('id');
        $.ajax({
            url: '/api/data/' + id,
            type: 'DELETE',
            success: function(){
                location.reload();
            }
        });
    });
});
</script>

</body>
</html>

```

**Penjelasan:** Kode tersebut merupakan halaman utama aplikasi yang berfungsi untuk menampilkan data produk dalam bentuk tabel interaktif. Tampilan halaman menggunakan framework Bootstrap agar terlihat rapi dan responsif, sementara jQuery dan plugin DataTables digunakan untuk mengelola dan menampilkan data secara dinamis. Data produk diambil dari endpoint /api/data dalam format JSON melalui fitur AJAX yang disediakan oleh DataTables, sehingga data dapat langsung ditampilkan tanpa perlu reload halaman secara manual.

Tabel yang ditampilkan memiliki tiga kolom utama yaitu nama, harga, dan aksi. Pada kolom aksi terdapat dua tombol, yaitu tombol hapus dan edit. Tombol hapus digunakan untuk menghapus data berdasarkan ID dengan mengirim request DELETE ke server menggunakan AJAX, kemudian halaman akan direfresh agar data terbaru ditampilkan. Sedangkan tombol edit akan mengarahkan pengguna ke halaman edit dengan membawa ID data yang dipilih. Secara keseluruhan, halaman ini berperan penting dalam sistem CRUD, khususnya untuk menampilkan data (Read) dan menghapus data (Delete) secara interaktif dan mudah digunakan.

-----

### D. `public/form.html`
```html
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Data</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-3">Tambah Data</h3>

        <form id="form">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" id="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" id="harga" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.html" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    $('#form').submit(function(e){
        e.preventDefault();

        const data = {
            nama: $('#nama').val(),
            harga: $('#harga').val()
        };

        $.ajax({
            url: '/api/data',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),

            success: function(res){
                alert("Data berhasil ditambah");
                window.location.href = "index.html";
            },

            error: function(err){
                console.log(err);
                alert("Gagal menyimpan data");
            }
        });

    });

});
</script>

</body>
</html>

```

**Penjelasan:** Kode tersebut merupakan halaman form yang digunakan untuk menambahkan data produk baru ke dalam sistem. Tampilan dibuat menggunakan Bootstrap agar terlihat rapi dengan layout berbentuk card, serta dilengkapi input untuk nama dan harga produk yang wajib diisi. Form ini memiliki tombol “Simpan” untuk mengirim data dan tombol “Kembali” untuk kembali ke halaman utama.

Pada bagian JavaScript, digunakan jQuery untuk menangani event submit pada form. Ketika form dikirim, proses default akan dicegah, lalu data dari input diambil dan dikemas dalam bentuk JSON. Data tersebut kemudian dikirim ke server melalui AJAX dengan method POST ke endpoint /api/data. Jika proses berhasil, akan muncul notifikasi dan pengguna diarahkan kembali ke halaman utama, sedangkan jika gagal akan ditampilkan pesan error. Halaman ini berfungsi sebagai implementasi fitur Create dalam sistem CRUD.

-----

### E. `public/edit.html`
```html
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Edit Data</h2>

<form id="form">
    <input type="text" id="nama" class="form-control mb-2">
    <input type="number" id="harga" class="form-control mb-2">
    <button class="btn btn-warning">Update</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

$('#form').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: '/api/data/' + id,
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({
            nama: $('#nama').val(),
            harga: $('#harga').val()
        }),
        success: function(){
            alert("Data diupdate");
            window.location = "index.html";
        }
    });
});
</script>

</body>
</html>

```

**Penjelasan:** Kode tersebut merupakan halaman yang digunakan untuk mengedit atau memperbarui data produk yang sudah ada. Tampilan halaman dibuat sederhana menggunakan Bootstrap dengan form berisi input nama dan harga. Halaman ini mengambil parameter id dari URL menggunakan URLSearchParams, yang digunakan untuk menentukan data mana yang akan diperbarui.

Pada bagian JavaScript, jQuery digunakan untuk menangani proses submit form. Ketika form dikirim, proses default dicegah, kemudian data dari input dikirim ke server melalui AJAX dengan method PUT ke endpoint /api/data/:id. Data yang dikirim berupa JSON yang berisi nama dan harga terbaru. Jika proses berhasil, akan muncul notifikasi dan pengguna diarahkan kembali ke halaman utama. Halaman ini berfungsi sebagai implementasi fitur Update dalam sistem CRUD.

-----

## 6\. Alur CRUD Aplikasi

1.  **Create**: Input form -\> AJAX POST -\> Backend (fs.writeFileSync) -\> data.json.
2.  **Read**: Request GET -\> API /api/data -\> DataTables render HTML.
3.  **Update**: Klik Edit (bawa ID) -\> Form Edit -\> AJAX PUT -\> Backend Update file.
4.  **Delete**: Klik Hapus -\> AJAX DELETE -\> Backend Filter data -\> Simpan ulang file.


---

## 7. Screenshot Hasil Aplikasi

Berikut merupakan tampilan dari aplikasi yang telah dibuat:

### 1. Halaman Utama (Dashboard)
Menampilkan daftar produk dalam bentuk tabel interaktif menggunakan DataTables.

![](assets/1.png)

### 2. Halaman Tambah Produk
Form untuk menambahkan data produk baru ke dalam sistem.

![](assets/2.png)

![](assets/3.png)


### 3. Halaman Edit Produk
Form untuk memperbarui data produk yang sudah ada.

![](assets/4.png)

![](assets/5.png)


### 4. Cari Produk
Tampilan cari produk di katalog.

![](assets/6.png)

### 5. Proses Hapus Produk
Tampilan konfirmasi penghapusan data .

![](assets/7.png)

![](assets/8.png)

---

## 8\. Kesimpulan

Aplikasi ini berhasil menerapkan konsep **CRUD** menggunakan stack **Node.js, Express, dan JSON**. Integrasi antara frontend (Bootstrap/jQuery) dan backend berjalan mulus melalui AJAX, memungkinkan pengelolaan data yang efisien tanpa reload halaman yang berat. Struktur ini sangat ideal untuk pengembangan aplikasi web skala kecil yang membutuhkan performa cepat.

-----

## 9\. Referensi

1.  https://ejs.co
2.  https://nodejs.org
3.  https://jquery.com
4.  https://datatables.net
5.  https://sweetalert2.github.io

-----

## 10\. Link Video Presentasi

[Klik di sini untuk melihat video presentasi](https://drive.google.com/file/d/183rOyQJzq4fj8f1ZIW3W3hjCLoev6oU9/view?usp=sharing)

-----

Apakah ada bagian spesifik lain dari laporan ini yang ingin Anda sesuaikan formatnya?