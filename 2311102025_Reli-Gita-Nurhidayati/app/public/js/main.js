// ============================================================
// Tugas 2 Praktikum - Aplikasi CRUD Mahasiswa
// NIM  : 2311102025
// Nama : Reli Gita Nurhidayati
// ============================================================
$(function () {
    var idHapus = null;
    var modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));

    var table = $('#tabelMahasiswa').DataTable({
        ajax: { url: '/api/mahasiswa', dataSrc: 'data' },
        columns: [
            { data: null, render: (d, t, r, meta) => meta.row + 1 },
            { data: 'nim' },
            { data: 'nama' },
            { data: 'jurusan' },
            { data: 'angkatan' },
            { data: 'ipk', render: d => parseFloat(d).toFixed(2) },
            {
                data: null,
                render: d =>
                    `<a href="/edit/${d.id}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></a>` +
                    `<button class="btn btn-danger btn-sm btn-hapus" data-id="${d.id}" data-nama="${d.nama}"><i class="fas fa-trash"></i></button>`
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        responsive: true
    });

    $('#tabelMahasiswa').on('click', '.btn-hapus', function () {
        idHapus = $(this).data('id');
        $('#namaHapus').text($(this).data('nama'));
        modalHapus.show();
    });

    $('#btnKonfirmasiHapus').on('click', function () {
        if (!idHapus) return;
        $.post('/hapus/' + idHapus, function (res) {
            if (res.success) {
                modalHapus.hide();
                table.ajax.reload();
                $('#alertBox').removeClass('d-none alert-danger').addClass('alert-success').text('Data berhasil dihapus!');
                setTimeout(() => $('#alertBox').addClass('d-none'), 3000);
                idHapus = null;
            }
        });
    });
});