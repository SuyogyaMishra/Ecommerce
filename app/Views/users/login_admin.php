<!-- admin-login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>

<body class="bg-secondary">

<div class="container d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow-lg p-4" style="width: 420px;">

    <h2 class="text-center text-primary mb-4">Admin Login</h2>

    <form id="adminLoginForm">

      <div class="mb-3">
        <label class="form-label">Admin Email</label>
        <input type="email" class="form-control" id="adminLoginEmail" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" id="adminLoginPassword" required>
      </div>

      <div class="form-check mb-3">
        <input
          type="checkbox"
          class="form-check-input"
          id="adminRememberMe"
        >
        <label class="form-check-label" for="adminRememberMe">
          Remember Me
        </label>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        Login as Admin
      </button>

    </form>

    <p class="text-center mt-3">
      Create new admin?
      <a href="admin-signup.html">Signup</a>
    </p>

  </div>

</div>

<script>

window.onload = function(){

  const adminRememberToken = localStorage.getItem("adminRememberToken");

  if(adminRememberToken){

    alert("Welcome Admin! Auto login successful.");

    console.log("Admin Token:", adminRememberToken);
  }
};

document.getElementById("adminLoginForm").addEventListener("submit", function(e){

  e.preventDefault();

  const email = document.getElementById("adminLoginEmail").value;
  const password = document.getElementById("adminLoginPassword").value;
  const rememberMe = document.getElementById("adminRememberMe").checked;

  const storedAdmin = JSON.parse(localStorage.getItem("admin"));

  if(
    storedAdmin &&
    storedAdmin.email === email &&
    storedAdmin.password === password
  ){

    alert("Admin login successful!");

    if(rememberMe){
      localStorage.setItem("adminRememberToken", storedAdmin.token);
    } else {
      localStorage.removeItem("adminRememberToken");
    }

    console.log("Admin Logged Token:", storedAdmin.token);


  } else {

    alert("Invalid admin credentials!");

  }

});

</script>

</body>
</html>