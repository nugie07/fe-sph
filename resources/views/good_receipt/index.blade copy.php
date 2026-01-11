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
/* Style Konsistensi */
.btn, .btn-sm, .btn-primary, .btn-danger, .btn-secondary, .btn-success { border-radius: 8px !important; }
.btn-close { border-radius: 8px !important; background-color: #e3342f !important; opacity: 1; padding: 0.5em 0.8em !important; }
#modalBulkPO .modal-content { border-radius: 20px; position: relative; }
.bulk-row-status { text-align: center; font-size: 12px; font-weight: bold; }
.bulk-row-status.pending { color: #6c757d; }
.bulk-row-status.success { color: #198754; }
.bulk-row-status.error { color: #dc3545; }
</style>
@endsection

@section('main_content')
{{-- Bagian Header & Widget Sama Seperti Sebelumnya --}}
<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6"><h3>Good Receipts - Penerimaan PO</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item active">Good Receipt</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="container-fluid general-widget">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden"><div class="card-header pb-0"><div class="d-flex"><div class="flex-grow-1"><p class="square-after f-w-600 header-text-primary">Total SPH<i class="fa fa-circle"></i></p><h4 id="card-total_sph">-</h4></div><div class="static-widget"><i data-feather="file-text" class="text-primary"></i></div></div></div></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden"><div class="card-header pb-0"><div class="d-flex"><div class="flex-grow-1"><p class="square-after f-w-600 header-text-success">Waiting PO<i class="fa fa-circle"></i></p><h4 id="card-waiting">-</h4></div><div class="static-widget"><i data-feather="slack" class="text-success"></i></div></div></div></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden"><div class="card-header pb-0"><div class="d-flex"><div class="flex-grow-1"><p class="square-after f-w-600 header-text-danger">Received PO<i class="fa fa-circle"></i></p><h4 id="card-revisi">-</h4></div><div class="static-widget"><i data-feather="edit" class="text-danger"></i></div></div></div></div>
        </div>
    </div>
</div>

{{-- Datatable --}}
<div class="col-sm-12">
    <div class="card">
      <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
        <div><h4 class="mb-0">Data Penerimaan PO</h4></div>
        <div>
          <button type="button" class="btn btn-primary me-2" id="btnOpenTambahPO"><i class="fa fa-plus"></i> Tambah PO</button>
          <button type="button" class="btn btn-success" id="btnOpenBulkPO"><i class="fa fa-list"></i> Bulk</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="display" id="basic-1">
            <thead><tr><th>Tipe SPH</th><th>No Sph</th><th>Perusahaan</th><th>Produk</th><th>Total Harga</th><th>PO No</th><th>Aksi</th></tr></thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
</div>

{{-- Modal Tambah PO (Single) --}}
<div class="modal fade" id="modalTambahPO" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="formTambahPO" enctype="multipart/form-data">
        <div class="modal-header"><h5 class="modal-title fw-bold">Tambah PO</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body px-4 py-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Nomer SPH *</label>
                    <select id="single-sph" name="sph_id" class="form-control" required><option value=""></option></select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small">Nama Perusahaan</label>
                    <input type="text" id="single-nama-perusahaan" class="form-control" readonly style="background-color:#f8f9fa;">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="form-label fw-bold small">Nomer PO Customer *</label>
                    <input type="text" name="po_no_customer" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold small">Wilayah *</label>
                    <select id="single-wilayah" name="wilayah" class="form-control" required><option value=""></option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold small">Seq No</label>
                    <input type="text" id="single-seq" name="no_seq" class="form-control" readonly style="background-color:#f8f9fa;">
                </div>
            </div>
            <input type="hidden" id="single-source" name="source">
            <div class="row">
                <div class="col-md-3 mb-3"><label class="small fw-bold">Qty *</label><input type="number" id="single-qty" name="qty" class="form-control" required></div>
                <div class="col-md-4 mb-3"><label class="small fw-bold">HSD Solar *</label><input type="text" id="single-hsd" name="hsd_solar" class="form-control currency-input" required></div>
                <div class="col-md-5 mb-3"><label class="small fw-bold">Ongkos Angkut</label><input type="text" id="single-angkut" name="ongkos_angkut" class="form-control currency-input"></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="small fw-bold">Total</label><input type="text" id="single-total" class="form-control fw-bold" readonly style="background-color:#f8f9fa;"></div>
                <div class="col-md-6 mb-3"><label class="small fw-bold">File PO *</label><input type="file" name="file_po" class="form-control" required></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnSimpanSingle">Simpan PO</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Bulk PO --}}
<div class="modal fade" id="modalBulkPO" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 98%;">
    <div class="modal-content">
      <form id="formBulkPO">
        <div class="modal-header"><h5 class="modal-title fw-bold">Bulk Tambah PO</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="btnAddRow"><i class="fa fa-plus"></i> Tambah Baris</button>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="bg-primary text-white">
                <tr><th>No</th><th style="width:250px">Nomer SPH *</th><th>Perusahaan</th><th>PO Customer *</th><th style="width:180px">Wilayah *</th><th>Seq</th><th>Qty</th><th>HSD</th><th>Total</th><th>File</th><th>Status</th><th>#</th></tr>
              </thead>
              <tbody id="bulk-tbody"></tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Semua</button></div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>

<script>
$(function(){
    // ==========================================
    // 1. UTILS
    // ==========================================
    function formatIDR(v) {
        v = v.toString().replace(/[^\d]/g, '');
        return v ? 'Rp ' + parseFloat(v).toLocaleString('id-ID') : '';
    }
    function parseNum(v) { return parseFloat(v.toString().replace(/[^\d]/g, '')) || 0; }

    $(document).on('input', '.currency-input', function() {
        $(this).val(formatIDR($(this).val()));
    });

    // ==========================================
    // 2. SINGLE PO LOGIC
    // ==========================================
    function initSingleSPH() {
        $('#single-sph').select2({
            theme: 'bootstrap-5', width: '100%', dropdownParent: $('#modalTambahPO'),
            placeholder: 'Pilih SPH', allowClear: true,
            ajax: {
                url: '/api/good-receipts/sph-approved', dataType: 'json', delay: 250,
                processResults: data => ({ results: data.data.map(i => ({ id: i.id, text: i.kode_sph, comp: i.comp_name, tipe: i.tipe_sph })) })
            }
        }).on('select2:select', function(e) {
            const d = e.params.data;
            $('#single-nama-perusahaan').val(d.comp);
            $('#single-source').val(d.tipe);
            $(this).trigger('change.select2'); // Paksa update UI
            getSingleSeq();
        });
    }

    function initSingleWilayah() {
        $.get('/api/master-wilayah/request', function(res){
            const list = res.data || res;
            const $el = $('#single-wilayah');
            $el.empty().append('<option></option>');
            list.forEach(w => $el.append(new Option(w.code, w.value)));
            
            $el.select2({
                theme: 'bootstrap-5', width: '100%', dropdownParent: $('#modalTambahPO'),
                placeholder: 'Pilih Wilayah', allowClear: true
            }).on('select2:select', function() {
                $(this).trigger('change.select2'); // Paksa update UI
                getSingleSeq();
            });
        });
    }

    function getSingleSeq() {
        const w = $('#single-wilayah').val();
        const s = $('#single-source').val();
        if(w && s) $.getJSON('/api/delivery-note-seq', { wilayah: w, source: s }).done(res => $('#single-seq').val(res.delivery_note));
    }

    $('#btnOpenTambahPO').click(() => { $('#formTambahPO')[0].reset(); $('#modalTambahPO').modal('show'); });
    $('#modalTambahPO').on('shown.bs.modal', function() { initSingleSPH(); initSingleWilayah(); });

    // ==========================================
    // 3. BULK PO LOGIC
    // ==========================================
    let bulkCount = 0;
    function addBulkRow() {
        bulkCount++;
        const id = `row-${bulkCount}`;
        const row = `
            <tr id="${id}">
                <td>${bulkCount}</td>
                <td><select class="form-control b-sph" required></select><input type="hidden" class="b-sph-id"><input type="hidden" class="b-source"></td>
                <td><input type="text" class="form-control b-comp" readonly></td>
                <td><input type="text" class="form-control" name="po_cust[]" required></td>
                <td><select class="form-control b-wilayah" required></select></td>
                <td><input type="text" class="form-control b-seq" readonly></td>
                <td><input type="number" class="form-control b-qty" required></td>
                <td><input type="text" class="form-control b-hsd currency-input" required></td>
                <td><input type="text" class="form-control b-total" readonly></td>
                <td><input type="file" class="form-control" required></td>
                <td class="bulk-row-status pending">Pending</td>
                <td><button type="button" class="btn btn-danger btn-sm btn-del">&times;</button></td>
            </tr>`;
        $('#bulk-tbody').append(row);
        initBulkSelects(id);
    }

    function initBulkSelects(rowId) {
        const $row = $('#' + rowId);
        
        // SPH Bulk
        $row.find('.b-sph').select2({
            theme: 'bootstrap-5', width: '100%', dropdownParent: $('#modalBulkPO'),
            ajax: {
                url: '/api/good-receipts/sph-approved', dataType: 'json',
                processResults: data => ({ results: data.data.map(i => ({ id: i.id, text: i.kode_sph, comp: i.comp_name, tipe: i.tipe_sph })) })
            }
        }).on('select2:select', function(e) {
            const d = e.params.data;
            $row.find('.b-sph-id').val(d.id);
            $row.find('.b-comp').val(d.comp);
            $row.find('.b-source').val(d.tipe);
            $(this).trigger('change.select2'); // Penting agar teks muncul
            getBulkSeq(rowId);
        });

        // Wilayah Bulk
        $.get('/api/master-wilayah/request', function(res){
            const list = res.data || res;
            const $w = $row.find('.b-wilayah');
            $w.append('<option></option>');
            list.forEach(i => $w.append(new Option(i.code, i.value)));
            $w.select2({ theme: 'bootstrap-5', width: '100%', dropdownParent: $('#modalBulkPO') })
              .on('select2:select', function() {
                  $(this).trigger('change.select2'); // Penting agar teks muncul
                  getBulkSeq(rowId);
              });
        });
    }

    function getBulkSeq(rowId) {
        const $r = $('#' + rowId);
        const w = $r.find('.b-wilayah').val();
        const s = $r.find('.b-source').val();
        if(w && s) $.getJSON('/api/delivery-note-seq', { wilayah: w, source: s }).done(res => $r.find('.b-seq').val(res.delivery_note));
    }

    $('#btnOpenBulkPO').click(() => { $('#bulk-tbody').empty(); bulkCount = 0; addBulkRow(); $('#modalBulkPO').modal('show'); });
    $('#btnAddRow').click(addBulkRow);
    $(document).on('click', '.btn-del', function() { $(this).closest('tr').remove(); });

    // Fetch Initial Table
    const table = $('#basic-1').DataTable();
    function fetchList() {
        $.get('/api/good-receipts/list').done(res => {
            $('#card-total_sph').text(res.cards.total_sph);
            $('#card-waiting').text(res.cards.waiting);
            $('#card-revisi').text(res.cards.received);
            table.clear().draw();
            // ... (logika render row DT Anda)
        });
    }
    fetchList();
});
</script>
@endsection