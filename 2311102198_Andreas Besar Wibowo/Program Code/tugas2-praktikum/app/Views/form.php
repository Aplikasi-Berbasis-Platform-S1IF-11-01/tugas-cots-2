<!-- Andreas Besar Wibowo -->
<!-- 2311102198 / IF - 11 - 01 -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Produk</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-light">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-dark bg-success shadow">
        <div class="container">
            <span class="navbar-brand">
                <i class="bi bi-box-seam"></i> Sistem Data Produk
            </span>
        </div>
    </nav>

    <div class="container mt-4">

        <!-- Header/ Judul -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">Tambah Produk</h2>
            <p class="text-muted">Masukkan data produk baru</p>
        </div>

        <!-- Alert -->
        <div id="alertBox"></div>

        <!-- Menu -->
        <div class="card shadow col-md-5 mx-auto">

            <div class="card-header bg-success text-white">
                <i class="bi bi-plus-circle"></i> Form Produk
            </div>

            <div class="card-body">

                <form id="formProduk" method="post" action="/save">

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control">
                    </div>

                    <button class="btn btn-success w-100">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                </form>

                <a href="/table" class="btn btn-dark w-100 mt-3">
                    <i class="bi bi-table"></i> Lihat Data
                </a>

            </div>
        </div>

    </div>

    <!-- Script Validasi -->
    <script>

        $("#formProduk").submit(function (e) {

            let nama = $("#nama").val().trim();
            let kategori = $("#kategori").val().trim();
            let harga = $("#harga").val().trim();

            if (nama === "" || kategori === "" || harga === "") {
                e.preventDefault();

                showAlert("Semua field wajib diisi!", "danger");
                return false;
            }

            if (harga <= 0) {
                e.preventDefault();

                showAlert("Harga harus lebih dari 0!", "warning");
                return false;
            }

        });

        function showAlert(msg, type = "danger") {
            $("#alertBox").html(`
        <div class="alert alert-${type} alert-dismissible fade show">
            ${msg}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>