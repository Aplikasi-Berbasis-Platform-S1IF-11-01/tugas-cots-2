<!-- penjual/create.php -->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Tambah Penjual</h5>
      </div>
      <div class="card-body">
        <form id="formPenjual" action="/penjual/store" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap / Nama Dealer</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Nomor Telepon</label>
            <input type="text" name="telepon" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3"></textarea>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="/penjual" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
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
    $('#formPenjual').validate({
        rules: { nama: { required: true, minlength: 3 } },
        messages: { nama: { required: 'Nama wajib diisi' } },
        errorClass: 'is-invalid',
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.parent().append(error);
        }
    });
});
</script>
<?= $this->endSection() ?>