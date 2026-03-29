/* ══════════════════════════════════════════════
   SIAKAD — main.js
   jQuery + DataTables + CRUD Logic
   ══════════════════════════════════════════════ */

$(function () {

  // ── Current Date ──────────────────────────────
  const now = new Date();
  $('#currentDate').text(now.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }));

  // ── Sidebar Toggle ────────────────────────────
  $('#sidebarToggle').on('click', function () {
    $('#sidebar').toggleClass('open');
  });
  $(document).on('click', function (e) {
    if (!$(e.target).closest('#sidebar, #sidebarToggle').length) {
      $('#sidebar').removeClass('open');
    }
  });

  // ── DataTables Init (only on index page) ─────
  if ($('#tableMahasiswa').length) {
    initDataTable();
  }

  // ── Refresh button ────────────────────────────
  $('#btnRefresh').on('click', function () {
    if ($.fn.DataTable.isDataTable('#tableMahasiswa')) {
      const table = $('#tableMahasiswa').DataTable();
      table.ajax.reload(null, false);
      showToast('Data berhasil diperbarui!', 'success');
    }
  });

});

/* ══ DataTable Initialization ══════════════════ */
function initDataTable() {
  $('#loadingState').show();
  $('#tableWrapper').hide();

  const table = $('#tableMahasiswa').DataTable({
    ajax: {
      url: '/api/mahasiswa',
      dataSrc: 'data',
      error: function () {
        $('#loadingState').html('<div class="text-danger"><i class="bi bi-x-circle-fill me-2"></i>Gagal memuat data dari API.</div>');
      }
    },
    columns: [
      {
        data: null,
        className: 'text-center',
        render: (data, type, row, meta) => meta.row + 1
      },
      {
        data: 'nim',
        render: nim => `<span class="nim-badge">${nim}</span>`
      },
      {
        data: 'nama',
        render: (nama, type, row) =>
          `<div class="d-flex align-items-center gap-2">
            <div class="avatar-table">${getInitials(nama)}</div>
            <div>
              <div class="fw-600">${nama}</div>
              <div class="text-xs text-muted">${row.email}</div>
            </div>
          </div>`
      },
      { data: 'jurusan' },
      {
        data: 'semester',
        className: 'text-center',
        render: s => `<span class="fw-600">Sem ${s}</span>`
      },
      {
        data: 'ipk',
        className: 'text-center',
        render: ipk => {
          const v = parseFloat(ipk);
          let cls = 'ipk-danger';
          if (v >= 3.5) cls = 'ipk-success';
          else if (v >= 3.0) cls = 'ipk-primary';
          else if (v >= 2.0) cls = 'ipk-warning';
          return `<span class="ipk-pill ${cls}">${v.toFixed(2)}</span>`;
        }
      },
      {
        data: 'status',
        className: 'text-center',
        render: s => {
          const cls = s.toLowerCase().replace(' ', '');
          return `<span class="badge-status status-${cls}">
            <span class="status-dot status-${cls}"></span>${s}
          </span>`;
        }
      },
      {
        data: 'id',
        className: 'text-center',
        orderable: false,
        render: (id, type, row) =>
          `<div class="action-btns">
            <button class="btn-action btn-action-view" title="Detail" onclick="viewDetail('${id}')">
              <i class="bi bi-eye-fill"></i>
            </button>
            <button class="btn-action btn-action-edit" title="Edit" onclick="editMahasiswa('${id}')">
              <i class="bi bi-pencil-fill"></i>
            </button>
            <button class="btn-action btn-action-delete" title="Hapus" onclick="confirmDelete('${id}', '${row.nama}')">
              <i class="bi bi-trash3-fill"></i>
            </button>
          </div>`
      }
    ],
    order: [[0, 'asc']],
    pageLength: 10,
    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'Semua']],
    language: {
      search: '',
      searchPlaceholder: '🔍  Cari mahasiswa...',
      lengthMenu: 'Tampilkan _MENU_ data',
      info: 'Menampilkan _START_–_END_ dari _TOTAL_ mahasiswa',
      infoEmpty: 'Tidak ada data',
      infoFiltered: '(disaring dari _MAX_ total data)',
      zeroRecords: '<div class="text-center py-4 text-muted"><i class="bi bi-search fs-2 d-block mb-2"></i>Tidak ada data ditemukan</div>',
      paginate: { first: '«', last: '»', previous: '‹', next: '›' }
    },
    initComplete: function () {
      $('#loadingState').hide();
      $('#tableWrapper').fadeIn(300);

      // Inject avatar CSS
      $('<style>')
        .text(`.avatar-table{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#4361ee,#7c3aed);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}`)
        .appendTo('head');
    },
    drawCallback: function () {
      // Re-attach tooltips if needed
    }
  });

  // Expose table globally for refresh
  window._dataTable = table;
}

/* ══ CRUD Action Functions ══════════════════════ */

function viewDetail(id) {
  window.location.href = `/detail/${id}`;
}

function editMahasiswa(id) {
  window.location.href = `/edit/${id}`;
}

let _deleteId = null;

function confirmDelete(id, nama) {
  _deleteId = id;
  Swal.fire({
    title: 'Hapus Data Mahasiswa?',
    html: `Data <strong>${nama}</strong> akan dihapus secara permanen dan tidak dapat dikembalikan.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef476f',
    cancelButtonColor: '#64748b',
    confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i> Ya, Hapus!',
    cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
    customClass: { popup: 'rounded-4', confirmButton: 'fw-600', cancelButton: 'fw-600' }
  }).then(result => {
    if (result.isConfirmed) {
      doDelete(id, nama);
    }
  });
}

function doDelete(id, nama) {
  $.ajax({
    url: `/api/mahasiswa/${id}`,
    method: 'DELETE',
    success: function (res) {
      Swal.fire({
        title: 'Berhasil Dihapus!',
        text: res.message,
        icon: 'success',
        timer: 2000,
        showConfirmButton: false,
        customClass: { popup: 'rounded-4' }
      });
      // Reload DataTable without full page reload
      if (window._dataTable) {
        window._dataTable.ajax.reload(null, false);
      }
      updateStatCards();
    },
    error: function (xhr) {
      Swal.fire('Gagal!', xhr.responseJSON?.message || 'Terjadi kesalahan server.', 'error');
    }
  });
}

/* ── Update stat cards after delete ── */
function updateStatCards() {
  $.getJSON('/api/mahasiswa', function (res) {
    const data = res.data;
    const total = data.length;
    const aktif = data.filter(m => m.status === 'Aktif').length;
    const cuti  = data.filter(m => m.status === 'Cuti').length;
    const avg   = total ? (data.reduce((s, m) => s + m.ipk, 0) / total).toFixed(2) : '0.00';

    // Animate counter update
    animateCounter($('.stat-primary .stat-value'), total);
    animateCounter($('.stat-success .stat-value'), aktif);
    animateCounter($('.stat-warning .stat-value'), cuti);
    $('.stat-info .stat-value').text(avg);
  });
}

function animateCounter($el, target) {
  const start = parseInt($el.text()) || 0;
  $({ val: start }).animate({ val: target }, {
    duration: 400,
    step: function () { $el.text(Math.ceil(this.val)); },
    complete: function () { $el.text(target); }
  });
}

/* ══ Global Utilities ═══════════════════════════ */

function getInitials(name) {
  return name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
}

function showToast(msg, type = 'success') {
  const colors = {
    success: '#2ec4b6',
    danger:  '#ef476f',
    info:    '#4361ee',
    warning: '#f7a325'
  };
  const toast = $('#appToast');
  toast.css('background-color', colors[type] || colors.success);
  toast.find('.btn-close').removeClass('btn-close-white');
  $('#toastMsg').css('color', '#fff').text(msg);
  toast.find('.btn-close').addClass('btn-close-white');

  const bsToast = new bootstrap.Toast(toast[0], { delay: 3000 });
  bsToast.show();
}
