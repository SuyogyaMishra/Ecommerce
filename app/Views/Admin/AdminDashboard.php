<?= $this->extend('layouts/sidebar') ?>
<?= $this->section('content') ?>

<style>
    .container-fluid.py-4{
    max-width:1400px;
    margin:auto;
    padding-top:22px!important
}

.dashboard-title{
    font-size:22px
}

.dashboard-subtitle{
    font-size:12px
}

.glass-nav{
    padding:14px 22px!important
}

.stats-card{
    border-radius:18px;
    box-shadow:0 4px 16px rgba(15,23,42,.05)
}

.stats-card .card-body{
    padding:18px!important
}

.stats-label{
    font-size:12px;
    margin-bottom:4px
}

.stats-value{
    font-size:24px;
    line-height:1
}

.stats-icon{
    width:52px;
    height:52px;
    border-radius:16px;
    font-size:20px
}

.row.g-4{
    --bs-gutter-x:1rem;
    --bs-gutter-y:1rem
}

.data-card{
    border-radius:18px;
    box-shadow:0 4px 16px rgba(15,23,42,.05)
}

.data-card .card-header{
    padding:18px 20px 8px
}

.section-title{
    font-size:18px
}

.custom-search{
    height:40px;
    border-radius:12px;
    font-size:13px;
    padding-left:38px;
    width:240px
}

.search-wrap i{
    font-size:13px
}

.table thead th{
    font-size:11px;
    padding:14px 20px
}

.table tbody td{
    padding:14px 20px;
    font-size:13px
}

.user-avatar{
    width:34px;
    height:34px;
    font-size:12px
}

.role-badge,
.status-badge{
    padding:6px 12px;
    font-size:11px
}

.theme-btn{
    width:40px;
    height:40px;
    border-radius:12px;
    font-size:14px
}

.toast{
    border-radius:12px!important
}

@media(max-width:768px){

    .stats-value{
        font-size:20px
    }

    .stats-icon{
        width:46px;
        height:46px;
        font-size:18px
    }

    .custom-search{
        width:100%
    }

    .table tbody td,
    .table thead th{
        padding:12px
    }

}
:root{
    --primary:#6366f1;
    --secondary:#8b5cf6;
    --success:#10b981;
    --warning:#f59e0b;
    --danger:#ef4444;
    --dark:#0f172a;
    --card:#ffffff;
    --border:#e2e8f0;
    --text:#0f172a;
    --muted:#64748b;
    --bg:#f8fafc;
}

body{
    background:var(--bg);
    font-family:Inter,sans-serif;
    overflow-x:hidden
}

body.dark-mode{
    --bg:#020617;
    --card:#0f172a;
    --border:#1e293b;
    --text:#f8fafc;
    --muted:#94a3b8
}

.main-content{
    min-height:100vh;
    background:var(--bg);
    transition:.3s
}

.glass-nav{
    backdrop-filter:blur(18px);
    background:rgba(255,255,255,.7)!important;
    border-bottom:1px solid rgba(255,255,255,.2)
}

.dark-mode .glass-nav{
    background:rgba(15,23,42,.85)!important
}

.dashboard-title{
    font-size:28px;
    font-weight:800;
    color:var(--text)
}

.dashboard-subtitle{
    color:var(--muted);
    font-size:14px
}

.theme-btn{
    width:46px;
    height:46px;
    border-radius:14px;
    border:none;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:#fff;
    transition:.3s
}

.theme-btn:hover{
    transform:translateY(-2px) scale(1.04)
}

.stats-card{
    background:var(--card);
    border:none;
    border-radius:24px;
    overflow:hidden;
    position:relative;
    transition:.35s;
    box-shadow:0 10px 30px rgba(15,23,42,.06)
}

.stats-card:hover{
    transform:translateY(-6px)
}

.stats-card::before{
    content:'';
    position:absolute;
    inset:0;
    background:linear-gradient(135deg,rgba(99,102,241,.08),rgba(139,92,246,.04));
    pointer-events:none
}

.stats-icon{
    width:70px;
    height:70px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    color:#fff
}

.icon-users{
    background:linear-gradient(135deg,#3b82f6,#6366f1)
}

.icon-products{
    background:linear-gradient(135deg,#10b981,#14b8a6)
}

.icon-orders{
    background:linear-gradient(135deg,#f59e0b,#f97316)
}

.stats-label{
    color:var(--muted);
    font-weight:600;
    margin-bottom:6px
}

.stats-value{
    font-size:34px;
    font-weight:800;
    color:var(--text)
}

.data-card{
    background:var(--card);
    border:none;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06)
}

.data-card .card-header{
    background:transparent;
    border:none;
    padding:24px 24px 10px
}

.section-title{
    font-size:22px;
    font-weight:700;
    color:var(--text)
}

.table{
    margin:0
}

.table thead th{
    border:none;
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:.5px;
    color:var(--muted);
    background:transparent;
    padding:18px 24px
}

.table tbody td{
    padding:18px 24px;
    vertical-align:middle;
    border-color:var(--border);
    color:var(--text);
    font-weight:500
}

.table tbody tr{
    transition:.25s
}

.table tbody tr:hover{
    background:rgba(99,102,241,.05)
}

.user-avatar{
    width:42px;
    height:42px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-weight:700;
    font-size:14px
}

.role-badge{
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700
}

.role-admin{
    background:rgba(99,102,241,.12);
    color:var(--primary)
}

.role-user{
    background:rgba(14,165,233,.12);
    color:#0284c7
}

.status-badge{
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700
}

.status-active{
    background:rgba(16,185,129,.12);
    color:var(--success)
}

.status-inactive{
    background:rgba(239,68,68,.12);
    color:var(--danger)
}

.custom-search{
    height:48px;
    border-radius:14px;
    border:1px solid var(--border);
    background:transparent;
    color:var(--text);
    padding-left:42px
}

.custom-search:focus{
    box-shadow:none;
    border-color:var(--primary)
}

.search-wrap{
    position:relative
}

.search-wrap i{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:var(--muted)
}

.table-responsive{
    border-radius:0 0 24px 24px
}

.loading-box{
    padding:50px 0
}

.toast{
    border-radius:16px!important;
    overflow:hidden
}

.dark-mode .table{
    --bs-table-bg:transparent;
    --bs-table-color:#fff;
    --bs-table-border-color:#1e293b
}

.dark-mode .table tbody tr:hover{
    background:rgba(255,255,255,.03)
}
</style>

<div class="main-content flex-grow-1">

    <nav class="navbar glass-nav navbar-expand-lg px-4 py-3 sticky-top">

        <div class="container-fluid">

            <div>

                <div class="dashboard-title">Admin Dashboard</div>

                <div class="dashboard-subtitle">Monitor users, products and orders in real time</div>

            </div>

            <button class="theme-btn" id="darkModeBtn">
                <i class="bi bi-moon-stars-fill"></i>
            </button>

        </div>

    </nav>

    <div class="container-fluid py-4">

        <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

        <div class="row g-4 mb-4">

            <div class="col-lg-4">

                <div class="stats-card">

                    <div class="card-body p-4 d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stats-label">Total Users</div>

                            <div class="stats-value" id="totalUsers">0</div>

                        </div>

                        <div class="stats-icon icon-users">
                            <i class="bi bi-people-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="stats-card">

                    <div class="card-body p-4 d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stats-label">Total Products</div>

                            <div class="stats-value" id="totalProducts">0</div>

                        </div>

                        <div class="stats-icon icon-products">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="stats-card">

                    <div class="card-body p-4 d-flex align-items-center justify-content-between">

                        <div>

                            <div class="stats-label">Total Orders</div>

                            <div class="stats-value" id="totalOrders">0</div>

                        </div>

                        <div class="stats-icon icon-orders">
                            <i class="bi bi-cart-check-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="data-card">

            <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

                <div>

                    <div class="section-title">Recent Users</div>

                    <small class="text-secondary">Latest registered users overview</small>

                </div>


            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                    <tr>

                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody id="userTable"></tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

function showToast(message,type='success')
{
    let bg=type=='success'?'bg-success':'bg-danger';

    $('.toast-container').append(`
    <div class="toast text-white ${bg} border-0 show mb-3 shadow-lg">
        <div class="d-flex align-items-center">
            <div class="toast-body fw-semibold">${message}</div>
            <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>`);

    setTimeout(()=>$('.toast').fadeOut(300,function(){$(this).remove()}),3000);
}

function loadUsers(page=1)
{
    let keyword=$('#searchUser').val();

    $('#userTable').html(`
    <tr>
        <td colspan="5" class="text-center loading-box">
            <div class="spinner-border text-primary"></div>
        </td>
    </tr>`);

    $.ajax({

        url:"<?= base_url('admin/dashboarddata') ?>",

        type:"GET",

        dataType:"json",

        data:{
            page:page,
            search:keyword
        },

        success:function(res){

            $('#totalUsers').text(res.totalUsers);
            $('#totalProducts').text(res.totalProducts);
            $('#totalOrders').text(res.totalOrders);

            let html='';

            $.each(res.users,function(i,user){

                let initials=user.name.split(' ').map(v=>v[0]).join('').substring(0,2).toUpperCase();

                html+=`
                <tr>

                    <td>#${user.id}</td>

                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar">${initials}</div>
                            <div>
                                <div class="fw-bold">${user.name}</div>
                                <small class="text-secondary">Member</small>
                            </div>
                        </div>
                    </td>

                    <td>${user.email}</td>

                    <td>
                        <span class="role-badge ${user.role=='admin'?'role-admin':'role-user'}">
                            ${user.role}
                        </span>
                    </td>

                    <td>
                        <span class="status-badge ${user.status=='active'?'status-active':'status-inactive'}">
                            ${user.status}
                        </span>
                    </td>

                </tr>`;
            });

            $('#userTable').html(html);

        },

        error:function(xhr){

            if(xhr.status==401)
            {
                window.location.href="<?= base_url('loginform') ?>";
            }

            showToast('Something went wrong','error');

        }

    });

}

$(document).on('keyup','#searchUser',function(){
    loadUsers();
});

$('#darkModeBtn').click(function(){

    $('body').toggleClass('dark-mode');

    $(this).html(
        $('body').hasClass('dark-mode')
        ?'<i class="bi bi-sun-fill"></i>'
        :'<i class="bi bi-moon-stars-fill"></i>'
    );

});

loadUsers();

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>