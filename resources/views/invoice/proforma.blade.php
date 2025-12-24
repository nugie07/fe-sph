@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>Pembuatan Proforma Invoice</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('invoice') }}">Invoice</a></li>
                    <li class="breadcrumb-item active">Proforma Invoice</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Proforma Invoice</h5>
                </div>
                <div class="card-body">
                    <form id="form-proforma-invoice" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <!-- Customer PO - Select2 -->
                            <div class="col-md-6">
                                <label for="po_no" class="form-label">Customer PO <span class="text-danger">*</span></label>
                                <select id="po_no" name="po_no" class="form-control select2" required>
                                    <option value="">Pilih Customer PO</option>
                                </select>
                                <div class="invalid-feedback">Customer PO wajib dipilih.</div>
                            </div>

                            <!-- Nomor Invoice - Manual Input -->
                            <div class="col-md-6">
                                <label for="invoice_no" class="form-label">Nomor Invoice <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Masukkan nomor invoice" required>
                                <div class="invalid-feedback">Nomor Invoice wajib diisi.</div>
                            </div>

                            <!-- Bill To -->
                            <div class="col-md-6">
                                <label class="form-label">Ditagihkan Kepada (Bill To)</label>
                                <textarea class="form-control" name="bill_to" id="bill_to" rows="3" required></textarea>
                            </div>

                            <!-- Ship To -->
                            <div class="col-md-6">
                                <label class="form-label">Dikirimkan Kepada (Ship To)</label>
                                <textarea class="form-control" name="ship_to" id="ship_to" rows="3" required></textarea>
                            </div>

                            <!-- Sent Date -->
                            <div class="col-md-6">
                                <label for="sent_date" class="form-label">Tanggal Kirim <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="sent_date" name="sent_date" required>
                                <div class="invalid-feedback">Tanggal Kirim wajib diisi.</div>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-6">
                                <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select id="payment_method" name="payment_method" class="form-control select2" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                </select>
                                <div class="invalid-feedback">Metode Pembayaran wajib dipilih.</div>
                            </div>

                            <!-- Detail Items Table -->
                            <div class="col-12">
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
                            </div>

                            <!-- Totals -->
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

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Batal</button>
                                <button type="submit" class="btn btn-primary" id="btn-save-proforma">
                                    <span class="txt">Simpan Proforma Invoice</span>
                                    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let itemCounter = 1;

    // Helper function untuk format rupiah
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

    // Helper function untuk terbilang
    function terbilang(n) {
        var angka = ["","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas"];
        n = Math.floor(n);
        if (n < 12) return angka[n];
        if (n < 20) return terbilang(n - 10) + " belas";
        if (n < 100) return terbilang(Math.floor(n/10)) + " puluh" + (n % 10 ? " " + terbilang(n % 10) : "");
        if (n < 200) return "seratus" + (n - 100 ? " " + terbilang(n - 100) : "");
        if (n < 1000) return terbilang(Math.floor(n/100)) + " ratus" + (n % 100 ? " " + terbilang(n % 100) : "");
        if (n < 2000) return "seribu" + (n - 1000 ? " " + terbilang(n - 1000) : "");
        if (n < 1000000) return terbilang(Math.floor(n/1000)) + " ribu" + (n % 1000 ? " " + terbilang(n % 1000) : "");
        if (n < 1000000000) return terbilang(Math.floor(n/1000000)) + " juta" + (n % 1000000 ? " " + terbilang(n % 1000000) : "");
        return terbilang(Math.floor(n/1000000000)) + " miliar" + (n % 1000000000 ? " " + terbilang(n % 1000000000) : "");
    }

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

        // Initialize Select2 for Payment Method
    $('#payment_method').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih Metode Pembayaran',
        allowClear: true,
        ajax: {
            url: '/api/master-lov/children',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    parent_code: 'PAYMENT_METHOD',
                    search: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                console.log('Payment method API response:', data); // Debug log

                // Handle different response formats
                let results = [];
                if (Array.isArray(data)) {
                    results = data;
                } else if (data && data.data && Array.isArray(data.data)) {
                    results = data.data;
                } else if (data && Array.isArray(data)) {
                    results = data;
                }

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
            return data.value || data.text || data.code || data.id;
        },
        templateSelection: function(data) {
            console.log('Template selection data:', data); // Debug log
            return data.value || data.text || data.code || data.id;
        }
    }).on('select2:select', function(e) {
        console.log('Payment method selected:', e.params.data); // Debug log
    });

    // Handle Customer PO change - auto-fill Bill To, Ship To, and Detail Items
    $('#po_no').on('change', function() {
        const customerPo = $(this).val();
        const selectedData = $(this).select2('data')[0];
        
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
                            calculateGrandTotal();
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
        } else {
            // Clear Bill To and Ship To if Customer PO is cleared
            $('#bill_to').val('');
            $('#ship_to').val('');
            // Clear datatable and transport
            $('#invoice-items-table tbody').empty();
            $('#transport').val(formatRupiahInput(0));
            // Recalculate totals
            calculateGrandTotal();
        }
    });

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

    // Add new item row
    $('#btn-add-item').on('click', function() {
        itemCounter++;
        const newRow = `
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

    // Delete item row
    $(document).on('click', '.btn-delete-item', function() {
        if ($('#invoice-items-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
            refreshTableNo();
            calculateGrandTotal();
        } else {
            Swal.fire('Peringatan', 'Minimal harus ada 1 item', 'warning');
        }
    });

    // Update row numbers
    function refreshTableNo() {
        $('#invoice-items-table tbody tr').each(function(i) {
            $(this).find('.item-no').text(i + 1);
        });
    }

    // Recalculate totals when qty or price changes
    $(document).on('input', '.item-qty, .item-price', function() {
        calculateRowTotal($(this).closest('tr'));
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

    // Form submission
    $('#form-proforma-invoice').on('submit', function(e) {
        e.preventDefault();

        // Validate form
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        // Validate items
        let hasValidItems = false;
        $('#invoice-items-table tbody tr').each(function() {
            const namaItem = $(this).find('input[name*="[nama_item]"]').val();
            const qty = $(this).find('.item-qty').val();
            const harga = $(this).find('.item-price').val();

            if (namaItem && qty && harga) {
                hasValidItems = true;
            }
        });

        if (!hasValidItems) {
            Swal.fire('Error', 'Minimal harus ada 1 item yang diisi lengkap', 'error');
            return;
        }

        // Show loading state
        const btn = $('#btn-save-proforma');
        const spinner = btn.find('.spinner-border');
        const txt = btn.find('.txt');

        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        txt.addClass('d-none');

        // Recalculate totals and terbilang before submit
        calculateGrandTotal();

        // Create new FormData to avoid duplicates
        const formData = new FormData();

        // Add all form fields except details (we'll handle details separately)
        const formFields = $(this).serializeArray();
        formFields.forEach(function(field) {
            if (!field.name.includes('details[')) {
                formData.append(field.name, field.value);
            }
        });

        // Get payment method value
        const paymentMethod = $('#payment_method').val();

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

        // Add required fields that don't exist in proforma form (set to null)
        formData.append('dn_no', '');
        formData.append('invoice_date', '');
        formData.append('fob', '');
        formData.append('sent_via', '');
        console.log('Adding required fields with null values: dn_no, invoice_date, fob, sent_via'); // Debug log

        // Add type = 2 for proforma invoice
        formData.append('type', '2');
        console.log('Adding type to payload: 2'); // Debug log

        console.log('FormData entries:'); // Debug log
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Submit form using $.ajax (same as create.blade.php)
        $.ajax({
            url: '/api/finance/invoices', // Same endpoint as create.blade.php
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Proforma Invoice berhasil disimpan',
                }).then(() => {
                    window.location.href = '{{ route("invoice") }}';
                });
            },
            complete: function() {
                btn.prop('disabled', false);
                spinner.addClass('d-none');
                txt.removeClass('d-none');
            },
            error: function(xhr) {
                btn.prop('disabled', false);
                spinner.addClass('d-none');
                txt.removeClass('d-none');

                let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                let errorTitle = 'Oops...';
                
                if (xhr.responseJSON) {
                    const response = xhr.responseJSON;
                    
                    if (response.errors && typeof response.errors === 'object') {
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

    // Set default date to today
    $('#sent_date').val(new Date().toISOString().split('T')[0]);

    // Initialize PPH 23, OAT, and Transport format on page load
    $('#pph23').val(formatRupiahInput(0));
    $('#oat').val(formatRupiahInput(0));
    $('#transport').val(formatRupiahInput(0));

    // Tambahkan baris pertama secara otomatis
    $('#btn-add-item').click();

    // Initial calculation
    calculateGrandTotal();
});
</script>
@endsection

