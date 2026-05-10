     
    <?= $this->extend('layouts/sidebar') ?>
    <?= $this->section('content') ?>
    <!-- MAIN -->

    <div class="main-content flex-grow-1">

        <!-- NAVBAR -->

        <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-3">

            <div class="container-fluid">

                <h4 class="mb-0">
                    Admin Dashboard
                </h4>

                <button class="btn btn-dark" id="darkModeBtn">
                    <i class="bi bi-moon"></i>
                </button>

            </div>

        </nav>

        <!-- CONTENT -->

        <div class="container-fluid py-4">

            <!-- ALERT -->

            <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

            <!-- CARDS -->

            <div class="row g-4 mb-4">

                <div class="col-md-3">

                    <div class="card dashboard-card shadow-sm">

                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Users
                                </p>

                                <h3 id="totalUsers">0</h3>

                            </div>

                            <i class="bi bi-people fs-1 text-primary"></i>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card shadow-sm">

                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Products
                                </p>

                                <h3 id="totalProducts">0</h3>

                            </div>

                            <i class="bi bi-box fs-1 text-success"></i>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card shadow-sm">

                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-1">
                                    Total Orders
                                </p>

                                <h3 id="totalOrders">0</h3>

                            </div>

                            <i class="bi bi-cart fs-1 text-warning"></i>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card dashboard-card shadow-sm">

                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div>

                                <p class="text-muted mb-1">
                                    Revenue
                                </p>

                                <h3 id="revenue">₹0</h3>

                            </div>

                            <i class="bi bi-currency-rupee fs-1 text-danger"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- CHART -->

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white fw-bold">
                    Analytics
                </div>

                <div class="card-body">

                    <canvas id="dashboardChart" height="100"></canvas>

                </div>

            </div>

            <!-- USER TABLE -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        Recent Users
                    </h5>

                    <div class="d-flex gap-2">

                        <input type="text"
                               class="form-control search-box"
                               id="searchUser"
                               placeholder="Search User">

                        <button class="btn btn-success" id="exportBtn">
                            <i class="bi bi-file-earmark-excel"></i>
                        </button>

                    </div>

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

                    <div class="p-3">

                        <ul class="pagination mb-0" id="pagination"></ul>

                    </div>

                </div>

            </div>

        </div>

    </div>
 <?= $this->endSection() ?>

 <?= $this->Section('script') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

    function showToast(message,type='success')
    {
        let bg=type=='success'?'bg-success':'bg-danger';

        $('.toast-container').append(`

        <div class="toast align-items-center text-white ${bg} border-0 show mb-2">

            <div class="d-flex">

                <div class="toast-body">
                    ${message}
                </div>

                <button type="button"
                        class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>

            </div>

        </div>

        `);

        setTimeout(()=>{
            $('.toast').remove();
        },3000);
    }

    function loadUsers(page=1)
    {
        let keyword=$('#searchUser').val();

        $('#userTable').html(`

        <tr>

            <td colspan="6" class="text-center p-5">

                <div class="spinner-border text-primary"></div>

            </td>

        </tr>

        `);

        $.ajax({

            url:"<?= base_url('admin/dashboarddata') ?>",

            type:"GET",

            dataType:"json",

            data:{
                page:page,
                search:keyword
            },

            success:function(res){

                $('#adminName').text(res.decodedToken.name);

                $('#adminEmail').text(res.decodedToken.email);

                $('#totalUsers').text(res.totalUsers);

                $('#totalProducts').text(res.totalProducts);

                $('#totalOrders').text(res.totalOrders);

                $('#revenue').text("₹"+res.revenue);

                let html='';

                $.each(res.users,function(i,user){

                    html+=`

                    <tr>

                        <td>${user.id}</td>

                        <td>${user.name}</td>

                        <td>${user.email}</td>

                        <td>

                            <span class="badge custom-badge ${user.role=='admin'?'bg-dark':'bg-primary'}">

                                ${user.role}

                            </span>

                        </td>

                        <td>

                            <span class="badge ${user.status=='active'?'bg-success':'bg-danger'}">

                                ${user.status}

                            </span>

                        </td>

                        <td class="d-flex gap-2">

                            <button class="btn btn-sm btn-primary editBtn"
                                    data-id="${user.id}">
                                Edit
                            </button>

                            <button class="btn btn-sm btn-danger deleteBtn"
                                    data-id="${user.id}">
                                Delete
                            </button>

                        </td>

                    </tr>

                    `;

                });

                $('#userTable').html(html);

                let pagination='';

                for(let i=1;i<=res.totalPages;i++)
                {
                    pagination+=`

                    <li class="page-item ${res.page==i?'active':''}">

                        <a href="#"
                           class="page-link"
                           onclick="loadUsers(${i})">

                            ${i}

                        </a>

                    </li>

                    `;
                }

                $('#pagination').html(pagination);

                loadChart(res.chartData);

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

    $(document).on('click','.deleteBtn',function(){

        let id=$(this).data('id');

        if(confirm('Delete this user ?'))
        {
            $.ajax({

                url:"<?= base_url('admin/deleteuser') ?>/"+id,

                type:"DELETE",

                success:function(){

                    showToast('User Deleted');

                    loadUsers();

                },

                error:function(){

                    showToast('Delete Failed','error');

                }

            });
        }

    });

    $('#exportBtn').click(function(){

        window.location.href="<?= base_url('admin/exportusers') ?>";

    });

    $('#darkModeBtn').click(function(){

        $('body').toggleClass('bg-dark text-white');

        $('.card').toggleClass('bg-dark text-white');

        $('.table').toggleClass('table-dark');

        $('.navbar').toggleClass('bg-dark');

    });

    let chart;

    function loadChart(data)
    {
        if(chart)
        {
            chart.destroy();
        }

        const ctx=document.getElementById('dashboardChart');

        chart=new Chart(ctx,{

            type:'bar',

            data:{

                labels:data.labels,

                datasets:[{

                    label:'Users',

                    data:data.values,

                    borderWidth:1

                }]

            }

        });

    }

    loadUsers();

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?= $this->endSection() ?>