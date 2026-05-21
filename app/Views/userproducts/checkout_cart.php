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
        padding: 16px;
        border-radius: 14px;
        background: #fff;
    }

    .total-label {
        font-size: 14px;
        color: #666;
    }

    .total-price {
        font-size: 14px;
        font-weight: 600;
        color: #111;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<div class="toast-box" id="toastBox"></div>

<div class="checkout-wrapper">

    <div class="checkout-card">

        <div class="checkout-header">

            <div class="d-flex align-items-center justify-content-between w-100">

                <div class="page-title mb-0">Checkout</div>

                <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill border bg-light">

                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width:34px;height:34px">
                        <i class="fas fa-wallet small"></i>
                    </div>

                    <div>
                        <div class="small text-muted lh-1">Balance</div>
                        <div class="fw-bold text-success" id="walletBalance">₹0</div>
                    </div>

                </div>

            </div>

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
                        <option value="wallet">wallet</option>
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

            <div class="summary-total border-top mt-2">
                <h6>Price Brakedown</h1>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                        <div class="total-label fw-bold">Sub Total</div>
                        <div class="total-price " id="SubTotal">₹0</div>
                    </div>
                    <div class="taxes"></div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                        <div class="total-label fw-bolder">Grand Total</div>
                        <div class="total-price fw-bolder" id="grandTotal">₹0</div>
                    </div>
            </div>

            <button class="place-btn mt-4" id="placeOrderBtn">
                Place Order
            </button>

        </div>

    </div>



</div>

<div class="modal fade" id="otpModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Wallet Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted small mb-3">Enter the OTP sent to your registered mobile/email</p>

                <input type="text" class="form-control text-center fs-4 fw-bold" id="walletOtp" maxlength="6" placeholder="Enter OTP">

                <button class="btn btn-dark w-100 mt-3 rounded-3" id="verifyOtpBtn">
                    Verify OTP
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    let csrfName = "<?= csrf_token() ?>";
    let csrfHash = "<?= csrf_hash() ?>";

    function handleResponseErrors(response) {
        console.log(response);
        updateCsrf(response.token);

        if (response.status) return false;

        let errors = response.errors?.errors || {};

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        if (response.errors?.walletBalance !== undefined) {
            $('#walletBalance').html(`₹${response.errors.walletBalance}`);
        }

        $.each(errors, function(key, message) {

            let field = $(`#${key}`);

            field.addClass('is-invalid');

            field.after(`
            <div class="invalid-feedback d-block">
                ${message}
            </div>
        `);

        });

        showToast(
            response.message ||
            Object.values(response.errors?.errors || {})[0] ||
            'Something went wrong',
            'error'
        );

        return true;
    }

    $(document).on('change', '#payment_method', function() {
        loadCheckoutCart();
    });

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

                if (handleResponseErrors(response)) {

                    btn.prop('disabled', false).html('Place Order');

                    return;
                }

                showToast(response.message || 'Order Placed Successfully');

                if (response.order_id) {
                    localStorage.setItem('order_id', response.order_id);
                }

                setTimeout(() => {

                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    }

                }, 1000);

            },

        });

    }

    function loadCheckoutCart() {

        $.ajax({

            url: "<?= base_url('getcart') ?>",

            type: "GET",

            dataType: "json",

            success: function(response) {
                updateCsrf(response.token);
                console.log(response);

                if (!response.status) return;
                $('#userName').text(response.user.name);
                $('#userEmail').text(response.user.email);
                $('#walletBalance').html(`₹${response.walletBalance}`);

                let wallet = parseFloat(response.walletBalance || 0);
                let grand = parseFloat(response.total.total || 0);

                if ($('#payment_method').val() == 'wallet' && grand > wallet) {
                    $('#placeOrderBtn').prop('disabled', true).css({
                        opacity: .6,
                        cursor: 'not-allowed'
                    }).html('Insufficient Wallet Balance');
                } else {
                    $('#placeOrderBtn').prop('disabled', false).css({
                        opacity: 1,
                        cursor: 'pointer'
                    }).html('Place Order');
                }
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

                rows = '';

                $.each(response.tax, function(name, amount) {

                    rows += `
                        <div class="d-flex justify-content-between align-items-center mb-1">
                         <div class="total-label fw-bold">${name.replace(/([A-Z])/g,' $1').replace(/^./,s=>s.toUpperCase())}</div>
                         <div class="total-price">₹${amount}</div>
                       </div>
                      `;

                });

                $(".taxes").html(rows);
                $('#SubTotal').text(`₹${response.total.subtotal}`);

                $('#grandTotal').text(`₹${response.total.total}`);
                SubTotal



            },

            error: function(xhr) {

                let response = xhr.responseJSON;

                console.log(response);

                handleResponseErrors(response);

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

                let response = xhr.responseJSON;

                if (handleResponseErrors(response)) {

                    btn.prop('disabled', false).html('Place Order');

                    return;
                }

                btn.prop('disabled', false).html('Place Order');


            }

        });

    });
</script>

<?= $this->endSection() ?>
```