$(document).ready(function() {
    // 1. Inisialisasi DataTables
    const table = $('#productTable').DataTable({
        ajax: '/api/products',
        columns: [
            { data: 'name' },
            { data: 'category' },
            { 
                data: 'price',
                render: function(data) {
                    return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                }
            },
            
            /**
                * Nama  : Aisyah Anis Mazaya
                * NIM   : 2311102095
                * Kelas : IF-11-REG01
                */

            { data: 'jumlah' }, 
            {
                data: 'id',
                orderable: false,
                className: 'text-center', 
                render: function(data) {
                    return `
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="/form?id=${data}" class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="${data}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });

    // 2. Logika Submit Form
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        
        const productId = $('#productId').val();
        const isEdit = productId !== '';

        const formData = {
            name: $('input[name="name"]').val(),
            category: $('select[name="category"]').val(),
            price: $('input[name="price"]').val(),
            jumlah: $('input[name="jumlah"]').val() 
        };

        const ajaxUrl = isEdit ? `/api/products/${productId}` : '/api/products';
        const ajaxMethod = isEdit ? 'PUT' : 'POST';

        $.ajax({
            url: ajaxUrl,
            type: ajaxMethod,
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function(response) {
                alert(response.message);
                window.location.href = '/';
            },
            error: function(err) {
                alert('Gagal menyimpan data: ' + err.responseJSON.message);
            }
        });
    });

    // 3. Logika Hapus Data
    $('#productTable').on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: `/api/products/${id}`,
                type: 'DELETE',
                success: function() {
                    table.ajax.reload();
                }
            });
        }
    });
});