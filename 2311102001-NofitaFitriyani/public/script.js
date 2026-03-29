let tabelAntrian = null;
let modalEdit = null;

function tampilPesan(targetId, jenis, pesan) {
  $('#' + targetId).html(`
    <div class="alert alert-${jenis}" role="alert">
      ${pesan}
    </div>
  `);
}

function loadDataTable() {
  tabelAntrian = $('#tabelAntrian').DataTable({
    ajax: {
      url: '/api/antrian',
      dataSrc: ''
    },
    columns: [
      { data: 'id' },
      { data: 'antrian' },
      { data: 'nama' },
      { data: 'umur' },
      { data: 'keluhan' },
      {
        data: null,
        render: function (data) {
          return `
            <div class="table-actions">
              <button class="btn btn-warning btn-sm btn-edit" data-id="${data.id}">Edit</button>
              <button class="btn btn-danger btn-sm btn-delete" data-id="${data.id}">Hapus</button>
            </div>
          `;
        }
      }
    ]
  });
}

$(document).ready(function () {
  if ($('#formAntrian').length) {
    $('#formAntrian').on('submit', function (e) {
      e.preventDefault();

      const data = {
        nama: $('#nama').val(),
        umur: $('#umur').val(),
        keluhan: $('#keluhan').val()
      };

      $.ajax({
        url: '/api/antrian',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
          tampilPesan('pesanForm', 'success', response.message);
          $('#formAntrian')[0].reset();
        },
        error: function (xhr) {
          tampilPesan('pesanForm', 'danger', xhr.responseJSON.message);
        }
      });
    });
  }

  if ($('#tabelAntrian').length) {
    modalEdit = new bootstrap.Modal(document.getElementById('editModal'));
    loadDataTable();

    $('#tabelAntrian').on('click', '.btn-edit', function () {
      const id = $(this).data('id');

      $.get(`/api/antrian/${id}`, function (data) {
        $('#editId').val(data.id);
        $('#editNama').val(data.nama);
        $('#editUmur').val(data.umur);
        $('#editKeluhan').val(data.keluhan);
        modalEdit.show();
      });
    });

    $('#btnUpdate').on('click', function () {
      const id = $('#editId').val();

      const data = {
        nama: $('#editNama').val(),
        umur: $('#editUmur').val(),
        keluhan: $('#editKeluhan').val()
      };

      $.ajax({
        url: `/api/antrian/${id}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
          alert(response.message);
          modalEdit.hide();
          tabelAntrian.ajax.reload(null, false);
        },
        error: function (xhr) {
          alert(xhr.responseJSON.message);
        }
      });
    });

    $('#tabelAntrian').on('click', '.btn-delete', function () {
      const id = $(this).data('id');

      if (confirm('Yakin ingin menghapus data ini?')) {
        $.ajax({
          url: `/api/antrian/${id}`,
          method: 'DELETE',
          success: function (response) {
            alert(response.message);
            tabelAntrian.ajax.reload(null, false);
          },
          error: function (xhr) {
            alert(xhr.responseJSON.message);
          }
        });
      }
    });
  }
});