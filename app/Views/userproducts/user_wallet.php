<?= $this->extend('layouts/user_sidebar') ?>

<?= $this->section('content') ?>

<style>
    body {
        overflow-x: hidden;
        background: #eef2f7
    }

    .main-content {
        margin-left: 260px;
        width: calc(100% - 260px);
        min-height: 100vh;
        padding: 28px
    }

    .gateway-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
        cursor: pointer;
        transition: .2s;
        text-align: center;
        font-weight: 700;
        background: #fff
    }

    .gateway-card.active {
        background: #111827;
        color: #fff;
        border-color: #111827
    }

    .wallet-wrapper {
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(15, 23, 42, .06)
    }

    .wallet-header {
        padding: 32px
    }

    .wallet-title {
        font-size: 30px;
        font-weight: 700;
        color: #0f172a
    }

    .wallet-subtitle {
        margin-top: 6px;
        color: #64748b;
        font-size: 14px
    }

    .wallet-card {
        margin-top: 28px;
        background: linear-gradient(135deg, #111827, #1e293b);
        border-radius: 28px;
        padding: 32px;
        color: #fff;
        position: relative;
        overflow: hidden
    }

    .wallet-card:before {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        top: -80px;
        right: -80px
    }

    .wallet-label {
        font-size: 13px;
        opacity: .75;
        margin-bottom: 12px;
        letter-spacing: .5px
    }

    .wallet-balance {
        font-size: 48px;
        font-weight: 700;
        line-height: 1
    }

    .wallet-actions {
        margin-top: 28px;
        display: flex;
        gap: 14px;
        flex-wrap: wrap
    }

    .wallet-btn {
        border: none;
        border-radius: 14px;
        padding: 13px 22px;
        font-weight: 600;
        font-size: 14px;
        transition: .2s
    }

    .wallet-btn-dark {
        background: #fff;
        color: #111827
    }

    .wallet-btn-light {
        background: rgba(255, 255, 255, .12);
        color: #fff;
        backdrop-filter: blur(8px)
    }

    .wallet-btn:hover {
        transform: translateY(-2px)
    }

    .wallet-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-top: 26px
    }

    .stats-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        padding: 24px
    }

    .stats-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px
    }

    .stats-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827
    }

    .wallet-bottom {
        padding: 0 32px 32px
    }

    .history-box {
        margin-top: 28px;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        overflow: hidden;
        display: none
    }

    .history-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #fff
    }

    .history-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827
    }

    .table {
        margin: 0
    }

    .table thead th {
        background: #111827 !important;
        color: #fff !important;
        border: none;
        padding: 18px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap
    }

    .table tbody td {
        padding: 18px;
        vertical-align: middle;
        border-color: #f1f5f9;
        white-space: nowrap
    }

    .table tbody tr:hover {
        background: #f8fafc
    }

    .credit {
        color: #16a34a;
        font-weight: 700
    }

    .debit {
        color: #dc2626;
        font-weight: 700
    }

    .badge-status {
        padding: 7px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600
    }

    .status-success {
        background: #dcfce7;
        color: #166534
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e
    }

    .pagination-wrap {
        padding: 22px;
        border-top: 1px solid #e2e8f0
    }

    .page-item .page-link {
        border: none;
        margin: 0 4px;
        border-radius: 10px;
        color: #111827;
        min-width: 40px;
        text-align: center
    }

    .page-item.active .page-link {
        background: #111827;
        color: #fff
    }

    .recharge-modal .modal-content {
        border: none;
        border-radius: 26px
    }

    .recharge-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-top: 18px
    }

    .amount-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
        text-align: center;
        cursor: pointer;
        transition: .2s;
        font-weight: 600
    }

    .amount-card:hover,
    .amount-card.active {
        background: #111827;
        color: #fff;
        border-color: #111827
    }

    .custom-amount {
        margin-top: 20px
    }

    @media(max-width:768px) {

        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 15px
        }

        .wallet-header,
        .wallet-bottom {
            padding: 20px
        }

        .wallet-balance {
            font-size: 36px
        }

        .wallet-stats {
            grid-template-columns: 1fr
        }

        .recharge-grid {
            grid-template-columns: repeat(2, 1fr)
        }

    }
</style>

<div class="wallet-wrapper">

    <div class="wallet-header">

        <div class="wallet-title">
            My Wallet
        </div>

        <div class="wallet-subtitle">
            Fast payments, refunds and wallet recharge
        </div>

        <div class="wallet-card">

            <div class="wallet-label">
                AVAILABLE BALANCE
            </div>

            <div class="wallet-balance" id="walletBalance">
                ₹0
            </div>

            <div class="wallet-actions">

                <button class="wallet-btn wallet-btn-dark" data-bs-toggle="modal" data-bs-target="#rechargeModal">
                    Recharge Wallet
                </button>

                <button class="wallet-btn wallet-btn-light" id="toggleHistory">
                    Show History
                </button>

            </div>

        </div>

        <div class="wallet-stats">

            <div class="stats-card">

                <div class="stats-label">
                    Total Credit
                </div>

                <div class="stats-value" id="totalCredit">
                    ₹0
                </div>

            </div>

            <div class="stats-card">

                <div class="stats-label">
                    Total Debit
                </div>

                <div class="stats-value" id="totalDebit">
                    ₹0
                </div>

            </div>

            <div class="stats-card">

                <div class="stats-label">
                    Transactions
                </div>

                <div class="stats-value" id="totalTransactions">
                    0
                </div>

            </div>

        </div>

    </div>

    <div class="wallet-bottom">

        <div class="history-box" id="historyBox">

            <div class="history-header d-flex justify-content-between align-items-center">

                <div class="history-title">
                    Transaction History
                </div>

                <button class="btn btn-sm btn-dark" id="hideHistory">
                    Hide
                </button>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Type</th>

                            <th>Amount</th>

                            <th>Balance</th>

                            <th>Reference ID</th>

                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody id="walletTableBody"></tbody>

                </table>

            </div>

            <div class="pagination-wrap d-flex justify-content-center">

                <ul class="pagination mb-0" id="pagination"></ul>

            </div>

        </div>

    </div>

</div>

<div class="modal fade recharge-modal" id="rechargeModal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Recharge Wallet
                        </h4>

                        <div class="text-muted small">
                            Choose amount to continue
                        </div>

                    </div>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="recharge-grid">

                    <div class="amount-card" data-amount="100">₹100</div>

                    <div class="amount-card" data-amount="500">₹500</div>

                    <div class="amount-card" data-amount="1000">₹1000</div>

                    <div class="amount-card" data-amount="2000">₹2000</div>

                </div>

                <div class="custom-amount">

                    <label class="form-label fw-semibold">
                        Custom Amount
                    </label>

                    <input type="number" class="form-control form-control-lg" id="customAmount" placeholder="Enter amount">

                </div>
                <div class="mt-4">

                    <label class="form-label fw-semibold">
                        Select Payment Gateway
                    </label>

                    <div class="d-flex gap-3 mt-2">

                        <label class="gateway-card active flex-fill" data-gateway="razorpay">

                            <input type="radio" name="gateway" value="razorpay" checked hidden>

                            <div class="gateway-name">
                                Razorpay
                            </div>

                        </label>

                        <label class="gateway-card flex-fill" data-gateway="stripe">

                            <input type="radio" name="gateway" value="stripe" hidden>

                            <div class="gateway-name">
                                Stripe
                            </div>

                        </label>

                    </div>

                </div>

                <button class="btn btn-dark w-100 mt-4 py-3 fw-semibold" id="rechargeBtn">
                    Continue Recharge
                </button>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let rechargeAmount = 0;

    $(document).ready(function() {
        loadWallet();
    });

    function loadWallet(page = 1) {

        $.ajax({

            url: "<?= base_url('getwallet') ?>",

            type: "GET",

            data: {
                page
            },

            dataType: "json",

            success: function(response) {

                $('#walletBalance').text(`₹${response.balance}`);
                $('#totalCredit').text(`₹${response.totalcredit}`);
                $('#totalDebit').text(`₹${response.totaldebit}`);
                $('#totalTransactions').text(response.total_transactions);

                let rows = '';

                if (response.transactions.length < 1) {

                    rows = `
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted fw-semibold">
                                No Transactions Found
                            </td>
                        </tr>
                    `;

                } else {

                    $.each(response.transactions, function(i, txn) {

                        rows += `
                            <tr>

                                <td>#${txn.id}</td>

                                <td>${txn.type.toUpperCase()}</td>

                                <td>
                                    <span class="${txn.type=='credit'?'credit':'debit'}">
                                        ${txn.type=='credit'?'+':'-'}₹${txn.amount}
                                    </span>
                                </td>

                                <td>₹${txn.balance}</td>

                                <td>
                                    <span class="badge-status ${txn.status=='success'?'status-success':'status-pending'}">
                                        ${txn.reference_id}
                                    </span>
                                </td>

                                <td>${txn.created_at}</td>

                            </tr>
                        `;

                    });

                }

                $('#walletTableBody').html(rows);

                let pagination = '';

                for (let i = 1; i <= response.transactions.totalPages; i++) {

                    pagination += `
                        <li class="page-item ${response.transactions.page==i?'active':''}">
                            <a href="#" class="page-link paginationBtn" data-page="${i}">
                                ${i}
                            </a>
                        </li>
                    `;

                }

                $('#pagination').html(pagination);

            }

        });

    }

    $(document).on('click', '.paginationBtn', function(e) {

        e.preventDefault();

        loadWallet($(this).data('page'));

    });

    $('#toggleHistory').click(function() {

        $('#historyBox').slideDown(200);

        $('html,body').animate({
            scrollTop: $('#historyBox').offset().top - 20
        }, 200);

    });

    $('#hideHistory').click(function() {

        $('#historyBox').slideUp(200);

    });

    $(document).on('click', '.amount-card', function() {

        $('.amount-card').removeClass('active');

        $(this).addClass('active');
        rechargeAmount = $(this).data('amount');
        $('#customAmount').val(rechargeAmount);

    });

    $('#customAmount').keyup(function() {

        $('.amount-card').removeClass('active');

        rechargeAmount = $(this).val();

    });
    let gateway = 'razorpay';

    $(document).on('click', '.gateway-card', function() {

        $('.gateway-card').removeClass('active');

        $(this).addClass('active');

        $(this).find('input').prop('checked', true);

        gateway = $(this).data('gateway');
        console.log(gateway);

    });

    $('#rechargeBtn').click(function() {
        let amount = parseFloat(rechargeAmount || $('#customAmount').val());

        if (!amount || amount < 1)
            return alert('Enter valid amount');

        let btn = $(this);

        btn.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
    `);

        $.ajax({

            url: "<?= base_url('createpayment') ?>",

            type: "POST",

            data: {
                amount,
                gateway,
                [window.CSRF_TOKEN_NAME]: window.CSRF_TOKEN_HASH
            },

            dataType: "json",

            success: function(res) {

                if (res.csrf) {
                    window.CSRF_TOKEN_NAME = res.csrf.token;
                    window.CSRF_TOKEN_HASH = res.csrf.hash;
                }
                if (res.redirect_url)
                    return window.location.href = res.redirect_url;

                alert(res.message || 'Unable to process recharge');

                btn.prop('disabled', false).text('Continue Recharge');

            },

            error: function(xhr) {

                if (xhr.responseJSON?.csrf) {
                    window.CSRF_TOKEN_NAME = xhr.responseJSON.csrf.token;
                    window.CSRF_TOKEN_HASH = xhr.responseJSON.csrf.hash;
                }

                alert(xhr.responseJSON?.message || 'Something went wrong');

                btn.prop('disabled', false).text('Continue Recharge');

            }

        });

    });
</script>

<?= $this->endSection() ?>