<!-- app/Views/admin/create_user.php -->

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

<div class="card shadow border-0 p-4" style="width:430px;">

<h2 class="text-center text-primary mb-4">Create User</h2>

<div id="msg"></div>

<form id="userForm">

<?= csrf_field() ?>

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" placeholder="Enter Email" required>
</div>

<div class="mb-3">
<label class="form-label">Role</label>

<select name="role" class="form-select" required>

<option value="">Select Role</option>
<option value="user">User</option>
<option value="admin">Admin</option>

</select>

</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" placeholder="Enter Password" required>
</div>

<div class="mb-3">
<label class="form-label">Confirm Password</label>
<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
</div>

<button type="submit" class="btn btn-primary w-100" id="btn">
Create User
</button>

</form>
   <p class="text-center mt-3">
           Already have an account?
            <a href="<?= base_url('adminlogin') ?>">Login</a>
        </p>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const form = document.getElementById('userForm');

form.addEventListener('submit', async e => {

e.preventDefault();

const btn = document.getElementById('btn');

btn.disabled = true;
btn.innerText = 'Please Wait...';

const res = await fetch("<?= base_url('admin/createuser') ?>", {
method:'POST',
body:new FormData(form)
});

const data = await res.json();

let html = '';

if(data.status){

html = `<div class="alert alert-success alert-dismissible fade show">
${data.message}
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>`;

form.reset();

}else{

html = `<div class="alert alert-danger alert-dismissible fade show">
${Object.values(data.errors).join('<br>')}
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>`;

}

document.getElementById('msg').innerHTML = html;

btn.disabled = false;
btn.innerText = 'Create User';

});

</script>

</body>
</html>