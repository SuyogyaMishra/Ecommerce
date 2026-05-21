<?= $this->extend('layouts/user_sidebar') ?>

<?= $this->section('content') ?>

<style>
  body {
    overflow-x: hidden;
    background: #f1f5f9;
  }

  .toast-box {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 99999;
    min-width: 320px;
    padding: 14px 18px;
    border-radius: 14px;
    color: #fff;
    font-weight: 600;
    display: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
  }

  .toast-success {
    background: #16a34a;
  }

  .toast-error {
    background: #dc2626;
  }

  .main-content {
    margin-left: 260px;
    width: calc(100% - 260px);
    min-height: 100vh;
    padding: 30px;
  }

  .products-wrapper {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(15, 23, 42, .05);
  }

  .top-bar {
    padding: 25px 30px;
    border-bottom: 1px solid #e2e8f0;
  }

  .page-title {
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
  }

  .page-subtitle {
    color: #64748b;
    margin-top: 5px;
  }

  .search-box {
    width: 320px;
    max-width: 100%;
    border: 1px solid #dbe2ea;
    border-radius: 14px;
    padding: 12px 18px 12px 45px;
    transition: .2s;
  }

  .search-box:focus {
    outline: none;
    border-color: #111827;
    box-shadow: none;
  }

  .search-wrap {
    position: relative;
  }

  .search-wrap i {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    color: #94a3b8;
  }

  .table {
    margin: 0;
  }

  .table thead th {
    background: #111827 !important;
    color: #fff !important;
    border: none;
    padding: 18px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
  }

  .table tbody td {
    padding: 18px;
    vertical-align: middle;
    border-color: #f1f5f9;
    white-space: nowrap;
  }

  .table tbody tr:hover {
    background: #f8fafc;
  }

  .product-img {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 14px;
    background: #e2e8f0;
  }

  .product-name {
    font-weight: 600;
    color: #0f172a;
  }

  .category-badge {
    background: #eff6ff;
    color: #2563eb;
    padding: 7px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
  }

  .price {
    font-weight: 700;
    color: #111827;
  }

  .stock-in {
    background: #dcfce7;
    color: #166534;
    padding: 7px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
  }

  .stock-out {
    background: #fee2e2;
    color: #991b1b;
    padding: 7px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
  }

  .btn-cart {
    border: none;
    background: #111827;
    color: #fff;
    padding: 10px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    transition: .2s;
  }

  .btn-cart:hover {
    background: #000;
  }

  .btn-cart:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
  }

  .pagination-wrap {
    padding: 25px;
    border-top: 1px solid #e2e8f0;
  }

  .page-item .page-link {
    border: none;
    margin: 0 4px;
    border-radius: 10px;
    color: #111827;
    min-width: 40px;
    text-align: center;
  }

  .page-item.active .page-link {
    background: #111827;
    color: #fff;
  }

  .empty-box {
    padding: 80px 20px;
  }

  @media(max-width:768px) {

    .main-content {
      margin-left: 0;
      width: 100%;
      padding: 15px;
    }

    .top-bar {
      padding: 20px;
    }

    .search-box {
      width: 100%;
    }

  }
  
</style>
<style>

.announcement-wrapper{
    background:#111827;
    color:#fff;
    border-radius:18px;
    overflow:hidden;
    margin-bottom:25px;
    position:relative;
    height:60px;
    display:flex;
    align-items:center;
}

.announcement-label{
    background:#dc2626;
    height:100%;
    padding:0 22px;
    display:flex;
    align-items:center;
    font-weight:700;
    white-space:nowrap;
    z-index:2;
}

.announcement-marquee{
    overflow:hidden;
    position:relative;
    flex:1;
    height:100%;
    display:flex;
    align-items:center;
}

.announcement-track{
    display:flex;
    align-items:center;
    white-space:nowrap;
    position:absolute;
    will-change:transform;
    animation:scrollAnnouncement 22s linear infinite;
}

.announcement-item{
    margin-right:80px;
    font-weight:500;
    font-size:15px;
}

.announcement-item strong{
    color:#facc15;
    margin-right:8px;
}

@keyframes scrollAnnouncement{
    from{
        transform:translateX(100%);
    }
    to{
        transform:translateX(-100%);
    }
}

@media(max-width:768px){

    .announcement-wrapper{
        height:auto;
        flex-direction:column;
        align-items:flex-start;
    }

    .announcement-label{
        width:100%;
        padding:14px 18px;
    }

    .announcement-marquee{
        width:100%;
        height:50px;
    }

}

</style>


<div class="products-wrapper">
  <div class="announcement-wrapper">

    <div class="announcement-label">

        <i class="bi bi-megaphone-fill me-2"></i>

        Announcements

    </div>

    <div class="announcement-marquee">

        <div class="announcement-track" id="announcementTrack"></div>

    </div>

</div>
  <div class="toast-box" id="toastBox"></div>

  <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">

    <div>

      <div class="page-title">
        Products
      </div>

      <div class="page-subtitle">
        Browse available products
      </div>

    </div>

    <a href="<?= base_url('user/cart') ?>" class="btn btn-dark px-4 py-2 rounded-3">

      <i class="bi bi-cart3 me-2"></i>

      Cart

    </a>

  </div>

  <div class="p-4 border-bottom">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

      <div class="search-wrap">

        <i class="bi bi-search"></i>

        <input
          type="text"
          id="searchProduct"
          class="search-box"
          placeholder="Search products...">

      </div>

      <div class="d-flex align-items-center gap-2">

        <small class="text-muted">
          Show
        </small>

        <select id="limitProducts" class="form-select form-select-sm" style="width:90px;border-radius:10px;">

          <option value="5">5</option>

          <option value="10" selected>10</option>

          <option value="25">25</option>

        </select>

      </div>

    </div>

  </div>

  <div class="table-responsive">

    <table class="table table-hover align-middle">

      <thead>

        <tr>

          <th>ID</th>

          <th>Image</th>

          <th>Name</th>

          <th>Category</th>

          <th>Price</th>

          <th>Availble</th>

          <th>Action</th>

        </tr>

      </thead>

      <tbody id="productTableBody"></tbody>

    </table>

  </div>

  <div class="pagination-wrap d-flex justify-content-center">

    <ul class="pagination mb-0" id="pagination"></ul>

  </div>

</div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

let csrfName="<?= csrf_token() ?>";
let csrfHash="<?= csrf_hash() ?>";

function showToast(message,type='success'){

    $('#toastBox')
    .removeClass('toast-success toast-error')
    .addClass(type=='success' ? 'toast-success' : 'toast-error')
    .html(message)
    .fadeIn(200);

    setTimeout(()=>{
        $('#toastBox').fadeOut(200);
    },2500);

}

function updateCsrf(token){

    csrfHash=token;

}

$(document).ready(function(){

    loadProducts();
    loadAnnouncements()

});

function loadProducts(page=1){

    let search=$('#searchProduct').val();
    let limit=$('#limitProducts').val();

    $('#productTableBody').html(`
        <tr>
            <td colspan="7" class="text-center empty-box">
                <div class="spinner-border text-dark"></div>
            </td>
        </tr>
    `);

    $.ajax({

        url:"<?= base_url('getproducts') ?>",

        type:"GET",

        data:{
            page,
            limit,
            search
        },

        dataType:"json",

        success:function(response){

            updateCsrf(response.token);

            if(!response.status){

                showToast(response.message || 'Unauthorized','error');

                if(response.redirect){
                    window.location.href=response.redirect;
                }

                return;

            }

            $('#userName').text(response.user.name);
            $('#userEmail').text(response.user.email);

            let rows='';

            if(response.products.users.length<1){

                rows=`
                    <tr>
                        <td colspan="7" class="text-center empty-box">

                            <i class="bi bi-box display-4 text-muted"></i>

                            <div class="mt-3 text-muted fw-semibold">
                                No Products Found
                            </div>

                        </td>
                    </tr>
                `;

            }else{

                $.each(response.products.users,function(i,product){

                    rows+=`
                        <tr>

                            <td>#${product.id}</td>

                            <td>

                                <img 
                                    src="<?= base_url() ?>/${product.image}"
                                    class="product-img"
                                    onerror="this.src='https://placehold.co/65x65'"
                                >

                            </td>

                            <td>

                                <div class="product-name">
                                    ${product.name}
                                </div>

                            </td>

                            <td>

                                <span class="category-badge">
                                    ${product.category || 'General'}
                                </span>

                            </td>

                            <td>

                                <span class="price">
                                    ₹${product.price}
                                </span>

                            </td>

                            <td>

                                ${
                                    product.stock>0
                                    ?
                                    `<span class="stock-in">
                                        ${product.stock} Available
                                    </span>`
                                    :
                                    `<span class="stock-out">
                                        Out Of Stock
                                    </span>`
                                }

                            </td>

                            <td>

                                ${
                                    product.stock>0
                                    ?
                                    `<button class="btn-cart addCartBtn" data-id="${product.id}">
                                        <i class="bi bi-cart-plus me-1"></i>
                                        Add To Cart
                                    </button>`
                                    :
                                    `<button class="btn-cart" disabled>
                                        Unavailable
                                    </button>`
                                }

                            </td>

                        </tr>
                    `;

                });

            }

            $('#productTableBody').html(rows);

            let pagination='';

            for(let i=1;i<=response.totalPages;i++){

                pagination+=`
                    <li class="page-item ${response.products.page==i?'active':''}">
                        <a href="#" class="page-link paginationBtn" data-page="${i}">
                            ${i}
                        </a>
                    </li>
                `;

            }

            $('#pagination').html(pagination);

        },

        error:function(xhr){

            if(xhr.responseJSON?.token){
                updateCsrf(xhr.responseJSON.token);
            }

            showToast(xhr.responseJSON?.message || 'Failed To Load Products','error');

            $('#productTableBody').html(`
                <tr>
                    <td colspan="7" class="text-center text-danger empty-box">

                        <i class="bi bi-wifi-off display-4"></i>

                        <div class="mt-3 fw-semibold">
                            Failed To Load Products
                        </div>

                    </td>
                </tr>
            `);

        }

    });

}

$(document).on('keyup','#searchProduct',function(){

    loadProducts(1);

});

$(document).on('change','#limitProducts',function(){

    loadProducts(1);

});

$(document).on('click','.paginationBtn',function(e){

    e.preventDefault();

    loadProducts($(this).data('page'));

});

$(document).on('click','.addCartBtn',function(){

    let productId=$(this).data('id');
    let btn=$(this);

    btn.prop('disabled',true);

    btn.html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

    $.ajax({

        url:"<?= base_url('addtocart') ?>/"+productId,

        type:"POST",

        data:{
            [csrfName]:csrfHash
        },

        dataType:"json",

        success:function(response){

            updateCsrf(response.token);

            if(!response.status){

                showToast(response.message || 'Failed To Add Product','error');

                btn.prop('disabled',false);

                btn.html(`
                    <i class="bi bi-cart-plus me-1"></i>
                    Add To Cart
                `);

                return;

            }

            showToast(response.message || 'Product Added');

            btn.html(`
                <i class="bi bi-check-circle me-1"></i>
                Added
            `);

            setTimeout(function(){

                btn.prop('disabled',false);

                btn.html(`
                    <i class="bi bi-cart-plus me-1"></i>
                    Add To Cart
                `);

            },1200);

        },

        error:function(xhr){

            if(xhr.responseJSON?.token){
                updateCsrf(xhr.responseJSON.token);
            }

            showToast(xhr.responseJSON?.message || 'Something Went Wrong','error');

            btn.prop('disabled',false);

            btn.html(`
                <i class="bi bi-cart-plus me-1"></i>
                Add To Cart
            `);

        }

    });

});

function loadAnnouncements(){

    $.ajax({

        url:"<?= base_url('announcements') ?>",

        type:"GET",

        dataType:"json",

        success:function(response){

            if(!response.status || !response.announcement.length){

                $('.announcement-wrapper').hide();

                return;

            }

            let html='';

            $.each(response.announcement,function(i,item){

                html+=`
                    <div class="announcement-item">

                        <strong>${item.title}</strong>

                        ${item.message}

                    </div>
                `;

            });

            $('#announcementTrack').html(html+html);

        },

        error:function(){

            $('.announcement-wrapper').hide();

        }

    });

}

</script>

<?= $this->endSection() ?>