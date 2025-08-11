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

                            <!-- Terbilang -->
                            <div class="col-12">
                                <label class="form-label">Terbilang:</label>
                                <div class="form-control-plaintext" id="terbilang">Nol rupiah</div>
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
        placeholder: 'Pilih Customer PO',
        ajax: {
            url: '/api/delivery-request/po-list',
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
                console.log('PO list API response:', data); // Debug log

                // Handle different response formats
                let results = [];
                if (Array.isArray(data)) {
                    results = data;
                } else if (data && data.data && Array.isArray(data.data)) {
                    results = data.data;
                } else if (data && Array.isArray(data)) {
                    results = data;
                }

                // Ensure each result has proper structure for Select2
                results = results.map(function(item) {
                    return {
                        id: item.po_no || item.id, // Use po_no as the ID
                        text: item.po_no || item.text,
                        po_no: item.po_no,
                        ...item // Include all original properties
                    };
                });

                console.log('Processed PO results:', results); // Debug log

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
            console.log('PO template result data:', data); // Debug log
            return data.po_no || data.text || data.id;
        },
        templateSelection: function(data) {
            console.log('PO template selection data:', data); // Debug log
            return data.po_no || data.text || data.id;
        },
        // Ensure we store the full object, not just the ID
        escapeMarkup: function(markup) { return markup; }
            }).on('select2:select', function(e) {
        console.log('Select2 select event triggered'); // Debug log
        console.log('Selected data:', e.params.data); // Debug log

        // Make sure we get the actual po_no, not the id
        const selectedPo = e.params.data.po_no || e.params.data.text || e.params.data.id;
        console.log('Selected PO:', selectedPo); // Debug log
        console.log('Full selected data:', e.params.data); // Debug log

        // Debug: Show what would be sent to API
        console.log('Will send to API - po_no:', selectedPo); // Debug log

        if (selectedPo) {
            // Call new API to get customer details by PO
            $.ajax({
                url: '/api/finance/get-customer-by-po',
                method: 'POST',
                dataType: 'json',
                data: {
                    po_no: selectedPo,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Customer by PO response:', response); // Debug log

                    if (response && response.success && response.data) {
                        $('#bill_to').val(response.data.bill_to || '');
                        $('#ship_to').val(response.data.ship_to || '');
                        console.log('Bill To set to:', response.data.bill_to); // Debug log
                        console.log('Ship To set to:', response.data.ship_to); // Debug log
                    } else {
                        console.log('No customer data found in response'); // Debug log
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch customer details:', error); // Debug log
                    console.error('Response:', xhr.responseText); // Debug log

                    // Fallback to old API if new API fails
                    $.ajax({
                        url: `/api/finance/invoices/${selectedPo}`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(fallbackResponse) {
                            console.log('Fallback API response:', fallbackResponse); // Debug log
                            if (fallbackResponse && fallbackResponse.data) {
                                $('#bill_to').val(fallbackResponse.data.bill_to || '');
                                $('#ship_to').val(fallbackResponse.data.ship_to || '');
                            }
                        },
                        error: function(fallbackXhr, fallbackStatus, fallbackError) {
                            console.error('Fallback API also failed:', fallbackError); // Debug log
                        }
                    });
                }
            });
        }
    });

        // Initialize Select2 for Payment Method
    $('#payment_method').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Metode Pembayaran',
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

        // When Customer PO is selected, populate bill_to and ship_to
    $('#po_no').on('change', function() {
        const selectedPo = $(this).val();
        const selectedData = $(this).select2('data');
        console.log('PO changed:', selectedPo); // Debug log
        console.log('Selected data (change):', selectedData); // Debug log

        // Try to get the actual po_no from selected data
        let actualPoNo = selectedPo;
        if (selectedData && selectedData.length > 0) {
            actualPoNo = selectedData[0].po_no || selectedData[0].text || selectedPo;
        }
        console.log('Actual PO No:', actualPoNo); // Debug log

        if (selectedPo) {
            // Call new API to get customer details by PO
            $.ajax({
                url: '/api/finance/get-customer-by-po',
                method: 'POST',
                dataType: 'json',
                data: {
                    po_no: actualPoNo,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Customer by PO response (change):', response); // Debug log

                    if (response && response.success && response.data) {
                        $('#bill_to').val(response.data.bill_to || '');
                        $('#ship_to').val(response.data.ship_to || '');
                        console.log('Bill To set to:', response.data.bill_to); // Debug log
                        console.log('Ship To set to:', response.data.ship_to); // Debug log
                    } else {
                        console.log('No customer data found in response'); // Debug log
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch customer details (change):', error); // Debug log
                    console.error('Response:', xhr.responseText); // Debug log
                }
            });
        } else {
            $('#bill_to').val('');
            $('#ship_to').val('');
            console.log('PO cleared, fields reset'); // Debug log
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

        // Prepare form data
        const formData = new FormData(this);

        // Add terbilang to form data
        const terbilangText = $('#terbilang').text();
        formData.append('terbilang', terbilangText);

        // Submit form
        fetch('/api/finance/proforma-invoices', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            btn.prop('disabled', false);
            spinner.addClass('d-none');
            txt.removeClass('d-none');

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Proforma Invoice berhasil disimpan'
                }).then(() => {
                    window.location.href = '/invoice';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Gagal menyimpan Proforma Invoice'
                });
            }
        })
        .catch(error => {
            btn.prop('disabled', false);
            spinner.addClass('d-none');
            txt.removeClass('d-none');

            console.error('Submit error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat menyimpan. Silakan coba lagi.'
            });
        });
    });

    // Set default date to today
    $('#sent_date').val(new Date().toISOString().split('T')[0]);

    // Tambahkan baris pertama secara otomatis
    $('#btn-add-item').click();

    // Initial calculation
    calculateGrandTotal();
});
</script>
@endsection

