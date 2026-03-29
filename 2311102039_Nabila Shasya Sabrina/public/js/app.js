$(document).ready(function () {
  if ($('#table').length) {
    $('#table').DataTable({
  ajax: {
    url: '/api/cheesecake',
    dataSrc: ''
  },
  columns: [
    { data: 'name' },
    {
  data: 'price',
  render: function (data) {
    return 'Rp ' + parseInt(data).toLocaleString();
  }
},
    { data: 'stock' },
    {
      data: null,
      render: function (data) {
        return `
          <a href="/edit/${data.id}" class="btn btn-warning btn-sm">Edit</a>
          <button onclick="deleteData(${data.id})" class="btn btn-danger btn-sm">Delete</button>
        `;
      }
    }
  ]
});
  }
});

function saveData() {
  const name = $('#name').val();
  const price = $('#price').val();
  const stock = $('#stock').val();

  if (!name || !price || !stock) {
    alert('Isi semua field!');
    return;
  }
  $.post('/api/cheesecake', {
    name: name,
    price: price,
    stock: stock
  }, () => {
    alert('Data berhasil ditambahkan!'); // ✅ DI SINI
    window.location.href = '/data';
  });
}

function updateData() {
  const id = $('#id').val();
  $.ajax({
    url: '/api/cheesecake/' + id,
    method: 'PUT',
    contentType: 'application/json',
    data: JSON.stringify({
      name: $('#name').val(),
      price: $('#price').val(),
      stock: $('#stock').val()
    }),
    success: () => {
  alert('Data berhasil diupdate!');
  window.location.href = '/data';
}
  });
}

function deleteData(id) {
  $.ajax({
    url: '/api/cheesecake/' + id,
    method: 'DELETE',
    success: () => {
  alert('Data berhasil dihapus!');
  window.location.href = '/data';
}
  });
}