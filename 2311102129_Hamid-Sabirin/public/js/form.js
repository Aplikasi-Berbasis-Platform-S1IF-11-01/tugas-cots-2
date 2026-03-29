$(document).ready(function() {
    // Baris 3 sampai 5: Skrip mendeteksi apakah di bagian link internet atas terdapat nomor seri barang atau tidak
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    const isEditMode = id !== null;

    if (isEditMode) {
        // Baris 9 sampai 12: Jika ternyata mode Update (ada serinya), maka tulisan Tombol dikondisikan ganti wujud
        $('#formTitle').text('Edit Data Produk');
        $('#navFormLink').text('Edit Item');
        $('#btnSubmit').html('<i class="bi bi-pencil-square"></i> Perbarui Data');
        $('#productId').val(id);

        // Baris 15 sampai 35: Sistem mengambil / mendownload rincian info barang dari belakang layar lalu diisikan ulang ke kotak-kotak kosong
        $.ajax({
            url: `/api/products/${id}`,
            type: 'GET',
            success: function(product) {
                $('#sku').val(product.sku).attr('readonly', true); // SKU tidak boleh diubah
                $('#name').val(product.name);
                $('#category').val(product.category);
                $('#price').val(product.price);
                $('#stock').val(product.stock);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Fatal Error',
                    text: 'Data produk tidak ditemukan di server.',
                    confirmButtonColor: '#4f46e5'
                }).then(() => {
                    window.location.href = 'data.html';
                });
            }
        });
    }

    // Baris 39 sampai 97: Skenario bila Tombol final Biru di Klik (Mengemas semua isian formulir baru ke dalam bentuk paket untuk dititipkan di server)
    $('#productForm').on('submit', function(e) {
        e.preventDefault(); 
        
        // Animasi tombol loading
        const $btn = $('#btnSubmit');
        const origText = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...');

        const idVal = $('#productId').val();
        
        // Format uppercase for SKU manually as fallback
        const inSku = $('#sku').val().toUpperCase();
        
        const productData = {
            sku: inSku,
            name: $('#name').val(),
            category: $('#category').val(),
            price: $('#price').val(),
            stock: $('#stock').val()
        };

        const apiUrl = idVal ? `/api/products/${idVal}` : `/api/products`;
        const apiType = idVal ? 'PUT' : 'POST';

        // AJAX Request Node API
        $.ajax({
            url: apiUrl,
            type: apiType,
            contentType: 'application/json',
            data: JSON.stringify(productData),
            success: function(response) {
                // Tampilkan toast modern menggunakan bootstrap 5
                const msg = idVal ? `Pembaruan berhasil: ${productData.name} telah diupdate.` : `Stok Baru: ${productData.name} telah ditambahkan ke database.`;
                
                $('#toastMessage').text(msg);
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast'));
                toastBootstrap.show();

                // Redirect ke data setelah delay pendek transisi natural
                setTimeout(() => {
                    window.location.href = 'data.html';
                }, 1200);
            },
            error: function(xhr) {
                let errMsg = "Transaction Failed: Server Error";
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errMsg = xhr.responseJSON.error;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errMsg,
                    confirmButtonColor: '#4f46e5'
                });
                $btn.prop('disabled', false).html(origText);
            }
        });
    });
});
