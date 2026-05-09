<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="d-flex">

        <div class="bg-dark text-white p-3 vh-100" style="width:260px;">

            <div class="text-center border-bottom pb-3 mb-4">
                <i class="bi bi-person-circle fs-1"></i>
                <h5 class="mt-2 mb-0" id="adminName">Admin</h5>
                <small class="text-secondary" id="adminEmail"></small>
            </div>

            <ul class="nav flex-column gap-2">

                <li class="nav-item">
                    <a href="#" class="nav-link text-white bg-primary rounded">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i>Users
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-box-seam me-2"></i>Products
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-cart me-2"></i>Orders
                    </a>
                </li>

                <li class="nav-item mt-4">
                    <a href="<?= base_url('admin/logout') ?>" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </li>

            </ul>

        </div>

        <div class="flex-grow-1">

            <nav class="navbar navbar-light bg-white shadow-sm px-4">
                <h4 class="mb-0">Dashboard</h4>
            </nav>

            <div class="container-fluid py-4">

                <div id="successAlert"></div>
                <div id="errorAlert"></div>
                <div id="warningAlert"></div>

                <div class="row g-4 mb-4">

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Users</p>
                                    <h3 class="mb-0" id="totalUsers">0</h3>
                                </div>
                                <i class="bi bi-people fs-1 text-primary"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white fw-semibold">
                        Recent Users
                    </div>

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script>

function loadUsers(page=1)
{
    $.ajax({

        url:"<?= base_url('admin/dashboarddata') ?>?page="+page,
        type:"GET",
        dataType:"json",

        success:function(res){

            $('#adminName').text(res.decodedToken.name);

            $('#adminEmail').text(res.decodedToken.email);

            $('#totalUsers').text(res.totalUsers);

            let html='';

            $.each(res.users,function(i,user){

                html+=`
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>
                        <span class="badge ${user.role=='admin'?'bg-dark':'bg-primary'}">
                            ${user.role}
                        </span>
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
                    <a href="#" class="page-link" onclick="loadUsers(${i})">
                        ${i}
                    </a>
                </li>
                `;
            }

            $('#pagination').html(pagination);

        },

        error:function(){

            $('#errorAlert').html(`
            <div class="alert alert-danger alert-dismissible fade show">
            Something went wrong
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            `);

        }

    });
}

loadUsers();

</script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>