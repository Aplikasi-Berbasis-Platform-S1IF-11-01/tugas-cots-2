<!-- ═══ DASHBOARD ═══ -->

<!-- Hero Banner -->
<div class="content-card mb-4" style="background:linear-gradient(135deg,#1a1f3c 0%,#2d3561 100%);border:none">
    <div class="card-body-custom py-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.4);letter-spacing:3px;text-transform:uppercase;margin-bottom:8px">
                    Management System
                </div>
                <h2 style="font-family:'Rajdhani',sans-serif;color:white;font-size:2.2rem;font-weight:800;margin-bottom:8px">
                    Selamat Datang di<br><span style="color:#e8452c">Jersey Store-2311102034!</span>
                </h2>
                <p style="color:rgba(255,255,255,0.55);font-size:0.9rem;margin-bottom:20px">
                    Kelola data jersey sepak bola dengan mudah menggunakan Jersey Store-2311102034.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('jersey/tambah') ?>" class="btn btn-accent px-4">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Jersey
                    </a>
                    <a href="<?= base_url('jersey') ?>" class="btn btn-outline-light px-4">
                        <i class="bi bi-table me-1"></i>Lihat Data
                    </a>
                </div>
            </div>
            <div class="col-md-5 text-center d-none d-md-block">
                <div style="font-size:7rem;opacity:0.12;line-height:1">⚽</div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(232,69,44,0.1)">
                <i class="bi bi-shirt" style="color:var(--accent)"></i>
            </div>
            <div class="stat-value"><?= $totalJersey ?></div>
            <div class="stat-label">Total Jersey Terdaftar</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(40,167,69,0.1)">
                <i class="bi bi-check2-circle" style="color:#28a745"></i>
            </div>
            <div class="stat-value"><?= $totalAktif ?></div>
            <div class="stat-label">Jersey Aktif / Tersedia</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(240,180,41,0.1)">
                <i class="bi bi-boxes" style="color:var(--accent-2)"></i>
            </div>
            <div class="stat-value"><?= number_format($totalStok) ?></div>
            <div class="stat-label">Total Unit Stok</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Distribusi Liga -->
    <div class="col-lg-5">
        <div class="content-card h-100">
            <div class="card-header-custom">
                <div class="ch-icon"><i class="bi bi-bar-chart-fill"></i></div>
                <div class="ch-title">Distribusi per Liga</div>
            </div>
            <div class="card-body-custom">
                <?php if (!empty($ligaStats)): ?>
                    <?php
                    $totalLiga = array_sum(array_column((array)$ligaStats, 'jumlah'));
                    $colors = ['#e8452c','#0d6efd','#28a745','#ffc107','#0dcaf0','#6f42c1','#fd7e14'];
                    $i = 0;
                    foreach ($ligaStats as $liga):
                        $pct   = $totalLiga > 0 ? round($liga->jumlah / $totalLiga * 100) : 0;
                        $color = $colors[$i++ % count($colors)];
                    ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold" style="font-size:0.88rem"><?= esc($liga->liga) ?></span>
                            <span class="badge" style="background:<?= $color ?>"><?= $liga->jumlah ?> jersey</span>
                        </div>
                        <div class="progress" style="height:8px;border-radius:20px">
                            <div class="progress-bar" style="width:0%;background:<?= $color ?>;border-radius:20px;transition:width 1.2s ease" data-w="<?= $pct ?>"></div>
                        </div>
                        <div style="font-size:0.72rem;color:#8898b8;margin-top:2px"><?= $pct ?>% dari total</div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-bar-chart fs-2"></i>
                        <p class="mt-2 small">Belum ada data.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Jersey Terbaru -->
    <div class="col-lg-7">
        <div class="content-card h-100">
            <div class="card-header-custom">
                <div class="ch-icon"><i class="bi bi-clock-history"></i></div>
                <div class="ch-title">Jersey Terbaru</div>
                <a href="<?= base_url('jersey') ?>" class="btn btn-outline-secondary btn-sm ms-auto">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="p-0">
                <table class="table table-hover mb-0">
                    <thead style="background:#f8f9fd">
                        <tr>
                            <th style="font-size:0.78rem;padding:12px 16px">Kode</th>
                            <th style="font-size:0.78rem;padding:12px 16px">Jersey</th>
                            <th style="font-size:0.78rem;padding:12px 16px">Harga</th>
                            <th style="font-size:0.78rem;padding:12px 16px">Stok</th>
                            <th style="font-size:0.78rem;padding:12px 16px">Status</th>
                            <th style="font-size:0.78rem;padding:12px 16px">Aksi</th> <!-- 🔥 -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($jerseysTerbaru)): ?>
                            <?php foreach ($jerseysTerbaru as $j): ?>
                            <tr>
                                <td style="padding:10px 16px">
                                    <span class="font-monospace text-primary fw-bold">
                                        <?= esc($j->kode) ?>
                                    </span>
                                </td>

                                <td style="padding:10px 16px;font-size:0.85rem">
                                    <strong><?= esc($j->nama) ?></strong><br>
                                    <small class="text-muted">
                                        <?= esc($j->liga) ?> · <?= esc($j->jenis) ?>
                                    </small>
                                </td>

                                <td style="padding:10px 16px;color:#28a745;font-weight:600">
                                    Rp <?= number_format($j->harga, 0, ',', '.') ?>
                                </td>

                                <td style="padding:10px 16px">
                                    <?php if ($j->stok <= 5): ?>
                                        <span class="badge bg-danger"><?= $j->stok ?></span>
                                    <?php else: ?>
                                        <span class="fw-semibold"><?= $j->stok ?></span>
                                    <?php endif; ?>
                                </td>

                                <td style="padding:10px 16px">
                                    <span class="badge <?= $j->status === 'Aktif' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= esc($j->status) ?>
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td style="padding:10px 16px">
                                    <a href="<?= base_url('jersey/edit/' . $j->id) ?>"
                                    class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button class="btn btn-sm btn-danger btn-hapus"
                                        data-id="<?= $j->id ?>"
                                        data-nama="<?= esc($j->nama) ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2"></i>
                                    <p class="mt-2 small">Belum ada data jersey.</p>
                                    <a href="<?= base_url('jersey/tambah') ?>" class="btn btn-accent btn-sm">
                                        Tambah Sekarang
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="content-card">
            <div class="card-header-custom">
                <div class="ch-icon"><i class="bi bi-lightning-charge"></i></div>
                <div class="ch-title">Aksi Cepat</div>
            </div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <?php
                    $actions = [
                        ['url' => base_url('jersey/tambah'), 'icon' => 'bi-plus-circle-fill', 'label' => 'Tambah Jersey',  'color' => '#e8452c', 'bg' => '#fff7f6', 'border' => 'var(--accent)'],
                        ['url' => base_url('jersey'),        'icon' => 'bi-table',             'label' => 'Data Jersey',    'color' => '#0d6efd', 'bg' => '#f0f8ff', 'border' => '#0d6efd'],
                        ['url' => '#',                       'icon' => 'bi-printer-fill',      'label' => 'Print Laporan',  'color' => '#28a745', 'bg' => '#f0fff4', 'border' => '#28a745', 'onclick' => 'window.print()'],
                        ['url' => '#',                       'icon' => 'bi-info-circle-fill',  'label' => 'Tentang Aplikasi','color' => '#d6a400','bg' => '#fffbf0','border' => '#ffc107', 'modal' => 'modalAbout'],
                    ];
                    foreach ($actions as $a):
                    ?>
                    <div class="col-md-3 col-6">
                        <a href="<?= $a['url'] ?>"
                           <?= isset($a['onclick']) ? 'onclick="' . $a['onclick'] . ';return false"' : '' ?>
                           <?= isset($a['modal']) ? 'data-bs-toggle="modal" data-bs-target="#' . $a['modal'] . '"' : '' ?>
                           class="d-flex flex-column align-items-center justify-content-center p-3 text-center text-decoration-none qa-card"
                           style="background:<?= $a['bg'] ?>;border:2px dashed <?= $a['border'] ?>;border-radius:12px;color:<?= $a['color'] ?>;transition:all 0.2s">
                            <i class="bi <?= $a['icon'] ?>" style="font-size:1.8rem;margin-bottom:8px"></i>
                            <strong style="font-size:0.85rem"><?= $a['label'] ?></strong>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    // ── Animasi counter ──
    $('.stat-value').each(function () {
        var $el = $(this);
        var end = parseInt($el.text().replace(/[^0-9]/g, '')) || 0;
        $({ v: 0 }).animate({ v: end }, {
            duration: 1000, easing: 'swing',
            step: function () { $el.text(Math.ceil(this.v).toLocaleString('id-ID')); },
            complete: function () { $el.text(end.toLocaleString('id-ID')); }
        });
    });

    // ── Animasi progress bar liga ──
    setTimeout(function () {
        $('.progress-bar').each(function () {
            $(this).css('width', $(this).data('w') + '%');
        });
    }, 300);

    $(document).on('click', '.btn-hapus', function () {
    let id = $(this).data('id');
    let nama = $(this).data('nama');

    if (confirm('Yakin ingin menghapus ' + nama + '?')) {
        $.ajax({
            url: "<?= base_url('jersey/hapus/') ?>" + id,
            type: "POST",
            dataType: "json",
            success: function (res) {
                if (res.status === 'success') {
                    alert('Berhasil dihapus');
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Gagal menghapus data');
            }
        });
    }
});

    // ── Hover efek quick action cards ──
    $(document).on('mouseenter', '.qa-card', function () {
        $(this).css({ transform: 'translateY(-3px)', boxShadow: '0 6px 18px rgba(0,0,0,0.1)' });
    }).on('mouseleave', '.qa-card', function () {
        $(this).css({ transform: '', boxShadow: '' });
    });
});
</script>
