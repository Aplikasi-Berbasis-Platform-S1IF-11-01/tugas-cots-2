$(document).ready(function() {
    // Baris 3 sampai 5: Rumus hitungan kecil yang otomatis memperbaiki tampilan angka harga menjadi teks Rupiah (Rp)
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    // Baris 8 sampai 45: Kode Pintar Pembangun Tabel Daftar Barang, secara mandiri menyedot rekapan dari server database
    const table = $('#productTable').DataTable({
        "ajax": {
            "url": "/api/products", // NEW API ENDPOINT
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": null, "render": function(data, type, row, meta) { return `<span class="fw-bold text-muted">${meta.row + 1}</span>`; }},
            { "data": "sku", "render": function(data) { return `<span class="badge bg-light text-dark border"><i class="bi bi-upc-scan me-1"></i>${data}</span>`; }},
            { "data": "name", "render": function(data) { return `<span class="fw-semibold">${data}</span>`; }},
            { "data": "category" },
            { "data": "price", "render": function(data) { return `<span class="price-badge">${formatRupiah(data)}</span>`; }},
            { "data": "stock", "render": function(data) { 
                return parseInt(data) < 10 ? 
                    `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>${data}</span>` : 
                    `<span class="stock-badge">${data} Unit</span>`; 
            }},
            { 
                "data": "id",
                "render": function(data) {
                    return `
                        <div class="action-btns d-flex">
                            <a class="btn btn-edit text-decoration-none" href="form.html?id=${data}" title="Edit"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-delete" onclick="deleteData(${data})" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    `;
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json",
            search: "_INPUT_",
            searchPlaceholder: "Cari produk..."
        },
        "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        "pageLength": 10
    });
});

// Baris 48 sampai 85: Kumpulan Perintah untuk melenyapkan / menghapus data satu barang sacara spesifik saat tanda silang ditekan
function deleteData(id) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: "Tindakan ini permanen dan tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/products/${id}`,
                type: 'DELETE',
                success: function(res) {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data produk berhasil dihapus.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#productTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal menghapus data produk.',
                        icon: 'error',
                        confirmButtonColor: '#4f46e5'
                    });
                    console.error(error);
                }
            });
        }
    });
}
