```php
<?= $this->extend('layouts/user_sidebar') ?>
<?= $this->section('content') ?>

<style>
    body {
        overflow-x: hidden;
        background: #f1f5f9
    }

    .main-content {
        margin-left: 260px;
        width: calc(100% - 260px);
        min-height: 100vh;
        padding: 30px
    }

    .checkout-wrapper {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 25px
    }

    .checkout-card,
    .summary-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .05)
    }

    .checkout-header,
    .summary-header {
        padding: 24px 28px;
        border-bottom: 1px solid #e2e8f0
    }

    .checkout-body,
    .summary-body {
        padding: 28px
    }

    .page-title {
        font-size: 30px;
        font-weight: 700;
        color: #0f172a
    }

    .page-subtitle {
        color: #64748b;
        margin-top: 4px
    }

    .form-label {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px
    }

    .form-control {
        border: 1px solid #dbe2ea;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: none
    }

    .form-control:focus {
        border-color: #111827;
        box-shadow: none
    }

    .product-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9
    }

    .product-row:last-child {
        border: none;
        padding-bottom: 0
    }

    .product-img {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        object-fit: cover;
        background: #e2e8f0
    }

    .product-name {
        font-weight: 700;
        color: #0f172a
    }

    .product-meta {
        font-size: 14px;
        color: #64748b;
        margin-top: 4px
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        margin-top: 20px;
        border-top: 1px solid #e2e8f0
    }

    .total-label {
        font-size: 15px;
        color: #64748b
    }

    .total-price {
        font-size: 34px;
        font-weight: 800;
        color: #111827
    }

    .place-btn {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 16px;
        background: #111827;
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        transition: .2s
    }

    .place-btn:hover {
        background: #000
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
        box-shadow: 0 10px 30px rgba(0, 0, 0, .15)
    }

    .toast-success {
        background: #16a34a
    }

    .toast-error {
        background: #dc2626
    }

    @media(max-width:992px) {
        .checkout-wrapper {
            grid-template-columns: 1fr
        }

        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 15px
        }
    }
</style>

<div class="toast-box" id="toastBox"></div>

<div class="checkout-wrapper">

    <div class="checkout-card">

        <div class="checkout-header">

            <div class="page-title">Checkout</div>

            <div class="page-subtitle">Complete your shipping and payment details</div>

        </div>

        <div class="checkout-body">

            <div class="row g-4">

                <div class="col-md-6">

                    <label class="form-label">Full Name</label>

                    <input type="text" class="form-control" id="name">

                </div>

                <div class="col-md-6">

                    <label class="form-label">Email</label>

                    <input type="email" class="form-control" id="email">

                </div>

                <div class="col-md-6">

                    <label class="form-label">Phone</label>

                    <input type="text" class="form-control" id="phone">

                </div>

                <div class="col-md-6">

                    <label class="form-label">Payment Method</label>

                    <select class="form-control" id="payment_method">
                        <option value="cod">Cash On Delivery</option>
                        <option value="online">Online Payment</option>
                    </select>

                </div>

                <div class="col-12">

                    <label class="form-label">Address</label>

                    <textarea class="form-control" rows="5" id="address"></textarea>

                </div>

            </div>

        </div>

    </div>

    <div class="summary-card">

        <div class="summary-header d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold fs-5">Order Summary</div>
                <div class="text-muted small">Your cart products</div>
            </div>

            <a href="<?= base_url('user/cart') ?>" class="btn btn-dark rounded-3 px-3 py-2">
                Back
            </a>

        </div>

        <div class="summary-body">

            <div id="checkoutProducts"></div>

            <div class="summary-total">

                <div>
                    <div class="total-label">Grand Total</div>
                </div>

                <div class="total-price" id="grandTotal">₹0</div>

            </div>

            <button class="place-btn mt-4" id="placeOrderBtn">
                Place Order
            </button>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    let csrfName = "<?= csrf_token() ?>";
    let csrfHash = "<?= csrf_hash() ?>";

    function updateCsrf(token) {
        csrfHash = token
    }

    function showToast(message, type = 'success') {
        $('#toastBox').removeClass('toast-success toast-error').addClass(type == 'success' ? 'toast-success' : 'toast-error').html(message).fadeIn(200);
        setTimeout(() => {
            $('#toastBox').fadeOut(200)
        }, 2500);
    }

    $(document).ready(function() {
        loadUser();
        loadCheckoutCart();
    });

    function loadUser() {

        $.ajax({

            url: "<?= base_url('getuserdata') ?>",

            type: "GET",

            dataType: "json",

            success: function(response) {

                if (response.status) {

                    $('#name').val(response.user.name);
                    $('#email').val(response.user.email);
                    $('#phone').val(response.user.phone);
                    $('#address').val(response.user.address);

                }

            }

        });

    }

    function loadCheckoutCart() {

        $.ajax({

            url: "<?= base_url('getcart') ?>",

            type: "GET",

            dataType: "json",

            success: function(response) {

                updateCsrf(response.token);

                if (!response.status) return;
                $('#userName').text(response.user.name);
                $('#userEmail').text(response.user.email);
                let rows = '';
                let total = 0;

                $.each(response.cart, function(i, item) {

                    let subtotal = item.price * item.quantity;
                    total += subtotal;

                    rows += `
                    <div class="product-row">

                        <img src="<?= base_url() ?>/${item.image}" class="product-img" onerror="this.src='https://placehold.co/70x70'">

                        <div class="flex-grow-1">

                            <div class="product-name">${item.name}</div>

                            <div class="product-meta">Qty : ${item.quantity}</div>

                        </div>

                        <div class="fw-bold">₹${subtotal}</div>

                    </div>
                `;

                });

                $('#checkoutProducts').html(rows);
                $('#grandTotal').text(`₹${total}`);

            }

        });

    }

    $(document).on('click', '#placeOrderBtn', function() {

        let btn = $(this);

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({

            url: "<?= base_url('placeorder') ?>",

            type: "POST",

            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                payment_method: $('#payment_method').val(),
                [csrfName]: csrfHash
            },

            dataType: "json",

            success: function(response) {

                updateCsrf(response.token);

                if (!response.status) {

                    showToast(response.message || 'Order Failed', 'error');

                    btn.prop('disabled', false).html('Place Order');

                    return;

                }
                showToast(response.message || 'Order Placed Successfully');
                    if (response.order_id) {
                            localStorage.setItem('order_id', response.order_id);
                        }
                setTimeout(() => {
                    if (response.redirect_url)
                    window.location.href = response.redirect_url;
                }, 1000);


            },

            error: function(xhr) {

                if (xhr.responseJSON?.token) updateCsrf(xhr.responseJSON.token);

                showToast(xhr.responseJSON?.message || 'Something Went Wrong', 'error');

                btn.prop('disabled', false).html('Place Order');

            }

        });

    });
</script>

<?= $this->endSection() ?>
```