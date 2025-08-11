@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- Panggil Select2 JS + CSS di layout -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Delivery Request Slip - DRS</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item active">DRS</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  {{-- Datatable disini --}}
  <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
  <div>
    <h4 class="mb-0">Data DRS</h4>
    <span>Semua data Delivery Request Slip ada Disini</span>
  </div>
  <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">
    <input class="datepicker-here form-control digits" type="text" data-language="en"
    data-min-view="months" data-position="bottom left" data-view="months" data-date-format="YYYY-MM" id="filter-month" style="width:160px;max-width:160px;">
 <button type="button" class="btn btn-light border rounded-square" id="btn-reset-filter" style="border-radius:8px;aspect-ratio:1/1;width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
      <i class="fa fa-refresh"></i>
    </button>
    <button type="button" class="btn btn-success" style="color:#fff; border-radius:8px; aspect-ratio:1/1; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
      <i class="fa fa-plus"></i>
    </button>

    </div>
</div>
          <div class="card-body">
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>No DRS</th>
                    <th>Customer</th>
                    <th>Nomor PO</th>
                    <th>Tanggal PO</th>
                    <th>Qty (KL)</th>
                    <th>Req Arrival</th>
                    <th>DN Nomer</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
<!-- MODAL ADD DRS -->
<div class="modal fade" id="modal-add-drs" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="form-add-drs" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Delivery Request Slip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">

        <div class="col-md-6">
          <label>Nomor PO</label>
          <select id="select-po" name="po_id" class="form-select select2" data-placeholder="Pilih PO" style="width: 100%;">
        <option value=""></option>
        </select>
          <input type="hidden" id="po_number" name="po_number" />
        </div>


        <!-- First row: Nama Customer, Tanggal PO, Source -->
        <div class="col-md-6">
          <label>Nama Customer</label>
          <input type="text" id="customer_name" name="customer_name" class="form-control" readonly>
        </div>
        <div class="col-md-3">
          <label>Tanggal PO</label>
          <input type="text" id="po_date" name="po_date" class="form-control" readonly>
        </div>
        <div class="col-md-3">
          <label>Source</label>
          <input type="text" id="source" name="source" class="form-control" readonly>
        </div>

        <!-- Second row: Volume, Truck Capacity, Request Date -->
        <div class="col-md-3">
          <label>Volume</label>
          <input type="number" step="0.01" name="volume" class="form-control" placeholder="Volume dalam KL">
        </div>
        <div class="col-md-3">
          <label>Truck Capacity</label>
          <input type="number" step="0.01" name="truck_capacity" class="form-control" placeholder="Capacity dalam KL">
          <div id="capacity-warning" class="mt-1 d-none">
            <span class="badge bg-danger text-white">
              Anda memerlukan DRS lagi untuk memuat semua order agar sesuai dengan Volume
            </span>
          </div>
        </div>
        <div class="col-md-2">
          <label>Request Date</label>
          <input type="text" name="request_date" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd">
        </div>

        <!-- Third row: Transporter, Wilayah -->
        <div class="col-md-6">
          <label>Transporter</label>
          <select id="select-transporter" name="transporter_name" class="select2" data-placeholder="Pilih Transporter" style="width: 100%;">
            <option value=""></option>
          </select>
            <input type="hidden" id="wilayah_nama" name="wilayah_nama" value="">
        </div>
        <div class="col-md-4">
          <label>Wilayah</label>
          <select id="select-wilayah" name="wilayah" class="select2" data-placeholder="Pilih Wilayah" style="width: 100%;">
            <option value=""></option>
          </select>
        </div>

        <div class="col-md-12">
          <label>Site Location</label>
          <textarea name="site_location" class="form-control"></textarea>
        </div>

        <!-- Delivery Note, PIC Site, PIC Site Telp in one row -->
        <div class="col-md-3">
          <label>Delivery Note Numbers</label>
          <input type="text" name="delivery_note" class="form-control" placeholder="Delivery Note" >
        </div>
        <div class="col-md-3">
          <label>PIC Site</label>
          <input type="text" name="pic_site" class="form-control" placeholder="PIC Site">
        </div>
        <div class="col-md-3">
          <label>PIC Site Telp</label>
          <input type="text" name="pic_site_telp" class="form-control" placeholder="PIC Site Telp">
        </div>
        <div class="col-md-3">
          <label>Requested By</label>
          <input type="text" name="requested_by" class="form-control" placeholder="Requested By">
        </div>

        <div class="col-md-12">
          <label>Additional Note</label>
          <textarea name="additional_note" class="form-control"></textarea>
        </div>

        <div class="col-md-12">
          <label>Generated DRS Code</label>
          <input type="text" id="drs_code" name="drs_no" class="form-control" readonly>
          <div class="mt-2">Uniq DRS Code: <span id="drs_unique"></span></div>
        </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" id="drs_unique_input" name="drs_unique" />
        <button type="submit" class="btn btn-primary rounded-square" id="btn-simpan-drs" style="border-radius:8px;">
          <span class="txt">Simpan</span>
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </div>
    </form>
  </div>
</div>
<!-- MODAL VIEW DRS DETAIL -->
<div class="modal fade" id="modal-view-drs" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Delivery Request Slip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody id="view-drs-body">
            <!-- Diisi via JS -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!-- Tombol akan diinject via JS -->
        <button type="button" class="btn btn-danger rounded-square ms-2"
        style="border-radius:8px;min-width:120px;height:42px;display:flex;align-items:center;justify-content:center;"
        data-bs-dismiss="modal">
          <i class="fa fa-times"></i>
          <span class="ms-2" style="font-size:1rem;">Tutup</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PDF VIEWER -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-labelledby="pdfViewerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfViewerModalLabel">PDF Viewer - DRS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
          <iframe id="pdfIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-download-pdf" onclick="downloadPdfFile()">
          <i class="fa fa-download"></i> Download
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link
  href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
  rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: function(){
            return $(this).data('placeholder');
        },
        dropdownParent: $('#modal-add-drs .modal-content')
    });

    if ($.fn.DataTable.isDataTable('#basic-1')) {
        $('#basic-1').DataTable().clear().destroy();
    }
    let tableDrs = $('#basic-1').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '/api/delivery-request',
            dataSrc: 'data',
            data: function(d) {
                let month = $('#filter-month').val();
                if (month) {
                    d.month = month;
                }
            }
        },
        columns: [
            { data: 'drs_no', defaultContent: '-' },           // No DRS
            { data: 'customer_name', defaultContent: '-' },    // Customer
            { data: 'po_number', defaultContent: '-' },        // Nomor PO
            { data: 'po_date', defaultContent: '-' },          // Tanggal PO
            {
                data: 'volume',
                defaultContent: '-',
                render: function(data, type, row) {
                  if (data == null || data === '') return '-';
                  return Number(data) % 1 === 0 ? Number(data) : Number(data).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                }
            },           // Qty (KL)
            { data: 'request_date', defaultContent: '-' },     // Req Arrival
            { data: 'dn_no', defaultContent: '-' },            // DN Nomer
            {
                data: 'id',
                orderable: false,
                render: function(data, type, row) {
                    var badge = '';
                    if (row.purchase_order == 1) {
                        badge = '<span class="badge bg-success text-white ms-1" style="cursor:pointer;" onclick="viewDrs(' + data + ')">Complete</span>';
                    } else {
                        badge = '<span class="badge bg-info text-white ms-1" style="cursor:pointer;" onclick="viewDrs(' + data + ')" >Ajukan</span>';
                    }
                    return `
                         ${badge}&nbsp;&nbsp;
                        <i class="fa fa-file-pdf-o text-danger fa-md" style="cursor:pointer;font-size:1.25em;" title="Download PDF" onclick="downloadDrsPdf('${row.file_drs || ''}', ${data})"></i>&nbsp;&nbsp;

                    `;
                }
            }
        ]
    });

    $('#filter-month').on('change', function() {
        tableDrs.ajax.reload();
    });

    $('#btn-reset-filter').on('click', function() {
        $('#filter-month').val('');
        tableDrs.ajax.reload();
    });

    tableDrs.on('draw', function() {
        if (window.feather) feather.replace();
    });

    function deleteDrs(id) {
        Swal.fire({
          title: 'Yakin mau hapus data ini?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `/api/delivery-request/${id}`,
              type: 'DELETE',
              success: function(res) {
                Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: res.message
                });
                $('#basic-1').DataTable().ajax.reload();
              },
              error: function(err) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Gagal hapus data.'
                });
              }
            });
          }
        });
    }

    // --------- DELIVERY NOTE AUTO GENERATE -----------
    function refreshDeliveryNote() {
        // Dapatkan nomor PO (text, bukan ID!)
        let po_no = $('#select-po option:selected').text().trim();
        let wilayah = $('#select-wilayah').val();
        let source = $('#source').val();
        // Jika salah satu kosong, kosongkan field dan stop
        if (!po_no || !wilayah) {
            $('input[name="delivery_note"]').val('');
            return;
        }
        $.getJSON('/api/delivery-note-seq', { po: po_no, wilayah: wilayah, source: source })
            .done(function(res) {
                $('input[name="delivery_note"]').val(res.delivery_note);
            });
    }
    // -------------------------------------------------

    // Modal Create New DRS
    $('button.btn-success').on('click', function() {
        $('#modal-add-drs').modal('show');
        // clear previous validation when opening modal
        $('#select-wilayah').attr('name', 'wilayah');
        $('#form-add-drs .is-invalid').removeClass('is-invalid');
        $('#form-add-drs .invalid-feedback').remove();
        // show global loading overlay
        $('#loading-overlay')
            .appendTo($('#modal-add-drs .modal-dialog'))
            .css({
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%',
                display: 'flex'
            })
            .show();

        const poRequest = $.get('/api/delivery-request/po-list');
        const transporterRequest = $.get('/api/transporter');
        const wilayahRequest = $.get('/api/master-lov/children', { parent_code: 'CODE_MMTEI_LOKASI' });

        poRequest.done(res => {
            $('#select-po').html('<option value="">Pilih PO</option>');
            res.data.forEach(po => {
                $('#select-po').append(`<option value="${po.id}">${po.po_no}</option>`);
            });
        });
        transporterRequest.done(res => {
            $('#select-transporter').html('<option value="">Pilih Transporter</option>');
            res.data.forEach(t => {
                $('#select-transporter').append(`<option value="${t.nama}">${t.nama}</option>`);
            });
        });
        wilayahRequest.done(res => {
            $('#select-wilayah').html('<option value="">Pilih Wilayah</option>');
            res.forEach(w => {
                $('#select-wilayah').append(`<option value="${w.value}" data-nama="${w.code}">${w.code}</option>`);
            });
        });

        // hide loading when all done, dan generate delivery note!
        $.when(poRequest, transporterRequest, wilayahRequest).always(() => {
            $('#loading-overlay')
                .hide()
                .appendTo('body')
                .css({position: 'fixed'});
            // Panggil auto delivery note setelah semua option terisi
            refreshDeliveryNote();
        });

        // RESET FORM
        $('#form-add-drs')[0].reset();
        $('#wilayah_nama').val('');
        // Generate unique code on modal open
        let now = new Date();
        let tahun = now.getFullYear().toString().slice(-2);
        let uniq = `${now.getDate()}${now.getMonth()+1}${tahun}${now.getHours()}${now.getMinutes()}${now.getSeconds()}`;
        $('#drs_unique').text(uniq);
        $('#drs_unique_input').val(uniq);
    });

    // On PO change ➜ fill fields & refresh delivery note
    $('#select-po').on('change', function() {
        let po = $(this).val();
        let po_no = $('#select-po option:selected').text();
        $('#po_number').val(po_no);
        if (!po) return;
        $.get(`/api/good-receipts/${po}/detail`, res => {
            let d = res; // FIX: response is root object, not res.data
            $('#sph_no').val(d.kode_sph);
            $('#customer_name').val(d.nama_customer);
            // Format tanggal tanpa time (YYYY-MM-DD)
            let poDate = d.created_at ? d.created_at.split('T')[0] : '';
            $('#po_date').val(poDate);
            $('#source').val(d.data_sph.tipe_sph); // FIX: use nested data_sph

            // Generate DRS Code
            let now = new Date();
            let monthRomawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now.getMonth()];
            let seqTanggal = now.getDate() <= 4 ? 'I' : 'II';
            let tahun = now.getFullYear().toString().slice(-2);
            let drsCode = `No.${d.daily_seq ?? 'XX'}/${monthRomawi}/${d.data_sph.tipe_sph}/${seqTanggal}/${tahun}`;
            $('#drs_code').val(drsCode);

            // Panggil delivery note setelah PO detail terisi
            refreshDeliveryNote();
        });
    });

    // On Wilayah change, refresh delivery note juga!
    $('#select-wilayah').on('change', function() {
    let namaWilayah = $('#select-wilayah option:selected').data('nama') || '';
    $('#wilayah_nama').val(namaWilayah);
    refreshDeliveryNote();
    });

    // Submit
    $('#form-add-drs').on('submit', function(e) {
        e.preventDefault();
        $('#form-add-drs .is-invalid').removeClass('is-invalid');
        $('#form-add-drs .invalid-feedback').remove();
        const requiredFields = ['#select-po', '#customer_name', '#po_date', '#source', '[name="volume"]',
            '[name="truck_capacity"]', '[name="request_date"]', '#select-transporter', '#select-wilayah', '[name="delivery_note"]',
            '[name="pic_site_telp"]','[name="pic_site"]','[name="po_number"]','[name="requested_by"]','[name="drs_unique"]'];
        let isValid = true;
        requiredFields.forEach(selector => {
            const $el = $(this).find(selector);
            if (!$el.val()) {
                isValid = false;
                $el.addClass('is-invalid');
                if ($el.next('.invalid-feedback').length === 0) {
                    $el.after('<div class="invalid-feedback d-block">Field ini wajib diisi</div>');
                }
            }
        });
        if (!isValid) {
            // Show validation error using Swal
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Mohon lengkapi semua field yang wajib diisi.'
            });
            return;
        }

        // Button loading ON
        var $btn = $('#btn-simpan-drs');
        $btn.prop('disabled', true);
        $btn.find('.txt').addClass('d-none');
        $btn.find('.spinner-border').removeClass('d-none');

        // Pastikan dn_no dikirim dari delivery_note (bukan manual input)
        $('[name="dn_no"]').remove(); // hapus jika ada sebelumnya
        $('<input type="hidden" name="dn_no">')
            .val($('[name="delivery_note"]').val())
            .appendTo('#form-add-drs');

        let formData = $(this).serialize();
        $.ajax({
            url: '/api/delivery-request/save',
            method: 'POST',
            data: formData,
            success: function(res) {
                $('#modal-add-drs').modal('hide');
                $('#form-add-drs')[0].reset();
                $('#form-add-drs .is-invalid').removeClass('is-invalid');
                $('#form-add-drs .invalid-feedback').remove();
                tableDrs.ajax.reload();
                setTimeout(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Sukses! Data berhasil disimpan.'
                    });
                }, 350);
            },
            error: function(xhr) {
                // Tampilkan error, misal pesan validasi Laravel
                let msg = 'Gagal menyimpan data!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                    // Optional: tampilkan error per field
                    if (xhr.responseJSON.errors) {
                        for (const field in xhr.responseJSON.errors) {
                            let inputSelector = '[name="' + field + '"]';
                            const $el = $('#form-add-drs').find(inputSelector);
                            $el.addClass('is-invalid');
                            if ($el.next('.invalid-feedback').length === 0) {
                                $el.after('<div class="invalid-feedback d-block">' + xhr.responseJSON.errors[field][0] + '</div>');
                            }
                        }
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg
                });
            },
            complete: function() {
                // Button loading OFF
                $btn.prop('disabled', false);
                $btn.find('.txt').removeClass('d-none');
                $btn.find('.spinner-border').addClass('d-none');
            }
        });
    });
    // Toggle warning if volume exceeds truck capacity
    $('#form-add-drs').on('input change', 'input[name="volume"], input[name="truck_capacity"]', function() {
      var vol = parseFloat($('input[name="volume"]').val()) || 0;
      var cap = parseFloat($('input[name="truck_capacity"]').val()) || 0;
      if (cap > 0 && vol > cap) {
        $('#capacity-warning').removeClass('d-none');
      } else {
        $('#capacity-warning').addClass('d-none');
      }
    });
});
window.viewDrs = function(id) {
    const table = $('#basic-1').DataTable();
    const drsData = table.data().toArray().find(d => d.id == id);
    if (!drsData) return;
    // Store the currently viewed DRS data globally for later use
    window._viewingDrsData = drsData;
    window._viewingDrsId = id;
    let html = `
      <tr><th>No DRS</th><td>${drsData.drs_no || ''}</td></tr>
      <tr><th>DRS Unique ID</th><td>${drsData.drs_unique || ''}</td></tr>
      <tr><th>Customer</th><td>${drsData.customer_name || ''}</td></tr>
      <tr><th>Nomor PO</th><td>${drsData.po_number || ''}</td></tr>
      <tr><th>Tanggal PO</th><td>${drsData.po_date || ''}</td></tr>
      <tr><th>Qty (KL)</th><td>${drsData.volume || ''}</td></tr>
      <tr><th>Req Arrival</th><td>${drsData.request_date || ''}</td></tr>
      <tr><th>DN Nomer</th><td>${drsData.dn_no || ''}</td></tr>
      <tr><th>Transporter</th><td>${drsData.transporter_name || ''}</td></tr>
      <tr><th>Wilayah</th><td>${drsData.wilayah || ''}</td></tr>
      <tr><th>Site Location</th><td>${drsData.site_location || ''}</td></tr>
      <tr><th>PIC Site</th><td>${drsData.pic_site || ''}</td></tr>
      <tr><th>PIC Site Telp</th><td>${drsData.pic_site_telp || ''}</td></tr>
      <tr><th>Requested By</th><td>${drsData.requested_by || ''}</td></tr>
      <tr><th>Additional Note</th><td>${drsData.additional_note || ''}</td></tr>
    `;
    $('#view-drs-body').html(html);

    // Tombol Ajukan PO Supplier dinamis
    let btnAjukan = '';
    if (drsData.purchase_order == 0) {
        btnAjukan = `<button type="button" class="btn btn-primary rounded-square ms-2 btn-ajukan-po"
            style="border-radius:8px;min-width:200px;height:42px;display:flex;align-items:center;justify-content:center;"
            onclick="ajukanPoSupplier(window._viewingDrsId)">
            <i class="fa fa-file-text-o"></i>
            <span class="ms-2" style="font-size:1rem;">Ajukan PO Transporter</span>
        </button>`;
    } else {
        btnAjukan = `<button type="button" class="btn btn-secondary rounded-square ms-2 btn-ajukan-po"
            style="border-radius:8px;min-width:200px;height:42px;display:flex;align-items:center;justify-content:center;"
            disabled>
            <i class="fa fa-file-text-o"></i>
            <span class="ms-2" style="font-size:1rem;">PO Transporter sudah diajukan</span>
        </button>`;
    }
    // Tombol Tutup (tetap kotak merah, label Tutup)
    let btnTutup = `<button type="button" class="btn btn-danger rounded-square ms-2" style="border-radius:8px;min-width:120px;height:42px;display:flex;align-items:center;justify-content:center;" data-bs-dismiss="modal">
          <i class="fa fa-times"></i>
          <span class="ms-2" style="font-size:1rem;">Tutup</span>
        </button>`;
    // Inject tombol ke modal-footer
    $('#modal-view-drs .modal-footer').html(btnAjukan + btnTutup);

    $('#modal-view-drs').modal('show');
};

window.ajukanPoSupplier = function(id) {
  // Use the globally set viewing DRS data
  const drsData = window._viewingDrsData;
  if (!drsData) {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: 'Data DRS tidak ditemukan!'
    });
    return;
  }

  let vendor_name  = drsData.transporter_name;
  let dn_no        = drsData.dn_no;
  let drs_no       = drsData.drs_no;
  let drs_unique   = drsData.drs_unique || '';
  let customer_po  = drsData.po_number;
  let qty          = drsData.volume;
  let pic_site      = drsData.pic_site;
  let site_location = drsData.site_location;
  let pic_site_telp =drsData.pic_site_telp;

  let $btnAjukan = $('#modal-view-drs .btn-ajukan-po');
  $btnAjukan.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
  $btnAjukan.addClass('loading'); // Optional: add a loading class for visual feedback (can be styled in CSS)

  $.ajax({
    url: '/api/purchase-order/po-transporter',
    type: 'POST',
    data: {
      vendor_name,
      dn_no,
      drs_no,
      drs_unique,
      customer_po,
      qty,
      pic_site,
      site_location,
      pic_site_telp
    },
    success: function(res) {
      Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: 'Berhasil diajukan!'
      });
      $('#modal-view-drs').modal('hide');
      $('#basic-1').DataTable().ajax.reload(); // reload datatable
    },
    error: function(xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal mengajukan PO Supplier!\n' + (xhr.responseJSON?.message ?? '')
      });
    },
    complete: function() {
      $btnAjukan.prop('disabled', false).html('<i class="fa fa-file-text-o"></i> <span class="ms-2" style="font-size:1rem;">Ajukan PO Supplier</span>');
      $btnAjukan.removeClass('loading'); // Remove loading class after request
    }
      });
};

// PDF Viewer Functions
let currentPdfUrl = '';

function downloadDrsPdf(pdfUrl, drsId) {
    // Check if PDF URL exists
    if (!pdfUrl || pdfUrl === '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'PDF tidak tersedia untuk DRS ini'
        });
        return;
    }

    // Set current PDF URL
    currentPdfUrl = pdfUrl;

    // Set iframe source
    $('#pdfIframe').attr('src', pdfUrl);

    // Show modal
    $('#pdfViewerModal').modal('show');
}

function downloadPdfFile() {
    if (currentPdfUrl) {
        // Create a temporary link to download the PDF
        const link = document.createElement('a');
        link.href = currentPdfUrl;
        link.download = `DRS_${Date.now()}.pdf`;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'URL PDF tidak tersedia'
        });
    }
}

// Handle modal events
$(document).ready(function() {
    // Reset iframe when modal is hidden
    $('#pdfViewerModal').on('hidden.bs.modal', function() {
        $('#pdfIframe').attr('src', '');
        currentPdfUrl = '';
    });
});
</script>
@endsection
