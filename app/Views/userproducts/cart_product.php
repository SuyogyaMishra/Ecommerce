<?= $this->extend('layouts/user_sidebar') ?>

<?= $this->section('content') ?>

<style>
    body {
        overflow-x: hidden;
        background: #f1f5f9;
    }

    .main-content {
        margin-left: 260px;
        width: calc(100% - 260px);
        min-height: 100vh;
        padding: 30px;
    }

    .cart-wrapper {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .05);
    }

    .top-bar {
        padding: 25px 30px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
    }

    .page-subtitle {
        color: #64748b;
        margin-top: 5px;
    }

    .toast-box {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        min-width: 320px;
        padding: 14px 18px;
        border-radius: 14px;
        color: #fff;
        font-weight: 600;
        display: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
    }

    .toast-success {
        background: #16a34a;
    }

    .toast-error {
        background: #dc2626;
    }

    .table {
        margin: 0;
    }

    .table thead th {
        background: #111827 !important;
        color: #fff !important;
        border: none;
        padding: 18px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 18px;
        vertical-align: middle;
        border-color: #f1f5f9;
        white-space: nowrap;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .product-img {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 14px;
        background: #e2e8f0;
    }

    .product-name {
        font-weight: 600;
        color: #0f172a;
    }

    .price {
        font-weight: 700;
        color: #111827;
    }

    .qty-box {
        width: 90px;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 8px 10px;
        outline: none;
    }

    .total-box {
        background: #111827;
        color: #fff;
        padding: 25px 30px;
    }

    .total-title {
        font-size: 15px;
        opacity: .8;
    }

    .total-price {
        font-size: 32px;
        font-weight: 700;
    }

    .btn-action {
        border: none;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-update {
        background: #111827;
        color: #fff;
    }

    .btn-update:hover {
        background: #000;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #fecaca;
    }

    .empty-box {
        padding: 80px 20px;
    }

    @media(max-width:768px) {

        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 15px;
        }

        .top-bar {
            padding: 20px;
        }

    }
</style>

<div class="cart-wrapper">

    <div class="toast-box" id="toastBox"></div>

    <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <div class="page-title">
                My Cart
            </div>

            <div class="page-subtitle">
                Manage your cart products
            </div>

        </div>

        <a href="<?= base_url('dashboard') ?>" class="btn btn-dark px-4 py-2 rounded-3">

            <i class="bi bi-arrow-left me-2"></i>

            Continue Shopping

        </a>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Image</th>

                    <th>Product</th>

                    <th>Price</th>

                    <th>Quantity</th>

                    <th>Total</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody id="cartTableBody"></tbody>

        </table>

    </div>

    <div class="total-box d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <div class="total-title">
                Grand Total
            </div>

            <div class="total-price" id="grandTotal">
                ₹0
            </div>

        </div>

        <a href="<?= base_url('checkout') ?>" class="btn btn-success rounded-3 px-3 py-2">
            Checkout
        </a>

    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let csrfName = "<?= csrf_token() ?>";
    let csrfHash = "<?= csrf_hash() ?>";

    function updateCsrf(token) {

        csrfHash = token;

    }

    function showToast(message, type = 'success') {

        $('#toastBox')
            .removeClass('toast-success toast-error')
            .addClass(type == 'success' ? 'toast-success' : 'toast-error')
            .html(message)
            .fadeIn(200);

        setTimeout(() => {
            $('#toastBox').fadeOut(200);
        }, 2500);

    }

    $(document).ready(function() {

        loadCart();

    });

    function loadCart() {

        $('#cartTableBody').html(`
        <tr>
            <td colspan="7" class="text-center empty-box">
                <div class="spinner-border text-dark"></div>
            </td>
        </tr>
    `);

        $.ajax({

            url: "<?= base_url('getcart') ?>",

            type: "GET",

            dataType: "json",

            success: function(response) {

                updateCsrf(response.token);

                if (!response.status) {

                    showToast(response.message || 'Failed To Load Cart', 'error');

                    return;

                }

                let rows = '';
                let grandTotal = 0;
                $('#userName').text(response.user.name);
                $('#userEmail').text(response.user.email);
                if (response.cart.length < 1) {

                    rows = `
                    <tr>
                        <td colspan="7" class="text-center empty-box">

                            <i class="bi bi-cart-x display-4 text-muted"></i>

                            <div class="mt-3 text-muted fw-semibold">
                                Cart Is Empty
                            </div>

                        </td>
                    </tr>
                `;

                } else {

                    $.each(response.cart, function(i, item) {

                        let total = item.price * item.quantity;

                        grandTotal += total;

                        rows += `
                        <tr>

                            <td>#${item.id}</td>

                            <td>

                                <img 
                                    src="<?= base_url() ?>/${item.image}"
                                    class="product-img"
                                    onerror="this.src='https://placehold.co/65x65'"
                                >

                            </td>

                            <td>

                                <div class="product-name">
                                    ${item.name}
                                </div>

                            </td>

                            <td>

                                <span class="price">
                                    ₹${item.price}
                                </span>

                            </td>

                            <td>

                                <input 
                                    type="number"
                                    min="1"
                                    value="${item.quantity}"
                                    class="qty-box qtyInput"
                                    data-id="${item.id}"
                                >

                            </td>

                            <td>

                                <span class="price">
                                    ₹${total}
                                </span>

                            </td>

                            <td class="d-flex gap-2">

                                <button class="btn-action btn-update updateCartBtn" data-id="${item.id}">

                                    <i class="bi bi-arrow-repeat me-1"></i>

                                    Update

                                </button>

                                <button class="btn-action btn-delete deleteCartBtn" data-id="${item.id}">

                                    <i class="bi bi-trash me-1"></i>

                                    Delete

                                </button>

                            </td>

                        </tr>
                    `;

                    });

                }

                $('#cartTableBody').html(rows);

                $('#grandTotal').text(`₹${grandTotal}`);

            },

            error: function(xhr) {

                if (xhr.responseJSON?.token) {
                    updateCsrf(xhr.responseJSON.token);
                }

                showToast(xhr.responseJSON?.message || 'Something Went Wrong', 'error');

            }

        });

    }

    $(document).on('click', '.updateCartBtn', function() {

        let id = $(this).data('id');
        let quantity = $(`.qtyInput[data-id="${id}"]`).val();
        let btn = $(this);

        btn.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

        $.ajax({

            url: "<?= base_url('updatecart') ?>/" + id,

            type: "POST",

            data: {
                quantity,
                [csrfName]: csrfHash
            },

            dataType: "json",

            success: function(response) {

                updateCsrf(response.token);

                if (!response.status) {

                    showToast(response.message || 'Failed To Update Cart', 'error');

                    btn.prop('disabled', false).html(`
                    <i class="bi bi-arrow-repeat me-1"></i>
                    Update
                `);

                    return;

                }

                showToast(response.message || 'Cart Updated');

                loadCart();

            },

            error: function(xhr) {

                if (xhr.responseJSON?.token) {
                    updateCsrf(xhr.responseJSON.token);
                }

                showToast(xhr.responseJSON?.message || 'Something Went Wrong', 'error');

                btn.prop('disabled', false).html(`
                <i class="bi bi-arrow-repeat me-1"></i>
                Update
            `);

            }

        });

    });

    $(document).on('click', '.deleteCartBtn', function() {

        let id = $(this).data('id');
        let btn = $(this);

        btn.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

        $.ajax({

            url: "<?= base_url('deletecart') ?>/" + id,

            type: "POST",

            data: {
                [csrfName]: csrfHash
            },

            dataType: "json",

            success: function(response) {

                updateCsrf(response.token);

                if (!response.status) {

                    showToast(response.message || 'Failed To Delete Item', 'error');

                    btn.prop('disabled', false).html(`
                    <i class="bi bi-trash me-1"></i>
                    Delete
                `);

                    return;

                }

                showToast(response.message || 'Item Removed');

                loadCart();

            },

            error: function(xhr) {

                if (xhr.responseJSON?.token) {
                    updateCsrf(xhr.responseJSON.token);
                }

                showToast(xhr.responseJSON?.message || 'Something Went Wrong', 'error');

                btn.prop('disabled', false).html(`
                <i class="bi bi-trash me-1"></i>
                Delete
            `);

            }

        });

    });
</script>

<?= $this->endSection() ?>