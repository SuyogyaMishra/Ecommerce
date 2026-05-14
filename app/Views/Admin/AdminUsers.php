<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<style>
    .page-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .stats-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: .3s ease;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-card .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stats-card.total {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
    }

    .stats-card.active {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    }

    .stats-card.admin {
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
    }

    .users-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .table thead th {
        border: none;
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        padding: 18px 15px;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 18px 15px;
        border-color: #f1f5f9;
    }

    .table tbody tr {
        transition: .2s ease;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-box {
        border-radius: 12px;
        border: 1px solid #dbeafe;
        padding: 10px 15px;
        box-shadow: none !important;
    }

    .btn-custom {
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        border-radius: 20px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
    }

    .page-item .page-link {
        border: none;
        margin: 0 4px;
        border-radius: 10px;
        color: #4f46e5;
    }

    .page-item.active .page-link {
        background: #4f46e5;
        color: white;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 12px;
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

                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>

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
<script>
    function loadUsers(page = 1) {
        let keyword = $('#searchUser').val();
        let limit = $('#limitUsers').val();
        console.log("function")
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
                search: keyword
            },

            success: function(res) {
                console.log(res);
                $('#totalUsers').text(res.totalUsers);
                $('#activeUsers').text(res.activeUsers);
                $('#adminUsers').text(res.adminUsers);
                $('#adminName').text(res.user.name);
                $('#adminEmail').text(res.user.email);
                console.log(res);
                let html = '';

                if (res.users.length < 1) {
                    html = `
                <tr>
                    <td colspan="6" class="text-center text-muted p-5">
                        No users found
                    </td>
                </tr>
                `;
                } else {
                    $.each(res.users.users, function(i, user) {

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
                            <span class="badge ${user.status=='active'?'bg-success':'bg-danger'}">
                                ${user.status}
                            </span>
                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <button
                                    class="btn btn-primary btn-sm action-btn editBtn"
                                    data-id="${user.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button
                                    class="btn btn-danger btn-sm action-btn deleteBtn"
                                    data-id="${user.id}">
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

                for (let i = 1; i <= res.totalPages; i++) {
                    pagination += `
                <li class="page-item ${res.users.page==i?'active':''}">
                    <a href="#"
                       class="page-link"
                       onclick="loadUsers(${i})">
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

                $('#user_id').val(res.user.id);
                $('#name').val(res.user.name);
                $('#email').val(res.user.email);
                $('#role').val(res.user.role);
                $('#status').val(res.user.status);

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

                showToast(
                    xhr.responseJSON?.message || 'Something went wrong',
                    'danger'
                );
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

        $('#toastMessage').text(message);

        new bootstrap.Toast(toastEl).show();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection() ?>