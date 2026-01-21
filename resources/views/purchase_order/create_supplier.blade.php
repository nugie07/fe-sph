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
        <h3>Form Pembuatan PO Supplier</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item"><a href="{{ route('purchase_order.index') }}">Purchase Order</a></li>
          <li class="breadcrumb-item active">Create PO Supplier</li>
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
          <form id="form-create-po-supplier" class="needs-validation" novalidate>
            <div class="row g-4">
              <input type="hidden" name="drs_unique" id="sp_drs_unique">
              <input type="hidden" name="category" id="po_category" value="1">
              <div class="col-md-4">
                <label>Customer PO No</label>
                <select id="sp_po_no" name="po_no" class="form-control select2" required>
                </select>
                <div class="invalid-feedback">Field Customer PO No wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Vendor Name</label>
                <select id="sp_vendor_name" name="vendor_name" class="form-control select2" required>
                </select>
                <div class="invalid-feedback">Field Vendor Name wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Nomer PO</label>
                <input type="text" name="vendor_po" id="sp_vendor_po" class="form-control" required>
                <div class="invalid-feedback">Field Nomer PO wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Tanggal PO</label>
                <input type="text" name="tgl_po" id="sp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required>
                <div class="invalid-feedback">Field Tanggal PO wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Nama PIC</label>
                <input type="text" name="nama" id="sp_nama" class="form-control" required>
                <div class="invalid-feedback">Field Nama PIC wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Contact</label>
                <input type="text" name="contact" id="sp_contact" class="form-control" required>
                <div class="invalid-feedback">Field Contact wajib diisi.</div>
              </div>
              <div class="col-md-12">
                <label>Alamat</label>
                <input type="text" name="alamat" id="sp_alamat" class="form-control" required>
                <div class="invalid-feedback">Field Alamat wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Metode Pembayaran</label>
                <select id="sp_term" name="term" class="form-control select2" required></select>
                <div class="invalid-feedback">Field Metode Pembayaran wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>FOB</label>
                <input type="text" name="fob" id="sp_fob" class="form-control" required>
                <div class="invalid-feedback">Field FOB wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Shipped Via</label>
                <input type="text" name="shipped_via" id="sp_shipped_via" class="form-control" required>
                <div class="invalid-feedback">Field Shipped Via wajib diisi.</div>
              </div>
              <div class="col-md-6">
                <label>Loading Point</label>
                <input type="text" name="loading_point" id="sp_loading_point" class="form-control" required>
                <div class="invalid-feedback">Field Loading Point wajib diisi.</div>
              </div>
              <div class="col-md-6">
                <label>Delivery To</label>
                <input type="text" name="delivery_to" id="sp_delivery_to" class="form-control" required>
                <div class="invalid-feedback">Field Delivery To wajib diisi.</div>
              </div>
              <!-- Baris 1: Harga, Qty, Sub Total -->
              <div class="col-md-4">
                <label>Harga</label>
                <input type="text" id="sp_harga" class="form-control" required>
                <div class="invalid-feedback">Field Harga wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Qty</label>
                <input type="number" name="qty" id="sp_qty" class="form-control" required>
                <div class="invalid-feedback">Field Qty wajib diisi.</div>
              </div>
              <div class="col-md-4">
                <label>Sub Total</label>
                <input type="text" id="sp_sub_total" class="form-control" readonly>
              </div>
              <!-- Baris 2: PPN, PPH, PBBKB -->
              <div class="col-md-4">
                <label>PPN</label>
                <input type="text" id="sp_ppn" class="form-control">
              </div>
              <div class="col-md-4">
                <label>PPH</label>
                <input type="text" id="sp_pph" class="form-control">
              </div>
              <div class="col-md-4">
                <label>PBBKB</label>
                <input type="text" id="sp_pbbkb" class="form-control">
              </div>
              <!-- Baris 3: BPH, Total, Terbilang -->
              <div class="col-md-4">
                <label>BPH</label>
                <input type="text" id="sp_bph" class="form-control">
              </div>
              <div class="col-md-4">
                <label>Total</label>
                <input type="text" id="sp_total" class="form-control" readonly>
              </div>
              <div class="col-md-4">
                <label>Terbilang</label>
                <input type="text" name="terbilang" id="sp_terbilang" class="form-control" readonly>
              </div>
              <!-- Hidden raw value inputs for decimal submission -->
              <input type="hidden" id="sp_nilai_po_raw" name="nilai_po">
              <input type="hidden" id="sp_harga_raw" name="harga">
              <input type="hidden" id="sp_tipe_sph" name="tipe_sph">
              <input type="hidden" id="sp_sub_total_raw" name="sub_total">
              <input type="hidden" id="sp_ppn_raw" name="ppn">
              <input type="hidden" id="sp_pbbkb_raw" name="pbbkb">
              <input type="hidden" id="sp_pph_raw" name="pph">
              <input type="hidden" id="sp_bph_raw" name="bph">
              <input type="hidden" id="sp_total_raw" name="total">
              <div class="col-md-12"><label>Keterangan</label><textarea name="description" id="sp_description" class="form-control"></textarea></div>
              <div class="col-md-12"><label>Additional Notes</label><textarea name="additional_notes" id="sp_additional_notes" class="form-control"></textarea></div>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                <button type="submit" id="btn-save-supplier" class="btn btn-primary rounded-square" style="border-radius:8px;">
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

// --- Hitung & Update Otomatis Semua Kolom Supplier ---
function calcSupplierFields() {
    var qty = parseFloat($('#sp_qty').val().replace(/\D/g,'')) || 0;
    var harga = parseFloat($('#sp_harga_raw').val()) || 0;
    var tipeSph = $('#sp_tipe_sph').val() || '';

    var subtotal = (qty * harga)
    
    // Calculate default values
    var valPPNCalculated = subtotal * 0.11;
    
    // Logic untuk PPH dan PBBKB berdasarkan tipe_sph
    var valPBBKBCalculated = 0;
    var valPPhCalculated = 0;
    if (tipeSph === 'MMTEI') {
        // Auto calculate untuk MMTEI
        valPBBKBCalculated = (qty * harga) * 0.075;
        valPPhCalculated = (qty * harga) * 0.03;
    } else if (tipeSph === 'IASE') {
        // Set ke 0 untuk IASE
        valPBBKBCalculated = 0;
        valPPhCalculated = 0;
    } else {
        // Default: hitung seperti biasa jika tipe_sph belum di-set
        valPBBKBCalculated = (qty * harga) * 0.075;
        valPPhCalculated = (qty * harga) * 0.03;
    }
    
    var valBPHCalculated = (qty * harga) * 0.025;
    
    // Get actual values (manual edit or calculated)
    var valPPN = 0;
    var valPBBKB = 0;
    var valPPh = 0;
    var valBPH = 0;
    
    // Check if fields are manually edited, if not use calculated values
    if (!$('#sp_ppn').data('manually-edited')) {
        valPPN = valPPNCalculated;
        $('#sp_ppn').val('Rp. ' + Math.round(valPPN).toLocaleString('id-ID'));
        $('#sp_ppn_raw').val(Math.round(valPPN));
    } else {
        valPPN = parseCurrencyValue($('#sp_ppn').val());
        $('#sp_ppn_raw').val(Math.round(valPPN));
    }
    
    if (!$('#sp_pbbkb').data('manually-edited')) {
        valPBBKB = valPBBKBCalculated;
        $('#sp_pbbkb').val('Rp. ' + Math.round(valPBBKB).toLocaleString('id-ID'));
        $('#sp_pbbkb_raw').val(Math.round(valPBBKB));
    } else {
        valPBBKB = parseCurrencyValue($('#sp_pbbkb').val());
        $('#sp_pbbkb_raw').val(Math.round(valPBBKB));
    }
    
    if (!$('#sp_pph').data('manually-edited')) {
        valPPh = valPPhCalculated;
        $('#sp_pph').val('Rp. ' + Math.round(valPPh).toLocaleString('id-ID'));
        $('#sp_pph_raw').val(Math.round(valPPh));
    } else {
        valPPh = parseCurrencyValue($('#sp_pph').val());
        $('#sp_pph_raw').val(Math.round(valPPh));
    }
    
    if (!$('#sp_bph').data('manually-edited')) {
        valBPH = valBPHCalculated;
        $('#sp_bph').val('Rp. ' + Math.round(valBPH).toLocaleString('id-ID'));
        $('#sp_bph_raw').val(Math.round(valBPH));
    } else {
        valBPH = parseCurrencyValue($('#sp_bph').val());
        $('#sp_bph_raw').val(Math.round(valBPH));
    }
    
    // Calculate total using actual values
    var Pajak = valPPN + valPBBKB + valPPh + valBPH;
    var total = subtotal + Pajak;

    var subTotalText = 'Rp. ' + subtotal.toLocaleString('id-ID');
    var totalText = 'Rp. ' + Math.round(total).toLocaleString('id-ID');

    $('#sp_sub_total').val(subTotalText);
    $('#sp_sub_total_raw').val(subtotal);
    $('#sp_total').val(totalText);
    $('#sp_total_raw').val(Math.round(total));

    var terbilangText = total ? terbilang(Math.round(total)) + ' rupiah' : 'nol rupiah';
    $('#sp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
}

$(document).ready(function(){
    // Load payment methods
    $.get('/api/master-lov/children', { parent_code: 'PAYMENT_METHOD' })
        .done(function(res) {
            var paymentMethods = res.data || res;
            var options = '<option value=""></option>' + paymentMethods.map(function(item){
                return '<option value="'+item.value+'">'+item.value+'</option>';
            }).join('');
            $('#sp_term').html(options).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih Metode Pembayaran'
            });
        });

    // Initialize vendor dropdown (kosong dulu, akan diisi saat dropdown dibuka)
    $('#sp_vendor_name').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih Vendor',
        allowClear: true
    });

    // Load vendors saat dropdown dibuka (diklik)
    $('#sp_vendor_name').on('select2:open', function() {
        var tipeSph = $('#sp_tipe_sph').val();
        
        // Validasi: pastikan Customer PO sudah dipilih dulu
        if (!$('#sp_po_no').val() || !tipeSph) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan pilih Customer PO terlebih dahulu',
                confirmButtonText: 'OK'
            });
            $(this).select2('close');
            return;
        }

        // Jika dropdown sudah pernah di-load, skip
        if ($(this).data('loaded')) {
            return;
        }

        // Show loading state
        $(this).prop('disabled', true);
        
        // Hit API dengan parameter tipe
        var tipeLower = tipeSph.toLowerCase();
        $.get('/api/transporter?category=1&tipe=' + encodeURIComponent(tipeLower))
            .done(function(res){
                var list = res.data || res;
                var $select = $('#sp_vendor_name');
                $select.html('<option></option>');
                
                list.forEach(function(item){
                    $select.append($('<option>')
                        .val(item.nama||item.name)
                        .text(item.nama||item.name)
                        .attr('data-format', item.format||'')
                        .attr('data-nama', item.nama||item.name||'')
                        .attr('data-contact', item.contact_no||'')
                        .attr('data-alamat', item.address||'')
                    );
                });
                
                // Mark as loaded
                $select.data('loaded', true);
                $select.prop('disabled', false);
            })
            .fail(function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data vendor: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'),
                    confirmButtonText: 'OK'
                });
                $('#sp_vendor_name').prop('disabled', false);
            });
    });

    // Load PO No list
    $.get('/api/good_receipt/gr_list_no')
        .done(function(res){
            var poList = res.data || [];
            var opts = poList.map(function(po){
                return `<option value="${po}">${po}</option>`;
            });
            $('#sp_po_no').html('<option value="">Pilih Customer PO NO</option>' + opts.join('')).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih Customer PO NO'
            });
        });

    // Initialize datepicker
    $('#sp_tgl_po').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        autoClose: true
    });

    // Vendor name change
    $('#sp_vendor_name').on('change', function() {
        var $sel = $(this).find('option:selected');
        var format = $sel.data('format') || '';
        // Ambil no_seq dari response API saat PO No dipilih (disimpan di data attribute)
        var noSeq = $('#sp_po_no').data('no-seq') || '';
        var now = new Date();
        var romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now.getMonth()];
        var tahun = now.getFullYear();
        var vendorPO = format.replace(/{nomor}|{NOMOR}/g, noSeq)
                             .replace(/{bulan}|{BULAN}/g, romawi)
                             .replace(/{tahun}|{TAHUN}/g, tahun);
        // Hapus tanda kurung tutup di akhir jika ada
        vendorPO = vendorPO.replace(/\)$/, '');
        // Hanya set jika field kosong atau user belum edit manual
        if (!$('#sp_vendor_po').data('user-edited')) {
            $('#sp_vendor_po').val(vendorPO);
        }
        $('#sp_nama').val($sel.data('nama') || '');
        $('#sp_contact').val($sel.data('contact') || '');
        $('#sp_alamat').val($sel.data('alamat') || '');
    });

    // Track manual edit on vendor PO
    $('#sp_vendor_po').on('input', function() {
        $(this).data('user-edited', true);
    });

    // PO No change
    $('#sp_po_no').on('change', function(){
        var poNo = $(this).val();
        if (!poNo) {
            $('#sp_qty').val('');
            $('#sp_nilai_po_raw').val('');
            $('#sp_tipe_sph').val('');
            $('#sp_po_no').removeData('no-seq');
            $('#sp_vendor_po').data('user-edited', false);
            // Reset manually-edited flags untuk tax fields
            $('#sp_ppn, #sp_pph, #sp_pbbkb, #sp_bph').removeData('manually-edited');
            // Reset vendor dropdown
            $('#sp_vendor_name').val('').trigger('change');
            $('#sp_vendor_name').data('loaded', false);
            return;
        }
        $.get('/api/good_receipt/gr_detail/' + encodeURIComponent(poNo), function(res){
            if (res.success && res.data) {
                var d = res.data;
                // Set Nilai PO (hidden field untuk backend)
                var nilaiPO = parseFloat(d.total) || 0;
                $('#sp_nilai_po_raw').val(nilaiPO);
                
                // Set tipe_sph dari response
                if (d.tipe_sph) {
                    $('#sp_tipe_sph').val(d.tipe_sph);
                } else {
                    $('#sp_tipe_sph').val('');
                }
                
                // Reset vendor dropdown karena tipe_sph berubah
                $('#sp_vendor_name').val('').trigger('change');
                $('#sp_vendor_name').data('loaded', false);
                
                // Reset manually-edited flags untuk tax fields (karena PO berubah, reset ke auto-calc)
                $('#sp_ppn, #sp_pph, #sp_pbbkb, #sp_bph').removeData('manually-edited');
                
                // Simpan no_seq di data attribute untuk digunakan saat vendor name change
                if (d.no_seq) {
                    $('#sp_po_no').data('no-seq', d.no_seq);
                } else {
                    $('#sp_po_no').removeData('no-seq');
                }
                
                // Set qty jika ada
                if (d.qty) {
                    $('#sp_qty').val(d.qty);
                }
                
                calcSupplierFields();
                // Trigger vendor name change untuk regenerate PO number
                if ($('#sp_vendor_name').val()) {
                    $('#sp_vendor_name').trigger('change');
                }
            }
        }).fail(function() {
            $('#sp_qty').val('');
            $('#sp_nilai_po_raw').val('');
            $('#sp_tipe_sph').val('');
            $('#sp_po_no').removeData('no-seq');
            // Reset manually-edited flags untuk tax fields
            $('#sp_ppn, #sp_pph, #sp_pbbkb, #sp_bph').removeData('manually-edited');
            // Reset vendor dropdown
            $('#sp_vendor_name').val('').trigger('change');
            $('#sp_vendor_name').data('loaded', false);
        });
    });

    // Harga input
    $('#sp_harga').on('input', function(){
        var numeric = $(this).val().replace(/[^\d]/g,'');
        $('#' + $(this).attr('id') + '_raw').val(numeric || 0);
        $(this).val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');
        calcSupplierFields();
    });
    $('#sp_qty').on('change', calcSupplierFields);

    // Event handler untuk PPN, PPH, PBBKB, BPH (editable)
    function setupEditableTaxField(fieldId) {
        $(fieldId).on('input', function(){
            // Allow free typing, only update raw value
            var numeric = $(this).val().replace(/[^\d]/g,'');
            var value = numeric ? parseInt(numeric, 10) : 0;
            $('#' + $(this).attr('id') + '_raw').val(value);
            $(this).data('manually-edited', true);
            calcSupplierFields();
        });
        
        // Format on blur
        $(fieldId).on('blur', function(){
            var numeric = $(this).val().replace(/[^\d]/g,'');
            var numValue = numeric ? parseInt(numeric, 10) : 0;
            $(this).val('Rp. ' + numValue.toLocaleString('id-ID'));
            $('#' + $(this).attr('id') + '_raw').val(numValue);
            calcSupplierFields();
        });
    }
    
    setupEditableTaxField('#sp_ppn');
    setupEditableTaxField('#sp_pph');
    setupEditableTaxField('#sp_pbbkb');
    setupEditableTaxField('#sp_bph');

    // Form submit
    $('#form-create-po-supplier').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        if (!form.checkValidity()) {
            e.stopPropagation();
            $(form).addClass('was-validated');
            return;
        }
        var $btn = $('#btn-save-supplier');
        if ($btn.prop('disabled')) return;

        $btn.prop('disabled', true);
        $btn.find('.txt').addClass('d-none');
        $btn.find('.spinner-border').removeClass('d-none');

        // Serialize form dan hapus nilai_po dari payload
        var formData = $(form).serializeArray();
        var payload = {};
        formData.forEach(function(item) {
            // Skip nilai_po dan transport, tidak dikirim ke backend
            if (item.name !== 'nilai_po' && item.name !== 'transport') {
                payload[item.name] = item.value;
            }
        });

        $.ajax({
            url: '/api/purchase-order/supplier',
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

