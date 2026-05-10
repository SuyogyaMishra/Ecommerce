<!-- app/Views/login.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card shadow p-4" style="width:400px;">

            <h2 class="text-center mb-4">User Login</h2>

            <!-- Error Message -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>
                </div>

                <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="remember_me"
                        value="1">

                    <label class="form-check-label">
                        Remember Me
                    </label>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Login
                </button>

            </form>

            <p class="text-center mt-3">
                Don't have an account?
                <a href="<?= base_url('signupform') ?>">Signup</a>
            </p>
             <p class="text-center mt-3">
                Login as admin?
                <a href="<?= base_url('adminlogin') ?>">Login</a>
            </p>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {

            $("#loginForm").submit(function(e) {

                e.preventDefault();

                $(".alert").remove();

                $.ajax({

                    url: "<?= base_url('login') ?>",

                    type: "POST",

                    data: $(this).serialize(),

                    dataType: "json",

                    success: function(response) {

                        console.log(response);

                        $('input[name="<?= csrf_token() ?>"]')
                            .val(response.token);

                        if (response.status) {

                            $("#loginForm").before(`

                        <div class="alert alert-success">

                            ${response.message}

                        </div>

                    `);

                            setTimeout(function() {

                                window.location.href = "<?= base_url('dashboard') ?>";

                            }, 1000);

                        } else {

                            let errors = "";

                            if (response.errors) {

                                $.each(response.errors, function(key, value) {

                                    errors += `<div>${value}</div>`;
                                });

                            } else {

                                errors = response.message;
                            }

                            $("#loginForm").before(`

                        <div class="alert alert-danger">

                            ${errors}

                        </div>

                    `);
                        }
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);
                        if (xhr.status === 401 || xhr.status === 403) {

                            localStorage.removeItem('token');

                            window.location.href = "<?= base_url('loginform') ?>";

                            return;
                        }
                        $("#loginForm").before(`

                    <div class="alert alert-danger">

                        Something went wrong!

                    </div>

                `);
                    }
                });

            });

        });
    </script>
</body>

</html>