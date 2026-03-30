/**
 * app.js - Shared jQuery Utilities & CRUD Functions
 * Manajemen Data Mahasiswa
 */

const API_BASE = '/api/mahasiswa';

// ─── Toast Notification Plugin (jQuery) ──────────────────────────────────────
$.fn.showToast = function () {};

function showToast(type, title, message, duration = 4000) {
  const icons = {
    success: '✅',
    danger:  '❌',
    warning: '⚠️',
    info:    'ℹ️'
  };

  const $container = $('#toastContainer');
  const id = 'toast_' + Date.now();

  const $toast = $(`
    <div class="toast-custom toast-${type}" id="${id}" role="alert">
      <span class="toast-icon">${icons[type] || '📌'}</span>
      <div class="toast-content">
        <div class="toast-title">${title}</div>
        <div class="toast-message">${message}</div>
      </div>
      <button class="toast-close" title="Tutup">×</button>
    </div>
  `);

  $container.append($toast);

  $toast.find('.toast-close').on('click', function () {
    dismissToast($toast);
  });

  setTimeout(() => dismissToast($toast), duration);
}

function dismissToast($toast) {
  $toast.css({ opacity: 0, transform: 'translateX(30px)', transition: 'all 0.3s ease' });
  setTimeout(() => $toast.remove(), 300);
}

// ─── Form Validation Plugin (jQuery) ─────────────────────────────────────────
$.fn.validateField = function () {
  const $field = $(this);
  const val = $field.val().trim();
  const isSelect = $field.is('select');

  let valid = val !== '';

  // Additional validators
  if ($field.data('type') === 'nim') {
    valid = /^\d{5,15}$/.test(val);
  }
  if ($field.data('type') === 'ipk') {
    const num = parseFloat(val);
    valid = !isNaN(num) && num >= 0 && num <= 4.00;
  }
  if ($field.data('type') === 'angkatan') {
    const year = parseInt(val);
    valid = year >= 2000 && year <= new Date().getFullYear();
  }

  if (!valid) {
    $field.addClass('is-invalid-custom');
    $field.siblings('.invalid-feedback-custom').css('display', 'block');
  } else {
    $field.removeClass('is-invalid-custom');
    $field.siblings('.invalid-feedback-custom').css('display', 'none');
  }

  return valid;
};

$.fn.validateForm = function () {
  let allValid = true;
  $(this).find('[data-required]').each(function () {
    if (!$(this).validateField()) allValid = false;
  });
  return allValid;
};

// ─── IPK Color Utility ────────────────────────────────────────────────────────
function getIPKClass(ipk) {
  if (ipk >= 3.5)  return 'ipk-excellent';
  if (ipk >= 3.0)  return 'ipk-good';
  if (ipk >= 2.5)  return 'ipk-average';
  return 'ipk-low';
}

// ─── Status Badge Utility ─────────────────────────────────────────────────────
function getStatusBadge(status) {
  const map = {
    'Aktif':        { cls: 'badge-aktif',    dot: '●' },
    'Cuti':         { cls: 'badge-cuti',     dot: '●' },
    'Tidak Aktif':  { cls: 'badge-nonaktif', dot: '●' }
  };
  const s = map[status] || { cls: 'badge-nonaktif', dot: '●' };
  return `<span class="badge-status ${s.cls}">${s.dot} ${status}</span>`;
}

// ─── API Helpers ──────────────────────────────────────────────────────────────
const API = {
  getAll() {
    return $.ajax({ url: API_BASE, method: 'GET', dataType: 'json' });
  },
  getById(id) {
    return $.ajax({ url: `${API_BASE}/${id}`, method: 'GET', dataType: 'json' });
  },
  create(data) {
    return $.ajax({
      url: API_BASE, method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(data),
      dataType: 'json'
    });
  },
  update(id, data) {
    return $.ajax({
      url: `${API_BASE}/${id}`, method: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify(data),
      dataType: 'json'
    });
  },
  delete(id) {
    return $.ajax({ url: `${API_BASE}/${id}`, method: 'DELETE', dataType: 'json' });
  }
};

// ─── On DOM Ready ─────────────────────────────────────────────────────────────
$(function () {
  // Mark active nav link based on current page
  const currentPage = window.location.pathname.split('/').pop() || 'table.html';
  $('.nav-item').each(function () {
    const href = $(this).attr('href');
    if (href && href.includes(currentPage)) {
      $(this).addClass('active');
    }
  });

  // Live validation on blur
  $('[data-required]').on('blur', function () {
    $(this).validateField();
  }).on('input change', function () {
    if ($(this).hasClass('is-invalid-custom')) {
      $(this).validateField();
    }
  });
});
