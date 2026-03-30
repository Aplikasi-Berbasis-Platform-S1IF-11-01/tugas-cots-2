<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> — Sistem Manajemen</title>

    <!-- Google Fonts: Syne (display) + DM Mono (data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Mono:wght@300;400;500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        /* ==============================
           CSS VARIABLES & BASE
        ============================== */
        :root {
            --black:        #0a0a0a;
            --black-2:      #111111;
            --black-3:      #1a1a1a;
            --card-bg:      #141414;
            --border:       #2a2a2a;
            --border-light: #333333;
            --muted:        #555555;
            --text-dim:     #888888;
            --text-mid:     #aaaaaa;
            --text:         #e8e8e8;
            --white:        #f5f5f5;
            --accent:       #ffffff;
            --accent-glow:  rgba(255,255,255,0.06);

            --font-display: 'Syne', sans-serif;
            --font-mono:    'DM Mono', monospace;
            --font-body:    'Inter', sans-serif;

            --radius:    6px;
            --radius-lg: 12px;
            --shadow:    0 4px 24px rgba(0,0,0,0.5);
            --shadow-lg: 0 8px 48px rgba(0,0,0,0.7);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--black);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 14px;
            line-height: 1.6;
            min-height: 100vh;
            background-image:
                radial-gradient(ellipse 80% 50% at 50% -10%, rgba(255,255,255,0.03) 0%, transparent 70%),
                repeating-linear-gradient(0deg, transparent, transparent 79px, rgba(255,255,255,0.012) 80px),
                repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,0.012) 80px);
        }

        /* ==============================
           NAVBAR
        ============================== */
        .navbar-custom {
            background-color: rgba(10,10,10,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 60px;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--white);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon svg {
            width: 16px;
            height: 16px;
            fill: var(--black);
        }

        .brand-name {
            font-family: var(--font-display);
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.01em;
        }

        .brand-sub {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            display: block;
            line-height: 1;
            margin-top: 1px;
        }

        .nav-badge {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--text-dim);
            border: 1px solid var(--border);
            padding: 2px 8px;
            border-radius: 20px;
            letter-spacing: 0.08em;
        }

        /* ==============================
           LAYOUT
        ============================== */
        .main-wrapper {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ==============================
           PAGE HEADER
        ============================== */
        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .page-header-inner {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-eyebrow {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .page-title {
            font-family: var(--font-display);
            font-size: clamp(22px, 3vw, 30px);
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin: 0;
        }

        /* ==============================
           STAT CARDS
        ============================== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
        }

        .stat-card:hover { border-color: var(--border-light); }

        .stat-label {
            font-family: var(--font-mono);
            font-size: 9px;
            color: var(--muted);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-value {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
        }

        .stat-value.mono {
            font-family: var(--font-mono);
            font-size: 16px;
            letter-spacing: -0.02em;
        }

        .stat-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--border-light);
        }

        /* ==============================
           CARD
        ============================== */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow);
            position: relative;
        }

        .card-custom::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
            pointer-events: none;
        }

        .card-header-custom {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .card-title-custom {
            font-family: var(--font-display);
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title-dot {
            width: 6px;
            height: 6px;
            background: var(--white);
            border-radius: 50%;
            display: inline-block;
        }

        .card-body-custom {
            padding: 24px;
        }

        /* ==============================
           BUTTONS
        ============================== */
        .btn-primary-custom {
            background: var(--white);
            color: var(--black);
            border: none;
            border-radius: var(--radius);
            padding: 9px 18px;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all 0.15s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary-custom:hover {
            background: #e0e0e0;
            color: var(--black);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(255,255,255,0.15);
        }

        .btn-primary-custom:active { transform: translateY(0); }

        .btn-ghost-custom {
            background: transparent;
            color: var(--text-mid);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 8px 14px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 400;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
        }

        .btn-ghost-custom:hover {
            border-color: var(--border-light);
            color: var(--text);
            background: rgba(255,255,255,0.03);
        }

        .btn-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-mid);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s;
            font-size: 13px;
            text-decoration: none;
        }

        .btn-icon:hover { border-color: var(--white); color: var(--white); }

        .btn-icon.danger:hover {
            border-color: #ff4444;
            color: #ff4444;
            background: rgba(255,68,68,0.08);
        }

        /* ==============================
           FORM CONTROLS
        ============================== */
        .form-label-custom {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--text-dim);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
        }

        .form-control-custom,
        .form-select-custom {
            background: var(--black-3) !important;
            border: 1px solid var(--border) !important;
            border-radius: var(--radius) !important;
            color: var(--text) !important;
            font-family: var(--font-body) !important;
            font-size: 14px !important;
            padding: 9px 14px !important;
            transition: border-color 0.15s, box-shadow 0.15s !important;
            width: 100% !important;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: rgba(255,255,255,0.3) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.05) !important;
            outline: none !important;
            background: var(--black-3) !important;
            color: var(--text) !important;
        }

        .form-control-custom::placeholder { color: var(--muted) !important; }

        .form-control-custom.is-invalid,
        .form-select-custom.is-invalid {
            border-color: #ff4444 !important;
        }

        .invalid-feedback-custom {
            font-family: var(--font-mono);
            font-size: 10px;
            color: #ff6b6b;
            margin-top: 4px;
            display: none;
        }

        .invalid-feedback-custom.show { display: block; }

        .input-prefix {
            background: var(--black-2);
            border: 1px solid var(--border);
            border-right: none;
            border-radius: var(--radius) 0 0 var(--radius);
            color: var(--muted);
            font-family: var(--font-mono);
            font-size: 12px;
            padding: 9px 12px;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .input-with-prefix { display: flex; }
        .input-with-prefix .form-control-custom {
            border-radius: 0 var(--radius) var(--radius) 0 !important;
        }

        /* ==============================
           DATATABLES CUSTOM STYLE
        ============================== */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: var(--black-3) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: var(--radius) !important;
            padding: 6px 10px !important;
            font-size: 13px !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--border-light) !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-dim) !important;
            font-size: 12px !important;
            font-family: var(--font-body) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: transparent !important;
            border: 1px solid var(--border) !important;
            color: var(--text-mid) !important;
            border-radius: var(--radius) !important;
            padding: 4px 10px !important;
            margin: 0 2px !important;
            font-size: 12px !important;
            cursor: pointer;
            transition: all 0.15s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--border) !important;
            color: var(--white) !important;
            border-color: var(--border-light) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--white) !important;
            color: var(--black) !important;
            border-color: var(--white) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.3 !important;
            cursor: default !important;
        }

        /* Table */
        #tableBarang {
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        #tableBarang thead th {
            background: var(--black-2) !important;
            color: var(--muted) !important;
            font-family: var(--font-mono) !important;
            font-size: 9px !important;
            font-weight: 500 !important;
            letter-spacing: 0.12em !important;
            text-transform: uppercase !important;
            border-bottom: 1px solid var(--border) !important;
            border-top: none !important;
            padding: 12px 16px !important;
        }

        #tableBarang thead th.sorting::after,
        #tableBarang thead th.sorting_asc::after,
        #tableBarang thead th.sorting_desc::after {
            color: var(--border-light) !important;
        }

        #tableBarang tbody tr {
            transition: background 0.12s;
        }

        #tableBarang tbody tr:hover td {
            background: rgba(255,255,255,0.025) !important;
        }

        #tableBarang tbody td {
            background: transparent !important;
            color: var(--text) !important;
            border-bottom: 1px solid var(--border) !important;
            border-top: none !important;
            padding: 13px 16px !important;
            font-size: 13px !important;
            vertical-align: middle !important;
        }

        .td-no {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--muted);
        }

        .td-nama {
            font-weight: 500;
            color: var(--white) !important;
        }

        .td-kategori span {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--text-mid);
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            padding: 2px 8px;
            border-radius: 20px;
            letter-spacing: 0.05em;
        }

        .td-jumlah {
            font-family: var(--font-mono);
            font-size: 13px;
        }

        .td-harga {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-mid) !important;
            letter-spacing: -0.01em;
        }

        .td-aksi {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        /* ==============================
           MODAL
        ============================== */
        .modal-content {
            background: var(--card-bg) !important;
            border: 1px solid var(--border) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-lg) !important;
        }

        .modal-header {
            background: var(--black-2) !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 18px 24px !important;
        }

        .modal-title {
            font-family: var(--font-display) !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: var(--white) !important;
            letter-spacing: -0.02em !important;
        }

        .modal-body { padding: 24px !important; }

        .modal-footer {
            border-top: 1px solid var(--border) !important;
            padding: 16px 24px !important;
            background: transparent !important;
        }

        .btn-close {
            filter: invert(1) !important;
            opacity: 0.5 !important;
        }

        .btn-close:hover { opacity: 1 !important; }

        .modal-backdrop.show { backdrop-filter: blur(4px); }

        /* ==============================
           TOAST NOTIFICATIONS
        ============================== */
        .toast-container-custom {
            position: fixed;
            top: 72px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }

        .toast-custom {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 18px;
            min-width: 280px;
            max-width: 360px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow);
            pointer-events: all;
            animation: toastIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .toast-custom.hiding {
            animation: toastOut 0.2s ease forwards;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(20px) scale(0.95); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }

        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to   { opacity: 0; transform: translateX(20px) scale(0.95); }
        }

        .toast-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .toast-icon.success { background: rgba(50,200,100,0.15); color: #50c878; }
        .toast-icon.error   { background: rgba(255,68,68,0.15);  color: #ff6464; }

        .toast-body-custom {
            flex: 1;
        }

        .toast-title {
            font-family: var(--font-display);
            font-size: 12px;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 1px;
        }

        .toast-msg {
            font-size: 12px;
            color: var(--text-dim);
            line-height: 1.4;
        }

        .toast-close-btn {
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            line-height: 1;
            flex-shrink: 0;
        }

        .toast-close-btn:hover { color: var(--text); }

        /* ==============================
           LOADING SPINNER
        ============================== */
        .spinner-custom {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(0,0,0,0.2);
            border-top-color: var(--black);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ==============================
           EMPTY STATE
        ============================== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 40px;
            color: var(--border);
            margin-bottom: 12px;
        }

        .empty-text {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.1em;
        }

        /* ==============================
           RESPONSIVE
        ============================== */
        @media (max-width: 768px) {
            .main-wrapper { padding: 1rem; }
            .card-body-custom { padding: 16px; }
            .card-header-custom { padding: 14px 16px; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<!-- ===================== NAVBAR ===================== -->
<nav class="navbar-custom d-flex align-items-center justify-content-between">
    <a href="<?= base_url('/') ?>" class="navbar-brand-custom">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-7 14H8v-2h4v2zm4-4H8v-2h8v2zm0-4H8V7h8v2z"/>
            </svg>
        </div>
        <div>
            <div class="brand-name">Inventaris</div>
            <span class="brand-sub">Sistem Manajemen Barang</span>
        </div>
    </a>
    <div class="d-flex align-items-center gap-2">
        <span class="nav-badge d-none d-sm-block">v1.0.0</span>
        <span class="nav-badge d-none d-md-block" id="navDate"></span>
    </div>
</nav>

<!-- ===================== TOAST CONTAINER ===================== -->
<div class="toast-container-custom" id="toastContainer"></div>

<!-- ===================== MAIN CONTENT ===================== -->
<div class="main-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-inner">
            <div>
                <div class="page-eyebrow">Manajemen Inventaris</div>
                <h1 class="page-title"><?= esc($page_title) ?></h1>
            </div>
            <button class="btn-primary-custom" onclick="openModalTambah()">
                <i class="bi bi-plus-lg"></i>
                Tambah Barang
            </button>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Barang</div>
            <div class="stat-value" id="statTotal">—</div>
            <i class="bi bi-box-seam stat-icon"></i>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Stok</div>
            <div class="stat-value" id="statStok">—</div>
            <i class="bi bi-layers stat-icon"></i>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value" id="statKategori">—</div>
            <i class="bi bi-tags stat-icon"></i>
        </div>
        <div class="stat-card">
            <div class="stat-label">Nilai Total</div>
            <div class="stat-value mono" id="statNilai">—</div>
            <i class="bi bi-cash stat-icon"></i>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-custom">
        <div class="card-header-custom">
            <h2 class="card-title-custom">
                <span class="card-title-dot"></span>
                Daftar Barang
            </h2>
            <button class="btn-ghost-custom" onclick="refreshTable()">
                <i class="bi bi-arrow-clockwise"></i>
                Refresh
            </button>
        </div>
        <div class="card-body-custom">
            <div class="table-responsive">
                <table id="tableBarang" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Tgl. Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div><!-- end main-wrapper -->


<!-- ===================== MODAL: TAMBAH / EDIT ===================== -->
<div class="modal fade" id="modalBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formBarang" novalidate>
                    <input type="hidden" id="barangId" name="id">

                    <div class="mb-3">
                        <label class="form-label-custom">Nama Barang <span style="color:#ff6464">*</span></label>
                        <input type="text" id="namaBarang" name="nama_barang"
                               class="form-control-custom"
                               placeholder="cth: Laptop Dell XPS 15"
                               maxlength="100">
                        <div class="invalid-feedback-custom" id="err_nama_barang"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Kategori <span style="color:#ff6464">*</span></label>
                        <select id="kategori" name="kategori" class="form-select-custom">
                            <option value="">— Pilih Kategori —</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Furnitur">Furnitur</option>
                            <option value="Peralatan Kantor">Peralatan Kantor</option>
                            <option value="ATK">ATK (Alat Tulis Kantor)</option>
                            <option value="Kendaraan">Kendaraan</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <div class="invalid-feedback-custom" id="err_kategori"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-5">
                            <label class="form-label-custom">Jumlah <span style="color:#ff6464">*</span></label>
                            <input type="number" id="jumlah" name="jumlah"
                                   class="form-control-custom"
                                   placeholder="0" min="0" step="1">
                            <div class="invalid-feedback-custom" id="err_jumlah"></div>
                        </div>
                        <div class="col-sm-7">
                            <label class="form-label-custom">Harga (Rp) <span style="color:#ff6464">*</span></label>
                            <div class="input-with-prefix">
                                <span class="input-prefix">Rp</span>
                                <input type="number" id="harga" name="harga"
                                       class="form-control-custom"
                                       placeholder="0" min="0" step="100">
                            </div>
                            <div class="invalid-feedback-custom" id="err_harga"></div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-primary-custom" id="btnSimpan" onclick="simpanBarang()">
                    <i class="bi bi-check-lg"></i>
                    <span id="btnSimpanText">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ===================== MODAL: KONFIRMASI HAPUS ===================== -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 20px 24px !important;">
                <div style="text-align:center; padding: 8px 0;">
                    <div style="font-size:32px; color: #ff4444; margin-bottom:12px;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <p style="font-size:13px; color:var(--text); margin-bottom:4px;">Hapus barang ini?</p>
                    <p style="font-family:var(--font-mono); font-size:11px; color:var(--muted); margin:0;"
                       id="hapusNamaBarang">—</p>
                </div>
            </div>
            <div class="modal-footer" style="justify-content:center; gap:8px;">
                <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnHapusKonfirm" class="btn-primary-custom"
                        style="background:#ff4444; color:white;"
                        onclick="konfirmasiHapus()">
                    <i class="bi bi-trash3"></i>
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ===================== SCRIPTS ===================== -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
/* ===================================================
   CONFIGURATION
=================================================== */
const BASE_URL   = '<?= base_url() ?>';
const CSRF_NAME  = '<?= csrf_token() ?>';
const CSRF_HASH  = '<?= csrf_hash() ?>';

// CSRF token auto-refresh helper
function getCsrfData() {
    return {
        [CSRF_NAME]: $('meta[name="csrf-token"]').attr('content') || CSRF_HASH
    };
}

/* ===================================================
   DATE IN NAV
=================================================== */
(function() {
    const opts = { weekday:'short', year:'numeric', month:'short', day:'numeric' };
    const d = new Date().toLocaleDateString('id-ID', opts);
    document.getElementById('navDate').textContent = d;
})();

/* ===================================================
   DATATABLES INIT
=================================================== */
let table;
let tableData = [];

$(document).ready(function() {
    table = $('#tableBarang').DataTable({
        ajax: {
            url: BASE_URL + 'barang/getData',
            type: 'GET',
            dataSrc: 'data',
            error: function(xhr, err, thrown) {
                showToast('error', 'Gagal Memuat', 'Tidak dapat mengambil data dari server.');
            }
        },
        columns: [
            { data: 'no',          className: 'td-no', width: '50px' },
            { data: 'nama_barang', render: (d) => `<span class="td-nama">${d}</span>` },
            { data: 'kategori',    render: (d) => `<span class="td-kategori"><span>${d}</span></span>` },
            { data: 'jumlah',      className: 'td-jumlah' },
            { data: 'harga_fmt',   className: 'td-harga' },
            { data: 'created_at',  className: 'td-no' },
            {
                data: null,
                orderable: false,
                render: function(d) {
                    return `<div class="td-aksi">
                        <button class="btn-icon" onclick="editBarang(${d.id})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-icon danger" onclick="hapusBarang(${d.id}, '${d.nama_barang.replace(/'/g,"\\'")}') " title="Hapus">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>`;
                }
            }
        ],
        language: {
            search:           '',
            searchPlaceholder: 'Cari barang...',
            lengthMenu:       'Tampilkan _MENU_ baris',
            info:             'Menampilkan _START_–_END_ dari _TOTAL_ barang',
            infoEmpty:        'Tidak ada data',
            infoFiltered:     '(difilter dari _MAX_ total)',
            zeroRecords:      '<div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><div class="empty-text">Tidak ada barang ditemukan</div></div>',
            emptyTable:       '<div class="empty-state"><div class="empty-icon"><i class="bi bi-inbox"></i></div><div class="empty-text">Belum ada data barang</div></div>',
            paginate: {
                previous: '<i class="bi bi-chevron-left"></i>',
                next:     '<i class="bi bi-chevron-right"></i>'
            }
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        dom: "<'row mb-3 align-items-center'<'col-sm-6'l><'col-sm-6 text-sm-end'f>>" +
             "<'row'<'col-12'tr>>" +
             "<'row mt-3 align-items-center'<'col-sm-5'i><'col-sm-7 text-sm-end'p>>",
        drawCallback: function() {
            updateStats(this.api().data().toArray());
        }
    });
});

/* ===================================================
   UPDATE STATS
=================================================== */
function updateStats(data) {
    tableData = data;

    const total     = data.length;
    const totalStok = data.reduce((s, r) => s + parseInt(r.jumlah || 0), 0);
    const kategoris = [...new Set(data.map(r => r.kategori))].length;
    const nilai     = data.reduce((s, r) => s + parseFloat(r.harga || 0) * parseInt(r.jumlah || 0), 0);

    document.getElementById('statTotal').textContent    = total;
    document.getElementById('statStok').textContent     = totalStok.toLocaleString('id-ID');
    document.getElementById('statKategori').textContent = kategoris;
    document.getElementById('statNilai').textContent    = 'Rp ' + formatRupiah(nilai);
}

function formatRupiah(n) {
    if (n >= 1_000_000_000) return (n/1_000_000_000).toFixed(1).replace('.', ',') + 'M';
    if (n >= 1_000_000)     return (n/1_000_000).toFixed(1).replace('.', ',') + 'Jt';
    return Math.round(n).toLocaleString('id-ID');
}

/* ===================================================
   REFRESH TABLE
=================================================== */
function refreshTable() {
    table.ajax.reload(null, false);
    showToast('success', 'Diperbarui', 'Data inventaris berhasil dimuat ulang.');
}

/* ===================================================
   MODAL: TAMBAH
=================================================== */
function openModalTambah() {
    resetForm();
    document.getElementById('modalTitle').textContent = 'Tambah Barang';
    document.getElementById('btnSimpanText').textContent = 'Simpan';
    document.getElementById('barangId').value = '';
    new bootstrap.Modal(document.getElementById('modalBarang')).show();
}

/* ===================================================
   MODAL: EDIT — fetch data via AJAX
=================================================== */
let editModalInstance = null;

function editBarang(id) {
    resetForm();

    $.ajax({
        url: BASE_URL + 'barang/edit/' + id,
        type: 'GET',
        success: function(res) {
            if (res.status === 'success') {
                const d = res.data;
                document.getElementById('barangId').value    = d.id;
                document.getElementById('namaBarang').value  = d.nama_barang;
                document.getElementById('kategori').value    = d.kategori;
                document.getElementById('jumlah').value      = d.jumlah;
                document.getElementById('harga').value       = d.harga;

                document.getElementById('modalTitle').textContent     = 'Edit Barang';
                document.getElementById('btnSimpanText').textContent  = 'Update';

                editModalInstance = new bootstrap.Modal(document.getElementById('modalBarang'));
                editModalInstance.show();
            } else {
                showToast('error', 'Gagal', res.message || 'Tidak dapat memuat data.');
            }
        },
        error: function() {
            showToast('error', 'Error', 'Terjadi kesalahan saat mengambil data.');
        }
    });
}

/* ===================================================
   SIMPAN (Create / Update)
=================================================== */
function simpanBarang() {
    clearErrors();

    const id          = document.getElementById('barangId').value;
    const nama_barang = document.getElementById('namaBarang').value.trim();
    const kategori    = document.getElementById('kategori').value;
    const jumlah      = document.getElementById('jumlah').value;
    const harga       = document.getElementById('harga').value;

    // Client-side validation
    let hasError = false;

    if (!nama_barang) {
        showFieldError('nama_barang', 'Nama barang wajib diisi.'); hasError = true;
    }
    if (!kategori) {
        showFieldError('kategori', 'Kategori wajib dipilih.'); hasError = true;
    }
    if (jumlah === '' || parseInt(jumlah) < 0) {
        showFieldError('jumlah', 'Jumlah wajib diisi (≥ 0).'); hasError = true;
    }
    if (harga === '' || parseFloat(harga) < 0) {
        showFieldError('harga', 'Harga wajib diisi (≥ 0).'); hasError = true;
    }

    if (hasError) return;

    const isEdit  = id !== '';
    const url     = BASE_URL + (isEdit ? 'barang/update' : 'barang/store');

    const formData = {
        id,
        nama_barang,
        kategori,
        jumlah,
        harga,
        [CSRF_NAME]: CSRF_HASH
    };

    // Loading state
    const btn = document.getElementById('btnSimpan');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-custom"></span> Menyimpan...';

    $.ajax({
        url,
        type: 'POST',
        data: formData,
        success: function(res) {
            btn.disabled = false;
            btn.innerHTML = `<i class="bi bi-check-lg"></i> <span>${isEdit ? 'Update' : 'Simpan'}</span>`;

            if (res.status === 'success') {
                bootstrap.Modal.getInstance(document.getElementById('modalBarang'))?.hide();
                table.ajax.reload(null, false);
                showToast('success', isEdit ? 'Berhasil Diperbarui' : 'Berhasil Ditambahkan', res.message);
            } else {
                if (res.errors) {
                    Object.keys(res.errors).forEach(k => showFieldError(k, res.errors[k]));
                } else {
                    showToast('error', 'Gagal', res.message || 'Terjadi kesalahan.');
                }
            }
        },
        error: function() {
            btn.disabled = false;
            btn.innerHTML = `<i class="bi bi-check-lg"></i> <span>${isEdit ? 'Update' : 'Simpan'}</span>`;
            showToast('error', 'Error', 'Gagal menghubungi server. Silakan coba lagi.');
        }
    });
}

/* ===================================================
   HAPUS
=================================================== */
let hapusId = null;

function hapusBarang(id, nama) {
    hapusId = id;
    document.getElementById('hapusNamaBarang').textContent = nama;
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}

function konfirmasiHapus() {
    if (!hapusId) return;

    const btn = document.getElementById('btnHapusKonfirm');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-custom" style="border-top-color:white;border-color:rgba(255,255,255,0.2)"></span> Menghapus...';

    $.ajax({
        url: BASE_URL + 'barang/delete',
        type: 'POST',
        data: { id: hapusId, [CSRF_NAME]: CSRF_HASH },
        success: function(res) {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-trash3"></i> Hapus';

            bootstrap.Modal.getInstance(document.getElementById('modalHapus'))?.hide();

            if (res.status === 'success') {
                table.ajax.reload(null, false);
                showToast('success', 'Berhasil Dihapus', res.message);
            } else {
                showToast('error', 'Gagal', res.message || 'Tidak dapat menghapus barang.');
            }
            hapusId = null;
        },
        error: function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-trash3"></i> Hapus';
            showToast('error', 'Error', 'Gagal menghubungi server.');
        }
    });
}

/* ===================================================
   FORM HELPERS
=================================================== */
function resetForm() {
    document.getElementById('formBarang').reset();
    clearErrors();
}

function clearErrors() {
    document.querySelectorAll('.invalid-feedback-custom').forEach(el => {
        el.textContent = '';
        el.classList.remove('show');
    });
    document.querySelectorAll('.form-control-custom, .form-select-custom').forEach(el => {
        el.classList.remove('is-invalid');
    });
}

function showFieldError(field, msg) {
    const errEl = document.getElementById('err_' + field);
    if (errEl) {
        errEl.textContent = msg;
        errEl.classList.add('show');
    }
    const inputEl = document.querySelector(`[name="${field}"]`);
    if (inputEl) inputEl.classList.add('is-invalid');
}

/* ===================================================
   TOAST NOTIFICATIONS
=================================================== */
function showToast(type, title, message) {
    const container = document.getElementById('toastContainer');

    const toast = document.createElement('div');
    toast.className = 'toast-custom';
    toast.innerHTML = `
        <div class="toast-icon ${type}">
            <i class="bi bi-${type === 'success' ? 'check-lg' : 'exclamation-lg'}"></i>
        </div>
        <div class="toast-body-custom">
            <div class="toast-title">${title}</div>
            <div class="toast-msg">${message}</div>
        </div>
        <button class="toast-close-btn" onclick="closeToast(this)">
            <i class="bi bi-x"></i>
        </button>
    `;

    container.appendChild(toast);

    // Auto-close after 4s
    setTimeout(() => closeToast(toast.querySelector('.toast-close-btn')), 4000);
}

function closeToast(btnEl) {
    const toast = btnEl.closest('.toast-custom');
    if (!toast) return;
    toast.classList.add('hiding');
    setTimeout(() => toast.remove(), 200);
}

/* ===================================================
   KEYBOARD: ESC closes modal
=================================================== */
document.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
        const modal = document.getElementById('modalBarang');
        if (modal.classList.contains('show')) simpanBarang();
    }
});
</script>

</body>
</html>
