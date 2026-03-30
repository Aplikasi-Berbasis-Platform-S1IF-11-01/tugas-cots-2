<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-header bg-warning">
        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Mobil</h5>
      </div>
      <div class="card-body">
        <form id="formEdit" action="/mobil/update/<?= $mobil['id'] ?>" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Penjual / Dealer</label>
              <select name="penjual_id" class="form-select">
                <option value="">-- Pilih Penjual --</option>
                <?php foreach ($penjual as $p): ?>
                  <option value="<?= $p['id'] ?>" <?= $p['id'] == $mobil['penjual_id'] ? 'selected' : '' ?>>
                    <?= $p['nama'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Merk</label>
              <input type="text" name="merk" class="form-control" value="<?= $mobil['merk'] ?>" required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Model</label>
              <input type="text" name="model" class="form-control" value="<?= $mobil['model'] ?>" required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Tahun</label>
              <input type="number" name="tahun" class="form-control" value="<?= $mobil['tahun'] ?>" min="1990" max="2025" required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Harga (Rp)</label>
              <input type="number" name="harga" class="form-control" value="<?= $mobil['harga'] ?>" required>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">Warna</label>
              <input type="text" name="warna" class="form-control" value="<?= $mobil['warna'] ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold">KM Tempuh</label>
              <input type="number" name="km_tempuh" class="form-control" value="<?= $mobil['km_tempuh'] ?>">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Transmisi</label>
              <select name="transmisi" class="form-select">
                <option value="Manual"   <?= $mobil['transmisi'] == 'Manual'   ? 'selected' : '' ?>>Manual</option>
                <option value="Otomatis" <?= $mobil['transmisi'] == 'Otomatis' ? 'selected' : '' ?>>Otomatis</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Bahan Bakar</label>
              <select name="bahan_bakar" class="form-select">
                <?php foreach (['Bensin','Diesel','Listrik','Hybrid'] as $bb): ?>
                  <option value="<?= $bb ?>" <?= $mobil['bahan_bakar'] == $bb ? 'selected' : '' ?>><?= $bb ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Status</label>
              <select name="status" class="form-select">
                <?php foreach (['Tersedia','Proses','Terjual'] as $st): ?>
                  <option value="<?= $st ?>" <?= $mobil['status'] == $st ? 'selected' : '' ?>><?= $st ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Foto Mobil</label>
              <?php if ($mobil['foto']): ?>
                <div class="mb-2">
                  <img src="/uploads/<?= $mobil['foto'] ?>" style="max-height:150px; border-radius:8px;">
                  <small class="text-muted d-block mt-1">Upload foto baru untuk mengganti</small>
                </div>
              <?php endif; ?>
              <input type="file" name="foto" class="form-control" accept="image/*" id="inputFotoEdit">
              <div id="previewFotoEdit" class="mt-2 d-none">
                <img id="gambarPreviewEdit" src="" style="max-height:150px; border-radius:8px;">
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="3"><?= $mobil['deskripsi'] ?></textarea>
            </div>

            <div class="col-12 d-flex gap-2">
              <button type="submit" class="btn btn-warning">
                <i class="bi bi-save me-1"></i>Update Data
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
    $('#inputFotoEdit').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#gambarPreviewEdit').attr('src', e.target.result);
                $('#previewFotoEdit').removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    $('#formEdit').validate({
        rules: {
            merk:  { required: true },
            model: { required: true },
            tahun: { required: true, digits: true },
            harga: { required: true, digits: true },
        },
        errorClass: 'is-invalid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('[class^="col-"]').append(error);
        }
    });
});
</script>
<?= $this->endSection() ?>