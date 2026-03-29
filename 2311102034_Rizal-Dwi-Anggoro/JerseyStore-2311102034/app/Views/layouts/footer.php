    </div><!-- end .page-content -->
</div><!-- end .main-content -->

<!-- Modal: Tentang Aplikasi -->
<div class="modal fade" id="modalAbout" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Tentang Aplikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div style="font-size:3rem">⚽</div>
                    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;color:var(--primary)">Jersey Store Management</h4>
                    <span class="badge bg-danger">v1.0.0 — CI4</span>
                </div>
                <hr>
                <dl class="row mb-0 small">
                    <dt class="col-5">Framework</dt><dd class="col-7">CodeIgniter 4</dd>
                    <dt class="col-5">Frontend</dt><dd class="col-7">Bootstrap 5.3 + jQuery</dd>
                    <dt class="col-5">Tabel Data</dt><dd class="col-7">jQuery DataTables (JSON)</dd>
                    <dt class="col-5">Database</dt><dd class="col-7">MySQL / MariaDB</dd>
                    <dt class="col-5">Alert</dt><dd class="col-7">SweetAlert2</dd>
                    <dt class="col-5">Validasi</dt><dd class="col-7">jQuery Validate Plugin</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Detail Jersey -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-shirt me-2"></i>Detail Jersey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="detailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-danger"></div>
                    <p class="mt-2 text-muted small">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-warning btn-sm" id="btnEditDariDetail">
                    <i class="bi bi-pencil-square me-1"></i>Edit
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ═══ JS LIBRARIES ═══ -->
<!-- 1. jQuery — wajib dimuat pertama -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- 2. Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- 3. jQuery DataTables + Bootstrap5 theme -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- 4. DataTables Buttons Plugin -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<!-- 5. DataTables Responsive Plugin -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<!-- 6. SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- 7. jQuery Validate Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<!-- 8. jQuery Mask Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
$(function () {

    // ── Sembunyikan page loader ──
    setTimeout(function () {
        $('#pageLoader').addClass('hide');
        setTimeout(function () { $('#pageLoader').hide(); }, 350);
    }, 350);

    // ── Sidebar toggle (mobile) ──
    $('#sidebarToggle').on('click', function () {
        $('#sidebar').toggleClass('show');
    });

    // ── Auto-dismiss alert setelah 5 detik ──
    setTimeout(function () { $('.alert').fadeOut(500); }, 5000);

    // ── Modal Detail Jersey via AJAX ──
    $(document).on('click', '.btn-detail', function () {
        var id = $(this).data('id');
        $('#detailContent').html(
            '<div class="text-center py-4">' +
            '<div class="spinner-border text-danger"></div>' +
            '<p class="mt-2 text-muted small">Memuat data...</p></div>'
        );
        var modal = new bootstrap.Modal(document.getElementById('modalDetail'));
        modal.show();

        $.getJSON('<?= base_url("jersey/detail/") ?>' + id, function (res) {
            if (res.status === 'success') {
                var d = res.data;
                var harga = 'Rp ' + parseInt(d.harga).toLocaleString('id-ID');
                var statusBadge = d.status === 'Aktif'
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-secondary">Nonaktif</span>';
                var jenisBadge = '<span class="badge bg-primary">' + d.jenis + '</span>';

                $('#detailContent').html(
                    '<div class="row">' +
                    '<div class="col-md-6"><dl class="detail-list">' +
                    '<dt>Kode</dt><dd><span class="font-monospace text-primary fw-bold fs-6">' + d.kode + '</span></dd>' +
                    '<dt>Nama Jersey</dt><dd>' + d.nama + '</dd>' +
                    '<dt>Klub / Tim</dt><dd>' + d.klub + '</dd>' +
                    '<dt>Liga</dt><dd>' + d.liga + '</dd>' +
                    '<dt>Musim</dt><dd>' + d.musim + '</dd>' +
                    '</dl></div>' +
                    '<div class="col-md-6"><dl class="detail-list">' +
                    '<dt>Ukuran</dt><dd><span class="badge bg-light text-dark border fs-6">' + d.ukuran + '</span></dd>' +
                    '<dt>Jenis</dt><dd>' + jenisBadge + '</dd>' +
                    '<dt>Harga</dt><dd class="text-success fw-bold fs-5">' + harga + '</dd>' +
                    '<dt>Stok</dt><dd>' + d.stok + ' pcs</dd>' +
                    '<dt>Status</dt><dd>' + statusBadge + '</dd>' +
                    '</dl></div>' +
                    '</div>' +
                    (d.deskripsi ? '<hr><p class="text-muted small mb-0"><strong>Deskripsi:</strong> ' + d.deskripsi + '</p>' : '')
                );
                $('#btnEditDariDetail').attr('href', '<?= base_url("jersey/edit/") ?>' + id);
            }
        }).fail(function () {
            $('#detailContent').html('<div class="alert alert-danger">Gagal memuat data.</div>');
        });
    });

});
</script>
</body>
</html>
