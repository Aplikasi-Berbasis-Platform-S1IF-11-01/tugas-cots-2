<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4><i class="bi bi-people me-2 text-primary"></i>Data Penjual</h4>
  <a href="/penjual/create" class="btn btn-primary">
    <i class="bi bi-person-plus me-1"></i>Tambah Penjual
  </a>
</div>

<div class="card">
  <div class="card-body">
    <table id="tabelPenjual" class="table table-bordered table-hover w-100">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Telepon</th>
          <th>Email</th>
          <th>Alamat</th>
          <th>Aksi</th> 
        </tr>
      </thead>
    </table>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#tabelPenjual').DataTable({
        processing: true,
        ajax: {
            url: '/penjual/json',
            dataSrc: 'data'
        },
        columns: [
            { data: 'no' },
            { data: 'nama' },
            { data: 'telepon' },
            { data: 'email' },
            { data: 'alamat' },
            {
                data: 'id', 
                orderable: false,
                render: function(data) {
                    return `
                        <a href="/penjual/edit/${data}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="/penjual/delete/${data}" 
                          class="btn btn-danger btn-sm"
                          onclick="return confirm('Yakin hapus data ini?')">
                          <i class="bi bi-trash"></i>
                        </a>
                    `;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
<?= $this->endSection() ?>