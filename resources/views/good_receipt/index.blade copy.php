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
.btn, .btn-sm, .btn-outline-primary, .btn-primary, .btn-danger, .btn-secondary, .btn-warning {
  border-radius: 8px !important;
}
.btn-close {
  border-radius: 8px !important;
  background-color: #e3342f !important;
  opacity: 1;
  padding: 0.5em 0.8em !important;
}
.btn-close:focus {
  box-shadow: none;
}
#modalBulkPO .modal-content {
  border-radius: 20px;
  position: relative;
}
#modalBulkPO.loading .modal-content > .modal-body,
#modalBulkPO.loading .modal-content > .modal-header,
#modalBulkPO.loading .modal-content > .modal-footer {
  filter: blur(3px);
  pointer-events: none;
  user-select: none;
}
.bulk-row-status {
  text-align: center;
  font-size: 12px;
  font-weight: bold;
}
.bulk-row-status.pending { color: #6c757d; }
.bulk-row-status.processing { color: #0d6efd; }
.bulk-row-status.success { color: #198754; }
.bulk-row-status.error { color: #dc3545; }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Good Receipts - Penerimaan PO</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item active">Good Receipt</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Data Penerimaan PO</h4>
          <span>Data penerimaan PO dari SPH yang telah dibuat dan dikirim</span>
        </div>
        <div>
          <button type="button" class="btn btn-primary me-2" id="btnTambahPO">
            <i class="fa fa-plus me-1"></i> Tambah PO
          </button>
          <button type="button" class="btn btn-success" id="btnBulkPO">
            <i class="fa fa-list me-1"></i> Bulk
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive theme-scrollbar">
          <table class="display" id="basic-1">
            <thead>
              <tr>
                <th>Tipe SPH</th>
                <th>No Sph</th>
                <th>Nama Perusahaan</th>
                <th>Produk Dibeli</th>
                <th>Total Harga</th>
                <th>PO No</th>
                <th>Download PO</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

{{-- MODAL TAMBAH PO --}}
<div class="modal fade" id="modalTambahPO" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="formTambahPO" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Tambah PO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Nomer SPH <span class="text-danger">*</span></label>
              <select id="tambah-po-sph" name="sph_id" class="form-control select2" required>
                <option value=""></option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Nama Perusahaan</label>
              <input type="text" id="tambah-po-nama-perusahaan" name="nama_perusahaan" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label class="form-label fw-bold small">Nomer PO Customer <span class="text-danger">*</span></label>
              <input type="text" id="tambah-po-no-customer" name="po_no_customer" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Wilayah <span class="text-danger">*</span></label>
              <select id="tambah-po-wilayah" name="wilayah" class="form-control select2" required>
                <option value=""></option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Seq No</label>
              <input type="text" id="tambah-po-seq" name="no_seq" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
          </div>
          <input type="hidden" id="tambah-po-source" name="source">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Request Date</label>
              <input type="text" id="tambah-po-req-date" name="req_date" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="Request Date">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Qty <span class="text-danger">*</span></label>
              <input type="number" id="tambah-po-qty" name="qty" class="form-control" required min="1">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">HSD Solar <span class="text-danger">*</span></label>
              <input type="text" id="tambah-po-hsd-solar" name="hsd_solar" class="form-control currency-input" required placeholder="Rp 0">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Ongkos Angkut</label>
              <input type="text" id="tambah-po-ongkos-angkut" name="ongkos_angkut" class="form-control currency-input" placeholder="Rp 0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Sub Total</label>
              <input type="text" id="tambah-po-subtotal" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">PPN 11%</label>
              <input type="text" id="tambah-po-ppn" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PBBKB</label>
              <input type="text" id="tambah-po-pbbkb" name="pbbkb" class="form-control currency-input" placeholder="Rp 0" value="Rp 0">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PPH 23</label>
              <input type="text" id="tambah-po-pph" name="pph" class="form-control currency-input" placeholder="Rp 0" value="Rp 0">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Transport</label>
              <input type="text" id="tambah-po-transport" name="transport" class="form-control currency-input" placeholder="Rp 0" value="Rp 0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Total</label>
              <input type="text" id="tambah-po-total" class="form-control fw-bold" readonly style="background-color:#f8f9fa; font-size:16px;">
              <div class="mt-2 small">Terbilang: <span id="tambah-po-terbilang" class="text-primary fw-bold"></span></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Upload File PO <span class="text-danger">*</span></label>
              <input type="file" id="tambah-po-file" name="file_po" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
          </div>
          <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="tambah-po-bypass" name="bypass" value="1">
            <label class="form-check-label fw-bold" for="tambah-po-bypass">Bypass</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btnResetTambahPO">Reset</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btnSimpanTambahPO">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- MODAL BULK PO --}}
<div class="modal fade" id="modalBulkPO" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 98%;">
    <div class="modal-content">
      <form id="formBulkPO">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Bulk Tambah PO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
          <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="btnAddBulkRow">
            <i class="fa fa-plus"></i> Tambah Baris
            </button>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="bg-primary text-white">
                <tr>
                  <th>No</th>
                  <th style="min-width: 200px;">Nomer SPH *</th>
                  <th>Perusahaan</th>
                  <th>PO Customer *</th>
                  <th style="min-width: 150px;">Wilayah *</th>
                  <th>Seq</th>
                  <th>Request Date</th>
                  <th>Qty *</th>
                  <th>HSD *</th>
                  <th>Total</th>
                  <th>File *</th>
                  <th>Status</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody id="bulk-po-tbody"></tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnSimpanBulkPO">Simpan Semua</button>
        </div>
      </form>
      <div id="bulkPOLoading" style="display:none; position:absolute; inset:0; background:rgba(255,255,255,0.8); z-index:10; align-items:center; justify-content:center;">
        <div class="text-center" style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%;">
              <div class="spinner-border text-primary"></div>
              <div class="fw-bold mt-2" id="bulk-loading-text">Memproses...</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- MODAL CANCEL & PDF VIEWER (DIPERSINGKAT UNTUK KODE FULL) --}}
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Preview PO</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body" style="height: 80vh;"><iframe id="pdfViewerFrame" width="100%" height="100%"></iframe></div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>

<script>
$(function(){
    // ==========================================
    // 1. DATA TABLE & LIST
    // ==========================================
    var table = $('#basic-1').DataTable({
        paging: true, searching: true, autoWidth: false,
        columns: [
            { title: 'Tipe SPH' }, { title: 'No Sph' }, { title: 'Nama Perusahaan' },
            { title: 'Produk Dibeli' }, { title: 'Total Harga' }, { title: 'PO No' }, { title: 'Download PO' }
        ]
    });

    // Render functions
function renderSphNo(item) {
    let html = `<div>${item.kode_sph || '-'}</div>`;
    if (item.revisi_count && item.revisi_count > 0) {
        html += `<div class="mt-1">
            <span class="badge bg-warning text-dark" style="font-size:11px; padding:2px 6px; border-radius:4px;">
                Revisi: ${item.revisi_count}
            </span>
        </div>`;
    }
    return html;
}

    function renderPoNo(item) {
        if (item.po_no && item.po_no.trim()) {
            return `<span class="badge bg-secondary px-2 py-1 border border-1 border-dark"
                style="font-size:11px; border-radius:4px; background-color:#f8f9fa; color:#333; display:inline-block; min-width:60px; text-align:center;">
                ${item.po_no}
            </span>`;
        }
        return '-';
    }

function renderFileBtn(item) {
    // Jika status = 9 (canceled), tampilkan badge PO Canceled
    if (item.status === 9) {
        return `<span class="badge bg-danger px-2 py-1 border border-1 border-dark"
            style="font-size:11px; border-radius:4px; background-color:#dc3545; color:#fff; display:inline-block; min-width:60px; text-align:center;">
            PO Canceled
        </span>`;
    }

    if (item.po_file && item.po_file.trim()) {
        const publicUrl = `https://is3.cloudhost.id/bensinkustorage/${item.po_file}`;
        return `
            <span style="display:inline-flex; align-items:center; gap:2px;">
                <a href="#" class="badge bg-info px-2 py-1 border border-1 border-dark btn-view-pdf"
                    data-public-url="${publicUrl}"
                    style="font-size:11px; border-radius:4px; background-color:#e3f2fd; color:#fff; display:inline-block; min-width:60px; text-align:center;">
                    <i class="fa fa-file-pdf-o me-1"></i> Lihat PO
                </a>
            </span>
        `;
    } else {
        if (item.status === 0) {
            return `
                <span style="display:inline-flex; align-items:center; gap:2px;">
                    <span class="badge bg-danger px-2 py-1 border border-1 border-dark"
                        style="font-size:11px; border-radius:4px; background-color:#fdecea; color:#fff; display:inline-block; min-width:60px; text-align:center;">
                        Tidak ada File
                    </span>
                </span>
            `;
        } else {
            return `<span class="badge bg-danger px-2 py-1 border border-1 border-dark"
                        style="font-size:11px; border-radius:4px; background-color:#fdecea; color:#fff; display:inline-block; min-width:60px; text-align:center;">
                        Tidak ada File
                        </span>`;
        }
    }
}

    function fetchList(){
        $('#basic-1 tbody').html(
            '<tr><td colspan="7" class="text-center py-4">'+
                '<div class="spinner-border text-primary" role="status"></div>'+
                ' <span>Loading mohon tunggu ya...</span>'+
            '</td></tr>'
        );
        table.clear();
        $.get('/api/good-receipts/list')
        .done(function(res){
            $('#card-total_sph').text(res.cards?.total_sph || 0);
            $('#card-waiting').text(res.cards?.waiting || 0);
            $('#card-revisi').text(res.cards?.received || 0);
            
            if (res.data && res.data.length > 0) {
                var rows = res.data.map(function(item){
                    return [
                        item.tipe_sph ?? '-', 
                        renderSphNo(item), 
                        item.comp_name ?? '-',
                        item.product ?? '-', 
                        formatRupiah(item.total_price), 
                        renderPoNo(item), 
                        renderFileBtn(item)
                    ];
                });
                table.rows.add(rows).draw();
            } else {
                table.draw();
            }
        })
        .fail(function(){
            table.clear().draw();
            $('#basic-1 tbody').html(
                '<tr><td colspan="7" class="text-center text-danger py-4">'+
                'Gagal memuat data Good Receipt.'+
                '</td></tr>'
            );
        });
    }

    // ==========================================
    // 2. FORM TAMBAH PO (SINGLE)
    // ==========================================
    function initTambahPOWilayahSelect() {
        if ($('#tambah-po-wilayah').hasClass('select2-hidden-accessible')) {
            $('#tambah-po-wilayah').select2('destroy');
        }
        
        $.get('/api/master-wilayah/request', function(res){
            var list = Array.isArray(res) ? res : (res.data || []);
            var $el = $('#tambah-po-wilayah');
            $el.empty().append('<option value=""></option>');
            
            list.forEach(function(w){
                $el.append(new Option(w.code, w.value, false, false));
            });

            $el.select2({
                theme: 'bootstrap-5', width: '100%', placeholder: 'Pilih Wilayah',
                dropdownParent: $('#modalTambahPO'), allowClear: true
            }).on('select2:select', function(e){
                $(this).trigger('change.select2'); // FIX: Agar pilihan muncul di box
                refreshSequenceNoTambahPO();
            });
        });
    }

    function initTambahPOSPHSelect() {
        $('#tambah-po-sph').select2({
            theme: 'bootstrap-5', width: '100%', placeholder: 'Pilih SPH',
            dropdownParent: $('#modalTambahPO'), allowClear: true,
            ajax: {
                url: '/api/good-receipts/sph-approved', dataType: 'json', delay: 250,
                processResults: function (data) {
                    return { results: data.data.map(i => ({ id: i.id, text: i.kode_sph + ' - ' + i.comp_name, comp_name: i.comp_name, tipe_sph: i.tipe_sph })) };
                }
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            $('#tambah-po-nama-perusahaan').val(data.comp_name);
            $('#tambah-po-source').val(data.tipe_sph);
            $(this).trigger('change.select2'); // FIX: Agar pilihan muncul di box
            refreshSequenceNoTambahPO();
        });
    }

    function refreshSequenceNoTambahPO() {
        let w = $('#tambah-po-wilayah').val();
        let s = $('#tambah-po-source').val();
        if(!w || !s) return $('#tambah-po-seq').val('');
        $.getJSON('/api/delivery-note-seq', { wilayah: w, source: s }).done(res => $('#tambah-po-seq').val(res.delivery_note));
    }

    // ==========================================
    // 3. BULK PO
    // ==========================================
    let bulkPORowCounter = 0;
    function addBulkPORow() {
        bulkPORowCounter++;
        const rowId = `bulk-row-${bulkPORowCounter}`;
        const html = `
            <tr id="${rowId}">
                <td>${bulkPORowCounter}</td>
                <td>
                    <select class="form-control bulk-sph select2" required><option value=""></option></select>
                    <input type="hidden" class="bulk-sph-id"><input type="hidden" class="bulk-source">
                </td>
                <td><input type="text" class="form-control bulk-nama-perusahaan" readonly></td>
                <td><input type="text" class="form-control bulk-po-no-customer" required></td>
                <td><select class="form-control bulk-wilayah select2" required><option value=""></option></select></td>
                <td><input type="text" class="form-control bulk-seq" readonly></td>
                <td><input type="text" class="form-control bulk-req-date datepicker-here" name="bulk[${bulkPORowCounter}][req_date]" data-language="en" data-date-format="yyyy-mm-dd" placeholder="Request Date"></td>
                <td><input type="number" class="form-control bulk-qty" required></td>
                <td><input type="text" class="form-control bulk-hsd-solar currency-input" required></td>
                <td><input type="text" class="form-control bulk-total fw-bold" readonly></td>
                <td><input type="file" class="form-control bulk-file" required></td>
                <td class="bulk-row-status pending"><span class="status-text">-</span></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-bulk-row">&times;</button></td>
            </tr>`;
        $('#bulk-po-tbody').append(html);
        initBulkRowSelect2(rowId);
        // Ensure loading is hidden after row is added
        $('#bulkPOLoading').css('display', 'none');
        $('#modalBulkPO').removeClass('loading');
    }

    function initBulkRowSelect2(rowId) {
        const $row = $(`#${rowId}`);
        
        // SPH Bulk
        $row.find('.bulk-sph').select2({
            theme: 'bootstrap-5', width: '100%', placeholder: 'Pilih SPH', dropdownParent: $('#modalBulkPO'),
            ajax: {
                url: '/api/good-receipts/sph-approved', dataType: 'json',
                processResults: data => ({ results: data.data.map(i => ({ id: i.id, text: i.kode_sph, comp_name: i.comp_name, tipe_sph: i.tipe_sph })) })
            }
        }).on('select2:select', function(e){
            const d = e.params.data;
            $row.find('.bulk-sph-id').val(d.id);
            $row.find('.bulk-nama-perusahaan').val(d.comp_name);
            $row.find('.bulk-source').val(d.tipe_sph);
            $(this).trigger('change.select2'); // FIX
            refreshBulkRowSeq(rowId);
        });

        // Wilayah Bulk
        $.get('/api/master-wilayah/request')
        .done(function(res){
            const list = Array.isArray(res) ? res : (res.data || []);
            const $w = $row.find('.bulk-wilayah');
            $w.empty().append('<option value=""></option>');
            list.forEach(i => $w.append(new Option(i.code, i.value)));
            $w.select2({ 
                theme: 'bootstrap-5', 
                width: '100%', 
                placeholder: 'Pilih Wilayah',
                dropdownParent: $('#modalBulkPO'),
                allowClear: true
            })
            .on('select2:select', function(){
                $(this).trigger('change.select2'); // FIX
                refreshBulkRowSeq(rowId);
            });
        })
        .fail(function(){
            console.error('Failed to load wilayah data');
            const $w = $row.find('.bulk-wilayah');
            $w.empty().append('<option value="">Error loading data</option>');
        })
        .always(function(){
            // Ensure loading is hidden after wilayah is loaded
            $('#bulkPOLoading').css('display', 'none');
            $('#modalBulkPO').removeClass('loading');
        });
        
        // Initialize date picker for Request Date
        $row.find('.bulk-req-date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            autoClose: true
        });
    }

    function refreshBulkRowSeq(rowId) {
        const $r = $('#' + rowId);
        const w = $r.find('.bulk-wilayah').val();
        const s = $r.find('.bulk-source').val();
        if(w && s) $.getJSON('/api/delivery-note-seq', { wilayah: w, source: s }).done(res => $r.find('.bulk-seq').val(res.delivery_note));
    }

    // ==========================================
    // 4. UTILITIES & INIT
    // ==========================================
    function formatRupiah(x){ return 'Rp ' + (parseFloat(x)||0).toLocaleString('id-ID',{ minimumFractionDigits:2 }); }
    function parseCurrencyValue(v){ return parseFloat(v.replace(/[^\d]/g, '')) || 0; }
    
    // Function to calculate totals for Tambah PO
    function calculateTambahPOTotal() {
        var qty = parseFloat($('#tambah-po-qty').val()) || 0;
        var hsdSolar = parseCurrencyValue($('#tambah-po-hsd-solar').val());
        var ongkosAngkut = parseCurrencyValue($('#tambah-po-ongkos-angkut').val());
        
        // Sub Total = (Qty × HSD Solar) + (Qty × Ongkos Angkut)
        var subtotal = (qty * hsdSolar) + (qty * ongkosAngkut);
        
        // PPN 11% = Sub Total × 0.11
        var ppn = subtotal * 0.11;
        
        // Get additional costs
        var pbbkb = parseCurrencyValue($('#tambah-po-pbbkb').val()) || 0;
        var pph = parseCurrencyValue($('#tambah-po-pph').val()) || 0;
        var transport = parseCurrencyValue($('#tambah-po-transport').val()) || 0;
        
        // Total = Sub Total + PPN + PBBKB + PPH + Transport
        var total = subtotal + ppn + pbbkb + pph + transport;
        
        // Update fields
        $('#tambah-po-subtotal').val(formatRupiah(subtotal));
        $('#tambah-po-ppn').val(formatRupiah(ppn));
        $('#tambah-po-total').val(formatRupiah(total));
        
        // Update terbilang
        if (total > 0) {
            $('#tambah-po-terbilang').text(formatTerbilang(Math.floor(total)));
        } else {
            $('#tambah-po-terbilang').text('');
        }
    }
    
    // Function to format terbilang
    function toTerbilang(num) {
        const satuan = ['','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh','sebelas'];
        num = Math.floor(num);
        if (num < 12) return satuan[num];
        if (num < 20) return toTerbilang(num - 10) + ' belas';
        if (num < 100) return toTerbilang(Math.floor(num / 10)) + ' puluh' + (num % 10 ? ' ' + toTerbilang(num % 10) : '');
        if (num < 200) return 'seratus' + (num - 100 ? ' ' + toTerbilang(num - 100) : '');
        if (num < 1000) return toTerbilang(Math.floor(num / 100)) + ' ratus' + (num % 100 ? ' ' + toTerbilang(num % 100) : '');
        if (num < 2000) return 'seribu' + (num - 1000 ? ' ' + toTerbilang(num - 1000) : '');
        if (num < 1000000) return toTerbilang(Math.floor(num / 1000)) + ' ribu' + (num % 1000 ? ' ' + toTerbilang(num % 1000) : '');
        if (num < 1000000000) return toTerbilang(Math.floor(num / 1000000)) + ' juta' + (num % 1000000 ? ' ' + toTerbilang(num % 1000000) : '');
        if (num < 1000000000000) return toTerbilang(Math.floor(num / 1000000000)) + ' miliar' + (num % 1000000000 ? ' ' + toTerbilang(num % 1000000000) : '');
        return '';
    }
    
    function formatTerbilang(n) {
        if (n === 0) return 'nol rupiah';
        return toTerbilang(n).trim() + ' rupiah';
    }
    
    // Event handler for currency input (using event delegation for dynamic elements)
    $(document).on('input', '.currency-input', function(){
        var $this = $(this);
        var cursorPos = this.selectionStart;
        var oldValue = $this.val();
        var num = oldValue.toString().replace(/[^\d]/g, '');
        
        if (num === '') {
            $this.val('');
        } else {
            var formatted = 'Rp ' + parseFloat(num).toLocaleString('id-ID');
            $this.val(formatted);
            
            // Restore cursor position
            var newCursorPos = cursorPos + (formatted.length - oldValue.length);
            this.setSelectionRange(newCursorPos, newCursorPos);
        }
        
        // Trigger calculation for Tambah PO form
        if ($this.attr('id') === 'tambah-po-hsd-solar' || 
            $this.attr('id') === 'tambah-po-ongkos-angkut' ||
            $this.attr('id') === 'tambah-po-pbbkb' ||
            $this.attr('id') === 'tambah-po-pph' ||
            $this.attr('id') === 'tambah-po-transport') {
            calculateTambahPOTotal();
        }
    });
    
    // Event handler for Qty input (direct handler for Tambah PO form)
    $(document).on('input change', '#tambah-po-qty', function(){
        var qty = parseFloat($(this).val()) || 0;
        if (qty > 9999999) {
            $(this).val(9999999);
            qty = 9999999;
        }
        calculateTambahPOTotal();
    });

    $('#btnTambahPO').on('click', () => $('#modalTambahPO').modal('show'));
    $('#btnBulkPO').on('click', () => { 
        $('#bulk-po-tbody').empty(); 
        bulkPORowCounter = 0;
        $('#bulkPOLoading').css('display', 'none');
        $('#modalBulkPO').removeClass('loading');
        $('#modalBulkPO').modal('show');
        // Add row after modal is shown
        setTimeout(function() {
            addBulkPORow();
        }, 300);
    });
    $('#btnAddBulkRow').on('click', addBulkPORow);
    
    // Hide loading when Bulk PO modal is shown
    $('#modalBulkPO').on('shown.bs.modal', function() {
        $('#bulkPOLoading').css('display', 'none');
        $('#modalBulkPO').removeClass('loading');
    });
    
    // Hide loading when Bulk PO modal is hidden
    $('#modalBulkPO').on('hidden.bs.modal', function() {
        $('#bulkPOLoading').css('display', 'none');
        $('#modalBulkPO').removeClass('loading');
        // Reset bulk form
        $('#bulk-po-tbody').empty();
        bulkPORowCounter = 0;
    });
    
    $('#modalTambahPO').on('shown.bs.modal', function(){ 
        initTambahPOSPHSelect(); 
        initTambahPOWilayahSelect(); 
        // Initialize date picker for Request Date
        $('#tambah-po-req-date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            autoClose: true
        });
        
        // Setup direct event handlers for calculation (after modal is shown)
        $('#tambah-po-hsd-solar, #tambah-po-ongkos-angkut, #tambah-po-pbbkb, #tambah-po-pph, #tambah-po-transport').off('input').on('input', function(){
            var $this = $(this);
            var cursorPos = this.selectionStart;
            var oldValue = $this.val();
            var num = oldValue.toString().replace(/[^\d]/g, '');
            
            if (num === '') {
                $this.val('');
            } else {
                var formatted = 'Rp ' + parseFloat(num).toLocaleString('id-ID');
                $this.val(formatted);
                
                // Restore cursor position
                var newCursorPos = cursorPos + (formatted.length - oldValue.length);
                this.setSelectionRange(newCursorPos, newCursorPos);
            }
            calculateTambahPOTotal();
        });
        
        $('#tambah-po-qty').off('input change').on('input change', function(){
            var qty = parseFloat($(this).val()) || 0;
            if (qty > 9999999) {
                $(this).val(9999999);
                qty = 9999999;
            }
            calculateTambahPOTotal();
        });
        
        // Calculate if there are existing values
        setTimeout(function() {
            calculateTambahPOTotal();
        }, 100);
    });
    
    // Reset form when modal is hidden
    $('#modalTambahPO').on('hidden.bs.modal', function(){
        $('#formTambahPO')[0].reset();
        $('#tambah-po-subtotal').val('');
        $('#tambah-po-ppn').val('');
        $('#tambah-po-pbbkb').val('Rp 0');
        $('#tambah-po-pph').val('Rp 0');
        $('#tambah-po-transport').val('Rp 0');
        $('#tambah-po-total').val('');
        $('#tambah-po-terbilang').text('');
        if ($('#tambah-po-sph').hasClass('select2-hidden-accessible')) {
            $('#tambah-po-sph').val(null).trigger('change');
        }
        if ($('#tambah-po-wilayah').hasClass('select2-hidden-accessible')) {
            $('#tambah-po-wilayah').val(null).trigger('change');
        }
    });

    // Handler untuk tombol view PDF
    $(document).on('click', '.btn-view-pdf', function(e){
        e.preventDefault();
        const publicUrl = $(this).data('public-url');
        if (!publicUrl) {
            Swal.fire('Oops!', 'File tidak ditemukan!', 'warning');
            return;
        }
        $('#pdfViewerFrame').attr('src', publicUrl);
        $('#pdfModal').modal('show');
    });
    
    $('#pdfModal').on('hidden.bs.modal', function(){
        $('#pdfViewerFrame').attr('src', '');
    });

    // Reset button handler for Tambah PO
    $('#btnResetTambahPO').on('click', function() {
        Swal.fire({
            title: 'Konfirmasi Reset',
            text: 'Anda yakin akan reset data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formTambahPO')[0].reset();
                if ($('#tambah-po-sph').hasClass('select2-hidden-accessible')) {
                    $('#tambah-po-sph').val(null).trigger('change');
                }
                if ($('#tambah-po-wilayah').hasClass('select2-hidden-accessible')) {
                    $('#tambah-po-wilayah').val(null).trigger('change');
                }
                $('#tambah-po-nama-perusahaan').val('');
                $('#tambah-po-source').val('');
                $('#tambah-po-seq').val('');
                $('#tambah-po-subtotal').val('');
                $('#tambah-po-ppn').val('');
                $('#tambah-po-pbbkb').val('Rp 0');
                $('#tambah-po-pph').val('Rp 0');
                $('#tambah-po-transport').val('Rp 0');
                $('#tambah-po-total').val('');
                $('#tambah-po-terbilang').text('');
                $('#tambah-po-bypass').prop('checked', false);
                Swal.fire('Berhasil!', 'Form telah direset', 'success');
            }
        });
    });

    // Form submission handler for Tambah PO
    $('#formTambahPO').on('submit', function(e) {
        e.preventDefault();
        
        var $btn = $('#btnSimpanTambahPO');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

        var formData = new FormData(this);
        
        // Convert currency values to numbers
        formData.set('hsd_solar', parseCurrencyValue($('#tambah-po-hsd-solar').val()));
        formData.set('ongkos_angkut', parseCurrencyValue($('#tambah-po-ongkos-angkut').val()) || 0);
        formData.set('subtotal', parseCurrencyValue($('#tambah-po-subtotal').val()));
        formData.set('ppn', parseCurrencyValue($('#tambah-po-ppn').val()));
        formData.set('pbbkb', parseCurrencyValue($('#tambah-po-pbbkb').val()) || 0);
        formData.set('pph', parseCurrencyValue($('#tambah-po-pph').val()) || 0);
        formData.set('transport', parseCurrencyValue($('#tambah-po-transport').val()) || 0);
        formData.set('total', parseCurrencyValue($('#tambah-po-total').val()));
        formData.set('no_seq', $('#tambah-po-seq').val().trim());
        formData.set('wilayah', $('#tambah-po-wilayah').val());
        formData.set('sph_id', $('#tambah-po-sph').val());
        formData.set('source', $('#tambah-po-source').val());
        // Set nama_perusahaan (required field)
        formData.set('nama_perusahaan', $('#tambah-po-nama-perusahaan').val() || '');
        // Set bypass value: 1 if checked, 0 if not
        formData.set('bypass', $('#tambah-po-bypass').is(':checked') ? '1' : '0');
        // Set terbilang
        formData.set('terbilang', $('#tambah-po-terbilang').text().trim());

        $.ajax({
            url: '/api/good-receipts/tambah-po',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function(res) {
            $('#modalTambahPO').modal('hide');
            Swal.fire('Berhasil!', res.message || 'PO berhasil ditambahkan', 'success');
            fetchList();
        })
        .fail(function(xhr) {
            var errorMsg = xhr.responseJSON?.message || 'Gagal menyimpan PO!';
            Swal.fire('Gagal!', errorMsg, 'error');
        })
        .always(function() {
            $btn.prop('disabled', false).html('Simpan');
        });
    });

    fetchList();
});
</script>
@endsection