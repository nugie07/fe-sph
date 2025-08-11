@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link
  href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
  rel="stylesheet"/>
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6">
        <h3>Pembuatan Purchase Order - Cetak PO</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item active">Cetak PO </li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid general-widget">
  <div class="row">
    <div class="col-sm-6 col-lg-3">
      <div class="card o-hidden">
        <div class="card-header pb-0">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="square-after f-w-600 header-text-primary">Total PO Supplier | Transporter<i class="fa fa-circle"> </i></p>
              <!-- added id -->
              <h4 id="card-total_po">-|-</h4>
            </div>
            <div class="d-flex static-widget">
                <i data-feather="github" class="text-primary" style="width: 40px; height: 40px;"></i>
                &nbsp;&nbsp;<i data-feather="truck" class="text-success" style="width: 40px; height: 40px;"></i>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="progress-widget">
            <div class="progress sm-progress-bar progress-animate">
              <div class="progress-gradient-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
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
              <p class="square-after f-w-600 header-text-info">Menunggu Approval<i class="fa fa-circle"> </i></p>
              <!-- added id -->
              <h4 id="card-draft">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="edit" class="text-info" style="width: 40px; height: 40px;"></i>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="progress-widget">
            <div class="progress sm-progress-bar progress-animate">
              <div class="progress-gradient-info" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
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
              <p class="square-after f-w-600 header-text-success">Approved<i class="fa fa-circle"> </i></p>
              <!-- added id -->
              <h4 id="card-approved">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="star" class="text-success" style="width: 40px; height: 40px;"></i>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="progress-widget">
            <div class="progress sm-progress-bar progress-animate">
              <div class="progress-gradient-success" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card o-hidden user-widget">
        <div class="card-header pb-0">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="square-after f-w-600 header-text-danger">Reject<i class="fa fa-circle"> </i></p>
              <!-- added id -->
              <h4 id="card-approved_reject">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="alert-triangle" class="text-danger" style="width: 40px; height: 40px;"></i>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="progress-widget">
            <div class="progress sm-progress-bar progress-animate">
              <div class="progress-gradient-danger" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- Datatable disini --}}
<div class="col-sm-12">
    <div class="card">
      <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Data Cetak PO</h4>
            <span>Data semua cetak PO untuk Supplier atau Transporter </span>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">
            <button type="button" class="btn btn-success" id="btnAddPO"
            style="color:#fff; border-radius:8px; aspect-ratio:1/1; width:40px; height:40px; display:flex; align-items:center; justify-content:center;" title="Buat PO Baru">
                <i class="fa fa-plus"></i>
            </button>
            <select class="form-select" id="filter-status" style="width:200px;max-width:220px;">
                <option value="">Semua Status</option>
                <option value="approvallist">Menunggu Approval</option>
                <option value="reject">Reject</option>
                <option value="draft">Draft</option>
                <option value="approved">Approved</option>
            </select>
            <select class="form-select" id="filter-category" style="width:200px;max-width:220px;">
              <option value="">Semua Kategori</option>
              <option value="1">Supplier</option>
              <option value="2">Transporter</option>
            </select>
        </div>
    </div>
      <div class="card-body">
        <div class="table-responsive theme-scrollbar">
          <table class="display" id="basic-1">
            <thead>
              <tr>
                <th>No</th>
                <th>Tipe PO</th>
                <th>DN No</th>
                <th>Nomer DRS</th>
                <th>Nama Supplier / Transportir</th>
                <th>Nilai PO (Rp)</th>
                <th>Status PO</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
<!-- CREATE PO SUPPLIER MODAL -->
<div class="modal fade" id="modal-create-po-supplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pembuatan PO Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-create-po-supplier" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <input type="hidden" name="drs_unique" id="sp_drs_unique">
                        <input type="hidden" name="category" id="po_category" value="1">
                        <div class="col-md-4">
                            <label>Nomer PO</label>
                            <input type="text" name="vendor_po" id="sp_vendor_po" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Nomer PO wajib diisi.</div>
                        </div>
                        <div class="col-md-5">
                            <label>DRS No</label>
                            <select id="sp_drs_no" name="drs_no" class="form-control select2" required>
                            </select>
                            <div class="invalid-feedback">Field DRS No wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Dn No</label>
                            <input type="text" id="sp_dn_no" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Dn No wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                            <label>Vendor Name</label>
                            <select id="sp_vendor_name" name="vendor_name" class="form-control select2" required>
                            </select>
                            <div class="invalid-feedback">Field Vendor Name wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Customer PO</label>
                            <input type="text" name="customer_po" id="sp_customer_po" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Customer PO wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal PO</label>
                            <input type="text" name="tgl_po" id="sp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required>
                            <div class="invalid-feedback">Field Tanggal PO wajib diisi.</div>
                        </div>
                        <div class="col-md-5">
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
                        <div class="col-md-4">
                            <label>Transport</label>
                            <input type="text" id="sp_transport" class="form-control" required>
                            <div class="invalid-feedback">Field Transport wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Harga</label>
                            <input type="text" id="sp_harga" class="form-control" required>
                            <div class="invalid-feedback">Field Harga wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Qty</label>
                            <input type="number" name="qty" id="sp_qty" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Qty wajib diisi.</div>
                        </div>
                        <div class="col-md-4"><label>Sub Total</label><input type="text" id="sp_sub_total" class="form-control" readonly></div>
                        <div class="col-md-4"><label>PPN</label><input type="text" id="sp_ppn" class="form-control" readonly></div>
                        <div class="col-md-4"><label>PPH</label><input type="text" id="sp_pph" class="form-control" readonly></div>
                        <div class="col-md-4"><label>PBBKB</label><input type="text" id="sp_pbbkb" class="form-control" readonly></div>
                        <div class="col-md-4"><label>BPH</label><input type="text" id="sp_bph" class="form-control" readonly></div>
                        <div class="col-md-4"><label>Total</label><input type="text" id="sp_total" class="form-control" readonly></div>
                        <!-- Hidden raw value inputs for decimal submission -->
                        <input type="hidden" id="sp_transport_raw" name="transport">
                        <input type="hidden" id="sp_harga_raw" name="harga">
                        <input type="hidden" id="sp_sub_total_raw" name="sub_total">
                        <input type="hidden" id="sp_ppn_raw" name="ppn">
                        <input type="hidden" id="sp_pbbkb_raw" name="pbbkb">
                        <input type="hidden" id="sp_pph_raw" name="pph">
                        <input type="hidden" id="sp_bph_raw" name="bph">
                        <input type="hidden" id="sp_total_raw" name="total">
                        <div class="col-md-12"><label>Terbilang</label><input type="text" name="terbilang" id="sp_terbilang" class="form-control" readonly></div>
                        <div class="col-md-12"><label>Keterangan</label><textarea name="description" id="sp_description" class="form-control"></textarea></div>
                        <div class="col-md-12"><label>Additional Notes</label><textarea name="additional_notes" id="sp_additional_notes" class="form-control"></textarea></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form-create-po-supplier" id="btn-save-supplier" class="btn btn-primary rounded-square" style="border-radius:8px;">
                    <span class="txt">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
            <!-- Loading overlay -->
            <div class="modal-loading-backdrop" id="modalCreatePOLoading">
                <div class="d-flex flex-column align-items-center">
                    <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"></div>
                    <div class="mt-2 fw-bold text-primary">Loading data...</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- WORKFLOW REMARKS MODAL -->
<div class="modal fade" id="workflow-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Loading overlay for Workflow Modal -->
            <div class="modal-loading-backdrop" id="workflowModalLoading" style="display:none; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.8); z-index:2000; align-items:center; justify-content:center;">
                <div class="spinner-border text-primary" role="status" style="width:3rem; height:3rem;"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Workflow History</h5>
                <button type="button" class="btn btn-danger rounded-square" style="border-radius:8px;" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="workflow-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengisi</th>
                                <th>Remark</th>
                                <th>Di Buat Tanggal</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create-po" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Loading overlay for transporter modal -->
            <div class="modal-loading-backdrop" id="modalCreatePOTransporterLoading" style="display:none; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(255,255,255,0.8); z-index:2000; align-items:center; justify-content:center;">
                <div class="spinner-border text-primary" role="status" style="width:3rem; height:3rem;"></div>
            </div>
            <form id="form-create-po">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pembuatan PO Transportir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="drs_unique" id="cp_drs_unique">
                    <!-- Baris 1 -->
                    <div class="col-md-4"><label>DRS No</label><input type="text" id="cp_drs_no" class="form-control" readonly required></div>
                    <div class="col-md-4"><label>Customer PO</label><input type="text" id="cp_customer_po" class="form-control" readonly required></div>
                    <div class="col-md-4"><label>Vendor PO</label><input type="text" id="cp_vendor_po" class="form-control" readonly required></div>
                    <!-- Baris 2 -->
                    <div class="col-md-8">
                        <label>Vendor Name</label>
                        <input type="text" name="vendor_name" id="cp_vendor_name" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal PO</label>
                        <input
                            type="text"
                            name="tgl_po"
                            id="cp_tgl_po"
                            class="form-control datepicker-here"
                            data-language="en"
                            data-date-format="yyyy-mm-dd"
                            placeholder="YYYY-MM-DD"
                            required
                        >
                    </div>
                    <!-- Baris 3 -->
                    <div class="col-md-6">
                        <label>Nama PIC</label>
                        <input type="text" name="pic_site" id="cp_nama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Contact</label>
                        <input type="text" name="pic_site_telp" id="cp_contact" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Alamat</label>
                        <input type="text" name="site_location" id="cp_alamat" class="form-control" required>
                    </div>
                    <!-- Baris 4 -->
                    <div class="col-md-12"><label>Delivery To</label><input type="text" name="delivery_to" id="cp_delivery_to" class="form-control" required></div>
                    <!-- Baris 5 -->
                    <div class="col-md-4"><label>FOB</label><input type="text" name="fob" class="form-control" required></div>
                    <div class="col-md-4"><label>Loading Point</label><input type="text" name="loading_point" class="form-control" required></div>
                    <div class="col-md-4"><label>Shipped Via</label><input type="text" name="shipped_via" class="form-control" required></div>
                    <!-- Comments Or Special Notes -->
                    <div class="col-md-12">
                        <label>Comments Or Special Notes</label>
                        <textarea name="special_notes" id="cp_special_notes" class="form-control"></textarea>
                    </div>
                    <!-- Baris 6 -->
                    <div class="col-md-3">
                        <label>Transport</label>
                        <input type="hidden" name="transport" id="cp_transport_raw" required>
                        <input type="text" id="cp_transport" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-3">
                        <label>Uang Portal</label>
                        <input type="hidden" name="portal" id="cp_portal_raw" required>
                        <input type="text" id="cp_portal" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-3">
                        <label>Harga</label>
                        <input type="hidden" name="harga" id="cp_harga_raw" required>
                        <input type="text" id="cp_harga" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-3">
                        <label>Qty</label>
                        <input type="text" id="cp_qty" class="form-control" readonly required>
                    </div>
                    <!-- Baris 7 -->
                    <div class="col-md-4">
                        <label>
                            Sub Total&nbsp;
                            <i class="fa fa-info-circle text-secondary"
                                data-bs-toggle="tooltip"
                                title="Rumus SubTotal = (Qty * Harga) * Transport"
                                style="cursor: help;"></i>
                        </label>
                        <input type="hidden" name="sub_total" id="cp_sub_total_raw" required>
                        <input type="text" id="cp_sub_total" class="form-control" readonly placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Total&nbsp;
                            <i class="fa fa-info-circle text-secondary"
                                data-bs-toggle="tooltip"
                                title="Rumus Total = SubTotal + Portal"
                                style="cursor: help;"></i>
                        </label>
                        <input type="hidden" name="total" id="cp_total_raw" required>
                        <input type="text" id="cp_total" class="form-control" readonly placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-4">
                        <label>Metode Pembayaran</label>
                        <select id="cp_term" name="term" class="form-control select2" data-placeholder="Pilih Metode Pembayaran" style="width:100%" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <!-- Baris 8 -->
                    <div class="col-md-12"><label>Terbilang</label><input type="text" name="terbilang" id="cp_terbilang" class="form-control" readonly required></div>
                    <!-- Baris 9 -->
                    <div class="col-md-12"><label>Keterangan</label><textarea name="description" class="form-control"></textarea></div>
                    <!-- Baris 10 (jika masih perlu) -->
                    <div class="col-md-12"><label>Additional Notes</label><textarea name="additional_notes" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save-po" class="btn btn-primary rounded-square" style="border-radius:8px;">
                        <span class="txt">Simpan</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Include revision modals --}}
@include('purchase_order.revisi_supplier')
@include('purchase_order.revisi_transportir')

        </div> {{-- Penutup untuk .table-responsive --}}
      </div> {{-- Penutup untuk .card-body --}}
    </div> {{-- Penutup untuk .card --}}
</div> {{-- Penutup untuk .col-sm-12 --}}
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
<!-- Panggil Select2 JS di layout -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// --- [FIXED] Load data into revision modals on show ---
// --- Handles both supplier and transporter revision modals ---

$('#modal-revisi-po-supplier').on('show.bs.modal', function() {
    var $modal = $(this);
    var drsUnique = $modal.find('[name="drs_unique"]').val();
    var modalLoadingId = '#modalRevisiSupplierLoading'; // Specific loading overlay

    $modal.addClass('loading');
    $(modalLoadingId).show();

    // Fetch PO data and vendor list in parallel
    var poDataRequest = $.get('/api/purchase-order/list', { drs_unique: drsUnique });
    var vendorListRequest = $.get('/api/transporter?category=1'); // Fetch all vendors

    $.when(poDataRequest, vendorListRequest).done(function(poDataResponse, vendorListResponse) {
        var d = (poDataResponse[0].data && poDataResponse[0].data[0]) || {};

        // Populate regular fields
        $modal.find('[name="vendor_po"]').val(d.vendor_po || '');
        // ... populate other fields from 'd' object
        $modal.find('[name="drs_no"]').val(d.drs_no || '');
        $modal.find('[name="dn_no"]').val(d.dn_no || '');
        $modal.find('[name="customer_po"]').val(d.customer_po || '');
        $modal.find('[name="tgl_po"]').val(d.tgl_po || '');
        $modal.find('[name="nama"]').val(d.nama || '');
        $modal.find('[name="contact"]').val(d.contact || '');
        $modal.find('[name="alamat"]').val(d.alamat || '');
        $modal.find('[name="fob"]').val(d.fob || '');
        $modal.find('[name="shipped_via"]').val(d.shipped_via || '');
        $modal.find('[name="loading_point"]').val(d.loading_point || '');
        $modal.find('[name="delivery_to"]').val(d.delivery_to || '');
        $modal.find('[name="qty"]').val(d.qty || '');
        $modal.find('[name="terbilang"]').val(d.terbilang || '');
        $modal.find('[name="description"]').val(d.description || '');
        $modal.find('[name="additional_notes"]').val(d.additional_notes || '');

        // --- Populate and initialize Vendor Name Select2 ---
        var vendorList = vendorListResponse[0].data || vendorListResponse[0];
        var $vendorSelect = $modal.find('[name="vendor_name"]').empty();
        vendorList.forEach(function(vendor) {
            // [FIX] Add data-format attribute to the option
            var option = new Option(vendor.nama || vendor.name, vendor.nama || vendor.name);
            $(option).attr('data-format', vendor.format || '');
            $vendorSelect.append(option);
        });
        $vendorSelect.val(d.vendor_name); // Set selected value
        $vendorSelect.select2({
            theme: 'bootstrap-5',
            dropdownParent: $modal,
            placeholder: 'Pilih Vendor'
        });

        // --- Populate and initialize Payment Method Select2 ---
        var $termSelect = $modal.find('[name="term"]');
        $termSelect.val(d.term);
        $termSelect.select2({
            theme: 'bootstrap-5',
            dropdownParent: $modal,
            placeholder: 'Pilih Metode Pembayaran'
        });

        // Numeric fields with formatting
        function setSupplierField(displayId, rawId, value) {
            $modal.find('#' + rawId).val(value || 0);
            $modal.find('#' + displayId).val(value ? 'Rp. ' + parseFloat(value).toLocaleString('id-ID') : '');
        }

        setSupplierField('sp_transport', 'sp_transport_raw', d.transport);
        setSupplierField('sp_harga', 'sp_harga_raw', d.harga);
        // ... set other numeric fields
        setSupplierField('sp_sub_total', 'sp_sub_total_raw', d.sub_total);
        setSupplierField('sp_ppn', 'sp_ppn_raw', d.ppn);
        setSupplierField('sp_pbbkb', 'sp_pbbkb_raw', d.pbbkb);
        setSupplierField('sp_pph', 'sp_pph_raw', d.pph);
        setSupplierField('sp_bph', 'sp_bph_raw', d.bph);
        setSupplierField('sp_total', 'sp_total_raw', d.total);

    }).fail(function() {
        Swal.fire('Error', 'Gagal memuat data revisi supplier.', 'error');
    }).always(function() {
        $(modalLoadingId).hide();
        $modal.removeClass('loading');
    });
});


$('#modal-revisi-transportir').on('show.bs.modal', function() {
    var $modal = $(this);
    var drsUnique = $modal.find('[name="drs_unique"]').val();
    var modalLoadingId = '#modalCreatePOTransporterLoading'; // Specific loading overlay

    $modal.addClass('loading');
    $(modalLoadingId).show();

    $.get('/api/purchase-order/list', { drs_unique: drsUnique })
        .done(function(res) {
            var d = (res.data && res.data[0]) || {};

            // Populate fields
            $modal.find('[name="drs_unique"]').val(d.drs_unique || '');
            // ... populate other fields ...
            $modal.find('[name="drs_no"]').val(d.drs_no || '');
            $modal.find('[name="customer_po"]').val(d.customer_po || '');
            $modal.find('[name="vendor_po"]').val(d.vendor_po || '');
            $modal.find('[name="vendor_name"]').val(d.vendor_name || '');
            $modal.find('[name="tgl_po"]').val(d.tgl_po || '');
            $modal.find('[name="pic_site"]').val(d.nama || '');
            $modal.find('[name="pic_site_telp"]').val(d.contact || '');
            $modal.find('[name="site_location"]').val(d.alamat || '');
            $modal.find('[name="delivery_to"]').val(d.delivery_to || '');
            $modal.find('[name="qty"]').val(d.qty || '');
            $modal.find('[name="terbilang"]').val(d.terbilang || '');
            $modal.find('[name="special_notes"]').val(d.special_notes || d.description || '');

            // --- Initialize Payment Method Select2 ---
            var $termSelect = $modal.find('[name="term"]');
            $termSelect.val(d.term);
            $termSelect.select2({
                theme: 'bootstrap-5',
                dropdownParent: $modal,
                placeholder: 'Pilih Metode Pembayaran'
            });

            // Numeric fields
            function setTransporterField(displayId, rawId, value) {
                $modal.find('#' + rawId).val(value || 0);
                $modal.find('#' + displayId).val(value ? 'Rp. ' + parseFloat(value).toLocaleString('id-ID') : '');
            }
            setTransporterField('cp_transport', 'cp_transport_raw', d.transport);
            setTransporterField('cp_portal', 'cp_portal_raw', d.portal);
            setTransporterField('cp_harga', 'cp_harga_raw', d.harga);
            setTransporterField('cp_sub_total', 'cp_sub_total_raw', d.sub_total);
            setTransporterField('cp_total', 'cp_total_raw', d.total);
        })
        .fail(function() {
            Swal.fire('Error', 'Gagal memuat data revisi transporter', 'error');
        })
        .always(function() {
            $(modalLoadingId).hide();
            $modal.removeClass('loading');
        });
});
</script>
<style>
  .clickable {
    cursor: pointer;
  }
  .clickable:hover {
    opacity: 0.8;
  }
  #modal-create-po-supplier .modal-loading-backdrop {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    border-radius: 0.5rem;
  }
  #modal-create-po-supplier.loading .modal-content {
    filter: blur(2px);
    pointer-events: none;
  }
</style>
<script>
$(document).ready(function(){
    // Override default alert() to use SweetAlert
    window.alert = function(message) {
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: message,
            confirmButtonText: 'OK'
        });
    };

    function formatRupiah(angka) {
        if (!angka) return 'Rp 0';
        return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
    }

    function formatDateTime(iso) {
        if (!iso) return '-';
        var d = new Date(iso);
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        var nd = new Date(utc + (3600000 * 7));
        var day = nd.getDate();
        var monthNames = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        var month = monthNames[nd.getMonth()];
        var year = nd.getFullYear();
        var hours = nd.getHours().toString().padStart(2,'0');
        var minutes = nd.getMinutes().toString().padStart(2,'0');
        return day + ' ' + month + ' ' + year + ' ' + hours + ':' + minutes;
    }

    function getStatusBadge(status) {
        switch(Number(status)) {
            case 0: return '<span class="badge bg-dark">Draft</span>';
            case 1: return '<span class="badge bg-info text-white">Menunggu Approval</span>';
            case 2: return '<span class="badge bg-warning text-dark">Revisi</span>';
            case 3: return '<span class="badge bg-danger">Reject</span>';
            case 4: return '<span class="badge bg-success">Approved</span>';
            default: return '<span class="badge bg-secondary">-</span>';
        }
    }

    function getTipePO(category) {
        if (category == 1) return 'Supplier';
        if (category == 2) return 'Transportir';
        return '-';
    }

    // DataTable setup and summary cards
    var table = $('#basic-1').DataTable({
        processing: true,
        serverSide: false, // Changed to false as data is processed client-side
        paging: true,
        searching: true,
        ordering: false,
        autoWidth: false,
        destroy: true,
        ajax: {
            url: '/api/purchase-order/list',
            data: function(d) {
                d.status = $('#filter-status').val();
                d.category = $('#filter-category').val();
            },
            dataSrc: function(json) {
                return (json.data || []).map(function(row, i) {
                    return {
                        no: row.no || '-',
                        category: getTipePO(row.category),
                        category_code: row.category,
                        dn_no: row.dn_no || '-',
                        drs_no: row.drs_no || '-',
                        vendor_name: row.vendor_name || '-',
                        total: formatRupiah(row.total || 0),
                        status: getStatusBadge(row.status),
                        status_code: row.status,
                        drs_unique: row.drs_unique || ''
                    };
                });
            }
        },
        language: {
            emptyTable: "Data belum tersedia",
            loadingRecords: "",
            processing: "Data Loading..."
        },
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Export',
            titleAttr: 'Export to Excel',
            className: 'btn btn-sm btn-success'
        }],
        columns: [
            { data: 'no', className: 'text-center' },
            { data: 'category', className: 'text-center' },
            { data: 'dn_no', className: 'text-center' },
            { data: 'drs_no', className: 'text-center' },
            { data: 'vendor_name', className: 'text-center' },
            { data: 'total', className: 'text-end' },
            {
                data: 'status',
                className: 'text-center',
                render: function(data, type, row) {
                    var btn = '';
                    if (row.status_code === 0) { // Draft
                        btn = `<a class="badge badge-info ms-2 btn-create-po" href="#" title="Create PO Transporter" data-drs_unique="${row.drs_unique}">
                                  <i class="fa fa-pencil-square-o text-white"></i>
                               </a>`;
                    } else if (row.status_code === 2) { // Revisi
                        btn = `<a class="badge bg-warning text-dark ms-2 btn-revisi-po"
                                  href="#"
                                  data-category="${row.category_code}"
                                  data-drs_unique="${row.drs_unique}"
                                  title="Revisi PO">
                                  <i class="fa fa-edit"></i>
                               </a>`;
                    }

                    return `<span class="status-click clickable"
                                    data-drs_unique="${row.drs_unique}"
                                    data-category="${row.category_code}">${data}</span>` + btn;
                }
            }
        ]
    });

    // Load summary cards
    function loadSummary() {
      $.getJSON('/api/purchase-order/list', {
        status: $('#filter-status').val(),
        category: $('#filter-category').val()
      }, function(res) {
        var summary = res.summary || {};
        var totalSup = summary.total_supplier || 0;
        var totalTrans = summary.total_transporter || 0;
        $('#card-total_po').text(totalSup + ' | ' + totalTrans);
        $('#card-draft').text(summary.waiting_approval || 0);
        $('#card-approved').text(summary.approved || 0);
        $('#card-approved_reject').text(summary.rejected || 0);
      });
    }
    loadSummary();

    // Filter change: reload DataTable and summary
    $('#filter-status, #filter-category').on('change', function(){
        table.ajax.reload();
        loadSummary();
    });

    // Load payment methods once for all modals
    $.get('/api/master-lov/children', { parent_code: 'PAYMENT_METHOD' })
        .done(function(res) {
            var paymentMethods = res.data || res;
            var options = '<option value=""></option>' + paymentMethods.map(function(item){
                return '<option value="'+item.value+'">'+item.value+'</option>';
            }).join('');

            // Populate all payment method dropdowns
            $('#sp_term, #cp_term, [name="term"]').html(options); // Also target revision modals

            // Initialize for CREATE modals
            $('#sp_term').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-create-po-supplier'),
                placeholder: 'Pilih Metode Pembayaran'
            });
            $('#cp_term').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-create-po'),
                placeholder: 'Pilih Metode Pembayaran'
            });
        });

    // Delegated event handlers for buttons inside DataTable
    $('#basic-1 tbody').on('click', '.btn-revisi-po', function(e) {
        e.preventDefault();
        const category = $(this).data('category');
        const drsUnique = $(this).data('drs_unique');

        let modalId = category == 1 ? '#modal-revisi-po-supplier' : '#modal-revisi-transportir';

        // Set drs_unique in the modal's form before showing
        $(modalId).find('[name="drs_unique"]').val(drsUnique);
        $(modalId).modal('show');
    });

    $('#basic-1 tbody').on('click', '.btn-create-po', function(e) {
        e.preventDefault();
        var drsUnique = $(this).data('drs_unique');
        if (!drsUnique) return;

        var $modal = $('#modal-create-po');
        $modal.modal('show');
        $('#modalCreatePOTransporterLoading').show();

        $.get('/api/purchase-order/list', { drs_unique: drsUnique }, function(res) {
            var d = (res.data && res.data[0]) || {};
            // Populate modal fields
            $modal.find('#cp_drs_unique').val(d.drs_unique || '');
            $modal.find('#cp_drs_no').val(d.drs_no || '');
            $modal.find('#cp_customer_po').val(d.customer_po || '');
            // ... populate other fields ...
        }).always(function() {
            $('#modalCreatePOTransporterLoading').hide();
        });
    });

    $('#basic-1 tbody').on('click', '.status-click', function() {
        var drs = $(this).data('drs_unique');
        var cat = $(this).data('category');
        var tipe = cat == 1 ? 'po_supplier' : 'po_transporter';

        $('#workflowModalLoading').show();
        $('#workflow-modal').modal('show');
        $('#workflow-table tbody').empty();

        $.get(`/api/remarks/${drs}?tipe_trx=${tipe}`, function(res) {
            var list = Array.isArray(res) ? res : (res.data || []);
            list.forEach(function(item, idx) {
                $('#workflow-table tbody').append(`
                    <tr>
                        <td class="text-center">${idx+1}</td>
                        <td>${item.user || item.created_by || ''}</td>
                        <td>${item.comment || item.remark || ''}</td>
                        <td>${formatDateTime(item.created_at)}</td>
                    </tr>
                `);
            });
        }).always(function() {
            $('#workflowModalLoading').hide();
        });
    });

    // --- Create PO Supplier Modal Logic ---
    $('#btnAddPO').on('click', function(e) {
        e.preventDefault();
        $('#form-create-po-supplier')[0].reset();
        $('#modal-create-po-supplier .select2').val('').trigger('change');
        $('#modal-create-po-supplier').modal('show');
    });

    $('#modal-create-po-supplier').on('show.bs.modal', function () {
        $('#modalCreatePOLoading').show();
        var $modal = $(this);
        $modal.find('form')[0].reset();
        $modal.find('.select2').val('').trigger('change');

        var reqVendor = $.get('/api/transporter?category=1');
        var reqDrs = $.get('/api/purchase-order/list-po-drs');

        reqVendor.done(function(res){
            var list = res.data || res;
            var $select = $('#sp_vendor_name').html('<option></option>');
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
            $select.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#modal-create-po-supplier'),
                placeholder: 'Pilih Vendor'
            });
        });

        reqDrs.done(function(res){
            var drsList = res.data || [];
            var opts = drsList.map(function(d){
                return `<option value="${d.drs_no}" data-drs-unique="${d.drs_unique}">${d.drs_no} [${d.drs_unique}]</option>`;
            });
            $('#sp_drs_no').html('<option value="">Pilih DRS No</option>' + opts.join('')).select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $('#modal-create-po-supplier'),
                placeholder: 'Pilih DRS No'
            });
        });

        $.when(reqVendor, reqDrs).always(function(){
            $('#modalCreatePOLoading').hide();
        });
    });

    $('#sp_vendor_name').on('change', function() {
        var $sel = $(this).find('option:selected');
        var format = $sel.data('format') || '';
        var dnNo = $('#sp_dn_no').val();
        var now = new Date();
        var romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now.getMonth()];
        var tahun = now.getFullYear();
        var vendorPO = format.replace(/{nomor}|{NOMOR}/g, dnNo)
                             .replace(/{bulan}|{BULAN}/g, romawi)
                             .replace(/{tahun}|{TAHUN}/g, tahun);
        $('#sp_vendor_po').val(vendorPO);
        $('#sp_nama').val($sel.data('nama') || '');
        $('#sp_contact').val($sel.data('contact') || '');
        $('#sp_alamat').val($sel.data('alamat') || '');
    });

    // [NEW] Add change event for vendor name in REVISION modal
    $(document).on('change', '#modal-revisi-po-supplier [name="vendor_name"]', function() {
        var $modal = $('#modal-revisi-po-supplier');
        var $sel = $(this).find('option:selected');
        var format = $sel.data('format') || '';
        var dnNo = $modal.find('[name="dn_no"]').val(); // Get DN from the modal context
        var now = new Date();
        var romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now.getMonth()];
        var tahun = now.getFullYear();

        var vendorPO = format.replace(/{nomor}|{NOMOR}/g, dnNo)
                             .replace(/{bulan}|{BULAN}/g, romawi)
                             .replace(/{tahun}|{TAHUN}/g, tahun);

        $modal.find('[name="vendor_po"]').val(vendorPO);
    });

    $('#sp_drs_no').on('change', function(){
        var drsUnique = $(this).find('option:selected').data('drs-unique') || '';
        $('#sp_drs_unique').val(drsUnique);
        if (!drsUnique) {
            $('#sp_customer_po, #sp_dn_no, #sp_qty').val('');
            return;
        }
        $.get('/api/purchase-order/list?drs_unique=' + encodeURIComponent(drsUnique), function(res){
            var d = (res.data && res.data[0]) || {};
            $('#sp_customer_po').val(d.customer_po||'');
            $('#sp_dn_no').val(d.dn_no||'');
            $('#sp_qty').val(d.qty||'');
            calcSupplierFields();
            $('#sp_vendor_name').trigger('change'); // Recalculate PO Number
        });
    });

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

    // --- Hitung & Update Otomatis Semua Kolom Supplier ---
    function calcSupplierFields() {
        var qty = parseFloat($('#sp_qty').val().replace(/\D/g,'')) || 0;
        var harga = parseFloat($('#sp_harga_raw').val()) || 0;
        var transport = parseFloat($('#sp_transport_raw').val()) || 0;

        var subtotal = (qty * harga) * transport;
        var valPPN = subtotal * 0.11;
        var valPBBKB = (qty * harga) * 0.075;
        var valPPh = (qty * harga) * 0.03;
        var valBPH = (qty * harga) * 0.025;
        var total = subtotal + valPPN + valPBBKB + valPPh + valBPH;

        $('#sp_sub_total').val('Rp. ' + subtotal.toLocaleString('id-ID'));
        $('#sp_sub_total_raw').val(subtotal);
        $('#sp_ppn').val('Rp. ' + Math.round(valPPN).toLocaleString('id-ID'));
        $('#sp_ppn_raw').val(Math.round(valPPN));
        $('#sp_pbbkb').val('Rp. ' + Math.round(valPBBKB).toLocaleString('id-ID'));
        $('#sp_pbbkb_raw').val(Math.round(valPBBKB));
        $('#sp_bph').val('Rp. ' + Math.round(valBPH).toLocaleString('id-ID'));
        $('#sp_bph_raw').val(Math.round(valBPH));
        $('#sp_pph').val('Rp. ' + Math.round(valPPh).toLocaleString('id-ID'));
        $('#sp_pph_raw').val(Math.round(valPPh));
        $('#sp_total').val('Rp. ' + Math.round(total).toLocaleString('id-ID'));
        $('#sp_total_raw').val(Math.round(total));

        var terbilangText = total ? terbilang(Math.round(total)) + ' rupiah' : 'nol rupiah';
        $('#sp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
    }

    $('#sp_transport, #sp_harga').on('input', function(){
        var numeric = $(this).val().replace(/\D/g,'');
        $('#' + $(this).attr('id') + '_raw').val(numeric || 0);
        $(this).val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');
        calcSupplierFields();
    });
    $('#sp_qty').on('change', calcSupplierFields);

    // --- Calculation for Transporter PO Modal ---
    function calculateTransporterTotals() {
        var qty       = parseFloat($('#cp_qty').val().replace(/\D/g, '')) || 0;
        var harga     = parseFloat($('#cp_harga_raw').val()) || 0;
        var transport = parseFloat($('#cp_transport_raw').val()) || 0;
        var portal    = parseFloat($('#cp_portal_raw').val()) || 0;

        var subTotal = (qty * harga) * transport;
        var total    = portal + subTotal;

        $('#cp_sub_total_raw').val(subTotal);
        $('#cp_total_raw').val(total);
        $('#cp_sub_total').val('Rp. ' + subTotal.toLocaleString('id-ID'));
        $('#cp_total').val('Rp. ' + total.toLocaleString('id-ID'));

        var terbilangText = total ? terbilang(total) + ' rupiah' : 'nol rupiah';
        $('#cp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
    }

    $('#cp_transport, #cp_portal, #cp_harga').on('input', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $('#' + $(this).attr('id') + '_raw').val(numeric || 0);
        $(this).val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');
        calculateTransporterTotals();
    });

    // --- Form Submissions ---
    function handleFormSubmit(formSelector, buttonSelector, url, method) {
        $(formSelector).off('submit').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            if (!form.checkValidity()) {
                e.stopPropagation();
                $(form).addClass('was-validated');
                return;
            }
            var $btn = $(buttonSelector);
            if ($btn.prop('disabled')) return;

            $btn.prop('disabled', true).find('.txt').addClass('d-none');
            $btn.find('.spinner-border').removeClass('d-none');

            var finalUrl = url;
            if (method.toUpperCase() === 'PUT') {
                var drs_unique = $(form).find('[name="drs_unique"]').val();
                finalUrl = url + '/' + drs_unique;
            }

            $.ajax({
                url: finalUrl,
                method: method,
                data: $(form).serialize(),
                success: function(res) {
                    Swal.fire('Berhasil', res.message || 'Operasi berhasil', 'success');
                    $(form).closest('.modal').modal('hide');
                    table.ajax.reload();
                    loadSummary();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
                    $btn.find('.txt').removeClass('d-none');
                }
            });
        });
    }

    handleFormSubmit('#form-create-po-supplier', '#btn-save-supplier', '/api/purchase-order/supplier', 'POST');
    handleFormSubmit('#form-create-po', '#btn-save-po', '/api/purchase-order', 'PUT');

});
</script>
@endsection
