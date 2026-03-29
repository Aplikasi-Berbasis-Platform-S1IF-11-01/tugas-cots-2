<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data TWS | TWS Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f2f4f8; font-family: Segoe UI, sans-serif; }
        .card { border-radius: 12px; border: none; }
        .badge-price { background: #d1fae5; color: #065f46; padding: 5px 10px; border-radius: 6px; font-weight: bold; }
        .badge-battery { background: #e0e7ff; color: #1e40af; padding: 5px 10px; border-radius: 6px; }
    </style>
</head>
<body>

<nav class="navbar bg-white shadow-sm mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold text-primary">
            <i class="fa-solid fa-headphones"></i> TWS Store
        </span>
        <div>
            <a href="<?= base_url('tws/create') ?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Tambah TWS
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card p-4 shadow-sm">
        <h5 class="mb-3">Daftar True Wireless Stereo (TWS)</h5>
        <table id="twsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Merek</th>
                    <th>Harga</th>
                    <th>Baterai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#twsTable').DataTable({
            ajax: {
                url: '<?= base_url('tws/json') ?>',
                dataSrc: ''
            },
            columns: [
                { data: 'name' },
                { data: 'brand' },
                {
                    data: 'price',
                    render: function(data) {
                        return '<span class="badge-price">Rp ' + new Intl.NumberFormat('id-ID').format(data) + '</span>';
                    }
                },
                { data: 'battery' },
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <a href="<?= base_url('tws/edit') ?>/${data}" class="btn btn-warning btn-sm me-1">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="${data}">
                                <i class="fa fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            }
        });

        $('#twsTable').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Hapus TWS?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('tws/delete') ?>/' + id,
                        method: 'GET',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Terhapus!', 'TWS berhasil dihapus.', 'success');
                                table.ajax.reload();
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>

</body>
</html>