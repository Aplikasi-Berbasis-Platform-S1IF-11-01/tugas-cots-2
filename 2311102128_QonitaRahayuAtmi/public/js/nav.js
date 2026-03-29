// Qonita Rahayu Atmi - 2311102128

// Array nama hari dan bulan untuk format tanggal
var HARI = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
var BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

// 1. Fungsi Mengubah tampilan Watermark "Qonita Rahayu Atmi 2311102128"
function setDate() {
  $('.topbar-date i').attr('class', 'bi bi-flower1 me-2');
  $('#currentDate').text('Qonita Rahayu Atmi 2311102128');
}

// 2. Fungsi Membuat menu sidebar "Menyala" maka akan aktif dan akan berwarna pink
function setActiveNav(page) {
  $('.nav-item').removeClass('active');
  $('#nav-' + page).addClass('active');
}

// 3. Fungsi Memunculkan popup notifikasi berhasil dan gagal
function showToast(msg, type) {
  type = type || 'success';
  var icons = { success: 'bi-check-circle-fill', error: 'bi-x-circle-fill', warning: 'bi-exclamation-circle-fill' };
  
  var $t = $('<div class="toast-item ' + (type !== 'success' ? type : '') + '">' +
    '<i class="bi ' + icons[type] + '"></i><span>' + msg + '</span></div>');
  
  $('#toastWrap').append($t);
  
  setTimeout(function() {
    $t.css({ transition: 'opacity 0.3s', opacity: 0 });
    setTimeout(function() { $t.remove(); }, 300);
  }, 3200);
}

// 4. Fungsi Menambahkan titik ribuan pada harga
function rupiah(n) {
  return 'Rp ' + parseInt(n).toLocaleString('id-ID');
}

// 5. Fungsi Mencari menggunakan keyword
function getParam(key) {
  return new URLSearchParams(window.location.search).get(key);
}

// 6. Fungsi Pengecek status label stok berdasarkan jumlah stok
function stokInfo(stok) {
  var s = parseInt(stok);
  if (s === 0) return { cls: 'bg-danger', label: 'Habis', indCls: 'habis', lblCls: 'lbl-habis' };     // Bootstrap: merah
  if (s <= 15) return { cls: 'bg-warning text-dark', label: 'Menipis', indCls: 'menipis', lblCls: 'lbl-menipis' }; // Bootstrap: kuning
  return { cls: 'bg-success', label: 'Aman', indCls: 'aman', lblCls: 'lbl-aman' };                    // Bootstrap: hijau
}

// 7. Untuk Kumpulan Ikon Kategori
var KATEGORI_ICON = {
  Lipstik:'heart-fill', Serum:'droplet-fill', Foundation:'layers-fill',
  Bedak:'stars', Toner:'droplet-half', Sunscreen:'sun-fill',
  'Blush On':'palette-fill', Moisturizer:'flower1', Maskara:'eye',
  'Eye Shadow':'brush', Concealer:'circle-fill', Primer:'palette2',
  'Setting Spray':'cloud-drizzle-fill'
};

// Jalankan fungsi setDate() saat website terbuka
$(document).ready(function() {
  setDate();
});
