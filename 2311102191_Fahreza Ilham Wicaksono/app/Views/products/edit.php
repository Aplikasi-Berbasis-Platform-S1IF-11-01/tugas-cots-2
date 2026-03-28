<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Add Product Form -->
<div class="row justify-content-center mt-5">
    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-black border border-primary border-opacity-50 rounded-4 p-4 p-md-5">

            <p class="text-primary text-uppercase fw-bold small mb-0">Inventory</p>
            <h2 class="fw-bold text-white mb-1">Edit Product</h2>
            <hr class="border border-primary border-2 opacity-75 mt-2 mb-4 w-25">

            <form id="editProductForm" action="/update/<?= $product['id']; ?>" method="post">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label for="product_name" class="form-label text-white-50 text-uppercase fw-semibold small">Name</label>

                    <div class="input-group">
                        <span class="input-group-text bg-black border-secondary text-primary">
                            <i class="ph-duotone ph-package fs-5"></i>
                        </span>

                        <input type="text" class="form-control bg-black border-secondary text-white <?= ($validation->hasError('product_name')) ? 'is-invalid' : ''; ?>" id="product_name" name="product_name" placeholder="e.g. Logitech G Pro X" value="<?= (old('product_name')) ? old('product_name') : $product['product_name']; ?>" autofocus>
                    </div>

                    <div class="invalid-feedback">
                        <?= $validation->getError('product_name'); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label text-white-50 text-uppercase fw-semibold small">Category</label>

                    <select class="form-select bg-black border-secondary text-white" id="category" name="category">
                        <option value="mouse" <?= old('category', $product['category']) == 'mouse' ? 'selected' : '' ?>>Mouse</option>
                        <option value="keyboard" <?= old('category', $product['category']) == 'keyboard' ? 'selected' : '' ?>>Keyboard</option>
                        <option value="monitor" <?= old('category', $product['category']) == 'monitor' ? 'selected' : '' ?>>Monitor</option>
                        <option value="headphone" <?= old('category', $product['category']) == 'headphone' ? 'selected' : '' ?>>Headphone</option>
                        <option value="iem" <?= old('category', $product['category']) == 'iem' ? 'selected' : '' ?>>IEM</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label text-white-50 text-uppercase fw-semibold small">Price</label>

                    <div class="input-group">
                        <span class="input-group-text bg-black border-secondary text-primary">
                            <i class="ph-duotone ph-currency-circle-dollar fs-5"></i>
                        </span>

                        <input type="number" class="form-control bg-black border-secondary text-white <?= ($validation->hasError('price')) ? 'is-invalid' : ''; ?>" id="price" name="price" placeholder="0" value="<?= (old('price')) ? old('price') : $product['price']; ?>">
                    </div>

                    <div class="invalid-feedback">
                        <?= $validation->getError('price'); ?>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-5 gap-2">
                    <a href="/" class="btn btn-outline-primary">Back</a>

                    <button type="submit" class="btn btn-primary fw-bold px-5">
                        <i class="ph-fill ph-plus-square me-1"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>