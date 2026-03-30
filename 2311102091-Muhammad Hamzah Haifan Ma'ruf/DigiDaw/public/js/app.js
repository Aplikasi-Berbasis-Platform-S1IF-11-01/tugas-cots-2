$(document).ready(function () {
  function showToast(message) {
    $('#toastMessage').text(message);
    const toastEl = document.getElementById('liveToast');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  }

  function updateStats() {
    $.get('/api/items', function (res) {
      const items = res.data || [];
      $('#totalData').text(items.length);
      $('#totalAktif').text(items.filter(item => item.status === 'Aktif').length);
      $('#totalNonaktif').text(items.filter(item => item.status === 'Nonaktif').length);
    });
  }

  if ($('#digidawTable').length) {
    const table = $('#digidawTable').DataTable({
      processing: true,
      ajax: {
        url: '/api/items',
        dataSrc: 'data'
      },
      columns: [
        { data: 'id' },
        { data: 'nama' },
        { data: 'kategori' },
        {
          data: 'harga',
          render: function (data) {
            return 'Rp ' + Number(data).toLocaleString('id-ID');
          }
        },
        {
          data: 'status',
          render: function (data) {
            const cls = data === 'Aktif'
              ? 'badge rounded-pill text-bg-light text-dark px-3 py-2'
              : 'badge rounded-pill border border-light text-light px-3 py-2';
            return `<span class="${cls}">${data}</span>`;
          }
        },
        {
          data: 'deskripsi',
          render: function (data) {
            return `<span class="desc-cell">${data || '-'}</span>`;
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data) {
            return `
              <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-sm btn-light editBtn" data-id="${data.id}">Edit</button>
                <button class="btn btn-sm btn-outline-light deleteBtn" data-id="${data.id}">Hapus</button>
              </div>
            `;
          }
        }
      ],
      language: {
        search: 'Cari:',
        lengthMenu: 'Tampilkan _MENU_ data',
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
        zeroRecords: 'Data tidak ditemukan',
        infoEmpty: 'Tidak ada data',
        infoFiltered: '(difilter dari _MAX_ total data)',
        paginate: {
          first: 'Awal',
          last: 'Akhir',
          next: '›',
          previous: '‹'
        }
      },
      pageLength: 5,
      autoWidth: false,
      responsive: true,
      drawCallback: function () {
        updateStats();
      }
    });

    updateStats();

    $('#refreshTable').on('click', function () {
      table.ajax.reload(function () {
        updateStats();
        showToast('Tabel berhasil diperbarui.');
      }, false);
    });

    $('#digidawTable').on('click', '.deleteBtn', function () {
      const id = $(this).data('id');

      if (confirm('Yakin ingin menghapus data ini?')) {
        $.ajax({
          url: `/api/items/${id}`,
          method: 'DELETE',
          success: function () {
            table.ajax.reload(function () {
              updateStats();
              showToast('Data berhasil dihapus.');
            }, false);
          },
          error: function () {
            showToast('Gagal menghapus data.');
          }
        });
      }
    });

    $('#digidawTable').on('click', '.editBtn', function () {
      const id = $(this).data('id');
      window.location.href = `/form?id=${id}`;
    });
  }

  if ($('#digidawForm').length) {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    if (id) {
      $.get(`/api/items/${id}`, function (data) {
        $('#itemId').val(data.id);
        $('#nama').val(data.nama);
        $('#kategori').val(data.kategori);
        $('#harga').val(data.harga);
        $('#status').val(data.status);
        $('#deskripsi').val(data.deskripsi);
        $('#formTitle').text('Edit Data DigiDaw');
        $('#submitBtn').text('Update Data');
      }).fail(function () {
        showToast('Data edit tidak ditemukan.');
      });
    }

    $('#digidawForm').on('submit', function (e) {
      e.preventDefault();

      const itemId = $('#itemId').val();
      const payload = {
        nama: $('#nama').val().trim(),
        kategori: $('#kategori').val(),
        harga: $('#harga').val(),
        status: $('#status').val(),
        deskripsi: $('#deskripsi').val().trim()
      };

      if (!payload.nama || !payload.kategori || !payload.harga || !payload.status) {
        showToast('Mohon lengkapi semua field wajib.');
        return;
      }

      $('#submitBtn').prop('disabled', true).text(itemId ? 'Mengupdate...' : 'Menyimpan...');

      const ajaxConfig = itemId
        ? {
            url: `/api/items/${itemId}`,
            method: 'PUT'
          }
        : {
            url: '/api/items',
            method: 'POST'
          };

      $.ajax({
        url: ajaxConfig.url,
        method: ajaxConfig.method,
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function () {
          showToast(itemId ? 'Data berhasil diupdate.' : 'Data berhasil ditambahkan.');
          setTimeout(() => {
            window.location.href = '/data';
          }, 700);
        },
        error: function () {
          $('#submitBtn').prop('disabled', false).text(itemId ? 'Update Data' : 'Simpan Data');
          showToast('Terjadi kesalahan saat menyimpan data.');
        }
      });
    });

    $('#resetBtn').on('click', function () {
      if (!$('#itemId').val()) {
        $('#submitBtn').text('Simpan Data').prop('disabled', false);
      }
    });
  }
});