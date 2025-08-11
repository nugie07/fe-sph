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
          <h3>Delivery Note</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item active">Delivery Note</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  {{-- Datatable disini --}}
  <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
              <h4 class="mb-0">Data Delivery Note</h4>
              <span>Semua data Delivery Note ada Disini</span>
            </div>
            <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">
                <input class="datepicker-here form-control digits" type="text" data-language="en"
                data-min-view="months" data-position="bottom left" data-view="months" data-date-format="yyyy-mm" id="filter-month" style="width:160px;max-width:160px;">
                <button type="button" class="btn btn-light border rounded-square" id="btn-reset-filter" style="border-radius:8px;aspect-ratio:1/1;width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                  <i class="fa fa-refresh"></i>
                </button>
                <button type="button" class="btn btn-success" id="btn-create-delivery-note" style="color:#fff; border-radius:8px; aspect-ratio:1/1; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                  <i class="fa fa-plus"></i>
                </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:20%;">DN No</th>
                    <th style="width:20%;">Customer Name</th>
                    <th style="width:10%;">Arrival Date</th>
                    <th style="width:5%;">Qty</th>
                    <th style="width:20%;">Transportir</th>
                    <th style="width:5%;">So</th>
                    <th style="width:5%;">Terra</th>
                    <th style="width:10%;">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

<div class="modal fade" id="modal-delivery-note" tabindex="-1" aria-labelledby="modalDeliveryNoteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-delivery-note" autocomplete="off">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeliveryNoteLabel">Delivery Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="dn-id">
        <input type="hidden" name="drs_unique" id="drs_unique">
        <input type="hidden" name="created_by" id="created_by">

        <input type="hidden" name="status" id="status" value=0>
        <div class="row g-2">
          <div class="col-md-3 mb-2">
            <label for="dn_no" class="form-label">DN No</label>
            <select class="form-select" id="dn_no" name="dn_no" style="width:100%;" required></select>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="drs_no" class="form-label">DRS No</label>
            <input type="text" class="form-control readonly-by-default" id="drs_no" name="drs_no" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control readonly-by-default" id="customer_name" name="customer_name" readonly>
          </div>
          <div class="col-md-4 mb-2">
            <label for="customer_po" class="form-label">Customer PO</label>
            <input type="text" class="form-control readonly-by-default" id="customer_po" name="customer_po" readonly>
          </div>

          <div class="col-md-4 mb-2">
            <label for="po_date" class="form-label">PO Date</label>
            <input type="text" class="form-control readonly-by-default" id="po_date" name="po_date" readonly>
          </div>
          <div class="col-md-4 mb-2">
            <label for="arrival_date" class="form-label">Arrival Date</label>
            <input type="text" class="form-control datepicker-here" id="arrival_date" name="arrival_date" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-6 mb-2">
            <label for="consignee" class="form-label">Consignee</label>
            <input type="text" class="form-control" id="consignee" name="consignee" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-6 mb-2">
            <label for="delivery_to" class="form-label">Delivery To</label>
            <input type="text" class="form-control readonly-by-default" id="delivery_to" name="delivery_to" readonly>
          </div>
          <div class="col-md-12 mb-2">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="2"></textarea>
          </div>
          <div class="col-md-3 mb-2">
            <label for="qty" class="form-label">Qty</label>
            <input type="text" class="form-control readonly-by-default" id="qty" name="qty" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="berat_jenis" class="form-label">Berat Jenis</label>
            <input type="text" class="form-control" id="berat_jenis" name="berat_jenis">
          </div>
          <div class="col-md-3 mb-2">
            <label for="temperature" class="form-label">Temperature</label>
            <input type="text" class="form-control" id="temperature" name="temperature">
          </div>
          <div class="col-md-3 mb-2">
            <label for="so" class="form-label">SO</label>
            <input type="number" class="form-control" id="so" name="so" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="terra" class="form-label">Terra</label>
            <input type="text" class="form-control" id="terra" name="terra" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="segel_atas" class="form-label">Segel Atas</label>
            <input type="text" class="form-control" id="segel_atas" name="segel_atas" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="segel_bawah" class="form-label">Segel Bawah</label>
            <input type="text" class="form-control" id="segel_bawah" name="segel_bawah" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="nopol" class="form-label">NoPol</label>
            <input type="text" class="form-control" id="nopol" name="nopol" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-3 mb-2">
            <label for="driver_name" class="form-label">Driver Name</label>
            <input type="text" class="form-control" id="driver_name" name="driver_name" required>
            <div class="invalid-feedback">Harus diisi</div>
          </div>
          <div class="col-md-6 mb-2">
            <label for="transportir" class="form-label">Transportir</label>
            <input type="text" class="form-control readonly-by-default" id="transportir" name="transportir" readonly>
          </div>

          <div class="col-md-12 mb-2">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger me-2 d-flex align-items-center px-4 py-2" data-bs-dismiss="modal" style="border-radius:8px;min-width:110px;">
            <i class="fa fa-times"></i>
            <span class="ms-2">Tutup</span>
        </button>
        <button type="submit" class="btn btn-success d-flex align-items-center px-4 py-2" id="btn-save-delivery-note" style="border-radius:8px;min-width:120px;">
            <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
            <i class="fa fa-save"></i>
            <span class="ms-2">Simpan</span>
        </button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal untuk upload BAST --}}
<div class="modal fade" id="modal-upload-bast" tabindex="-1" aria-labelledby="modalUploadBastLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-upload-bast" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUploadBastLabel">Upload BAST</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bast_drs_unique" id="bast_drs_unique">
                    {{-- PERBAIKAN: Input FOB dan Sent Via dijadikan hidden --}}
                    <input type="hidden" name="fob" id="fob">
                    <input type="hidden" name="sent_via" id="sent_via">
                    <div class="row">

                      <div class="col-md-4 mb-2">
                        <label for="tgl_bongkar" class="form-label">Tanggal Bongkar</label>
                        <input type="date" class="form-control" id="tgl_bongkar" name="tgl_bongkar">
                      </div>
                      <div class="col-md-4 mb-2">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai">
                      </div>
                      <div class="col-md-4 mb-2">
                        <label for="jam_akhir" class="form-label">Jam Akhir</label>
                        <input type="time" class="form-control" id="jam_akhir" name="jam_akhir">
                      </div>
                      <div class="col-md-3 mb-2">
                        <label for="meter_awal" class="form-label">Meter Awal</label>
                        <input type="text" class="form-control" id="meter_awal" name="meter_awal">
                      </div>
                      <div class="col-md-3 mb-2">
                        <label for="meter_akhir" class="form-label">Meter Akhir</label>
                        <input type="text" class="form-control" id="meter_akhir" name="meter_akhir">
                      </div>
                      <div class="col-md-3 mb-2">
                        <label for="tinggi_sounding" class="form-label">Tinggi Sounding</label>
                        <input type="text" class="form-control" id="tinggi_sounding" name="tinggi_sounding">
                      </div>
                      <div class="col-md-3 mb-2">
                        <label for="jenis_suhu" class="form-label">Jenis Suhu</label>
                        <input type="text" class="form-control" id="jenis_suhu" name="jenis_suhu">
                      </div>
                      <div class="col-md-3 mb-2">
                        <label for="volume_diterima" class="form-label">Volume Diterima</label>
                        <input type="text" class="form-control" id="volume_diterima" name="volume_diterima">
                      </div>
                      <div class="col-md-3 mb-2">
                        <label for="bast_date" class="form-label">BAST Date</label>
                        <input type="text" class="form-control datepicker-here" id="bast_date" name="bast_date" data-language="en" data-date-format="yyyy-mm-dd" autocomplete="off" required>
                        <div class="invalid-feedback">BAST Date harus diisi</div>
                      </div>
                      <div class="col-md-6 mb-2">
                        <label for="bast_file" class="form-label">Pilih File BAST</label>
                        <input class="form-control" type="file" id="bast_file" name="bast_file" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="form-text">Tipe file yang diizinkan: PDF, JPG, PNG. Ukuran maksimal: 1MB.</div>
                        <div class="invalid-feedback" id="bast-file-error"></div>
                    </div>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-0" id="btn-save-bast">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal untuk preview PDF --}}
<div class="modal fade" id="modal-pdf-preview" tabindex="-1" aria-labelledby="modalPdfPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPdfPreviewLabel">Preview PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 80vh;">
                <iframe id="pdf-iframe" src="" frameborder="0" width="100%" height="100%" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div id="overlay-loading-dn" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:2000;background:rgba(255,255,255,0.8);align-items:center;justify-content:center;">
  <div style="text-align:center;">
    <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;"></div>
    <div style="font-size:1.15rem;">Loading mengambil data, tunggu sebentar ..</div>
  </div>
</div>
@endsection

@section('scripts')
{{-- PERBAIKAN: Tambahkan jQuery sebelum script lainnya --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Tambahkan SweetAlert2 --}}

<script>
let deliveryNoteTable;
let deliveryNoteModal;
let bastUploadModal;
let pdfPreviewModal;
let deliveryNoteMode = 'create'; // 'create' | 'edit' | 'view'
let currentUser = ''; // Set this to current user if available from backend

window.uploadBast = function(drs_unique) {
    // 1. Cari data baris yang sesuai dari cache DataTable
    let rowData = deliveryNoteTable.rows().data().toArray().find(r => r.drs_unique === drs_unique);

    if (!rowData) {
        showToast('Data untuk baris ini tidak ditemukan.', 'error');
        return;
    }

    let vendorPo = rowData.vendor_po || drs_unique;

    // 2. Isi semua input di modal BAST
    $('#bast_drs_unique').val(drs_unique);

    // PERBAIKAN: Isi nilai fob dan sent_via saat modal dibuka
    $('#fob').val(rowData.fob || '');
    // Asumsi nama field di response adalah 'shipped_via'
    $('#sent_via').val(rowData.shipped_via || '');

    // 3. Atur judul modal
    $('#modalUploadBastLabel').text(`Upload BAST untuk Vendor PO: ${vendorPo}`);

    // 4. Tampilkan modal
    bastUploadModal.show();
};

window.viewBast = function(drs_unique) {
    let rowData = deliveryNoteTable.rows().data().toArray().find(r => r.drs_unique === drs_unique);
    if (rowData && rowData.file) {
        window.open(rowData.file, '_blank');
    } else {
        showToast(`File BAST untuk DRS: ${drs_unique} tidak ditemukan.`, 'error');
    }
};

// Function to open PDF preview modal
function openPdfModal(pdfUrl, title) {
    // Construct full URL with public path
    const baseUrl = 'https://is3.cloudhost.id/bensinkustorage/';
    const fullPdfUrl = baseUrl + pdfUrl;

    $('#modalPdfPreviewLabel').text(title);
    $('#pdf-iframe').attr('src', fullPdfUrl);
    pdfPreviewModal.show();
}


function showToast(msg, type='success') {
  if (window.Swal) {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    Toast.fire({
      icon: type,
      title: msg
    });
  } else {
    alert(msg);
  }
}

function setDeliveryNoteFormReadonly(isReadonly) {
    $('#form-delivery-note input, #form-delivery-note textarea').not('.not-readonly').prop('readonly', isReadonly);
    $('#form-delivery-note select').not('.not-readonly').prop('disabled', isReadonly);
}


function reloadDeliveryNoteTable() {
  if (deliveryNoteTable) deliveryNoteTable.ajax.reload(null, false);
}

$(document).ready(function() {
  // Overlay loading function
  function showDnOverlayLoading(show=true) {
    $('#overlay-loading-dn').css('display', show ? 'flex' : 'none');
  }
  // Setup DataTable
  deliveryNoteTable = $('#basic-1').DataTable({
    ajax: {
      url: '/api/delivery-note',
      data: function(d) {
        let month = $('#filter-month').val();
        if (month) d.created_at = month+'-01';
      },
      dataSrc: 'data'
    },
    columns: [
      { data: null, className: 'text-center', render: (d,t,r,i) => i.row+1 },
      {
        data: 'dn_no',
        className: 'text-center',
        render: function(data, type, row) {
            if (!data) return '';

            let badgeHtml = '';
            if (row.status == 0) {
              badgeHtml = `<span class="badge bg-info text-white mt-1" style="cursor:pointer;display:inline-block;" onclick="window.uploadBast('${row.drs_unique}')">Upload BAST</span>`;
            } else {
              badgeHtml = `<span class="badge bg-success mt-1" style="cursor:default;display:inline-block;opacity:0.7;">BAST Terlampir</span>`;
            }

            return `
            <div class="d-flex flex-column align-items-center justify-content-center">
                <span>${data}</span>
                ${badgeHtml}
            </div>
            `;
        }
      },
      { data: 'customer_name', className: 'text-center' },
      { data: 'arrival_date', className: 'text-center' },
      { data: 'qty', className: 'text-center' },
      { data: 'transportir', className: 'text-center' },
      { data: 'so', className: 'text-center' },
      { data: 'terra', className: 'text-center' },
      { data: null, orderable: false, className: 'text-center', render: function(data, type, row){
        let editButton = '';
        if (row.status == 0) {
          editButton = `<span class="badge rounded p-2 bg-warning btn-edit" style="cursor:pointer;" data-id="${row.id}" title="Edit"><i class="fa fa-pencil"></i></span>`;
        }

        let pdfButton = '';
        if (row.file) {
          pdfButton = `<span class="badge rounded p-2 bg-info btn-pdf" style="cursor:pointer;" data-id="${row.id}" title="Download PDF"><i class="fa fa-file-pdf-o"></i></span>`;
        }

        return `
          <div class="d-flex justify-content-center gap-2">
            <span class="badge rounded p-2 bg-primary btn-view" style="cursor:pointer;" data-id="${row.id}" title="View"><i class="fa fa-eye"></i></span>
            ${editButton}
            ${pdfButton}
            <span class="badge rounded p-2 bg-danger btn-delete" style="cursor:pointer;" data-id="${row.id}" title="Delete"><i class="fa fa-trash"></i></span>
          </div>
        `;
      }}
    ],
    destroy: true
  });

  // Filter by month
  $('#filter-month').datepicker({
    language: 'en',
    minView: 'months',
    view: 'months',
    dateFormat: 'yyyy-mm'
  }).on('change', function(){
    reloadDeliveryNoteTable();
  });
  $('#btn-reset-filter').on('click', function(){
    $('#filter-month').val('');
    reloadDeliveryNoteTable();
  });

  // Modal instances
  deliveryNoteModal = new bootstrap.Modal(document.getElementById('modal-delivery-note'), {});
  bastUploadModal = new bootstrap.Modal(document.getElementById('modal-upload-bast'), {});
  pdfPreviewModal = new bootstrap.Modal(document.getElementById('modal-pdf-preview'), {});

  // Select2 for DN No
  $('#dn_no').select2({
    theme: 'bootstrap-5',
    dropdownParent: $('#modal-delivery-note'),
    ajax: {
      url: '/api/dn-source',
      dataType: 'json',
      processResults: function(data) {
        let results = {
          results: data.map(function(dn){
            return {id: dn.dn_no, text: dn.dn_no, data: dn};
          })
        };
        showDnOverlayLoading(false);
        return results;
      }
    },
    placeholder: 'Pilih DN No',
    allowClear: true
  }).on('select2:select', function(e){
    let dn = e.params.data.data;
    // Autofill fields
    $('#drs_no').val(dn.drs_no || '');
    $('#drs_unique').val(dn.drs_unique || '');
    $('#customer_po').val(dn.customer_po || '');
    $('#customer_name').val(dn.customer_name || '');
    $('#po_date').val(dn.po_date || '');


    if (dn.arrival_date) {
        $('#arrival_date').val(dn.arrival_date);
        var datepicker = $('#arrival_date').datepicker().data('datepicker');
        if(datepicker) {
            datepicker.selectDate(new Date(dn.arrival_date + 'T00:00:00'));
        }
    } else {
        $('#arrival_date').val('');
        var datepicker = $('#arrival_date').datepicker().data('datepicker');
        if(datepicker) {
            datepicker.clear();
        }
    }

    $('#delivery_to').val(dn.delivery_to || '');
    $('#address').val(dn.delivery_to || '');
    $('#qty').val(dn.qty || '');
    $('#description').val(dn.description || '');
    $('#transportir').val(dn.transportir || '');
  }).on('select2:clear', function(e){
    $('#drs_no,#drs_unique,#customer_po,#customer_name,#po_date,#delivery_to,#address,#qty,#description,#transportir').val('');
    $('#arrival_date').val('');
    var datepicker = $('#arrival_date').datepicker().data('datepicker');
    if(datepicker) {
        datepicker.clear();
    }
  });

  // Hide overlay when select2 is open (fallback)
  $('#dn_no').on('select2:open', function() {
    showDnOverlayLoading(false);
  });

  // Datepicker for arrival_date
  $('#arrival_date').datepicker({
    language: 'en',
    dateFormat: 'yyyy-mm-dd',
    autoClose: true
  });

  // Datepicker for bast_date
  $('#bast_date').datepicker({
    language: 'en',
    dateFormat: 'yyyy-mm-dd',
    autoClose: true
  });

  // Open modal in create mode
  $('#btn-create-delivery-note').on('click', function(){
    showDnOverlayLoading(true);
    deliveryNoteMode = 'create';
    $('#modalDeliveryNoteLabel').text('Create Delivery Note');
    $('#form-delivery-note')[0].reset();
    $('#dn-id').val('');
    $('#drs_unique').val('');
    $('#created_by').val(currentUser || '');
    $('#dn_no').val(null).trigger('change');
    setDeliveryNoteFormReadonly(false);
    $('#form-delivery-note .readonly-by-default').prop('readonly', true);
    $('#form-delivery-note [name=drs_unique], #form-delivery-note [name=created_by]').prop('readonly', true);
    $('#form-delivery-note [name=dn_no]').prop('disabled', false);
    $('#form-delivery-note .invalid-feedback').hide();
    $('#btn-save-delivery-note').show();
    deliveryNoteModal.show();
    setTimeout(function() {
      showDnOverlayLoading(false);
    }, 500);
  });

  // View button
  $('#basic-1 tbody').on('click', '.btn-view', function(){
    const id = $(this).data('id');
    $.get('/api/delivery-note/'+id, function(row){
      deliveryNoteMode = 'view';
      $('#modalDeliveryNoteLabel').text('View Delivery Note');
      fillDeliveryNoteForm(row);
      setDeliveryNoteFormReadonly(true);
      $('#btn-save-delivery-note').hide();
      deliveryNoteModal.show();
    });
  });

  // Edit button
  $('#basic-1 tbody').on('click', '.btn-edit', function(){
    const id = $(this).data('id');
    $.get('/api/delivery-note/'+id, function(row){
      deliveryNoteMode = 'edit';
      $('#modalDeliveryNoteLabel').text('Edit Delivery Note');
      fillDeliveryNoteForm(row);
      setDeliveryNoteFormReadonly(false);
      $('#form-delivery-note .readonly-by-default').prop('readonly', true);
      $('#form-delivery-note [name=dn_no]').prop('disabled', true);
      $('#form-delivery-note [name=drs_unique], #form-delivery-note [name=created_by]').prop('readonly', true);
      $('#form-delivery-note .invalid-feedback').hide();
      $('#btn-save-delivery-note').show();
      deliveryNoteModal.show();
    });
  });

  // Delete button
  $('#basic-1 tbody').on('click', '.btn-delete', function(){
    const id = $(this).data('id');
    if (window.Swal) {
      Swal.fire({
        title: 'Hapus Delivery Note?',
        text: "Data yang sudah dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) doDeleteDeliveryNote(id);
      });
    } else {
      if (confirm('Hapus Delivery Note ini?')) doDeleteDeliveryNote(id);
    }
  });

  // PDF button
  $('#basic-1 tbody').on('click', '.btn-pdf', function(){
    const id = $(this).data('id');
    // Get row data to find the file URL
    const rowData = deliveryNoteTable.rows().data().toArray().find(r => r.id == id);
    if (rowData && rowData.file) {
      openPdfModal(rowData.file, rowData.dn_no || 'Delivery Note PDF');
    } else {
      showToast('File PDF tidak ditemukan', 'error');
    }
  });



  // Event handler untuk form upload BAST
  $('#form-upload-bast').on('submit', function(e) {
    e.preventDefault();
    const fileInput = $('#bast_file')[0];
    const file = fileInput.files[0];
    const errorDiv = $('#bast-file-error');
    const bastDate = $('#bast_date').val();

    // Pastikan hidden fields FOB dan SENT_VIA terisi dari data Delivery Note
    const drs_unique = $('#bast_drs_unique').val();
    const rowData = deliveryNoteTable.rows().data().toArray().find(r => r.drs_unique === drs_unique);
    if (rowData) {
      $('#fob').val(rowData.fob || '');
      $('#sent_via').val(rowData.shipped_via || '');
    }

    // Validasi BAST Date
    if (!bastDate || bastDate.trim() === '') {
        $('#bast_date').addClass('is-invalid');
        showToast('BAST Date harus diisi', 'error');
        return;
    } else {
        $('#bast_date').removeClass('is-invalid');
    }

    // Validasi file
    if (!file) {
        errorDiv.text('Silakan pilih file terlebih dahulu.').show();
        return;
    }
    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        errorDiv.text('Tipe file tidak valid. Harap pilih PDF, JPG, atau PNG.').show();
        return;
    }
    const maxSize = 1 * 1024 * 1024; // 1MB
    if (file.size > maxSize) {
        errorDiv.text('Ukuran file terlalu besar. Maksimal 1MB.').show();
        return;
    }
    errorDiv.hide();

    // Tampilkan loading dan disable tombol
    const submitButton = $('#btn-save-bast');
    submitButton.prop('disabled', true);
    submitButton.find('.spinner-border').removeClass('d-none');

    const formData = new FormData(this);

    // AJAX call untuk upload file
    $.ajax({
        url: '/api/delivery-note/upload-bast',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            submitButton.prop('disabled', false);
            submitButton.find('.spinner-border').addClass('d-none');
            showToast(response.message || 'BAST berhasil diupload.', 'success');
            bastUploadModal.hide();
            reloadDeliveryNoteTable();
        },
        error: function(xhr) {
            submitButton.prop('disabled', false);
            submitButton.find('.spinner-border').addClass('d-none');
            let errorMessage = 'Gagal mengupload BAST.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                const firstError = Object.values(errors)[0][0];
                errorMessage = firstError;
            }
            showToast(errorMessage, 'error');
        }
    });
});

  // Reset modal BAST saat ditutup
  $('#modal-upload-bast').on('hidden.bs.modal', function(){
    $('#form-upload-bast')[0].reset();
    $('#bast-file-error').hide();
    $('#bast_date').removeClass('is-invalid');
    // Clear datepicker
    var datepicker = $('#bast_date').datepicker().data('datepicker');
    if(datepicker) {
        datepicker.clear();
    }
  });

  // Reset modal PDF saat ditutup
  $('#modal-pdf-preview').on('hidden.bs.modal', function(){
    $('#pdf-iframe').attr('src', '');
  });


  function doDeleteDeliveryNote(id) {
    $.ajax({
      url: '/api/delivery-note/'+id,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success: function(resp){
        showToast('Berhasil dihapus','success');
        reloadDeliveryNoteTable();
      }, error: function(xhr){
        showToast('Gagal menghapus','error');
      }
    });
  }

  // Fill form for edit/view
  function fillDeliveryNoteForm(row) {
    $('#dn-id').val(row.id || '');
    if (row.dn_no) {
        var newOption = new Option(row.dn_no, row.dn_no, true, true);
        $('#dn_no').append(newOption).trigger('change');
    }
    $('#drs_no').val(row.drs_no||'');
    $('#drs_unique').val(row.drs_unique||'');
    $('#customer_po').val(row.customer_po||'');
    $('#customer_name').val(row.customer_name||'');
    $('#po_date').val(row.po_date||'');
    $('#arrival_date').val(row.arrival_date||'');
    $('#consignee').val(row.consignee||'');
    $('#delivery_to').val(row.delivery_to||'');
    $('#address').val(row.address||'');
    $('#qty').val(row.qty||'');
    $('#unit').val(row.unit||'');
    // Kolom baru
    $('#berat_jenis').val(row.berat_jenis||'');
    $('#temperature').val(row.temperature||'');
    $('#description').val(row.description||'');
    $('#segel_atas').val(row.segel_atas||'');
    $('#segel_bawah').val(row.segel_bawah||'');
    $('#nopol').val(row.nopol||'');
    $('#driver_name').val(row.driver_name||'');
    $('#transportir').val(row.transportir||'');
    $('#so').val(row.so||'');
    $('#terra').val(row.terra||'');
    $('#created_by').val(row.created_by||'');
  }

  // Form submit
  $('#form-delivery-note').on('submit', function(e){
    e.preventDefault();
    let form = $(this)[0];
    if (!form.checkValidity()) {
      $(form).addClass('was-validated');
      return;
    }
    $('#btn-save-delivery-note .spinner-border').removeClass('d-none');
    $('#btn-save-delivery-note').prop('disabled', true);

    let data = $(this).serializeArray();

    // FORCE include hidden status value (overwrite if double)
    let statusVal = $('#status').val();
    let foundStatus = false;
    data = data.map(function(d) {
      if(d.name === 'status') {
        foundStatus = true;
        return {name: 'status', value: statusVal};
      }
      return d;
    });
    if (!foundStatus) {
      data.push({name: 'status', value: statusVal});
    }

    if ($('#dn_no').is(':disabled')) {
        data.push({name: 'dn_no', value: $('#dn_no').val()});
    }

    let method = deliveryNoteMode === 'edit' ? 'PUT' : 'POST';
    let url = '/api/delivery-note' + (deliveryNoteMode === 'edit' ? '/' + $('#dn-id').val() : '');
    $.ajax({
      url: url,
      type: method,
      data: $.param(data),
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success: function(resp){
        $('#btn-save-delivery-note .spinner-border').addClass('d-none');
        $('#btn-save-delivery-note').prop('disabled', false);
        showToast('Berhasil disimpan','success');
        reloadDeliveryNoteTable();
        deliveryNoteModal.hide();
      },
      error: function(xhr){
        $('#btn-save-delivery-note .spinner-border').addClass('d-none');
        $('#btn-save-delivery-note').prop('disabled', false);
        let errorMsg = 'Gagal menyimpan';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
        }
        showToast(errorMsg,'error');
      }
    });
  });

  // Reset modal on close
  $('#modal-delivery-note').on('hidden.bs.modal', function(){
    $('#form-delivery-note')[0].reset();
    $('#dn_no').val(null).trigger('change');
    $('#form-delivery-note').removeClass('was-validated');
    setDeliveryNoteFormReadonly(false);
    // Reset kolom baru juga
    $('#berat_jenis').val('');
    $('#temperature').val('');
  });
  $('#modal-delivery-note').on('shown.bs.modal', function(){
    showDnOverlayLoading(false);
  });
});
</script>
@endsection
