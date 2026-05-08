<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Ecommerce Dashboard</title>

  <meta
    name="csrf-token"
    content="<?= csrf_hash() ?>">

  <!-- Bootstrap -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />

  <!-- Icons -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <style>
    body {
      background: #f4f6f9;
    }

    .dashboard-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .user-box {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      margin-bottom: 30px;
    }
  </style>

</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark">

    <div class="container">

      <a class="navbar-brand fw-bold">

        <i class="bi bi-shop"></i>

        Ecommerce Dashboard

      </a>

      <a
        href="<?= base_url('logout') ?>"
        class="btn btn-danger">

        Logout

      </a>

    </div>

  </nav>

  <!-- Main -->
  <div class="container py-5">

    <!-- User -->
    <div class="user-box">

      <h3>

        Welcome,
        <?= session()->get('user_name') ?>

      </h3>

      <p class="mb-0">

        <?= session()->get('user_email') ?>

      </p>

    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

      <div>

        <h2 class="fw-bold">

          Manage Products

        </h2>

        <p class="text-muted">

          CRUD Dashboard

        </p>

      </div>

      <a
        href="<?= base_url('addproduct') ?>"
        class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>

        Add Product

      </a>

    </div>

    <!-- Table -->
    <div class="card dashboard-card p-4">

      <div class="table-responsive">

        <table class="table table-hover">

          <thead class="table-dark">

            <tr>

              <th>ID</th>

              <th>Name</th>

              <th>Category</th>

              <th>Price</th>

              <th>Quantity</th>

              <th>Action</th>

            </tr>

          </thead>

          <tbody id="productTableBody">

          </tbody>

        </table>

      </div>

    </div>

  </div>

  <!-- Update Modal -->
  <div
    class="modal fade"
    id="updateProductModal"
    tabindex="-1">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title">

            Update Product

          </h5>

          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"></button>

        </div>

        <div class="modal-body">

          <form id="updateProductForm">

            <?= csrf_field() ?>

            <input
              type="hidden"
              id="update_product_id"
              name="product_id">

            <!-- Product -->
            <div class="mb-3">

              <label>

                Product Name

              </label>

              <input
                type="text"
                class="form-control"
                id="update_product_name"
                name="product_name">

              <small class="text-danger error-product_name"></small>

            </div>

            <!-- Category -->
            <div class="mb-3">

              <label>

                Category

              </label>

              <input
                type="text"
                class="form-control"
                id="update_category"
                name="category">

              <small class="text-danger error-category"></small>

            </div>

            <!-- Price -->
            <div class="mb-3">

              <label>

                Price

              </label>

              <input
                type="number"
                class="form-control"
                id="update_price"
                name="price">

              <small class="text-danger error-price"></small>

            </div>

            <!-- Quantity -->
            <div class="mb-3">

              <label>

                Quantity

              </label>

              <input
                type="number"
                class="form-control"
                id="update_quantity"
                name="quantity">

              <small class="text-danger error-quantity"></small>

            </div>

            <button
              type="submit"
              class="btn btn-primary w-100"
              id="updateBtn">

              Update Product

            </button>

          </form>

        </div>

      </div>

    </div>

  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    /*
|--------------------------------------------------------------------------
| Load Products
|--------------------------------------------------------------------------
*/

    $(document).ready(function() {

      loadProducts();

    });

    function loadProducts() {
      $.ajax({

        url: "<?= base_url('getproducts') ?>",

        type: "GET",

        dataType: "json",

        success: function(response) {

          if (!response.status) {

            window.location.href =
              response.redirect;

            return;
          }

          let rows = '';

          if (response.products.length === 0) {

            rows = `

                    <tr>

                        <td colspan="6"
                            class="text-center">

                            No Products Found

                        </td>

                    </tr>

                `;
          }

          $.each(response.products, function(index, product) {

            rows += `

                    <tr>

                        <td>${product.id}</td>

                        <td>${product.product_name}</td>

                        <td>${product.category}</td>

                        <td>$${product.price}</td>

                        <td>${product.quantity}</td>

                        <td>

    <!-- Edit -->
    <button
        class="btn btn-warning btn-sm editBtn"
        data-id="${product.id}"
    >

        <i class="bi bi-pencil-square"></i>

    </button>

    <!-- Delete -->
    <button
        class="btn btn-danger btn-sm deleteBtn"
        data-id="${product.id}"
    >

        <i class="bi bi-trash-fill"></i>

    </button>

</td>

                    </tr>

                `;
          });

          $('#productTableBody').html(rows);
        }

      });
    }

    /*
    |--------------------------------------------------------------------------
    | Open Edit Modal
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.editBtn', function() {

      let productId = $(this).data('id');

      $.ajax({

        url: "<?= base_url('get-product') ?>/" + productId,

        type: "GET",

        dataType: "json",

        success: function(response) {

          if (response.status) {

            $('#update_product_id')
              .val(response.product.id);

            $('#update_product_name')
              .val(response.product.product_name);

            $('#update_category')
              .val(response.product.category);

            $('#update_price')
              .val(response.product.price);

            $('#update_quantity')
              .val(response.product.quantity);

            let modal =
              new bootstrap.Modal(

                document.getElementById(
                  'updateProductModal'
                )

              );

            modal.show();
          }
        }

      });

    });

    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    $('#updateProductForm').submit(function(e) {

      e.preventDefault();

      $('.text-danger').text('');

      let productId =
        $('#update_product_id').val();

      let csrfName =
        '<?= csrf_token() ?>';

      let csrfHash =
        $('meta[name="csrf-token"]')
        .attr('content');

      let formData =
        $(this).serializeArray();

      formData.push({

        name: csrfName,

        value: csrfHash

      });

      $.ajax({

        url: "<?= base_url('update-product') ?>/" + productId,

        type: "POST",

        data: formData,

        dataType: "json",

        beforeSend: function() {

          $('#updateBtn')
            .prop('disabled', true)
            .html('Updating...');
        },

        success: function(response) {

          /*
          |--------------------------------------------------------------------------
          | Update CSRF
          |--------------------------------------------------------------------------
          */

          if (response.csrf_hash) {

            $('meta[name="csrf-token"]')
              .attr('content',
                response.csrf_hash
              );

            $('input[name="<?= csrf_token() ?>"]')
              .val(response.csrf_hash);
          }

          /*
          |--------------------------------------------------------------------------
          | Validation Errors
          |--------------------------------------------------------------------------
          */

          if (!response.status) {

            if (response.errors) {

              $.each(response.errors,
                function(key, value) {

                  $('.error-' + key)
                    .text(value);
                });
            }

            if (response.message) {

              alert(response.message);
            }

            $('#updateBtn')
              .prop('disabled', false)
              .html('Update Product');

            return;
          }

          /*
          |--------------------------------------------------------------------------
          | Success
          |--------------------------------------------------------------------------
          */

          alert(response.message);

          bootstrap.Modal
            .getInstance(

              document.getElementById(
                'updateProductModal'
              )

            ).hide();

          $('#updateProductForm')[0]
            .reset();

          loadProducts();

          $('#updateBtn')
            .prop('disabled', false)
            .html('Update Product');
        },

        error: function(xhr) {

          console.log(xhr.responseText);

          alert('Something Went Wrong');

          $('#updateBtn')
            .prop('disabled', false)
            .html('Update Product');
        }

      });

    });
  </script>
  <script>

/*
|--------------------------------------------------------------------------
| Delete Product
|--------------------------------------------------------------------------
*/

$(document).on('click', '.deleteBtn', function(){

    if(!confirm('Are you sure you want to delete this product?')){

        return;
    }

    let productId = $(this).data('id');

    let csrfName =
        '<?= csrf_token() ?>';

    let csrfHash =
        $('meta[name="csrf-token"]')
            .attr('content');

    $.ajax({

        url: "<?= base_url('delete-product') ?>/" + productId,

        type: "POST",

        data: {

            [csrfName]: csrfHash
        },

        dataType: "json",

        success: function(response){

            /*
            |--------------------------------------------------------------------------
            | Update CSRF
            |--------------------------------------------------------------------------
            */

            if(response.csrf_hash){

                $('meta[name="csrf-token"]')
                    .attr(
                        'content',
                        response.csrf_hash
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            if(response.status){

                alert(response.message);

                loadProducts();
            }
            else{

                alert(response.message);
            }
        },

        error: function(xhr){

            console.log(xhr.responseText);

            alert('Delete Failed');
        }

    });

});

</script>
</body>

</html>