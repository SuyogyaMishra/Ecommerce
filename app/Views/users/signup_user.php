<!-- app/Views/signup.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>User Signup</title>

    <!-- Bootstrap CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card shadow-lg border-0 p-4" style="width: 430px;">

            <h2 class="text-center mb-4 text-primary">
                Create Account
            </h2>

            <!-- Success Message -->

            <?php if (session()->getFlashdata('success')) : ?>

                <div class="alert alert-success">

                    <?= session()->getFlashdata('success') ?>

                </div>

            <?php endif; ?>

            <!-- Validation Errors -->

            <?php if (session()->getFlashdata('errors')) : ?>

                <div class="alert alert-danger">

                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>

                        <div>

                            <?= $error ?>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

            <!-- Signup Form -->

            <form
                method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">

                    <label class="form-label">

                        Full Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Enter Full Name"
                        value="<?= old('name') ?>"
                        required>

                </div>

                <!-- Email -->

                <div class="mb-3">

                    <label class="form-label">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter Email Address"
                        value="<?= old('email') ?>"
                        required>

                </div>

                <!-- Role -->

                <div class="mb-3">

                    <label class="form-label">

                        Select Role

                    </label>

                    <select
                        name="role"
                        class="form-select"
                        required disabled>


                        <option
                            value="user"
                            <?= old('role') == 'user' ? 'selected' : '' ?> selected>

                            User


                        </option>

                    </select>

                </div>

                <!-- Password -->

                <div class="mb-3">

                    <label class="form-label">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter Password"
                        required>

                </div>


                <div class="mb-3">

                    <label class="form-label">

                        Confirm Password

                    </label>

                    <input
                        type="password"
                        name="confirm_password"
                        class="form-control"
                        placeholder="Confirm Password"
                        required>

                </div>

                <!-- Submit Button -->

                <button
                    type="submit"
                    class="btn btn-primary w-100">

                    Signup

                </button>

            </form>

            <!-- Login Link -->

            <p class="text-center mt-3 mb-0">

                Already have an account?

                <a href="<?= base_url('loginform') ?>">

                    Login

                </a>

            </p>

        </div>

    </div>

</body>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$(document).ready(function () {

    $("form").submit(function (e) {

        e.preventDefault();

        $(".alert").remove();

        $.ajax({

            url: "<?= base_url('signup') ?>",

            type: "POST",

            data: $(this).serialize(),

            dataType: "json",

            success: function (response) {

                console.log(response);

                $('input[name="<?= csrf_token() ?>"]')
                    .val(response.token);

                if (response.status) {
                   console.log(response.message)
                    $("form").before(`

                        <div class="alert alert-success">

                            ${response.message}

                        </div>

                    `);

                    $("form")[0].reset();

                } else {

                    let errors = "";

                    $.each(response.errors, function (key, value) {

                        errors += `<div>${value}</div>`;
                    });

                    $("form").before(`

                        <div class="alert alert-danger">

                            ${errors}

                        </div>

                    `);
                    $("form")[0].reset();
                }
            },

            error: function (xhr) {

                console.log(xhr.responseText);

                $("form").before(`

                    <div class="alert alert-danger">

                        ${xhr.responseJSON.message}

                    </div>

                `);
            }

        });

    });

});

</script>

</html>