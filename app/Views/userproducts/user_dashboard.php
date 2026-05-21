<?= $this->extend('layouts/user_sidebar') ?>

<?= $this->section('content') ?>

<style>

body{
    background:#f1f5f9;
}

.dashboard{
    display:flex;
    flex-direction:column;
    gap:16px;
}

.announcement-bar{
    height:62px;
    background:#111827;
    border-radius:18px;
    overflow:hidden;
    position:relative;
    display:flex;
    align-items:center;
    padding-left:150px;
    box-shadow:0 4px 20px rgba(15,23,42,.06);
}

.announcement-label{
    position:absolute;
    left:0;
    top:0;
    width:135px;
    height:100%;
    background:#dc2626;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-size:13px;
    font-weight:700;
    letter-spacing:.5px;
}

.announcement-scroll{
    width:100%;
    overflow:hidden;
    white-space:nowrap;
}

.announcement-track{
    display:inline-flex;
    gap:70px;
    align-items:center;
    animation:scroll 24s linear infinite;
}

.announcement-item{
    color:#fff;
    font-size:14px;
    font-weight:500;
}

.announcement-item strong{
    color:#facc15;
    margin-right:8px;
}

@keyframes scroll{

    from{
        transform:translateX(100%);
    }

    to{
        transform:translateX(-100%);
    }

}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
    gap:12px;
}

.stats-card{
    background:#fff;
    border-radius:18px;
    padding:16px;
    box-shadow:0 4px 18px rgba(15,23,42,.05);
}

.stats-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.stats-icon{
    width:42px;
    height:42px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:17px;
}

.blue{
    background:#dbeafe;
    color:#2563eb;
}

.green{
    background:#dcfce7;
    color:#16a34a;
}

.orange{
    background:#fef3c7;
    color:#d97706;
}

.red{
    background:#fee2e2;
    color:#dc2626;
}

.stats-label{
    font-size:11px;
    color:#64748b;
    font-weight:600;
    text-transform:uppercase;
}

.stats-value{
    margin-top:6px;
    font-size:24px;
    font-weight:700;
    color:#111827;
    line-height:1;
}

.stats-text{
    margin-top:8px;
    font-size:11px;
    color:#16a34a;
    font-weight:600;
}

.dashboard-grid{
    display:grid;
    grid-template-columns:1.2fr .8fr;
    gap:16px;
}

.dashboard-card{
    background:#fff;
    border-radius:20px;
    padding:20px;
    box-shadow:0 4px 18px rgba(15,23,42,.05);
}

.card-title{
    font-size:18px;
    font-weight:700;
    color:#111827;
}

.card-subtitle{
    font-size:13px;
    color:#64748b;
    margin-top:3px;
}

.announcement-list{
    margin-top:18px;
    display:flex;
    flex-direction:column;
    gap:14px;
    max-height:480px;
    overflow:auto;
}

.announcement-card{
    background:#111827;
    border-radius:18px;
    padding:18px;
    color:#fff;
    position:relative;
}

.announcement-badge{
    position:absolute;
    top:14px;
    right:14px;
    background:#dc2626;
    color:#fff;
    border-radius:30px;
    padding:5px 10px;
    font-size:10px;
    font-weight:700;
}

.announcement-title{
    font-size:15px;
    font-weight:700;
    margin-bottom:8px;
}

.announcement-message{
    font-size:13px;
    line-height:1.6;
    color:#cbd5e1;
}

.quick-links{
    margin-top:18px;
    display:flex;
    flex-direction:column;
    gap:12px;
}

.quick-link{
    background:#f8fafc;
    border-radius:16px;
    padding:14px;
    display:flex;
    align-items:center;
    gap:12px;
    text-decoration:none;
    color:#111827;
    transition:.2s;
    font-size:14px;
    font-weight:600;
}

.quick-link:hover{
    background:#111827;
    color:#fff;
}

.quick-icon{
    width:40px;
    height:40px;
    border-radius:12px;
    background:#e2e8f0;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
}

.loading-box{
    min-height:260px;
    display:flex;
    align-items:center;
    justify-content:center;
}

@media(max-width:992px){

    .dashboard-grid{
        grid-template-columns:1fr;
    }

}

@media(max-width:768px){

    .announcement-bar{
        padding-left:0;
        height:auto;
        flex-direction:column;
        align-items:flex-start;
    }

    .announcement-label{
        position:relative;
        width:100%;
        height:52px;
    }

    .announcement-scroll{
        padding:12px 0;
    }

}

</style>

<div class="dashboard">

    <div class="announcement-bar">

        <div class="announcement-label">

            <i class="bi bi-megaphone-fill"></i>

            ANNOUNCEMENTS

        </div>

        <div class="announcement-scroll">

            <div class="announcement-track" id="announcementBar"></div>

        </div>

    </div>

    <div class="stats-grid">

        <div class="stats-card">

            <div class="stats-top">

                <div>

                    <div class="stats-label">
                        Orders
                    </div>

                    <div class="stats-value" id="totalOrders">
                        0
                    </div>

                </div>

                <div class="stats-icon blue">

                    <i class="bi bi-bag-check-fill"></i>

                </div>

            </div>

            <div class="stats-text">
                Total Orders
            </div>

        </div>

        <div class="stats-card">

            <div class="stats-top">

                <div>

                    <div class="stats-label">
                        Cart
                    </div>

                    <div class="stats-value" id="cartItems">
                        0
                    </div>

                </div>

                <div class="stats-icon green">

                    <i class="bi bi-cart-fill"></i>

                </div>

            </div>

            <div class="stats-text">
                Cart Products
            </div>

        </div>


        <div class="stats-card">

            <div class="stats-top">

                <div>

                    <div class="stats-label">
                        Alerts
                    </div>

                    <div class="stats-value" id="totalAnnouncements">
                        0
                    </div>

                </div>

                <div class="stats-icon red">

                    <i class="bi bi-megaphone-fill"></i>

                </div>

            </div>

            <div class="stats-text">
                Latest Updates
            </div>

        </div>

    </div>

    <div class="dashboard-grid">

        <div class="dashboard-card">

            <div class="card-title">
                Latest Announcements
            </div>

            <div class="card-subtitle">
                Recent admin notifications
            </div>

            <div class="announcement-list" id="announcementList">

                <div class="loading-box">

                    <div class="spinner-border text-dark"></div>

                </div>

            </div>

        </div>

        <div class="dashboard-card">

            <div class="card-title">
                Quick Access
            </div>

            <div class="card-subtitle">
                Open modules quickly
            </div>

            <div class="quick-links">

                <a href="<?= base_url('products') ?>" class="quick-link">

                    <div class="quick-icon">

                        <i class="bi bi-box-fill"></i>

                    </div>

                    Products

                </a>

                <a href="<?= base_url('user/cart') ?>" class="quick-link">

                    <div class="quick-icon">

                        <i class="bi bi-cart-fill"></i>

                    </div>

                    Cart

                </a>

                <a href="<?= base_url('user/orders') ?>" class="quick-link">

                    <div class="quick-icon">

                        <i class="bi bi-bag-fill"></i>

                    </div>

                    Orders

                </a>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$(document).ready(function(){
  loadDashboard();
  setInterval(loadDashboard,5000);

});

function loadDashboard(){

    $.ajax({

        url:"<?= base_url('userstats') ?>",

        type:"GET",

        dataType:"json",

        success:function(response){

            $('#totalOrders').text(response.totalOrders || 0);

            $('#cartItems').text(response.totatCarts || 0);

            $('#totalAnnouncements').text(response.announcements.length || 0);

            if(!response.announcements.length){

                $('#announcementList').html(`
                    <div class="text-center text-muted py-5">

                        <i class="bi bi-megaphone display-4"></i>

                        <div class="mt-3 fw-semibold">
                            No Announcements Found
                        </div>

                    </div>
                `);

                return;

            }

            let cards='';
            let bar='';

            $.each(response.announcements,function(i,item){

                bar+=`
                    <div class="announcement-item">

                        <strong>${item.title}</strong>

                        ${item.message}

                    </div>
                `;

                cards+=`
                    <div class="announcement-card">

                        <div class="announcement-badge">
                            NEW
                        </div>

                        <div class="announcement-title">

                            ${item.title}

                        </div>

                        <div class="announcement-message">

                            ${item.message}

                        </div>

                    </div>
                `;

            });

            $('#announcementBar').html(bar+bar);

            $('#announcementList').html(cards);

        },

        error:function(){

            $('#announcementList').html(`
                <div class="text-center text-danger py-5">

                    <i class="bi bi-wifi-off display-4"></i>

                    <div class="mt-3 fw-semibold">
                        Failed To Load Dashboard
                    </div>

                </div>
            `);

        }

    });

}

</script>

<?= $this->endSection() ?>