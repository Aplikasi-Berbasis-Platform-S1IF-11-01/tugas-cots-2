$(document).ready(function() {
    // Baris 3 sampai 6: Rumus bantu sederhana untuk mencetak angka nominal biasa menjadi format teks mata uang Rupiah (Rp)
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    };

    // Baris 8 sampai 158: Kode Inti yang menghubungi Mesin Server (Database) mengambil data Produk dan menggambar seluruh Halaman Utama
    $.ajax({
        url: '/api/products',
        type: 'GET',
        success: function(response) {
            const products = response.data;
            
            // Baris 15 sampai 39: Proses awal menghitung Total Keseluruhan Barang, Nilai Uang Stok, dan mendeteksi barang apa saja yang isinya kurang dari 10
            let totalProducts = products.length;
            let totalStock = 0;
            let totalValue = 0;
            let lowStockProducts = [];
            let categoryCount = {};
            
            products.forEach(p => {
                const stock = parseInt(p.stock);
                const price = parseFloat(p.price);
                
                totalStock += stock;
                totalValue += (stock * price);
                
                if (stock < 10) {
                    lowStockProducts.push(p);
                }
                
                // Count Category for Chart
                if (categoryCount[p.category]) {
                    categoryCount[p.category]++;
                } else {
                    categoryCount[p.category] = 1;
                }
            });

            // Baris 41 sampai 54: Menyetak / menembakkan hasil perhitungan di atas ke Empat Kotak Laporan Indikator dengan sentuhan animasi angka berjalan
            $({ Counter: 0 }).animate({ Counter: totalProducts }, {
                duration: 1000, easing: 'swing', step: function() { $('#stat-total-products').text(Math.ceil(this.Counter)); }
            });
            $({ Counter: 0 }).animate({ Counter: totalStock }, {
                duration: 1000, easing: 'swing', step: function() { $('#stat-total-stock').text(Math.ceil(this.Counter)); }
            });
            
            $('#stat-total-value').text(formatRupiah(totalValue));
            
            $({ Counter: 0 }).animate({ Counter: lowStockProducts.length }, {
                duration: 1000, easing: 'swing', step: function() { $('#stat-low-stock').text(Math.ceil(this.Counter)); }
            });
            $('#badge-alert-count').text(lowStockProducts.length);

            // Baris 56 sampai 84: Fungsi yang mencetak / menulis daftar kolom sebelah kanan tentang rincian produk mana saja yang stoknya hampir habis
            const $listContainer = $('#lowStockList');
            $listContainer.empty();
            
            if (lowStockProducts.length === 0) {
                $listContainer.html(`
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center text-success" style="opacity: 0.8;">
                        <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                        <span class="fw-medium">Semua stok produk berada<br>dalam batas aman.</span>
                    </div>
                `);
            } else {
                // Urutkan dari stok paling sedikit
                lowStockProducts.sort((a,b) => parseInt(a.stock) - parseInt(b.stock));
                
                lowStockProducts.forEach(p => {
                    $listContainer.append(`
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom" style="border-color: #e2e8f0 !important;">
                            <div class="pe-3">
                                <h6 class="text-dark mb-1 text-truncate" style="max-width: 150px;" title="${p.name}">${p.name}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.8rem;">${p.sku}</p>
                            </div>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1 rounded-3 d-flex align-items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> Sisa ${p.stock}
                            </span>
                        </div>
                    `);
                });
            }

            // Baris 86 sampai 148: Fungsi yang memicu pembuatan gambar interaktif Grafik Batang (Chart) untuk kategori jenis barang
            const ctx = document.getElementById('categoryChart').getContext('2d');
            
            // Skema Warna Gradient Canvas
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.8)');
            gradient.addColorStop(1, 'rgba(56, 189, 248, 0.8)');
            
            Chart.defaults.color = '#64748b';
            Chart.defaults.font.family = "'Inter', sans-serif";
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(categoryCount),
                    datasets: [{
                        label: 'Jumlah Item Produk',
                        data: Object.values(categoryCount),
                        backgroundColor: gradient,
                        hoverBackgroundColor: '#818cf8',
                        borderRadius: 8,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#ffffff',
                            titleColor: '#0f172a',
                            bodyColor: '#475569',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: { 
                                stepSize: 1,
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        },
        error: function(xhr) {
            $('#lowStockList').html(`
                <div class="text-center text-danger py-5">
                    <i class="bi bi-x-circle-fill fs-1 d-block mb-2"></i>
                    Gagal menyinkronkan data API.
                </div>
            `);
        }
    });
});
