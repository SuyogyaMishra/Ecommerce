<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-md-5">
                <div class="card shadow border-0 rounded-4">

                    <div class="card-body p-4">

                        <h2 class="text-center mb-4">
                            Vendor Login
                        </h2>

                        <form action="<?= base_url('/vendor/login') ?>" method="POST">

                            <div class="mb-3">
                                <label class="form-label">
                                    Email
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Enter email"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    Password
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Enter password"
                                    required>
                            </div>

                            <div class="mb-3 form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="rememberMe"
                                    name="remember_me">

                                <label class="form-check-label" for="rememberMe">
                                    Remember Me
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success" id="loginBtn">
                                    Login
                                </button>
                            </div>

                        </form>

                        <p class="mt-3">
                            Register as Vendor
                            <a href="<?= base_url('vendor/signup') ?>">
                                Create here
                            </a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Toast -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index:9999">
        <div id="messageToast"
            class="toast align-items-center text-bg-success border-0"
            role="alert">

            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Message here
                </div>
                <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast">
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const form = document.querySelector("form");
        const loginBtn = document.getElementById("loginBtn");

        function showToast(message, isSuccess = true) {

            const toastElement = document.getElementById("messageToast");
            const toastMessage = document.getElementById("toastMessage");

            toastMessage.innerText = message;

            toastElement.classList.remove(
                "text-bg-success",
                "text-bg-danger"
            );

            toastElement.classList.add(
                isSuccess ? "text-bg-success" : "text-bg-danger"
            );

            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        form.addEventListener("submit", async function(e) {

            e.preventDefault();

            const formData = new FormData(form);

            loginBtn.disabled = true;
            loginBtn.innerText = "Logging in...";

            try {

                const response = await fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                const data = await response.json();

                if (data.status) {

                    showToast(data.message, true);

                    setTimeout(() => {
                        window.location.href = data.url;
                    }, 1200);

                } else {

                    showToast(
                        data.message || "Something went wrong",
                        false
                    );
                }

            } catch (error) {

                console.error(error);
                showToast("Server Error", false);

            } finally {

                loginBtn.disabled = false;
                loginBtn.innerText = "Login";
            }

        });
    </script>

</body>

</html>