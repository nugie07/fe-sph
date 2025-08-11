@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link
  href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
  rel="stylesheet"/>
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6">
        <h3>Tracking Pembayaran PO</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item active">Tracking Pembayaran PO</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid general-widget">
  <div class="row justify-content-center">
    <div class="col-sm-6 col-lg-3">
      <div class="card o-hidden message-widget">
        <div class="card-header pb-0">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="square-after f-w-600 header-text-success">Sudah Dibayar<i class="fa fa-circle"> </i></p>
              <!-- added id -->
              <h4 id="card-approved">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="star" class="text-success" style="width: 40px; height: 40px;"></i>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="progress-widget">
            <div class="progress sm-progress-bar progress-animate">
              <div class="progress-gradient-success" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card o-hidden user-widget">
        <div class="card-header pb-0">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="square-after f-w-600 header-text-danger">Belum Dibayar<i class="fa fa-circle"> </i></p>
              <!-- added id -->
              <h4 id="card-approved_reject">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="alert-triangle" class="text-danger" style="width: 40px; height: 40px;"></i>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="progress-widget">
            <div class="progress sm-progress-bar progress-animate">
              <div class="progress-gradient-danger" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- Datatable disini --}}
<div class="col-sm-12">
    <div class="card">
      <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Data Pembayaran PO</h4>
            <span>Data semua pembayaran PO untuk Supplier atau Transporter </span>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">

            <select class="form-select" id="filter-status" style="width:200px;max-width:220px;">
                <option value="">Semua Status</option>
                <option value="pending">Belum Dibayar</option>
                <option value="paid">Sudah Dibayar</option>
            </select>
            <select class="form-select" id="filter-category" style="width:200px;max-width:220px;">
              <option value="">Semua Kategori</option>
              <option value="1">Supplier</option>
              <option value="2">Transporter</option>
            </select>
        </div>
    </div>
      <div class="card-body">
        <div class="table-responsive theme-scrollbar">
          <table class="display" id="basic-1">
            <thead>
              <tr>
                <th>No</th>
                <th>Tipe PO</th>
                <th>Nomer PO</th>
                <th>Payment Term</th>
                <th>Nama Supplier / Transportir</th>
                <th>Nilai PO (Rp)</th>
                <th>Status Pembayaran</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
            </div>
                        </div>
                        </div>
                        </div>
                        </div>

<!-- MODAL UPLOAD BUKTI PEMBAYARAN -->
<div class="modal fade" id="uploadPaymentModal" tabindex="-1" aria-labelledby="uploadPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
        <h5 class="modal-title" id="uploadPaymentModalLabel">Upload Bukti Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
        <form id="uploadPaymentForm">
          <input type="hidden" id="po_id" name="po_id">

          <div class="row g-3">
            <div class="col-md-12">
              <div class="alert alert-info">
                <strong>Informasi PO:</strong><br>
                <span id="po_info">-</span>
            </div>
                </div>

                    <div class="col-md-6">
              <label for="payment_date" class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                    </div>

                    <div class="col-md-6">
              <label for="receipt_number" class="form-label">No Bukti Bayar <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="receipt_number" name="receipt_number" placeholder="Masukkan nomor bukti pembayaran" required>
                    </div>

                    <div class="col-md-12">
              <label for="payment_receipt" class="form-label">Upload Bukti Bayar <span class="text-danger">*</span></label>
              <input type="file" class="form-control" id="payment_receipt" name="payment_receipt" accept=".pdf,.jpg,.jpeg,.png" required>
              <div class="form-text">
                Format: PDF, JPG, JPEG, PNG. Maksimal 1MB.
                    </div>
              <div id="file-size-error" class="text-danger mt-1" style="display: none;">
                Ukuran file maksimal 1MB
                    </div>
                    </div>
                    </div>
        </form>
                </div>
                <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 8px 20px;">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-submit-payment" style="border-radius: 8px; padding: 8px 20px;">
          <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
          Simpan
                    </button>
                </div>
        </div>
    </div>
</div>

<!-- MODAL VIEW RECEIPT -->
<div class="modal fade" id="viewReceiptModal" tabindex="-1" aria-labelledby="viewReceiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
        <h5 class="modal-title" id="viewReceiptModalLabel">Bukti Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
      <div class="modal-body p-0">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
          <iframe id="receiptIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 8px 20px;">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-download-receipt" onclick="downloadReceiptFile()" style="border-radius: 8px; padding: 8px 20px;">
          <i class="fa fa-download"></i> Download
        </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/js/general-widget.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
<!-- Panggil Select2 JS di layout -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let paymentTable;

    // Format currency function
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka || 0);
    }

    // Load summary data
    function loadSummaryData() {
        $.get('/api/purchase-order/payment/list', function(response) {
            if (response.success && response.summary) {
                $('#card-approved').text(response.summary.total_paid || 0);
                $('#card-approved_reject').text(response.summary.total_pending || 0);
            }
        });
    }

    // Initialize DataTable
    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#basic-1')) {
            $('#basic-1').DataTable().destroy();
        }

        paymentTable = $('#basic-1').DataTable({
        processing: true,
            serverSide: false,
        ajax: {
                url: '/api/purchase-order/payment/list',
            data: function(d) {
                    d.filter_status = $('#filter-status').val();
                    d.filter_category = $('#filter-category').val();
                },
                dataSrc: 'data'
            },
            columns: [
                { data: 'no', defaultContent: '-' },
                {
                    data: 'category_text',
                    defaultContent: '-',
                    render: function(data) {
                        if (data === 'Supplier') {
                            return '<span class="badge bg-primary">Supplier</span>';
                        } else if (data === 'Transporter') {
                            return '<span class="badge bg-info">Transporter</span>';
                        }
                        return data;
                    }
                },
                { data: 'vendor_po', defaultContent: '-' },
                { data: 'term', defaultContent: '-' },
                { data: 'vendor_name', defaultContent: '-' },
                {
                    data: 'total',
                    defaultContent: '-',
                    render: function(data) {
                        return formatRupiah(data);
                    }
                },
                                                {
                    data: 'payment_status_text',
                    defaultContent: '-',
                render: function(data, type, row) {
                        if (row.payment_status === 'paid') {
                            return `
                                <span class="badge bg-success">Sudah Dibayar</span>
                                ${row.receipt_file ? `<span class="badge bg-primary ms-1" style="cursor:pointer;" onclick="viewReceipt('${row.receipt_file}', '${row.receipt_number || 'Bukti Bayar'}')">Lihat Bukti</span>` : ''}
                            `;
                        } else if (row.payment_status === 'pending') {
                            return `
                                <span class="badge bg-warning">Belum Dibayar</span>
                                <span class="badge bg-info ms-1" style="cursor:pointer;" onclick="showUploadModal(${row.id}, '${row.vendor_po}', '${row.vendor_name}')">Upload Bukti Bayar</span>
                            `;
                        }
                        return data;
                    }
                }
            ],
            order: [[0, 'asc']],
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    }

    // Reload table and summary
    function reloadData() {
        if (paymentTable) {
            paymentTable.ajax.reload();
        }
        loadSummaryData();
    }

    // Filter change handlers
    $('#filter-status').on('change', function() {
        reloadData();
    });

    $('#filter-category').on('change', function() {
        reloadData();
    });

    // Initialize on page load
    initializeDataTable();
    loadSummaryData();

    // Refresh data every 30 seconds (optional)
    setInterval(function() {
        reloadData();
    }, 30000);

    // Handle receipt modal events
    $('#viewReceiptModal').on('hidden.bs.modal', function() {
        $('#receiptIframe').attr('src', '');
        currentReceiptUrl = '';
        currentReceiptTitle = '';
    });

    // File size validation
    $('#payment_receipt').on('change', function() {
        const file = this.files[0];
        const maxSize = 1 * 1024 * 1024; // 1MB in bytes

        if (file && file.size > maxSize) {
            $('#file-size-error').show();
            this.value = ''; // Clear the file input
        } else {
            $('#file-size-error').hide();
        }
    });

    // Submit payment receipt
    $('#btn-submit-payment').on('click', function() {
        const form = $('#uploadPaymentForm')[0];
        const formData = new FormData(form);

        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Validate file size
        const file = $('#payment_receipt')[0].files[0];
        const maxSize = 1 * 1024 * 1024; // 1MB

        if (file && file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ukuran file maksimal 1MB'
            });
            return;
        }

        // Show loading state
        const btn = $(this);
        const spinner = btn.find('.spinner-border');
        btn.prop('disabled', true);
        spinner.removeClass('d-none');

        // Submit form using fetch API
        fetch('/api/purchase-order/payment/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            btn.prop('disabled', false);
            spinner.addClass('d-none');

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Bukti pembayaran berhasil diupload'
                }).then(() => {
                    $('#uploadPaymentModal').modal('hide');
                    reloadData(); // Reload table and summary
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Gagal upload bukti pembayaran'
                });
            }
        })
        .catch(error => {
            btn.prop('disabled', false);
            spinner.addClass('d-none');

            console.error('Upload error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat upload. Silakan coba lagi.'
            });
        });
    });
});

// Global function to show upload modal
function showUploadModal(poId, vendorPo, vendorName) {
    // Set PO information
    $('#po_id').val(poId);
    $('#po_info').text(`${vendorPo} - ${vendorName}`);

    // Reset form
    $('#uploadPaymentForm')[0].reset();
    $('#file-size-error').hide();

    // Set default date to today
    $('#payment_date').val(new Date().toISOString().split('T')[0]);

    // Show modal
    $('#uploadPaymentModal').modal('show');
}

// Global variables for receipt viewer
let currentReceiptUrl = '';
let currentReceiptTitle = '';

// Global function to view receipt
function viewReceipt(receiptUrl, receiptTitle) {
    if (!receiptUrl || receiptUrl === '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'File bukti pembayaran tidak tersedia'
        });
            return;
        }

    // Set current receipt data
    currentReceiptUrl = receiptUrl;
    currentReceiptTitle = receiptTitle;

    // Set modal title
    $('#viewReceiptModalLabel').text(`Bukti Pembayaran - ${receiptTitle}`);

    // Set iframe source
    $('#receiptIframe').attr('src', receiptUrl);

    // Show modal
    $('#viewReceiptModal').modal('show');
}

// Global function to download receipt
function downloadReceiptFile() {
    if (currentReceiptUrl) {
        // Create a temporary link to download the receipt
        const link = document.createElement('a');
        link.href = currentReceiptUrl;
        link.download = `Receipt_${currentReceiptTitle}_${Date.now()}.pdf`;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
                } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'URL bukti pembayaran tidak tersedia'
        });
    }
}
</script>

@endsection
