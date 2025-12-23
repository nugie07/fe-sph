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

@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Buat Invoice Baru</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('invoice') }}">Invoice</a></li>
            <li class="breadcrumb-item active">Buat Baru</li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form id="form-create-invoice">
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
                        <input type="text" class="form-control" name="invoice_no" id="invoice_no" readonly required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Invoice</label>
                        <input type="date" class="form-control" name="invoice_date" id="invoice_date" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ditagihkan Kepada (Bill To)</label>
                        <textarea class="form-control" name="bill_to" id="bill_to" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dikirimkan Kepada (Ship To)</label>
                        <textarea class="form-control" name="ship_to" id="ship_to" rows="3" required></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-control select2" name="payment_method" id="payment_method" required>
                            <option value="">Pilih Metode Pembayaran</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">FOB</label>
                        <input type="text" class="form-control" name="fob" id="fob" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jalur</label>
                        <input type="text" class="form-control" name="sent_via" id="sent_via" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sent Date</label>
                        <input type="date" class="form-control" name="sent_date" id="sent_date" required>
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
                                <th style="width: 6%;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Baris item akan ditambahkan oleh JavaScript --}}
                        </tbody>
                        <tfoot>
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
                    <a href="{{ route('invoice') }}" class="btn btn-secondary btn-sq-rounded">Batal</a>
                    <button type="submit" class="btn btn-success btn-sq-rounded" id="btn-save-invoice">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Simpan Invoice
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
    // Initialize Select2 for Payment Method
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
                console.log('API Response:', data); // Debug log
                console.log('Data type:', typeof data); // Debug log
                console.log('Data length:', data ? data.length : 'null'); // Debug log

                // Ensure data is an array
                var results = Array.isArray(data) ? data : [];
                console.log('Processed results:', results); // Debug log

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
            console.log('Template result data:', data); // Debug log
            return data.value || data.text;
        },
        templateSelection: function(data) {
            console.log('Template selection data:', data); // Debug log
            return data.value || data.text;
        }
    });

    // PREFILL DARI QUERY STRING (update to handle po_file and dn_file)
    function prefillFromQueryString() {
        console.log('Prefill function called'); // Debug log
        const params = new URLSearchParams(window.location.search);
        console.log('URL params:', window.location.search); // Debug log

        const dnNo = params.get('dn_no') || '';
        const poNo = params.get('po_no') || '';
        const invoiceNo = params.get('invoice_no') || '';
        const invoiceDate = params.get('invoice_date') || (new Date().toISOString().slice(0,10));
        const shipTo = params.get('ship_to') || '';
        const billTo = params.get('bill_to') || '';
        const fob = params.get('fob') || '';
        const sentVia = params.get('sent_via') || '';
        const sentDate = params.get('sent_date') || '';

                console.log('Extracted values:', { dnNo, poNo, invoiceNo, invoiceDate, shipTo, billTo, fob, sentVia, sentDate }); // Debug log

        // Check if elements exist
        console.log('Checking elements...'); // Debug log
        console.log('dn_no element:', $('#dn_no').length); // Debug log
        console.log('po_no element:', $('#po_no').length); // Debug log
        console.log('invoice_no element:', $('#invoice_no').length); // Debug log
        console.log('ship_to element:', $('#ship_to').length); // Debug log
        console.log('bill_to element:', $('#bill_to').length); // Debug log
        console.log('fob element:', $('#fob').length); // Debug log
        console.log('sent_via element:', $('#sent_via').length); // Debug log

        // Set values to form fields
        $('#dn_no').val(dnNo);
        $('#po_no').val(poNo);
        $('#invoice_no').val(invoiceNo);
        $('#invoice_date').val(invoiceDate);
        $('#ship_to').val(shipTo);
        $('#bill_to').val(billTo);
        $('#fob').val(fob);
        $('#sent_via').val(sentVia);
        $('#sent_date').val(sentDate);

        // Verify values were set
        console.log('Values after setting:'); // Debug log
        console.log('dn_no value:', $('#dn_no').val()); // Debug log
        console.log('po_no value:', $('#po_no').val()); // Debug log
        console.log('ship_to value:', $('#ship_to').val()); // Debug log
        console.log('bill_to value:', $('#bill_to').val()); // Debug log
        console.log('fob value:', $('#fob').val()); // Debug log
        console.log('sent_via value:', $('#sent_via').val()); // Debug log
        console.log('sent_date value:', $('#sent_date').val()); // Debug log

        // Prefill payment method if available
        const paymentMethod = params.get('payment_method');
        if (paymentMethod) {
            // Create option and set it as selected
            const option = new Option(paymentMethod, paymentMethod, true, true);
            $('#payment_method').append(option).trigger('change');
        }

        // Generate invoice number if PO No and DN No are available
        setTimeout(function() {
            if ($('#po_no').val() && $('#dn_no').val()) {
                generateInvoiceNumber();
            }
        }, 500);

        // Prefill for PDF viewer buttons
        const poFile = params.get('po_file');
        const bastFile = params.get('dn_file');
        if (poFile && poFile !== 'null' && poFile !== '') {
            $('#btn-lihat-po').attr('href', publicUrl + poFile).attr('target', '_blank').show();
        } else {
            $('#btn-lihat-po').attr('href', '#').hide();
        }
        if (bastFile && bastFile !== 'null' && bastFile !== '') {
            $('#btn-lihat-bast').attr('href', publicUrl + bastFile).attr('target', '_blank').show();
        } else {
            $('#btn-lihat-bast').attr('href', '#').hide();
        }
    }

    // Call prefill function with delay to ensure DOM is ready
    console.log('Calling prefillFromQueryString...'); // Debug log
    setTimeout(function() {
    prefillFromQueryString();
        console.log('Prefill function completed'); // Debug log
    }, 100);

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(angka || 0);
    }

    function calculateRowTotal(row) {
        let qty = parseFloat(row.find('.item-qty').val()) || 0;
        let price = parseFloat(row.find('.item-price').val()) || 0;
        let total = qty * price;
        row.find('.row-total').text(formatRupiah(total));
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
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

    // Tambahkan baris dengan NO urut, mirip screenshot
    function refreshTableNo() {
        $('#invoice-items-table tbody tr').each(function(i) {
            $(this).find('.item-no').text(i + 1);
        });
    }

    $('#btn-add-item').on('click', function() {
        let newRow = `
            <tr>
                <td class="item-no text-center align-middle"></td>
                <td><input type="text" name="details[][nama_item]" class="form-control" required></td>
                <td><input type="number" name="details[][qty]" class="form-control item-qty" value="1" min="1" required></td>
                <td><input type="number" name="details[][harga]" class="form-control item-price" value="0" min="0" required></td>
                <td class="row-total text-end align-middle">0</td>
                <td class="text-center align-middle"><button type="button" class="btn btn-delete-item">×</button></td>
            </tr>
        `;
        $('#invoice-items-table tbody').append(newRow);
        refreshTableNo();
    });

    $('#invoice-items-table').on('click', '.btn-delete-item', function() {
        $(this).closest('tr').remove();
        refreshTableNo();
        calculateGrandTotal();
    });

    $('#invoice-items-table').on('input', '.item-qty, .item-price', function() {
        calculateRowTotal($(this).closest('tr'));
    });

    // Prefill invoice items if present
    @php
        $prefillDetails = old('details', request('details') ?? ($prefill['details'] ?? []));
    @endphp
    let prefillDetails = @json($prefillDetails);
    if (Array.isArray(prefillDetails) && prefillDetails.length > 0) {
        for (let i = 0; i < prefillDetails.length; i++) {
            let item = prefillDetails[i];
            let nama = item.nama_item ?? '';
            let qty = item.qty ?? 1;
            let harga = item.harga ?? 0;
            let total = (parseFloat(qty) || 0) * (parseFloat(harga) || 0);
            let newRow = `
                <tr>
                    <td class="item-no text-center align-middle"></td>
                    <td><input type="text" name="details[][nama_item]" class="form-control" required value="${nama}"></td>
                    <td><input type="number" name="details[][qty]" class="form-control item-qty" value="${qty}" min="1" required></td>
                    <td><input type="number" name="details[][harga]" class="form-control item-price" value="${harga}" min="0" required></td>
                    <td class="row-total text-end align-middle">${formatRupiah(total)}</td>
                    <td class="text-center align-middle"><button type="button" class="btn btn-delete-item">×</button></td>
                </tr>
            `;
            $('#invoice-items-table tbody').append(newRow);
        }
        refreshTableNo();
        calculateGrandTotal();
    } else {
        // Tambahkan baris pertama secara otomatis
        $('#btn-add-item').click();
    }

    // Hitung total jika input berubah
    $('#invoice-items-table').on('input', '.item-qty, .item-price', function() {
        calculateRowTotal($(this).closest('tr'));
        validateRow($(this).closest('tr'));
    });

    // Real-time validation for item name
    $('#invoice-items-table').on('input', 'input[name*="[nama_item]"]', function() {
        validateRow($(this).closest('tr'));
    });

        // Real-time validation for payment method
    $('#payment_method').on('change', function() {
        validatePaymentMethod();
    });

    // Real-time validation for other required fields
    $('#invoice_date, #bill_to, #ship_to, #fob, #sent_via, #sent_date').on('input change', function() {
        validateField($(this));
    });

    // Validation function for payment method
    function validatePaymentMethod() {
        const paymentMethod = $('#payment_method').val();
        if (!paymentMethod) {
            $('#payment_method').addClass('is-invalid');
        } else {
            $('#payment_method').removeClass('is-invalid');
        }
    }

    // Validation function for individual fields
    function validateField(field) {
        const value = field.val();
        if (!value) {
            field.addClass('is-invalid');
        } else {
            field.removeClass('is-invalid');
        }
    }

    // Validation function
    function validateRow(row) {
        const namaItem = row.find('input[name*="[nama_item]"]').val();
        const qty = row.find('input[name*="[qty]"]').val();
        const harga = row.find('input[name*="[harga]"]').val();

        // Highlight fields that are empty
        if (!namaItem) {
            row.find('input[name*="[nama_item]"]').addClass('is-invalid');
        } else {
            row.find('input[name*="[nama_item]"]').removeClass('is-invalid');
        }

        if (!qty) {
            row.find('input[name*="[qty]"]').addClass('is-invalid');
        } else {
            row.find('input[name*="[qty]"]').removeClass('is-invalid');
        }

        if (!harga) {
            row.find('input[name*="[harga]"]').addClass('is-invalid');
        } else {
            row.find('input[name*="[harga]"]').removeClass('is-invalid');
        }

        // Highlight row if any field is empty
        if (!namaItem || !qty || !harga) {
            row.addClass('table-danger');
        } else {
            row.removeClass('table-danger');
        }
    }

    // Generate Invoice Number when PO No changes
    $('#po_no').on('change keyup', function() {
        generateInvoiceNumber();
    });

    // Function to generate invoice number
    function generateInvoiceNumber() {
        const poNo = $('#po_no').val();
        const dnNo = $('#dn_no').val();

        if (poNo && dnNo) {
            // Show loading state
            $('#invoice_no').val('Generating...');

            $.ajax({
                url: '/api/finance/generate-invoice-no',
                method: 'POST',
                data: {
                    po_no: poNo
                },
                                success: function(response) {
                    console.log('Generate invoice response:', response);

                    // Combine DN No with generated number
                    const generatedNumber = response.invoice_no || response.data || response;
                    const combinedNumber = dnNo + '/' + generatedNumber;

                    // Set the combined number to invoice_no field
                    $('#invoice_no').val(combinedNumber);
                },
                error: function(xhr) {
                    console.error('Error generating invoice number:', xhr);
                    $('#invoice_no').val('');

                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal generate nomor invoice. Silakan coba lagi.',
                    });
                }
            });
        } else {
            // Clear invoice number if PO No or DN No is empty
            $('#invoice_no').val('');
        }
    }

    $('#form-create-invoice').on('submit', function(e) {
        console.log('Form submit triggered'); // Debug log
        e.preventDefault();
        e.stopPropagation();

        const submitButton = $('#btn-save-invoice');
        const buttonText = submitButton.find('.txt');
        const spinner = submitButton.find('.spinner-border');
        const loadingText = submitButton.find('.loading-text');

        // Prevent double submission
        if (submitButton.prop('disabled')) {
            console.log('Form already submitting, ignoring...');
            return;
        }

                // Clean empty rows before submit
        $('#invoice-items-table tbody tr').each(function() {
            const namaItem = $(this).find('input[name*="[nama_item]"]').val();
            const qty = $(this).find('input[name*="[qty]"]').val();
            const harga = $(this).find('input[name*="[harga]"]').val();

            console.log('Checking row:', { namaItem, qty, harga }); // Debug log

            // Remove row if all fields are empty
            if (!namaItem && !qty && !harga) {
                console.log('Removing empty row'); // Debug log
                $(this).remove();
            }
        });

        // Refresh table numbering after removing rows
        refreshTableNo();

                // Validate required fields with detailed feedback
        let hasError = false;
        let errorMessages = [];
        let emptyFields = [];

        // Check payment method
        const paymentMethod = $('#payment_method').val();
        if (!paymentMethod) {
            hasError = true;
            emptyFields.push('Metode Pembayaran');
            $('#payment_method').addClass('is-invalid');
        } else {
            $('#payment_method').removeClass('is-invalid');
        }

        // Check other required fields
        const requiredFields = [
            { id: 'invoice_date', name: 'Tanggal Invoice' },
            { id: 'bill_to', name: 'Bill To' },
            { id: 'ship_to', name: 'Ship To' },
            { id: 'fob', name: 'FOB' },
            { id: 'sent_via', name: 'Jalur' },
            { id: 'sent_date', name: 'Sent Date' }
        ];

        requiredFields.forEach(function(field) {
            const value = $(`#${field.id}`).val();
            if (!value) {
                hasError = true;
                emptyFields.push(field.name);
                $(`#${field.id}`).addClass('is-invalid');
            } else {
                $(`#${field.id}`).removeClass('is-invalid');
            }
        });

        // Check table rows
        $('#invoice-items-table tbody tr').each(function(index) {
            const rowNumber = index + 1;
            const namaItem = $(this).find('input[name*="[nama_item]"]').val();
            const qty = $(this).find('input[name*="[qty]"]').val();
            const harga = $(this).find('input[name*="[harga]"]').val();

            let rowErrors = [];

            if (!namaItem) {
                rowErrors.push('Nama Item');
                $(this).find('input[name*="[nama_item]"]').addClass('is-invalid');
            } else {
                $(this).find('input[name*="[nama_item]"]').removeClass('is-invalid');
            }

            if (!qty) {
                rowErrors.push('Quantity');
                $(this).find('input[name*="[qty]"]').addClass('is-invalid');
            } else {
                $(this).find('input[name*="[qty]"]').removeClass('is-invalid');
            }

            if (!harga) {
                rowErrors.push('Harga');
                $(this).find('input[name*="[harga]"]').addClass('is-invalid');
            } else {
                $(this).find('input[name*="[harga]"]').removeClass('is-invalid');
            }

            if (rowErrors.length > 0) {
                hasError = true;
                $(this).addClass('table-danger');
                errorMessages.push(`Baris ${rowNumber}: ${rowErrors.join(', ')}`);
            } else {
                $(this).removeClass('table-danger');
            }
        });

        if (hasError) {
            let errorText = 'Mohon lengkapi field berikut:\n\n';

            if (emptyFields.length > 0) {
                errorText += `• ${emptyFields.join(', ')}\n\n`;
            }

            if (errorMessages.length > 0) {
                errorText += errorMessages.join('\n');
            }

            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                html: errorText.replace(/\n/g, '<br>'),
                confirmButtonText: 'OK',
                width: '500px'
            });
            return;
        }

        // Recalculate totals and terbilang before submit
        calculateGrandTotal();

        // Show loading state
        submitButton.prop('disabled', true);
        buttonText.addClass('d-none');
        spinner.removeClass('d-none');
        loadingText.removeClass('d-none');

                        // Create new FormData to avoid duplicates
        const formData = new FormData();

        // Add all form fields except details (we'll handle details separately)
        const formFields = $(this).serializeArray();
        formFields.forEach(function(field) {
            if (!field.name.includes('details[')) {
                formData.append(field.name, field.value);
            }
        });

        // Add invoice ID from URL if available
        const urlParams = new URLSearchParams(window.location.search);
        const invoiceId = urlParams.get('id');
        const invoiceIdd = urlParams.get('idd');

        if (invoiceIdd) {
            console.log('Adding invoice IDD to payload:', invoiceIdd); // Debug log
            formData.append('idd', invoiceIdd);
        } else if (invoiceId) {
            console.log('Adding invoice ID to payload:', invoiceId); // Debug log
            formData.append('id', invoiceId);
        }

        // Debug payment method (reuse existing variable)
        console.log('Payment method value:', paymentMethod); // Debug log
        console.log('Payment method selected:', $('#payment_method').select2('data')); // Debug log

        // Ensure payment method is included with correct value
        if (paymentMethod) {
            // Get the selected option text from Select2 data
            const select2Data = $('#payment_method').select2('data');
            let paymentMethodText = paymentMethod;

            if (select2Data && select2Data.length > 0) {
                paymentMethodText = select2Data[0].value || select2Data[0].text || paymentMethod;
            } else {
                // Fallback to option text
                const selectedOption = $('#payment_method option:selected');
                paymentMethodText = selectedOption.text() || paymentMethod;
            }

            console.log('Payment method text:', paymentMethodText); // Debug log
            formData.set('payment_method', paymentMethodText);
        }

        // Add all calculation values to payload
        const subtotal = $('#subtotal').text().replace(/[^\d]/g, '') || '0';
        const tax = $('#tax').text().replace(/[^\d]/g, '') || '0';
        const pbbkb = $('#pbbkb').text().replace(/[^\d]/g, '') || '0';
        const pph23 = $('#pph23').text().replace(/[^\d]/g, '') || '0';
        const grandTotal = $('#grand-total').text().replace(/[^\d]/g, '') || '0';
        const terbilangText = $('#terbilang').text();

        console.log('Adding calculation values to payload:', { subtotal, tax, pbbkb, pph23, grandTotal, terbilangText }); // Debug log

        formData.append('subtotal', subtotal);
        formData.append('tax', tax);
        formData.append('pbbkb', pbbkb);
        formData.append('pph23', pph23);
        formData.append('grand_total', grandTotal);

        if (terbilangText && terbilangText.trim() !== '') {
            formData.append('terbilang', terbilangText.trim());
        }

        // Add only non-empty details with proper indexing
        let detailIndex = 0;
        $('#invoice-items-table tbody tr').each(function() {
            const namaItem = $(this).find('input[name*="[nama_item]"]').val();
            const qty = $(this).find('input[name*="[qty]"]').val();
            const harga = $(this).find('input[name*="[harga]"]').val();

            console.log('Row data:', { namaItem, qty, harga }); // Debug log

            if (namaItem && qty && harga) {
                formData.append(`details[${detailIndex}][nama_item]`, namaItem);
                formData.append(`details[${detailIndex}][qty]`, qty);
                formData.append(`details[${detailIndex}][harga]`, harga);
                detailIndex++;
            }
        });

        console.log('FormData entries:'); // Debug log
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: '/api/finance/invoices', // URL simpan API Invoice
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                }).then(() => {
                    window.location.href = '{{ route("invoice") }}';
                });
            },
            complete: function() {
                // Reset loading state in all cases
                submitButton.prop('disabled', false);
                buttonText.removeClass('d-none');
                spinner.addClass('d-none');
                loadingText.addClass('d-none');
            },
            error: function(xhr) {
                // Reset loading state
                submitButton.prop('disabled', false);
                buttonText.removeClass('d-none');
                spinner.addClass('d-none');
                loadingText.addClass('d-none');

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

    // Backup handler for button click
    $('#btn-save-invoice').on('click', function(e) {
        e.preventDefault();
        console.log('Button click triggered'); // Debug log

        // Prevent double submission
        if ($(this).prop('disabled')) {
            console.log('Button already disabled, ignoring...');
            return;
        }

        $('#form-create-invoice').submit();
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
