<!-- ═══ HALAMAN 2 & 3: FORM TAMBAH / EDIT JERSEY ═══ -->

<div class="row justify-content-center">
<div class="col-xl-9 col-lg-10">

    <!-- Tampilkan error validasi server-side (CI4) -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex gap-2 align-items-start mb-4">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div>
                <strong>Perbaiki kesalahan berikut:</strong>
                <ul class="mb-0 mt-1">
                    <?php foreach ($errors as $err): ?>
                        <li class="alert-item"><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="content-card">
        <div class="card-header-custom">
            <div class="ch-icon">
                <i class="bi <?= $mode === 'edit' ? 'bi-pencil-square' : 'bi-plus-circle' ?>"></i>
            </div>
            <div>
                <div class="ch-title"><?= $mode === 'edit' ? 'Edit Data Jersey' : 'Tambah Jersey Baru' ?></div>
                <div style="font-size:0.78rem;color:#8898b8">
                    <?= $mode === 'edit' ? 'Perbarui informasi jersey' : 'Isi form di bawah untuk menambahkan jersey baru' ?>
                </div>
            </div>
            <div class="ms-auto">
                <a href="<?= base_url('jersey') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>

        <div class="card-body-custom">
            <form id="formJersey" action="<?= $formAction ?>" method="POST" novalidate>
                <?= csrf_field() ?>

                <!-- ── Informasi Dasar ── -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2"
                        style="font-family:'Rajdhani',sans-serif;font-size:1rem;color:var(--primary)">
                        <span style="width:20px;height:20px;background:var(--accent);border-radius:5px;display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-info-circle" style="font-size:0.65rem;color:white"></i>
                        </span>
                        Informasi Dasar
                    </h6>

                    <div class="row g-3">
                        <!-- Kode -->
                        <div class="col-md-4">
                            <label class="form-label" for="kode">Kode Jersey <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dce0ee">
                                    <i class="bi bi-hash text-muted"></i>
                                </span>
                                <input type="text" class="form-control" id="kode" name="kode"
                                       value="<?= esc(old('kode', isset($jersey) && $jersey ? $jersey->kode : $autoKode)) ?>"
                                       placeholder="JRS-001" maxlength="20"
                                       style="border-radius:0 10px 10px 0"
                                       <?= $mode === 'edit' ? 'readonly' : '' ?>>
                            </div>
                            <div class="form-text">Kode unik jersey (auto-generate)</div>
                        </div>

                        <!-- Nama Jersey-->
                        <div class="col-md-8">
                            <label class="form-label" for="nama">Nama Jersey <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                                   id="nama" name="nama"
                                   value="<?= esc(old('nama', isset($jersey) && $jersey ? $jersey->nama : '')) ?>"
                                   placeholder="Real Madrid Home 2024/25" maxlength="150">
                            <?php if (isset($errors['nama'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['nama']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Klub -->
                        <div class="col-md-6">
                            <label class="form-label" for="klub">Nama Klub / Tim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= isset($errors['klub']) ? 'is-invalid' : '' ?>"
                                   id="klub" name="klub"
                                   value="<?= esc(old('klub', isset($jersey) && $jersey ? $jersey->klub : '')) ?>"
                                   placeholder="Real Madrid" maxlength="100">
                            <?php if (isset($errors['klub'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['klub']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Liga -->
                        <div class="col-md-6">
                            <label class="form-label" for="liga">Liga <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= isset($errors['liga']) ? 'is-invalid' : '' ?>"
                                   id="liga" name="liga"
                                   value="<?= esc(old('liga', isset($jersey) && $jersey ? $jersey->liga : '')) ?>"
                                   placeholder="La Liga, Premier League..." maxlength="100">
                            <?php if (isset($errors['liga'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['liga']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Musim -->
                        <div class="col-md-4">
                            <label class="form-label" for="musim">Musim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= isset($errors['musim']) ? 'is-invalid' : '' ?>"
                                   id="musim" name="musim"
                                   value="<?= esc(old('musim', isset($jersey) && $jersey ? $jersey->musim : '')) ?>"
                                   placeholder="2024/2025" maxlength="20">
                            <?php if (isset($errors['musim'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['musim']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Ukuran -->
                        <div class="col-md-4">
                            <label class="form-label" for="ukuran">Ukuran <span class="text-danger">*</span></label>
                            <select class="form-select <?= isset($errors['ukuran']) ? 'is-invalid' : '' ?>"
                                    id="ukuran" name="ukuran">
                                <option value="">-- Pilih Ukuran --</option>
                                <?php
                                $ukuranList = ['S','M','L','XL','XXL'];
                                $selUkuran  = old('ukuran', isset($jersey) && $jersey ? $jersey->ukuran : '');
                                foreach ($ukuranList as $u):
                                ?>
                                    <option value="<?= $u ?>" <?= $selUkuran === $u ? 'selected' : '' ?>><?= $u ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['ukuran'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['ukuran']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Jenis Jersey-->
                        <div class="col-md-4">
                            <label class="form-label" for="jenis">Jenis Jersey <span class="text-danger">*</span></label>
                            <select class="form-select <?= isset($errors['jenis']) ? 'is-invalid' : '' ?>"
                                    id="jenis" name="jenis">
                                <option value="">-- Pilih Jenis --</option>
                                <?php
                                $jenisList = ['Home','Away','Third','GK','Training'];
                                $selJenis  = old('jenis', isset($jersey) && $jersey ? $jersey->jenis : '');
                                foreach ($jenisList as $j):
                                ?>
                                    <option value="<?= $j ?>" <?= $selJenis === $j ? 'selected' : '' ?>><?= $j ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['jenis'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['jenis']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr style="border-color:#eef0f8;margin:24px 0">

                <!-- ── Harga & Stok ── -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2"
                        style="font-family:'Rajdhani',sans-serif;font-size:1rem;color:var(--primary)">
                        <span style="width:20px;height:20px;background:#28a745;border-radius:5px;display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-currency-dollar" style="font-size:0.65rem;color:white"></i>
                        </span>
                        Harga & Stok
                    </h6>
                    <div class="row g-3">
                        <!-- Harga -->
                        <div class="col-md-6">
                            <label class="form-label" for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dce0ee">Rp</span>
                                <input type="number" class="form-control <?= isset($errors['harga']) ? 'is-invalid' : '' ?>"
                                       id="harga" name="harga"
                                       value="<?= esc(old('harga', isset($jersey) && $jersey ? $jersey->harga : '')) ?>"
                                       placeholder="450000" min="1" style="border-radius:0 10px 10px 0">
                            </div>
                            <div class="form-text">Preview: <strong id="hargaPreview" class="text-success">Rp 0</strong></div>
                            <?php if (isset($errors['harga'])): ?>
                                <div class="text-danger small"><?= esc($errors['harga']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6">
                            <label class="form-label" for="stok">Stok <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" id="btnMin"
                                        style="border-radius:10px 0 0 10px"><i class="bi bi-dash-lg"></i></button>
                                <input type="number" class="form-control text-center <?= isset($errors['stok']) ? 'is-invalid' : '' ?>"
                                       id="stok" name="stok"
                                       value="<?= esc(old('stok', isset($jersey) && $jersey ? $jersey->stok : '0')) ?>"
                                       min="0" style="border-radius:0">
                                <button type="button" class="btn btn-outline-secondary" id="btnPlus"
                                        style="border-radius:0 10px 10px 0"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <?php if (isset($errors['stok'])): ?>
                                <div class="text-danger small"><?= esc($errors['stok']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr style="border-color:#eef0f8;margin:24px 0">

                <!-- ── Lainnya ── -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2"
                        style="font-family:'Rajdhani',sans-serif;font-size:1rem;color:var(--primary)">
                        <span style="width:20px;height:20px;background:#6b7ba4;border-radius:5px;display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-three-dots" style="font-size:0.65rem;color:white"></i>
                        </span>
                        Informasi Tambahan
                    </h6>
                    <div class="row g-3">
                        <!-- Deskripsi -->
                        <div class="col-md-8">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"
                                      rows="3" placeholder="Deskripsi singkat jersey..."
                                      maxlength="500"><?= esc(old('deskripsi', isset($jersey) && $jersey ? $jersey->deskripsi : '')) ?></textarea>
                            <div class="form-text"><span id="descCount">0</span>/500 karakter</div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <?php $selStatus = old('status', isset($jersey) && $jersey ? $jersey->status : 'Aktif'); ?>
                            <div class="d-flex flex-column gap-2 mt-1">
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                                    <input type="radio" name="status" value="Aktif"
                                           <?= $selStatus === 'Aktif' ? 'checked' : '' ?>>
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i>Aktif
                                    </span>
                                </label>
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                                    <input type="radio" name="status" value="Nonaktif"
                                           <?= $selStatus === 'Nonaktif' ? 'checked' : '' ?>>
                                    <span class="badge bg-secondary fs-6 px-3 py-2">
                                        <i class="bi bi-x-circle me-1"></i>Nonaktif
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border-color:#eef0f8;margin:24px 0">

                <!-- Tombol Aksi -->
                <div class="d-flex gap-3 justify-content-end flex-wrap">
                    <a href="<?= base_url('jersey') ?>" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </a>
                    <button type="button" class="btn btn-outline-warning px-4" id="btnReset">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-accent px-5" id="btnSubmit">
                        <i class="bi <?= $mode === 'edit' ? 'bi-save' : 'bi-plus-circle' ?> me-1"></i>
                        <?= $mode === 'edit' ? 'Simpan Perubahan' : 'Tambah Jersey' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
</div>

<script>
$(function () {

    // ── jQuery Validate Plugin: Validasi form client-side ──
    $('#formJersey').validate({
        rules: {
            nama:   { required: true, minlength: 3 },
            klub:   { required: true },
            liga:   { required: true },
            musim:  { required: true },
            ukuran: { required: true },
            jenis:  { required: true },
            harga:  { required: true, number: true, min: 1 },
            stok:   { required: true, digits: true, min: 0 },
            status: { required: true },
        },
        messages: {
            nama:   { required: 'Nama jersey wajib diisi', minlength: 'Minimal 3 karakter' },
            klub:   { required: 'Nama klub wajib diisi' },
            liga:   { required: 'Liga wajib diisi' },
            musim:  { required: 'Musim wajib diisi' },
            ukuran: { required: 'Pilih ukuran jersey' },
            jenis:  { required: 'Pilih jenis jersey' },
            harga:  { required: 'Harga wajib diisi', number: 'Masukkan angka', min: 'Harga harus > 0' },
            stok:   { required: 'Stok wajib diisi', digits: 'Bilangan bulat', min: 'Minimal 0' },
            status: { required: 'Pilih status jersey' },
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback d-block',
        highlight:   function (el) { $(el).addClass('is-invalid').removeClass('is-valid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid').addClass('is-valid'); },
        submitHandler: function (form) {
            $('#btnSubmit').prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
            form.submit();
        }
    });

    // ── Preview harga real-time (jQuery) ──
    function updateHarga() {
        var v = parseInt($('#harga').val()) || 0;
        $('#hargaPreview').text('Rp ' + v.toLocaleString('id-ID'));
    }
    $('#harga').on('input', updateHarga);
    updateHarga();

    // ── Tombol stok +/- (jQuery) ──
    $('#btnPlus').on('click', function () {
        $('#stok').val((parseInt($('#stok').val()) || 0) + 1);
    });
    $('#btnMin').on('click', function () {
        var v = parseInt($('#stok').val()) || 0;
        if (v > 0) $('#stok').val(v - 1);
    });

    // ── Counter karakter deskripsi ──
    function updateCount() { $('#descCount').text($('#deskripsi').val().length); }
    $('#deskripsi').on('input', updateCount);
    updateCount();

    // ── Konfirmasi reset form ──
    $('#btnReset').on('click', function () {
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua perubahan akan direset.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f0b429',
            cancelButtonColor:  '#6b7ba4',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText:  'Batal',
        }).then(function (r) {
            if (r.isConfirmed) {
                document.getElementById('formJersey').reset();
                updateHarga(); updateCount();
                $('.form-control, .form-select').removeClass('is-valid is-invalid');
                $('.invalid-feedback.d-block').remove();
            }
        });
    });

    // ── Efek visual select jenis jersey ──
    var jenisColors = { Home:'#0d6efd', Away:'#0dcaf0', Third:'#ffc107', GK:'#dc3545', Training:'#212529' };
    $('#jenis').on('change', function () {
        $(this).css('border-color', jenisColors[$(this).val()] || '#dce0ee');
    }).trigger('change');

    // ── Visual feedback radio status ──
    $('input[name="status"]').on('change', function () {
        $('input[name="status"]').closest('label').find('.badge').css('opacity', '0.45');
        $(this).closest('label').find('.badge').css('opacity', '1');
    });
    $('input[name="status"]:checked').closest('label').find('.badge').css('opacity', '1');
    $('input[name="status"]:not(:checked)').closest('label').find('.badge').css('opacity', '0.45');

    // ── Auto fokus ke nama ──
    setTimeout(function () { $('#nama').focus(); }, 300);
});
</script>
