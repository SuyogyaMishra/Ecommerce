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

    .orders-wrapper {
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

    .search-box {
        width: 320px;
        max-width: 100%;
        border: 1px solid #dbe2ea;
        border-radius: 14px;
        padding: 12px 18px 12px 45px;
    }

    .search-box:focus {
        outline: none;
        border-color: #111827;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap i {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #94a3b8;
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

    .order-id {
        font-weight: 700;
        color: #111827;
    }

    .price {
        font-weight: 700;
        color: #111827;
    }

    .badge-status {
        padding: 7px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-placed {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .pagination-wrap {
        padding: 25px;
        border-top: 1px solid #e2e8f0;
    }

    .page-item .page-link {
        border: none;
        margin: 0 4px;
        border-radius: 10px;
        color: #111827;
        min-width: 40px;
        text-align: center;
    }

    .page-item.active .page-link {
        background: #111827;
        color: #fff;
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

        .search-box {
            width: 100%;
        }

    }
</style>

<div class="orders-wrapper">

    <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <div class="page-title">
                My Orders
            </div>

            <div class="page-subtitle">
                Track and manage your orders
            </div>

        </div>

    </div>

    <div class="p-4 border-bottom">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="search-wrap">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="searchOrder"
                    class="search-box"
                    placeholder="Search orders...">

            </div>

            <div class="d-flex align-items-center gap-2">

                <small class="text-muted">
                    Show
                </small>

                <select id="limitOrders" class="form-select form-select-sm" style="width:90px;border-radius:10px;">

                    <option value="5">5</option>

                    <option value="10" selected>10</option>

                    <option value="25">25</option>

                </select>

            </div>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Order ID</th>

                    <th>Total</th>

                    <th>Payment</th>

                    <th>Payment Status</th>

                    <th>Order Status</th>

                    <th>Date</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody id="ordersTableBody"></tbody>

        </table>

    </div>

    <div class="pagination-wrap d-flex justify-content-center">

        <ul class="pagination mb-0" id="pagination"></ul>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {

        loadOrders();

    });

    function loadOrders(page = 1) {

        let search = $('#searchOrder').val();
        let limit = $('#limitOrders').val();

        $('#ordersTableBody').html(`
        <tr>
            <td colspan="7" class="text-center empty-box">
                <div class="spinner-border text-dark"></div>
            </td>
        </tr>
    `);

        $.ajax({

            url: "<?= base_url('getorders') ?>",

            type: "GET",

            data: {
                page,
                limit,
                search
            },

            dataType: "json",

            success: function(response) {

                let rows = '';
                $('#userName').text(response.user.name);
                $('#userEmail').text(response.user.email);
                if (response.orders.users.length < 1) {

                    rows = `
                    <tr>
                        <td colspan="6" class="text-center empty-box">

                            <i class="bi bi-box display-4 text-muted"></i>

                            <div class="mt-3 text-muted fw-semibold">
                                No Orders Found
                            </div>

                        </td>
                    </tr>
                `;

                } else {

                    $.each(response.orders.users, function(i, order) {

                        let paymentBadge = '';
                        let orderBadge = '';

                        if (order.payment_status === 'paid' || order.payment_status === 'cod_pending')
                            paymentBadge = 'status-placed';
                        else if (order.payment_status === 'failed')
                            paymentBadge = 'status-failed';
                        else
                            paymentBadge = 'status-pending';

                        if (order.order_status === 'confirmed')
                            orderBadge = 'status-placed';
                        else if (order.order_status === 'payment_failed')
                            orderBadge = 'status-failed';
                        else
                            orderBadge = 'status-pending';

                        rows += `
                        <tr>

                           <td>
    <a 
        href="<?= base_url('orderdetails') ?>/${order.id}"
        class="order-id ">
        #${order.id}
    </a>
</td>

                            <td>
                                <span class="price">
                                    ₹${order.total}
                                </span>
                            </td>

                            <td>
                                ${order.payment_method.toUpperCase()}
                            </td>

                            <td>
                                <span class="badge-status ${paymentBadge}">
                                    ${order.payment_status}
                                </span>
                            </td>

                            <td>
                                <span class="badge-status ${orderBadge}">
                                    ${order.order_status}
                                </span>
                            </td>

                            <td>
                                ${order.created_at}
                            </td>
                            <td>
        ${
            ['pending','confirmed'].includes(order.order_status)
            ?`
            <button
                class="btn btn-danger btn-sm cancelOrderBtn"
                data-id="${order.id}">
                Cancel
            </button>
            `
            :`<span class="text-muted small">N/A</span>`
        }
            <a 
        href="invoice/${order.id}" 
        class="btn btn-primary btn-sm ms-1"
        target="_blank">
        Invoice
    </a>
    </td>


                        </tr>
                    `;

                    });

                }

                $('#ordersTableBody').html(rows);

                let pagination = '';

                for (let i = 1; i <= response.totalPages; i++) {

                    pagination += `
                    <li class="page-item ${response.orders.page==i?'active':''}">
                        <a href="#" class="page-link paginationBtn" data-page="${i}">
                            ${i}
                        </a>
                    </li>
                `;

                }

                $('#pagination').html(pagination);

            }

        });

    }

    $(document).on('keyup', '#searchOrder', function() {

        loadOrders(1);

    });

    $(document).on('click', '.paginationBtn', function(e) {

        e.preventDefault();

        loadOrders($(this).data('page'));

    });
    $(document).on('change', '#limitOrders', function() {

        loadOrders(1);

    });
</script>
<script>
    window.CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
    window.CSRF_TOKEN_HASH = '<?= csrf_hash() ?>';

    function updateCsrf(csrf) {

        if (!csrf)
            return;

        window.CSRF_TOKEN_NAME = csrf.token;
        window.CSRF_TOKEN_HASH = csrf.hash;

    }

    $(document).on('click', '.cancelOrderBtn', function() {

        if (!confirm('Cancel this order ?'))
            return;

        let btn = $(this);
        let id = btn.data('id');

        btn.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

        $.ajax({

            url: "<?= base_url('cancelorder') ?>/" + id,

            type: "delete",

            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN_HASH
            },

            dataType: "json",

            success: function(res) {

                updateCsrf(res.csrf);

                alert(res.message);

                loadOrders();

            },

            error: function(xhr) {

                updateCsrf(xhr.responseJSON?.csrf);

                alert(
                    xhr.responseJSON?.message ||
                    'Something went wrong'
                );

                btn.prop('disabled', false).html('Cancel');

            }

        });

    });
</script>

<?= $this->endSection() ?>