<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4">

                    <div class="card-body p-4">

                        <h2 class="text-center mb-4">
                            Vendor Registration
                        </h2>

                        <p id="successres" class="text-center mb-4 text-success"></p>

                        <form action="<?= base_url('vendor/register') ?>" method="POST">

                            <div class="mb-3">
                                <label class="form-label">
                                    Name
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter vendor name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role</label>

                                <select name="role" class="form-select" disabled required>

                                    <option value="">Select Role</option>
                                    <option value="admin" selected>Vendor</option>

                                </select>

                            </div>

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

                            <div class="mb-3">
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

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Create Vendor
                                </button>
                            </div>

                        </form>

                        <p>
                            Already a vendor?
                            <a href="<?= base_url('vendor/loginform') ?>">
                                Login here
                            </a>
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

<script>
    const form = document.querySelector("form");

    form.addEventListener("submit", async function(e) {

        e.preventDefault();

        const name = document.querySelector('[name="name"]').value.trim();
        const email = document.querySelector('[name="email"]').value.trim();
        const password = document.querySelector('[name="password"]').value.trim();
        const formData = new FormData(form);

        try {

            const response = await fetch(form.action, {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            if (data.status) {
                document.getElementById('successres').innerHTML = `
                 ${data.message}
                 <a href="${data.url}">login Here</a>`;
                form.reset();

            } else {

                alert(data.message || "Something went wrong");

            }

        } catch (error) {

            console.error(error);
            alert("Server Error");

        }

    });
</script>

</html>