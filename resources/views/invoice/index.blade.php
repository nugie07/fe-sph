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
          <h3>Pembuatan Invoice</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item active">Invoice</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
<div class="container-fluid general-widget">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Total Invoice<i class="fa fa-circle"> </i></p>
                            <h4 id="card-total_invoice">-</h4>
                        </div>
                        <div class="d-flex static-widget">
                                <i data-feather="file-text" class="text-primary" style="width: 40px; height: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden product-widget">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-success">Terbayar<i class="fa fa-circle"> </i></p>
                            <h4 id="card-paid">-</h4>
                        </div>
                        <div class="d-flex static-widget">
                            <i data-feather="check-circle" class="text-success" style="width: 40px; height: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden message-widget">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-danger">Belum Terbayar<i class="fa fa-circle"> </i></p>
                            <h4 id="card-unpaid">-</h4>
                        </div>
                        <div class="d-flex static-widget">
                            <i data-feather="alert-octagon" class="text-danger" style="width: 40px; height: 40px;"></i>
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
              <h4 class="mb-0">Invoice Management</h4>
              <span>Data semua invoice untuk finance tracking dan manajemen</span>
            </div>
            <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">
              <button type="button" class="btn btn-success" id="btn-create-invoice" style="color:#fff; border-radius:8px; padding:8px 16px; display:flex; align-items:center; gap:8px;" title="Buat Proforma Invoice Baru" onclick="window.location.href='/invoice/proforma'">
                  <i class="fa fa-plus"></i>
                  <span>Proforma Invoice</span>
              </button>
              <select class="form-select" id="filter-status" style="width:200px;max-width:220px;">
                <option value="">Semua Status</option>
                <option value="0">Draft</option>
                <option value="1">Belum Dibayar</option>
                <option value="2">Sudah Dibayar</option>
              </select>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Invoice No</th>
                    <th>Customer PO</th>
                    <th>Nama Customer</th>
                    <th>Total Nilai Invoice (Rp)</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>

<!-- Modal Detail/Edit Invoice -->
<div class="modal fade" id="modal-invoice-detail" tabindex="-1" aria-labelledby="modalInvoiceDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInvoiceDetailLabel">Detail Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-invoice-detail">
                    <input type="hidden" id="detail-invoice-id">
                    {{-- Bagian Detail Utama --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Invoice No</label>
                            <input type="text" class="form-control" id="detail-invoice-no" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Customer PO</label>
                            <input type="text" class="form-control" id="detail-po-no" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="detail-bill-to" readonly>
                        </div>
                    </div>
                    <hr>
                    {{-- Bagian Detail Item --}}
                    <h5>Detail Item</h5>
                    <table class="table table-bordered" id="invoice-details-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th>Kuantitas</th>
                                <th>Harga Satuan</th>
                                <th>Total</th>
                                <th class="action-col-edit" style="display:none;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-primary mt-2 action-col-edit" id="btn-add-item" style="display:none;">Tambah Item</button>

                    {{-- Bagian Total --}}
                    <div class="row justify-content-end mt-3">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span id="detail-subtotal">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Pajak (11%):</span>
                                <span id="detail-tax">Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span id="detail-total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary action-col-edit" id="btn-save-invoice" style="display:none;">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL UPLOAD BUKTI PEMBAYARAN -->
<div class="modal fade" id="uploadReceiptModal" tabindex="-1" aria-labelledby="uploadReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadReceiptModalLabel">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadReceiptForm">
                    <input type="hidden" id="receipt_invoice_id" name="invoice_id">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Informasi Invoice:</strong><br>
                                <span id="receipt_invoice_info">-</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="receipt_number" class="form-label">Nomer Bukti Bayar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="receipt_number" name="receipt_number" placeholder="Masukkan nomor bukti pembayaran" required>
                        </div>

                        <div class="col-md-6">
                            <label for="payment_date" class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                        </div>

                        <div class="col-md-12">
                            <label for="receipt_file" class="form-label">Upload Bukti Bayar <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="receipt_file" name="receipt_file" accept=".pdf,.jpg,.jpeg,.png" required>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 8px 20px;">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-submit-receipt" style="border-radius: 8px; padding: 8px 20px;">
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
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Function to view invoice in new page (global scope)
function viewInvoice(invoiceId) {
    // Redirect ke halaman view dengan state=view
    window.location.href = '/invoice/view?id=' + invoiceId + '&state=view';
}

// Function to edit invoice in new page (global scope)
function editInvoice(invoiceId) {
    // Redirect ke halaman view dengan state=revisi
    window.location.href = '/invoice/view?id=' + invoiceId + '&state=revisi';
}

$(document).ready(function() {
    let invoiceTable;
    let detailInvoiceModal = new bootstrap.Modal(document.getElementById('modal-invoice-detail'));
    let invoiceDetailsTable;

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka || 0);
    }

    function reloadTable() {
        if (invoiceTable) invoiceTable.ajax.reload();
        loadSummaryData();
    }

    function loadSummaryData() {
        $.get('/api/finance/invoices', function(response) {
            if (response.summary) {
                $('#card-total_invoice').text(response.summary.total || 0);
                $('#card-paid').text(response.summary.paid || 0);
                $('#card-unpaid').text(response.summary.unpaid || 0);
            }
        });
    }

    invoiceTable = $('#basic-1').DataTable({
        processing: false,
        destroy: true,
        ajax: {
            url: '/api/finance/invoices',
            data: d => {
                d.status = $('#filter-status').val();
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (d,t,r,i) => i.row + 1 },
            { data: 'invoice_no', defaultContent: '-' },
            { data: 'po_no', defaultContent: '-' },
            { data: 'bill_to', defaultContent: '-' },
            { data: 'total', render: data => formatRupiah(data) },
            {
                data: 'status',
                render: function(data) {
                    if (data == 0) return '<span class="badge bg-secondary">Draft</span>';
                    if (data == 1) return '<span class="badge bg-info">Menunggu Approval</span>';
                    if (data == 2) return '<span class="badge bg-warning">Revisi</span>';
                    if (data == 4) return '<span class="badge bg-primary">Approved</span>';
                    if (data == 5) return '<span class="badge bg-danger">Belum Dibayar</span>';
                    if (data == 6) return '<span class="badge bg-success">Paid</span>';
                    return '<span class="badge bg-light text-dark">Unknown</span>';
                }
            },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    if (row.status == 0) {
                        return `<span class="badge rounded p-2 bg-info text-white btn-buat-invoice" style="cursor:pointer;" data-id="${row.idd}">Buat Invoice</span>`;
                    } else if (row.status == 1) {
                        return `
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge rounded p-2 bg-primary btn-view-invoice" style="cursor:pointer;" data-id="${row.idd}" title="View" onclick="viewInvoice(${row.idd})"><i class="fa fa-eye"></i></span>
                            </div>
                        `;
                    } else if (row.status == 2) {
                        return `
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge rounded p-2 bg-primary btn-view-invoice" style="cursor:pointer;" data-id="${row.idd}" title="View" onclick="viewInvoice(${row.idd})"><i class="fa fa-eye"></i></span>
                                <span class="badge rounded p-2 bg-warning btn-edit-invoice" style="cursor:pointer;" data-id="${row.idd}" title="Edit" onclick="editInvoice(${row.idd})"><i class="fa fa-pencil"></i></span>
                            </div>
                        `;
                    } else if (row.status == 4 || row.status == 5 || row.status == 6) {
                        // Payment status handling
                        if (row.payment_status == 0) {
                            return `
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="badge rounded p-2 bg-info text-white">Unpaid</span>
                                    <span class="badge rounded p-2 bg-primary text-white btn-upload-receipt" style="cursor:pointer;" data-id="${row.idd}" data-invoice-no="${row.invoice_no}" title="Upload Bukti Bayar">Upload Bukti Bayar</span>
                                </div>
                            `;
                        } else if (row.payment_status == 1) {
                            return `
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="badge rounded p-2 bg-success text-white">PAID</span>
                                    <span class="badge rounded p-2 bg-primary text-white btn-view-receipt" style="cursor:pointer;" data-id="${row.idd}" data-receipt-file="${row.receipt_file}" data-receipt-number="${row.receipt_number}" title="View Bukti Bayar">View</span>
                                </div>
                            `;
                        }
                    }
                    return '';
                }
            }
        ]
    });

    $('#filter-status').on('change', reloadTable);
    loadSummaryData();

    // Fungsi untuk membuka modal detail
    function openDetailModal(invoiceId, isEditMode) {
        $.get(`/api/finance/invoices/${invoiceId}`, function(invoice) {
            $('#detail-invoice-id').val(invoice.id);
            $('#detail-invoice-no').val(invoice.invoice_no);
            $('#detail-po-no').val(invoice.po_no);
            $('#detail-bill-to').val(invoice.bill_to);

            $('.action-col-edit').toggle(isEditMode);

            if (invoiceDetailsTable) {
                invoiceDetailsTable.destroy();
            }

            $('#invoice-details-table tbody').empty();

            (invoice.details || []).forEach(item => {
                let rowHtml = `
                    <tr data-id="${item.id || ''}">
                        <td>${isEditMode ? `<input type="text" class="form-control" name="description" value="${item.description}">` : item.description}</td>
                        <td>${isEditMode ? `<input type="number" class="form-control" name="quantity" value="${item.quantity}">` : item.quantity}</td>
                        <td>${isEditMode ? `<input type="number" class="form-control" name="price" value="${item.price}">` : formatRupiah(item.price)}</td>
                        <td class="row-total">${formatRupiah(item.quantity * item.price)}</td>
                        ${isEditMode ? '<td><button type="button" class="btn btn-sm btn-danger btn-delete-item">Hapus</button></td>' : ''}
                    </tr>
                `;
                $('#invoice-details-table tbody').append(rowHtml);
            });

            calculateTotals();
            detailInvoiceModal.show();
        });
    }



    // Event handler lama untuk view sudah tidak digunakan karena sekarang menggunakan onclick
    // $('#basic-1 tbody').on('click', '.btn-view-invoice', function() {
    //     openDetailModal($(this).data('id'), false);
    // });

    $('#basic-1 tbody').on('click', '.btn-edit-invoice', function() {
        openDetailModal($(this).data('id'), true);
    });

    // Ubah: tombol "Buat Invoice" kirim seluruh data row lewat query string
    $('#basic-1 tbody').on('click', '.btn-buat-invoice', function() {
        const row = invoiceTable.row($(this).closest('tr')).data();
        // Serialize all row fields into query parameters
        const params = $.param(row);
        // Redirect ke halaman create dengan membawa semua field
        window.location.href = '/invoice/create?' + params;
    });

    function calculateTotals() {
        let subtotal = 0;
        $('#invoice-details-table tbody tr').each(function() {
            let qtyInput = $(this).find('input[name="quantity"]');
            let priceInput = $(this).find('input[name="price"]');

            let qty = parseFloat(qtyInput.length ? qtyInput.val() : $(this).find('td:eq(1)').text()) || 0;
            let price = parseFloat(priceInput.length ? priceInput.val() : $(this).find('td:eq(2)').text().replace(/[^0-9]/g, '')) || 0;

            let total = qty * price;
            $(this).find('.row-total').text(formatRupiah(total));
            subtotal += total;
        });
        let tax = subtotal * 0.11;
        let total = subtotal + tax;
        $('#detail-subtotal').text(formatRupiah(subtotal));
        $('#detail-tax').text(formatRupiah(tax));
        $('#detail-total').text(formatRupiah(total));
    }

    $('#invoice-details-table').on('input', 'input', calculateTotals);

    // Tambah item baru
    $('#btn-add-item').on('click', function() {
        let newRow = `
            <tr>
                <td><input type="text" class="form-control" name="description" value=""></td>
                <td><input type="number" class="form-control" name="quantity" value="1"></td>
                <td><input type="number" class="form-control" name="price" value="0"></td>
                <td class="row-total">${formatRupiah(0)}</td>
                <td><button type="button" class="btn btn-sm btn-danger btn-delete-item">Hapus</button></td>
            </tr>
        `;
        $('#invoice-details-table tbody').append(newRow);
    });

    // Hapus item
    $('#invoice-details-table').on('click', '.btn-delete-item', function() {
        $(this).closest('tr').remove();
        calculateTotals();
    });

    // Simpan perubahan
    $('#btn-save-invoice').on('click', function() {
        let invoiceId = $('#detail-invoice-id').val();
        let details = [];
        $('#invoice-details-table tbody tr').each(function() {
            details.push({
                id: $(this).data('id') || null,
                description: $(this).find('input[name="description"]').val(),
                quantity: $(this).find('input[name="quantity"]').val(),
                price: $(this).find('input[name="price"]').val(),
            });
        });

        $.ajax({
            url: `/api/finance/invoices/${invoiceId}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                details: details
                // Anda bisa menambahkan data lain dari form utama di sini jika perlu
            },
            success: function(response) {
                showToast('Invoice berhasil diperbarui.', 'success');
                detailInvoiceModal.hide();
                reloadTable();
            },
            error: function(xhr) {
                showToast('Gagal memperbarui invoice.', 'error');
            }
        });
    });

    // Global variables for receipt handling
    let currentReceiptUrl = '';
    let currentReceiptTitle = '';

    // Event handler untuk upload bukti pembayaran
    $('#basic-1 tbody').on('click', '.btn-upload-receipt', function() {
        const invoiceId = $(this).data('id');
        const invoiceNo = $(this).data('invoice-no');

        // Set invoice info
        $('#receipt_invoice_id').val(invoiceId);
        $('#receipt_invoice_info').text(invoiceNo);

        // Reset form
        $('#uploadReceiptForm')[0].reset();
        $('#file-size-error').hide();

        // Set default date to today
        $('#payment_date').val(new Date().toISOString().split('T')[0]);

        // Show modal
        $('#uploadReceiptModal').modal('show');
    });

    // Event handler untuk view bukti pembayaran
    $('#basic-1 tbody').on('click', '.btn-view-receipt', function() {
        const receiptFile = $(this).data('receipt-file');
        const receiptNumber = $(this).data('receipt-number');

        if (!receiptFile || receiptFile === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'File bukti pembayaran tidak tersedia'
            });
            return;
        }

        // Set current receipt data
        currentReceiptUrl = receiptFile;
        currentReceiptTitle = receiptNumber || 'Bukti Pembayaran';

        // Set modal title
        $('#viewReceiptModalLabel').text(`Bukti Pembayaran - ${currentReceiptTitle}`);

        // Set iframe source
        $('#receiptIframe').attr('src', receiptFile);

        // Show modal
        $('#viewReceiptModal').modal('show');
    });

    // File size validation for upload
    $('#receipt_file').on('change', function() {
        const file = this.files[0];
        const maxSize = 1 * 1024 * 1024; // 1MB in bytes

        if (file && file.size > maxSize) {
            $('#file-size-error').show();
            this.value = ''; // Clear the file input
        } else {
            $('#file-size-error').hide();
        }
    });

    // Submit receipt upload
    $('#btn-submit-receipt').on('click', function() {
        const form = $('#uploadReceiptForm')[0];
        const formData = new FormData(form);

        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Validate file size
        const file = $('#receipt_file')[0].files[0];
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

        // Add CSRF token to FormData
        formData.append('_token', '{{ csrf_token() }}');

        // Debug: Log FormData contents
        console.log('Uploading receipt for invoice ID:', $('#receipt_invoice_id').val());
        console.log('Receipt number:', $('#receipt_number').val());
        console.log('Payment date:', $('#payment_date').val());
        console.log('File:', $('#receipt_file')[0].files[0]);

        // Submit form using fetch API
        fetch('/api/finance/invoices/upload-receipt', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            btn.prop('disabled', false);
            spinner.addClass('d-none');

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Bukti pembayaran berhasil diupload'
                                }).then(() => {
                    $('#uploadReceiptModal').modal('hide');

                    // Wait a bit for modal to close, then reload
                    setTimeout(() => {
                        // Force reload table and summary
                        console.log('Reloading table after successful upload...');
                        if (invoiceTable) {
                            invoiceTable.ajax.reload(null, false); // false = stay on current page
                        }
                        loadSummaryData();

                        console.log('Table reload completed');
                    }, 300);
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

    // Handle receipt modal events
    $('#viewReceiptModal').on('hidden.bs.modal', function() {
        $('#receiptIframe').attr('src', '');
        currentReceiptUrl = '';
        currentReceiptTitle = '';
    });
});

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
