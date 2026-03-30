$(document).ready(function () {
  $("#productForm").on("submit", async function (e) {
    e.preventDefault();

    const payload = {
      namaProduk: $("#namaProduk").val().trim(),
      kategori: $("#kategori").val().trim(),
      harga: $("#harga").val().trim()
    };

    const response = await fetch("/api/products", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(payload)
    });

    const result = await response.json();

    if (response.ok) {
      $("#formMessage").html(`<div class="alert alert-success">${result.message}</div>`);
      $("#productForm")[0].reset();
    } else {
      $("#formMessage").html(`<div class="alert alert-danger">${result.message}</div>`);
    }
  });
});