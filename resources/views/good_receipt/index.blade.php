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
/* Fix button shape: kotak rounded bukan pill */
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
.btnRemovePOItem {
  border-radius: 8px !important;
  font-size: 16px !important;
  font-weight: bold;
  padding: 3px 14px !important;
  background: #e3342f !important;
  color: #fff !important;
  border: none;
}
.btnRemovePOItem:hover {
  background: #c82333 !important;
  color: #fff !important;
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
.bulk-row-status.pending {
  color: #6c757d;
}
.bulk-row-status.processing {
  color: #0d6efd;
}
.bulk-row-status.success {
  color: #198754;
}
.bulk-row-status.error {
  color: #dc3545;
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
  <div class="container-fluid general-widget">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary">Total SPH Dibuat<i class="fa fa-circle"></i></p>
                            <h4 id="card-total_sph">-</h4>
                        </div>
                        <div class="d-flex static-widget">
                                <i data-feather="file-text" class="text-primary" style="width: 40px; height: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden product-widget">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-success">Total PO Belum Diterima<i class="fa fa-circle"></i></p>
                            <h4 id="card-waiting">-</h4>
                        </div>
                        <div class="d-flex static-widget">
                            <i data-feather="slack" class="text-success" style="width: 40px; height: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card o-hidden message-widget">
                <div class="card-header pb-0">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-danger">Total PO Diterima<i class="fa fa-circle"></i></p>
                            <h4 id="card-revisi">-</h4>
                        </div>
                        <div class="d-flex static-widget">
                            <i data-feather="edit" class="text-danger" style="width: 40px; height: 40px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  {{-- Datatable --}}
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Data Penerimaan PO</h4>
          <span>Data penerimaan PO dari SPH yang telah dibuat dan dikirim</span>
        </div>
        <div>
          <button type="button" class="btn btn-primary me-2" id="btnTambahPO" style="border-radius:8px;">
            <i class="fa fa-plus me-1"></i> Tambah PO
          </button>
          <button type="button" class="btn btn-success" id="btnBulkPO" style="border-radius:8px;">
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
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<!-- Modal PDF Viewer -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preview Purchase Order (PDF)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="height: 80vh;">
        <iframe id="pdfViewerFrame" src="" frameborder="0" width="100%" height="100%" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cancel PO -->
<div class="modal fade" id="modalCancelPO" tabindex="-1" aria-labelledby="modalCancelPOLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-danger" id="modalCancelPOLabel">
          <i class="fa fa-exclamation-triangle me-2"></i>Konfirmasi Cancel PO
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <i class="fa fa-warning me-2"></i>
          <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
        </div>
        <p>Apakah Anda yakin akan membatalkan PO ini?</p>
        <div class="mb-3">
          <label class="form-label fw-bold">Kode SPH: <span id="cancel-po-sph-code" class="text-primary"></span></label>
        </div>
        <div class="mb-3">
          <label for="cancelConfirmation" class="form-label fw-bold">
            Ketik <code>no_sph</code> untuk konfirmasi:
          </label>
          <input type="text" class="form-control" id="cancelConfirmation"
                 placeholder="Ketik 'no_sph' untuk konfirmasi"
                 style="border:1px solid #495057; box-shadow:none;">
          <div class="form-text">Masukkan kode SPH yang benar untuk melanjutkan.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">Batal</button>
        <button type="button" class="btn btn-danger" id="btnConfirmCancel" style="border-radius:8px;" disabled>
          <i class="fa fa-times me-1"></i>Cancel PO
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah PO -->
<div class="modal fade" id="modalTambahPO" tabindex="-1" aria-labelledby="modalTambahPOLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="formTambahPO" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalTambahPOLabel">Tambah PO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Nomer SPH <span class="text-danger">*</span></label>
              <select id="tambah-po-sph" name="sph_id" class="form-control select2" data-placeholder="Pilih Nomer SPH" style="width: 100%;" required>
                <option value=""></option>
              </select>
              <div class="form-text">Pilih SPH yang telah disetujui</div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Nama Perusahaan</label>
              <input type="text" id="tambah-po-nama-perusahaan" name="nama_perusahaan" class="form-control" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 mb-3">
              <label class="form-label fw-bold small">Nomer PO Customer <span class="text-danger">*</span></label>
              <input type="text" id="tambah-po-no-customer" name="po_no_customer" class="form-control" required style="border:1px solid #495057; box-shadow:none;">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Wilayah <span class="text-danger">*</span></label>
              <select id="tambah-po-wilayah" name="wilayah" class="form-control select2" data-placeholder="Pilih Wilayah" style="width: 100%;" required>
                <option value=""></option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Seq No</label>
              <input type="text" id="tambah-po-seq" name="no_seq" class="form-control" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;">
            </div>
          </div>
          <!-- Hidden Source field for seq generation -->
          <input type="hidden" id="tambah-po-source" name="source">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label fw-bold small">Qty <span class="text-danger">*</span></label>
              <input type="number" id="tambah-po-qty" name="qty" class="form-control" required min="1" max="9999999" style="border:1px solid #495057; box-shadow:none;" placeholder="0">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">HSD Solar <span class="text-danger">*</span></label>
              <input type="text" id="tambah-po-hsd-solar" name="hsd_solar" class="form-control currency-input" required style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </div>
            <div class="col-md-5 mb-3">
              <label class="form-label fw-bold small">Ongkos Angkut</label>
              <input type="text" id="tambah-po-ongkos-angkut" name="ongkos_angkut" class="form-control currency-input" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Sub Total</label>
              <input type="text" id="tambah-po-subtotal" name="subtotal" class="form-control" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;" value="Rp 0">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">PPN 11%</label>
              <input type="text" id="tambah-po-ppn" name="ppn" class="form-control" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;" value="Rp 0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PBBKB</label>
              <input type="text" id="tambah-po-pbbkb" name="pbbkb" class="form-control currency-input" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">PPH 23</label>
              <input type="text" id="tambah-po-pph" name="pph" class="form-control currency-input" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold small">Transport</label>
              <input type="text" id="tambah-po-transport" name="transport" class="form-control currency-input" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Total</label>
              <input type="text" id="tambah-po-total" name="total" class="form-control fw-bold" readonly style="border:2px solid #495057; box-shadow:none; background-color:#f8f9fa; font-size:16px;" value="Rp 0">
              <div class="mt-2">
                <span class="fw-bold small">Terbilang:</span>
                <span id="tambah-po-terbilang" class="fw-bold text-primary"></span>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold small">Upload File PO <span class="text-danger">*</span> <span class="text-muted">(PDF/Word, maks 1MB)</span></label>
              <input type="file" id="tambah-po-file" name="file_po" class="form-control" accept=".pdf,.doc,.docx" required style="border:1px solid #495057; box-shadow:none;">
              <div class="form-text">Hanya file PDF dan Word, maksimal 1MB</div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="tambah-po-bypass" name="bypass" value="1">
                <label class="form-check-label fw-bold" for="tambah-po-bypass">
                  Bypass
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btnResetTambahPO" style="border-radius:8px;">Reset</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius:8px;">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btnSimpanTambahPO" style="border-radius:8px;">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Bulk PO -->
<div class="modal fade" id="modalBulkPO" tabindex="-1" aria-labelledby="modalBulkPOLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 98%; width: 98%;">
    <div class="modal-content">
      <form id="formBulkPO" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalBulkPOLabel">Bulk Tambah PO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3" style="max-height: 80vh; overflow-y: auto;">
          <div class="mb-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddBulkRow" style="border-radius:8px;">
              <i class="fa fa-plus me-1"></i> Tambah Baris
            </button>
            <div id="bulk-progress-info" class="d-none">
              <div class="progress" style="width: 300px; height: 25px;">
                <div id="bulk-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
              </div>
              <small class="text-muted" id="bulk-progress-text">Menyimpan 0 dari 0...</small>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="bulk-po-table">
              <thead class="bg-primary text-white">
                <tr>
                  <th style="width: 50px;">No</th>
                  <th style="min-width: 200px;">Nomer SPH *</th>
                  <th style="min-width: 180px;">Nama Perusahaan</th>
                  <th style="min-width: 150px;">Nomer PO Customer *</th>
                  <th style="min-width: 120px;">Wilayah *</th>
                  <th style="min-width: 100px;">Seq No</th>
                  <th style="min-width: 100px;">Qty *</th>
                  <th style="min-width: 150px;">HSD Solar *</th>
                  <th style="min-width: 150px;">Ongkos Angkut</th>
                  <th style="min-width: 120px;">Sub Total</th>
                  <th style="min-width: 120px;">PPN 11%</th>
                  <th style="min-width: 120px;">PBBKB</th>
                  <th style="min-width: 120px;">PPH 23</th>
                  <th style="min-width: 120px;">Transport</th>
                  <th style="min-width: 150px;">Total</th>
                  <th style="min-width: 200px;">Upload File PO *</th>
                  <th style="width: 100px;">Bypass</th>
                  <th style="width: 100px;">Status</th>
                  <th style="width: 80px;">#</th>
                </tr>
              </thead>
              <tbody id="bulk-po-tbody">
                <!-- Rows will be added dynamically -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btnResetBulkPO" style="border-radius:8px;">Reset</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius:8px;">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btnSimpanBulkPO" style="border-radius:8px;">Simpan Semua</button>
        </div>
      </form>
      <!-- Loading overlay -->
      <div class="modal-loading-backdrop" id="bulkPOLoading" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.7); z-index: 2000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(6px); border-radius: 20px;">
        <div class="text-center">
          <div class="spinner-border text-primary" style="width:3rem;height:3rem;"></div>
          <div class="mt-2 fw-bold text-primary" id="bulk-loading-text">Memproses...</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
// Pastikan jQuery sudah di-load sebelum Select2
if (typeof jQuery === 'undefined') {
    console.error('jQuery is not loaded!');
} else {
    console.log('jQuery version:', jQuery.fn.jquery);
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
// Pastikan Select2 sudah di-load
if (typeof jQuery.fn.select2 === 'undefined') {
    console.error('Select2 is not loaded!');
} else {
    console.log('Select2 is loaded successfully');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>


$(function(){
// ========== FORM TAMBAH PO ==========
// Function to refresh Seq No for Tambah PO
function refreshSequenceNoTambahPO() {
    let wilayah = $('#tambah-po-wilayah').val();
    let source = $('#tambah-po-source').val();
    
    // Jika salah satu kosong, kosongkan field dan stop
    if (!wilayah || !source) {
        $('#tambah-po-seq').val('');
        return;
    }
    
    $.getJSON('/api/delivery-note-seq', { wilayah: wilayah, source: source })
        .done(function(res) {
            $('#tambah-po-seq').val(res.delivery_note || '');
        })
        .fail(function() {
            $('#tambah-po-seq').val('');
        });
}

// Initialize Wilayah Select2
function initTambahPOWilayahSelect() {
    // Destroy existing Select2 if any
    if ($('#tambah-po-wilayah').hasClass('select2-hidden-accessible')) {
        $('#tambah-po-wilayah').select2('destroy');
    }
    
    // Load data wilayah
    $.get('/api/master-wilayah/request', function(wilayahRes){
        var wilayahList = Array.isArray(wilayahRes) ? wilayahRes : (wilayahRes.data || []);
        var $wilayahSelect = $('#tambah-po-wilayah').html('<option value=""></option>');
        wilayahList.forEach(function(w){
            $wilayahSelect.append(`<option value="${w.value}">${w.code}</option>`);
        });
        
        // Initialize Select2 for Wilayah
        var $wilayahSelect = $('#tambah-po-wilayah');
        $wilayahSelect.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Pilih Wilayah',
            dropdownParent: $('#modalTambahPO'),
            allowClear: true
        });
        
        // Event handler untuk generate Seq No saat wilayah dipilih/diganti
        $wilayahSelect.off('change.select2').on('change.select2', function(e) {
            refreshSequenceNoTambahPO();
        });
        
        // Handle select2:select event - ensure the selected value is displayed correctly
        $wilayahSelect.off('select2:select').on('select2:select', function(e) {
            var data = e.params.data;
            var $select = $(this);
            
            // Select2 should automatically set the value and update display
            // But we ensure it's set correctly
            if ($select.val() !== data.id) {
                $select.val(data.id);
            }
            
            // Force Select2 to update its display by triggering change
            setTimeout(function() {
                $select.trigger('change.select2');
                refreshSequenceNoTambahPO();
            }, 10);
        });
    });
}

// Button to open modal
$('#btnTambahPO').on('click', function() {
    resetTambahPOForm();
    $('#modalTambahPO').modal('show');
});

// Initialize Select2 when modal is fully shown
$('#modalTambahPO').on('shown.bs.modal', function () {
    initTambahPOSPHSelect();
    initTambahPOWilayahSelect();
    initCurrencyInputs(); // Re-initialize currency inputs
});

// Initialize Select2 for SPH dropdown
function initTambahPOSPHSelect() {
    // Destroy existing Select2 if any
    if ($('#tambah-po-sph').hasClass('select2-hidden-accessible')) {
        $('#tambah-po-sph').select2('destroy');
    }
    
    $('#tambah-po-sph').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih Nomer SPH',
        allowClear: true,
        dropdownParent: $('#modalTambahPO'),
        ajax: {
            url: '/api/good-receipts/sph-approved',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                if (data.success && data.data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.kode_sph + ' - ' + item.comp_name,
                                kode_sph: item.kode_sph,
                                comp_name: item.comp_name,
                                tipe_sph: item.tipe_sph
                            };
                        })
                    };
                }
                return { results: [] };
            },
            cache: true
        },
        minimumInputLength: 0
    });

    // Handle SPH selection change
    $('#tambah-po-sph').off('select2:select').on('select2:select', function (e) {
        var data = e.params.data;
        $('#tambah-po-nama-perusahaan').val(data.comp_name || '');
        $('#tambah-po-source').val(data.tipe_sph || '');
        calculateTambahPOTotal();
        // Generate Seq No if wilayah already selected
        refreshSequenceNoTambahPO();
    });

    // Clear fields when SPH is cleared
    $('#tambah-po-sph').off('select2:clear').on('select2:clear', function () {
        $('#tambah-po-nama-perusahaan').val('');
        $('#tambah-po-source').val('');
        $('#tambah-po-seq').val('');
        calculateTambahPOTotal();
    });
}

// Currency formatting function
function formatCurrencyInput(value) {
    // Remove all non-digit characters
    var num = value.toString().replace(/[^\d]/g, '');
    if (num === '') return '';
    // Format as currency
    return 'Rp ' + parseFloat(num).toLocaleString('id-ID');
}

// Parse currency value to number
function parseCurrencyValue(value) {
    if (!value) return 0;
    var num = value.toString().replace(/[^\d]/g, '');
    return parseFloat(num) || 0;
}

// Initialize currency inputs
function initCurrencyInputs() {
    // Use event delegation to handle dynamically added elements
    $(document).off('input', '.currency-input').on('input', '.currency-input', function() {
        var $this = $(this);
        var cursorPos = this.selectionStart;
        var oldValue = $this.val();
        var num = oldValue.toString().replace(/[^\d]/g, '');
        
        if (num === '') {
            $this.val('');
        } else {
            var formatted = formatCurrencyInput(num);
            $this.val(formatted);
            
            // Restore cursor position
            var newCursorPos = cursorPos + (formatted.length - oldValue.length);
            this.setSelectionRange(newCursorPos, newCursorPos);
        }
        
        calculateTambahPOTotal();
    });

    // Format on blur
    $(document).off('blur', '.currency-input').on('blur', '.currency-input', function() {
        var num = parseCurrencyValue($(this).val());
        if (num > 0) {
            $(this).val(formatCurrencyInput(num.toString()));
        } else {
            $(this).val('');
        }
    });
    
    // Event listener for Qty
    $('#tambah-po-qty').off('input change').on('input change', function() {
        var qty = parseFloat($(this).val()) || 0;
        // Limit to 7 digits (max 9999999)
        if (qty > 9999999) {
            $(this).val(9999999);
            qty = 9999999;
        }
        calculateTambahPOTotal();
    });
}

// Calculate totals
function calculateTambahPOTotal() {
    var qty = parseFloat($('#tambah-po-qty').val()) || 0;
    var hsdSolar = parseCurrencyValue($('#tambah-po-hsd-solar').val());
    var ongkosAngkut = parseCurrencyValue($('#tambah-po-ongkos-angkut').val());
    // Sub Total = (Qty X HSD Solar) + (Qty X Ongkos Angkut)
    var subtotal = (qty * hsdSolar) + (qty * ongkosAngkut);
    var ppn = subtotal * 0.11;
    var pbbkb = parseCurrencyValue($('#tambah-po-pbbkb').val());
    var pph = parseCurrencyValue($('#tambah-po-pph').val());
    var transport = parseCurrencyValue($('#tambah-po-transport').val());
    var total = subtotal + ppn + pbbkb + pph + transport;

    $('#tambah-po-subtotal').val(formatCurrencyInput(subtotal.toString()));
    $('#tambah-po-ppn').val(formatCurrencyInput(ppn.toString()));
    $('#tambah-po-total').val(formatCurrencyInput(total.toString()));
    
    // Update terbilang
    if (total > 0) {
        $('#tambah-po-terbilang').text(formatTerbilang(Math.floor(total)));
    } else {
        $('#tambah-po-terbilang').text('');
    }
}

// File upload validation
$('#tambah-po-file').on('change', function() {
    var file = this.files[0];
    if (!file) return;

    var maxSize = 1 * 1024 * 1024; // 1MB
    var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    var allowedExtensions = ['.pdf', '.doc', '.docx'];

    // Check file size
    if (file.size > maxSize) {
        Swal.fire('Error!', 'Ukuran file maksimal 1MB', 'error');
        $(this).val('');
        return;
    }

    // Check file type
    var fileExtension = '.' + file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(fileExtension)) {
        Swal.fire('Error!', 'Hanya file PDF dan Word yang diperbolehkan', 'error');
        $(this).val('');
        return;
    }
});

// Reset button with confirmation
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
            resetTambahPOForm();
            Swal.fire('Berhasil!', 'Form telah direset', 'success');
        }
    });
});

// Reset form function
function resetTambahPOForm() {
    $('#formTambahPO')[0].reset();
    if ($('#tambah-po-sph').hasClass('select2-hidden-accessible')) {
        $('#tambah-po-sph').val(null).trigger('change');
    } else {
        $('#tambah-po-sph').val(null);
    }
    if ($('#tambah-po-wilayah').hasClass('select2-hidden-accessible')) {
        $('#tambah-po-wilayah').val(null).trigger('change');
    } else {
        $('#tambah-po-wilayah').val(null);
    }
    $('#tambah-po-nama-perusahaan').val('');
    $('#tambah-po-source').val('');
    $('#tambah-po-seq').val('');
    $('#tambah-po-qty').val('');
    $('#tambah-po-subtotal').val('Rp 0');
    $('#tambah-po-ppn').val('Rp 0');
    $('#tambah-po-total').val('Rp 0');
    $('#tambah-po-terbilang').text('');
    $('#tambah-po-pbbkb').val('');
    $('#tambah-po-pph').val('');
    $('#tambah-po-transport').val('');
    $('#tambah-po-hsd-solar').val('');
    $('#tambah-po-ongkos-angkut').val('');
    $('#tambah-po-bypass').prop('checked', false);
}

// Form submission
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
        resetTambahPOForm();
        fetchList(); // Refresh data table
    })
    .fail(function(xhr) {
        var errorMsg = xhr.responseJSON?.message || 'Gagal menyimpan PO!';
        Swal.fire('Gagal!', errorMsg, 'error');
    })
    .always(function() {
        $btn.prop('disabled', false).html('Simpan');
    });
});

// Initialize currency inputs on page load
initCurrencyInputs();

// Cleanup when modal is closed
$('#modalTambahPO').on('hidden.bs.modal', function () {
    resetTambahPOForm();
    // Destroy Select2 when modal is closed
    if ($('#tambah-po-sph').hasClass('select2-hidden-accessible')) {
        $('#tambah-po-sph').select2('destroy');
    }
    if ($('#tambah-po-wilayah').hasClass('select2-hidden-accessible')) {
        $('#tambah-po-wilayah').select2('destroy');
    }
});

// ========== BULK PO ==========
let bulkPORowCounter = 0;

// Button to open Bulk PO modal
$('#btnBulkPO').on('click', function() {
    resetBulkPOForm();
    $('#modalBulkPO').removeClass('loading');
    $('#bulkPOLoading').hide();
    $('#modalBulkPO').modal('show');
    // Add first row
    setTimeout(function() {
        addBulkPORow();
    }, 100);
});

// Add new row to Bulk PO table
function addBulkPORow() {
    bulkPORowCounter++;
    const rowId = 'bulk-row-' + bulkPORowCounter;
    const rowHtml = `
        <tr id="${rowId}" data-row-id="${bulkPORowCounter}">
            <td class="text-center align-middle">${bulkPORowCounter}</td>
            <td>
                <select class="form-control bulk-sph select2" data-placeholder="Pilih SPH" style="width: 100%;" required>
                    <option value=""></option>
                </select>
                <input type="hidden" class="bulk-sph-id" name="bulk[${bulkPORowCounter}][sph_id]">
                <input type="hidden" class="bulk-source" name="bulk[${bulkPORowCounter}][source]">
            </td>
            <td>
                <input type="text" class="form-control bulk-nama-perusahaan" name="bulk[${bulkPORowCounter}][nama_perusahaan]" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;">
            </td>
            <td>
                <input type="text" class="form-control bulk-po-no-customer" name="bulk[${bulkPORowCounter}][po_no_customer]" required style="border:1px solid #495057; box-shadow:none;">
            </td>
            <td>
                <select class="form-control bulk-wilayah select2" data-placeholder="Pilih Wilayah" style="width: 100%;" required>
                    <option value=""></option>
                </select>
                <input type="hidden" class="bulk-wilayah-val" name="bulk[${bulkPORowCounter}][wilayah]">
            </td>
            <td>
                <input type="text" class="form-control bulk-seq" name="bulk[${bulkPORowCounter}][no_seq]" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;">
            </td>
            <td>
                <input type="number" class="form-control bulk-qty" name="bulk[${bulkPORowCounter}][qty]" required min="1" max="9999999" style="border:1px solid #495057; box-shadow:none;" placeholder="0">
            </td>
            <td>
                <input type="text" class="form-control bulk-hsd-solar currency-input" name="bulk[${bulkPORowCounter}][hsd_solar]" required style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-ongkos-angkut currency-input" name="bulk[${bulkPORowCounter}][ongkos_angkut]" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-subtotal" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;" value="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-ppn" readonly style="border:1px solid #495057; box-shadow:none; background-color:#f8f9fa;" value="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-pbbkb currency-input" name="bulk[${bulkPORowCounter}][pbbkb]" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-pph currency-input" name="bulk[${bulkPORowCounter}][pph]" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-transport currency-input" name="bulk[${bulkPORowCounter}][transport]" style="border:1px solid #495057; box-shadow:none;" placeholder="Rp 0">
            </td>
            <td>
                <input type="text" class="form-control bulk-total fw-bold" readonly style="border:2px solid #495057; box-shadow:none; background-color:#f8f9fa;" value="Rp 0">
            </td>
            <td>
                <input type="file" class="form-control bulk-file" name="bulk[${bulkPORowCounter}][file_po]" accept=".pdf,.doc,.docx" required style="border:1px solid #495057; box-shadow:none;">
            </td>
            <td class="text-center align-middle">
                <div class="form-check d-flex justify-content-center">
                    <input class="form-check-input bulk-bypass" type="checkbox" name="bulk[${bulkPORowCounter}][bypass]" value="1" id="bulk-bypass-${bulkPORowCounter}">
                </div>
            </td>
            <td class="text-center align-middle bulk-row-status pending" data-status="pending">
                <span class="status-text">-</span>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-danger btn-sm btn-remove-bulk-row" style="border-radius:8px;">&times;</button>
            </td>
        </tr>
    `;
    $('#bulk-po-tbody').append(rowHtml);
    
    // Initialize Select2 for SPH and Wilayah
    initBulkRowSelect2(rowId);
    
    // Initialize currency inputs
    initCurrencyInputs();
}

// Initialize Select2 for a bulk row
function initBulkRowSelect2(rowId) {
    const $row = $('#' + rowId);
    const $sphSelect = $row.find('.bulk-sph');
    const $wilayahSelect = $row.find('.bulk-wilayah');
    
    // Initialize SPH Select2
    $sphSelect.select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih SPH',
        dropdownParent: $('#modalBulkPO'),
        allowClear: true,
        ajax: {
            url: '/api/good-receipts/sph-approved',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                if (data.success && data.data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.kode_sph + ' - ' + item.comp_name,
                                kode_sph: item.kode_sph,
                                comp_name: item.comp_name,
                                tipe_sph: item.tipe_sph
                            };
                        })
                    };
                }
                return { results: [] };
            },
            cache: true
        },
        minimumInputLength: 0
    });
    
    // Handle SPH selection
    $sphSelect.on('select2:select', function(e) {
        const data = e.params.data;
        $row.find('.bulk-sph-id').val(data.id);
        $row.find('.bulk-nama-perusahaan').val(data.comp_name || '');
        $row.find('.bulk-source').val(data.tipe_sph || '');
        calculateBulkRowTotal(rowId);
        refreshBulkRowSeq(rowId);
    });
    
    // Load Wilayah data
    $.get('/api/master-wilayah/request', function(wilayahRes){
        const wilayahList = Array.isArray(wilayahRes) ? wilayahRes : (wilayahRes.data || []);
        wilayahList.forEach(function(w){
            $wilayahSelect.append(`<option value="${w.value}">${w.code}</option>`);
        });
        
        // Initialize Wilayah Select2
        $wilayahSelect.select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Pilih Wilayah',
            dropdownParent: $('#modalBulkPO'),
            allowClear: true
        });
        
        // Handle Wilayah selection
        $wilayahSelect.on('select2:select', function(e) {
            const selectedValue = $(this).val();
            $row.find('.bulk-wilayah-val').val(selectedValue);
            refreshBulkRowSeq(rowId);
        });
    });
}

// Refresh Seq No for a bulk row
function refreshBulkRowSeq(rowId) {
    const $row = $('#' + rowId);
    const wilayah = $row.find('.bulk-wilayah').val();
    const source = $row.find('.bulk-source').val();
    
    if (!wilayah || !source) {
        $row.find('.bulk-seq').val('');
        return;
    }
    
    $.getJSON('/api/delivery-note-seq', { wilayah: wilayah, source: source })
        .done(function(res) {
            $row.find('.bulk-seq').val(res.delivery_note || '');
        })
        .fail(function() {
            $row.find('.bulk-seq').val('');
        });
}

// Calculate total for a bulk row
function calculateBulkRowTotal(rowId) {
    const $row = $('#' + rowId);
    const qty = parseFloat($row.find('.bulk-qty').val()) || 0;
    const hsdSolar = parseCurrencyValue($row.find('.bulk-hsd-solar').val());
    const ongkosAngkut = parseCurrencyValue($row.find('.bulk-ongkos-angkut').val());
    const subtotal = (qty * hsdSolar) + (qty * ongkosAngkut);
    const ppn = subtotal * 0.11;
    const pbbkb = parseCurrencyValue($row.find('.bulk-pbbkb').val());
    const pph = parseCurrencyValue($row.find('.bulk-pph').val());
    const transport = parseCurrencyValue($row.find('.bulk-transport').val());
    const total = subtotal + ppn + pbbkb + pph + transport;
    
    $row.find('.bulk-subtotal').val(formatCurrencyInput(subtotal.toString()));
    $row.find('.bulk-ppn').val(formatCurrencyInput(ppn.toString()));
    $row.find('.bulk-total').val(formatCurrencyInput(total.toString()));
}

// Event handlers for bulk rows
$(document).on('click', '#btnAddBulkRow', function() {
    addBulkPORow();
});

$(document).on('click', '.btn-remove-bulk-row', function() {
    $(this).closest('tr').remove();
    // Renumber rows
    $('#bulk-po-tbody tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
    });
});

$(document).on('input change', '.bulk-qty, .bulk-hsd-solar, .bulk-ongkos-angkut, .bulk-pbbkb, .bulk-pph, .bulk-transport', function() {
    const rowId = $(this).closest('tr').attr('id');
    if (rowId) {
        calculateBulkRowTotal(rowId);
    }
});

// File upload validation for bulk PO
$(document).on('change', '.bulk-file', function() {
    const file = this.files[0];
    if (!file) return;
    
    const maxSize = 1 * 1024 * 1024; // 1MB
    const allowedExtensions = ['.pdf', '.doc', '.docx'];
    
    // Check file size
    if (file.size > maxSize) {
        Swal.fire('Error!', 'Ukuran file maksimal 1MB', 'error');
        $(this).val('');
        return;
    }
    
    // Check file type
    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(fileExtension)) {
        Swal.fire('Error!', 'Hanya file PDF dan Word yang diperbolehkan', 'error');
        $(this).val('');
        return;
    }
});

// Reset Bulk PO button
$('#btnResetBulkPO').on('click', function() {
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
            resetBulkPOForm();
            Swal.fire('Berhasil!', 'Form telah direset', 'success');
        }
    });
});

// Reset Bulk PO form
function resetBulkPOForm() {
    $('#bulk-po-tbody').html('');
    bulkPORowCounter = 0;
    $('#bulk-progress-info').addClass('d-none');
    $('#bulk-progress-bar').css('width', '0%');
    $('#bulk-progress-text').text('Menyimpan 0 dari 0...');
}

// Submit Bulk PO form
$('#formBulkPO').on('submit', function(e) {
    e.preventDefault();
    
    const $btn = $('#btnSimpanBulkPO');
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
    
    const rows = [];
    const rowElements = [];
    let hasError = false;
    
    $('#bulk-po-tbody tr').each(function() {
        const $row = $(this);
        const rowData = {
            sph_id: $row.find('.bulk-sph-id').val(),
            nama_perusahaan: $row.find('.bulk-nama-perusahaan').val(),
            po_no_customer: $row.find('.bulk-po-no-customer').val(),
            wilayah: $row.find('.bulk-wilayah').val(),
            no_seq: $row.find('.bulk-seq').val(),
            source: $row.find('.bulk-source').val(),
            qty: parseFloat($row.find('.bulk-qty').val()) || 0,
            hsd_solar: parseCurrencyValue($row.find('.bulk-hsd-solar').val()),
            ongkos_angkut: parseCurrencyValue($row.find('.bulk-ongkos-angkut').val()) || 0,
            subtotal: parseCurrencyValue($row.find('.bulk-subtotal').val()),
            ppn: parseCurrencyValue($row.find('.bulk-ppn').val()),
            pbbkb: parseCurrencyValue($row.find('.bulk-pbbkb').val()) || 0,
            pph: parseCurrencyValue($row.find('.bulk-pph').val()) || 0,
            transport: parseCurrencyValue($row.find('.bulk-transport').val()) || 0,
            total: parseCurrencyValue($row.find('.bulk-total').val()),
            file_po: $row.find('.bulk-file')[0].files[0],
            bypass: $row.find('.bulk-bypass').is(':checked') ? '1' : '0',
            terbilang: formatTerbilang(Math.floor(parseCurrencyValue($row.find('.bulk-total').val())))
        };
        
        if (!rowData.sph_id || !rowData.po_no_customer || !rowData.wilayah || !rowData.qty || !rowData.hsd_solar || !rowData.file_po) {
            hasError = true;
            return false;
        }
        
        rows.push(rowData);
        rowElements.push($row);
    });
    
    if (hasError || rows.length === 0) {
        Swal.fire('Error!', 'Pastikan semua field required terisi dengan benar', 'error');
        $btn.prop('disabled', false).html('Simpan Semua');
        return;
    }
    
    // Show loading overlay and prevent modal close
    $('#modalBulkPO').addClass('loading');
    $('#bulkPOLoading').show();
    $('#bulk-progress-info').removeClass('d-none');
    
    // Prevent modal close
    const modalInstance = bootstrap.Modal.getInstance($('#modalBulkPO')[0]);
    if (modalInstance) {
        modalInstance._config.backdrop = 'static';
        modalInstance._config.keyboard = false;
    }
    
    // Disable close button
    $('#modalBulkPO .btn-close, #modalBulkPO [data-bs-dismiss="modal"]').prop('disabled', true).css('pointer-events', 'none');
    
    // Reset all row statuses to pending
    rowElements.forEach(function($row) {
        updateBulkRowStatus($row, 'pending', '-');
    });
    
    // Submit each row
    let successCount = 0;
    let failCount = 0;
    let completed = 0;
    const totalRows = rows.length;
    
    function updateProgress() {
        const progress = Math.round((completed / totalRows) * 100);
        $('#bulk-progress-bar').css('width', progress + '%');
        $('#bulk-progress-text').text(`Menyimpan ${completed} dari ${totalRows}...`);
        $('#bulk-loading-text').text(`Memproses ${completed} dari ${totalRows} PO...`);
    }
    
    rows.forEach(function(rowData, index) {
        const $row = rowElements[index];
        updateBulkRowStatus($row, 'processing', 'Memproses...');
        
        const formData = new FormData();
        Object.keys(rowData).forEach(function(key) {
            if (rowData[key] !== null && rowData[key] !== undefined) {
                formData.append(key, rowData[key]);
            }
        });
        
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
            successCount++;
            updateBulkRowStatus($row, 'success', 'Berhasil');
        })
        .fail(function(xhr) {
            failCount++;
            const errorMsg = xhr.responseJSON?.message || 'Gagal';
            updateBulkRowStatus($row, 'error', 'Gagal');
        })
        .always(function() {
            completed++;
            updateProgress();
            
            if (completed === totalRows) {
                // Hide loading overlay
                setTimeout(function() {
                    $('#modalBulkPO').removeClass('loading');
                    $('#bulkPOLoading').hide();
                    $('#bulk-progress-info').addClass('d-none');
                    
                    // Re-enable modal close
                    const modalInstance = bootstrap.Modal.getInstance($('#modalBulkPO')[0]);
                    if (modalInstance) {
                        modalInstance._config.backdrop = true;
                        modalInstance._config.keyboard = true;
                    }
                    $('#modalBulkPO .btn-close, #modalBulkPO [data-bs-dismiss="modal"]').prop('disabled', false).css('pointer-events', 'auto');
                    
                    $('#modalBulkPO').modal('hide');
                    
                    if (failCount === 0) {
                        Swal.fire('Berhasil!', `Semua ${successCount} PO berhasil ditambahkan`, 'success');
                    } else {
                        Swal.fire('Perhatian!', `${successCount} PO berhasil, ${failCount} PO gagal`, 'warning');
                    }
                    resetBulkPOForm();
                    fetchList();
                    $btn.prop('disabled', false).html('Simpan Semua');
                }, 500);
            }
        });
    });
});

// Update status for a bulk row
function updateBulkRowStatus($row, status, text) {
    const $statusCell = $row.find('.bulk-row-status');
    $statusCell.removeClass('pending processing success error');
    $statusCell.addClass(status);
    $statusCell.attr('data-status', status);
    $statusCell.find('.status-text').text(text);
}

// Cleanup when Bulk PO modal is closed
$('#modalBulkPO').on('hidden.bs.modal', function () {
    resetBulkPOForm();
    // Destroy all Select2 instances
    $('#bulk-po-tbody .select2').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
        }
    });
    // Reset modal state
    $('#modalBulkPO').removeClass('loading');
    $('#bulkPOLoading').hide();
    const modalInstance = bootstrap.Modal.getInstance($('#modalBulkPO')[0]);
    if (modalInstance) {
        modalInstance._config.backdrop = true;
        modalInstance._config.keyboard = true;
    }
    $('#modalBulkPO .btn-close, #modalBulkPO [data-bs-dismiss="modal"]').prop('disabled', false).css('pointer-events', 'auto');
});
// ========== END BULK PO ==========

// ========== END FORM TAMBAH PO ==========

// 1. Initialize DataTable
var table = $.fn.dataTable.isDataTable('#basic-1')
    ? $('#basic-1').DataTable()
    : $('#basic-1').DataTable({
        paging: true,
        searching: true,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o"></i> Export',
        titleAttr: 'Export to Excel',
        className: 'btn btn-sm btn-success'
        }],
        columns: [
        { title: 'Tipe SPH' },
        { title: 'No Sph' },
        { title: 'Nama Perusahaan' },
        { title: 'Produk Dibeli' },
        { title: 'Total Harga' },
        { title: 'PO No' },
        { title: 'Download PO' }
        ]
    });

function renderPoNo(item) {
    if (item.po_no && item.po_no.trim()) {
        return `<span class="badge bg-secondary px-2 py-1 border border-1 border-dark"
        style="font-size:11px; border-radius:4px; background-color:#f8f9fa; color:#333; display:inline-block; min-width:60px; text-align:center;">
        ${item.po_no}
        </span>`;
    }
    return '-';
}

function renderSphNo(item) {
    let html = `<div>${item.kode_sph || '-'}</div>`;

    // Tambahkan badge revisi jika ada
    if (item.revisi_count && item.revisi_count > 0) {
        html += `<div class="mt-1">
            <span class="badge bg-warning text-dark" style="font-size:11px; padding:2px 6px; border-radius:4px;">
                Revisi: ${item.revisi_count}
            </span>
        </div>`;
    }

    return html;
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
        // Tambahkan tombol Revisi PO dan Cancel PO di samping Lihat PO
        return `
            <span style="display:inline-flex; align-items:center; gap:2px;">
                <a href="#" class="badge bg-info px-2 py-1 border border-1 border-dark btn-view-pdf"
                    data-public-url="${publicUrl}"
                    style="font-size:11px; border-radius:4px; background-color:#e3f2fd; color:#fff; display:inline-block; min-width:60px; text-align:center;">
                    <i class="fa fa-file-pdf-o me-1"></i> Lihat PO
                </a>
                <a href="#" class="badge bg-success px-2 py-1 border border-1 border-dark btn-revisi-po"
                    data-po-id="${item.po_id}"
                    style="font-size:11px; border-radius:4px; margin-left:2px; display:inline-block; min-width:60px; text-align:center;">
                    <i class="fa fa-pencil-square-o me-1"></i> Revisi PO
                </a>
                <a href="#" class="badge bg-danger px-2 py-1 border border-1 border-dark btn-cancel-po"
                    data-po-id="${item.po_id}"
                    data-kode-sph="${item.kode_sph || ''}"
                    style="font-size:11px; border-radius:4px; margin-left:2px; display:inline-block; min-width:60px; text-align:center;">
                    <i class="fa fa-times me-1"></i> Cancel PO
                </a>
            </span>
        `;
    } else {
        // Untuk status = 0 (belum ada file), tambahkan tombol Cancel PO
        if (item.status === 0) {
            return `
                <span style="display:inline-flex; align-items:center; gap:2px;">
                    <span class="badge bg-danger px-2 py-1 border border-1 border-dark"
                        style="font-size:11px; border-radius:4px; background-color:#fdecea; color:#fff; display:inline-block; min-width:60px; text-align:center;">
                        Tidak ada File
                    </span>
                    <a href="#" class="badge bg-danger px-2 py-1 border border-1 border-dark btn-cancel-po"
                        data-po-id="${item.po_id}"
                        data-kode-sph="${item.kode_sph || ''}"
                        style="font-size:11px; border-radius:4px; margin-left:2px; display:inline-block; min-width:60px; text-align:center;">
                        <i class="fa fa-times me-1"></i> Cancel PO
                    </a>
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
        $('#card-total_sph').text(res.cards.total_sph);
        $('#card-waiting').text(res.cards.waiting);
        $('#card-revisi').text(res.cards.received);

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

function formatRupiah(x){
    x = parseFloat(x)||0;
    return 'Rp ' + x.toLocaleString('id-ID',{ minimumFractionDigits:2 });
}

function toTerbilang(num) {
const satuan = ['','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh','sebelas'];

num = Math.floor(num);
if (num < 12) {
    return satuan[num];
}
if (num < 20) {
    return toTerbilang(num - 10) + ' belas';
}
if (num < 100) {
    return toTerbilang(Math.floor(num / 10)) + ' puluh' + (num % 10 ? ' ' + toTerbilang(num % 10) : '');
}
if (num < 200) {
    return 'seratus' + (num - 100 ? ' ' + toTerbilang(num - 100) : '');
}
if (num < 1000) {
    return toTerbilang(Math.floor(num / 100)) + ' ratus' + (num % 100 ? ' ' + toTerbilang(num % 100) : '');
}
if (num < 2000) {
    return 'seribu' + (num - 1000 ? ' ' + toTerbilang(num - 1000) : '');
}
if (num < 1000000) {
    return toTerbilang(Math.floor(num / 1000)) + ' ribu' + (num % 1000 ? ' ' + toTerbilang(num % 1000) : '');
}
if (num < 1000000000) {
    return toTerbilang(Math.floor(num / 1000000)) + ' juta' + (num % 1000000 ? ' ' + toTerbilang(num % 1000000) : '');
}
if (num < 1000000000000) {
    return toTerbilang(Math.floor(num / 1000000000)) + ' miliar' + (num % 1000000000 ? ' ' + toTerbilang(num % 1000000000) : '');
}
// Kalau perlu trilion ke atas, bisa ditambah
return '';
}

function formatTerbilang(n) {
if (n === 0) return 'nol rupiah';
return toTerbilang(n).trim() + ' rupiah';
}
    fetchList();

});
</script>
<script>
</script>
<script>
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
</script>

<script>
// Handler tombol Cancel PO
$(document).on('click', '.btn-cancel-po', function(e){
    e.preventDefault();
    const po_id = $(this).data('po-id');
    const kode_sph = $(this).data('kode-sph');

    if (!po_id) return;

    // Set data untuk modal
    $('#cancel-po-sph-code').text(kode_sph);
    $('#modalCancelPO').data('po-id', po_id);
    $('#modalCancelPO').data('kode-sph', kode_sph);

    // Reset form
    $('#cancelConfirmation').val('');
    $('#btnConfirmCancel').prop('disabled', true);

    // Tampilkan modal
    $('#modalCancelPO').modal('show');
});

// Validasi input konfirmasi
$(document).on('input', '#cancelConfirmation', function(){
    const inputValue = $(this).val().trim();
    const expectedValue = $('#modalCancelPO').data('kode-sph');

    if (inputValue === expectedValue) {
        $('#btnConfirmCancel').prop('disabled', false);
        $(this).removeClass('is-invalid').addClass('is-valid');
    } else {
        $('#btnConfirmCancel').prop('disabled', true);
        $(this).removeClass('is-valid').addClass('is-invalid');
    }
});

// Handler konfirmasi cancel PO
$(document).on('click', '#btnConfirmCancel', function(){
    const po_id = $('#modalCancelPO').data('po-id');
    const kode_sph = $('#modalCancelPO').data('kode-sph');
    const confirmation = $('#cancelConfirmation').val().trim();

    if (confirmation !== kode_sph) {
        Swal.fire('Error!', 'Kode SPH tidak cocok!', 'error');
        return;
    }

    // Disable button dan tampilkan loading
    const $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

    // Hit API cancel PO
    $.ajax({
        url: `/api/good-receipts/${po_id}/cancel`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            kode_sph: kode_sph,
            last_update_by: '{{ auth()->user()->name ?? "System" }}',
            last_update_at: new Date().toISOString()
        }
    })
    .done(function(res){
        $('#modalCancelPO').modal('hide');

        // Refresh data table immediately
        fetchList();

        // Show success message after a short delay
        setTimeout(function() {
            Swal.fire('Berhasil!', res.message || 'PO berhasil dibatalkan', 'success');
        }, 100);
    })
    .fail(function(xhr){
        Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal membatalkan PO!', 'error');
        // Refresh data table even on error to ensure consistency
        fetchList();
    })
    .always(function(){
        $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i>Cancel PO');
    });
});

// Reset modal saat ditutup
$('#modalCancelPO').on('hidden.bs.modal', function(){
    $('#cancelConfirmation').val('').removeClass('is-valid is-invalid');
    $('#btnConfirmCancel').prop('disabled', true);
});
</script>
@endsection
