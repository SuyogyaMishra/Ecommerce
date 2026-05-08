<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


<div class="container vh-100 d-flex justify-content-center align-items-center">
<div class="card shadow border-0 p-4" style="width:400px;">

<h3 class="text-center text-primary mb-4">Admin Login</h3>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show"><?= session()->getFlashdata('error') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<form method="POST" action="<?= base_url('admin/login') ?>">

<?= csrf_field() ?>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?= old('email') ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" placeholder="Enter Password" required>
</div>

<!-- <div class="form-check mb-3">
<input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">
<label class="form-check-label" for="remember">Remember Me</label>
</div> -->

<button class="btn btn-primary w-100">Login</button>

</form>
   <p class="text-center mt-3">
            Don't have an account?
            <a href="<?= base_url('adminsignup') ?>">Signup</a>
        </p>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>