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
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6">
        <h3>Form Pembuatan PO Transportir</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item"><a href="{{ route('purchase_order.index') }}">Purchase Order</a></li>
          <li class="breadcrumb-item active">Create PO Transportir</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        
        <div class="card-body">
          <form id="form-create-po-transportir" class="needs-validation" novalidate>
            <div class="row g-4">
              <input type="hidden" name="drs_unique" id="cp_drs_unique">
              <input type="hidden" name="category" id="cp_category" value="2">
              <div class="col-md-4">
                <label>Customer PO</label>
                <select id="select-po" name="po_id" class="form-control select2" required>
                  <option value=""></option>
                </select>
                <input type="hidden" id="po_number" name="po_number" />
                <div class="invalid-feedback">Field Customer PO wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Nama Customer</label>
                <input type="text" id="cp_nama_customer" class="form-control" readonly>
                <div class="invalid-feedback">Field Nama Customer wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Dn No</label>
                <input type="text" name="dn_no" id="cp_dn_no" class="form-control" required>
                <div class="invalid-feedback">Field Dn No wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Vendor Name</label>
                <select id="cp_vendor_name" name="vendor_name" class="form-control select2" required>
                </select>
                <div class="invalid-feedback">Field Vendor Name wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Nomer PO</label>
                <input type="text" name="vendor_po" id="cp_vendor_po" class="form-control" required>
                <div class="invalid-feedback">Field Nomer PO wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Tanggal PO</label>
                <input type="text" name="tgl_po" id="cp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required>
                <div class="invalid-feedback">Field Tanggal PO wajib diisi.</div>
              </div>
              <div class="col-md-3">
                <label>Nama PIC</label>
                <input type="text" name="nama" id="cp_nama" class="form-control" required>
                <div class="invalid-feedback">Field Nama PIC wajib diisi.</div>
              </div>
              <div class="col-md-3">
                <label>Contact</label>
                <input type="text" name="contact" id="cp_contact" class="form-control" required>
                <div class="invalid-feedback">Field Contact wajib diisi.</div>
              </div>
              <div class="col-md-6">
                <label>Alamat</label>
                <input type="text" name="alamat" id="cp_alamat" class="form-control" required>
                <div class="invalid-feedback">Field Alamat wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Metode Pembayaran</label>
                <select id="cp_term" name="term" class="form-control select2" required></select>
                <div class="invalid-feedback">Field Metode Pembayaran wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>FOB</label>
                <input type="text" name="fob" id="cp_fob" class="form-control" required>
                <div class="invalid-feedback">Field FOB wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Shipped Via</label>
                <input type="text" name="shipped_via" id="cp_shipped_via" class="form-control" required>
                <div class="invalid-feedback">Field Shipped Via wajib diisi.</div>
              </div>
              <div class="col-md-6">
                <label>Loading Point</label>
                <input type="text" name="loading_point" id="cp_loading_point" class="form-control" required>
                <div class="invalid-feedback">Field Loading Point wajib diisi.</div>
              </div>
              <div class="col-md-6">
                <label>Delivery To</label>
                <select name="delivery_to" id="cp_delivery_to" class="form-control select2" required>
                  <option value="">Pilih Vendor terlebih dahulu</option>
                </select>
                <div class="invalid-feedback">Field Delivery To wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Qty by KL</label>
                <select id="cp_qty" class="form-control select2" required>
                  <option value="">Pilih Delivery To terlebih dahulu</option>
                </select>
                <input type="hidden" name="qty" id="cp_qty_submit">
                <div class="invalid-feedback">Field Qty wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Portal</label>
                <input type="text" id="cp_transport" class="form-control" required>
                <div class="invalid-feedback">Field Portal wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Unit Price</label>
                <input type="text" id="cp_harga" class="form-control" required>
                <div class="invalid-feedback">Field Unit Price wajib diisi.</div>
              </div>
              <div class="col-md-4"><label>Sub Total</label><input type="text" id="cp_sub_total" class="form-control" readonly></div>
              <div class="col-md-4"><label>PPN</label><input type="text" id="cp_ppn" class="form-control"></div>
              <div class="col-md-4">
                <label>Total</label>
                <input type="text" id="cp_total" class="form-control" readonly>
              </div>
              <!-- Hidden raw value inputs for decimal submission -->
              <input type="hidden" id="cp_transport_raw" name="portal">
              <input type="hidden" id="cp_harga_raw" name="harga">
              <input type="hidden" id="cp_sub_total_raw" name="sub_total">
              <input type="hidden" id="cp_ppn_raw" name="ppn">
              <input type="hidden" id="cp_total_raw" name="total">
              <div class="col-md-12"><label>Terbilang</label><input type="text" name="terbilang" id="cp_terbilang" class="form-control" readonly></div>
              <div class="col-md-12">
                <label>Description</label>
                <textarea name="description" id="cp_description" class="form-control" required>Transport</textarea>
                <div class="invalid-feedback">Field Description wajib diisi.</div>
              </div>
              <div class="col-md-12"><label>Special Instruction</label><textarea name="special_notes" id="cp_special_notes" class="form-control"></textarea></div>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                <button type="submit" id="btn-save-transportir" class="btn btn-primary rounded-square" style="border-radius:8px;">
                  <span class="txt">Simpan</span>
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                <a href="{{ route('purchase_order.index') }}" class="btn btn-secondary rounded-square" style="border-radius:8px;">Kembali</a>
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
// --- Helper: Terbilang (ID) ---
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

// --- Helper: Parse Currency Value ---
function parseCurrencyValue(value) {
    if (!value) return 0;
    // Remove "Rp. ", spaces, and dots (thousand separators)
    var numeric = value.toString().replace(/Rp\.?\s*/g, '').replace(/\./g, '').replace(/\s/g, '');
    return parseFloat(numeric) || 0;
}

// --- Hitung & Update Otomatis Semua Kolom Transportir (tanpa PBBKB, BPH, dan PPH) ---
function calcTransportirFields() {
    var qtyEl = $('#cp_qty');
    var qty = qtyEl.is('select') ? (parseFloat(qtyEl.find('option:selected').data('oat')) || parseFloat($('#cp_qty_submit').val()) || 0) : (parseFloat(qtyEl.val().replace(/\D/g,'')) || 0);
    var harga = parseFloat($('#cp_harga_raw').val()) || 0;
    var transport = parseFloat($('#cp_transport_raw').val()) || 0;

    var subtotal = (qty * harga)
    
    // Calculate default PPN value
    var valPPNCalculated = subtotal * 0.11;
    
    // Get actual PPN value (manual edit or calculated)
    var valPPN = 0;
    
    // Check if PPN field is manually edited, if not use calculated value
    if (!$('#cp_ppn').data('manually-edited')) {
        valPPN = valPPNCalculated;
        $('#cp_ppn').val('Rp. ' + Math.round(valPPN).toLocaleString('id-ID'));
        $('#cp_ppn_raw').val(Math.round(valPPN));
    } else {
        valPPN = parseCurrencyValue($('#cp_ppn').val());
        $('#cp_ppn_raw').val(Math.round(valPPN));
    }
    
    // Calculate total using actual PPN value
    var Pajak = valPPN;
    var total = subtotal + Pajak + transport;

    var subTotalText = 'Rp. ' + subtotal.toLocaleString('id-ID');
    var totalText = 'Rp. ' + Math.round(total).toLocaleString('id-ID');

    $('#cp_sub_total').val(subTotalText);
    $('#cp_sub_total_raw').val(subtotal);
    $('#cp_total').val(totalText);
    $('#cp_total_raw').val(Math.round(total));

    var terbilangText = total ? terbilang(Math.round(total)) + ' rupiah' : 'nol rupiah';
    $('#cp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
}

$(document).ready(function(){
    // Load payment methods
    $.get('/api/master-lov/children', { parent_code: 'PAYMENT_METHOD' })
        .done(function(res) {
            var paymentMethods = res.data || res;
            var options = '<option value=""></option>' + paymentMethods.map(function(item){
                return '<option value="'+item.value+'">'+item.value+'</option>';
            }).join('');
            $('#cp_term').html(options).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih Metode Pembayaran'
            });
        });

    // Vendor dropdown: load after Customer PO selected (using wilayah from PO response)
    function loadVendorByWilayah(wilayah) {
        var $select = $('#cp_vendor_name');
        $select.html('<option value="">Loading...</option>').prop('disabled', true);
        if (!wilayah) {
            $select.html('<option value="">Pilih Customer PO terlebih dahulu</option>').prop('disabled', false);
            if ($select.hasClass('select2-hidden-accessible')) $select.trigger('change.select2');
            return;
        }
        $.get('/api/transporter', { category: 2, wilayah: wilayah })
            .done(function(res){
                var list = res.data || res || [];
                $select.empty().append('<option value="">Pilih Vendor</option>');
                list.forEach(function(item){
                    var vid = item.id != null ? item.id : '';
                    $select.append($('<option>')
                        .val(item.nama||item.name)
                        .text(item.nama||item.name)
                        .attr('data-vendor-id', vid)
                        .attr('data-format', item.format||'')
                        .attr('data-nama', item.nama||item.name||'')
                        .attr('data-pic', item.pic||'')
                        .attr('data-contact', item.contact_no||'')
                        .attr('data-alamat', item.address||'')
                    );
                });
                $select.prop('disabled', false);
                if ($select.hasClass('select2-hidden-accessible')) $select.trigger('change.select2');
            })
            .fail(function(){
                $select.html('<option value="">Gagal memuat vendor</option>').prop('disabled', false);
                if ($select.hasClass('select2-hidden-accessible')) $select.trigger('change.select2');
            });
    }
    $('#cp_vendor_name').html('<option value="">Pilih Customer PO terlebih dahulu</option>').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih Vendor'
    });

    // Delivery To (OAT lokasi) and Qty (OAT) dropdowns - init select2
    $('#cp_delivery_to').select2({ theme: 'bootstrap-5', width: '100%', placeholder: 'Pilih Delivery To' });
    $('#cp_qty').select2({ theme: 'bootstrap-5', width: '100%', placeholder: 'Pilih Qty' });

    // Step 1: Load Delivery To (lokasi) by vendor_id + wilayah_id (dari Customer PO)
    function loadOatLokasi(vendorId) {
        var $el = $('#cp_delivery_to');
        if (!vendorId) {
            $el.empty().append('<option value="">Pilih Vendor terlebih dahulu</option>');
            if ($el.hasClass('select2-hidden-accessible')) $el.trigger('change.select2');
            $('#cp_qty').empty().append('<option value="">Pilih Delivery To terlebih dahulu</option>').trigger('change.select2');
            $('#cp_qty_submit').val('');
            $('#cp_harga').val(''); $('#cp_harga_raw').val('');
            return;
        }
        var wilayahId = $('#form-create-po-transportir').data('wilayah-id');
        var params = { vendor_id: vendorId };
        if (wilayahId != null && wilayahId !== '') params.wilayah_id = wilayahId;
        $el.empty().append('<option value="">Pilih Lokasi</option>');
        $.get('/api/oat-transportir/lokasi', params)
            .done(function(res) {
                var list = (res.data || res) || [];
                $el.empty().append('<option value="">Pilih Lokasi</option>');
                list.forEach(function(l) {
                    var label = (l.name || '') + (l.wilayah ? ' - ' + l.wilayah : '');
                    $el.append($('<option>').val(l.name || '').text(label).attr('data-id', l.id));
                });
                if ($el.hasClass('select2-hidden-accessible')) $el.trigger('change.select2');
                $('#cp_qty').empty().append('<option value="">Pilih Delivery To terlebih dahulu</option>').trigger('change.select2');
                $('#cp_qty_submit').val('');
                $('#cp_harga').val(''); $('#cp_harga_raw').val('');
            })
            .fail(function() {
                $el.empty().append('<option value="">Gagal memuat lokasi</option>');
                if ($el.hasClass('select2-hidden-accessible')) $el.trigger('change.select2');
            });
    }

    // Step 2: Load Qty (oat) by vendor_id + lokasi name
    function loadOatQty(vendorId, lokasiName) {
        var $el = $('#cp_qty');
        if (!vendorId || !lokasiName) {
            $el.empty().append('<option value="">Pilih Delivery To terlebih dahulu</option>');
            if ($el.hasClass('select2-hidden-accessible')) $el.trigger('change.select2');
            $('#cp_qty_submit').val('');
            $('#cp_harga').val(''); $('#cp_harga_raw').val('');
            return;
        }
        $el.empty().append('<option value="">Pilih OAT (Qty)</option>');
        $.get('/api/oat-transportir/oat-qty', { vendor_id: vendorId, name: lokasiName })
            .done(function(res) {
                var list = (res.data || res) || [];
                $el.empty().append('<option value="">Pilih OAT (Qty)</option>');
                list.forEach(function(o) {
                    var oat = (o.oat != null && o.oat !== '') ? String(o.oat) : '';
                    $el.append($('<option>').val(o.id).text(oat).attr('data-oat', oat));
                });
                if ($el.hasClass('select2-hidden-accessible')) $el.trigger('change.select2');
                $('#cp_qty_submit').val('');
                $('#cp_harga').val(''); $('#cp_harga_raw').val('');
            })
            .fail(function() {
                $el.empty().append('<option value="">Gagal memuat OAT</option>');
                if ($el.hasClass('select2-hidden-accessible')) $el.trigger('change.select2');
            });
    }

    // Step 3: Load Unit Price (value) by oat id and populate field (editable)
    function loadOatValue(oatId) {
        if (!oatId) {
            $('#cp_harga').val(''); $('#cp_harga_raw').val('');
            calcTransportirFields();
            return;
        }
        $.get('/api/oat-transportir/value/' + oatId)
            .done(function(res) {
                var val = (res.data && res.data.value != null) ? String(res.data.value) : '';
                var num = parseFloat(val.replace(/[^\d.-]/g, '')) || 0;
                $('#cp_harga_raw').val(num);
                $('#cp_harga').val(num ? 'Rp. ' + parseInt(num, 10).toLocaleString('id-ID') : '');
                calcTransportirFields();
            })
            .fail(function() {
                $('#cp_harga').val(''); $('#cp_harga_raw').val('');
                calcTransportirFields();
            });
    }

    // Load Customer PO list (tetap seperti sekarang)
    $.get('/api/list/purchase-order/supplier/approve')
        .done(function(res) {
            $('#select-po').html('<option value=""></option>');
            var poList = res.data || res || [];
            poList.forEach(function(po) {
                var poId = po.id || po.po_id || po.purchase_order_id;
                var customerPo = po.customer_po || po.po_no || '';
                if (poId && customerPo) {
                    $('#select-po').append(`<option value="${poId}" data-customer-po="${customerPo}" data-vendor-po="${po.vendor_po || ''}">${customerPo}</option>`);
                }
            });
            $('#select-po').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih Customer PO'
            });
        })
        .fail(function(xhr) {
            console.error('Error loading PO list:', xhr);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal memuat daftar PO. Silakan refresh halaman.'
            });
        });

    // Initialize datepicker
    $('#cp_tgl_po').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        autoClose: true
    });

    // Vendor name change
    $('#cp_vendor_name').on('change', function() {
        var $sel = $(this).find('option:selected');
        var vendorId = $sel.data('vendor-id');
        var format = $sel.data('format') || '';
        // Load Delivery To (OAT lokasi) by vendor_id
        loadOatLokasi(vendorId);
        // Ambil Dn No dari field (bukan no_seq)
        var dnNo = $('#cp_dn_no').val() || '';
        var now = new Date();
        var romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now.getMonth()];
        var tahun = now.getFullYear();
        var vendorPO = format.replace(/{nomor}|{NOMOR}/g, dnNo)
                             .replace(/{bulan}|{BULAN}/g, romawi)
                             .replace(/{tahun}|{TAHUN}/g, tahun);
        vendorPO = vendorPO.replace(/\)$/, '');
        if (!$('#cp_vendor_po').data('user-edited')) {
            $('#cp_vendor_po').val(vendorPO);
        }
        $('#cp_nama').val($sel.data('pic') || '');
        $('#cp_contact').val($sel.data('contact') || '');
        $('#cp_alamat').val($sel.data('alamat') || '');
    });

    // Delivery To change → load Qty (oat-qty)
    $('#cp_delivery_to').on('change', function() {
        var lokasiName = $(this).val();
        var vendorId = $('#cp_vendor_name option:selected').data('vendor-id');
        loadOatQty(vendorId, lokasiName);
    });

    // Qty (oat) change → set hidden qty for submit, load Unit Price (value)
    $('#cp_qty').on('change', function() {
        var $opt = $(this).find('option:selected');
        var oatId = $opt.val();
        var oatVal = $opt.data('oat');
        $('#cp_qty_submit').val(oatVal || '');
        loadOatValue(oatId);
    });

    // Track manual edit on vendor PO
    $('#cp_vendor_po').on('input', function() {
        $(this).data('user-edited', true);
    });

    // On Dn No change, regenerate Nomer PO jika Vendor Name sudah dipilih
    $('#cp_dn_no').on('change', function() {
        if ($('#cp_vendor_name').val()) {
            $('#cp_vendor_name').trigger('change');
        }
    });

    // Customer PO change
    $('#select-po').on('change', function(){
        var poId = $(this).val();
        var selectedOption = $('#select-po option:selected');
        var customerPo = selectedOption.text().trim();
        
        $('#po_number').val(customerPo); // Store customer_po
        
        if (!poId) {
            $('#cp_dn_no').val('');
            $('#cp_nama_customer').val('');
            $('#select-po').removeData('no-seq');
            $('#cp_vendor_po').data('user-edited', false);
            $('#cp_ppn').removeData('manually-edited');
            $('#form-create-po-transportir').removeData('wilayah-id');
            loadVendorByWilayah(null);
            loadOatLokasi(null);
            $('#cp_qty_submit').val('');
            $('#cp_harga').val(''); $('#cp_harga_raw').val('');
            return;
        }
        
        // Validasi: Check apakah PO Supplier sudah approved
        $.ajax({
            url: `/api/list/purchase-order/supplier/approve/${encodeURIComponent(customerPo)}`,
            method: 'GET',
            success: function(res) {
                // HTTP 200: Data ditemukan
                console.log('Validation Response:', res); // Debug log
                
                // Ambil no_seq dan nama_customer dari response validasi Customer PO (bukan dari endpoint details)
                // DN No dan Nama Customer hanya berelasi dengan Customer PO dropdown
                if (res.success && res.data) {
                    // Set DN No dari no_seq
                    if (res.data.no_seq) {
                        var noSeq = res.data.no_seq;
                        $('#cp_dn_no').val(noSeq);
                        console.log('DN No set from Customer PO validation response:', noSeq); // Debug log
                        // Simpan no_seq di data attribute untuk digunakan saat vendor name change
                        $('#select-po').data('no-seq', noSeq);
                        
                        // Trigger vendor name change untuk regenerate PO number setelah Dn No terisi
                        if ($('#cp_vendor_name').val()) {
                            $('#cp_vendor_name').trigger('change');
                        }
                    } else {
                        console.log('No no_seq found in Customer PO validation response'); // Debug log
                        $('#cp_dn_no').val('');
                        $('#select-po').removeData('no-seq');
                    }
                    
                    // Set Nama Customer dari nama_customer
                    if (res.data.nama_customer) {
                        $('#cp_nama_customer').val(res.data.nama_customer);
                        console.log('Nama Customer set from Customer PO validation response:', res.data.nama_customer); // Debug log
                    } else {
                        $('#cp_nama_customer').val('');
                        console.log('No nama_customer found in Customer PO validation response'); // Debug log
                    }
                    // Load Vendor Name dropdown by wilayah from response
                    var wilayah = res.data.wilayah != null ? res.data.wilayah : (res.data.wilayah_id != null ? res.data.wilayah_id : null);
                    loadVendorByWilayah(wilayah);
                    // Simpan wilayah_id dari Customer PO untuk API lokasi (Delivery To)
                    var wilayahId = res.data.wilayah_id != null ? res.data.wilayah_id : (res.data.wilayah != null ? res.data.wilayah : null);
                    $('#form-create-po-transportir').data('wilayah-id', wilayahId);
                    // Reset manually-edited flag untuk PPN (karena PO berubah, reset ke auto-calc)
                    $('#cp_ppn').removeData('manually-edited');
                } else {
                    // Jika response tidak valid, reset semua field
                    $('#cp_dn_no').val('');
                    $('#cp_nama_customer').val('');
                    $('#select-po').removeData('no-seq');
                    $('#cp_ppn').removeData('manually-edited');
                    $('#form-create-po-transportir').removeData('wilayah-id');
                    loadVendorByWilayah(null);
                }
            },
            error: function(xhr) {
                // HTTP 400 atau error lainnya: Tampilkan modal dengan pesan error
                if (xhr.status === 400) {
                    var errorMessage = xhr.responseJSON?.message || 'PO Supplier belum di-approve. Hubungi Finance untuk membuat PO Supplier terlebih dahulu.';
                    Swal.fire({
                        icon: 'error',
                        title: 'PO Supplier Belum Di-approve',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    }).then(function() {
                        // Reset dropdown Customer PO
                        $('#select-po').val('').trigger('change');
                        $('#po_number').val('');
                        // Reset manually-edited flag untuk PPN
                        $('#cp_ppn').removeData('manually-edited');
                    });
                } else {
                    // Error lainnya
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memvalidasi PO Supplier',
                        confirmButtonText: 'OK'
                    });
                    // Reset manually-edited flag untuk PPN
                    $('#cp_ppn').removeData('manually-edited');
                }
            }
        });
    });

    // Transport and Harga input
    $('#cp_transport, #cp_harga').on('input', function(){
        var numeric = $(this).val().replace(/[^\d]/g,'');
        $('#' + $(this).attr('id') + '_raw').val(numeric || 0);
        $(this).val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');
        calcTransportirFields();
    });
    $('#cp_qty').on('change', calcTransportirFields);

    // Event handler untuk PPN (editable)
    $('#cp_ppn').on('input', function(){
        // Allow free typing, only update raw value
        var numeric = $(this).val().replace(/[^\d]/g,'');
        var value = numeric ? parseInt(numeric, 10) : 0;
        $('#' + $(this).attr('id') + '_raw').val(value);
        $(this).data('manually-edited', true);
        calcTransportirFields();
    });
    
    // Format on blur
    $('#cp_ppn').on('blur', function(){
        var numeric = $(this).val().replace(/[^\d]/g,'');
        var numValue = numeric ? parseInt(numeric, 10) : 0;
        $(this).val('Rp. ' + numValue.toLocaleString('id-ID'));
        $('#' + $(this).attr('id') + '_raw').val(numValue);
        calcTransportirFields();
    });

    // Form submit
    $('#form-create-po-transportir').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        if (!form.checkValidity()) {
            e.stopPropagation();
            $(form).addClass('was-validated');
            return;
        }
        var $btn = $('#btn-save-transportir');
        if ($btn.prop('disabled')) return;

        $btn.prop('disabled', true);
        $btn.find('.txt').addClass('d-none');
        $btn.find('.spinner-border').removeClass('d-none');

        // Serialize form dan mapping field sesuai kebutuhan backend
        var formData = $(form).serializeArray();
        var payload = {};
        formData.forEach(function(item) {
            // Mapping field sesuai kebutuhan backend
            if (item.name === 'vendor_name') {
                payload['vendor_name'] = item.value;
            } else if (item.name === 'po_number') {
                payload['customer_po'] = item.value;
            } else if (item.name === 'qty') {
                payload['qty'] = item.value;
            } else if (item.name === 'tgl_po') {
                payload['po_date'] = item.value;
            } else if (item.name === 'nama') {
                payload['pic_site'] = item.value;
            } else if (item.name === 'contact') {
                payload['pic_site_telp'] = item.value;
            } else if (item.name === 'alamat') {
                payload['site_location'] = item.value;
            } else if (item.name === 'term') {
                payload['term'] = item.value;
            } else if (item.name === 'dn_no') {
                payload['dn_no'] = item.value;
            } else {
                // Field lainnya tetap sama, termasuk drs_unique
                payload[item.name] = item.value;
            }
        });
        
        // Pastikan dn_no dikirim (jika belum ada di payload)
        if (!payload.dn_no && $('#cp_dn_no').val()) {
            payload.dn_no = $('#cp_dn_no').val();
        }

        $.ajax({
            url: '/api/purchase-order/po-transporter',
            method: 'POST',
            data: payload,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(res) {
                Swal.fire('Berhasil', res.message || 'Operasi berhasil', 'success')
                    .then(function() {
                        window.location.href = '{{ route("purchase_order.index") }}';
                    });
            },
            error: function(xhr) {
                Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.find('.spinner-border').addClass('d-none');
                $btn.find('.txt').removeClass('d-none');
            }
        });
    });
});
</script>
@endsection
