<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
          <i class="bi bi-pencil-square me-2"></i>Edit Penjual
        </h5>
      </div>
      <div class="card-body">
        <form action="/penjual/update/<?= $penjual['id'] ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label fw-semibold">Nama</label>
            <input type="text" name="nama" class="form-control"
                   value="<?= $penjual['nama'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Telepon</label>
            <input type="text" name="telepon" class="form-control"
                   value="<?= $penjual['telepon'] ?>">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= $penjual['email'] ?>">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3"><?= $penjual['alamat'] ?></textarea>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-1"></i>Update
            </button>
            <a href="/penjual" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>