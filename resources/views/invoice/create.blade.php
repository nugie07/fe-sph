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
    .select2-container.is-invalid .select2-selection {
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
                        <label class="form-label">Customer PO</label>
                        <select class="form-control select2" name="po_no" id="po_no" required>
                            <option value="">Pilih Customer PO</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dn No</label>
                        <select class="form-control select2" name="dn_no" id="dn_no" required style="display:none;">
                            <option value="">Pilih DN No</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor Invoice</label>
                        <input type="text" class="form-control" name="invoice_no" id="invoice_no" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Invoice</label>
                        <input type="date" class="form-control" name="invoice_date" id="invoice_date" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ditagihkan Kepada (Bill To)</label>
                        <input type="text" class="form-control" name="bill_to" id="bill_to" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dikirimkan Kepada (Ship To)</label>
                        <input type="text" class="form-control" name="ship_to" id="ship_to" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bill To Address</label>
                        <textarea class="form-control" name="bill_to_address" id="bill_to_address" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ship To Address</label>
                        <textarea class="form-control" name="ship_to_address" id="ship_to_address" rows="3"></textarea>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <span>PPH 23 (2%):</span>
                            <input type="text" class="form-control" name="pph23" id="pph23" value="0,00" style="width: 150px; text-align: right;">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>OAT:</span>
                            <input type="text" class="form-control" name="oat" id="oat" value="0" style="width: 150px; text-align: right;">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Transport:</span>
                            <input type="text" class="form-control" name="transport" id="transport" value="0" style="width: 150px; text-align: right;">
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
    // Initialize Select2 for Customer PO
    $('#po_no').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih Customer PO',
        allowClear: true,
        ajax: {
            url: '/api/list/purchase-order/supplier/approve',
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
                console.log('Customer PO API Response:', data);

                // Handle response structure: { success: true, data: [...] } or direct array
                var results = [];
                if (Array.isArray(data)) {
                    results = data;
                } else if (data && data.data && Array.isArray(data.data)) {
                    results = data.data;
                } else if (data && Array.isArray(data)) {
                    results = data;
                }
                
                console.log('Processed results:', results);
                
                // Map response to Select2 format
                var mappedResults = results.map(function(item) {
                    var customerPo = item.customer_po || item.po_no || item.text || item.name || '';
                    var itemId = item.customer_po || item.po_no || item.id || customerPo;
                    
                    // Try various possible field names for customer name
                    var namaCustomer = item.nama_customer || 
                                     item.nama || 
                                     item.name || 
                                     item.customer_name || 
                                     item.customer || 
                                     '';
                    
                    return {
                        id: itemId,
                        text: customerPo,
                        // Store full item data for later use (all properties from original item)
                        originalData: item,
                        nama_customer: namaCustomer
                    };
                });

                console.log('Mapped results:', mappedResults);

                return {
                    results: mappedResults,
                    pagination: {
                        more: false
                    }
                };
            },
            cache: true
        },
        templateResult: function(data) {
            if (data.loading) return data.text;
            return data.text;
        },
        templateSelection: function(data) {
            return data.text;
        }
    });

    // Initialize Select2 for DN No (will be populated when Customer PO is selected)
    $('#dn_no').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih DN No',
        allowClear: true
    });

    // Function to fetch customer data and fill Bill To & Ship To
    function fetchCustomerData(name) {
        if (!name) {
            console.log('No customer name provided');
            return;
        }
        
        console.log('Fetching customer data for:', name);
        
        $.ajax({
            url: '/api/finance/generate-cust-data',
            method: 'GET',
            data: {
                name: name
            },
            success: function(response) {
                console.log('Customer Data API Response:', response);
                
                // Extract bill_to, ship_to, and addresses from response
                var customerData = response.data || response;
                if (customerData) {
                    // Handle Bill To - use bill_to if available, otherwise use name only
                    var billToText = '';
                    if (customerData.bill_to && customerData.bill_to !== null && customerData.bill_to !== '') {
                        billToText = customerData.bill_to;
                    } else if (customerData.name) {
                        billToText = customerData.name;
                    }
                    
                    if (billToText) {
                        $('#bill_to').val(billToText);
                        console.log('Bill To filled:', billToText);
                    } else {
                        console.log('No bill_to or name available');
                    }
                    
                    // Handle Bill To Address - use bill_to_address if available, otherwise use address
                    var billToAddress = '';
                    if (customerData.bill_to_address && customerData.bill_to_address !== null && customerData.bill_to_address !== '') {
                        billToAddress = customerData.bill_to_address;
                    } else if (customerData.address && customerData.address !== null && customerData.address !== '') {
                        billToAddress = customerData.address;
                    }
                    
                    if (billToAddress) {
                        $('#bill_to_address').val(billToAddress);
                        console.log('Bill To Address filled:', billToAddress);
                    }
                    
                    // Handle Ship To - use ship_to if available, otherwise use name only
                    var shipToText = '';
                    if (customerData.ship_to && customerData.ship_to !== null && customerData.ship_to !== '') {
                        shipToText = customerData.ship_to;
                    } else if (customerData.name) {
                        shipToText = customerData.name;
                    }
                    
                    if (shipToText) {
                        $('#ship_to').val(shipToText);
                        console.log('Ship To filled:', shipToText);
                    } else {
                        console.log('No ship_to or name available');
                    }
                    
                    // Handle Ship To Address - use ship_to_address if available, otherwise use address
                    var shipToAddress = '';
                    if (customerData.ship_to_address && customerData.ship_to_address !== null && customerData.ship_to_address !== '') {
                        shipToAddress = customerData.ship_to_address;
                    } else if (customerData.address && customerData.address !== null && customerData.address !== '') {
                        shipToAddress = customerData.address;
                    }
                    
                    if (shipToAddress) {
                        $('#ship_to_address').val(shipToAddress);
                        console.log('Ship To Address filled:', shipToAddress);
                    }
                } else {
                    console.log('No customer data in response');
                }
            },
            error: function(xhr) {
                console.error('Error loading customer data:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseJSON || xhr.responseText);
            }
        });
    }

    // Handle Customer PO change - load DN No options and auto-fill Bill To & Ship To
    $('#po_no').on('change', function() {
        const customerPo = $(this).val();
        const selectedData = $(this).select2('data')[0];
        
        // Clear DN No (invoice_no is now editable, so don't clear it automatically)
        $('#dn_no').val(null).trigger('change');
        $('#dn_no').html('<option value="">Pilih DN No</option>');
        $('#dn_no').hide();
        
        if (customerPo) {
            // First, try to get nama_customer from selected data
            let namaCustomer = '';
            if (selectedData) {
                namaCustomer = selectedData.nama_customer || 
                              (selectedData.originalData && selectedData.originalData.nama_customer) ||
                              '';
            }
            
            console.log('Selected Customer PO:', customerPo);
            console.log('Nama Customer from selected data:', namaCustomer);
            console.log('Selected Data:', selectedData);
            
            // If nama_customer is not in selected data, fetch it from API
            if (!namaCustomer) {
                $.ajax({
                    url: '/api/list/purchase-order/supplier/approve',
                    method: 'GET',
                    data: {
                        search: customerPo
                    },
                    success: function(response) {
                        console.log('Customer PO Detail API Response:', response);
                        
                        var results = [];
                        if (Array.isArray(response)) {
                            results = response;
                        } else if (response && response.data && Array.isArray(response.data)) {
                            results = response.data;
                        }
                        
                        // Find matching Customer PO
                        var matchedPo = results.find(function(item) {
                            return (item.customer_po || item.po_no) === customerPo;
                        });
                        
                        console.log('Matched PO:', matchedPo);
                        
                        if (matchedPo) {
                            // Try various possible field names for customer name
                            namaCustomer = matchedPo.nama_customer || 
                                         matchedPo.nama || 
                                         matchedPo.name || 
                                         matchedPo.customer_name || 
                                         matchedPo.customer || 
                                         '';
                            
                            console.log('Nama Customer from API:', namaCustomer);
                            console.log('All matched PO fields:', Object.keys(matchedPo));
                            
                            // Now fetch Bill To and Ship To
                            if (namaCustomer) {
                                fetchCustomerData(namaCustomer);
                            } else {
                                console.warn('No customer name found in Customer PO data');
                            }
                        } else {
                            console.warn('Customer PO not found in API response');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching Customer PO detail:', xhr);
                    }
                });
            } else {
                // nama_customer is available, fetch Bill To and Ship To directly
                fetchCustomerData(namaCustomer);
            }
            
            // Fetch PO Customer data to populate datatable and transport
            $.ajax({
                url: '/api/finance/generate-po-customer',
                method: 'GET',
                data: {
                    po_no: customerPo
                },
                success: function(response) {
                    console.log('PO Customer API Response:', response);
                    
                    if (response && response.success && response.data) {
                        const poData = response.data;
                        
                        // Populate transport from good_receipt.transport
                        if (poData.good_receipt && poData.good_receipt.transport) {
                            const transportValue = poData.good_receipt.transport;
                            $('#transport').val(formatRupiahInput(transportValue));
                            console.log('Transport filled:', transportValue);
                        }
                        
                        // Populate datatable from details array
                        if (poData.details && Array.isArray(poData.details) && poData.details.length > 0) {
                            // Clear existing rows first
                            $('#invoice-items-table tbody').empty();
                            
                            // Add rows from details
                            poData.details.forEach(function(detail) {
                                const namaItem = detail.nama_item || '';
                                const qty = detail.qty || 0;
                                const harga = detail.per_item || 0;
                                const total = qty * harga;
                                
                                const newRow = `
                                    <tr>
                                        <td class="item-no text-center align-middle"></td>
                                        <td><input type="text" name="details[][nama_item]" class="form-control" required value="${namaItem}"></td>
                                        <td><input type="number" name="details[][qty]" class="form-control item-qty" value="${qty}" min="1" required></td>
                                        <td><input type="number" name="details[][harga]" class="form-control item-price" value="${harga}" min="0" required></td>
                                        <td class="row-total text-end align-middle">${formatRupiah(total)}</td>
                                        <td class="text-center align-middle"><button type="button" class="btn btn-delete-item">×</button></td>
                                    </tr>
                                `;
                                $('#invoice-items-table tbody').append(newRow);
                            });
                            
                            // Refresh table numbering
                            refreshTableNo();
                            
                            // Recalculate totals
                            calculateGrandTotal();
                            
                            console.log('Datatable populated with', poData.details.length, 'items');
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching PO Customer data:', xhr);
                    // Don't show error to user, just log it
                }
            });
            
            // Show loading state
            $('#dn_no').show();
            $('#dn_no').html('<option value="">Loading...</option>').trigger('change');
            
            // Fetch DN No list from API
            $.ajax({
                url: '/api/finance/dn-list-invoice',
                method: 'GET',
                data: {
                    customer_po: customerPo
                },
                success: function(response) {
                    console.log('DN No API Response:', response);
                    
                    // Clear existing options
                    $('#dn_no').html('<option value="">Pilih DN No</option>');
                    
                    // Ensure response is an array
                    var dnList = Array.isArray(response) ? response : (response.data || []);
                    
                    // Populate DN No dropdown
                    dnList.forEach(function(item) {
                        var dnNo = item.dn_no || item.dnNo || item.id || item.text;
                        var optionText = item.dn_no || item.dnNo || item.text || item.name;
                        $('#dn_no').append(new Option(optionText, dnNo, false, false));
                    });
                    
                    $('#dn_no').trigger('change');
                },
                error: function(xhr) {
                    console.error('Error loading DN No:', xhr);
                    $('#dn_no').html('<option value="">Error loading DN No</option>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat daftar DN No. Silakan coba lagi.',
                    });
                }
            });
        } else {
            // Clear Bill To and Ship To if Customer PO is cleared
            $('#bill_to').val('');
            $('#ship_to').val('');
            $('#bill_to_address').val('');
            $('#ship_to_address').val('');
            // Clear datatable and transport
            $('#invoice-items-table tbody').empty();
            $('#transport').val(formatRupiahInput(0));
            // Recalculate totals
            calculateGrandTotal();
        }
    });

    // Handle DN No change - generate invoice number
    $('#dn_no').on('change', function() {
        generateInvoiceNumber();
    });

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
        const billToAddress = params.get('bill_to_address') || '';
        const shipToAddress = params.get('ship_to_address') || '';
        const fob = params.get('fob') || '';
        const sentVia = params.get('sent_via') || '';
        const sentDate = params.get('sent_date') || '';

                console.log('Extracted values:', { dnNo, poNo, invoiceNo, invoiceDate, shipTo, billTo, billToAddress, shipToAddress, fob, sentVia, sentDate }); // Debug log

        // Check if elements exist
        console.log('Checking elements...'); // Debug log
        console.log('dn_no element:', $('#dn_no').length); // Debug log
        console.log('po_no element:', $('#po_no').length); // Debug log
        console.log('invoice_no element:', $('#invoice_no').length); // Debug log
        console.log('ship_to element:', $('#ship_to').length); // Debug log
        console.log('bill_to element:', $('#bill_to').length); // Debug log
        console.log('fob element:', $('#fob').length); // Debug log
        console.log('sent_via element:', $('#sent_via').length); // Debug log

        // Set values to form fields (for non-dropdown fields)
        $('#invoice_no').val(invoiceNo);
        $('#invoice_date').val(invoiceDate);
        $('#ship_to').val(shipTo);
        $('#bill_to').val(billTo);
        $('#bill_to_address').val(billToAddress);
        $('#ship_to_address').val(shipToAddress);
        $('#fob').val(fob);
        $('#sent_via').val(sentVia);
        $('#sent_date').val(sentDate);

        // Prefill Customer PO if available
        if (poNo) {
            // Create option and set it as selected for Customer PO
            const poOption = new Option(poNo, poNo, true, true);
            $('#po_no').append(poOption).trigger('change');
            
            // If Bill To and Ship To are not in query string, try to fetch from API
            if (!billTo || !shipTo) {
                // Fetch Customer PO data to get nama_customer
                setTimeout(function() {
                    $.ajax({
                        url: '/api/list/purchase-order/supplier/approve',
                        method: 'GET',
                        data: {
                            search: poNo
                        },
                        success: function(response) {
                            var results = [];
                            if (Array.isArray(response)) {
                                results = response;
                            } else if (response && response.data && Array.isArray(response.data)) {
                                results = response.data;
                            }
                            
                            // Find matching Customer PO
                            var matchedPo = results.find(function(item) {
                                return (item.customer_po || item.po_no) === poNo;
                            });
                            
                            if (matchedPo) {
                                var namaCustomer = matchedPo.nama_customer || 
                                                 matchedPo.nama || 
                                                 matchedPo.name || 
                                                 matchedPo.customer_name || 
                                                 matchedPo.customer || 
                                                 '';
                                if (namaCustomer) {
                                    // Fetch Bill To and Ship To
                                    fetchCustomerData(namaCustomer);
                                }
                            }
                        },
                        error: function(xhr) {
                            console.error('Error loading Customer PO data:', xhr);
                        }
                    });
                }, 300);
            }
            
            // After Customer PO is set, load DN No options
            setTimeout(function() {
                $.ajax({
                    url: '/api/finance/dn-list-invoice',
                    method: 'GET',
                    data: {
                        customer_po: poNo
                    },
                    success: function(response) {
                        var dnList = Array.isArray(response) ? response : (response.data || []);
                        $('#dn_no').html('<option value="">Pilih DN No</option>');
                        dnList.forEach(function(item) {
                            var dnNoValue = item.dn_no || item.dnNo || item.id || item.text;
                            var optionText = item.dn_no || item.dnNo || item.text || item.name;
                            $('#dn_no').append(new Option(optionText, dnNoValue, false, false));
                        });
                        $('#dn_no').show();
                        
                        // Set DN No if available
                        if (dnNo) {
                            $('#dn_no').val(dnNo).trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading DN No:', xhr);
                        $('#dn_no').html('<option value="">Error loading DN No</option>');
                    }
                });
            }, 500);
        }

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

    // Function to parse rupiah format to number (remove dots and commas)
    function parseRupiah(rupiahString) {
        if (!rupiahString) return 0;
        // Remove all non-digit characters except decimal point
        let cleaned = rupiahString.toString().replace(/[^\d,]/g, '').replace(',', '.');
        return parseFloat(cleaned) || 0;
    }

    // Function to format rupiah without decimal places for input fields (PPH 23, OAT, Transport)
    function formatRupiahInput(angka) {
        return new Intl.NumberFormat('id-ID', { 
            style: 'decimal', 
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(angka || 0);
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
        // PPH 23 auto-calculate (2% of subtotal), but field is editable
        let pph23Auto = subtotal * 0.02;
        let pph23 = 0;
        
        // Only auto-update PPH 23 if it hasn't been manually edited
        if (!pph23ManuallyEdited) {
            // Use auto-calculated value
            pph23 = pph23Auto;
            $('#pph23').val(formatRupiahInput(pph23Auto));
        } else {
            // Use manually edited value (parse from rupiah format)
            pph23 = parseRupiah($('#pph23').val());
        }
        
        // OAT and Transport are manual input fields (parse from rupiah format)
        let oat = parseRupiah($('#oat').val()) || 0;
        let transport = parseRupiah($('#transport').val()) || 0;
        let grandTotal = subtotal + tax + pbbkb + pph23 + oat + transport;

        $('#subtotal').text(formatRupiah(subtotal));
        $('#tax').text(formatRupiah(tax));
        $('#pbbkb').text(formatRupiah(pbbkb));
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

    // Real-time validation for Customer PO and DN No
    $('#po_no').on('change', function() {
        validateField($(this));
    });

    $('#dn_no').on('change', function() {
        validateField($(this));
    });

    // Real-time validation for other required fields
    $('#invoice_date, #bill_to, #ship_to, #fob, #sent_via, #sent_date').on('input change', function() {
        validateField($(this));
    });

    // Flag to track if PPH 23 has been manually edited
    let pph23ManuallyEdited = false;

    // Event handler for PPH 23 - parse on focus (remove format for editing)
    $('#pph23').on('focus', function() {
        let value = parseRupiah($(this).val());
        $(this).val(value.toString().replace('.', ','));
    });

    // Event handler for PPH 23 - mark as manually edited and recalculate
    $('#pph23').on('input', function() {
        let value = $(this).val();
        // If field is cleared, reset to auto-calculate
        if (value === '' || value === '0' || value === '0,00' || parseRupiah(value) === 0) {
            pph23ManuallyEdited = false;
        } else {
            pph23ManuallyEdited = true;
        }
        calculateGrandTotal();
    });

    // Format PPH 23 on blur (format with rupiah)
    $('#pph23').on('blur', function() {
        let value = parseRupiah($(this).val());
        $(this).val(formatRupiahInput(value));
        calculateGrandTotal();
    });

    // Event handler for OAT and Transport - parse on focus (remove format for editing)
    $('#oat, #transport').on('focus', function() {
        let value = parseRupiah($(this).val());
        $(this).val(value.toString().replace('.', ','));
    });

    // Event handler for OAT and Transport to recalculate total
    $('#oat, #transport').on('input change', function() {
        calculateGrandTotal();
    });

    // Format OAT and Transport on blur (format with rupiah without decimal)
    $('#oat, #transport').on('blur', function() {
        let value = parseRupiah($(this).val());
        $(this).val(formatRupiahInput(value));
        calculateGrandTotal();
    });

    // Initialize PPH 23, OAT, and Transport format on page load
    $('#pph23').val(formatRupiahInput(0));
    $('#oat').val(formatRupiahInput(0));
    $('#transport').val(formatRupiahInput(0));

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
        // For Select2, also check if it's a select element
        if (field.is('select')) {
            if (!value || value === '') {
                field.addClass('is-invalid');
                field.next('.select2-container').addClass('is-invalid');
            } else {
                field.removeClass('is-invalid');
                field.next('.select2-container').removeClass('is-invalid');
            }
        } else {
            if (!value) {
                field.addClass('is-invalid');
            } else {
                field.removeClass('is-invalid');
            }
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

        // Check Customer PO
        const poNo = $('#po_no').val();
        if (!poNo) {
            hasError = true;
            emptyFields.push('Customer PO');
            $('#po_no').addClass('is-invalid');
            $('#po_no').next('.select2-container').addClass('is-invalid');
        } else {
            $('#po_no').removeClass('is-invalid');
            $('#po_no').next('.select2-container').removeClass('is-invalid');
        }

        // Check DN No
        const dnNo = $('#dn_no').val();
        if (!dnNo) {
            hasError = true;
            emptyFields.push('DN No');
            $('#dn_no').addClass('is-invalid');
            $('#dn_no').next('.select2-container').addClass('is-invalid');
        } else {
            $('#dn_no').removeClass('is-invalid');
            $('#dn_no').next('.select2-container').removeClass('is-invalid');
        }

        // Check payment method
        const paymentMethod = $('#payment_method').val();
        if (!paymentMethod) {
            hasError = true;
            emptyFields.push('Metode Pembayaran');
            $('#payment_method').addClass('is-invalid');
            $('#payment_method').next('.select2-container').addClass('is-invalid');
        } else {
            $('#payment_method').removeClass('is-invalid');
            $('#payment_method').next('.select2-container').removeClass('is-invalid');
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

        // Add type = 1 for invoice creation
        formData.append('type', '1');
        console.log('Adding type to payload: 1'); // Debug log

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
        // PPH 23 is now from input field (parse from rupiah format)
        const pph23 = parseRupiah($('#pph23').val()) || 0;
        // OAT and Transport are from input fields (parse from rupiah format)
        const oat = parseRupiah($('#oat').val()) || 0;
        const transport = parseRupiah($('#transport').val()) || 0;
        const grandTotal = $('#grand-total').text().replace(/[^\d]/g, '') || '0';
        const terbilangText = $('#terbilang').text();

        console.log('Adding calculation values to payload:', { subtotal, tax, pbbkb, pph23, oat, transport, grandTotal, terbilangText }); // Debug log

        formData.append('subtotal', subtotal);
        formData.append('tax', tax);
        formData.append('pbbkb', pbbkb);
        formData.append('pph23', pph23);
        formData.append('oat', oat);
        formData.append('transport', transport);
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
                let errorTitle = 'Oops...';
                
                if (xhr.responseJSON) {
                    const response = xhr.responseJSON;
                    
                    // Check if there are detailed errors
                    if (response.errors && typeof response.errors === 'object') {
                        // Collect all error messages
                        let errorMessages = [];
                        for (let field in response.errors) {
                            if (Array.isArray(response.errors[field])) {
                                errorMessages.push(...response.errors[field]);
                            } else {
                                errorMessages.push(response.errors[field]);
                            }
                        }
                        
                        if (errorMessages.length > 0) {
                            errorMsg = errorMessages.join('<br>');
                            errorTitle = response.message || 'Validation Error';
                        } else if (response.message) {
                            errorMsg = response.message;
                        }
                    } else if (response.message) {
                        errorMsg = response.message;
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: errorTitle,
                    html: errorMsg,
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
