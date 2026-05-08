<!-- admin-signup.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Signup</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>

<body class="bg-dark">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-lg p-4" style="width: 420px;">
    
    <h2 class="text-center text-danger mb-4">Admin Signup</h2>

    <form id="adminSignupForm">

      <div class="mb-3">
        <label class="form-label">Admin Name</label>
        <input type="text" class="form-control" id="adminName" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Admin Email</label>
        <input type="email" class="form-control" id="adminEmail" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" id="adminPassword" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="adminConfirmPassword" required>
      </div>

      <button type="submit" class="btn btn-danger w-100">
        Create Admin Account
      </button>

    </form>

    <p class="text-center mt-3">
      Already admin?
      <a href="admin-login.html">Login</a>
    </p>

  </div>
</div>

<script>

document.getElementById("adminSignupForm").addEventListener("submit", function(e) {

  e.preventDefault();

  const password = document.getElementById("adminPassword").value;
  const confirmPassword = document.getElementById("adminConfirmPassword").value;

  if(password !== confirmPassword){
    alert("Passwords do not match!");
    return;
  }

  const adminToken = "admin_" + Math.random().toString(36).substr(2);

  const adminData = {
    name: document.getElementById("adminName").value,
    email: document.getElementById("adminEmail").value,
    password: password,
    token: adminToken
  };

  localStorage.setItem("admin", JSON.stringify(adminData));

  alert("Admin account created successfully!");

  window.location.href = "admin-login.html";

});

</script>

</body>
</html>