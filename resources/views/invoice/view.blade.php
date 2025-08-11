@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
<style>
    /* Custom style mirip screenshot */
    #invoice-items-table thead th {
        background: #5b6be8 !important;
        color: #fff !important;
        text-align: left;
        vertical-align: middle;
    }
    #invoice-items-table tbody td, #invoice-items-table thead th {
        vertical-align: middle !important;
    }
    .btn-sq-rounded {
        border-radius: 12px !important;
        padding: 6px 18px !important;
        font-weight: 600;
        border: 1px solid #5b6be8 !important;
        background: #fff;
        color: #5b6be8;
        transition: 0.2s;
    }
    .btn-sq-rounded:hover, .btn-sq-rounded:focus {
        background: #5b6be8;
        color: #fff;
        border: 1px solid #5b6be8;
    }
    .btn-delete-item {
        border-radius: 12px !important;
        background: #FF2377 !important;
        color: #fff !important;
        font-weight: bold;
        border: none !important;
        padding: 6px 16px !important;
        font-size: 18px;
        transition: 0.2s;
    }
    .btn-delete-item:hover {
        opacity: 0.9;
        background: #d81b60 !important;
    }
    .table-danger {
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
    }
    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    .is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
/* --- PDF Sidebar CSS --- */
#pdfSidebar {
    transition: right .3s cubic-bezier(.7,0,.2,1);
}
@media (max-width: 650px) {
    #pdfSidebar {
        width: 100vw !important;
        min-width:0;
    }
}
/* State Management Styles */
.readonly-field {
    background-color: #f8f9fa !important;
    border-color: #dee2e6 !important;
    color: #495057 !important;
    cursor: not-allowed !important;
}
.readonly-field:focus {
    box-shadow: none !important;
    border-color: #dee2e6 !important;
}

.editable-field {
    background-color: #fff !important;
    border-color: #ced4da !important;
    color: #495057 !important;
    cursor: text !important;
}
.editable-field:focus {
    border-color: #5b6be8 !important;
    box-shadow: 0 0 0 0.2rem rgba(91, 107, 232, 0.25) !important;
}

.state-view .editable-field {
    background-color: #f8f9fa !important;
    border-color: #dee2e6 !important;
    color: #495057 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
}

.state-view .editable-field:focus {
    box-shadow: none !important;
    border-color: #dee2e6 !important;
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(5px);
}

.loading-content {
    text-align: center;
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.loading-spinner {
    width: 60px;
    height: 60px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #5b6be8;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-text {
    font-size: 18px;
    color: #495057;
    font-weight: 500;
    margin-bottom: 10px;
}

.loading-subtext {
    font-size: 14px;
    color: #6c757d;
}
</style>

<!-- Sidebar PDF Viewer -->
<div id="pdfSidebarOverlay" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:1099;display:none;background:rgba(20,20,20,0.18);" onclick="closePdfSidebar()"></div>
<div id="pdfSidebar" style="position:fixed;top:0;right:-560px;width:560px;height:100vh;background:#fff;z-index:1100;box-shadow:-2px 0 16px 0 rgba(91,107,232,0.10);transition:all .3s cubic-bezier(.7,0,.2,1);display:block;">
    <div style="padding:18px 20px 6px 24px;display:flex;align-items:center;justify-content:space-between;background:#f7f8fa;border-bottom:1px solid #eee;">
        <b class="text-dark">Preview Dokumen PDF</b>
        <button type="button" onclick="closePdfSidebar()" style="border:none;background:transparent;font-size:25px;line-height:1;color:#888;cursor:pointer;">&times;</button>
    </div>
    <iframe id="pdfSidebarIframe" src="" width="100%" height="90%" style="border:none;min-height:88vh;background:#f4f4f8;"></iframe>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <div class="loading-text">Memuat Data Invoice</div>
        <div class="loading-subtext">Mohon tunggu sebentar...</div>
    </div>
</div>

@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
                          <h3 id="pageTitle">Detail Invoice</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('invoice') }}">Invoice</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5>Remark History</h5>
            <div class="mb-4">
                <ul class="list-unstyled mb-0" id="remarkHistory"></ul>
              </div>
</div>
</div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form id="form-view-invoice">
                @csrf
                <h5>Informasi Utama</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Dn No</label>
                        <input type="text" class="form-control" name="dn_no" id="dn_no" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Customer PO</label>
                        <input type="text" class="form-control" name="po_no" id="po_no" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor Invoice</label>
                        <input type="text" class="form-control" name="invoice_no" id="invoice_no" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Invoice</label>
                        <input type="date" class="form-control editable-field" name="invoice_date" id="invoice_date">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ditagihkan Kepada (Bill To)</label>
                        <textarea class="form-control editable-field" name="bill_to" id="bill_to" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dikirimkan Kepada (Ship To)</label>
                        <textarea class="form-control editable-field" name="ship_to" id="ship_to" rows="3"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-control editable-field select2" name="payment_method" id="payment_method">
                            <option value="">Pilih Metode Pembayaran</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">FOB</label>
                        <input type="text" class="form-control editable-field" name="fob" id="fob">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jalur</label>
                        <input type="text" class="form-control editable-field" name="sent_via" id="sent_via">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sent Date</label>
                        <input type="date" class="form-control editable-field" name="sent_date" id="sent_date">
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <a href="#" id="btn-lihat-po" class="btn btn-sq-rounded btn-outline-info shadow-sm px-4 py-2" target="_blank" style="border-radius: 12px; border-width: 2px; box-shadow: 0 2px 8px rgba(91,107,232,0.08); font-weight: 600; display:none;">
                            Lihat PO
                        </a>
                        <a href="#" id="btn-lihat-bast" class="btn btn-sq-rounded btn-outline-warning shadow-sm px-4 py-2" target="_blank" style="border-radius: 12px; border-width: 2px; box-shadow: 0 2px 8px rgba(255,193,7,0.08); font-weight: 600; display:none;">
                            Lihat BAST
                        </a>
                    </div>
                </div>
                <hr class="mt-4 mb-4">
                <h5>Detail Item</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="invoice-items-table">
                        <thead>
                            <tr>
                                <th style="width: 4%;">NO</th>
                                <th style="width: 40%;">Nama Item</th>
                                <th style="width: 15%;">Quantity</th>
                                <th style="width: 20%;">Harga</th>
                                <th style="width: 15%;">Jumlah</th>
                                <th style="width: 6%;" id="action-header" style="display: none;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Baris item akan ditambahkan oleh JavaScript --}}
                        </tbody>
                        <tfoot id="add-item-footer" style="display: none;">
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="d-flex justify-content-start">
                                        <button type="button" class="btn btn-sq-rounded" id="btn-add-item" style="border-radius: 12px; color: #5b6be8; border: 1px solid #5b6be8; background: #fff; font-weight: 600; transition: 0.2s;"
                                            onmouseover="this.style.background='#5b6be8';this.style.color='#fff';"
                                            onmouseout="this.style.background='#fff';this.style.color='#5b6be8';">
                                            Tambah Item
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row justify-content-end mt-3">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <span>Sub Total:</span>
                            <span id="subtotal">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>PPN (11%):</span>
                            <span id="tax">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>PBBKB (7,5%):</span>
                            <span id="pbbkb">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>PPH 23 (2%):</span>
                            <span id="pph23">0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total:</span>
                            <span id="grand-total">0</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Terbilang:</span>
                            <span id="terbilang" class="fst-italic"></span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('invoice') }}" class="btn btn-secondary btn-sq-rounded">Kembali</a>
                    <button type="submit" class="btn btn-success btn-sq-rounded" id="btn-update-invoice" style="display: none;">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Update Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// --- Terbilang Indonesia sederhana ---
function terbilang(nilai) {
    var satuan = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    nilai = Math.floor(nilai);
    if (nilai < 12) return satuan[nilai];
    if (nilai < 20) return terbilang(nilai - 10) + " belas";
    if (nilai < 100) return terbilang(Math.floor(nilai / 10)) + " puluh " + terbilang(nilai % 10);
    if (nilai < 200) return "seratus " + terbilang(nilai - 100);
    if (nilai < 1000) return terbilang(Math.floor(nilai / 100)) + " ratus " + terbilang(nilai % 100);
    if (nilai < 2000) return "seribu " + terbilang(nilai - 1000);
    if (nilai < 1000000) return terbilang(Math.floor(nilai / 1000)) + " ribu " + terbilang(nilai % 1000);
    if (nilai < 1000000000) return terbilang(Math.floor(nilai / 1000000)) + " juta " + terbilang(nilai % 1000000);
    if (nilai < 1000000000000) return terbilang(Math.floor(nilai / 1000000000)) + " milyar " + terbilang(nilai % 1000000000);
    return "";
}

// --- PREFILL DAN PDF VIEWER BUTTON HANDLING ---
const publicUrl = `https://is3.cloudhost.id/bensinkustorage/`;

$(document).ready(function() {
    console.log('Document ready triggered'); // Debug log
    console.log('jQuery version:', $.fn.jquery); // Debug log
    console.log('Current URL:', window.location.href); // Debug log



            // STATE MANAGEMENT
    let currentState = 'view';
    let invoiceId = null;

    function initializeState() {
        const params = new URLSearchParams(window.location.search);
        currentState = params.get('state') || 'view';
        invoiceId = params.get('id');

        console.log('Current state:', currentState);
        console.log('Invoice ID:', invoiceId);

        // Update page title based on state
        if (currentState === 'revisi') {
            $('#pageTitle').text('Revisi Invoice');
            $('#btn-update-invoice').show();
            $('#action-header').show();
            $('#add-item-footer').show();
            $('body').removeClass('state-view');
        } else {
            $('#pageTitle').text('Detail Invoice');
            $('#btn-update-invoice').hide();
            $('#action-header').hide();
            $('#add-item-footer').hide();
            $('body').addClass('state-view');
        }
    }

    // LOAD DATA FROM API
    function loadInvoiceData() {
        if (!invoiceId) {
            console.error('No invoice ID provided');
            return;
        }

        console.log('Loading invoice data for ID:', invoiceId);

        // Show loading overlay
        $('#loadingOverlay').fadeIn(300);

        $.ajax({
            url: `/api/finance/invoices/${invoiceId}/view-details`,
            method: 'GET',
            success: function(response) {
                console.log('API Response:', response);

                if (response.success && response.data) {
                    const invoice = response.data.invoice;
                    const details = response.data.details || [];



                                        // Populate the form fields with API data
                    $('#dn_no').val(invoice.drs_no || '');
                    $('#po_no').val(invoice.po_no || '');
                    $('#invoice_no').val(invoice.invoice_no || '');
                    $('#invoice_date').val(invoice.invoice_date || '');
                    $('#ship_to').val(invoice.ship_to || '');
                    $('#bill_to').val(invoice.bill_to || '');
                    $('#fob').val(invoice.fob || '');
                    $('#sent_via').val(invoice.sent_via || '');
                    $('#sent_date').val(invoice.sent_date || '');

                    // Handle payment method based on state
                    if (currentState === 'revisi') {
                        // For revisi state, set value for Select2
                        $('#payment_method').val(invoice.terms || '').trigger('change');
                    } else {
                        // For view state, create a readonly input with the terms value
                        $('#payment_method').replaceWith(`<input type="text" class="form-control" value="${invoice.terms || ''}" readonly>`);
                    }

                    // Re-populate totals
                    $('#subtotal').text(formatRupiah(invoice.sub_total || 0));
                    $('#tax').text(formatRupiah(invoice.ppn || 0));
                    $('#pbbkb').text(formatRupiah(invoice.pbbkb || 0));
                    $('#pph23').text(formatRupiah(invoice.pph || 0));
                    $('#grand-total').text(formatRupiah(invoice.total || 0));

                    // Handle terbilang - use from API or calculate if empty
                    let terbilangText = invoice.terbilang || '';
                    if (!terbilangText && invoice.total && invoice.total > 0) {
                        terbilangText = terbilang(invoice.total).replace(/\s+/g, ' ').trim() + " rupiah";
                        terbilangText = terbilangText.replace(/  +/g, ' ');
                    }
                    $('#terbilang').text(terbilangText);

                    // Re-populate details table
                    $('#invoice-items-table tbody').empty();
                    if (details.length > 0) {
                        details.forEach(function(item, index) {
                            let newRow = '';
                            if (currentState === 'revisi') {
                                newRow = `
                                    <tr data-item-id="${item.id || ''}">
                                        <td class="item-no text-center align-middle">${index + 1}</td>
                                        <td><input type="text" name="details[${index}][nama_item]" class="form-control" value="${item.nama_item || ''}" required></td>
                                        <td><input type="number" name="details[${index}][qty]" class="form-control item-qty" value="${item.qty || 1}" min="1" required></td>
                                        <td><input type="number" name="details[${index}][harga]" class="form-control item-price" value="${item.harga || 0}" min="0" required></td>
                                        <td class="row-total text-end align-middle">${formatRupiah(item.total || 0)}</td>
                                        <td class="text-center align-middle"><button type="button" class="btn btn-delete-item">×</button></td>
                                    </tr>
                                `;
                            } else {
                                newRow = `
                                    <tr>
                                        <td class="item-no text-center align-middle">${index + 1}</td>
                                        <td class="align-middle">${item.nama_item || ''}</td>
                                        <td class="item-qty text-center align-middle">${item.qty || 0}</td>
                                        <td class="item-price text-end align-middle">${formatRupiah(item.harga || 0)}</td>
                                        <td class="row-total text-end align-middle">${formatRupiah(item.total || 0)}</td>
                                    </tr>
                                `;
                            }
                            $('#invoice-items-table tbody').append(newRow);
                        });
                    } else {
                        let newRow = '';
                        if (currentState === 'revisi') {
                            newRow = `
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada detail item</td>
                                </tr>
                            `;
                        } else {
                            newRow = `
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada detail item</td>
                                </tr>
                            `;
                        }
                        $('#invoice-items-table tbody').append(newRow);
                    }

                    // Re-show PDF buttons if files exist
                    if (invoice.po_file) {
                        $('#btn-lihat-po').attr('href', publicUrl + invoice.po_file).attr('target', '_blank').show();
                    } else {
                        $('#btn-lihat-po').hide();
                    }
                    if (invoice.dn_file) {
                        $('#btn-lihat-bast').attr('href', publicUrl + invoice.dn_file).attr('target', '_blank').show();
                    } else {
                        $('#btn-lihat-bast').hide();
                    }

                    // Hide loading overlay after successful data load
                    $('#loadingOverlay').fadeOut(300);

                    // Load remark history
                    loadRemarks(invoiceId, 'invoice', '#remarkHistory');

                } else {
                    console.error('Invalid API response:', response);
                    $('#loadingOverlay').fadeOut(300);
                    $('#form-view-invoice .card-body').html('<div class="text-center p-5 text-danger"><i class="fa fa-exclamation-triangle"></i><p class="mt-2">Gagal memuat data invoice</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('API Error:', xhr, status, error);
                $('#loadingOverlay').fadeOut(300);
                $('#form-view-invoice .card-body').html('<div class="text-center p-5 text-danger"><i class="fa fa-exclamation-triangle"></i><p class="mt-2">Gagal memuat data invoice</p><small>' + error + '</small></div>');
            }
        });
    }

    // Initialize Select2 for Payment Method (only in revisi state)
    function initializeSelect2() {
        if (currentState === 'revisi') {
            $('#payment_method').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih Metode Pembayaran',
                allowClear: true,
                ajax: {
                    url: '/api/master-lov/children?parent_code=PAYMENT_METHOD',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        var results = Array.isArray(data) ? data : [];
                        return {
                            results: results,
                            pagination: {
                                more: false
                            }
                        };
                    },
                    cache: true
                },
                templateResult: function(data) {
                    if (data.loading) return data.text;
                    return data.value || data.text;
                },
                templateSelection: function(data) {
                    return data.value || data.text;
                }
            });
        }
    }

    // Initialize state and load data
    initializeState();
    initializeSelect2();



    // Call load data function with delay to ensure DOM is ready
    console.log('Calling loadInvoiceData...'); // Debug log
    setTimeout(function() {
        loadInvoiceData();
        console.log('Load data function completed'); // Debug log
    }, 100);

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(angka || 0);
    }

    function calculateGrandTotal() {
        let subtotal = 0;
        $('#invoice-items-table tbody tr').each(function() {
            let qty = parseFloat($(this).find('.item-qty').text()) || 0;
            let price = parseFloat($(this).find('.item-price').text().replace(/[^\d]/g, '')) || 0;
            subtotal += qty * price;
        });
        let tax = subtotal * 0.11;
        let pbbkb = subtotal * 0.075;
        let pph23 = subtotal * 0.02;
        let grandTotal = subtotal + tax + pbbkb + pph23;

        $('#subtotal').text(formatRupiah(subtotal));
        $('#tax').text(formatRupiah(tax));
        $('#pbbkb').text(formatRupiah(pbbkb));
        $('#pph23').text(formatRupiah(pph23));
        $('#grand-total').text(formatRupiah(grandTotal));

        // Terbilang
        let valTerbilang = "";
        if (grandTotal > 0) {
            valTerbilang = terbilang(grandTotal).replace(/\s+/g, ' ').trim() + " rupiah";
            valTerbilang = valTerbilang.replace(/  +/g, ' ');
        }
        $('#terbilang').text(valTerbilang);
    }

    // Tambahkan baris dengan NO urut, mirip screenshot
    function refreshTableNo() {
        $('#invoice-items-table tbody tr').each(function(i) {
            $(this).find('.item-no').text(i + 1);
        });
    }

        // Data will be loaded from API, so no need for prefill here

    // Add new item function (only in revisi state)
    $('#btn-add-item').on('click', function() {
        if (currentState !== 'revisi') return;

        const currentRowCount = $('#invoice-items-table tbody tr').length;
        const newIndex = currentRowCount;

        let newRow = `
            <tr data-item-id="">
                <td class="item-no text-center align-middle">${newIndex + 1}</td>
                <td><input type="text" name="details[${newIndex}][nama_item]" class="form-control" required></td>
                <td><input type="number" name="details[${newIndex}][qty]" class="form-control item-qty" value="1" min="1" required></td>
                <td><input type="number" name="details[${newIndex}][harga]" class="form-control item-price" value="0" min="0" required></td>
                <td class="row-total text-end align-middle">0</td>
                <td class="text-center align-middle"><button type="button" class="btn btn-delete-item">×</button></td>
            </tr>
        `;
        $('#invoice-items-table tbody').append(newRow);
        refreshTableNo();
    });

    // Delete item function
    $('#invoice-items-table').on('click', '.btn-delete-item', function() {
        if (currentState !== 'revisi') return;

        $(this).closest('tr').remove();
        refreshTableNo();
        calculateGrandTotal();
    });

    // Calculate row total when input changes
    $('#invoice-items-table').on('input', '.item-qty, .item-price', function() {
        if (currentState !== 'revisi') return;

        const row = $(this).closest('tr');
        const qty = parseFloat(row.find('.item-qty').val()) || 0;
        const price = parseFloat(row.find('.item-price').val()) || 0;
        const total = qty * price;

        row.find('.row-total').text(formatRupiah(total));
        calculateGrandTotal();
    });

    // Refresh table numbering
    function refreshTableNo() {
        $('#invoice-items-table tbody tr').each(function(i) {
            $(this).find('.item-no').text(i + 1);
        });
    }

        // Calculate grand total
    function calculateGrandTotal() {
        if (currentState !== 'revisi') return;

        let subtotal = 0;
        $('#invoice-items-table tbody tr').each(function() {
            let qty = parseFloat($(this).find('.item-qty').val()) || 0;
            let price = parseFloat($(this).find('.item-price').val()) || 0;
            subtotal += qty * price;
        });

        let tax = subtotal * 0.11;
        let pbbkb = subtotal * 0.075;
        let pph23 = subtotal * 0.02;
        let grandTotal = subtotal + tax + pbbkb + pph23;

        $('#subtotal').text(formatRupiah(subtotal));
        $('#tax').text(formatRupiah(tax));
        $('#pbbkb').text(formatRupiah(pbbkb));
        $('#pph23').text(formatRupiah(pph23));
        $('#grand-total').text(formatRupiah(grandTotal));

        // Terbilang
        let valTerbilang = "";
        if (grandTotal > 0) {
            valTerbilang = terbilang(grandTotal).replace(/\s+/g, ' ').trim() + " rupiah";
            valTerbilang = valTerbilang.replace(/  +/g, ' ');
        }
        $('#terbilang').text(valTerbilang);
    }

    // Load remark history function
    function loadRemarks(id, tipe, container) {
        // show loading spinner
        $(container).html('<li class="text-center py-2"><div class="spinner-border text-primary"></div> Memuat riwayat…</li>');

        $.get(`/api/remarks/${id}?tipe_trx=${tipe}`)
            .done(function(remarks){
                if (!remarks.length) {
                    $(container).html('<li class="text-muted">Belum ada remark</li>');
                    return;
                }
                var html = remarks.map(function(r){
                    var color = 'primary';
                    var user = r.user || r.last_updateby || 'User';
                    var comment = r.comment || r.wf_comment || '';
                    if (comment.toLowerCase().includes('approve')) color = 'success';
                    if (comment.toLowerCase().includes('reject'))  color = 'danger';
                    var created = r.created_at
                        ? new Date(r.created_at).toLocaleDateString('id-ID', { year:'numeric', month:'long', day:'numeric' })
                        : '';
                    return `<li class="mb-2 pb-2 border-bottom">
                        <span class="fw-bold text-${color}">• ${user}</span> -
                        <span>${comment}</span>
                        <span class="text-muted ms-2 small">(${created})</span>
                    </li>`;
                }).join('');
                $(container).html(html);
            })
            .fail(function(){
                $(container).html('<li class="text-danger">Gagal memuat riwayat.</li>');
            });
    }

    // Form submission for update (only in revisi state)
    $('#form-view-invoice').on('submit', function(e) {
        e.preventDefault();

        if (currentState !== 'revisi') {
            return;
        }

        const submitButton = $('#btn-update-invoice');
        const buttonText = submitButton.find('.txt');
        const spinner = submitButton.find('.spinner-border');
        const loadingText = submitButton.find('.loading-text');

        // Prevent double submission
        if (submitButton.prop('disabled')) {
            return;
        }

        // Show loading state
        submitButton.prop('disabled', true);
        buttonText.addClass('d-none');
        spinner.removeClass('d-none');
        loadingText.removeClass('d-none');

        // Create FormData
        const formData = new FormData();

        // Add form fields
        formData.append('invoice_date', $('#invoice_date').val());
        formData.append('bill_to', $('#bill_to').val());
        formData.append('ship_to', $('#ship_to').val());
        formData.append('fob', $('#fob').val());
        formData.append('sent_via', $('#sent_via').val());
        formData.append('sent_date', $('#sent_date').val());

        // Add payment method
        const select2Data = $('#payment_method').select2('data');
        let paymentMethodText = $('#payment_method').val();
        if (select2Data && select2Data.length > 0) {
            paymentMethodText = select2Data[0].value || select2Data[0].text || paymentMethodText;
        }
        formData.append('payment_method', paymentMethodText);

        // Add details items
        let detailIndex = 0;
        $('#invoice-items-table tbody tr').each(function() {
            const namaItem = $(this).find('input[name*="[nama_item]"]').val();
            const qty = $(this).find('input[name*="[qty]"]').val();
            const harga = $(this).find('input[name*="[harga]"]').val();
            const itemId = $(this).data('item-id');

            if (namaItem && qty && harga) {
                formData.append(`details[${detailIndex}][id]`, itemId || '');
                formData.append(`details[${detailIndex}][nama_item]`, namaItem);
                formData.append(`details[${detailIndex}][qty]`, qty);
                formData.append(`details[${detailIndex}][harga]`, harga);
                detailIndex++;
            }
        });

        $.ajax({
            url: `/api/finance/invoices/${invoiceId}`,
            type: 'PUT',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Invoice berhasil diperbarui.',
                }).then(() => {
                    window.location.href = '{{ route("invoice") }}';
                });
            },
            complete: function() {
                // Reset loading state
                submitButton.prop('disabled', false);
                buttonText.removeClass('d-none');
                spinner.addClass('d-none');
                loadingText.addClass('d-none');
            },
            error: function(xhr) {
                let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg,
                });
            }
        });
    });
});
// --- PDF SIDEBAR SLIDING ---
function openPdfSidebar(url) {
    $('#pdfSidebarIframe').attr('src', url);
    $('#pdfSidebarOverlay').fadeIn(120);
    $('#pdfSidebar').css('right', '0');
    // Prevent body horizontal scroll
    $('body').css('overflow-x', 'hidden');
}
function closePdfSidebar() {
    $('#pdfSidebarIframe').attr('src', '');
    $('#pdfSidebar').css('right', '-560px');
    $('#pdfSidebarOverlay').fadeOut(120);
    $('body').css('overflow-x', '');
}

// Gantikan default click btn-lihat-po dan btn-lihat-bast
$('#btn-lihat-po').off('click').on('click', function(e){
    e.preventDefault();
    let url = $(this).attr('href');
    if(url && url !== '#' && url.endsWith('.pdf')) openPdfSidebar(url);
});
$('#btn-lihat-bast').off('click').on('click', function(e){
    e.preventDefault();
    let url = $(this).attr('href');
    if(url && url !== '#' && url.endsWith('.pdf')) openPdfSidebar(url);
});
</script>
@endsection
