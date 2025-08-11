@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
  .modal-dialog-scrollable .modal-body {
    overflow-y: auto !important;
    max-height: 75vh;
  }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6"><h3>Approval Center</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item active">Approval Center</li>
        </ol>
      </div>
    </div>
  </div>
</div>

{{-- summary cards --}}
<div class="container-fluid general-widget">
  <div class="row justify-content-center">
    <div class="col-sm-6 col-lg-3">
      <div class="card o-hidden">
        <div class="card-header pb-0">
          <div class="d-flex">
            <div class="flex-grow-1">
              <p class="square-after f-w-600 header-text-primary">
                SPH Approval <i class="fa fa-circle"></i>
              </p>
              <h4 id="card-total_sph">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="file-text" class="text-primary" style="width:40px;height:40px;"></i>
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
              <p class="square-after f-w-600 header-text-success">
                PO Supplier Approval <i class="fa fa-circle"></i>
              </p>
              <h4 id="card-waiting">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="shopping-bag" class="text-success" style="width:40px;height:40px;"></i>
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
              <p class="square-after f-w-600 header-text-info">
                PO Transporter Approval <i class="fa fa-circle"></i>
              </p>
              <h4 id="card-revisi">-</h4>
            </div>
            <div class="d-flex static-widget">
              <i data-feather="truck" class="text-info" style="width:40px;height:40px;"></i>
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
                <p class="square-after f-w-600 header-text-secondary">
                  Invoice Approval <i class="fa fa-circle"></i>
                </p>
                <h4 id="card-revisi">-</h4>
              </div>
              <div class="d-flex static-widget">
                <i data-feather="dollar-sign" class="text-secondary" style="width:40px;height:40px;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>
</div>

{{-- tabs + table --}}
<div class="col-sm-12">
  <div class="card">
    <div class="card-header pb-0">
      <div>
        <h4 class="mb-0">Data Approval</h4>
        <span>Semua data yang memerlukan Approval, Reject, dan Revisi</span>
      </div><br>
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#tab-sph" role="tab">SPH</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#tab-po-sup" role="tab">PO Supplier</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#tab-po-trans" role="tab">PO Transporter</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-invoice" role="tab">Invoice</a>
          </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        {{-- SPH tab --}}
        <div class="tab-pane fade show active" id="tab-sph" role="tabpanel">
          <div class="table-responsive theme-scrollbar">
            <table class="display" id="basic-1">
              <thead>
                <tr>
                  <th>Tipe SPH</th>
                  <th>No SPH</th>
                  <th>Nama Perusahaan</th>
                  <th>Produk Dibeli</th>
                  <th>Harga /Liter</th>
                  <th>PPN</th>
                  <th>PBBKB</th>
                  <th>Total Harga</th>
                  <th>Metode Pembayaran</th>
                  <th>Confirmation</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        {{-- PO Supplier --}}
        <div class="tab-pane fade" id="tab-po-sup" role="tabpanel">
          <div class="table-responsive theme-scrollbar">
            <table class="display" id="supplier-table">
              <thead>
                <tr>
                  <th>No Vendor PO</th>
                  <th>Nama Perusahaan</th>
                  <th>Nilai PO</th>
                  <th>Tanggal Dibuat</th>
                  <th>Metode Pembayaran</th>
                  <th>Confirmation</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        {{-- PO Transporter --}}
        <div class="tab-pane fade" id="tab-po-trans" role="tabpanel">
          <div class="table-responsive theme-scrollbar">
            <table class="display" id="transporter-table">
              <thead>
                <tr>
                  <th>No Vendor PO</th>
                  <th>Nama Perusahaan</th>
                  <th>Nilai PO</th>
                  <th>Tanggal Dibuat</th>
                  <th>Metode Pembayaran</th>
                  <th>Confirmation</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="tab-invoice" role="tabpanel">
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="invoice-table">
                <thead>
                  <tr>
                    <th>Nomer Invoice</th>
                    <th>Nomer PO</th>
                    <th>Nama Customer</th>
                    <th>Nilai PO</th>
                    <th>Nilai Invoice</th>
                    <th>Confirmation</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- SPH Modal Detail Confirmation -->
<div class="modal fade" id="modalConfirmation" tabindex="-1" aria-labelledby="modalConfirmationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold text-dark" id="modalConfirmationLabel">Detail SPH</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Table detail -->
        <table class="table table-bordered mb-4">
          <tbody>
            <tr><th width="35%">Tipe SPH</th><td id="detail-tipe-sph"></td></tr>
            <tr><th>No SPH</th><td id="detail-no-sph"></td></tr>
            <tr><th>Nama Perusahaan</th><td id="detail-comp-name"></td></tr>
            <tr><th>Produk Dibeli</th><td id="detail-product"></td></tr>
            <tr><th>Harga /Liter</th><td id="detail-price-liter"></td></tr>
            <tr><th>PPN</th><td id="detail-ppn"></td></tr>
            <tr><th>PBBKB</th><td id="detail-pbbkb"></td></tr>
            <tr><th>Total Harga</th><td id="detail-total-price"></td></tr>
            <tr><th>Metode Pembayaran</th><td id="detail-pay-method"></td></tr>
          </tbody>
        </table>

        <!-- Riwayat Remark Approval -->
        <div class="mb-4">
          <label class="fw-bold mb-2">Riwayat Remark:</label>
          <ul class="list-unstyled mb-0" id="remarkHistory"></ul>
        </div>

        <!-- Konfirmasi Approval -->
        <div class="mb-3">
          <label class="form-label fw-bold mb-2">Konfirmasi Approval:</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="approval_status" id="radioApprove" value="approve">
            <label class="form-check-label" for="radioApprove">Approve</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="approval_status" id="radioRevisi" value="revisi">
            <label class="form-check-label" for="radioRevisi">Revisi</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="approval_status" id="radioReject" value="reject">
            <label class="form-check-label" for="radioReject">Reject</label>
          </div>
        </div>
        <div class="mb-2">
          <label for="approvalComment" class="form-label fw-bold">Komentar / Remark</label>
          <textarea class="form-control" id="approvalComment" name="approvalComment" rows="3" placeholder="Tulis komentar atau alasan..."></textarea>
        </div>
      </div> <!-- end modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success rounded-3 px-4" id="btnSaveApproval">Simpan</button>
      </div>
    </div> <!-- end modal-content -->
  </div> <!-- end modal-dialog -->
</div> <!-- end modal -->
<!-- VERIFY PO MODAL -->
<div class="modal fade" id="modal-verify-po" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-verify-po">
        <div class="modal-header">
          <h5 class="modal-title">Verifikasi Purchase Order Transportir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
          <div class="row g-3">
            <!-- Semua field kecuali bph, ppn, pbbkb -->
            <div class="col-md-6"><label>DRS No</label><input type="text" id="v_drs_no" class="form-control" readonly></div>
            <div class="col-md-6"><label>Customer PO</label><input type="text" id="v_customer_po" class="form-control" readonly></div>
            <div class="col-md-6"><label>Vendor Name</label><input type="text" id="v_vendor_name" class="form-control" readonly></div>
            <div class="col-md-6"><label>Vendor PO</label><input type="text" id="v_vendor_po" class="form-control" readonly></div>
            <div class="col-md-6"><label>Tanggal PO</label><input type="text" id="v_tgl_po" class="form-control" readonly></div>
            <div class="col-md-6"><label>Nama PIC</label><input type="text" id="v_nama" class="form-control" readonly></div>
            <div class="col-md-12"><label>Alamat</label><textarea id="v_alamat" class="form-control" rows="2" readonly></textarea></div>
            <div class="col-md-6"><label>Contact</label><input type="text" id="v_contact" class="form-control" readonly></div>
            <div class="col-md-6"><label>Delivery To</label><input type="text" id="v_delivery_to" class="form-control" readonly></div>
            <div class="col-md-4"><label>FOB</label><input type="text" id="v_fob" class="form-control" readonly></div>
            <div class="col-md-4"><label>Term</label><input type="text" id="v_term" class="form-control" readonly></div>
            <div class="col-md-4"><label>Transport</label><input type="text" id="v_transport" class="form-control" readonly></div>
            <div class="col-md-4"><label>Portal</label><input type="text" id="v_portal" class="form-control" readonly></div>
            <div class="col-md-4"><label>Harga</label><input type="text" id="v_harga" class="form-control" readonly></div>
            <div class="col-md-4"><label>Qty</label><input type="text" id="v_qty" class="form-control" readonly></div>
            <div class="col-md-6"><label>Sub Total</label><input type="text" id="v_sub_total" class="form-control" readonly></div>
            <div class="col-md-6"><label>Total</label><input type="text" id="v_total" class="form-control" readonly></div>
            <div class="col-md-12"><label>Terbilang</label><input type="text" id="v_terbilang" class="form-control" readonly></div>

            <!-- Komentar & Status -->
            <div class="mb-4">
            <label class="fw-bold mb-2">Riwayat Remark:</label>
            <ul class="list-unstyled mb-0" id="remarkTransporter"></ul>
             </div>
            <div class="mb-3">
              <label class="form-label fw-bold mb-2">Konfirmasi Approval:</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="verify_status" id="radioApproveVerifyPo" value="approve">
                <label class="form-check-label" for="radioApproveVerifyPo">Approve</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="verify_status" id="radioRevisiVerifyPo" value="revisi">
                <label class="form-check-label" for="radioRevisiVerifyPo">Revisi</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="verify_status" id="radioRejectVerifyPo" value="reject">
                <label class="form-check-label" for="radioRejectVerifyPo">Reject</label>
              </div>
            </div>
            <div class="mb-2">
              <label for="verify_comment" class="form-label fw-bold">Komentar / Remark</label>
              <textarea class="form-control" id="verify_comment" name="verify_comment" rows="3" placeholder="Tulis komentar atau alasan..."></textarea>
            </div>
          </div> <!-- end .row g-3 -->
          <!-- Added closing for modal-body after row g-3 -->
        </div> <!-- end .modal-body -->
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary rounded-3 px-4" id="btn-verify-po" style="border-radius: 0.5rem !important;">
            <span class="txt">Simpan</span>
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span class="loading-text d-none">Saving...</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Form verifikasi PO Supplier --}}
<div class="modal fade" id="modal-create-po-supplier" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Verifikasi PO Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="form-create-po-supplier" novalidate>
        <div class="modal-body">
          <div class="row g-4">
            <input type="hidden" name="drs_unique" id="sp_drs_unique">
            <input type="hidden" name="category" id="sp_category" value="1">
            <div class="col-md-6">
              <label>Vendor Name</label>
              <select id="sp_vendor_name" class="form-control select2" required disabled>
              </select>
              <div class="invalid-feedback">Field Vendor Name wajib diisi.</div>
            </div>
            <div class="col-md-3">
              <label>DRS No</label>
              <input type="text" id="sp_drs_no" class="form-control" readonly required>
              <div class="invalid-feedback">Field DRS No wajib diisi.</div>
            </div>
            <div class="col-md-3">
              <label>Customer PO</label>
              <input type="text" id="sp_customer_po" class="form-control" readonly required>
              <div class="invalid-feedback">Field Customer PO wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Vendor PO</label>
              <input type="text" id="sp_vendor_po" class="form-control" required readonly>
              <div class="invalid-feedback">Field Vendor PO wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Tanggal PO</label>
              <input type="text" id="sp_tgl_po" name="sp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required readonly>
              <div class="invalid-feedback">Field Tanggal PO wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Dn No</label>
              <input type="text" id="sp_dn_no" class="form-control" readonly required>
              <div class="invalid-feedback">Field Dn No wajib diisi.</div>
            </div>
            <div class="col-md-6">
              <label>Nama PIC</label>
              <input type="text" id="sp_nama" class="form-control" required readonly>
              <div class="invalid-feedback">Field Nama PIC wajib diisi.</div>
            </div>
            <div class="col-md-6">
              <label>Contact</label>
              <input type="text" id="sp_contact" class="form-control" required readonly>
              <div class="invalid-feedback">Field Contact wajib diisi.</div>
            </div>
            <div class="col-md-12">
              <label>Alamat</label>
              <input type="text" id="sp_alamat" class="form-control" required readonly>
              <div class="invalid-feedback">Field Alamat wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Metode Pembayaran</label>
              <select id="sp_term" class="form-control select2" required disabled></select>
              <div class="invalid-feedback">Field Metode Pembayaran wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>FOB</label>
              <input type="text" id="sp_fob" class="form-control" required readonly>
              <div class="invalid-feedback">Field FOB wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Shipped Via</label>
              <input type="text" id="sp_shipped_via" class="form-control" required readonly>
              <div class="invalid-feedback">Field Shipped Via wajib diisi.</div>
            </div>
            <div class="col-md-6">
              <label>Loading Point</label>
              <input type="text" id="sp_loading_point" class="form-control" required readonly>
              <div class="invalid-feedback">Field Loading Point wajib diisi.</div>
            </div>
            <div class="col-md-6">
              <label>Delivery To</label>
              <input type="text" id="sp_delivery_to" class="form-control" required readonly>
              <div class="invalid-feedback">Field Delivery To wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Transport</label>
              <input type="text" id="sp_transport" class="form-control" required readonly>
              <div class="invalid-feedback">Field Transport wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Harga</label>
              <input type="text" id="sp_harga" class="form-control" required readonly>
              <div class="invalid-feedback">Field Harga wajib diisi.</div>
            </div>
            <div class="col-md-4">
              <label>Qty</label>
              <input type="number" id="sp_qty" class="form-control" readonly required>
              <div class="invalid-feedback">Field Qty wajib diisi.</div>
            </div>
            <div class="col-md-4"><label>Sub Total</label><input type="text" id="sp_sub_total" class="form-control" readonly></div>
            <div class="col-md-4"><label>PPN</label><input type="text" id="sp_ppn" class="form-control" readonly></div>
            <div class="col-md-4"><label>PPH</label><input type="text" id="sp_pph" class="form-control" readonly></div>
            <div class="col-md-4"><label>PBBKB</label><input type="text" id="sp_pbbkb" class="form-control" readonly></div>
            <div class="col-md-4"><label>BPH</label><input type="text" id="sp_bph" class="form-control" readonly></div>
            <div class="col-md-4"><label>Total</label><input type="text" id="sp_total" class="form-control" readonly></div>
            <div class="col-md-12"><label>Terbilang</label><input type="text" id="sp_terbilang" class="form-control" readonly></div>
            <div class="col-md-12"><label>Keterangan</label><textarea id="sp_description" class="form-control" readonly></textarea></div>
            <div class="col-md-12"><label>Additional Notes</label><textarea id="sp_additional_notes" class="form-control" readonly></textarea></div>
          </div>
          <div class="mb-4">
            <label class="fw-bold mb-2">Riwayat Remark:</label>
            <ul class="list-unstyled mb-0" id="remarkSupplier"></ul>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold mb-2">Konfirmasi Approval:</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="verify_status" id="radioApproveVerifyPo" value="approve">
              <label class="form-check-label" for="radioApproveVerifyPo">Approve</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="verify_status" id="radioRevisiVerifyPo" value="revisi">
              <label class="form-check-label" for="radioRevisiVerifyPo">Revisi</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="verify_status" id="radioRejectVerifyPo" value="reject">
              <label class="form-check-label" for="radioRejectVerifyPo">Reject</label>
            </div>
          </div>
          <div class="mb-2">
            <label for="verify_comment_supplier" class="form-label fw-bold">Komentar / Remark</label>
            <textarea class="form-control" id="verify_comment_supplier" name="verify_comment" rows="3" placeholder="Tulis komentar atau alasan..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn-save-supplier" class="btn btn-primary rounded-square" style="border-radius:8px;">
            <span class="txt">Simpan</span>
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <!-- ensure jQuery is loaded first, then Select2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    /**
     * Load and render remark history into the given container.
     * @param {string|number} id - The record ID
     * @param {string} tipe - The tipe_trx value for the API
     * @param {string} container - jQuery selector for the remarks container
     */
    function loadRemarks(id, tipe, container) {
      // show loading spinner
      $(container).html('<li class="text-center py-2"><div class="spinner-border text-primary"></div> Memuat riwayat…</li>');
      $.get(`/api/remarks/${id}?tipe_trx=${tipe}`)
        .done(function(remarks){
          if (!remarks.length) {
            $(container).html('<li class="text-muted">Belum ada remark</li>');
            return;
          }
          var html = remarks.map(function(r){
            var color = 'primary';
            var user = r.user || r.last_updateby || 'User';
            var comment = r.comment || r.wf_comment || '';
            if (comment.toLowerCase().includes('approve')) color = 'success';
            if (comment.toLowerCase().includes('reject'))  color = 'danger';
            var created = r.created_at
              ? new Date(r.created_at).toLocaleDateString('id-ID', { year:'numeric', month:'long', day:'numeric' })
              : '';
            return `<li class="mb-2 pb-2 border-bottom">
              <span class="fw-bold text-${color}">• ${user}</span> -
              <span>${comment}</span>
              <span class="text-muted ms-2 small">(${created})</span>
            </li>`;
          }).join('');
          $(container).html(html);
        })
        .fail(function(){
          $(container).html('<li class="text-danger">Gagal memuat riwayat.</li>');
        });
    }

    // Global: open Verify PO modal
    function showWorkflowModal(id) {
      var row = $('#transporter-table').DataTable().data().toArray().find(r => r.id === id);
      if (!row) {
        return alert('Data PO tidak ditemukan!');
      }
      // Populate fields
      $('#v_drs_no').val(row.drs_no);
      $('#v_customer_po').val(row.customer_po);
      $('#v_vendor_name').val(row.vendor_name);
      $('#v_vendor_po').val(row.vendor_po);
      $('#v_tgl_po').val(row.tgl_po);
      $('#v_nama').val(row.nama);
      $('#v_alamat').val(row.alamat);
      $('#v_contact').val(row.contact);
      $('#v_delivery_to').val(row.delivery_to);
      $('#v_fob').val(row.fob);
      $('#v_term').val(row.term);
      $('#v_transport').val(row.transport);
      $('#v_portal').val(row.portal);
      $('#v_harga').val(row.harga);
      $('#v_qty').val(row.qty);
      $('#v_sub_total').val(row.sub_total);
      $('#v_total').val(row.total);
      $('#v_terbilang').val(row.terbilang);
      // Store current PO id for submission
      $('#form-verify-po').data('po-id', row.id);
      // Load remarks for PO transporter before showing modal
      // Kosongkan & tampilkan spinner pada remarkHistory
      $('#remarkTransporter').html('<li class="text-center py-2"><div class="spinner-border text-primary"></div> Memuat riwayat…</li>');
      loadRemarks(row.drs_unique, 'po_transporter', '#remarkTransporter');
      $('#modal-verify-po').modal('show');
    }

    $(function(){
      // 1) DataTable setup
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
              { title: 'No SPH' },
              { title: 'Nama Perusahaan' },
              { title: 'Produk Dibeli' },
              { title: 'Harga /Liter' },
              { title: 'PPN' },
              { title: 'PBBKB' },
              { title: 'Total Harga' },
              { title: 'Metode Pembayaran' },
              { title: 'Confirmation' }
            ]
          });

      // 2) Fetch & render SPH data
      function fetchSph(){
        table.clear().draw();
        $('#basic-1 tbody').html(
          '<tr><td colspan="11" class="text-center py-4">'+
            '<div class="spinner-border text-primary" role="status"></div>'+
            ' <span>Loading...</span>'+
          '</td></tr>'
        );
        $.get('/api/sph/list?status=approvallist')
          .done(function(res){
            $('#card-total_sph').text(res.cards.waiting); // SPH Approval (status=1)
            $('#card-waiting')     .text('-');
            $('#card-revisi')      .text('-');

            var rows = res.data.map(function(item){
              var confirmationHtml = `<span class="badge bg-primary confirmation-btn" data-id="${item.id}" style="cursor:pointer;">Click to Verify</span>`;
              return [
                item.tipe_sph||'',
                item.kode_sph,
                item.comp_name,
                item.product,
                formatRupiah(item.price_liter),
                formatRupiah(item.ppn),
                formatRupiah(item.pbbkb),
                formatRupiah(item.total_price),
                item.pay_method,
                confirmationHtml
              ];
            });

            table.clear().rows.add(rows).draw();
            $('[title]').tooltip({ trigger: 'hover' });
          })
          .fail(function(){
            table.clear().draw();
          });
      }

      function formatRupiah(x){
        x = parseFloat(x)||0;
        return 'Rp ' + x.toLocaleString('id-ID',{ minimumFractionDigits:2 });
      }

      // Initial load
      fetchSph();

      // Load PO Supplier & Transporter summary counts
      $.get('/api/purchase-order/list', { page: 'summary-only' })
        .done(function(res) {
          // supplier_waiting and transporter_waiting from summary
          $('#card-waiting').text(res.summary.supplier_waiting);
          $('#card-revisi').text(res.summary.transporter_waiting);
        });

      // Handler untuk klik Confirmation badge (SPH)
      $(document).on('click', '#basic-1 .confirmation-btn', function(){
        var $tr = $(this).closest('tr');
        var sphId = $(this).data('id');

        // Isi detail table
        $('#detail-tipe-sph').text($tr.find('td').eq(0).text());
        $('#detail-no-sph').text($tr.find('td').eq(1).text());
        $('#detail-comp-name').text($tr.find('td').eq(2).text());
        $('#detail-product').text($tr.find('td').eq(3).text());
        $('#detail-price-liter').text($tr.find('td').eq(4).text());
        $('#detail-ppn').text($tr.find('td').eq(5).text());
        $('#detail-pbbkb').text($tr.find('td').eq(6).text());
        $('#detail-total-price').text($tr.find('td').eq(7).text());
        $('#detail-pay-method').text($tr.find('td').eq(8).text());

        // Kosongkan & tampilkan spinner pada remarkHistory
        $('#remarkHistory').html('<li class="text-center py-2"><div class="spinner-border text-primary"></div> Memuat riwayat…</li>');

        // Set sphId pada modal
        $('#modalConfirmation').data('sph-id', sphId);

        // Reset radio & textarea
        $('input[name="approval_status"]').prop('checked', false);
        $('#approvalComment').val('');

        // Load remark riwayat via API (reusable helper)
        loadRemarks(sphId, 'sph', '#remarkHistory');

        $('#modalConfirmation').modal('show');
      });

      // Handler tombol Simpan di modal
      $(document).on('click', '#btnSaveApproval', function() {
        var sphId = $('#modalConfirmation').data('sph-id');
        var status = $('input[name="approval_status"]:checked').val();
        var comment = $('#approvalComment').val().trim();

        if (!status) {
          Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Pilih status Approve, Revisi, atau Reject.' });
          return;
        }
        if (!comment) {
          Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Komentar wajib diisi.' }).then(() => {
            $('#approvalComment').focus();
          });
          return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

        $.ajax({
          url: '/api/sph/' + sphId + '/approval',
          type: 'POST',
          data: {
            approval_status: status,
            approvalComment: comment
          },
          success: function(res) {
            Swal.fire('Berhasil', res.message, 'success');
            $('#modalConfirmation').modal('hide');
            $btn.prop('disabled', false).html('Simpan');
            fetchSph();
          },
          error: function(xhr) {
            Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal simpan!', 'error');
            $btn.prop('disabled', false).html('Simpan');
          }
        });
      });

      // Transporter PO Approval table
      // Destroy if exists
      if ($.fn.DataTable.isDataTable('#transporter-table')) {
          $('#transporter-table').DataTable().clear().destroy();
      }
      var transporterTable = $('#transporter-table').DataTable({
          processing: true,
          ajax: {
              url: '/api/purchase-order/list',
              data: function(d) {
                  d.category = 2;
                  d.status = 1;
              },
              dataSrc: function(res) {
                  return res.data;
              }
          },
          columns: [
              { data: 'vendor_po', title: 'No Vendor PO' },
              { data: 'vendor_name', title: 'Nama Perusahaan' },
              {
                data: 'total',
                title: 'Nilai PO',
                className: 'text-center',
                render: function(data) {
                  // Default to 0 if null or undefined
                  var val = data != null ? parseFloat(data) : 0;
                  // Format as Indonesian Rupiah without decimals
                  return 'Rp ' + val.toLocaleString('id-ID');
                }
              },
              {
                data: 'created_at',
                title: 'Tanggal Dibuat',
                render: function(data) {
                    return data ? data.split(' ')[0] : '';
                }
              },
              { data: 'term', title: 'Metode Pembayaran', defaultContent: '-' },
              {
                data: 'id',
                title: 'Confirmation',
                orderable: false,
                render: function(id) {
                  return '<span class="badge bg-primary verify-po-btn" data-id="' + id + '" style="cursor:pointer;">Click to Verify</span>';
                }
              }
          ],
          drawCallback: function() {
              if (window.feather) feather.replace();
          }
      });

      // Supplier PO Approval table
      if ($.fn.DataTable.isDataTable('#supplier-table')) {
        $('#supplier-table').DataTable().clear().destroy();
      }
      var supplierTable = $('#supplier-table').DataTable({
          processing: true,
          ajax: {
              url: '/api/purchase-order/list',
              data: function(d) {
                  d.category = 1;
                  d.status = 1;
              },
              dataSrc: function(res) {
                  return res.data;
              }
          },
          columns: [
              { data: 'vendor_po', title: 'No Vendor PO' },
              { data: 'vendor_name', title: 'Nama Perusahaan' },
              {
                  data: 'total',
                  title: 'Nilai PO',
                  className: 'text-center',
                  render: function(data) {
                      var val = data != null ? parseFloat(data) : 0;
                      return 'Rp ' + val.toLocaleString('id-ID');
                  }
              },
              {
                  data: 'created_at',
                  title: 'Tanggal Dibuat',
                  render: function(data) {
                      return data ? data.split(' ')[0] : '';
                  }
              },
              { data: 'term', title: 'Metode Pembayaran', defaultContent: '-' },
              {
                  data: 'id',
                  title: 'Confirmation',
                  orderable: false,
                  render: function(id) {
                      return '<span class="badge bg-primary verify-supplier-btn" data-id="' + id + '" style="cursor:pointer;">Click To Verify</span>';
                  }
              }
          ],
          drawCallback: function() {
              if (window.feather) feather.replace();
          }
      });

      // Reload when transporter tab is shown
      $('a[data-bs-toggle="tab"][href="#tab-po-trans"]').on('shown.bs.tab', function() {
          transporterTable.ajax.reload();
      });
      // Reload when supplier tab is shown
      $('a[data-bs-toggle="tab"][href="#tab-po-sup"]').on('shown.bs.tab', function() {
          supplierTable.ajax.reload();
      });

      // Inisialisasi Select2 di modal verify dan handle form events
      $(document).ready(function() {
        // Inisialisasi Select2 di modal verify
        $('#modal-verify-po .select2').select2({
          theme: 'bootstrap-5',
          width: '100%',
          dropdownParent: $('#modal-verify-po .modal-content')
        });



        // Handle form verification dengan loading state
        $('#form-verify-po').on('submit', function(e) {
          e.preventDefault();
          var $btn = $('#btn-verify-po');
          $btn.prop('disabled', true).find('.txt').addClass('d-none');
          $btn.find('.spinner-border').removeClass('d-none');
          $btn.find('.loading-text').removeClass('d-none');
          var poId = $(this).data('po-id');
          $.ajax({
            url: '/api/purchase-order/verify/' + poId,
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
              $('#modal-verify-po').modal('hide');
              transporterTable.ajax.reload();
              Swal.fire('Berhasil', 'Verifikasi berhasil', 'success');
              window.location.reload(); // Reload page to refresh data
            },
            error: function(xhr) {
              Swal.fire('Gagal', xhr.responseJSON?.message || 'Verifikasi gagal', 'error');
            },
            complete: function() {
              $btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
              $btn.find('.loading-text').addClass('d-none');
              $btn.find('.txt').removeClass('d-none');
            }
          });
        });
      });
      // Handler for PO Transporter Verify button
      $(document).on('click', '.verify-po-btn', function(){
        var poId = $(this).data('id');
        showWorkflowModal(poId);
      });

      // Handler for PO Supplier Verify button
      $(document).on('click', '.verify-supplier-btn', function() {
        var poId = $(this).data('id');
        // Cari row di datatable supplier-table
        var dataArr = $('#supplier-table').DataTable().data().toArray();
        var row = dataArr.find(function(r) { return r.id == poId; });
        if (!row) {
          alert('Data PO tidak ditemukan!');
          return;
        }
        // Set value ke modal-create-po-supplier
        $('#sp_drs_unique').val(row.drs_unique);
        $('#sp_category').val(row.category);
        $('#sp_vendor_name').html(`<option value="${row.vendor_name}">${row.vendor_name}</option>`).val(row.vendor_name).trigger('change');
        $('#sp_drs_no').val(row.drs_no);
        $('#sp_customer_po').val(row.customer_po);
        $('#sp_vendor_po').val(row.vendor_po);
        $('#sp_tgl_po').val(row.tgl_po);
        $('#sp_dn_no').val(row.dn_no);
        $('#sp_nama').val(row.nama);
        $('#sp_contact').val(row.contact);
        $('#sp_alamat').val(row.alamat);
        $('#sp_term').html(`<option value="${row.term}">${row.term}</option>`).val(row.term).trigger('change');
        $('#sp_fob').val(row.fob);
        $('#sp_shipped_via').val(row.shipped_via);
        $('#sp_loading_point').val(row.loading_point);
        $('#sp_delivery_to').val(row.delivery_to);
        $('#sp_transport').val('Rp ' + (parseFloat(row.transport) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_harga').val('Rp ' + (parseFloat(row.harga) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_qty').val(row.qty);
        $('#sp_sub_total').val('Rp ' + (parseFloat(row.sub_total) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_ppn').val('Rp ' + (parseFloat(row.ppn) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_pph').val('Rp ' + (parseFloat(row.pph) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_pbbkb').val('Rp ' + (parseFloat(row.pbbkb) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_bph').val('Rp ' + (parseFloat(row.bph) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_total').val('Rp ' + (parseFloat(row.total) || 0).toLocaleString('id-ID', {minimumFractionDigits:2}));
        $('#sp_terbilang').val(row.terbilang);
        $('#sp_description').val(row.description);
        $('#sp_additional_notes').val(row.additional_notes);

        // Remark (remarkSupplier di modal-create-po-supplier, tipe_trx 'po_supplier')
        loadRemarks(row.drs_unique, 'po_supplier', '#remarkSupplier');

        // Store current PO id on the form
        $('#form-create-po-supplier').data('po-id', poId);

        // Tampilkan modal
        $('#modal-create-po-supplier').modal('show');
      });



      // Handle PO Supplier Verification form submission
      $('#form-create-po-supplier').off('submit').on('submit', function(e) {
        e.preventDefault();
        var $btn = $('#btn-save-supplier');
        // prevent double submit
        if ($btn.prop('disabled')) return;
        // get selected status and comment
        var status = $('input[name="verify_status"]:checked').val();
        var comment = $('#verify_comment_supplier').val().trim();
        if (!status) {
          Swal.fire('Peringatan', 'Pilih status Approve, Revisi, atau Reject.', 'warning');
          return;
        }
        if (!comment) {
          Swal.fire('Peringatan', 'Komentar wajib diisi.', 'warning');
          $('#verify_comment_supplier').focus();
          return;
        }
        // show loading on button
        $btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');
        $btn.find('.txt').addClass('d-none');

        // determine PO ID and category
        var poId = $('#form-create-po-supplier').data('po-id');
        var category = $('#sp_category').val();

        // send AJAX request
        $.ajax({
          url: '/api/purchase-order/verify/' + poId,
          method: 'POST',
          data: {
            verify_status: status,
            verify_comment: comment,
            category: category
          },
          success: function(res) {
            Swal.fire('Berhasil', res.message, 'success');
            $('#modal-create-po-supplier').modal('hide');
            // Reload supplier DataTable
            if (typeof supplierTable !== 'undefined') {
              supplierTable.ajax.reload();
            }
          },
          error: function(xhr) {
            Swal.fire('Gagal', xhr.responseJSON?.message || 'Verifikasi gagal', 'error');
          },
          complete: function() {
            $btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            $btn.find('.txt').removeClass('d-none');
          }
        });
      });
    }); // end of $(function())

  </script>
@endsection


