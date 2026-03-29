<!-- Andreas Besar Wibowo -->
<!-- 2311102198 / IF - 11 - 01 -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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

        <div class="text-center mb-4">
            <h2 class="fw-bold">Manajemen Produk</h2>
            <p class="text-muted">Kelola data produk dengan mudah</p>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-table"></i> Data Produk
            </div>

            <div class="card-body">

                <table id="tbl" class="table table-striped">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>

                <a href="/" class="btn btn-success mt-3">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>

            </div>
        </div>

    </div>

    <script>
        function formatRupiah(angka) {
            return "Rp " + parseInt(angka).toLocaleString("id-ID");
        }

        $('#tbl').DataTable({
            ajax: {
                url: '/data',
                dataSrc: 'data'
            },
            columns: [
                { data: null, render: (d, t, r, m) => m.row + 1 },
                { data: 'nama', render: d => "<b>" + d + "</b>" },
                { data: 'kategori', render: d => `<span class="badge bg-primary">${d}</span>` },
                { data: 'harga', render: d => formatRupiah(d) },
                {
                    data: null,
                    render: function (d) {
                        return `
                <a href="/edit/${d.id}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="/delete/${d.id}" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                </a>`;
                    }
                }
            ]
        });
    </script>

</body>

</html>