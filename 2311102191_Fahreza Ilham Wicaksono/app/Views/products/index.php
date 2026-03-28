<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Hero -->
<div class="row justify-content-center my-5">
    <div class="col-md-10" data-aos="fade-down">
        <div class="rounded-4 overflow-hidden position-relative" style="min-height:400px; background-image:url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGdhbWluZ3xlbnwwfHwwfHx8MA%3D%3D'); background-size:cover; background-position:center;">

            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75"></div>

            <div class="position-relative p-5 d-flex flex-column justify-content-center" style="min-height:400px;">
                <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-50 rounded-pill px-3 py-2 mb-3 fs-6 fw-semibold align-self-start">
                    <i class="ph-fill ph-storefront me-1"></i> Official Gaming Store
                </span>

                <h1 class="display-4 fw-bold text-white mb-3">
                    Welcome to<br>
                    <span class="text-primary">CihuyStore</span>
                </h1>

                <p class="text-white-50 fs-6 mb-0" style="max-width:500px; line-height:1.8;">
                    Temukan koleksi periferal gaming terbaik — mouse presisi tinggi, keyboard mekanikal,
                    monitor responsif, headphone imersif, hingga IEM premium. Harga terbaik, kualitas terjamin.
                    Cihuy~
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Product Table -->
<div class="row justify-content-center mb-5">
    <div class="col-md-10" data-aos="fade-up" data-aos-delay="150">
        <div class="bg-black border border-primary border-opacity-50 rounded-4 p-4 p-md-5">

            <p class="text-primary text-uppercase fw-bold small mb-0">Overview</p>
            <h2 class="fw-bold text-white mb-1">Product List</h2>
            <hr class="border border-primary border-2 opacity-75 mt-2 mb-2 w-25">

            <a href="/create" class="btn btn-primary fw-bold px-5 mb-4"><i class="ph-fill ph-plus-square me-1"></i> Add Product</a>

            <table id="productTable" class="table table-dark table-striped table-hover align-middle w-100">
                <thead class="border-bottom border-primary border-opacity-50">
                    <tr>
                        <th class="text-white text-uppercase small fw-bold">#</th>
                        <th class="text-white text-uppercase small fw-bold">Product Name</th>
                        <th class="text-white text-uppercase small fw-bold">Category</th>
                        <th class="text-white text-uppercase small fw-bold">Price</th>
                        <th class="text-white text-uppercase small fw-bold">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<?php if (session()->getFlashdata('message')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?= session()->getFlashdata('message'); ?>',
            position: 'top',
            showConfirmButton: false,
            background: '#181818ff',
            color: '#fff',
            timer: 2000
        });
    </script>
<?php endif; ?>

<script>
    $(document).ready(function() {
        let table = $("#productTable").DataTable({
            paging: true,
            searching: true,
            stateSave: true,
            ordering: false,
            columnDefs: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    className: "fw-bold"
                },
                {
                    targets: 2,
                    className: "align-middle text-center"
                },
                {
                    targets: 3,
                    className: "fw-bold text-end"
                },
                {
                    targets: 4,
                    className: "align-middle text-center"
                }
            ]
        });

        (function($) {
            $.categoryBadge = function(category) {
                let badges = {
                    mouse: "primary",
                    keyboard: "danger",
                    monitor: "warning",
                    headphone: "success",
                    iem: "info"
                };

                let icons = {
                    mouse: "ph-mouse",
                    keyboard: "ph-keyboard",
                    monitor: "ph-monitor",
                    headphone: "ph-headphones",
                    iem: "ph-music-note"
                };

                return `
                    <span class="badge bg-${badges[category]} fw-bold p-2">
                        <i class="ph-fill ${icons[category]} me-2"></i>
                        ${category.toUpperCase()}
                    </span>`;
            };
        })(jQuery);

        $.ajax({
            url: '/products/get_json',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    data.forEach(function(product) {
                        table.row.add([
                            null,
                            product.product_name,
                            $.categoryBadge(product.category),
                            "Rp. " + product.price,
                            `
                                <a href="/edit/${product.id}" class="btn btn-warning btn-sm"><i class="ph-fill ph-pencil-simple"></i></a>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="${product.id}"><i class="ph-fill ph-trash"></i></button>
                            `
                        ]);
                    });
                }

                table.draw(false);
            }
        });

        $("#productTable tbody").on('click', '.deleteBtn', function() {
            let button = $(this);
            let row = table.row(button.parents('tr'));
            let id = button.data('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Delete this product?",
                icon: "warning",
                position: 'top',
                showCancelButton: true,
                background: '#181818ff',
                color: '#fff',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/delete/' + id,
                        type: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                position: 'top',
                                showConfirmButton: false,
                                background: '#181818ff',
                                color: '#fff',
                                timer: 2000
                            });

                            row.remove().draw(false);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'success',
                                title: '<?= session()->getFlashdata('message'); ?>',
                                position: 'top',
                                background: '#181818ff',
                                color: '#fff',
                                timer: 2000
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>