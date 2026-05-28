 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Advanced Admin Dashboard</title>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

     <style>
         body {
             background: #f4f6f9;
             overflow-x: hidden;
         }

         .sidebar {
             width: 260px;
             min-height: 100vh;
             background: #111827;
             position: fixed;
             left: 0;
             top: 0;
         }

         .main-content {
             margin-left: 260px;
         }

         .nav-link {
             color: white;
             transition: 0.3s;
             border-radius: 10px;
         }

         .nav-link:hover {
             background: #2563eb;
             transform: translateX(5px);
         }

         .active-menu {
             background: #2563eb;
         }

         .dashboard-card {
             border: none;
             border-radius: 20px;
             transition: 0.3s;
         }

         .dashboard-card:hover {
             transform: translateY(-5px);
         }

         .table {
             vertical-align: middle;
         }

         .search-box {
             border-radius: 15px;
         }

         .custom-badge {
             padding: 8px 12px;
             border-radius: 30px;
         }

         .toast-container {
             z-index: 9999;
         }
     </style>

 </head>

 <body>

     <div class="d-flex"></div>
     <div class="sidebar text-white p-3">

         <div class="text-center border-bottom pb-3 mb-4">

             <i class="bi bi-person-circle fs-1"></i>

             <h5 class="mt-2 mb-0" id="adminName">Admin</h5>

             <small class="text-secondary" id="adminEmail"></small>

         </div>

         <ul class="nav flex-column gap-2">

             <?php $uri = service('uri'); ?>

             <li class="nav-item">
                 <a href="<?= base_url('admin/dashboard') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'dashboard' ? 'active-menu' : '' ?>">
                     <i class="bi bi-speedometer2 me-2"></i>
                     Dashboard
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?= base_url('admin/users') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'users' ? 'active-menu' : '' ?>">
                     <i class="bi bi-people me-2"></i>
                     Users
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?= base_url('admin/products') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'products' ? 'active-menu' : '' ?>">
                     <i class="bi bi-box-seam me-2"></i>
                     Products
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?= base_url('admin/orders') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'orders' ? 'active-menu' : '' ?>">
                     <i class="bi bi-cart me-2"></i>
                     Orders
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?= base_url('admin/vendor') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'vendor' ? 'active-menu' : '' ?>">
                     <i class="bi bi-person-badge me-2"></i>
                     Vendors
                 </a>
             </li>
             
             <li class="nav-item">
                 <a href="<?= base_url('admin/announcements') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'announcements' ? 'active-menu' : '' ?>">
                     <i class="bi bi-bell me-2"></i>
                     Announcements
                 </a>
             </li>

             <!-- <li class="nav-item">
                 <a href="<?= base_url('admin/reports') ?>"
                     class="nav-link <?= $uri->getSegment(2) == 'reports' ? 'active-menu' : '' ?>">
                     <i class="bi bi-graph-up me-2"></i>
                     Reports
                 </a>
             </li> -->


             <li class="nav-item mt-4">

                 <a href="<?= base_url('admin/logout') ?>"
                     class="btn btn-danger w-100">

                     <i class="bi bi-box-arrow-right me-2"></i>
                     Logout

                 </a>

             </li>

         </ul>

     </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <script>
         fetch("<?= base_url('admin/profile') ?>")
             .then(r => r.json())
             .then(res => {
                 if (res.status) {
                     document.getElementById('adminName').innerText = res.name;
                     document.getElementById('adminEmail').innerText = res.email;
                 }
             })
             .catch(() => console.log('Admin fetch failed'));
     </script>

     <?= $this->renderSection('content') ?>
     </div>
     <?= $this->renderSection('script') ?>