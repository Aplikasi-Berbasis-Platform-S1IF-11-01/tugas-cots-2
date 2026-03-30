<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0"><i class="bi bi-table me-2 text-primary"></i>Data Mobil</h4>
  <a href="/mobil/create" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i>Tambah Mobil
  </a>
</div>

<div class="card">
  <div class="card-body">
    <table id="tabelMobil" class="table table-bordered table-hover align-middle w-100">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Foto</th>
          <th>Merk / Model</th>
          <th>Tahun</th>
          <th>Harga</th>
          <th>KM</th>
          <th>Transmisi</th>
          <th>Status</th>
          <th>Penjual</th>
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
    $('#tabelMobil').DataTable({
        processing: true, 
        ajax: {
            url: '/mobil/json',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'no' },
            {
                data: 'foto',
                render: function(data) {
                    if (data) {
                        return '<img src="/uploads/' + data + '" class="table-img" loading="lazy">';
                    }
                    return '-';
                }
            },
            {
                data: 'merk',
                render: function(data, type, row) {
                    return '<strong>' + data + '</strong><br><small class="text-muted">' + row.model + '</small>';
                }
            },
            { data: 'tahun' },
            { data: 'harga' },
            { data: 'km_tempuh' },
            { data: 'transmisi' },
            {
                data: 'status',
                render: function(data) {
                    let cls = {
                        'Tersedia': 'badge-tersedia',
                        'Terjual': 'badge-terjual',
                        'Proses': 'badge-proses'
                    };
                    return '<span class="badge ' + (cls[data] || 'bg-secondary') + '">' + data + '</span>';
                }
            },
            { data: 'nama_penjual' },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <a href="/mobil/edit/${data}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="/mobil/delete/${data}" class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus?')">
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