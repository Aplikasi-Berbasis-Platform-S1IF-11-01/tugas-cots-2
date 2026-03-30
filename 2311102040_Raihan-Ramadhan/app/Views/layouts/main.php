<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GarasiMotuba<?= $title ?? 'Jual Beli Mobil' ?></title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- DataTables + Bootstrap 5 style -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
  body { background-color: #f4f8fb; }

  .navbar {
    background: linear-gradient(90deg, #0d6efd, #0b5ed7);
  }

  .navbar-brand {
    font-weight: 700;
    font-size: 1.4rem;
  }

  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  }

  .card-header {
    background-color: #0d6efd !important;
    color: #fff;
    border-radius: 12px 12px 0 0 !important;
  }

  .btn-primary {
    background-color: #0d6efd;
    border: none;
  }

  .btn-primary:hover {
    background-color: #0b5ed7;
  }

  .table thead {
    background-color: #0d6efd;
    color: white;
  }

  .badge-tersedia { background-color: #0d6efd; }
  .badge-terjual  { background-color: #dc3545; }
  .badge-proses   { background-color: #ffc107; color: #000; }

  .table-img {
    width: 60px;
    height: 45px;
    object-fit: cover;
    border-radius: 6px;
  }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/mobil">
      <i class="bi bi-car-front-fill text-warning me-2"></i>Garasi Motuba
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/mobil"><i class="bi bi-car-front me-1"></i>Data Mobil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/mobil/create"><i class="bi bi-plus-circle me-1"></i>Tambah Mobil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/penjual"><i class="bi bi-people me-1"></i>Data Penjual</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/penjual/create"><i class="bi bi-person-plus me-1"></i>Tambah Penjual</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten halaman -->
<div class="container pb-5">
  <!-- Flash message -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?= $this->renderSection('content') ?>
</div>

<!-- jQuery (WAJIB sebelum DataTables) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables + Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- jQuery Validate Plugin (jQuery plugin wajib) -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>