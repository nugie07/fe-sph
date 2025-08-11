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
                    <input type="hidden" name="category" id="cp_category" value="2">
                    <input type="hidden" name="po_id" id="cp_po_id">
                    <!-- Baris 1 -->
                    <div class="col-md-4"><label>DRS No</label><input type="text" name="drs_no" id="cp_drs_no" class="form-control" readonly required></div>
                    <div class="col-md-4"><label>Customer PO</label><input type="text" name="customer_po" id="cp_customer_po" class="form-control" readonly required></div>
                    <div class="col-md-4"><label>Vendor PO</label><input type="text" name="vendor_po" id="cp_vendor_po" class="form-control" readonly required></div>
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
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            required
                            readonly
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
                    <div class="col-md-4">
                        <label>Uang Portal</label>
                        <input type="hidden" name="portal" id="cp_portal_raw" required>
                        <input type="text" id="cp_portal" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <!-- Hidden field for transport (will be set equal to harga) -->
                    <input type="hidden" name="transport" id="cp_transport_raw" required>
                    <div class="col-md-4">
                        <label>Harga</label>
                        <input type="hidden" name="harga" id="cp_harga_raw" required>
                        <input type="text" id="cp_harga" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-4">
                        <label>Qty</label>
                        <input type="text" name="qty" id="cp_qty" class="form-control" readonly required>
                    </div>
                    <!-- Baris 7 -->
                    <div class="col-md-4">
                        <label>
                            Sub Total&nbsp;
                            <i class="fa fa-info-circle text-secondary"
                                data-bs-toggle="tooltip"
                                title="Rumus SubTotal = Qty * Harga (Transport = Harga)"
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

<!-- PDF Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- PDF will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal" style="border-radius: 0.5rem !important;">Tutup</button>
            </div>
        </div>
    </div>
</div>

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
    var id = $modal.find('[name="po_id"]').val();
    var drsUnique = $modal.find('[name="drs_unique"]').val();
    var modalLoadingId = '#modalRevisiSupplierLoading'; // Specific loading overlay

    $modal.addClass('loading');
    $(modalLoadingId).show();

                // Always use drs_unique for consistency with other parts of the application
    var requestParams = { drs_unique: drsUnique, category: 1 };

    console.log('Modal revisi supplier - Request params:', requestParams);
    console.log('Modal revisi supplier - drsUnique:', drsUnique);

    // Fetch PO data and vendor list in parallel
    var poDataRequest = $.get('/api/purchase-order/list', requestParams);
    var vendorListRequest = $.get('/api/transporter?category=1'); // Fetch all vendors

    $.when(poDataRequest, vendorListRequest).done(function(poDataResponse, vendorListResponse) {
        var d = (poDataResponse[0].data && poDataResponse[0].data[0]) || {};

        // Populate regular fields
        $modal.find('[name="vendor_po"]').val(d.vendor_po || '');
        // ... populate other fields from 'd' object
        $modal.find('[name="po_id"]').val(d.id || '');
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
            // Add all necessary data attributes to the option
            var option = new Option(vendor.nama || vendor.name, vendor.nama || vendor.name);
            $(option).attr('data-format', vendor.format || '');
            $(option).attr('data-nama', vendor.nama || vendor.name || '');
            $(option).attr('data-contact', vendor.contact_no || vendor.contact || '');
            $(option).attr('data-alamat', vendor.address || vendor.alamat || '');
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

        // Set calculated fields from server data as initial values for reference
        setSupplierField('sp_sub_total', 'sp_sub_total_raw', d.sub_total);
        setSupplierField('sp_ppn', 'sp_ppn_raw', d.ppn);
        setSupplierField('sp_pbbkb', 'sp_pbbkb_raw', d.pbbkb);
        setSupplierField('sp_pph', 'sp_pph_raw', d.pph);
        setSupplierField('sp_bph', 'sp_bph_raw', d.bph);
        setSupplierField('sp_total', 'sp_total_raw', d.total);

        // Trigger calculation after data is loaded to ensure consistency
        setTimeout(function() {
            // Call the modal-specific calculation function if it exists
            if (typeof calcSupplierFieldsModal === 'function') {
                calcSupplierFieldsModal();
            } else {
                calcSupplierFields();
            }
        }, 100);

    }).fail(function() {
        Swal.fire('Error', 'Gagal memuat data revisi supplier.', 'error');
    }).always(function() {
        $(modalLoadingId).hide();
        $modal.removeClass('loading');
    });
});

// --- [FIXED] Load data into revision transportir modal on show ---
$('#modal-revisi-transportir').on('show.bs.modal', function() {
    var $modal = $(this);
    var id = $modal.find('[name="po_id"]').val();
    var drsUnique = $modal.find('[name="drs_unique"]').val();
    var modalLoadingId = '#modalRevisiTransportirLoading'; // Specific loading overlay

    $modal.addClass('loading');
    $(modalLoadingId).show();

                // Always use drs_unique for consistency with other parts of the application
    var requestParams = { drs_unique: drsUnique, category: 2 };

    console.log('Modal revisi transportir - Request params:', requestParams);
    console.log('Modal revisi transportir - drsUnique:', drsUnique);

    // Fetch PO data only (payment methods already populated globally)
    var poDataRequest = $.get('/api/purchase-order/list', requestParams);

    poDataRequest.done(function(poDataResponse) {
        var d = (poDataResponse.data && poDataResponse.data[0]) || {};

        console.log('Modal revisi transportir - Response data:', d);
        console.log('Modal revisi transportir - Portal value:', d.portal);

        // Populate regular fields
        $modal.find('[name="vendor_po"]').val(d.vendor_po || '');
        $modal.find('[name="po_id"]').val(d.id || '');
        $modal.find('[name="drs_no"]').val(d.drs_no || '');
        $modal.find('[name="customer_po"]').val(d.customer_po || '');
        $modal.find('[name="tgl_po"]').val(d.tgl_po || '');
        $modal.find('[name="vendor_name"]').val(d.vendor_name || '');
        $modal.find('[name="pic_site"]').val(d.pic_site || d.nama || '');
        $modal.find('[name="pic_site_telp"]').val(d.pic_site_telp || d.contact || '');
        $modal.find('[name="site_location"]').val(d.site_location || d.alamat || '');
        $modal.find('[name="delivery_to"]').val(d.delivery_to || '');
        $modal.find('[name="fob"]').val(d.fob || '');
        $modal.find('[name="loading_point"]').val(d.loading_point || '');
        $modal.find('[name="shipped_via"]').val(d.shipped_via || '');
        $modal.find('[name="qty"]').val(d.qty || '');
        $modal.find('[name="terbilang"]').val(d.terbilang || '');
        $modal.find('[name="description"]').val(d.description || '');
        $modal.find('[name="additional_notes"]').val(d.additional_notes || '');

        // --- Initialize Payment Method Select2 (already populated globally) ---
        var $termSelect = $modal.find('[name="term"]');
        $termSelect.val(d.term);
        $termSelect.select2({
            theme: 'bootstrap-5',
            dropdownParent: $modal,
            placeholder: 'Pilih Metode Pembayaran'
        });

        // Numeric fields with formatting
        function setTransportirField(displayId, rawId, value) {
            $modal.find('#' + rawId).val(value || 0);
            $modal.find('#' + displayId).val(value ? 'Rp. ' + parseFloat(value).toLocaleString('id-ID') : '');
        }

        setTransportirField('cp_transport', 'cp_transport_raw', d.transport);
        setTransportirField('cp_portal', 'cp_portal_raw', d.portal);
        setTransportirField('cp_harga', 'cp_harga_raw', d.harga);

        console.log('Modal revisi transportir - After setting fields:');
        console.log('cp_portal display:', $modal.find('#cp_portal').val());
        console.log('cp_portal_raw:', $modal.find('#cp_portal_raw').val());

        // Set calculated fields from server data as initial values for reference
        setTransportirField('cp_sub_total', 'cp_sub_total_raw', d.sub_total);
        setTransportirField('cp_total', 'cp_total_raw', d.total);

        // Trigger calculation after data is loaded to ensure consistency
        setTimeout(function() {
            // Call the modal-specific calculation function if it exists
            if (typeof calcTransportirFieldsModal === 'function') {
                calcTransportirFieldsModal();
            }
        }, 100);

    }).fail(function() {
        Swal.fire('Error', 'Gagal memuat data revisi transportir.', 'error');
    }).always(function() {
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
        console.log('calcSupplierFields called'); // Debug log

    // Check if elements exist
    console.log('Element check:', {
        sp_qty: $('#sp_qty').length,
        sp_harga_raw: $('#sp_harga_raw').length,
        sp_transport_raw: $('#sp_transport_raw').length,
        sp_sub_total: $('#sp_sub_total').length,
        sp_ppn: $('#sp_ppn').length,
        sp_pbbkb: $('#sp_pbbkb').length,
        sp_bph: $('#sp_bph').length,
        sp_pph: $('#sp_pph').length,
        sp_total: $('#sp_total').length,
        sp_terbilang: $('#sp_terbilang').length
    });

    var qty = parseFloat($('#sp_qty').val().replace(/\D/g,'')) || 0;
    var harga = parseFloat($('#sp_harga_raw').val()) || 0;
    var transport = parseFloat($('#sp_transport_raw').val()) || 0;

    console.log('Values:', {qty: qty, harga: harga, transport: transport}); // Debug log

    var subtotal = (qty * harga)
    var valPPN = subtotal * 0.11;
    var valPBBKB = (qty * harga) * 0.075;
    var valPPh = (qty * harga) * 0.03;
    var valBPH = (qty * harga) * 0.025;
    var Pajak = valPPN + valPBBKB + valPPh + valBPH;
    var total = subtotal + Pajak + transport;

    console.log('Calculated:', {subtotal: subtotal, total: total}); // Debug log

        var subTotalText = 'Rp. ' + subtotal.toLocaleString('id-ID');
    var ppnText = 'Rp. ' + Math.round(valPPN).toLocaleString('id-ID');
    var pbbkbText = 'Rp. ' + Math.round(valPBBKB).toLocaleString('id-ID');
    var bphText = 'Rp. ' + Math.round(valBPH).toLocaleString('id-ID');
    var pphText = 'Rp. ' + Math.round(valPPh).toLocaleString('id-ID');
    var totalText = 'Rp. ' + Math.round(total).toLocaleString('id-ID');

        console.log('Setting sp_sub_total to:', subTotalText);
    $('#sp_sub_total').val(subTotalText).prop('value', subTotalText).attr('value', subTotalText);
    $('#sp_sub_total_raw').val(subtotal);

    console.log('Setting sp_ppn to:', ppnText);
    $('#sp_ppn').val(ppnText).prop('value', ppnText).attr('value', ppnText);
    $('#sp_ppn_raw').val(Math.round(valPPN));

    console.log('Setting sp_pbbkb to:', pbbkbText);
    $('#sp_pbbkb').val(pbbkbText).prop('value', pbbkbText).attr('value', pbbkbText);
    $('#sp_pbbkb_raw').val(Math.round(valPBBKB));

    console.log('Setting sp_bph to:', bphText);
    $('#sp_bph').val(bphText).prop('value', bphText).attr('value', bphText);
    $('#sp_bph_raw').val(Math.round(valBPH));

    console.log('Setting sp_pph to:', pphText);
    $('#sp_pph').val(pphText).prop('value', pphText).attr('value', pphText);
    $('#sp_pph_raw').val(Math.round(valPPh));

    console.log('Setting sp_total to:', totalText);
    $('#sp_total').val(totalText).prop('value', totalText).attr('value', totalText);
    $('#sp_total_raw').val(Math.round(total));

    var terbilangText = total ? terbilang(Math.round(total)) + ' rupiah' : 'nol rupiah';
        console.log('Setting sp_terbilang to:', terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
    $('#sp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));

        // Force UI update by triggering change events
    $('#sp_sub_total, #sp_ppn, #sp_pbbkb, #sp_bph, #sp_pph, #sp_total, #sp_terbilang').trigger('change');

    // Force a second update after a small delay to ensure UI updates
    setTimeout(function() {
        $('#sp_sub_total').val(subTotalText).prop('value', subTotalText);
        $('#sp_ppn').val(ppnText).prop('value', ppnText);
        $('#sp_pbbkb').val(pbbkbText).prop('value', pbbkbText);
        $('#sp_bph').val(bphText).prop('value', bphText);
        $('#sp_pph').val(pphText).prop('value', pphText);
        $('#sp_total').val(totalText).prop('value', totalText);
        $('#sp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));

        // Force another update after another delay
        setTimeout(function() {
            $('#sp_sub_total').val(subTotalText);
            $('#sp_ppn').val(ppnText);
            $('#sp_pbbkb').val(pbbkbText);
            $('#sp_bph').val(bphText);
            $('#sp_pph').val(pphText);
            $('#sp_total').val(totalText);
            $('#sp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
        }, 100);
    }, 50);

    console.log('Fields updated and change events triggered'); // Debug log
}

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
                        drs_unique: row.drs_unique || '',
                        id: row.id || '',
                        file: row.file || ''
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
                    var pdfBtn = '';

                    if (row.status_code === 0) { // Draft
                        btn = `<a class="badge badge-info ms-2 btn-create-po" href="#" title="Create PO Transporter" data-id="${row.id}">
                                  <i class="fa fa-pencil-square-o text-white"></i>
                               </a>`;
                    } else if (row.status_code === 2) { // Revisi
                        btn = `<a class="badge bg-warning text-dark ms-2 btn-revisi-po"
                                  href="#"
                                  data-category="${row.category_code}"
                                  data-drs_unique="${row.drs_unique}"
                                  data-id="${row.id}"
                                  title="Revisi PO">
                                  <i class="fa fa-edit"></i>
                               </a>`;
                    } else if (row.status_code === 4) { // Approved - add PDF button
                        pdfBtn = `<a class="badge bg-danger ms-2 pdf-icon" href="#" title="Lihat PDF" style="cursor: pointer;">
                                  <i class="fa fa-file-pdf-o text-white"></i>
                               </a>`;
                    }

                    return `<span class="status-click clickable"
                                    data-drs_unique="${row.drs_unique}"
                                    data-category="${row.category_code}">${data}</span>` + btn + pdfBtn;
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
            console.log('Payment methods loaded:', paymentMethods);

            var options = '<option value=""></option>' + paymentMethods.map(function(item){
                return '<option value="'+item.value+'">'+item.value+'</option>';
            }).join('');

            // Populate all payment method dropdowns
            $('#sp_term, #cp_term, [name="term"]').html(options); // Also target revision modals

            // Initialize for CREATE modals
            $('#sp_term').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-create-po-supplier .modal-content'),
                placeholder: 'Pilih Metode Pembayaran'
            });
            $('#cp_term').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-create-po .modal-content'),
                placeholder: 'Pilih Metode Pembayaran'
            });

            // Initialize for REVISION modals (will be re-initialized when modal opens)
            $('#modal-revisi-po-supplier [name="term"]').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-revisi-po-supplier'),
                placeholder: 'Pilih Metode Pembayaran'
            });
            $('#modal-revisi-transportir [name="term"]').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-revisi-transportir'),
                placeholder: 'Pilih Metode Pembayaran'
            });
        });

    // Delegated event handlers for buttons inside DataTable
    $('#basic-1 tbody').on('click', '.btn-revisi-po', function(e) {
        e.preventDefault();
        const category = $(this).data('category');
        const drsUnique = $(this).data('drs_unique');
        const poId = $(this).data('id'); // Get PO ID from button data

        let modalId = category == 1 ? '#modal-revisi-po-supplier' : '#modal-revisi-transportir';

        // Set drs_unique and po_id in the modal's form before showing
        $(modalId).find('[name="drs_unique"]').val(drsUnique);
        $(modalId).find('[name="po_id"]').val(poId);
        $(modalId).modal('show');
    });

    $('#basic-1 tbody').on('click', '.btn-create-po', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (!id) return;

        var $modal = $('#modal-create-po');
        // Reset form and Select2 before showing modal
        $modal.find('form')[0].reset();
        $modal.find('#cp_term').val('').trigger('change');
        $modal.modal('show');
        $('#modalCreatePOTransporterLoading').show();

        $.get('/api/purchase-order/list', { id: id }, function(res) {
            var d = (res.data && res.data[0]) || {};
            console.log('Create PO Transportir - Response data:', d);

            // Populate modal fields
            $modal.find('#cp_po_id').val(id); // Set po_id for PUT request
            $modal.find('#cp_drs_unique').val(d.drs_unique || '');
            $modal.find('#cp_drs_no').val(d.drs_no || '');
            $modal.find('#cp_customer_po').val(d.customer_po || '');
            $modal.find('#cp_vendor_po').val(d.vendor_po || '');
            $modal.find('#cp_vendor_name').val(d.vendor_name || '');
            $modal.find('#cp_tgl_po').val(d.tgl_po || '');
            $modal.find('#cp_nama').val(d.nama || '');
            $modal.find('#cp_contact').val(d.contact || '');
            $modal.find('#cp_alamat').val(d.alamat || '');
            $modal.find('#cp_delivery_to').val(d.delivery_to || '');
            $modal.find('#cp_fob').val(d.fob || '');
            $modal.find('#cp_loading_point').val(d.loading_point || '');
            $modal.find('#cp_shipped_via').val(d.shipped_via || '');
            $modal.find('#cp_special_notes').val(d.special_notes || '');
            $modal.find('#cp_qty').val(d.qty || '');
            $modal.find('#cp_description').val(d.description || '');
            $modal.find('#cp_additional_notes').val(d.additional_notes || '');

            // Format numeric fields
            if (d.portal) {
                $modal.find('#cp_portal_raw').val(d.portal);
                $modal.find('#cp_portal').val('Rp. ' + parseFloat(d.portal).toLocaleString('id-ID'));
            }
            if (d.harga) {
                $modal.find('#cp_harga_raw').val(d.harga);
                $modal.find('#cp_harga').val('Rp. ' + parseFloat(d.harga).toLocaleString('id-ID'));
            }

            // Set transport equal to harga (hidden field for submission)
            if (d.harga) {
                $modal.find('#cp_transport_raw').val(d.harga);
            }

            // Calculate totals
            calculateTransporterTotals();

                        // Set payment method
            if (d.term) {
                // Get all payment method options from the global dropdown
                var allOptions = $('#sp_term option').clone();
                console.log('All payment options:', allOptions);

                // Set all options and then set the selected value
                $modal.find('#cp_term').html(allOptions).val(d.term).trigger('change');

                // Refresh Select2 to show the selected value
                $modal.find('#cp_term').select2('destroy').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $modal.find('.modal-content'),
                    placeholder: 'Pilih Metode Pembayaran'
                });
            }

        }).fail(function(xhr) {
            console.log('Error loading data:', xhr);
            Swal.fire('Error', 'Gagal memuat data', 'error');
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
        var $modal = $('#modal-create-po-supplier');
        var $form = $('#form-create-po-supplier');

        // Reset form completely
        $form[0].reset();

        // Remove all validation classes and states
        $form.removeClass('was-validated');
        $modal.find('.is-invalid').removeClass('is-invalid');
        $modal.find('.is-valid').removeClass('is-valid');
        $modal.find('.invalid-feedback').hide();
        $modal.find('.valid-feedback').hide();

        // Reset Select2
        $modal.find('.select2').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });
        $modal.find('.select2').val('').trigger('change');

        // Clear any error messages
        $modal.find('.alert-danger').remove();
        $modal.find('.alert-success').remove();

        // Remove any existing datepicker click handlers
        $(document).off('click.datepicker-close');

        $modal.modal('show');
    });

        $('#modal-create-po-supplier').on('show.bs.modal', function () {
        $('#modalCreatePOLoading').show();
        var $modal = $(this);
        var $form = $modal.find('form');

        // Reset form completely
        $form[0].reset();

        // Remove all validation classes and states
        $form.removeClass('was-validated');
        $modal.find('.is-invalid').removeClass('is-invalid');
        $modal.find('.is-valid').removeClass('is-valid');
        $modal.find('.invalid-feedback').hide();
        $modal.find('.valid-feedback').hide();

        // Reset Select2
        $modal.find('.select2').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });
        $modal.find('.select2').val('').trigger('change');

        // Clear any error messages
        $modal.find('.alert-danger').remove();
        $modal.find('.alert-success').remove();

        // Remove any existing datepicker click handlers
        $(document).off('click.datepicker-close');

        // Remove datepicker event handlers
        $('#sp_tgl_po').off('keydown blur');

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
                dropdownParent: $('#modal-create-po-supplier .modal-content'),
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
                dropdownParent: $('#modal-create-po-supplier .modal-content'),
                placeholder: 'Pilih DRS No'
            });
        });

                $.when(reqVendor, reqDrs).always(function(){
            $('#modalCreatePOLoading').hide();

            // Re-initialize Select2 for payment method after data is loaded
            $('#sp_term').select2('destroy').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-create-po-supplier .modal-content'),
                placeholder: 'Pilih Metode Pembayaran'
            });
        });

                        // Fix datepicker auto-close issue
        setTimeout(function() {
            // Destroy existing datepicker if any
            if ($('#sp_tgl_po').data('datepicker')) {
                $('#sp_tgl_po').datepicker('destroy');
            }

            $('#sp_tgl_po').datepicker({
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                autoClose: false, // Disable auto close
                onSelect: function(formattedDate, date, inst) {
                    // Just update the value, don't close
                    $(this).val(formattedDate);
                }
            });

            // Remove any existing click handlers to prevent conflicts
            $(document).off('click.datepicker-close');

            // Add new click handler for closing datepicker only when clicking outside
            $(document).on('click.datepicker-close', function(e) {
                var $datepicker = $('.datepicker');
                var $input = $('#sp_tgl_po');

                // Only close if clicking outside both the datepicker and the input
                if ($datepicker.length &&
                    !$(e.target).closest('.datepicker').length &&
                    !$(e.target).closest('#sp_tgl_po').length) {
                    $input.datepicker('hide');
                }
            });

            // Add keyboard event handlers for closing datepicker
            $('#sp_tgl_po').on('keydown', function(e) {
                if (e.keyCode === 13 || e.keyCode === 9) { // Enter or Tab
                    $(this).datepicker('hide');
                }
            });

            // Add blur event to close datepicker when input loses focus
            $('#sp_tgl_po').on('blur', function() {
                setTimeout(function() {
                    if (!$('.datepicker:hover').length) {
                        $('#sp_tgl_po').datepicker('hide');
                    }
                }, 200);
            });
        }, 500);
    });

    // Reset form and validation when modal is hidden
    $('#modal-create-po-supplier').on('hidden.bs.modal', function() {
        var $modal = $(this);
        var $form = $modal.find('form');

        // Reset form completely
        $form[0].reset();

        // Remove all validation classes and states
        $form.removeClass('was-validated');
        $modal.find('.is-invalid').removeClass('is-invalid');
        $modal.find('.is-valid').removeClass('is-valid');
        $modal.find('.invalid-feedback').hide();
        $modal.find('.valid-feedback').hide();

        // Reset Select2
        $modal.find('.select2').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });
        $modal.find('.select2').val('').trigger('change');

        // Clear any error messages
        $modal.find('.alert-danger').remove();
        $modal.find('.alert-success').remove();

        // Remove datepicker click handler when modal is hidden
        $(document).off('click.datepicker-close');

        // Remove datepicker event handlers
        $('#sp_tgl_po').off('keydown blur');
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



    // Event listener untuk modal create PO supplier (bukan modal revisi)
    $('#modal-create-po-supplier #sp_transport, #modal-create-po-supplier #sp_harga').on('input', function(){
        console.log('Input changed (create modal):', $(this).attr('id'), $(this).val()); // Debug log
        var numeric = $(this).val().replace(/[^\d]/g,'');
        $('#' + $(this).attr('id') + '_raw').val(numeric || 0);
        $(this).val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');
        console.log('Calling calcSupplierFields from create modal input event'); // Debug log
        calcSupplierFields();
    });
    $('#sp_qty').on('change', calcSupplierFields);

    // --- Calculation for Transporter PO Modal ---
    function calculateTransporterTotals() {
        var qty       = parseFloat($('#cp_qty').val().replace(/\D/g, '')) || 0;
        var harga     = parseFloat($('#cp_harga_raw').val()) || 0;
        var portal    = parseFloat($('#cp_portal_raw').val()) || 0;

        var subTotal = qty * harga;
        var total    = portal + subTotal;

        // Set transport equal to harga (hidden field for submission)
        $('#cp_transport_raw').val(harga);

        $('#cp_sub_total_raw').val(subTotal);
        $('#cp_total_raw').val(total);
        $('#cp_sub_total').val('Rp. ' + subTotal.toLocaleString('id-ID'));
        $('#cp_total').val('Rp. ' + total.toLocaleString('id-ID'));

        var terbilangText = total ? terbilang(total) + ' rupiah' : 'nol rupiah';
        $('#cp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));
    }

    $('#cp_portal, #cp_harga').on('input', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $('#' + $(this).attr('id') + '_raw').val(numeric || 0);
        $(this).val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');
        calculateTransporterTotals();
    });

    // Trigger calculation when modal-create-po is shown
    $('#modal-create-po').on('shown.bs.modal', function() {
        // Trigger calculation to set transport equal to harga if harga is already filled
        if ($('#cp_harga_raw').val()) {
            calculateTransporterTotals();
        }

        // Ensure Select2 is properly initialized
        if (!$('#cp_term').hasClass('select2-hidden-accessible')) {
            $('#cp_term').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modal-create-po .modal-content'),
                placeholder: 'Pilih Metode Pembayaran'
            });
        }

        // Initialize datepicker for Tanggal PO in transporter modal
        setTimeout(function() {
            // Remove readonly attribute to allow datepicker to work
            $('#cp_tgl_po').removeAttr('readonly');

            // Destroy existing datepicker if any
            if ($('#cp_tgl_po').data('datepicker')) {
                $('#cp_tgl_po').datepicker('destroy');
            }

            // Initialize datepicker with simple configuration
            $('#cp_tgl_po').datepicker({
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                autoClose: true,
                onSelect: function(formattedDate, date, inst) {
                    $(this).val(formattedDate);
                    $(this).blur();
                }
            });

            // Add click handler to prevent datepicker from closing immediately
            $('#cp_tgl_po').on('click', function(e) {
                e.stopPropagation();
                $(this).datepicker('show');
            });

            // Prevent modal from closing when clicking on datepicker
            $(document).on('click', '.datepicker', function(e) {
                e.stopPropagation();
            });

        }, 300);
    });

    // Clean up datepicker when transporter modal is hidden
    $('#modal-create-po').on('hidden.bs.modal', function() {
        // Remove click handlers
        $('#cp_tgl_po').off('click');
        $(document).off('click', '.datepicker');

        // Destroy datepicker
        if ($('#cp_tgl_po').data('datepicker')) {
            $('#cp_tgl_po').datepicker('destroy');
        }

        // Reset readonly attribute
        $('#cp_tgl_po').attr('readonly', 'readonly');
    });

    // Prevent modal from closing when clicking on datepicker elements
    $(document).on('click', '.datepicker, .datepicker--cell, .datepicker--nav', function(e) {
        e.stopPropagation();
        e.preventDefault();
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

            // Disable button and show loading state
            $btn.prop('disabled', true);
            $btn.find('.txt').addClass('d-none');
            $btn.find('.loading-text').removeClass('d-none');
            $btn.find('.spinner-border').removeClass('d-none');

            var finalUrl = url;
            if (method.toUpperCase() === 'PUT') {
                // Use po_id instead of drs_unique for revision
                var poId = $(form).find('[name="po_id"]').val();
                if (poId) {
                    finalUrl = url + '/' + poId;
                    console.log('PUT request - PO ID:', poId, 'URL:', finalUrl);
                } else {
                    console.log('PUT request - No PO ID found, using base URL:', finalUrl);
                }
            }

                                    console.log('Submitting form to:', finalUrl, 'with method:', method);
            console.log('Form data:', $(form).serialize());

            $.ajax({
                url: finalUrl,
                method: method,
                data: $(form).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(res) {
                    console.log('Success response:', res);
                    Swal.fire('Berhasil', res.message || 'Operasi berhasil', 'success');
                    $(form).closest('.modal').modal('hide');
                    table.ajax.reload();
                    loadSummary();
                },
                error: function(xhr) {
                    console.log('Error response:', xhr);
                    console.log('Status:', xhr.status);
                    console.log('Response text:', xhr.responseText);
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
                },
                complete: function() {
                    // Reset button state
                    $btn.prop('disabled', false);
                    $btn.find('.spinner-border').addClass('d-none');
                    $btn.find('.loading-text').addClass('d-none');
                    $btn.find('.txt').removeClass('d-none');
                }
            });
        });
    }

    handleFormSubmit('#form-create-po-supplier', '#btn-save-supplier', '/api/purchase-order/supplier', 'POST');
    handleFormSubmit('#form-create-po', '#btn-save-po', '/api/purchase-order', 'PUT');
    handleFormSubmit('#form-revisi-po-supplier', '#btn-save-revisi-supplier', '/api/purchase-order', 'PUT');
    handleFormSubmit('#form-revisi-transportir', '#btn-save-revisi-transportir', '/api/purchase-order', 'PUT');

        // Handle PDF icon click
    $(document).on('click', '.pdf-icon', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Get the row data
        var row = table.row($(this).closest('tr')).data();
        if (row && row.file) {
            // Determine title based on category
            var title = '';
            if (row.category_code == 1) {
                title = 'Supplier PO - ' + row.vendor_name;
            } else if (row.category_code == 2) {
                title = 'Transportir PO - ' + row.vendor_name;
            } else {
                title = 'Document PDF - ' + row.vendor_name;
            }

            // Show PDF in modal
            $('#pdfModal .modal-title').text(title);
            $('#pdfModal .modal-body').html('<iframe src="' + row.file + '" width="100%" height="500px" frameborder="0"></iframe>');
            $('#pdfModal').modal('show');
        } else {
            Swal.fire('Info', 'File PDF tidak tersedia', 'info');
        }
    });

});
</script>
@endsection
