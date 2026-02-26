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
.row-flex {
  display: flex;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
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
            <i class="fa fa-plus me-1"></i> Halaman Input PO Customer
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
          <h5 class="modal-title fw-bold">Halaman Input PO Customer</h5>
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
              <input type="text" id="tambah-po-hsd-solar" name="hsd_solar" class="form-control" required placeholder="Rp 0 atau 0,00">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Ongkos Angkut</label>
              <input type="text" id="tambah-po-ongkos-angkut" name="ongkos_angkut" class="form-control" placeholder="Rp 0 atau 0,00">
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="tambah-po-include-ppn" name="include_ppn" value="1">
                <label class="form-check-label fw-bold small" for="tambah-po-include-ppn">Include PPN</label>
              </div>
            </div>
          </div>
          <div class="row-flex">
            <div class="mb-3" style="flex: 0 0 40%; padding-right: 15px;">
              <label class="form-label fw-bold small">Sub Total</label>
              <input type="text" id="tambah-po-subtotal" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
            <div class="mb-3" style="flex: 0 0 30%; padding-right: 15px;">
              <label class="form-label fw-bold small">PPN 11%</label>
              <input type="text" id="tambah-po-ppn" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
            <div class="mb-3" style="flex: 0 0 30%; padding-right: 15px;">
              <label class="form-label fw-bold small">PBBKB</label>
              <input type="text" id="tambah-po-pbbkb" name="pbbkb" class="form-control currency-input" placeholder="Rp 0">
              <div class="mt-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pbbkb_percentage" id="tambah-po-pbbkb-75" value="7.5">
                  <label class="form-check-label" for="tambah-po-pbbkb-75">7.5%</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="pbbkb_percentage" id="tambah-po-pbbkb-10" value="10">
                  <label class="form-check-label" for="tambah-po-pbbkb-10">10%</label>
                </div>
              </div>
            </div>
          </div>
          <div class="row-flex">
            <div class="mb-3" style="flex: 0 0 40%; padding-right: 15px;">
              <label class="form-label fw-bold small">PPH 23</label>
              <input type="text" id="tambah-po-pph" name="pph" class="form-control currency-input" placeholder="Rp 0">
            </div>
            <div class="mb-3" style="flex: 0 0 60%; padding-right: 15px;">
              <label class="form-label fw-bold small">Total</label>
              <input type="text" id="tambah-po-total" class="form-control fw-bold" readonly style="background-color:#f8f9fa; font-size:16px;">
              <div class="mt-2 small">Terbilang: <span id="tambah-po-terbilang" class="text-primary fw-bold"></span></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Upload File PO <span class="text-danger">*</span></label>
              <input type="file" id="tambah-po-file" name="file_po" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-end">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="tambah-po-bypass" name="bypass" value="1">
                <label class="form-check-label fw-bold" for="tambah-po-bypass">Bypass</label>
              </div>
            </div>
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

{{-- MODAL VIEW PO (read-only dari GET detail) --}}
<div class="modal fade" id="modalViewPO" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Detail PO Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3" id="modalViewPOBody">
        <div class="text-center py-4"><span class="spinner-border text-primary"></span> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <a href="#" id="modalViewPOFileLink" class="btn btn-info d-none" target="_blank"><i class="fa fa-file-pdf-o me-1"></i> Lihat File PO</a>
      </div>
    </div>
  </div>
</div>

{{-- MODAL REVISI PO (seperti create, Seq No / Nomer SPH / Nama Perusahaan readonly) --}}
<div class="modal fade" id="modalRevisiPO" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="formRevisiPO" enctype="multipart/form-data">
        <input type="hidden" id="revisi-po-id" name="id">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Revisi PO Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Nomer SPH</label>
              <input type="text" id="revisi-po-sph" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Nama Perusahaan</label>
              <input type="text" id="revisi-po-nama-perusahaan" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Nomer PO Customer <span class="text-danger">*</span></label>
              <input type="text" id="revisi-po-no-customer" name="po_no" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Wilayah</label>
              <input type="text" id="revisi-po-wilayah" class="form-control" readonly style="background-color:#f8f9fa;">
              <input type="hidden" id="revisi-po-wilayah-value" name="wilayah">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Seq No</label>
              <input type="text" id="revisi-po-seq" name="no_seq" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
          </div>
          <input type="hidden" id="revisi-po-source" name="source">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Request Date</label>
              <input type="text" id="revisi-po-req-date" name="req_date" class="form-control" placeholder="yyyy-mm-dd">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Qty <span class="text-danger">*</span></label>
              <input type="number" id="revisi-po-qty" name="qty" class="form-control" required min="1">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">HSD Solar <span class="text-danger">*</span></label>
              <input type="text" id="revisi-po-hsd-solar" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Ongkos Angkut</label>
              <input type="text" id="revisi-po-ongkos-angkut" class="form-control">
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="revisi-po-include-ppn" name="include_ppn" value="1">
                <label class="form-check-label fw-bold small" for="revisi-po-include-ppn">Include PPN</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Sub Total</label>
              <input type="text" id="revisi-po-subtotal" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PPN 11%</label>
              <input type="text" id="revisi-po-ppn" class="form-control" readonly style="background-color:#f8f9fa;">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PBBKB</label>
              <input type="text" id="revisi-po-pbbkb" name="pbbkb" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PPH 23</label>
              <input type="text" id="revisi-po-pph" name="pph" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Total</label>
              <input type="text" id="revisi-po-total" name="total" class="form-control" readonly style="background-color:#f8f9fa;">
              <div class="mt-2 small">Terbilang: <span id="revisi-po-terbilang" class="text-primary fw-bold"></span></div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Upload File PO (opsional)</label>
              <input type="file" id="revisi-po-file" name="file" class="form-control" accept=".pdf,.doc,.docx">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btnSimpanRevisiPO">Simpan</button>
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

var goodReceiptListData = []; // simpan list untuk View/Revisi

function renderFileBtn(item) {
    // Jika status = 9 (canceled), tampilkan badge PO Canceled
    if (item.status === 9) {
        return `<span class="badge bg-danger px-2 py-1 border border-1 border-dark"
            style="font-size:11px; border-radius:4px; background-color:#dc3545; color:#fff; display:inline-block; min-width:60px; text-align:center;">
            PO Canceled
        </span>`;
    }

    var id = item.po_id != null ? item.po_id : item.id;
    var viewBtn = `<button type="button" class="btn btn-sm btn-primary me-1 btn-gr-view" data-id="${id}" title="View"><i class="fa fa-eye me-1"></i> View</button>`;
    var revisiBtn = `<button type="button" class="btn btn-sm btn-warning text-dark me-1 btn-gr-revisi" data-id="${id}" title="Revisi"><i class="fa fa-pencil me-1"></i> Revisi</button>`;
    var lihatPo = '';
    if (item.po_file && item.po_file.trim()) {
        var publicUrl = item.po_file;
        lihatPo = `<a href="#" class="btn btn-sm btn-info btn-view-pdf" data-public-url="${publicUrl}" title="Lihat PO"><i class="fa fa-file-pdf-o me-1"></i> Lihat PO</a>`;
    } else {
        lihatPo = `<span class="badge bg-secondary" style="font-size:11px;">Tidak ada File</span>`;
    }
    return `<span style="display:inline-flex; align-items:center; flex-wrap:wrap; gap:2px;">${viewBtn}${revisiBtn}${lihatPo}</span>`;
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
                goodReceiptListData = res.data;
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
    // Parse Rupiah: 505.000.000,00 -> 505000000 (dot=ribuan, koma=desimal). Jangan strip semua non-digit atau ,00 jadi 00.
    function parseCurrencyValue(v){
        if (!v || (typeof v === 'string' && v.trim() === '')) return 0;
        var s = v.toString().replace(/[^\d,.]/g, '');
        var n = s.replace(/\./g, '').replace(',', '.');
        return parseFloat(n) || 0;
    }
    function parseCurrencyValueDecimal(v){ 
        if (!v || v.trim() === '') return 0;
        // Remove Rp, spaces, and keep numbers, comma, and dot
        var cleaned = v.toString().replace(/[^\d,.]/g, '');
        // Ganti titik (pemisah ribuan) dengan kosong, koma (desimal) dengan titik
        var normalized = cleaned.replace(/\./g, '').replace(',', '.');
        return parseFloat(normalized) || 0; 
    }
    function formatCurrencyDecimal(num) {
        if (!num && num !== 0) return '';
        // Format dengan 2 desimal menggunakan toLocaleString
        return 'Rp ' + num.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    
    // Function to calculate totals for Tambah PO
    function calculateTambahPOTotal() {
        var qty = parseFloat($('#tambah-po-qty').val()) || 0;
        var hsdSolar = parseCurrencyValueDecimal($('#tambah-po-hsd-solar').val());
        var ongkosAngkutRaw = $('#tambah-po-ongkos-angkut').val() || '';
        var ongkosAngkut = parseCurrencyValueDecimal(ongkosAngkutRaw);
        var includePpn = $('#tambah-po-include-ppn').is(':checked');
        
        // Sub Total = (Qty × HSD Solar) + (Qty × Ongkos Angkut)
        // Ensure both values are numbers
        var hsdTotal = qty * (hsdSolar || 0);
        var ongkosTotal = qty * (ongkosAngkut || 0);
        var subtotal = hsdTotal + ongkosTotal;
        
        // PPN calculation based on Include PPN checkbox
        var ppn;
        if (includePpn) {
            // PPN = ((QTY * HSD SOLAR) + (QTY * ONGKOS ANGKUT)) * 11%
            ppn = subtotal * 0.11;
        } else {
            // PPN = (QTY * HSD SOLAR) * 11%
            ppn = (qty * hsdSolar) * 0.11;
        }
        
        // PBBKB calculation - check if manually entered or use radio button
        var pbbkb = parseCurrencyValue($('#tambah-po-pbbkb').val()) || 0;
        var pbbkbPercentage = $('input[name="pbbkb_percentage"]:checked').val();
        var pbbkbFieldValue = $('#tambah-po-pbbkb').val().trim();
        
        // If radio button is selected and field is empty or zero, auto calculate
        if (pbbkbPercentage && (!pbbkbFieldValue || pbbkbFieldValue === 'Rp 0' || pbbkbFieldValue === 'Rp 0,00')) {
            pbbkb = (parseFloat(pbbkbPercentage) / 100) * (qty * hsdSolar);
            $('#tambah-po-pbbkb').val(formatRupiah(pbbkb));
        }
        
        // PPH 23 calculation
        var pphFieldValue = $('#tambah-po-pph').val().trim();
        var pph = parseCurrencyValue(pphFieldValue) || 0;
        var pphCalculated = 0.02 * (ongkosAngkut * qty);
        var pphManuallyEdited = $('#tambah-po-pph').data('manually-edited') || false;
        
        // Logika PPH 23:
        // - Jika Include PPN checked: auto calculate PPH = 2% * (Ongkos Angkut * QTY), tapi bisa di-edit (termasuk set ke 0)
        // - Jika Include PPN unchecked: PPH = 0 (default), tapi bisa di-edit
        if (includePpn) {
            // Include PPN checked: auto calculate PPH = 2% * (Ongkos Angkut * QTY)
            // Auto calculate jika belum pernah di-edit manual
            if (!pphManuallyEdited) {
                // Auto calculate PPH
                pph = pphCalculated;
                $('#tambah-po-pph').val(formatRupiah(pph));
            } else {
                // User sudah mengedit manual, gunakan nilai yang sudah diisi (termasuk jika user set ke 0)
                pph = parseCurrencyValue(pphFieldValue) || 0;
            }
        } else {
            // Include PPN unchecked: default PPH = 0, tapi bisa di-edit
            // Hanya set ke 0 jika field benar-benar kosong (belum di-edit user)
            if (!pphFieldValue) {
                pph = 0;
                $('#tambah-po-pph').val('Rp 0,00');
                // Reset flag saat unchecked
                $('#tambah-po-pph').data('manually-edited', false);
            } else {
                // Gunakan nilai yang sudah diisi user (manual)
                pph = parseCurrencyValue(pphFieldValue) || 0;
            }
        }
        
        // Total = Sub Total + PPN + PBBKB saja. PPh 23 tidak dimasukkan dalam Total (bukan dikurangkan, hanya tidak dihitung di Total)
        var total = subtotal + ppn + pbbkb;
        
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
    
    // Event handler untuk HSD Solar dan Ongkos Angkut - biarkan user mengetik bebas, format hanya saat blur
    $(document).on('blur', '#tambah-po-hsd-solar, #tambah-po-ongkos-angkut', function(){
        var $this = $(this);
        var value = $this.val();
        
        if (!value || value.trim() === '') {
            $this.val('');
            return;
        }
        
        // Hapus Rp dan spasi, biarkan angka, titik, dan koma
        var cleaned = value.replace(/[^\d,.]/g, '');
        
        // Normalisasi: ganti koma dengan titik untuk parsing
        var normalized = cleaned.replace(/\./g, '').replace(',', '.');
        
        // Validasi: hanya boleh ada satu titik (desimal)
        var parts = normalized.split('.');
        if (parts.length > 2) {
            normalized = parts[0] + '.' + parts.slice(1).join('');
            parts = normalized.split('.');
        }
        
        // Batasi desimal maksimal 2 angka
        if (parts.length === 2 && parts[1].length > 2) {
            normalized = parts[0] + '.' + parts[1].substring(0, 2);
        }
        
        var num = parseFloat(normalized) || 0;
        
        // Format dengan desimal
        var formatted = formatCurrencyDecimal(num);
        $this.val(formatted);
        
        calculateTambahPOTotal();
    });
    
    // Trigger calculation saat input (tanpa formatting)
    $(document).on('input', '#tambah-po-hsd-solar, #tambah-po-ongkos-angkut', function(){
        calculateTambahPOTotal();
    });
    
    // Event handler for currency input (using event delegation for dynamic elements)
    $(document).on('input', '.currency-input', function(){
        var $this = $(this);
        var fieldId = $this.attr('id');
        
        // Skip HSD Solar dan Ongkos Angkut karena sudah dihandle di atas
        if (fieldId === 'tambah-po-hsd-solar' || fieldId === 'tambah-po-ongkos-angkut') {
            return;
        }
        
        // Track manual edit untuk PPH
        if (fieldId === 'tambah-po-pph') {
            $this.data('manually-edited', true);
        }
        
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
        if (fieldId === 'tambah-po-pbbkb' || fieldId === 'tambah-po-pph') {
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
        // Refresh Seq No dari API setiap modal dibuka agar counter IASE/seq ter-update (backend harus increment counter saat POST tambah-po)
        refreshSequenceNoTambahPO();
        // Initialize date picker for Request Date
        $('#tambah-po-req-date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            autoClose: true
        });
        
        // Setup event handlers for HSD Solar and Ongkos Angkut - format hanya saat blur
        $('#tambah-po-hsd-solar, #tambah-po-ongkos-angkut').off('blur').on('blur', function(){
            var $this = $(this);
            var value = $this.val();
            
            if (!value || value.trim() === '') {
                $this.val('');
                return;
            }
            
            // Hapus Rp dan spasi, biarkan angka, titik, dan koma
            var cleaned = value.replace(/[^\d,.]/g, '');
            
            // Normalisasi: ganti koma dengan titik untuk parsing
            var normalized = cleaned.replace(/\./g, '').replace(',', '.');
            
            // Validasi: hanya boleh ada satu titik (desimal)
            var parts = normalized.split('.');
            if (parts.length > 2) {
                normalized = parts[0] + '.' + parts.slice(1).join('');
                parts = normalized.split('.');
            }
            
            // Batasi desimal maksimal 2 angka
            if (parts.length === 2 && parts[1].length > 2) {
                normalized = parts[0] + '.' + parts[1].substring(0, 2);
            }
            
            var num = parseFloat(normalized) || 0;
            
            // Format dengan desimal
            var formatted = formatCurrencyDecimal(num);
            $this.val(formatted);
            
            calculateTambahPOTotal();
        });
        
        // Trigger calculation saat input (tanpa formatting)
        $('#tambah-po-hsd-solar, #tambah-po-ongkos-angkut').off('input').on('input', function(){
            calculateTambahPOTotal();
        });
        
        // Setup direct event handlers for PBBKB and PPH (regular currency)
        $('#tambah-po-pbbkb, #tambah-po-pph').off('input').on('input', function(){
            var $this = $(this);
            var fieldId = $this.attr('id');
            var cursorPos = this.selectionStart;
            var oldValue = $this.val();
            var num = oldValue.toString().replace(/[^\d]/g, '');
            
            // Track manual edit untuk PPH
            if (fieldId === 'tambah-po-pph') {
                $this.data('manually-edited', true);
            }
            
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
        
        // Event handler for Include PPN checkbox
        $('#tambah-po-include-ppn').off('change').on('change', function(){
            var isChecked = $(this).is(':checked');
            var pphFieldValue = $('#tambah-po-pph').val().trim();
            var pphManuallyEdited = $('#tambah-po-pph').data('manually-edited') || false;
            
            // Jika Include PPN di-check
            if (isChecked) {
                // Reset flag dan clear field jika belum pernah di-edit manual (agar auto calculate bisa jalan)
                if (!pphManuallyEdited) {
                    $('#tambah-po-pph').data('manually-edited', false);
                    $('#tambah-po-pph').val(''); // Clear field agar auto calculate jalan
                }
            } else {
                // Jika Include PPN di-uncheck, reset flag
                $('#tambah-po-pph').data('manually-edited', false);
                // Set PPH ke 0 jika belum pernah di-edit manual
                if (!pphManuallyEdited) {
                    $('#tambah-po-pph').val('Rp 0,00');
                }
            }
            
            calculateTambahPOTotal();
        });
        
        // Event handler for PBBKB radio buttons
        $('input[name="pbbkb_percentage"]').off('change').on('change', function(){
            // Clear manual input when radio is selected to trigger auto calculation
            $('#tambah-po-pbbkb').val('');
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
        $('#tambah-po-pbbkb').val('');
        $('#tambah-po-pph').val('');
        $('#tambah-po-total').val('');
        $('#tambah-po-terbilang').text('');
        $('#tambah-po-include-ppn').prop('checked', false);
        $('input[name="pbbkb_percentage"]').prop('checked', false);
        // Reset flag manually-edited untuk PPH
        $('#tambah-po-pph').data('manually-edited', false);
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

    // View PO: GET detail, tampilkan modal read-only
    $(document).on('click', '.btn-gr-view', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        if (!id) return;
        $('#modalViewPOBody').html('<div class="text-center py-4"><span class="spinner-border text-primary"></span> Loading...</div>');
        $('#modalViewPOFileLink').addClass('d-none');
        $('#modalViewPO').modal('show');
        $.get('/api/good-receipts/' + id + '/detail')
            .done(function(res) {
                var d = res.data !== undefined ? res.data : res;
                var createdDate = (d.created_at || '').toString();
                if (createdDate.length >= 10) createdDate = createdDate.substring(0, 10);
                if (!createdDate) createdDate = '-';
                var html = '<div class="mb-3"><strong>Kode SPH:</strong> ' + (d.kode_sph || '-') + '</div>';
                html += '<div class="mb-3"><strong>Nama Customer:</strong> ' + (d.nama_customer || '-') + '</div>';
                html += '<div class="mb-3"><strong>PO No:</strong> ' + (d.po_no || '-') + '</div>';
                html += '<div class="mb-3"><strong>Created:</strong> ' + createdDate + ' &nbsp; <strong>Seq No:</strong> ' + (d.no_seq != null ? d.no_seq : (d.daily_seq != null ? d.daily_seq : '-')) + '</div>';
                html += '<div class="mb-3"><strong>Request Date:</strong> ' + (d.req_date || '-') + '</div>';
                html += '<div class="mb-3"><strong>Sub Total:</strong> ' + (d.sub_total != null ? formatRupiah(parseFloat(d.sub_total)) : '-') + '</div>';
                html += '<div class="mb-3"><strong>PPN:</strong> ' + (d.ppn != null ? formatRupiah(parseFloat(d.ppn)) : '-') + ' &nbsp; <strong>PBBKB:</strong> ' + (d.pbbkb != null ? formatRupiah(parseFloat(d.pbbkb)) : '-') + '</div>';
                html += '<div class="mb-3"><strong>PPH:</strong> ' + (d.pph != null ? formatRupiah(parseFloat(d.pph)) : '-') + ' &nbsp; <strong>Transport:</strong> ' + (d.transport != null ? formatRupiah(parseFloat(d.transport)) : '-') + '</div>';
                html += '<div class="mb-3"><strong>Total:</strong> ' + (d.total != null ? formatRupiah(parseFloat(d.total)) : '-') + '</div>';
                html += '<div class="mb-3"><strong>Terbilang:</strong> ' + (d.terbilang || '-') + '</div>';
                if (d.items && d.items.length) {
                    html += '<table class="table table-bordered table-sm"><thead><tr><th>Nama Item</th><th>Qty</th><th>Per Item</th><th>Total Harga</th></tr></thead><tbody>';
                    d.items.forEach(function(it) {
                        html += '<tr><td>' + (it.nama_item || '') + '</td><td>' + (it.qty != null ? it.qty : '') + '</td><td>' + (it.per_item != null ? it.per_item : '') + '</td><td>' + (it.total_harga != null ? it.total_harga : '') + '</td></tr>';
                    });
                    html += '</tbody></table>';
                }
                $('#modalViewPOBody').html(html);
                if (d.po_file && d.po_file.trim()) {
                    var poUrl = d.po_file.indexOf('http') === 0 ? d.po_file : d.po_file;
                    $('#modalViewPOFileLink').attr('href', poUrl).removeClass('d-none');
                }
            })
            .fail(function() {
                $('#modalViewPOBody').html('<p class="text-danger">Gagal memuat detail PO.</p>');
            });
    });

    // Revisi PO: buka modal dengan data list + GET detail, Seq No / Nomer SPH / Nama Perusahaan readonly
    $(document).on('click', '.btn-gr-revisi', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        if (!id) return;
        var item = goodReceiptListData.find(function(i) { return (i.po_id != null ? i.po_id : i.id) == id; });
        if (!item) {
            Swal.fire('Oops!', 'Data tidak ditemukan.', 'warning');
            return;
        }
        $('#revisi-po-id').val(id);
        $('#revisi-po-sph').val(item.kode_sph || '');
        $('#revisi-po-nama-perusahaan').val(item.comp_name || '');
        $('#revisi-po-no-customer').val(item.po_no || '');
        $('#revisi-po-source').val(item.source || item.tipe_sph || '');
        $.get('/api/good-receipts/' + id + '/detail')
            .done(function(res) {
                var d = res.data !== undefined ? res.data : res;
                var items = d.items || [];
                // Response baru: flat sub_total, ppn, pbbkb, pph, total, terbilang, no_seq, wilayah, req_date
                $('#revisi-po-seq').val(d.no_seq != null ? d.no_seq : (item.no_seq != null ? item.no_seq : ''));
                $('#revisi-po-req-date').val((d.req_date || (d.created_at || '').toString().substring(0, 10)).toString().substring(0, 10));
                var subTotal = parseFloat(d.sub_total) || 0;
                var ppn = parseFloat(d.ppn) || 0;
                var pbbkb = parseFloat(d.pbbkb) || 0;
                var pph = parseFloat(d.pph) || 0;
                var total = parseFloat(d.total) || 0;
                $('#revisi-po-subtotal').val(formatRupiah(subTotal));
                $('#revisi-po-ppn').val(formatRupiah(ppn));
                $('#revisi-po-pbbkb').val(d.pbbkb != null && d.pbbkb !== '' ? formatCurrencyDecimal(parseFloat(d.pbbkb)) : '');
                $('#revisi-po-pph').val(d.pph != null && d.pph !== '' ? formatCurrencyDecimal(parseFloat(d.pph)) : 'Rp 0,00');
                $('#revisi-po-total').val(formatRupiah(total));
                $('#revisi-po-terbilang').text((d.terbilang || (total > 0 ? formatTerbilang(Math.floor(total)) : '')).trim());
                var hsdItem = items.find(function(i) { return (i.nama_item || '').toLowerCase().indexOf('hsd') >= 0 || (i.nama_item || '').toLowerCase().indexOf('solar') >= 0; });
                var ongkosItem = items.find(function(i) { return (i.nama_item || '').toLowerCase().indexOf('ongkos') >= 0 || (i.nama_item || '').toLowerCase().indexOf('angkut') >= 0; });
                var qty = (hsdItem && hsdItem.qty) || (items[0] && items[0].qty) || 1;
                var hsd = (hsdItem && hsdItem.per_item) != null ? parseFloat(hsdItem.per_item) : (items[0] && items[0].per_item != null ? parseFloat(items[0].per_item) : 0);
                var ongkos = (ongkosItem && ongkosItem.per_item) != null ? parseFloat(ongkosItem.per_item) : (items[1] && items[1].per_item != null ? parseFloat(items[1].per_item) : 0);
                $('#revisi-po-qty').val(qty);
                $('#revisi-po-hsd-solar').val(formatCurrencyDecimal(hsd));
                $('#revisi-po-ongkos-angkut').val(formatCurrencyDecimal(ongkos));
                $('#revisi-po-wilayah-value').val(d.wilayah || item.wilayah || '');
                $.get('/api/master-wilayah/request', function(wres) {
                    var list = Array.isArray(wres) ? wres : (wres.data || wres || []);
                    if (!Array.isArray(list)) list = [];
                    var wVal = d.wilayah || item.wilayah || item.wilayah_id;
                    var codeLabel = wVal || '-';
                    list.forEach(function(w) {
                        var val = w.value != null ? String(w.value) : (w.id != null ? String(w.id) : (w.wilayah || w.name));
                        if (val === String(wVal)) codeLabel = w.code || w.name || w.wilayah || val;
                    });
                    $('#revisi-po-wilayah').val(codeLabel);
                });
                $('#modalRevisiPO').modal('show');
            })
            .fail(function() {
                Swal.fire('Oops!', 'Gagal memuat detail PO untuk revisi.', 'warning');
            });
    });

    // Revisi form: hitung ulang total saat input berubah
    function recalcRevisiTotal() {
        var qty = parseFloat($('#revisi-po-qty').val()) || 0;
        var hsd = parseCurrencyValueDecimal($('#revisi-po-hsd-solar').val());
        var ongkos = parseCurrencyValueDecimal($('#revisi-po-ongkos-angkut').val());
        var includePpn = $('#revisi-po-include-ppn').is(':checked');
        var hsdTotal = qty * (hsd || 0);
        var ongkosTotal = qty * (ongkos || 0);
        var subtotal = hsdTotal + ongkosTotal;
        var ppn = includePpn ? subtotal * 0.11 : (qty * hsd) * 0.11;
        var pbbkb = parseCurrencyValue($('#revisi-po-pbbkb').val()) || 0;
        var pph = parseCurrencyValue($('#revisi-po-pph').val()) || 0;
        var total = subtotal + ppn + pbbkb;
        $('#revisi-po-subtotal').val(formatRupiah(subtotal));
        $('#revisi-po-ppn').val(formatRupiah(ppn));
        $('#revisi-po-total').val(formatRupiah(total));
        $('#revisi-po-terbilang').text(total > 0 ? formatTerbilang(Math.floor(total)) : '');
    }
    $(document).on('input change', '#revisi-po-qty, #revisi-po-hsd-solar, #revisi-po-ongkos-angkut, #revisi-po-pbbkb, #revisi-po-pph, #revisi-po-include-ppn', recalcRevisiTotal);

    // Form Revisi PO submit: konfirmasi lalu POST update (form-data jika ada file, else JSON)
    $('#formRevisiPO').on('submit', function(e) {
        e.preventDefault();
        var id = $('#revisi-po-id').val();
        if (!id) return;
        Swal.fire({
            title: 'Konfirmasi Revisi',
            text: 'Apakah anda yakin untuk revisi PO ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Revisi',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            var $btn = $('#btnSimpanRevisiPO');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
            var qty = parseFloat($('#revisi-po-qty').val()) || 0;
            var hsd = parseCurrencyValueDecimal($('#revisi-po-hsd-solar').val());
            var ongkos = parseCurrencyValueDecimal($('#revisi-po-ongkos-angkut').val());
            var items = [
                { nama_item: 'HSD Solar', qty: qty, per_item: hsd || 0, total_harga: qty * (hsd || 0) },
                { nama_item: 'Ongkos Angkut', qty: qty, per_item: ongkos || 0, total_harga: qty * (ongkos || 0) }
            ];
            var payload = {
                po_no: $('#revisi-po-no-customer').val().trim(),
                no_seq: $('#revisi-po-seq').val().trim(),
                wilayah: $('#revisi-po-wilayah-value').val(),
                source: $('#revisi-po-source').val(),
                sub_total: parseCurrencyValue($('#revisi-po-subtotal').val()),
                ppn: parseCurrencyValue($('#revisi-po-ppn').val()),
                pbbkb: parseCurrencyValue($('#revisi-po-pbbkb').val()) || 0,
                pph: parseCurrencyValue($('#revisi-po-pph').val()) || 0,
                total: parseCurrencyValue($('#revisi-po-total').val()),
                terbilang: $('#revisi-po-terbilang').text().trim(),
                status: 1,
                items: items
            };
            var hasFile = $('#revisi-po-file')[0].files && $('#revisi-po-file')[0].files.length > 0;
            if (hasFile) {
                var formData = new FormData();
                Object.keys(payload).forEach(function(k) {
                    if (k === 'items') formData.append(k, JSON.stringify(payload[k]));
                    else formData.append(k, payload[k]);
                });
                formData.append('file', $('#revisi-po-file')[0].files[0]);
                $.ajax({
                    url: '/api/good-receipts/' + id + '/update',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                }).done(function(res) {
                    $('#modalRevisiPO').modal('hide');
                    Swal.fire('Berhasil!', res.message || 'PO berhasil direvisi', 'success');
                    fetchList();
                }).fail(function(xhr) {
                    Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Gagal menyimpan revisi', 'error');
                }).always(function() {
                    $btn.prop('disabled', false).html('Simpan');
                });
            } else {
                $.ajax({
                    url: '/api/good-receipts/' + id + '/update',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).done(function(res) {
                    $('#modalRevisiPO').modal('hide');
                    Swal.fire('Berhasil!', res.message || 'PO berhasil direvisi', 'success');
                    fetchList();
                }).fail(function(xhr) {
                    Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Gagal menyimpan revisi', 'error');
                }).always(function() {
                    $btn.prop('disabled', false).html('Simpan');
                });
            }
        });
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
                $('#tambah-po-pbbkb').val('');
                $('#tambah-po-pph').val('');
                $('#tambah-po-total').val('');
                $('#tambah-po-terbilang').text('');
                $('#tambah-po-include-ppn').prop('checked', false);
                $('input[name="pbbkb_percentage"]').prop('checked', false);
                $('#tambah-po-bypass').prop('checked', false);
                // Reset flag manually-edited untuk PPH
                $('#tambah-po-pph').data('manually-edited', false);
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
        var includePpn = $('#tambah-po-include-ppn').is(':checked');
        var ongkosAngkutValue = parseCurrencyValueDecimal($('#tambah-po-ongkos-angkut').val()) || 0;
        
        formData.set('hsd_solar', parseCurrencyValueDecimal($('#tambah-po-hsd-solar').val()));
        // Ongkos Angkut: jika Include PPN unchecked, set ke 0, jika checked gunakan nilai dari field
        formData.set('ongkos_angkut', includePpn ? ongkosAngkutValue : 0);
        formData.set('subtotal', parseCurrencyValue($('#tambah-po-subtotal').val()));
        formData.set('ppn', parseCurrencyValue($('#tambah-po-ppn').val()));
        formData.set('pbbkb', parseCurrencyValue($('#tambah-po-pbbkb').val()) || 0);
        formData.set('pph', parseCurrencyValue($('#tambah-po-pph').val()) || 0);
        // Transport: 0 if Include PPN is checked, otherwise use Ongkos Angkut value
        formData.set('transport', includePpn ? 0 : ongkosAngkutValue);
        formData.set('total', parseCurrencyValue($('#tambah-po-total').val()));
        formData.set('include_ppn', includePpn ? '1' : '0');
        formData.set('pbbkb_percentage', $('input[name="pbbkb_percentage"]:checked').val() || '');
        // no_seq (e.g. IASE020): backend harus update counter di DB saat simpan berhasil agar seq berikutnya increment
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