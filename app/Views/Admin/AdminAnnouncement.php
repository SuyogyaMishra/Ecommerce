<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<style>
    .notification-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .05)
    }

    .table th {
        font-size: 12px;
        text-transform: uppercase;
        background: #f8fafc
    }

    .table td {
        vertical-align: middle
    }

    .badge-status {
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 11px
    }

    .target-users {
        max-height: 220px;
        overflow: auto;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px
    }
</style>

<div class="main-content flex-grow-1">

    <div class="container-fluid py-4">
        <div class="position-fixed top-0 end-0 p-3" style="z-index:9999">
            <div id="liveToast" class="toast align-items-center text-bg-dark border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body" id="toastMessage"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Announcements</h3>
                <small class="text-muted">Manage notifications & announcements</small>
            </div>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
                <i class="bi bi-plus-circle me-1"></i>Add Announcement
            </button>
        </div>

        <div class="card notification-card">

            <div class="card-body p-0">
                <div class="d-flex justify-content-between align-items-center p-3">

                    <div class="d-flex align-items-center gap-5">

                        <input
                            type="text"
                            class="form-control"
                            id="searchAnnouncement"
                            placeholder="Search announcements..."
                            style="width:250px">

                        <select
                            class="form-select"
                            id="perPageAnnouncement"
                            style="width:120px">

                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>

                        </select>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>

                                <th
                                    class="sortColumn"
                                    data-column="id"
                                    data-callback="loadAnnouncements">

                                    ID <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th
                                    class="sortColumn"
                                    data-column="title"
                                    data-callback="loadAnnouncements">

                                    Title <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th
                                    class="sortColumn"
                                    data-column="message"
                                    data-callback="loadAnnouncements">

                                    Message <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th
                                    class="sortColumn"
                                    data-column="target"
                                    data-callback="loadAnnouncements">

                                    Target <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th
                                    class="sortColumn"
                                    data-column="status"
                                    data-callback="loadAnnouncements">

                                    Status <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th
                                    class="sortColumn"
                                    data-column="start_date"
                                    data-callback="loadAnnouncements">

                                    Start <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th
                                    class="sortColumn"
                                    data-column="end_date"
                                    data-callback="loadAnnouncements">

                                    End <i class="bi bi-arrow-down-up ms-1"></i>

                                </th>

                                <th width="120">
                                    Action
                                </th>

                            </tr>
                        </thead>

                        <tbody id="announcementTable"></tbody>

                    </table>
                    <div
                        class="d-flex justify-content-center py-3"
                        id="announcementPagination">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="announcementModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add Announcement</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form id="announcementForm">

                        <?= csrf_field() ?>
                        <input type="hidden" id="announcement_id">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>

                                <input type="text" class="form-control" name="title" id="title">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>

                                <select class="form-select" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Message</label>

                                <textarea class="form-control" rows="4" name="message" id="message"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start At</label>

                                <input type="datetime-local" class="form-control" name="start_at" id="start_at">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End At</label>

                                <input type="datetime-local" class="form-control" name="end_at" id="end_at">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Target Type</label>

                                <select class="form-select" name="target_type" id="target_type">
                                    <option value="ALL_USERS">All Users</option>
                                    <option value="SPECIFIC_USER">Specific Users</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3 d-none" id="targetUsersBox">
                                <input type="text" class="form-control mb-3" id="userSearch" placeholder="Search users...">

                                <label class="form-label">Select Users</label>

                                <div class="target-users" id="usersList"></div>

                            </div>

                        </div>

                        <button class="btn btn-primary w-100" id="saveBtn">
                            Save Announcement
                        </button>

                        <button type="button" class="btn btn-success w-100 mt-2 d-none" id="updateBtn">
                            Update Announcement
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('resources/script.js') ?>"></script>




<script>
    let keyword, limit = 10;
    let currentPage = 1;;

    function showToast(message, type = 'dark') {
        $('#liveToast').removeClass('text-bg-dark text-bg-success text-bg-danger text-bg-warning').addClass('text-bg-' + type);
        $('#toastMessage').html(message);
        new bootstrap.Toast(document.getElementById('liveToast')).show();
    }

    function getAjaxErrorMessage(xhr) {
        let message = 'Something went wrong';

        if (xhr && xhr.responseJSON) {
            if (xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }

            if (xhr.responseJSON.errors) {
                if (typeof xhr.responseJSON.errors === 'string') {
                    message = xhr.responseJSON.errors;
                } else if (Array.isArray(xhr.responseJSON.errors)) {
                    message = xhr.responseJSON.errors.join('<br>');
                } else if (typeof xhr.responseJSON.errors === 'object') {
                    const values = Object.values(xhr.responseJSON.errors).flat();
                    message = values.join('<br>');
                }
            }
        }

        return message;
    }

    function loadAnnouncements(page = 1) {

        $.ajax({

            url: "<?= base_url('admin/getannouncements') ?>",

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

                let html = '';

                // no data
                if (!res.data || res.data.length < 1) {

                    html = `
        <tr>
            <td colspan="8" class="text-center p-5 text-muted">
                No announcements found
            </td>
        </tr>
        `;

                    $('#announcementTable').html(html);

                    $('#announcementPagination').html('');

                    return;
                }

                // rows
                $.each(res.data, function(i, row) {

                    html += `
        <tr>

            <td>${row.id}</td>

            <td>${row.title}</td>

            <td style="max-width:250px">
                ${row.message}
            </td>

            <td>
                <span class="badge bg-dark">
                    ${row.target_type=='ALL_USERS'
                        ?'All Users'
                        :'Specific Users'}
                </span>
            </td>

            <td>
                <span class="badge ${
                    row.status==1
                        ?'bg-success'
                        :'bg-danger'
                } badge-status">

                    ${row.status==1
                        ?'Active'
                        :'Inactive'}

                </span>
            </td>

            <td>${row.start_at ?? '-'}</td>

            <td>${row.end_at ?? '-'}</td>

            <td>

                <button 
                    class="btn btn-primary btn-sm editBtn"
                    data-id="${row.id}">

                    <i class="bi bi-pencil"></i>

                </button>

                <button
                    class="btn btn-danger btn-sm deleteBtn"
                    data-id="${row.id}">

                    <i class="bi bi-trash"></i>

                </button>

            </td>

        </tr>
        `;
                });

                $('#announcementTable').html(html);

                // pagination
                let pagination = '';

                if (res.totalPages > 1) {

                    // prev button
                    pagination += `
    
    <button
        class="btn btn-sm btn-outline-primary mx-1 paginationBtn"
        data-page="${res.page - 1}"
        ${res.page == 1 ? 'disabled' : ''}>
        
        Prev
        
    </button>
    `;

                    // page numbers
                    for (let i = 1; i <= res.totalPages; i++) {

                        pagination += `
        
        <button
            class="btn btn-sm ${
                i == res.page
                    ? 'btn-primary'
                    : 'btn-outline-primary'
            } mx-1 paginationBtn"
            data-page="${i}">
            
            ${i}
            
        </button>
        `;
                    }

                    // next button
                    pagination += `
    
    <button
        class="btn btn-sm btn-outline-primary mx-1 paginationBtn"
        data-page="${res.page + 1}"
        ${res.page == res.totalPages ? 'disabled' : ''}>
        
        Next
        
    </button>
    `;
                }

                $('#announcementPagination').html(pagination);

            }

        });

    }

    function loadUsers() {
        return $.ajax({

            url: "<?= base_url('admin/allusers') ?>",
            type: "GET",
            dataType: "json",

            success: function(res) {

                let html = '';

                $.each(res.user, function(i, user) {

                    html += `
                <div class="form-check mb-2">
                    <input class="form-check-input target_user" type="checkbox" value="${user.id}" id="user_${user.id}">
                    <label class="form-check-label" for="user_${user.id}">
                        <span class="fw-semibold">${user.name}</span>
                         <small class="text-muted">${user.email}</small>
                    </label>
                </div>
                `;
                });

                $('#usersList').html(html);

            }

        });

    }

    $('#target_type').change(function() {

        if ($(this).val() == 'SPECIFIC_USER') {

            $('#targetUsersBox').removeClass('d-none');

            loadUsers();

        } else {

            $('#targetUsersBox').addClass('d-none');

            $('#usersList').html('');

        }

    });

    $('#announcementForm').submit(function(e) {

        e.preventDefault();

        let users = [];

        $('.target_user:checked').each(function() {
            users.push($(this).val());
        });

        $.ajax({

            url: "<?= base_url('admin/storeannouncement') ?>",

            type: "POST",

            contentType: "application/json",

            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },

            data: JSON.stringify({

                title: $('#title').val(),
                message: $('#message').val(),
                status: $('#status').val(),
                start_at: $('#start_at').val(),
                end_at: $('#end_at').val(),
                target_type: $('#target_type').val(),
                target_ids: users

            }),

            dataType: "json",

            success: function(res) {
                if (res.success === false) {
                    showToast(res.message || 'Save failed', 'danger');
                    return;
                }

                bootstrap.Modal.getInstance(document.getElementById('announcementModal')).hide();

                $('#announcementForm')[0].reset();

                $('#targetUsersBox').addClass('d-none');

                loadAnnouncements();

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

        if (!confirm('Delete announcement?')) return;

        let id = $(this).data('id');

        $.ajax({

            url: "<?= base_url('admin/deleteannouncement') ?>/" + id,

            type: "DELETE",

            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },

            dataType: "json",

            success: function(res) {

                loadAnnouncements();

                alert(res.message);

            }

        });

    });

    $(document).on('click', '.editBtn', async function() {

        let row = $(this).data();

        $('#announcement_id').val(row.id);
        $('#title').val(row.title);
        $('#message').val(row.message);
        $('#status').val(row.status);
        $('#start_at').val(row.start_at?.replace(' ', 'T'));
        $('#end_at').val(row.end_at?.replace(' ', 'T'));
        $('#target_type').val(row.target_type);

        if (row.target_type == 'SPECIFIC_USER') {

            $('#targetUsersBox').removeClass('d-none');

            await loadUsers();


            let ids = row.target_ids ? row.target_ids.toString().split(',') : [];

            ids.forEach(id => {
                $(`#user_${id}`).prop('checked', true);
            });

        }

        $('#saveBtn').addClass('d-none');
        $('#updateBtn').removeClass('d-none');
        $('.modal-title').text('Update Announcement');
        $('#announcementModal').modal('show');

    });
    $('#updateBtn').click(function() {

        let users = [];

        $('.target_user:checked').each(function() {
            users.push($(this).val());
        });

        $.ajax({

            url: "<?= base_url('admin/updateannouncement') ?>/" + $('#announcement_id').val(),

            type: "PUT",

            contentType: "application/json",

            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
            },

            data: JSON.stringify({

                title: $('#title').val(),
                message: $('#message').val(),
                status: $('#status').val(),
                start_at: $('#start_at').val(),
                end_at: $('#end_at').val(),
                target_type: $('#target_type').val(),
                target_ids: users

            }),

            dataType: "json",

            success: function(res) {
                if (res.success === false) {
                    showToast(res.message || 'Update failed', 'danger');
                    return;
                }

                $('#announcementModal').modal('hide');

                $('#announcementForm')[0].reset();

                $('#announcement_id').val('');

                $('#saveBtn').removeClass('d-none');

                $('#updateBtn').addClass('d-none');

                $('.modal-title').text('Add Announcement');

                loadAnnouncements();

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


    $('#announcementModal').on('hidden.bs.modal', function() {

        $('#announcementForm')[0].reset();

        $('#announcement_id').val('');

        $('#usersList').html('');

        $('#targetUsersBox').addClass('d-none');

        $('.target_user').prop('checked', false);

        $('#saveBtn').removeClass('d-none');

        $('#updateBtn').addClass('d-none');

        $('.modal-title').text('Add Announcement');

    });

    loadAnnouncements();

    $('#searchAnnouncement').on('keyup', function() {

        keyword = $(this).val();

        currentPage = 1;

        loadAnnouncements(currentPage);

    });

    $('#perPageAnnouncement').on('change', function() {

        limit = $(this).val();

        currentPage = 1;

        loadAnnouncements(currentPage);

    });

    $(document).on('click', '.paginationBtn', function() {

        currentPage = $(this).data('page');

        loadAnnouncements(currentPage);

    });
</script>

<?= $this->endSection() ?>