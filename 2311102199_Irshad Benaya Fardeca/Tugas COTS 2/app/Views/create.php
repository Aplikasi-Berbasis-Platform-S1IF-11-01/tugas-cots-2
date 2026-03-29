<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah TWS | TWS Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f2f4f8; font-family: Segoe UI, sans-serif; }
        .card { border-radius: 12px; border: none; }
        .btn-primary { background: #4f46e5; border: none; }
    </style>
</head>
<body>

<nav class="navbar bg-white shadow-sm mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold text-primary">
            <i class="fa-solid fa-headphones"></i> TWS Store
        </span>
        <div>
            <a href="<?= base_url('/tws') ?>" class="btn btn-outline-primary btn-sm">
                <i class="fa fa-table"></i> Lihat Data
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">Tambah TWS Baru</h5>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('tws/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label>Nama TWS</label>
                        <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Merek</label>
                        <input type="text" name="brand" class="form-control" value="<?= old('brand') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" value="<?= old('price') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Baterai (misal: 8 jam)</label>
                        <input type="text" name="battery" class="form-control" value="<?= old('battery') ?>" placeholder="Contoh: 8 jam">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-save"></i> Simpan TWS
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>