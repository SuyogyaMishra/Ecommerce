<?= $this->extend('App\Vendors\Views\layout\vendor_sidebar') ?>

<?= $this->section('content') ?>

<?php
$kycVerified = false;
?>

<style>
    body {
        background: #f4f7fb;
    }

    .tooltip-inner {
        background: #dc3545;
        color: white;
        font-size: 13px;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #dc3545 !important;
    }

    .dashboard-title {
        font-weight: 700;
        color: #1f2937;
    }

    .dashboard-subtitle {
        color: #6b7280;
        font-size: 15px;
    }

    .kyc-card {
        border: none;
        border-radius: 22px;
        background: linear-gradient(135deg, #6366f1, #7c3aed);
        color: white;
        box-shadow: 0 10px 25px rgba(99, 102, 241, .2);
        transition: .3s;
    }

    .kyc-card:hover {
        transform: translateY(-3px);
    }

    .verify-btn {
        background: white;
        color: #4f46e5;
        border: none;
        border-radius: 12px;
        padding: 8px 18px;
        font-size: 14px;
        font-weight: 600;
    }

    .status-pill {
        display: inline-block;
        background: rgba(255, 255, 255, .2);
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 13px;
    }

    .modal-content {
        border-radius: 24px;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, #6366f1, #7c3aed);
        color: white;
        border: none;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 12px;
    }

    .submit-btn {
        border-radius: 12px;
        padding: 10px 24px;
        border: none;
        background: linear-gradient(135deg, #6366f1, #7c3aed);
    }

    .modal {
        z-index: 99999 !important;
    }

    .modal-dialog-centered {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    body.modal-open {
        overflow: hidden !important;
    }
</style>

<div class="container-fluid p-4">

    <h2 class="dashboard-title">Vendor Dashboard</h2>
    <p class="dashboard-subtitle">
        Manage products, orders and complete your KYC verification.
    </p>




    <div class="row mt-4">

        <div class="col-md-3">

            <div id="kycStatusContainer"></div>


        </div>

    </div>



    <!-- Modal -->
</div>
<div class="modal fade"
    id="kycModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Complete KYC
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <form id="kycForm"
                method="post"
                enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="row g-3">


                        <div class="col-md-6">
                            <label>Document</label>

                            <select name="document_name"
                                class="form-select">

                                <option>
                                    Select
                                </option>

                                <option value="aadhaar">
                                    Aadhaar
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Document Number</label>

                            <input type="text"
                                name="document_number"
                                class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Aadhaar</label>

                            <input type="file"
                                name="aadhaarcard"
                                class="form-control">
                        </div>


                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel
                    </button>

                    <button type="submit"
                        class="btn text-white submit-btn">

                        Submit KYC
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(function() {

        checkKycStatus();

    });
    $(function() {

        // Bootstrap tooltip init
        function showTooltip(element, message) {

            if (!element) return;

            // remove existing tooltip
            const existing =
                bootstrap.Tooltip.getInstance(element);

            if (existing) {
                existing.dispose();
            }

            $(element)
                .addClass('is-invalid')
                .attr('title', message);

            const tooltip =
                new bootstrap.Tooltip(element, {
                    trigger: 'manual',
                    placement: 'top'
                });

            tooltip.show();

            setTimeout(function() {

                tooltip.dispose();

                $(element)
                    .removeClass('is-invalid')
                    .removeAttr('title');

            }, 3000);
        }


        $('#kycForm').on('submit', function(e) {

            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');

            let formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('vendor/submit/kyc') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',

                beforeSend: function() {

                    $('.invalid-feedback').remove();

                    $('.form-control, .form-select')
                        .removeClass('is-invalid');

                    $('.submit-btn')
                        .html('Saving...')
                        .prop('disabled', true);
                },

                success: function(response) {

                    $('.submit-btn')
                        .html('Submit KYC')
                        .prop('disabled', false);

                    $('#kycForm')[0].reset();

                    const modalEl = document.getElementById('kycModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

                    modal.hide();

                    // cleanup backdrop issue
                    $('.modal-backdrop').remove();
                    $('body')
                        .removeClass('modal-open')
                        .css('overflow', '');

                    showSuccessToast(
                        response.message ??
                        'KYC Submitted Successfully ✅'
                    );

                    checkKycStatus(); // refresh status after submit
                },

                error: function(xhr) {

                    $('.submit-btn')
                        .html('Submit KYC')
                        .prop('disabled', false);

                    const response =
                        xhr.responseJSON;

                    // remove old errors
                    $('.invalid-feedback').remove();
                    $('.form-control, .form-select')
                        .removeClass('is-invalid');

                    if (
                        xhr.status === 422 &&
                        response?.errors
                    ) {

                        $.each(
                            response.errors,
                            function(field, message) {

                                const input =
                                    $('[name="' + field + '"]');

                                if (input.length) {

                                    input.addClass('is-invalid');

                                    input.after(`
                        <div class="invalid-feedback d-block">
                            ${message}
                        </div>
                    `);
                                }
                            }
                        );

                        return;
                    }

                    showSuccessToast(
                        'Something went wrong ❌'
                    );
                }
            });
        });


        function showSuccessToast(message) {

            const toast = $(`
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:999999">
                <div class="toast text-bg-dark border-0">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>

                        <button type="button"
                                class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast">
                        </button>
                    </div>
                </div>
            </div>
        `);

            $('body').append(toast);

            const bsToast =
                new bootstrap.Toast(
                    toast.find('.toast')[0]
                );

            bsToast.show();

            toast.on('hidden.bs.toast', function() {
                toast.remove();
            });
        }
    });


    function checkKycStatus() {

        $.ajax({
            url: "<?= base_url('vendor/kyc/status') ?>",
            type: "GET",
            dataType: "json",

            success: function(response) {

                let html = '';

                switch (parseInt(response.status)) {

                    case 0:
                        html = `
                                    <div class="kyc-status-box bg-warning-subtle border border-warning rounded-4 p-3">

                                        <div class="row align-items-center">

                                            <div class="col-8">

                                                <h6 class="mb-1 text-warning fw-bold">
                                                    KYC Pending
                                                </h6>

                                                <small class="text-muted">
                                                    Complete your KYC verification
                                                </small>

                                            </div>

                                            <div class="col-4 text-end">

                                                <button class="btn btn-warning fw-semibold px-3 py-2 rounded-3 shadow-sm verify-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kycModal">

                                                    Do KYC
                                                </button>

                                            </div>

                                        </div>

                                    </div>
                             `;
                        break;


                    case 1:
                        html = `
            <div class="kyc-status-box bg-primary-subtle border border-primary rounded-4 p-3">

                <div class="d-flex align-items-center">

                    <div>
                        <h6 class="mb-1 text-primary fw-bold">
                            KYC Under Review
                        </h6>

                        <small class="text-muted">
                            Your KYC are under verification
                        </small>
                    </div>

                </div>
            </div>
        `;
                        break;


                    case 2:
                        html = `
            <div class="kyc-status-box bg-success-subtle border border-success rounded-4 p-3">

                <div class="d-flex align-items-center">

                    <div>
                        <h6 class="mb-1 text-success fw-bold">
                            ✅ KYC Completed
                        </h6>

                        <small class="text-muted">
                            Verification completed successfully
                        </small>
                    </div>

                </div>
            </div>
        `;
                        break;


                    case 3:
                        html = `
            <div class="kyc-status-box bg-danger-subtle border border-danger rounded-4 p-3">

                <div class="d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="mb-1 text-danger fw-bold">
                             KYC Rejected
                        </h6>

                        <small class="text-muted">
                            Please upload correct documents
                        </small>
                    </div>

                    <button class="verify-btn btn btn-danger fw-semibold"
                            data-bs-toggle="modal"
                            data-bs-target="#kycModal">

                        Retry KYC
                    </button>
                </div>

            </div>
        `;
                        break;


                    default:
                        html = `
            <div class="kyc-status-box bg-secondary-subtle border border-secondary rounded-4 p-3">

                <div class="d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="mb-1 text-dark fw-bold">
                            ⚠️ Not Verified
                        </h6>

                        <small class="text-muted">
                            Please verify your KYC
                        </small>
                    </div>

                    <button class="verify-btn btn btn-dark fw-semibold"
                            data-bs-toggle="modal"
                            data-bs-target="#kycModal">

                        Verify Now
                    </button>

                </div>

            </div>
        `;
                }

                $('#kycStatusContainer').html(html);
            }
        });
    }
</script>
<?= $this->endSection() ?>