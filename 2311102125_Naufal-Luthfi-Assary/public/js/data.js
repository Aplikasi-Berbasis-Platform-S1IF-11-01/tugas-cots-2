$(document).ready(function () {
  const table = $("#productTable").DataTable({
    ajax: {
      url: "/api/products",
      dataSrc: "data"
    },
    columns: [
      { data: "id" },
      { data: "namaProduk" },
      { data: "kategori" },
      {
        data: "harga",
        render: function (data) {
          return "Rp " + Number(data).toLocaleString("id-ID");
        }
      },
      {
        data: null,
        render: function (data) {
          return `
            <button class="btn btn-sm btn-warning btn-edit" data-id="${data.id}">Edit</button>
            <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id}">Hapus</button>
          `;
        }
      }
    ]
  });

  $(document).on("click", ".btn-edit", async function () {
    const id = $(this).data("id");
    const response = await fetch(`/api/products/${id}`);
    const product = await response.json();

    $("#editId").val(product.id);
    $("#editNamaProduk").val(product.namaProduk);
    $("#editKategori").val(product.kategori);
    $("#editHarga").val(product.harga);

    const modal = new bootstrap.Modal(document.getElementById("editModal"));
    modal.show();
  });

  $("#editForm").on("submit", async function (e) {
    e.preventDefault();

    const id = $("#editId").val();
    const payload = {
      namaProduk: $("#editNamaProduk").val().trim(),
      kategori: $("#editKategori").val().trim(),
      harga: $("#editHarga").val().trim()
    };

    const response = await fetch(`/api/products/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(payload)
    });

    if (response.ok) {
      bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
      table.ajax.reload();
    }
  });

  $(document).on("click", ".btn-delete", async function () {
    const id = $(this).data("id");

    if (!confirm("Yakin ingin menghapus data ini?")) return;

    const response = await fetch(`/api/products/${id}`, {
      method: "DELETE"
    });

    if (response.ok) {
      table.ajax.reload();
    }
  });
});