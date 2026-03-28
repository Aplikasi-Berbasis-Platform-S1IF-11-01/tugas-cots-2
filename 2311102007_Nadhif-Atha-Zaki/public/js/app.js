$(document).ready(function () {
  // Jalankan DataTables jika tabel ditemukan
  if ($("#tabelMahasiswa").length) {
    $("#tabelMahasiswa").DataTable({
      ajax: "/api/mahasiswa",
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          }
        },
        { data: "nim" },
        { data: "nama" },
        { data: "jurusan" },
        { data: "angkatan" },
        { data: "email" },
        {
          data: "id",
          render: function (data) {
            return `
              <a href="/mahasiswa/edit/${data}" class="btn btn-warning btn-sm me-1">Edit</a>
              <form action="/mahasiswa/${data}?_method=DELETE" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?')">
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            `;
          }
        }
      ]
    });
  }

  // Validasi sederhana form tambah
  $("#formMahasiswa").on("submit", function () {
    const nim = $("input[name='nim']").val().trim();
    const nama = $("input[name='nama']").val().trim();

    if (nim === "" || nama === "") {
      alert("NIM dan Nama wajib diisi");
      return false;
    }
  });

  // Validasi sederhana form edit
  $("#formEditMahasiswa").on("submit", function () {
    const nim = $("input[name='nim']").val().trim();
    const nama = $("input[name='nama']").val().trim();

    if (nim === "" || nama === "") {
      alert("NIM dan Nama wajib diisi");
      return false;
    }
  });
});