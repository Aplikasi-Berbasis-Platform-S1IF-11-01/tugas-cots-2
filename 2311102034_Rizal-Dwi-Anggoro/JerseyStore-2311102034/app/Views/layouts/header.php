<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' — Jersey Store' : 'Jersey Store' ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:    #1a1f3c;
            --accent:     #e8452c;
            --accent-2:   #f0b429;
            --sidebar-w:  260px;
            --sidebar-bg: #12162d;
            --card-r:     14px;
            --tr:         0.22s ease;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Nunito', sans-serif;
            background: #f0f2f8;
            color: #2c3057;
            margin: 0;
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: transform var(--tr);
        }
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand .logo-wrap {
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand .logo-icon {
            width: 44px; height: 44px;
            background: var(--accent);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: white; flex-shrink: 0;
        }
        .brand-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.4rem; font-weight: 700; color: white; line-height: 1.1;
        }
        .brand-sub {
            font-size: 0.68rem; color: rgba(255,255,255,0.35);
            letter-spacing: 2px; text-transform: uppercase;
        }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section-label {
            font-size: 0.65rem; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 12px 10px 6px;
        }
        .sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 14px; border-radius: 10px;
            color: rgba(255,255,255,0.6); font-weight: 500;
            font-size: 0.92rem; transition: all var(--tr);
            margin-bottom: 2px; text-decoration: none;
        }
        .sidebar-nav .nav-link:hover {
            background: rgba(232,69,44,0.12); color: white;
        }
        .sidebar-nav .nav-link.active {
            background: rgba(232,69,44,0.2);
            color: var(--accent);
            border-left: 3px solid var(--accent);
            padding-left: 11px;
        }
        .nav-link .nav-icon { font-size: 1.15rem; width: 22px; text-align: center; }
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-footer .app-badge {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            background: rgba(255,255,255,0.05); border-radius: 10px;
        }
        .sidebar-footer .app-badge .bi { color: var(--accent-2); font-size: 1.2rem; }
        .app-info { font-size: 0.78rem; color: rgba(255,255,255,0.4); line-height: 1.4; }

        /* ── MAIN ── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1; display: flex; flex-direction: column; min-height: 100vh;
        }

        .topbar {
            height: 64px; background: white;
            border-bottom: 1px solid #e5e9f2;
            display: flex; align-items: center; padding: 0 28px; gap: 16px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .topbar .page-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.3rem; font-weight: 700; color: var(--primary); flex: 1;
        }
        .btn-topbar {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: #f0f2f8; border: 1px solid #e5e9f2;
            color: #6b7ba4; font-size: 1rem; cursor: pointer;
            transition: all var(--tr); text-decoration: none;
        }
        .btn-topbar:hover { background: var(--accent); color: white; border-color: var(--accent); }
        .page-content { padding: 28px; flex: 1; }

        /* ── BREADCRUMB ── */
        .breadcrumb { background: none; padding: 0; margin: 0 0 22px; font-size: 0.82rem; }
        .breadcrumb-item a { color: var(--accent); text-decoration: none; }

        /* ── CARDS ── */
        .stat-card {
            background: white; border-radius: var(--card-r);
            padding: 22px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            border: 1px solid #eef0f8; transition: transform var(--tr);
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.09); }
        .stat-card .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 14px;
        }
        .stat-value {
            font-family: 'Rajdhani', sans-serif;
            font-size: 2.2rem; font-weight: 700; color: var(--primary); line-height: 1;
        }
        .stat-label { font-size: 0.82rem; color: #8898b8; font-weight: 500; margin-top: 4px; }

        .content-card {
            background: white; border-radius: var(--card-r);
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            border: 1px solid #eef0f8; overflow: hidden;
        }
        .card-header-custom {
            padding: 18px 22px; border-bottom: 1px solid #eef0f8;
            display: flex; align-items: center; gap: 14px; background: white;
        }
        .ch-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: rgba(232,69,44,0.1);
            display: flex; align-items: center; justify-content: center;
            color: var(--accent); font-size: 1.1rem;
        }
        .ch-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.1rem; font-weight: 700; color: var(--primary); flex: 1;
        }
        .card-body-custom { padding: 22px; }

        /* ── FORM ── */
        .form-label { font-weight: 600; font-size: 0.88rem; color: var(--primary); margin-bottom: 6px; }
        .form-control, .form-select {
            border-color: #dce0ee; border-radius: 10px;
            padding: 10px 14px; font-size: 0.9rem;
            color: var(--primary); transition: all var(--tr);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(232,69,44,0.12);
        }
        .form-control.is-invalid, .form-select.is-invalid { border-color: #dc3545; }
        .invalid-feedback { font-size: 0.8rem; }
        .alert-item { font-size: 0.82rem; }

        /* ── BUTTONS ── */
        .btn-accent {
            background: var(--accent); border-color: var(--accent);
            color: white; font-weight: 600; border-radius: 10px;
            padding: 10px 22px; transition: all var(--tr);
        }
        .btn-accent:hover {
            background: #c93820; border-color: #c93820; color: white;
            transform: translateY(-1px); box-shadow: 0 4px 12px rgba(232,69,44,0.35);
        }

        /* ── TABLE ── */
        table.dataTable thead { background: #f8f9fd; }
        table.dataTable thead th {
            font-weight: 700; font-size: 0.8rem;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #8898b8; border-bottom: 2px solid #eef0f8 !important;
            padding: 14px 12px;
        }
        table.dataTable tbody td {
            vertical-align: middle; font-size: 0.88rem;
            padding: 12px; border-bottom: 1px solid #f0f2f8; color: #3a4065;
        }
        table.dataTable tbody tr:hover { background: #faf8ff !important; }

        /* ── MODAL ── */
        .modal-content { border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .modal-header {
            background: var(--primary); color: white;
            border-radius: 16px 16px 0 0; padding: 18px 22px;
        }
        .modal-header .modal-title { font-family: 'Rajdhani', sans-serif; font-weight: 700; font-size: 1.2rem; }
        .modal-header .btn-close { filter: invert(1); }

        /* ── MISC ── */
        .alert { border-radius: 12px; border: none; font-weight: 500; }
        .font-monospace { font-size: 0.82rem; letter-spacing: 0.5px; }
        .detail-list dt { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; color: #8898b8; font-weight: 600; }
        .detail-list dd { font-size: 0.95rem; color: var(--primary); font-weight: 600; margin-bottom: 14px; }

        /* ── PAGE LOADER ── */
        .page-loader {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: white; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            flex-direction: column; gap: 14px; transition: opacity 0.3s;
        }
        .page-loader.hide { opacity: 0; pointer-events: none; }
        .loader-spin {
            width: 48px; height: 48px;
            border: 4px solid #f0f2f8; border-top-color: var(--accent);
            border-radius: 50%; animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* DT Buttons */
        .dt-buttons .dt-button {
            background: #f0f2f8 !important; border: 1px solid #dce0ee !important;
            border-radius: 8px !important; color: var(--primary) !important;
            font-size: 0.82rem !important; font-weight: 600 !important;
            padding: 6px 14px !important; box-shadow: none !important;
        }
        .dt-buttons .dt-button:hover { background: var(--accent) !important; color: white !important; border-color: var(--accent) !important; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="page-loader" id="pageLoader">
    <div class="loader-spin"></div>
    <span style="color:#8898b8;font-size:0.85rem;font-weight:600">Memuat Jersey Store...</span>
</div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="logo-wrap">
            <div class="logo-icon">⚽</div>
            <div>
                <div class="brand-name">JerseyStore</div>
                <div class="brand-sub">Management System</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a href="<?= base_url('dashboard') ?>"
           class="nav-link <?= (isset($activeMenu) && $activeMenu === 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 nav-icon"></i> Dashboard
        </a>

        <a href="<?= base_url('jersey') ?>"
           class="nav-link <?= (isset($activeMenu) && $activeMenu === 'jersey') ? 'active' : '' ?>">
            <i class="bi bi-shirt nav-icon"></i> Data Jersey
        </a>

        <a href="<?= base_url('jersey/tambah') ?>"
           class="nav-link <?= (isset($activeMenu) && $activeMenu === 'tambah') ? 'active' : '' ?>">
            <i class="bi bi-plus-circle nav-icon"></i> Tambah Jersey
        </a>

        <div class="nav-section-label" style="margin-top:8px">Informasi</div>
        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#modalAbout">
            <i class="bi bi-info-circle nav-icon"></i> Tentang Aplikasi
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="app-badge">
            <i class="bi bi-trophy-fill"></i>
            <div class="app-info">
                <strong style="color:rgba(255,255,255,0.7)">Jersey Store v1.0</strong><br>
                CodeIgniter 4 + Bootstrap 5
            </div>
        </div>
    </div>
</aside>

<div class="main-content">
    <header class="topbar">
        <button class="btn-topbar d-lg-none border-0" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="page-title">
            <i class="bi bi-shirt me-2" style="color:var(--accent)"></i>
            <?= isset($title) ? esc($title) : 'Jersey Store' ?>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('jersey/tambah') ?>" class="btn-topbar" title="Tambah Jersey">
                <i class="bi bi-plus-lg"></i>
            </a>
            <a href="<?= base_url('jersey') ?>" class="btn-topbar" title="Data Jersey">
                <i class="bi bi-table"></i>
            </a>
            <a href="<?= base_url('dashboard') ?>" class="btn-topbar" title="Dashboard">
                <i class="bi bi-house"></i>
            </a>
        </div>
    </header>

    <div class="page-content">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= isset($title) ? esc($title) : 'Dashboard' ?></li>
            </ol>
        </nav>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div><?= session()->getFlashdata('success') ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div><?= session()->getFlashdata('error') ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>