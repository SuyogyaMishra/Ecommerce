<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<style>
    .page-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        margin-bottom: 25px
    }

    .stats-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: .3s
    }

    .stats-card:hover {
        transform: translateY(-5px)
    }

    .stats-card .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px
    }

    .stats-card.total {
        background: linear-gradient(135deg, #eff6ff, #dbeafe)
    }

    .stats-card.active {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5)
    }

    .stats-card.stock {
        background: linear-gradient(135deg, #fff7ed, #fed7aa)
    }

    .users-card,
    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden
    }

    .table thead th {
        border: none;
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        padding: 18px 15px
    }

    .table tbody td {
        vertical-align: middle;
        padding: 18px 15px;
        border-color: #f1f5f9
    }

    .table tbody tr:hover {
        background: #f8fafc
    }

    .search-box {
        border-radius: 12px;
        border: 1px solid #dbeafe;
        padding: 10px 15px
    }

    .btn-custom {
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 600
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center
    }

    .page-item .page-link {
        border: none;
        margin: 0 4px;
        border-radius: 10px;
        color: #0f172a
    }

    .page-item.active .page-link {
        background: #0f172a;
        color: #fff
    }

    .badge {
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 12px
    }

    .product-img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 12px
    }
</style>

<div class="main-content flex-grow-1">

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-2">
                <i class="bi bi-box-seam-fill me-2"></i>
                Products Management
            </h2>

            <p class="mb-0 opacity-75">
                Manage all products
            </p>
        </div>

        <button class="btn btn-light btn-custom shadow-sm" id="openAddModal">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Add Product
        </button>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card stats-card total shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Products</p>
                        <h2 class="fw-bold mb-0" id="totalProducts">0</h2>
                    </div>

                    <div class="icon-box bg-primary text-white">
                        <i class="bi bi-box-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stats-card active shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Active Products</p>
                        <h2 class="fw-bold mb-0" id="activeProducts">0</h2>
                    </div>

                    <div class="icon-box bg-success text-white">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stats-card stock shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Out Of Stock</p>
                        <h2 class="fw-bold mb-0" id="outStockProducts">0</h2>
                    </div>

                    <div class="icon-box bg-warning text-white">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card users-card shadow-sm">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h4 class="mb-1 fw-bold">Products List</h4>
                </div>

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                    <input type="text" class="form-control search-box ps-5" id="searchProduct" placeholder="Search product...">
                </div>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="productTable"></tbody>

            </table>

            <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-2">

                <ul class="pagination mb-0" id="pagination"></ul>

                <div class="d-flex align-items-center gap-2">

                    <small class="text-muted">Show</small>

                    <select id="limitProducts" class="form-select form-select-sm" style="width:90px;">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                    </select>

                    <small class="text-muted">products</small>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ADD MODAL -->

<div class="modal fade" id="addProductModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <form id="addProductForm" enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Price</label>
                        <input type="number" class="form-control" name="price">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stock</label>
                        <input type="number" class="form-control" name="stock">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>

                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 btn-custom">
                        Add Product
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- UPDATE MODAL -->

<div class="modal fade" id="updateProductModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <form id="updateProductForm" enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <input type="hidden" name="product_id" id="edit_product_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Price</label>
                        <input type="number" class="form-control" name="price" id="edit_price">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stock</label>
                        <input type="number" class="form-control" name="stock" id="edit_stock">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>

                        <select class="form-select" name="status" id="edit_status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 btn-custom">
                        Update Product
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<div class="toast-container position-fixed top-0 end-0 p-3">

    <div id="liveToast" class="toast border-0 shadow">

        <div class="toast-header">

            <strong class="me-auto">Notification</strong>

            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>

        </div>

        <div class="toast-body" id="toastMessage"></div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    function updateCsrf(res) {

        if (res.token) {

            csrfHash = res.token;

            $('input[name="' + csrfName + '"]').val(csrfHash);

        }

    }


    function showToast(message, type = 'success') {

        let toastEl = document.getElementById('liveToast');

        toastEl.classList.remove(
            'text-bg-success',
            'text-bg-danger'
        );

        toastEl.classList.add(
            type == 'success' ?
            'text-bg-success' :
            'text-bg-danger'
        );

        $('#toastMessage').text(message);

        new bootstrap.Toast(toastEl).show();

    }

    function loadProducts(page = 1) {

        let search = $('#searchProduct').val();
        let limit = $('#limitProducts').val();

        $('#productTable').html(`
    <tr>
        <td colspan="7" class="text-center p-5">
            <div class="spinner-border text-dark"></div>
        </td>
    </tr>
    `);

        $.ajax({

            url: "<?= base_url('admin/productdata') ?>",

            type: "GET",

            data: {
                page,
                limit,
                search
            },

            success: function(res) {

                updateCsrf(res);

                $('#totalProducts').text(res.totalProducts);
                $('#activeProducts').text(res.activeProducts);
                $('#outStockProducts').text(res.outStockProducts);

                let html = '';

                if (res.products.users.length < 1) {

                    html = `
                <tr>
                    <td colspan="7" class="text-center text-muted p-5">
                        No products found
                    </td>
                </tr>
                `;

                } else {

                    $.each(res.products.users, function(i, product) {

                        html += `
                    <tr>

                        <td>${product.id}</td>

                        <td>
                            <img src="<?= base_url() ?>/${product.image}" class="product-img">
                        </td>

                        <td>${product.name}</td>

                        <td>₹${product.price}</td>

                        <td>${product.stock}</td>

                        <td>
                            <span class="badge ${product.status==1?'bg-success':'bg-danger'}">
                                ${product.status==1?'Active':'Inactive'}
                            </span>
                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <button class="btn btn-primary btn-sm action-btn editBtn" data-id="${product.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn btn-danger btn-sm action-btn deleteBtn" data-id="${product.id}">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>
                    `;

                    });

                }

                $('#productTable').html(html);

                let pagination = '';

                for (let i = 1; i <= res.totalPages; i++) {

                    pagination += `
                <li class="page-item ${res.products.page==i?'active':''}">
                    <a href="#" class="page-link paginationBtn" data-page="${i}">
                        ${i}
                    </a>
                </li>
                `;

                }

                $('#pagination').html(pagination);

            },

            error: function() {

                $('#productTable').html(`
            <tr>
                <td colspan="7" class="text-center text-danger p-5">
                    Failed to load products
                </td>
            </tr>
            `);

            }

        });

    }

    loadProducts();

    $(document).on('keyup', '#searchProduct', function() {

        loadProducts();

    });

    $(document).on('change', '#limitProducts', function() {

        loadProducts();

    });

    $(document).on('click', '.paginationBtn', function(e) {

        e.preventDefault();

        loadProducts($(this).data('page'));

    });

    $('#openAddModal').click(function() {

        $('#addProductForm')[0].reset();

        new bootstrap.Modal(
            document.getElementById('addProductModal')
        ).show();

    });

    $('#addProductForm').submit(function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        formData.append(csrfName, csrfHash);
        $.ajax({

            url: "<?= base_url('admin/addproduct') ?>",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success: function(res) {

                updateCsrf(res);

                $('#addProductForm')[0].reset();

                bootstrap.Modal.getInstance(
                    document.getElementById('addProductModal')
                ).hide();

                loadProducts();

                showToast(res.message);

            },

            error: function(xhr) {

                updateCsrf(xhr.responseJSON || {});

                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );

            }

        });

    });

    $(document).on('click', '.editBtn', function() {

        let id = $(this).data('id');

        $.ajax({

            url: "<?= base_url('admin/getproduct') ?>/" + id,

            type: "GET",

            success: function(res) {

                updateCsrf(res);

                $('#edit_product_id').val(res.product.id);
                $('#edit_name').val(res.product.name);
                $('#edit_price').val(res.product.price);
                $('#edit_stock').val(res.product.stock);
                $('#edit_status').val(res.product.status);

                new bootstrap.Modal(
                    document.getElementById('updateProductModal')
                ).show();

            }

        });

    });

    $('#updateProductForm').submit(function(e) {

        e.preventDefault();

        let id = $('#edit_product_id').val();

        let formData = new FormData(this);

        formData.append('_method', 'PUT');
        formData.append(csrfName, csrfHash);
        $.ajax({

            url: "<?= base_url('admin/updateproduct') ?>/" + id,

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success: function(res) {

                updateCsrf(res);

                bootstrap.Modal.getInstance(
                    document.getElementById('updateProductModal')
                ).hide();

                $('#updateProductForm')[0].reset();

                loadProducts();

                showToast(res.message);

            },

            error: function(xhr) {

                updateCsrf(xhr.responseJSON || {});

                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );

            }

        });

    });

    $(document).on('click', '.deleteBtn', function() {

        if (!confirm('Delete this product?')) return;

        let id = $(this).data('id');

        $.ajax({

            url: "<?= base_url('admin/deleteproduct') ?>/" + id,

            type: "POST",

            data: {
                _method: 'DELETE',
                [csrfName]: csrfHash
            },

            success: function(res) {

                updateCsrf(res);

                loadProducts();

                showToast(res.message);

            },

            error: function(xhr) {

                updateCsrf(xhr.responseJSON || {});

                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );

            }

        });

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>