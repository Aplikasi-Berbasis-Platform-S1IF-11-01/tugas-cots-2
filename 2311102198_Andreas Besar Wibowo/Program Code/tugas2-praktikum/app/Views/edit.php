<!-- Andreas Besar Wibowo -->
<!-- 2311102198 / IF - 11 - 01 -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
            <h2 class="fw-bold">Edit Produk</h2>
            <p class="text-muted">Perbarui data produk yang sudah ada</p>
        </div>

        <!-- Menu -->
        <div class="card shadow col-md-5 mx-auto">

            <div class="card-header bg-warning text-dark">
                <i class="bi bi-pencil-square"></i> Form Edit Produk
            </div>

            <div class="card-body">

                <form method="post" action="/update/<?= $produk['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" value="<?= $produk['nama'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?= $produk['kategori'] ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= $produk['harga'] ?>" required>
                    </div>

                    <button class="btn btn-warning w-100">
                        <i class="bi bi-save"></i> Update Produk
                    </button>

                </form>

                <!-- Tombol Kembali -->
                <a href="/table" class="btn btn-secondary w-100 mt-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke Data
                </a>

            </div>
        </div>

    </div>

</body>

</html>