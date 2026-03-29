// Qonita Rahayu Atmi - 2311102128

// Fungsi untuk sidebar ini otomatis berjalan saat web dibuka
(function() {
  // Untuk membuat menu kiri (Sidebar)
  var sidebarHTML = `
  <aside class="sidebar">
    
    <!-- Bagian Logo Utama -->
    <div class="sidebar-logo">
      <!-- Ikon logo (diubah jadi bunga/flower agar cocok dengan Skincare) -->
      <div class="logo-icon"><i class="bi bi-flower1"></i></div>
      <div>
        <div class="logo-title">GlowStock</div>
        <div class="logo-sub">Inventori Kosmetik</div>
      </div>
    </div>
    
    <!-- Bagian Navigasi Menu -->
    <nav class="sidebar-nav">
      <div class="nav-section-label">MENU UTAMA</div>
      
      <!-- Tombol Menu: Dashboard -->
      <!-- Ikon kotak-kotak (grid) -->
      <a href="/index.html" class="nav-item" id="nav-dashboard">
        <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
      </a>
      
      <!-- Tombol Menu: Data Produk -->
      <!-- Ikon kardus/arsip (archive) -->
      <a href="/produk.html" class="nav-item" id="nav-produk">
        <i class="bi bi-archive-fill"></i><span>Data Produk</span>
      </a>
      
      <!-- Tombol Menu: Tambah Produk Baru -->
      <!-- Ikon plus (plus-circle) -->
      <a href="/form.html" class="nav-item" id="nav-tambah">
        <i class="bi bi-plus-circle-fill"></i><span>Tambah Produk</span>
      </a>
      
    </nav>
    
    <!-- Teks copyright kecil di paling bawah sidebar -->
    <div class="sidebar-footer">Tugas 2 ABP &copy; 2026</div>
  </aside>`;

  document.getElementById('app').insertAdjacentHTML('afterbegin', sidebarHTML);
})();
