<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Data Mobil</h5>
      </div>
      <div class="card-body">
        <form id="formTambah" action="/mobil/store" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Penjual / Dealer</label>
              <select name="penjual_id" class="form-select" required>
                <option value="">-- Pilih Penjual --</option>
                <?php foreach ($penjual as $p): ?>
                  <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Merk</label>
              <input type="text" name="merk" class="form-control" placeholder="Toyota, Honda..." required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Model</label>
              <input type="text" name="model" class="form-control" placeholder="Avanza, Brio..." required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Tahun</label>
              <input type="number" name="tahun" class="form-control" min="1990" max="2025" required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Harga (Rp)</label>
              <input type="number" name="harga" class="form-control" placeholder="150000000" required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Warna</label>
              <input type="text" name="warna" class="form-control" placeholder="Putih, Hitam...">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">KM Tempuh</label>
              <input type="number" name="km_tempuh" class="form-control" placeholder="50000">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Transmisi</label>
              <select name="transmisi" class="form-select">
                <option value="Manual">Manual</option>
                <option value="Otomatis">Otomatis</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Bahan Bakar</label>
              <select name="bahan_bakar" class="form-select">
                <option value="Bensin">Bensin</option>
                <option value="Diesel">Diesel</option>
                <option value="Listrik">Listrik</option>
                <option value="Hybrid">Hybrid</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" class="form-select">
                <option value="Tersedia">Tersedia</option>
                <option value="Proses">Proses</option>
                <option value="Terjual">Terjual</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Foto Mobil</label>
              <input type="file" name="foto" class="form-control" accept="image/*" id="inputFoto">
              <div id="previewFoto" class="mt-2 d-none">
                <img id="gambarPreview" src="" alt="Preview" style="max-height:200px; border-radius:8px;">
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="3" placeholder="Kondisi mobil, kelengkapan surat, dll..."></textarea>
            </div>

            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Simpan Data
              </button>
              <a href="/mobil" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Preview foto sebelum upload (jQuery plugin usage)
    $('#inputFoto').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#gambarPreview').attr('src', e.target.result);
                $('#previewFoto').removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // jQuery Validate plugin
    $('#formTambah').validate({
        rules: {
            merk:   { required: true, minlength: 2 },
            model:  { required: true, minlength: 2 },
            tahun:  { required: true, digits: true, min: 1990, max: 2025 },
            harga:  { required: true, digits: true, min: 1 },
        },
        messages: {
            merk:  { required: 'Merk wajib diisi', minlength: 'Minimal 2 karakter' },
            model: { required: 'Model wajib diisi' },
            tahun: { required: 'Tahun wajib diisi', min: 'Minimal 1990', max: 'Maksimal 2025' },
            harga: { required: 'Harga wajib diisi', min: 'Harga harus lebih dari 0' },
        },
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-3, .col-md-4, .col-12, .col-md-6').append(error);
        }
    });
});
</script>
<?= $this->endSection() ?>