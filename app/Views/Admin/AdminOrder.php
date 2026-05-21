<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary: #4f46e5;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #0f172a;
        --text: #0f172a;
        --muted: #64748b;
        --border: #e2e8f0;
        --bg: #f8fafc;
        --card: #ffffff;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: Inter, sans-serif;
        overflow-x: hidden
    }

    .main-content {
        min-height: 100vh;
        padding: 20px
    }

    .container-fluid {
        max-width: 1380px
    }

    .page-header {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 20px;
        color: #fff;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .12)
    }

    .page-header h2 {
        font-size: 24px;
        margin-bottom: 5px
    }

    .page-header p {
        font-size: 13px;
        opacity: .8
    }

    .row.g-4 {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem
    }

    .stats-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: .25s;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .05)
    }

    .stats-card:hover {
        transform: translateY(-3px)
    }

    .stats-card.total {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff)
    }

    .stats-card.pending {
        background: linear-gradient(135deg, #fff7ed, #fde68a)
    }

    .stats-card.completed {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5)
    }

    .stats-card .card-body {
        padding: 18px !important
    }

    .stats-card p {
        font-size: 12px;
        margin-bottom: 4px;
        color: #64748b
    }

    .stats-card h2 {
        font-size: 24px;
        margin: 0
    }

    .icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .08)
    }

    .orders-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .05)
    }

    .orders-card .card-header {
        background: #fff;
        border: none;
        padding: 20px 22px
    }

    .orders-card h4 {
        font-size: 18px;
        margin-bottom: 2px
    }

    .search-box {
        width: 240px;
        height: 42px;
        border-radius: 12px;
        border: 1px solid var(--border);
        font-size: 13px;
        background: #fff;
        transition: .2s
    }

    .search-box:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .08)
    }

    .table {
        margin: 0
    }

    .table thead th {
        border: none;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 16px 18px
    }

    .table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        border-color: #f1f5f9;
        font-size: 13px;
        color: #0f172a
    }

    .table tbody tr {
        transition: .2s
    }

    .table tbody tr:hover {
        background: #f8fafc
    }

    .badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s
    }

    .action-btn:hover {
        transform: translateY(-1px)
    }

    .btn-primary.action-btn {
        background: #eef2ff;
        color: #4f46e5
    }

    .btn-primary.action-btn:hover {
        background: #4f46e5;
        color: #fff
    }

    .btn-danger.action-btn {
        background: #fef2f2;
        color: #ef4444
    }

    .btn-danger.action-btn:hover {
        background: #ef4444;
        color: #fff
    }

    .pagination {
        gap: 6px
    }

    .page-item .page-link {
        border: none;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 13px;
        font-weight: 600
    }

    .page-item.active .page-link {
        background: #4f46e5;
        color: #fff
    }

    .form-select {
        border-radius: 10px;
        border: 1px solid var(--border);
        font-size: 13px
    }

    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(15, 23, 42, .12)
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 18px 22px
    }

    .modal-title {
        font-size: 18px
    }

    .modal-body {
        padding: 22px !important
    }

    .form-control,
    .form-select {
        height: 44px;
        border-radius: 12px;
        border: 1px solid var(--border);
        font-size: 13px
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .08)
    }

    .form-label {
        font-size: 13px;
        margin-bottom: 7px
    }

    .toast {
        border: none !important;
        border-radius: 14px !important;
        overflow: hidden;
        font-size: 13px
    }

    .toast-header {
        border: none
    }

    .spinner-border {
        width: 2rem;
        height: 2rem
    }

    .table-responsive {
        min-height: 420px
    }

    small.text-muted {
        font-size: 12px
    }

    .fw-semibold {
        font-size: 13px
    }

    @media(max-width:768px) {

        .main-content {
            padding: 14px
        }

        .page-header {
            padding: 20px
        }

        .page-header h2 {
            font-size: 20px
        }

        .stats-card h2 {
            font-size: 20px
        }

        .icon-box {
            width: 46px;
            height: 46px;
            font-size: 18px
        }

        .search-box {
            width: 100%
        }

        .table thead th,
        .table tbody td {
            padding: 13px
        }

    }
</style>

<div class="main-content flex-grow-1">

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <h2 class="fw-bold mb-2">
                <i class="bi bi-bag-check-fill me-2"></i>
                Orders Management
            </h2>

            <p class="mb-0 opacity-75">
                Manage and track all customer orders
            </p>

        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card stats-card total shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">Total Orders</p>
                        <h2 class="fw-bold mb-0" id="totalOrders">0</h2>
                    </div>

                    <div class="icon-box bg-primary text-white">
                        <i class="bi bi-cart-fill"></i>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card pending shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">Pending Orders</p>
                        <h2 class="fw-bold mb-0" id="pendingOrders">0</h2>
                    </div>

                    <div class="icon-box bg-warning text-white">
                        <i class="bi bi-clock-fill"></i>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card stats-card completed shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">Completed Orders</p>
                        <h2 class="fw-bold mb-0" id="completedOrders">0</h2>
                    </div>

                    <div class="icon-box bg-success text-white">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card orders-card shadow-sm">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h4 class="mb-1 fw-bold">
                        Orders List
                    </h4>

                    <small class="text-muted">
                        Search and manage orders
                    </small>

                </div>

                <div class="position-relative">

                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                    <input
                        type="text"
                        class="form-control search-box ps-5"
                        id="searchOrder"
                        placeholder="Search order...">

                </div>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="sortColumn" data-column="id">
                            ID <i class="bi bi-arrow-down-up ms-1"></i>
                        </th>

                        <th>
                            Customer
                        </th>

                        <th class="sortColumn" data-column="total">
                            Total <i class="bi bi-arrow-down-up ms-1"></i>
                        </th>

                        <th class="sortColumn" data-column="payment_method">
                            Payment <i class="bi bi-arrow-down-up ms-1"></i>
                        </th>

                        <th class="sortColumn" data-column="payment_status">
                            Payment Status <i class="bi bi-arrow-down-up ms-1"></i>
                        </th>

                        <th class="sortColumn" data-column="order_status">
                            Order Status <i class="bi bi-arrow-down-up ms-1"></i>
                        </th>

                        <th class="sortColumn" data-column="created_at">
                            Date <i class="bi bi-arrow-down-up ms-1"></i>
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody id="orderTable"></tbody>

            </table>

            <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-2">

                <ul class="pagination mb-0" id="pagination"></ul>

                <div class="d-flex align-items-center gap-2">

                    <small class="text-muted">Show</small>

                    <select id="limitOrders" class="form-select form-select-sm" style="width:90px;">

                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>

                    </select>

                    <small class="text-muted">orders</small>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="updateOrderModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Update Order
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <form id="updateOrderForm">

                    <input type="hidden" id="order_id">

                    <div class="mb-3">

                        <label class="form-label">
                            Order Status
                        </label>

                        <select id="order_status" class="form-select">

                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="returned">Returned</option>

                        </select>

                    </div>

                    <button class="btn btn-dark w-100">
                        Update Order
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<div class="toast-container position-fixed top-0 end-0 p-3">

    <div id="liveToast" class="toast border-0 shadow">

        <div class="toast-header">

            <strong class="me-auto" id="toastTitle">
                Notification
            </strong>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast">
            </button>

        </div>

        <div class="toast-body" id="toastMessage"></div>

    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    let sortColumn ;
    let sortDirection ='ASC';
    function updateCsrf(tokenName, tokenHash) {
        $('input[name="' + tokenName + '"]').val(tokenHash);
        window.CSRF_TOKEN_NAME = tokenName;
        window.CSRF_TOKEN_HASH = tokenHash;
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

    function loadOrders(page = 1) {
        let search = $('#searchOrder').val();

        let limit = $('#limitOrders').val();

        $('#orderTable').html(`
        <tr>
            <td colspan="8" class="text-center p-5">
                <div class="spinner-border text-dark"></div>
            </td>
        </tr>
    `);

        $.ajax({

            url: "<?= base_url('admin/getorders') ?>",

            type: "GET",

            data: {
                page,
                limit,
                search,
                sortDirection,
                sortColumn
            },

            dataType: "json",

            success: function(res) {

                $('#totalOrders').text(res.totalOrders);

                $('#pendingOrders').text(res.pendingOrders);

                $('#completedOrders').text(res.completedOrders);

                let html = '';

                if (res.orders.users.length < 1) {

                    html = `
                    <tr>
                        <td colspan="8" class="text-center text-muted p-5">
                            No Orders Found
                        </td>
                    </tr>
                `;

                } else {

                    $.each(res.orders.users, function(i, order) {

                        html += `
                        <tr>

                            <td>#${order.id}</td>

                            <td>
                                <div class="fw-semibold">
                                    ${order.name}
                                </div>

                                <small class="text-muted">
                                    ${order.email}
                                </small>
                            </td>

                            <td>
                                ₹${order.total}
                            </td>

                            <td>
                                ${order.payment_method.toUpperCase()}
                            </td>

                            <td>

                                <span class="badge ${order.payment_status=='paid'?'bg-success':order.payment_status=='failed'?'bg-danger':'bg-warning'}">

                                    ${order.payment_status}

                                </span>

                            </td>

                            <td>

                                <span class="badge ${order.order_status=='delivered'?'bg-success':order.order_status=='cancelled'?'bg-danger':'bg-primary'}">

                                    ${order.order_status}

                                </span>

                            </td>

                            <td>
                                ${order.created_at}
                            </td>

                            <td>

                                <div class="d-flex gap-2">

                                    <button
                                        class="btn btn-primary btn-sm action-btn editBtn"
                                        data-id="${order.id}"
                                        data-status="${order.order_status}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button
                                        class="btn btn-danger btn-sm action-btn deleteBtn"
                                        data-id="${order.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                     <a 
                                        href="<?= base_url() ?>admin/invoice/${order.id}"
                                        class="btn btn-primary btn-sm ms-1"
                                        target="_blank"
                                        title="Download Invoice"
                                        data-bs-toggle="tooltip">
                                        
                                        <i class="fa fa-download"></i>
                                    </a>

                                </div>

                            </td>

                        </tr>
                    `;

                    });

                }

                $('#orderTable').html(html);

                let pagination = '';

                for (let i = 1; i <= res.totalPages; i++) {

                    pagination += `
                    <li class="page-item ${res.orders.page==i?'active':''}">
                        <a href="#"
                           class="page-link"
                           onclick="loadOrders(${i})">
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

    $(document).on('change', '#limitOrders', function() {

        loadOrders(1);

    });

    $(document).on('click', '.editBtn', function() {

        $('#order_id').val($(this).data('id'));

        $('#order_status').val($(this).data('status'));

        new bootstrap.Modal(
            document.getElementById('updateOrderModal')
        ).show();

    });

    $(document).on('submit', '#updateOrderForm', function(e) {

        e.preventDefault();

        $.ajax({
            url: "<?= base_url('admin/updateorder') ?>",
            type: "PUT",
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN_HASH
            },
            data: JSON.stringify({
                id: $('#order_id').val(),
                order_status: $('#order_status').val()
            }),
            dataType: "json",
            success: function(res) {

                if (res.csrf) {
                    updateCsrf(res.csrf.token, res.csrf.hash);
                }

                bootstrap.Modal.getInstance(
                    document.getElementById('updateOrderModal')
                ).hide();

                showToast(res.message, 'success');

                loadOrders();
            },
            error: function(xhr) {

                if (xhr.responseJSON?.csrf) {
                    updateCsrf(
                        xhr.responseJSON.csrf.token,
                        xhr.responseJSON.csrf.hash
                    );
                }

                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );
            }
        });

    });

    $(document).on('click', '.deleteBtn', function() {

        if (!confirm('Delete this order ?'))
            return;

        let id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('admin/deleteorder') ?>/" + id,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN_HASH
            },
            dataType: "json",
            success: function(res) {

                if (res.csrf) {
                    updateCsrf(res.csrf.token, res.csrf.hash);
                }

                showToast(res.message, 'success');

                loadOrders();
            },
            error: function(xhr) {

                if (xhr.responseJSON?.csrf) {
                    updateCsrf(
                        xhr.responseJSON.csrf.token,
                        xhr.responseJSON.csrf.hash
                    );
                }

                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );
            }
        });

    });
    window.CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
    window.CSRF_TOKEN_HASH = '<?= csrf_hash() ?>';

    $(document).on('click', '.sortColumn', function() {

        let column = $(this).data('column');
         console.log(column);
        if (sortColumn === column) {

            sortDirection = sortDirection === 'ASC' ?
                'DESC' :
                'ASC';
               
        } else {

            sortColumn = column;
            sortDirection = 'ASC';
        }

        loadOrders();
    });

    loadOrders();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>