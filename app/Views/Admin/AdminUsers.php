<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>
<style>
    :root {
        --primary: #6366f1;
        --secondary: #8b5cf6;
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

    body {
        background: var(--bg);
        color: var(--text);
        font-family: Inter, sans-serif;
        overflow-x: hidden
    }

    .main-content {
        min-height: 100vh;
        padding: 22px
    }

    .container-fluid {
        max-width: 1380px
    }

    .page-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 20px;
        color: #fff;
        box-shadow: 0 10px 25px rgba(99, 102, 241, .18)
    }

    .page-header h2 {
        font-size: 24px;
        margin-bottom: 6px
    }

    .page-header p {
        font-size: 13px;
        opacity: .9
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
        background: var(--card);
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

    .stats-card.admin {
        background: linear-gradient(135deg, #f5f3ff, #ede9fe)
    }

    .stats-card .card-body {
        padding: 18px !important
    }

    .stats-card p {
        font-size: 12px;
        margin-bottom: 5px;
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
        background: var(--card);
        box-shadow: 0 4px 18px rgba(15, 23, 42, .05)
    }

    .users-card .card-header {
        background: #fff;
        padding: 20px 22px;
        border: none
    }

    .users-card h4 {
        font-size: 18px;
        margin-bottom: 2px
    }

    .users-card small {
        font-size: 12px
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
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .08)
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

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0
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
        color: #4f46e5;
        background: #eef2ff;
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
        box-shadow: 0 15px 40px rgba(15, 23, 42, .12)
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
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .08)
    }

    .form-label {
        font-size: 13px;
        margin-bottom: 7px
    }

    .btn-custom {
        height: 46px;
        border: none;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        background: linear-gradient(135deg, #4f46e5, #7c3aed)
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

    <!-- HEADER -->

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-2">
                <i class="bi bi-people-fill me-2"></i>
                Users Management
            </h2>

            <p class="mb-0 opacity-75">
                Manage all users, roles and permissions easily 🚀
            </p>
        </div>

        <!-- <button class="btn btn-light btn-custom shadow-sm">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Add User
        </button> -->
    </div>

    <!-- STATS -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card stats-card total shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">Total Users</p>
                        <h2 class="fw-bold mb-0" id="totalUsers">0</h2>
                    </div>

                    <div class="icon-box bg-primary text-white">
                        <i class="bi bi-people-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stats-card active shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">Active Users</p>
                        <h2 class="fw-bold mb-0" id="activeUsers">0</h2>
                    </div>

                    <div class="icon-box bg-success text-white">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stats-card admin shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">Admin Users</p>
                        <h2 class="fw-bold mb-0" id="adminUsers">0</h2>
                    </div>

                    <div class="icon-box bg-dark text-white">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- TABLE CARD -->
    <div class="card users-card shadow-sm">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h4 class="mb-1 fw-bold">
                        Users List
                    </h4>

                    <small class="text-muted">
                        Search, edit and manage users
                    </small>
                </div>

                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                    <input
                        type="text"
                        class="form-control search-box ps-5"
                        id="searchUser"
                        placeholder="Search user...">
                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Users
                </h5>
            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>

                            <th
                                class="sortColumn"
                                data-column="id"
                                data-callback="loadUsers">

                                ID <i class="bi bi-arrow-down-up ms-1"></i>

                            </th>

                            <th
                                class="sortColumn"
                                data-column="name"
                                data-callback="loadUsers">

                                Name <i class="bi bi-arrow-down-up ms-1"></i>

                            </th>

                            <th
                                class="sortColumn"
                                data-column="email"
                                data-callback="loadUsers">

                                Email <i class="bi bi-arrow-down-up ms-1"></i>

                            </th>

                            <th
                                class="sortColumn"
                                data-column="role"
                                data-callback="loadUsers">

                                Role <i class="bi bi-arrow-down-up ms-1"></i>

                            </th>

                            <th
                                class="sortColumn"
                                data-column="status"
                                data-callback="loadUsers">

                                Status <i class="bi bi-arrow-down-up ms-1"></i>

                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="userTable"></tbody>

                </table>

                <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-2">

                    <ul class="pagination mb-0" id="pagination"></ul>

                    <div class="d-flex align-items-center gap-2">

                        <small class="text-muted">Show</small>

                        <select id="limitUsers" class="form-select form-select-sm" style="width:90px;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>

                        <small class="text-muted">users</small>

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>

<!-- UPDATE USER MODAL -->
<div class="modal fade" id="updateUserModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>
                    Update User
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <form id="updateUserForm">

                    <?= csrf_field() ?>

                    <input
                        type="hidden"
                        id="user_id"
                        name="user_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>

                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>

                        <select
                            class="form-select"
                            id="role"
                            name="role">

                            <option value="user">User</option>
                            <option value="admin">Admin</option>

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>

                        <select
                            class="form-select"
                            id="status"
                            name="status">

                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100 btn-custom">

                        <i class="bi bi-check-circle-fill me-2"></i>
                        Update User

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('resources/script.js') ?>"></script>

<script>
    function loadUsers(page = 1) {
        let keyword = $('#searchUser').val();
        let limit = $('#limitUsers').val();
        console.log(sortColumn,
            sortDirection);
        $('#userTable').html(`
    <tr>
        <td colspan="6" class="text-center p-5">
            <div class="spinner-border text-primary"></div>
        </td>
    </tr>
    `);

        $.ajax({

            url: "<?= base_url('admin/userdata') ?>",

            type: "GET",

            dataType: "json",

            data: {
                page: page,
                limit: limit,
                search: keyword,
                column: sortColumn,
                direction: sortDirection


            },

            success: function(res) {

                $('#totalUsers').text(res.data.totalUsers);
                $('#activeUsers').text(res.data.activeUsers);
                $('#adminUsers').text(res.data.adminUsers);

                $('#adminName').text(res.data.user.name);
                $('#adminEmail').text(res.data.user.email);

                let users = res.data.users.users;
                let currentPage = res.data.users.page;
                let totalPages = res.data.totalPages;

                let html = '';

                if (users.length < 1) {

                    html = `
        <tr>
            <td colspan="6" class="text-center text-muted p-5">
                No users found
            </td>
        </tr>
        `;

                } else {

                    $.each(users, function(i, user) {

                        html += `
            <tr>

                <td>${user.id}</td>

                <td>
                    <div class="d-flex align-items-center gap-3">

                        <div class="user-avatar">
                            ${user.name.charAt(0).toUpperCase()}
                        </div>

                        <div>
                            <div class="fw-semibold">
                                ${user.name}
                            </div>
                        </div>

                    </div>
                </td>

                <td>${user.email}</td>

                <td>
                    <span class="badge ${user.role=='admin'?'bg-dark':'bg-primary'}">
                        ${user.role}
                    </span>
                </td>

                <td>
                    <span class="badge ${user.status=='1'?'bg-success':'bg-danger'}">
                        ${user.status=='1'?'active':'inactive'}
                    </span>
                </td>

                <td>

                    <div class="d-flex gap-2">

                        <button class="btn btn-primary btn-sm action-btn editBtn" data-id="${user.id}">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="btn btn-danger btn-sm action-btn deleteBtn" data-id="${user.id}">
                            <i class="bi bi-trash"></i>
                        </button>

                    </div>

                </td>

            </tr>
            `;
                    });
                }

                $('#userTable').html(html);

                let pagination = '';

                for (let i = 1; i <= totalPages; i++) {

                    pagination += `
        <li class="page-item ${currentPage==i?'active':''}">
            <a href="javascript:void(0)" class="page-link" onclick="loadUsers(${i})">
                ${i}
            </a>
        </li>
        `;
                }

                $('#pagination').html(pagination);
            },

            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.href = "<?= base_url('loginform') ?>";
                }

                $('#userTable').html(`
            <tr>
                <td colspan="6" class="text-center text-danger p-5">
                    Failed to load users
                </td>
            </tr>
            `);
            }

        });
    }

    function searchUser(keyword) {
        $.ajax({

            url: "<?= base_url('admin/searchuser') ?>/" + keyword,

            type: "GET",

            dataType: "json",

            success: function(res) {

                let html = '';
                console.log(res.data);
                if (res.data.length < 1) {

                    html = `
                <tr>
                    <td colspan="6" class="text-center p-5">
                        No users found
                    </td>
                </tr>
                `;

                } else {

                    $.each(res.data, function(i, user) {

                        html += `
                    <tr>

                        <td>${user.id}</td>

                        <td>${user.name}</td>

                        <td>${user.email}</td>

                        <td>${user.role}</td>

                        <td>
                            ${user.status==1?'Active':'Inactive'}
                        </td>

                        <td>

                            <button
                                class="btn btn-primary btn-sm editBtn"
                                data-id="${user.id}">
                                Edit
                            </button>

                        </td>

                    </tr>
                    `;
                    });
                }

                $('#userTable').html(html);
            }
        });
    }

    let timer;

    $(document).on('keyup', '#searchUser', function() {

        clearTimeout(timer);

        let keyword = $(this).val().trim();
        console.log(keyword);
        timer = setTimeout(function() {

            if (keyword == '') {

                loadUsers();

            } else {

                searchUser(keyword);

            }

        }, 300);

    });

    $(document).on('change', '#limitUsers', function() {
        loadUsers(1);
    });

    loadUsers();
    $(document).on('click', '.editBtn', function() {

        let id = $(this).data('id');

        $.ajax({

            url: "<?= base_url('admin/getuser') ?>/" + id,

            type: "GET",

            dataType: "json",

            success: function(res) {

                $('#user_id').val(res.data.id);
                $('#name').val(res.data.name);
                $('#email').val(res.data.email);
                $('#role').val(res.data.role);
                $('#status').val(res.data.status);

                let modal = new bootstrap.Modal(
                    document.getElementById('updateUserModal')
                );

                modal.show();
            }
        });

    });

    $(document).on('submit', '#updateUserForm', function(e) {

        e.preventDefault();

        let id = $('#user_id').val();

        $.ajax({

            url: "<?= base_url('admin/updateuser') ?>",

            type: "PUT",

            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },

            data: JSON.stringify({
                id: $('#user_id').val(),
                name: $('#name').val(),
                email: $('#email').val(),
                role: $('#role').val(),
                status: $('#status').val()
            }),

            dataType: "json",

            success: function(res) {
                bootstrap.Modal.getInstance(
                    document.getElementById('updateUserModal')
                ).hide();

                loadUsers();

                showToast(res.message, 'success');
            },

            error: function(xhr) {

                let message = 'Something went wrong';

                if (xhr.responseJSON) {

                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    if (xhr.responseJSON.errors) {

                        let errors = xhr.responseJSON.errors.errors || xhr.responseJSON.errors;

                        if (typeof errors === 'object') {
                            message = Object.values(errors).join('<br>');
                        } else {
                            message = errors;
                        }

                    }

                }

                showToast(message, 'danger');
            }

        });

    });

    $(document).on('click', '.deleteBtn', function() {

        if (!confirm('Delete this user?'))
            return;

        let id = $(this).data('id');

        $.ajax({

            url: "<?= base_url('admin/deleteuser') ?>/" + id,

            type: "DELETE",

            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },

            success: function(res) {

                loadUsers();

                showToast(res.message, 'success');
            },

            error: function(xhr) {
                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );
            }

        });

    });

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

        $('#toastMessage').html(message);

        new bootstrap.Toast(toastEl).show();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection() ?>