<!-- ═══ HALAMAN 1: TABEL DATA JERSEY (jQuery DataTable JSON) ═══ -->

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(232,69,44,0.1)">
                <i class="bi bi-shirt" style="color:var(--accent)"></i>
            </div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-label">Total Jersey</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(40,167,69,0.1)">
                <i class="bi bi-check2-circle" style="color:#28a745"></i>
            </div>
            <div class="stat-value"><?= $totalAktif ?></div>
            <div class="stat-label">Jersey Aktif</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(240,180,41,0.1)">
                <i class="bi bi-boxes" style="color:var(--accent-2)"></i>
            </div>
            <div class="stat-value"><?= number_format($totalStok) ?></div>
            <div class="stat-label">Total Stok</div>
        </div>
    </div>
</div>

<!-- Tabel Card -->
<div class="content-card">
    <div class="card-header-custom">
        <div class="ch-icon"><i class="bi bi-table"></i></div>
        <div>
            <div class="ch-title">Daftar Jersey</div>
            <div style="font-size:0.78rem;color:#8898b8">Data diambil via format JSON — jQuery DataTables</div>
        </div>
        <div class="ms-auto">
            <a href="<?= base_url('jersey/tambah') ?>" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Jersey
            </a>
        </div>
    </div>

    <div class="card-body-custom">
        <div class="alert alert-warning d-flex align-items-center gap-2 py-2 mb-3" style="border-radius:10px;font-size:0.82rem">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>Stok &le; 5 ditandai merah. Klik <i class="bi bi-eye"></i> untuk melihat detail jersey.</div>
        </div>

        <div class="table-responsive">
            <table id="tabelJersey" class="table table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th width="45">#</th>
                        <th>Kode</th>
                        <th>Nama / Klub</th>
                        <th>Liga</th>
                        <th>Musim</th>
                        <th>Ukuran</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th width="130" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(function () {

    // ─── Animasi counter ───
    $('.stat-value').each(function () {
        var $el = $(this);
        var end = parseInt($el.text().replace(/[^0-9]/g, '')) || 0;
        $({ v: 0 }).animate({ v: end }, {
            duration: 900, easing: 'swing',
            step: function () { $el.text(Math.ceil(this.v).toLocaleString('id-ID')); },
            complete: function () { $el.text(end.toLocaleString('id-ID')); }
        });
    });

    // ─── DATATABLE ───
    var table = $('#tabelJersey').DataTable({
    processing: true,
    serverSide: false,

    ajax: {
        url: "<?= base_url('jersey/json') ?>",
        type: "GET",
        dataSrc: 'data'
    },

    // TAMBAHKAN DI SINI
    columns: [
        { data: 0 },
        { data: 1 },
        { data: 2 },
        { data: 3 },
        { data: 4 },
        { data: 5 },
        { data: 6 },
        { data: 7 },
        { data: 8 },
        { data: 9 },
        { data: 10 }
    ]
});

    // ─── DELETE FIX (POST + SWEETALERT)  ───
    $(document).on('click', '.btn-hapus', function () {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        if (confirm('Yakin hapus ' + nama + '?')) {

            $.ajax({
                url: '<?= base_url("jersey/hapus/") ?>' + id,
                type: 'POST', //  FIX
                dataType: 'json',

                success: function (res) {
                    if (res.status === 'success') {
                        alert('Berhasil dihapus');
                        table.ajax.reload(null, false);
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

});
</script>