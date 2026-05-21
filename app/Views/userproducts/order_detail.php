<?= $this->extend('layouts/user_sidebar') ?>
<?= $this->section('content') ?>

<style>
body{overflow-x:hidden;background:#f1f5f9}
.main-content{margin-left:260px;width:calc(100% - 260px);min-height:100vh;padding:30px}
.order-wrapper{background:#fff;border-radius:24px;box-shadow:0 4px 20px rgba(15,23,42,.05);padding:30px}
.page-title{font-size:30px;font-weight:700;color:#0f172a}
.page-subtitle{color:#64748b}
.card-box{background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:22px;height:100%}
.card-title{font-size:18px;font-weight:700;color:#0f172a;margin-bottom:18px}
.label-text{font-size:13px;color:#64748b}
.value-text{font-size:15px;font-weight:600;color:#0f172a}
.status-badge{padding:7px 14px;border-radius:30px;font-size:12px;font-weight:600}
.status-paid{background:#dcfce7;color:#166534}
.status-pending{background:#fef3c7;color:#92400e}
.status-failed{background:#fee2e2;color:#991b1b}
.product-img{width:70px;height:70px;border-radius:16px;object-fit:cover}
.table thead th{background:#111827!important;color:#fff!important;border:none;padding:16px;white-space:nowrap}
.table tbody td{padding:18px;vertical-align:middle;white-space:nowrap}
.table tbody tr:hover{background:#f8fafc}
.loader-box{padding:120px 20px;text-align:center}
@media(max-width:768px){
.main-content{margin-left:0;width:100%;padding:15px}
}
</style>

<div class="order-wrapper" id="orderDetails">

    <div class="loader-box">
        <div class="spinner-border text-dark"></div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

const orderId="<?= service('uri')->getSegment(2) ?>";

$(document).ready(function(){

    loadOrderDetails();

});

function badgeClass(status){

    status=(status||'').toLowerCase();

    if(['paid','confirmed','delivered'].includes(status))
        return 'status-paid';

    if(['failed','cancelled','payment_failed'].includes(status))
        return 'status-failed';

    return 'status-pending';

}

function loadOrderDetails(){

    $.ajax({

        url:"<?= base_url('getorderdetails') ?>/"+orderId,

        type:"GET",

        dataType:"json",

        success:function(res){

            if(!res.status){

                $('#orderDetails').html(`
                    <div class="text-center py-5">
                        <h4>${res.message}</h4>
                    </div>
                `);

                return;

            }

            let order=res.order;

            let customerHtml='';

            Object.entries({
                'Customer Name':order.customer_name,
                'Email':order.customer_email,
                'Phone':order.phone
            }).forEach(([label,value])=>{

                customerHtml+=`
                    <div class="mb-3">
                        <div class="label-text">${label}</div>
                        <div class="value-text">${value||'N/A'}</div>
                    </div>
                `;

            });

            let addressHtml='';

            Object.entries(order.address).forEach(([label,value])=>{

                addressHtml+=`
                    <div class="mb-3">
                        <div class="label-text">${label.replace('_',' ').toUpperCase()}</div>
                        <div class="value-text">${value||'N/A'}</div>
                    </div>
                `;

            });

            let paymentHtml='';

            Object.entries({
                'Method':order.payment.method,
                'Payment Status':order.payment.status,
                'Order Status':order.status,
                'Grand Total':'₹'+order.total
            }).forEach(([label,value])=>{

                paymentHtml+=`
                    <div class="mb-3">
                        <div class="label-text">${label}</div>
                        <div class="value-text">${value}</div>
                    </div>
                `;

            });

            let items='';

            $.each(res.items,function(i,item){

                items+=`
                    <tr>

                        <td>
                            <img src="${item.image}" class="product-img">
                        </td>

                        <td>
                            <div class="fw-bold">${item.product_name}</div>
                        </td>

                        <td>${item.quantity}</td>

                        <td>₹${item.price}</td>

                        <td class="fw-bold">
                            ₹${item.total}
                        </td>

                    </tr>
                `;

            });

            let payments='';

            $.each(res.payments,function(i,payment){

                payments+=`
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <div class="fw-semibold">
                                ${payment.name}
                            </div>

                            <small class="text-muted">
                                ${payment.status}
                            </small>

                        </div>

                        <div class="fw-bold">
                            ₹${payment.amount}
                        </div>

                    </div>
                `;

            });

            $('#orderDetails').html(`

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>

                        <div class="page-title">
                            Order #${order.id}
                        </div>

                        <div class="page-subtitle">
                            ${order.created_at}
                        </div>

                    </div>

                    <div class="d-flex gap-2">

                        <span class="status-badge ${badgeClass(order.payment.status)}">
                            ${order.payment.status}
                        </span>

                        <span class="status-badge ${badgeClass(order.status)}">
                            ${order.status}
                        </span>

                    </div>

                </div>

                <div class="row g-4 mb-4">

                    <div class="col-md-4">

                        <div class="card-box">

                            <div class="card-title">
                                Customer Details
                            </div>

                            ${customerHtml}

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card-box">

                            <div class="card-title">
                                Delivery Address
                            </div>

                            ${addressHtml}

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="card-box">

                            <div class="card-title">
                                Payment Info
                            </div>

                            ${paymentHtml}

                        </div>

                    </div>

                </div>

                <div class="card-box mb-4">

                    <div class="card-title">
                        Ordered Products
                    </div>

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>

                            </thead>

                            <tbody>

                                ${items}

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="row g-4">

                    <div class="col-md-6">

                        <div class="card-box">

                            <div class="card-title">
                                Payment Breakdown
                            </div>

                            ${payments}

                                  <div class="d-flex justify-content-between">

                                <span class="fw-bold">
                                    Grand Total
                                </span>

                                <span class="fw-bold">
                                    ₹${order.total}
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card-box">

                            <div class="card-title">
                                Order Summary
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Products</span>
                                <span>${res.items.length}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Payment Method</span>
                                <span>${order.payment.method}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Order Status</span>
                                <span>${order.status}</span>
                            </div>

                            <hr>

                        </div>

                    </div>

                </div>

            `);

        }

    });

}

</script>

<?= $this->endSection() ?>