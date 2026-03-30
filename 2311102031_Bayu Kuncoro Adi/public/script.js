$(document).ready(function() {
    // 1. READ: Inisialisasi DataTables dengan format JSON dari API
    let table = $('#productTable').DataTable({
        ajax: {
            url: '/api/products',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nama' },
            { data: 'kategori' },
            { 
                data: 'harga',
                render: function(data) {
                    return 'Rp ' + data.toLocaleString('id-ID');
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm btn-edit" data-id="${row.id}" data-nama="${row.nama}" data-kategori="${row.kategori}" data-harga="${row.harga}">Edit</button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Hapus</button>
                    `;
                }
            }
        ]
    });

    // 2. CREATE & UPDATE: Submit Form
    $('#productForm').submit(function(e) {
        e.preventDefault();
        
        const id = $('#productId').val();
        const productData = {
            nama: $('#nama').val(),
            kategori: $('#kategori').val(),
            harga: $('#harga').val()
        };

        if (id) {
            // Proses Update (PUT)
            $.ajax({
                url: `/api/products/${id}`,
                type: 'PUT',
                data: productData,
                success: function(res) {
                    resetForm();
                    table.ajax.reload();
                }
            });
        } else {
            // Proses Create (POST)
            $.ajax({
                url: '/api/products',
                type: 'POST',
                data: productData,
                success: function(res) {
                    resetForm();
                    table.ajax.reload();
                }
            });
        }
    });

    // 3. Persiapan UPDATE: Klik tombol Edit
    $('#productTable').on('click', '.btn-edit', function() {
        $('#productId').val($(this).data('id'));
        $('#nama').val($(this).data('nama'));
        $('#kategori').val($(this).data('kategori'));
        $('#harga').val($(this).data('harga'));
        
        $('#formTitle').text('Edit Produk');
        $('#saveBtn').text('Simpan Perubahan').removeClass('btn-primary').addClass('btn-success');
        $('#cancelBtn').removeClass('d-none');
    });

    // Batal Edit
    $('#cancelBtn').click(function() {
        resetForm();
    });

    // 4. DELETE: Klik tombol Hapus
    $('#productTable').on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            $.ajax({
                url: `/api/products/${id}`,
                type: 'DELETE',
                success: function(res) {
                    table.ajax.reload();
                }
            });
        }
    });

    // Fungsi reset form
    function resetForm() {
        $('#productId').val('');
        $('#nama').val('');
        $('#kategori').val('');
        $('#harga').val('');
        $('#formTitle').text('Tambah Produk');
        $('#saveBtn').text('Tambah Produk').removeClass('btn-success').addClass('btn-primary');
        $('#cancelBtn').addClass('d-none');
    }
});