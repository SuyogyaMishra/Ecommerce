<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Product</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />

    <style>
        body {
            background: #f4f6f9;
        }

        .form-card {
            max-width: 700px;
            margin: auto;
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="card form-card p-5">

            <h2 class="mb-4 fw-bold text-center">
                Add Product
            </h2>

            <form id="productForm">

                <?= csrf_field() ?>

                <!-- Product Name -->
                <div class="mb-3">

                    <label class="form-label">
                        Product Name
                    </label>

                    <input
                        type="text"
                        name="product_name"
                        class="form-control">

                    <small class="text-danger error-product_name"></small>

                </div>

                <!-- Category -->
                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        class="form-control">

                    <small class="text-danger error-category"></small>

                </div>

                <!-- Price -->
                <div class="mb-3">

                    <label class="form-label">
                        Price
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control">

                    <small class="text-danger error-price"></small>

                </div>

                <!-- Quantity -->
                <div class="mb-4">

                    <label class="form-label">
                        Quantity
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        class="form-control">

                    <small class="text-danger error-quantity"></small>

                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="saveBtn">
                        Save Product
                    </button>

                    <a
                        href="<?= base_url('dashboard') ?>"
                        class="btn btn-secondary">
                        Back
                    </a>

                </div>

            </form>

        </div>

    </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
<script>

$(document).ready(function(){

    $('#productForm').submit(function(e){

        e.preventDefault();

        $('.text-danger').html('');

        $.ajax({

            url: "<?= base_url('saveproduct') ?>",

            type: "POST",

            data: $(this).serialize(),

            dataType: "json",

            beforeSend: function(){

                $('#saveBtn')
                    .html('Saving...')
                    .attr('disabled', true);
            },

            success: function(response){

                $('input[name="<?= csrf_token() ?>"]')
                    .val(response.csrf_hash);

                if(!response.status){

                    if(response.errors.product_name){

                        $('.error-product_name')
                            .html(response.errors.product_name);
                    }

                    // Category
                    if(response.errors.category){

                        $('.error-category')
                            .html(response.errors.category);
                    }

                    // Price
                    if(response.errors.price){

                        $('.error-price')
                            .html(response.errors.price);
                    }

                    // Quantity
                    if(response.errors.quantity){

                        $('.error-quantity')
                            .html(response.errors.quantity);
                    }

                    $('#saveBtn')
                        .html('Save Product')
                        .attr('disabled', false);

                    return;
                }

                alert(response.message);

                window.location.href = response.redirect;
            },

            error: function(){

                alert('Something went wrong');

                $('#saveBtn')
                    .html('Save Product')
                    .attr('disabled', false);
            }

        });

    });

});

</script>
</html>