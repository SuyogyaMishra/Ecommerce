<?= $this->extend('layouts/user_sidebar') ?>
<?= $this->section('content') ?>

<style>
body{overflow-x:hidden;background:#f1f5f9}
.main-content{margin-left:260px;width:calc(100% - 260px);min-height:100vh;padding:30px}
.payment-wrapper{max-width:1200px;margin:auto}
.payment-card{background:#fff;border-radius:24px;overflow:hidden;box-shadow:0 4px 20px rgba(15,23,42,.05)}
.payment-header{padding:30px;border-bottom:1px solid #e2e8f0}
.page-title{font-size:30px;font-weight:700;color:#0f172a}
.page-subtitle{color:#64748b;margin-top:6px}
.gateway-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:25px;padding:30px}
.gateway-box{border:2px solid #e2e8f0;border-radius:22px;padding:30px;cursor:pointer;transition:.2s}
.gateway-box.active{border-color:#111827;background:#f8fafc}
.gateway-logo{width:70px;height:70px;object-fit:contain;margin-bottom:20px}
.gateway-title{font-size:20px;font-weight:700;color:#111827}
.gateway-desc{margin-top:8px;color:#64748b;font-size:14px}
.summary-box{padding:30px;border-top:1px solid #e2e8f0}
.summary-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px}
.summary-label{color:#64748b}
.summary-value{font-weight:700;color:#111827}
.total-price{font-size:34px;font-weight:800;color:#111827}
.pay-btn{width:100%;border:none;background:#111827;color:#fff;padding:16px;border-radius:16px;font-weight:700;font-size:16px}
.toast-box{position:fixed;top:20px;right:20px;z-index:9999;min-width:320px;padding:14px 18px;border-radius:14px;color:#fff;font-weight:600;display:none}
.toast-success{background:#16a34a}
.toast-error{background:#dc2626}
@media(max-width:992px){
.main-content{margin-left:0;width:100%;padding:15px}
}
</style>

<div class="toast-box" id="toastBox"></div>

<div class="payment-wrapper">

    <div class="payment-card">

        <div class="payment-header">

            <div class="page-title">
                Choose Payment Gateway
            </div>

            <div class="page-subtitle">
                Secure payment checkout
            </div>

        </div>

        <div class="gateway-grid">

            <div class="gateway-box active" data-gateway="razorpay">

                <img src="https://razorpay.com/assets/razorpay-logo.svg" class="gateway-logo">

                <div class="gateway-title">
                    Razorpay
                </div>

                <div class="gateway-desc">
                    UPI, Cards, Wallets & Net Banking
                </div>

            </div>

            <div class="gateway-box" data-gateway="stripe">

                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Stripe_logo%2C_revised_2016.svg" class="gateway-logo">

                <div class="gateway-title">
                    Stripe
                </div>

                <div class="gateway-desc">
                    International payments & cards
                </div>

            </div>

        </div>

        <div class="summary-box">

            <div class="summary-row">

                <div class="summary-label">
                    Order ID
                </div>

                <div class="summary-value" id="orderIdText">
                    --
                </div>

            </div>

            <div class="summary-box">

            <div class="summary-row">

                <div class="summary-label">
                   Coustmer Name
                </div>

                <div class="summary-value" id="costName">
                    --
                </div>

            </div>


            <div class="summary-row">

                <div class="summary-label">
                    Gateway
                </div>

                <div class="summary-value" id="gatewayText">
                    Razorpay
                </div>

            </div>

            <div class="summary-row">

                <div class="summary-label">
                    Amount
                </div>

                <div class="total-price" id="orderAmountText">
                    ₹0
                </div>

            </div>

            <button class="pay-btn mt-4" id="payBtn">
                Pay Now
            </button>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

let gateway='razorpay';
let orderId=localStorage.getItem('order_id');
let csrfName='<?= csrf_token() ?>';
let csrfHash='<?= csrf_hash() ?>';

function updateCsrf(csrf){

    if(!csrf)
        return;

    csrfName=csrf.token;
    csrfHash=csrf.hash;

}

function toast(message,type='success'){

    $('#toastBox')
    .removeClass('toast-success toast-error')
    .addClass(type=='success'?'toast-success':'toast-error')
    .html(message)
    .fadeIn(200);

    setTimeout(()=>{
        $('#toastBox').fadeOut(200)
    },2500);

}

if(!orderId){

    toast('Ord not found','error');

}else{

    loadOrder();

}

function loadOrder(){

    $.ajax({

        url:"<?= base_url('getpayment') ?>/"+orderId,

        type:"GET",

        dataType:"json",

        success:function(res){

            updateCsrf(res.csrf);

            if(!res.status){

                toast(res.message,'error');

                return;

            }

            $('#orderIdText').html('#'+res.order_id);
            $('#costName').html(res.name);

            $('#orderAmountText').html('₹'+res.total);

        },

        error:function(){

            toast('Unable to fetch order','error');

        }

    });

}

$(document).on('click','.gateway-box',function(){

    $('.gateway-box').removeClass('active');

    $(this).addClass('active');

    gateway=$(this).data('gateway');

    $('#gatewayText').text(
        gateway.charAt(0).toUpperCase()+gateway.slice(1)
    );

});

$('#payBtn').click(function(){

    let btn=$(this);

    btn.prop('disabled',true).html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

    $.ajax({

        url:"<?= base_url('createpayment') ?>",

        type:"POST",

        data:{
            order_id:orderId,
            gateway,
            [csrfName]:csrfHash
        },

        dataType:"json",

        success:function(response){

            updateCsrf(response.csrf);

            if(!response.status){

                toast(response.message,'error');

                btn.prop('disabled',false)
                .html('Pay Now');

                return;

            }

            if(response.redirect_url)
                window.location.href=response.redirect_url;

        },

        error:function(xhr){

            updateCsrf(xhr.responseJSON?.csrf);

            toast(
                xhr.responseJSON?.message ||
                'Something went wrong',
                'error'
            );

            btn.prop('disabled',false)
            .html('Pay Now');

        }

    });

});

function verifyPayment(payment){

    $.ajax({

        url:"<?= base_url('verifypayment') ?>",

        type:"POST",

        data:{
            order_id:orderId,
            gateway,
            payment_id:payment.payment_id,
            gateway_order_id:payment.gateway_order_id,
            signature:payment.signature,
            [csrfName]:csrfHash
        },

        dataType:"json",

        success:function(res){

            updateCsrf(res.csrf);

            if(!res.status){

                toast(res.message,'error');

                return;

            }

            localStorage.removeItem('order_id');

            toast(res.message);

            setTimeout(()=>{
                window.location.href=res.redirect_url;
            },1000);

        },

        error:function(xhr){

            updateCsrf(xhr.responseJSON?.csrf);

            toast(
                xhr.responseJSON?.message ||
                'Payment verification failed',
                'error'
            );

        }

    });

}

</script>

<?= $this->endSection() ?>