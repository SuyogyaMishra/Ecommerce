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

        <h3 class="text-center text-primary mb-4">
            Admin Login
        </h3>

        <form id="loginForm">

            <?= csrf_field() ?>

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input type="email" name="email" class="form-control" placeholder="Enter Email">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input type="password" name="password" class="form-control" placeholder="Enter Password">

            </div>

            <div class="form-check mb-3">

                <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">

                <label class="form-check-label" for="remember">
                    Remember Me
                </label>

            </div>

            <button class="btn btn-primary w-100" id="loginBtn">
                Login
            </button>

        </form>

        <p class="text-center mt-3">

            Don't have an account?

            <a href="<?= base_url('adminsignup') ?>">
                Signup
            </a>

        </p>

    </div>

</div>

<div class="toast-container position-fixed top-0 end-0 p-3">

    <div id="liveToast" class="toast border-0 shadow">

        <div class="toast-header">

            <strong class="me-auto">
                Notification
            </strong>

            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>

        </div>

        <div class="toast-body" id="toastMessage"></div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

let csrfName='<?= csrf_token() ?>';
let csrfHash='<?= csrf_hash() ?>';

function updateCsrf(res){

    if(res.token){

        csrfHash=res.token;

        $('input[name="'+csrfName+'"]').val(csrfHash);

    }

}

function showToast(message,type='success'){

    let toast=document.getElementById('liveToast');

    toast.classList.remove(
        'text-bg-success',
        'text-bg-danger'
    );

    toast.classList.add(
        type=='success'
        ? 'text-bg-success'
        : 'text-bg-danger'
    );

    $('#toastMessage').html(message);

    new bootstrap.Toast(toast).show();
}

$('#loginForm').submit(function(e){

    e.preventDefault();

    let btn=$('#loginBtn');

    btn.prop('disabled',true).html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

    let data=$(this).serialize();

    $.ajax({

        url:"<?= base_url('admin/login') ?>",

        type:"POST",

        data:data,

        dataType:"json",

        success:function(res){

            updateCsrf(res);

            btn.prop('disabled',false).html('Login');

            if(!res.status){

                let errors='';

                if(res.errors){

                    $.each(res.errors,function(k,v){
                        errors+=v+'<br>';
                    });

                }

                showToast(
                    errors || res.message,
                    'danger'
                );

                return;
            }

            showToast(res.message);

            setTimeout(()=>{

                window.location.href=res.redirect;

            },1000);

        },

        error:function(xhr){

            btn.prop('disabled',false).html('Login');

            updateCsrf(xhr.responseJSON || {});

            showToast(
                xhr.responseJSON?.message || 'Something went wrong',
                'danger'
            );

        }

    });

});

</script>

</body>

</html>