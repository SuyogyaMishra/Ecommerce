<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary: #4f46e5;
        --secondary: #7c3aed;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --dark: #0f172a;
        --text: #0f172a;
        --muted: #64748b;
        --border: #e2e8f0;
        --bg: #f8fafc;
        --card: #ffffff;
    }

    .sortable {
        cursor: pointer;
        user-select: none;
        position: relative;
    }

    .sortable:hover {
        color: #4f46e5;
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

    .btn-custom {
        height: 42px;
        border: none;
        border-radius: 12px;
        padding: 0 18px;
        font-size: 13px;
        font-weight: 600
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

    .stats-card.active {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5)
    }

    .stats-card.stock {
        background: linear-gradient(135deg, #fff7ed, #fed7aa)
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

    .users-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .05)
    }

    .users-card .card-header {
        background: #fff;
        border: none;
        padding: 20px 22px
    }

    .users-card h4 {
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

    .product-img {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #e2e8f0
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
        min-height: 400px
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

        .product-img {
            width: 42px;
            height: 42px
        }

    }
</style>

<div class="main-content flex-grow-1">

    <!-- Header -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white text-white">

        <!-- Toast Container -->
        <div class="toast-container position-fixed top-0 end-0 p-3">

            <div
                id="appToast"
                class="toast border-0 shadow-lg text-bg-success"
                role="alert">

                <div class="d-flex">

                    <div class="toast-body" id="toastMessage">
                        Success message
                    </div>

                    <button
                        type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast">
                    </button>

                </div>

            </div>

        </div>
        <div class="card-body p-2">
            <h2 class="fw-bold mb-1 text-black">
                Vendor Management
            </h2>

            <p class="mb-0 opacity-75 text-black">
                Manage vendors and KYC requests
            </p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            Total Vendors
                        </small>

                        <h2 class="fw-bold mb-0" id="totalVendors">
                            0
                        </h2>
                    </div>

                    <div class="fs-1 text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            KYC Requested
                        </small>

                        <h2 class="fw-bold mb-0" id="kycRequested">
                            0
                        </h2>
                    </div>

                    <div class="fs-1 text-success">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <small class="text-muted">
                            KYC Pending
                        </small>

                        <h2 class="fw-bold mb-0" id="kycPending">
                            0
                        </h2>
                    </div>

                    <div class="fs-1 text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                </div>
            </div>
        </div>
        <div class="btn-group">

            <button
                class="btn btn-primary sectionToggle"
                data-table="vendors">

                Vendors
            </button>

            <button
                class="btn btn-outline-primary sectionToggle"
                data-table="kyc">

                Requested KYC
            </button>

        </div>

    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h4 class="fw-bold mb-0"
                        id="tableTitle">

                        Vendors
                    </h4>

                    <small class="text-muted">
                        Manage vendors & KYC requests
                    </small>

                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">

                    <!-- Search -->
                    <input
                        type="text"
                        id="searchVendor"
                        class="form-control search-box"
                        placeholder="Search vendor...">

                    <!-- Limit -->
                    <select
                        id="limitVendor"
                        class="form-select"
                        style="width:90px">

                        <option value="5">
                            5
                        </option>

                        <option
                            value="10"
                            selected>

                            10
                        </option>

                        <option value="25">
                            25
                        </option>

                        <option value="50">
                            50
                        </option>

                    </select>

                </div>

            </div>

        </div>

        <div class="card-body p-0">

            <!-- Vendor Table -->
            <div id="vendorTableWrapper">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th
                                    class="sortable"
                                    data-sort="id">

                                    ID
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="name">

                                    Vendor Name
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="email">

                                    Email
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="status">

                                    Status
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="is_kyc">

                                    KYC Status
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody id="vendorTable">

                            <tr>
                                <td colspan="6" class="text-center p-5">
                                    Loading...
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="p-3 border-top">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <small
                                class="text-muted"
                                id="paginationInfo">

                            </small>

                            <ul
                                class="pagination mb-0"
                                id="vendorPagination">

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Requested KYC Table -->
            <div id="kycTableWrapper" style="display:none;">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th
                                    class="sortable"
                                    data-sort="id">

                                    ID
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="name">

                                    Vendor Name
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="email">

                                    Email
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>

                                <th
                                    class="sortable"
                                    data-sort="status">

                                    Status
                                    <i class="bi bi-arrow-down-up ms-1 sort-icon"></i>
                                </th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody id="kycTable">

                            <tr>
                                <td colspan="5" class="text-center p-5">
                                    Loading...
                                </td>
                            </tr>

                        </tbody>

                    </table>
                    <div class="p-3 border-top">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <small
                                class="text-muted"
                                id="kycPaginationInfo">
                            </small>

                            <ul
                                class="pagination mb-0"
                                id="kycPagination">
                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Update Vendor Modal -->
<div class="modal fade" id="updateVendorModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    Update Vendor
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="updateVendorId">

                <div class="mb-3">
                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="updateVendorName">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        id="updateVendorEmail">
                </div>

                <div class="mb-3">

                    <label class="form-label d-block">
                        Status
                    </label>

                    <div class="form-check form-switch">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="updateVendorStatus">

                        <label class="form-check-label">
                            Active / Inactive
                        </label>

                    </div>

                </div>

            </div>

            <div class="modal-footer border-0">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancel
                </button>

                <button
                    class="btn btn-primary"
                    id="saveVendorBtn">

                    Save Changes
                </button>

            </div>

        </div>

    </div>

</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteVendorModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold text-danger">
                    Delete Vendor
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p class="mb-0">
                    Are you sure you want to delete this vendor?
                </p>

                <input type="hidden" id="deleteVendorId">

            </div>

            <div class="modal-footer border-0">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancel
                </button>

                <button
                    class="btn btn-danger"
                    id="confirmDeleteVendor">

                    Delete
                </button>

            </div>

        </div>

    </div>

</div>


<!-- KYC Modal -->
<div class="modal fade" id="kycModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Vendor KYC Details
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <input
                    type="hidden"
                    id="kycVendorId">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Vendor Name
                        </label>

                        <p id="vName" class="mb-0">
                            -
                        </p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Document Name
                        </label>

                        <p id="docName" class="mb-0">
                            -
                        </p>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold">
                            Document Number
                        </label>

                        <p id="docNumber" class="mb-0">
                            -
                        </p>

                    </div>

                </div>

                <!-- Aadhaar Image -->
                <div class="mb-4">

                    <label class="fw-bold d-block mb-2">
                        Aadhaar Image
                    </label>

                    <img
                        id="aadhaarPhoto"
                        src=""
                        class="img-fluid rounded border w-100"
                        style="max-height:300px; object-fit:contain">

                </div>

                <!-- Remark -->
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Remark
                    </label>

                    <textarea
                        id="kycRemark"
                        class="form-control"
                        rows="3"
                        placeholder="Enter remark (optional)">
                    </textarea>

                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Close
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="rejectKycBtn">

                    Reject
                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    id="verifyKycBtn">

                    Verify
                </button>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let vendorList = [];
    let currentPage = 1;

    let limit = 10;

    let searchKeyword = '';

    let sortColumn = 'id';

    let sortDirection = 'DESC';

    let currentTable = 'vendors';

    const updateModal = new bootstrap.Modal(
        document.getElementById('updateVendorModal')
    );

    const kycModal = new bootstrap.Modal(
        document.getElementById('kycModal')
    );

    const deleteModal = new bootstrap.Modal(
        document.getElementById('deleteVendorModal')
    );

    function loadDashboard(
        page = 1
    ) {

        $.ajax({

            url: "<?= base_url('admin/vendordata') ?>",

            type: "GET",

            data: {

                page: page,

                limit: $('#limitVendor')
                    .val(),

                keyword: $('#searchVendor')
                    .val(),

                sortColumn: sortColumn,

                sortDirection: sortDirection,

                table: currentTable
            },

            dataType: "json",

            success: function(res) {

                $('#totalVendors')
                    .text(
                        res.totalVendors
                    );

                $('#kycRequested')
                    .text(
                        res.kycRequested
                    );

                $('#kycPending')
                    .text(
                        res.kycPending
                    );

                if (
                    currentTable ===
                    'vendors'
                ) {

                    vendorList =
                        res.vendors;

                    renderVendorTable(
                        vendorList
                    );

                } else {

                    renderKycTable(
                        res.pendingKyc
                    );
                }

                renderPagination({
                    totalPages: res.totalPages
                });
            },

            error: function() {

                showToast(
                    'Failed to load dashboard',
                    'error'
                );
            }
        });
    }

    // Render Vendor Table
    function renderVendorTable(data) {

        let html = '';

        if (data.length < 1) {

            html = `
                <tr>
                    <td colspan="6"
                        class="text-center text-muted p-5">

                        No Vendors Found
                    </td>
                </tr>
            `;

        } else {
            console.log(data);

            data.forEach(vendor => {

                html += `
                    <tr>

                        <td>${vendor.id}</td>

                        <td>
                            <strong>
                                ${vendor.name}
                            </strong>
                        </td>

                        <td>
                            ${vendor.email}
                        </td>

                        <td>

                            <span class="badge bg-${
                                vendor.status == 1
                                ? 'success'
                                : 'danger'
                            }">

                                ${
                                    vendor.status == 1
                                    ? 'Active'
                                    : 'Inactive'
                                }

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-${
                                vendor.is_kyc == 2
                                ? 'success'
                                : vendor.is_kyc == 3
                                ? 'danger'
                                : vendor.is_kyc == 1
                                ? 'primary'
                                : 'warning'
                            }">

                                ${
                                    vendor.is_kyc == 0
                                    ? 'Pending'
                                    : vendor.is_kyc == 1
                                    ? 'Requested'
                                    : vendor.is_kyc == 2
                                    ? 'Done'
                                    : 'Rejected'
                                }

                            </span>

                        </td>

                        <td>

                           <div class="d-flex gap-2">

                                <button
                                    class="btn btn-sm btn-primary updateVendor"
                                    data-id="${vendor.id}"
                                    title="Update">

                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button
                                    class="btn btn-sm btn-danger deleteVendor"
                                    data-id="${vendor.id}"
                                    title="Delete">

                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>
                `;
            });
        }

        $('#vendorTable').html(html);
    }

    // Render Requested KYC Table
    function renderKycTable(data) {

        let html = '';

        if (data.length < 1) {

            html = `
                <tr>
                    <td colspan="5"
                        class="text-center text-muted p-5">

                        No Requested KYC
                    </td>
                </tr>
            `;

        } else {

            data.forEach(vendor => {

                html += `
                    <tr>

                        <td>${vendor.id}</td>

                        <td>
                            ${vendor.name}
                        </td>

                        <td>
                            ${vendor.email}
                        </td>

                        <td>

                            <span class="badge bg-warning">
                                Pending
                            </span>

                        </td>

                        <td>

                            <button
                                class="btn btn-dark btn-sm kycActionBtn"
                                data-id="${vendor.id}">

                                Action
                            </button>

                        </td>

                    </tr>
                `;
            });
        }

        $('#kycTable').html(html);
    }

    // Toggle Tables
    $(document).on(
        'click',
        '.sectionToggle',
        function() {

            let table =
                $(this)
                .data('table');

            currentTable =
                table;

            currentPage = 1;

            $('.sectionToggle')
                .removeClass('btn-primary')
                .addClass(
                    'btn-outline-primary'
                );

            $(this)
                .removeClass(
                    'btn-outline-primary'
                )
                .addClass('btn-primary');

            // Toggle table wrapper
            if (
                table === 'vendors'
            ) {

                $('#vendorTableWrapper')
                    .show();

                $('#kycTableWrapper')
                    .hide();

                $('#tableTitle')
                    .text('Vendors');

            } else {

                $('#vendorTableWrapper')
                    .hide();

                $('#kycTableWrapper')
                    .show();

                $('#tableTitle')
                    .text(
                        'Requested KYC'
                    );
            }

            loadDashboard(
                currentPage
            );
        }
    );
    // Open Update Modal
    $(document).on(
        'click',
        '.updateVendor',
        function() {

            let id =
                $(this).data('id');

            let vendor =
                vendorList.find(
                    v => v.id == id
                );

            if (!vendor) return;

            $('#updateVendorId')
                .val(vendor.id);

            $('#updateVendorName')
                .val(vendor.name);

            $('#updateVendorEmail')
                .val(vendor.email);

            $('#updateVendorStatus')
                .prop(
                    'checked',
                    vendor.status == 1
                );

            $('#updateVendorKyc')
                .val(
                    vendor.kyc_status
                );

            updateModal.show();
        }
    );

    // Save Vendor
    $('#saveVendorBtn')
        .on('click', function() {

            let payload = {

                id: $('#updateVendorId')
                    .val(),

                name: $('#updateVendorName')
                    .val(),

                email: $('#updateVendorEmail')
                    .val(),

                status: $('#updateVendorStatus')
                    .is(':checked') ?
                    1 : 0,

                kyc_status: $('#updateVendorKyc')
                    .val()
            };

            console.log(payload);


            $.ajax({
                url: 'update/vendor',
                type: 'put',
                data: payload,
                success: function(res) {
                    showToast(res.message);
                    updateModal.hide();
                    loadDashboard();
                }
            });


            updateModal.hide();
        });

    // Open Delete Modal
    $(document).on(
        'click',
        '.deleteVendor',
        function() {

            let id =
                $(this).data('id');

            $('#deleteVendorId')
                .val(id);

            deleteModal.show();
        }
    );

    // Confirm Delete
    $('#confirmDeleteVendor')
        .on('click', function() {

            let id =
                $('#deleteVendorId')
                .val();

            console.log(id);

            $.ajax({
                url: 'delete/vendor',
                type: 'DELETE',
                data: {
                    id
                },
                success: function(res) {
                    showToast(res.message);
                    deleteModal.hide();
                    loadDashboard();
                }
            });


            deleteModal.hide();
        });

    // Requested KYC Action
    $(document).on(
        'click',
        '.kycActionBtn',
        function() {

            let id = $(this).data('id');

            $.ajax({

                url: "<?= base_url('admin/kyc/details') ?>",

                type: "GET",

                data: {
                    id: id
                },

                dataType: "json",

                success: function(res) {

                    if (!res.status) {
                        showToast(res.message, 'error');
                        return;
                    }
                    $('#kycVendorId').val(res.data.vendor_id);
                    $('#vName').text(
                        res.data.name
                    );

                    $('#docName').text(
                        res.data.doc_name
                    );

                    $('#docNumber').text(
                        res.data.doc_number
                    );

                    $('#aadhaarPhoto').attr(
                        'src',
                        "<?= base_url() ?>" + res.data.path
                    );
                    console.log(res.data.path);
                    kycModal.show();
                },

                error: function() {
                    showToast(
                        'Failed to load KYC details',
                        'error'
                    );
                }
            });
        }
    );

    // Init
    loadDashboard();
</script>

<script>
    function showToast(
        message,
        type = 'success'
    ) {

        let toast =
            $('#appToast');

        let classes = {
            success: 'text-bg-success',
            error: 'text-bg-danger',
            warning: 'text-bg-warning',
            info: 'text-bg-primary'
        };

        toast.removeClass(
            'text-bg-success text-bg-danger text-bg-warning text-bg-primary'
        );

        toast.addClass(
            classes[type]
        );

        $('#toastMessage')
            .text(message);

        let bsToast =
            new bootstrap.Toast(
                document.getElementById('appToast'), {
                    delay: 3000
                }
            );

        bsToast.show();
    }


    $(document).on(
        'click',
        '.sortable',
        function() {

            let column =
                $(this)
                .data('sort');

            // Same column clicked
            if (
                sortColumn ===
                column
            ) {

                sortDirection =
                    sortDirection ===
                    'ASC' ?
                    'DESC' :
                    'ASC';

            } else {

                // New column
                sortColumn =
                    column;

                sortDirection =
                    'ASC';
            }

            currentPage = 1;

            updateSortIcons();

            loadDashboard(
                currentPage
            );
        }
    );



    function updateSortIcons() {

        $('.sort-icon')
            .removeClass(
                'bi-arrow-up bi-arrow-down'
            )
            .addClass(
                'bi-arrow-down-up'
            );

        let selectedColumn =
            $(
                `[data-sort="${sortColumn}"]`
            );

        selectedColumn
            .find('i')
            .removeClass(
                'bi-arrow-down-up'
            )
            .addClass(

                sortDirection ===
                'ASC'

                ?
                'bi-arrow-up'

                :
                'bi-arrow-down'
            );
    }


    // Pagination render
    function renderPagination(
        pagination
    ) {

        let totalPages =
            pagination.totalPages || 1;

        let html = '';

        // Previous
        html += `
        <li class="page-item
            ${
                currentPage === 1
                ? 'disabled'
                : ''
            }">

            <a
                class="page-link pageBtn"
                href="#"
                data-page="${
                    currentPage - 1
                }">

                <i class="bi bi-chevron-left"></i>

            </a>
        </li>
    `;

        // Pages
        for (
            let i = 1; i <= totalPages; i++
        ) {

            html += `
            <li class="page-item
                ${
                    currentPage == i
                    ? 'active'
                    : ''
                }">

                <a
                    href="#"
                    class="page-link pageBtn"
                    data-page="${i}">

                    ${i}

                </a>
            </li>
        `;
        }

        // Next
        html += `
        <li class="page-item
            ${
                currentPage ===
                totalPages
                ? 'disabled'
                : ''
            }">

            <a
                class="page-link pageBtn"
                href="#"
                data-page="${
                    currentPage + 1
                }">

                <i class="bi bi-chevron-right"></i>

            </a>
        </li>
    `;

        let paginationId =
            currentTable === 'vendors' ?
            '#vendorPagination' :
            '#kycPagination';

        let infoId =
            currentTable === 'vendors' ?
            '#paginationInfo' :
            '#kycPaginationInfo';

        $(paginationId)
            .html(html);

        $(infoId)
            .text(
                `Page ${currentPage}
        of ${totalPages}`
            );

    }


    $(document).on(
        'click',
        '.pageBtn',
        function(e) {

            e.preventDefault();

            let page =
                parseInt(
                    $(this)
                    .data('page')
                );

            if (
                page < 1
            ) return;

            currentPage =
                page;

            loadDashboard(
                currentPage
            );
        }
    );


    $('#limitVendor')
        .on(
            'change',
            function() {

                currentPage = 1;

                limit =
                    $(this)
                    .val();

                loadDashboard(
                    currentPage
                );
            }
        );

    let searchTimer;

    $('#searchVendor')
        .on(
            'keyup',
            function() {

                clearTimeout(
                    searchTimer
                );

                searchTimer =
                    setTimeout(
                        function() {

                            currentPage = 1;

                            loadDashboard(
                                currentPage
                            );

                        },
                        400
                    );
            }
        );
</script>

<script>
    function updateKycStatus(status) {

        $.ajax({

            url: "<?= base_url('admin/updatekyc') ?>",

            type: "Put",

            dataType: "json",

            data: {

                vendor_id: $('#kycVendorId').val(),

                remark: $('#kycRemark').val(),

                status: status
            },

            beforeSend: function() {

                $('#verifyKycBtn, #rejectKycBtn')
                    .prop('disabled', true);
            },

            success: function(res) {

                if (res.status) {

                    showToast(
                        res.message,
                        'success'
                    );

                    kycModal.hide();

                    $('#kycRemark').val('');

                    loadDashboard();

                } else {

                    showToast(
                        res.message,
                        'error'
                    );
                }
            },

            error: function(res) {
            console.log(res);
                showToast(
                    res.responseJSON?.message || 'Something went wrong',
                    'error'
                );
            },

            complete: function() {

                $('#verifyKycBtn, #rejectKycBtn')
                    .prop('disabled', false);
            }
        });
    }


    $(document).on(
        'click',
        '#verifyKycBtn',
        function() {

            updateKycStatus(2);
        }
    );


    $(document).on(
        'click',
        '#rejectKycBtn',
        function() {

            updateKycStatus(3);
        }
    );
</script>

<?= $this->endSection() ?>