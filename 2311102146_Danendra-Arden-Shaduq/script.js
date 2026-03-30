"use strict";

const ProductStore = {
  _data: {},
  _nextId: 1,

  _genId() {
    return `PRD-${String(this._nextId++).padStart(4, "0")}`;
  },

  create(nama, kategori, harga) {
    const id = this._genId();
    const product = {
      id,
      nama: nama.trim(),
      kategori,
      harga: parseFloat(harga),
      createdAt: new Date(),
    };
    this._data[id] = product;
    return product;
  },

  getAll() {
    return Object.values(this._data);
  },

  getById(id) {
    return this._data[id] || null;
  },

  update(id, nama, kategori, harga) {
    if (!this._data[id]) return null;
    this._data[id] = {
      ...this._data[id],
      nama: nama.trim(),
      kategori,
      harga: parseFloat(harga),
      updatedAt: new Date(),
    };
    return this._data[id];
  },

  remove(id) {
    if (!this._data[id]) return false;
    delete this._data[id];
    return true;
  },

  count() { return Object.keys(this._data).length; },
};

let dtInstance = null;

$(document).ready(function () {
  updateNavDate();
  seedSampleData();
  initDataTable();
  renderTable();
  updateStats();
});

function seedSampleData() {
  const samples = [
    { nama: "iPhone 15 Pro Max",     kategori: "Electronics", harga: 21999000 },
    { nama: "Nike Air Max 270",      kategori: "Fashion",     harga: 1850000  },
    { nama: "Indomie Goreng Pack 40",kategori: "Food & Beverage", harga: 95000 },
    { nama: "Samsung Galaxy S24 Ultra", kategori: "Electronics", harga: 19999000 },
    { nama: "Kaos Polos Oversize",   kategori: "Fashion",     harga: 150000  },
  ];
  samples.forEach(s => ProductStore.create(s.nama, s.kategori, s.harga));
}

function initDataTable() {
  dtInstance = $("#productTable").DataTable({
    data: [],
    columns: [
      { title: "#",          data: "rowNum",   orderable: false, width: "40px" },
      { title: "Nama Produk",data: "nama"    },
      { title: "Kategori",   data: "kategori" },
      { title: "Harga",      data: "harga"   },
      { title: "Ditambah",   data: "date"    },
      { title: "Actions",    data: "actions", orderable: false, className: "text-center", width: "90px" },
    ],
    order: [],
    language: {
      emptyTable:     buildEmptyState(),
      zeroRecords:    buildEmptyState("Tidak ada hasil ditemukan"),
      info:           "Menampilkan _START_–_END_ dari _TOTAL_ produk",
      infoEmpty:      "Menampilkan 0 produk",
      infoFiltered:   "(difilter dari _MAX_ total)",
      search:         '<i class="bi bi-search me-1"></i>',
      searchPlaceholder: "Cari produk...",
      lengthMenu:     "Tampilkan _MENU_ baris",
      paginate: {
        previous: '<i class="bi bi-chevron-left"></i>',
        next:     '<i class="bi bi-chevron-right"></i>',
      },
    },
    dom:
      "<'row mb-3'<'col-sm-6 d-flex align-items-center'l><'col-sm-6 d-flex justify-content-end'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row mt-3'<'col-sm-5'i><'col-sm-7 d-flex justify-content-end'p>>",
    pageLength: 10,
    responsive: true,
    drawCallback: function () {
      updateTableCount();
    },
  });
}

function renderTable() {
  if (!dtInstance) return;

  const products = ProductStore.getAll();
  const rows = products.map((p, idx) => ({
    id:       p.id,
    rowNum:   `<span class="row-num">${idx + 1}</span>`,
    nama:     `<span class="prod-name">${escHtml(p.nama)}</span>`,
    kategori: buildCatBadge(p.kategori),
    harga:    `<span class="price-val">${formatRupiah(p.harga)}</span>`,
    date:     `<span class="date-val">${formatDate(p.createdAt)}</span>`,
    actions:  buildActions(p.id, p.nama),
  }));

  dtInstance.clear();
  dtInstance.rows.add(rows);
  dtInstance.draw();

  updateStats();
}

function buildCatBadge(cat) {
  const slug = cat.replace(/[\s&]/g, "").replace(/\//g, "");
  const map = {
    "Electronics": "Electronics",
    "Fashion":     "Fashion",
    "FoodBeverage":"Food",
    "HomeLiving":  "Home",
    "Sports":      "Sports",
    "Beauty":      "Beauty",
    "Automotive":  "Automotive",
    "Books":       "Books",
  };
  const cls = map[slug] || "Books";
  return `<span class="cat-badge cat-${cls}">${escHtml(cat)}</span>`;
}

function buildActions(id, nama) {
  return `
    <button class="btn-action btn-edit me-1" title="Edit" onclick="openEdit('${id}')">
      <i class="bi bi-pencil"></i>
    </button>
    <button class="btn-action btn-delete" title="Hapus" onclick="openDelete('${id}','${escHtml(nama)}')">
      <i class="bi bi-trash3"></i>
    </button>`;
}

function buildEmptyState(msg = "Belum ada produk. Tambahkan produk baru!") {
  return `<div class="empty-state">
    <i class="bi bi-inbox"></i>
    <p>${msg}</p>
  </div>`;
}

function submitProduct() {
  const nama     = $("#inputNama").val().trim();
  const kategori = $("#inputKategori").val();
  const harga    = $("#inputHarga").val();

  if (!validateForm(nama, kategori, harga)) return;

  ProductStore.create(nama, kategori, harga);
  resetForm();
  renderTable();
  showToast(`<i class="bi bi-check-circle-fill me-2"></i>Produk <strong>${escHtml(nama)}</strong> berhasil ditambahkan!`, "success");
}

function validateForm(nama, kategori, harga, prefix = "") {
  const alertEl = prefix ? $("#editAlert") : $("#formAlert");

  if (!nama) {
    showAlert(alertEl, "Nama produk tidak boleh kosong.");
    return false;
  }
  if (nama.length < 2) {
    showAlert(alertEl, "Nama produk minimal 2 karakter.");
    return false;
  }
  if (!kategori) {
    showAlert(alertEl, "Pilih kategori terlebih dahulu.");
    return false;
  }
  if (!harga || isNaN(harga) || parseFloat(harga) < 0) {
    showAlert(alertEl, "Harga harus berupa angka yang valid.");
    return false;
  }

  alertEl.hide();
  return true;
}

function showAlert(el, msg) {
  el.html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${msg}`).show();
  setTimeout(() => el.fadeOut(), 3500);
}

function openEdit(id) {
  const product = ProductStore.getById(id);
  if (!product) return;

  $("#editId").val(id);
  $("#editNama").val(product.nama);
  $("#editKategori").val(product.kategori);
  $("#editHarga").val(product.harga);

  const modal = new bootstrap.Modal(document.getElementById("editModal"));
  modal.show();
}

function saveEdit() {
  const id       = $("#editId").val();
  const nama     = $("#editNama").val().trim();
  const kategori = $("#editKategori").val();
  const harga    = $("#editHarga").val();

  if (!validateForm(nama, kategori, harga, "edit")) return;

  ProductStore.update(id, nama, kategori, harga);

  bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
  renderTable();
  showToast(`<i class="bi bi-pencil-fill me-2"></i>Produk <strong>${escHtml(nama)}</strong> berhasil diperbarui!`, "info");
}

function cancelEdit() {
  resetForm();
}

function openDelete(id, nama) {
  $("#deleteId").val(id);
  $("#deleteProductName").text(`"${nama}" akan dihapus permanen.`);
  const modal = new bootstrap.Modal(document.getElementById("deleteModal"));
  modal.show();
}

function confirmDelete() {
  const id = $("#deleteId").val();
  const product = ProductStore.getById(id);
  const namaBackup = product ? product.nama : "Produk";

  ProductStore.remove(id);

  bootstrap.Modal.getInstance(document.getElementById("deleteModal")).hide();
  renderTable();
  showToast(`<i class="bi bi-trash3-fill me-2"></i><strong>${escHtml(namaBackup)}</strong> berhasil dihapus.`, "error");
}

function resetForm() {
  $("#inputNama").val("");
  $("#inputKategori").val("");
  $("#inputHarga").val("");
  $("#formAlert").hide();
  $("#btnCancelEdit").hide();
  $("#formTitle").text("New Product");
  $("#btnSubmit").html('<i class="bi bi-plus-lg me-1"></i> Tambah');
}

function updateStats() {
  const all = ProductStore.getAll();
  const total = all.length;
  const elec  = all.filter(p => p.kategori === "Electronics").length;
  const fash  = all.filter(p => p.kategori === "Fashion").length;
  const avg   = total > 0 ? all.reduce((s, p) => s + p.harga, 0) / total : 0;

  animateCount("#statTotal",   total);
  animateCount("#statElec",    elec);
  animateCount("#statFashion", fash);
  $("#statAvg").text(formatRupiah(Math.round(avg)));
}

function animateCount(selector, target) {
  const el = $(selector);
  const current = parseInt(el.text()) || 0;
  if (current === target) return;
  $({ val: current }).animate({ val: target }, {
    duration: 400,
    step(now) { el.text(Math.ceil(now)); },
    complete() { el.text(target); },
  });
}

function updateTableCount() {
  const info = dtInstance ? dtInstance.page.info() : null;
  if (info) {
    $("#tableCount").text(`Showing ${info.recordsDisplay} of ${info.recordsTotal} products`);
  }
}

function showToast(msg, type = "success") {
  const toast = $("#appToast");
  toast.removeClass("toast-success toast-error toast-info");
  toast.addClass(`toast-${type}`);
  $("#toastBody").html(msg);

  const bsToast = bootstrap.Toast.getOrCreateInstance(toast[0], { delay: 3000 });
  bsToast.show();
}

function formatRupiah(num) {
  return "Rp " + Number(num).toLocaleString("id-ID");
}

function formatDate(date) {
  if (!date) return "-";
  return new Intl.DateTimeFormat("id-ID", {
    day:   "2-digit",
    month: "short",
    year:  "numeric",
    hour:  "2-digit",
    minute:"2-digit",
  }).format(new Date(date));
}

function escHtml(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

function updateNavDate() {
  const now = new Date();
  const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
  $("#navDate").text(now.toLocaleDateString("id-ID", options));
}

$(document).on("keydown", "#inputNama, #inputKategori, #inputHarga", function (e) {
  if (e.key === "Enter") submitProduct();
});