<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{background:#f4f6f9;overflow-x:hidden}
        .sidebar{width:240px;min-height:100vh;background:#111827;position:fixed;left:0;top:0}
        .main-content{margin-left:240px}
        .nav-link{color:#fff;border-radius:10px;transition:.3s}
        .nav-link:hover{background:#2563eb;padding-left:20px}
        .active-menu{background:#2563eb}
    </style>
</head>

<body>

<div class="sidebar text-white p-3">

    <div class="text-center border-bottom pb-3 mb-4">
        <i class="bi bi-person-circle fs-1"></i>
        <h5 class="mt-2 mb-0" id="userName">User</h5>
        <small class="text-secondary" id="userEmail"></small>
    </div>

    <?php $uri = service('uri'); ?>

    <ul class="nav flex-column gap-2">

        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $uri->getSegment(1)=='dashboard'?'active-menu':'' ?>">
                <i class="bi bi-speedometer2 me-2"></i>
                Products
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('user/orders') ?>" class="nav-link <?= $uri->getSegment(2)=='orders'?'active-menu':'' ?>">
                <i class="bi bi-cart me-2"></i>
                Orders
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('wallet') ?>" class="nav-link <?= $uri->getSegment(2)=='wallet'?'active-menu':'' ?>">
                <i class="bi bi-cart me-2"></i>
               Wallet
            </a>
        </li>

        <li class="nav-item mt-4">
            <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i>
                Logout
            </a>
        </li>

    </ul>

</div>

<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<?= $this->renderSection('script') ?>

</body>
</html>