@extends('layout.master')

@php
use App\Helpers\PermissionHelper;
@endphp

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
<!-- Modal untuk Lihat PDF -->
<div class="modal fade" id="pdfViewerModal" tabindex="-1" aria-labelledby="pdfViewerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width:90%;">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <h5 class="modal-title mb-0">Lihat Dokumen SPH (PDF)</h5>
          <button type="button" class="btn btn-sm btn-outline-primary" id="btn-recreate-pdf-sph" title="Recreate PDF">Recreate</button>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" style="height: 80vh;">
        <iframe id="pdfViewerFrame" src="" frameborder="0" style="width:100%; height:100%;"></iframe>
      </div>
    </div>
  </div>
</div>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Surat Penawaran Harga - SPH</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
            <li class="breadcrumb-item active">Surat Penawaran Harga</li>
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
                <p class="square-after f-w-600 header-text-primary">Total SPH Dibuat<i class="fa fa-circle"> </i></p>
                <!-- added id -->
                <h4 id="card-total_sph">-</h4>
              </div>
              <div class="d-flex static-widget">
                  <i data-feather="file-text" class="text-primary" style="width: 40px; height: 40px;"></i>
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
                <p class="square-after f-w-600 header-text-success">Menunggu Approval<i class="fa fa-circle"> </i></p>
                <!-- added id -->
                <h4 id="card-waiting">-</h4>
              </div>
              <div class="d-flex static-widget">
                <i data-feather="slack" class="text-success" style="width: 40px; height: 40px;"></i>
              </div>
            </div>
          </div>
          <div class="card-body pt-0">
            <div class="progress-widget">
              <div class="progress sm-progress-bar progress-animate">
                <div class="progress-gradient-success" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
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
                <p class="square-after f-w-600 header-text-danger">Perlu Revisi<i class="fa fa-circle"> </i></p>
                <!-- added id -->
                <h4 id="card-revisi">-</h4>
              </div>
              <div class="d-flex static-widget">
                <i data-feather="edit" class="text-danger" style="width: 40px; height: 40px;"></i>
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
      <div class="col-sm-6 col-lg-3">
        <div class="card o-hidden user-widget">
          <div class="card-header pb-0">
            <div class="d-flex">
              <div class="flex-grow-1">
                <p class="square-after f-w-600 header-text-info">Approved & Reject SPH<i class="fa fa-circle"> </i></p>
                <!-- added id -->
                <h4 id="card-approved_reject">- | -</h4>
              </div>
              <div class="d-flex static-widget">
                <i data-feather="star" class="text-info" style="width: 40px; height: 40px;"></i>
              </div>
            </div>
          </div>
          <div class="card-body pt-0">
            <div class="progress-widget">
              <div class="progress sm-progress-bar progress-animate">
                <div class="progress-gradient-info" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
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
    <h4 class="mb-0">Data SPH</h4>
    <span>Data semua SPH yang telah dibuat, di-approve, direvisi termasuk yang ditolak akan masuk di sini</span>
  </div>
  <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">
    <button type="button" class="btn btn-primary" id="btn-create-sph" style="border-radius:8px;">
      Create New SPH
    </button>
    <button type="button" class="btn btn-light border rounded-square" id="btn-reset-filter" style="border-radius:8px;aspect-ratio:1/1;width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
      <i class="fa fa-refresh"></i>
    </button>
    <input class="datepicker-here form-control digits" type="text" data-language="en"
    data-min-view="months" data-position="top left" data-view="months" data-date-format="YYYY-MM" id="filter-month" style="width:160px;max-width:160px;">

    <select class="form-select" id="filter-status" style="width:200px;max-width:220px;">
        <option value="">Semua Status</option>
        <option value="approvallist">Menunggu Approval</option>
        <option value="revisi">Revisi</option>
        <option value="reject">Reject</option>
        <option value="approved">Approved</option>
    </select>
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
                    <th>Harga /Liter</th>
                    <th>PPN</th>
                    <th>PBBKB</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Dibuat Oleh</th>
                    <th>Workflow</th>
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
<!-- Remark Modal -->
<div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remarkModalLabel">Workflow History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="remark-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Pengisi</th>
              <th>Remark</th>
              <th>Dibuat Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="3" class="text-center">Belum ada data</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal Create SPH -->
<div class="modal fade" id="createSphModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create SPH</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="create-sph-form" novalidate>
          <div class="mb-3">
            <label class="form-label">Tipe SPH</label>
            <select id="field-tipe" class="form-select" required>
              <option value="">Pilih Type SPH</option>
              <option value="MMLN">MMLN</option>
              <option value="MMTEI">MMTEI</option>
              <option value="IASE">IASE</option>
            </select>
            <div class="invalid-feedback">Tipe SPH wajib dipilih.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Pilih Company</label>
            <select id="field-company" class="form-select" required>
              <option value="">Pilih Company</option>
            </select>
            <div class="invalid-feedback">Nama Customer wajib dipilih.</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" style="border-radius:8px;" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" style="border-radius:8px;" id="btn-modal-pilih">Pilih</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Dynamic SPH Form (loads full page in iframe) -->
<div class="modal fade" id="formSphModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width:95%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formSphModalTitle">Form SPH</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="height:80vh;padding:0;">
        <iframe id="formSphFrame" src="" style="border:0;width:100%;height:100%;"></iframe>
      </div>
    </div>
  </div>
  </div>
<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Cancel SPH</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan cancel pengajuan SPH ini??<br>
        <small class="text-danger">Relasi data akan dihapus dan tidak dapat dikembalikan.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning rounded" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger rounded" id="confirmDeleteBtn">Ya, Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Konfirmasi Tambah Good Receipt -->
<div class="modal fade" id="modalAddGoodReceipt" tabindex="-1" aria-labelledby="modalAddGoodReceiptLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddGoodReceiptLabel">Konfirmasi Tambah Good Receipt</h5>
      </div>
      <div class="modal-body">
        Apakah anda yakin menambahkan SPH ini ke Good Receipt (Penerimaan PO Customer)?
      </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Batal</button>
      <button type="button" class="btn btn-primary rounded" id="btnConfirmAddGR">Ya, Tambahkan</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Ensure Select2 JS loaded after jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(function(){
    console.log('▶️ SPH page script loaded, setting up DataTable…');

    // 1) Initialize DataTable once
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
                { title: 'Dibuat Oleh'},
                { title: 'Workflow' },
                { title: 'Action' }
            ]
        });

    // 2) Filter Handler
    $('#filter-status, #filter-month').on('change', function(){
        fetchSphWithFilter();
    });

    // 3) Fetch & render with filter
    function fetchSphWithFilter(){
        var status = $('#filter-status').val();
        var month = $('#filter-month').val();
        var params = {};
        if (status) params.status = status;
        if (month) params.month = month;

        // Add restrict parameter based on permission
        @if(PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.restrict', 'sph.o.menu') == 1)
        params.restrict = 1;
        @else
        params.restrict = 0;
        @endif

        var qs = $.param(params);

        table.clear().draw();
        $('#basic-1 tbody').html(
            '<tr><td colspan="11" class="text-center py-4">'+
            '<div class="spinner-border text-primary" role="status"></div>'+
            ' <span>Loading...</span>'+
            '</td></tr>'
        );

        $.get('/api/sph/list' + (qs ? '?' + qs : ''), function(res){
            // update cards
            $('#card-total_sph').text(res.cards.total_sph);
            $('#card-waiting').text(res.cards.waiting);
            $('#card-revisi').text(res.cards.revisi);
            $('#card-approved_reject').text(res.cards.approved + ' | ' + res.cards.reject);

            window._sphDataRaw = res.data;
            var rows = res.data.map(function(item){
                var statusHtml;
                var actionHtml = '';
                // Normalize status to integer for comparison (handle string, number, null, undefined)
                var status = parseInt(String(item.status || '').trim()) || 0;
                
                // Status mapping
                var statusMap = {
                    1: { label: 'Menunggu Approval', class: 'bg-info' },
                    2: { label: 'Revisi', class: 'bg-warning' },
                    3: { label: 'Reject', class: 'bg-danger' },
                    4: { label: 'Approved', class: 'bg-success' }
                };
                
                // Get status info from map or use status_label from API
                var statusInfo = statusMap[status] || null;
                var statusLabel = statusInfo ? statusInfo.label : (item.status_label || 'Unknown');
                var badgeClass = statusInfo ? statusInfo.class : 'bg-secondary';
                
                switch(status){
                    case 1:
                        statusHtml = `<span class="badge ${badgeClass} badge-status-remark"
                            title="${item.workflow||''}"
                            style="cursor:pointer;" data-sph-id="${item.id}">${statusLabel}</span>`;
                        actionHtml +=
                            `<i class="fa fa-eye text-primary fa-md btn-view-sph"
                                title="Lihat Detail"
                                data-sph-id="${item.id}"
                                data-template-id="${item.template_id||''}"
                                data-template-form="${item.template_form||''}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`+
                            `<i class="fa fa-trash text-danger fa-md" title="Cancel SPH" data-sph-id="${item.id}"
                            style="cursor:pointer;font-size:1.25em;"></i> <span class="text-danger fw-bold ms-1" style="font-size:0.8em;">Cancel</span>`;
                        break;
                    case 2:
                        statusHtml = `<span class="badge ${badgeClass} badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">${statusLabel}</span>
                            <span class="badge bg-primary text-white ms-1 btn-edit-sph" data-sph-id="${item.id}" data-template-id="${item.template_id||''}" data-template-form="${item.template_form||''}" style="cursor:pointer;"><i class="fa fa-pencil"></i> Revisi</span>`;
                        actionHtml +=
                            `<i class="fa fa-eye text-primary fa-md btn-view-sph"
                                title="Lihat Detail"
                                data-sph-id="${item.id}"
                                data-template-id="${item.template_id||''}"
                                data-template-form="${item.template_form||''}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`+
                            `<i class="fa fa-trash text-danger fa-md" title="Cancel SPH" data-sph-id="${item.id}"
                            style="cursor:pointer;font-size:1.25em;"></i><span class="text-danger fw-bold ms-1" style="font-size:0.8em;">Cancel</span>`;
                        break;
                    case 3:
                        statusHtml = `<span class="badge ${badgeClass} badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">${statusLabel}</span>`;
                        actionHtml +=
                            `<i class="fa fa-eye text-primary fa-md btn-view-sph"
                                title="Lihat Detail"
                                data-sph-id="${item.id}"
                                data-template-id="${item.template_id||''}"
                                data-template-form="${item.template_form||''}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`+
                            `<i class="fa fa-trash text-danger fa-md" title="Cancel SPH" data-sph-id="${item.id}"
                            style="cursor:pointer;font-size:1.25em;"></i> <span class="text-danger fw-bold ms-1" style="font-size:1em;">Cancel</span>`;
                        break;
                    case 4:
                        statusHtml = `<span class="badge ${badgeClass} badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">${statusLabel}</span>`;
                        // View button available on approved too
                        actionHtml += `<i class="fa fa-eye text-primary fa-md btn-view-sph"
                                title="Lihat Detail"
                                data-sph-id="${item.id}"
                                data-template-id="${item.template_id||''}"
                                data-template-form="${item.template_form||''}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`;
                        // Check permission for Send Email button
                        @if(PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.sent', 'sph.o.menu'))
                        actionHtml += `<i class="fa fa-envelope text-info fa-md btn-send-mail"
                                title="Kirim Email ke Customer"
                                data-sph-id="${item.id}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`;
                        @endif

                        // Check permission for PDF button
                        @if(PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.pdf', 'sph.o.menu'))
                        actionHtml += `<i class="fa fa-file-pdf-o text-danger fa-md btn-show-pdf" title="Lihat PDF" data-sph-id="${item.id}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`;
                        @endif

                        // Check permission for Add GR button - HIDDEN
                        // @if(PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.gr', 'sph.o.menu'))
                        // actionHtml += `<i class="fa fa-plus-circle text-success fa-md btn-add-gr"
                        //         title="Tambahkan ke Good Receipt"
                        //         data-sph-id="${item.id}"
                        //         style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`;
                        // @endif
                        break;
                    default:
                        // Fallback: use status_label from API or statusMap, otherwise show Unknown
                        statusHtml = `<span class="badge ${badgeClass} badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">${statusLabel}</span>`;
                }
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
                    item.created_by,
                    statusHtml,
                    actionHtml
                ];
            });

            table.clear().rows.add(rows).draw();
            $('[title]').tooltip({ trigger: 'hover' });
        })
        .fail(function(){
            table.clear().draw();
            $('#basic-1 tbody').html(
                '<tr><td colspan="11" class="text-center text-danger py-4">'+
                'Gagal memuat data SPH.'+
                '</td></tr>'
            );
        });
    }
    // Expose to global for iframe callbacks
    window.fetchSphWithFilter = fetchSphWithFilter;

    // Tombol Reset Filter
    $('#btn-reset-filter').on('click', function(){
        $('#filter-status').val('');
        $('#filter-month').val('');
        fetchSphWithFilter();
    });

    // 4) Remark modal (icon or badge)
    $(document).on('click', '.fa-comment, .badge-status-remark', function(){
        var sphId = $(this).data('sph-id');
        $('#remarkModal').modal('show');
        $('#remark-table tbody').html(
            '<tr><td colspan="3" class="text-center py-3">'+
            '<div class="spinner-border text-primary" role="status"></div>'+
            ' <span>Loading remarks…</span></td></tr>'
        );
        $.get(`/api/remarks/${sphId}?tipe_trx=sph`)
        .done(function(remarks){
            var html = remarks.length
              ? remarks.map((r,i)=>`<tr>
                  <td>${i+1}</td>
                  <td>${r.user}</td>
                  <td>${r.comment}</td>
                  <td>${r.created_at ? new Date(r.created_at)
                    .toLocaleDateString('id-ID', {year:'numeric', month:'long', day:'numeric'})
                    : ''}</td>
                </tr>`).join('')
              : '<tr><td colspan="4" class="text-center">Tidak ada remark</td></tr>';
            $('#remark-table tbody').html(html);
        })
        .fail(function(){
            $('#remark-table tbody').html(
            '<tr><td colspan="3" class="text-center text-danger">Gagal memuat remark.</td></tr>'
            );
        });
    });

    // 5) Delete flow
    var deleteId = null;
    $(document).on('click', '.fa-trash', function(){
        deleteId = $(this).data('sph-id');
        $('#confirmDeleteModal').modal('show');
    });
    $('#confirmDeleteBtn').on('click', function(){
        if(!deleteId) return;
        $(this).prop('disabled', true).text('Menghapus...');
        $.ajax({
            url: '/api/sph/' + deleteId,
            method: 'DELETE',
            success: function(res){
                $('#confirmDeleteModal').modal('hide');
                $('#confirmDeleteBtn').prop('disabled', false).text('Ya, Hapus');
                fetchSphWithFilter();
                Swal.fire('Berhasil!', res.message || 'Data berhasil dihapus.', 'success');
            },
            error: function(xhr){
                Swal.fire('Gagal!', (xhr.responseJSON?.message||xhr.statusText), 'error');
                $('#confirmDeleteModal').modal('hide');
                $('#confirmDeleteBtn').prop('disabled', false).text('Ya, Hapus');
            }
        });
    });

    // 6) Kirim Email SPH
    $(document).on('click', '.btn-send-mail', function() {
        // Check permission for send email
        @if(!PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.sent', 'sph.o.menu'))
        Swal.fire('Akses Ditolak', 'Anda tidak memiliki izin untuk mengirim email SPH.', 'error');
        return;
        @endif
        var $row = $(this).closest('tr');
        var rowIdx = $('#basic-1').DataTable().row($row).index();
        var item = window._sphDataRaw ? window._sphDataRaw[rowIdx] : null;
        if (!item) {
            Swal.fire('Gagal!', 'Gagal mendapatkan data SPH.', 'error');
            return;
        }
        if (!item.pic_email) {
            Swal.fire('Oops!', 'PIC Email tidak ditemukan pada data ini!', 'warning');
            return;
        }
        if (!confirm('Kirim email SPH ke ' + item.pic_email + '?')) return;

        var payload = {
            to: item.pic_email,
            fullname: item.pic,
            company_name: item.comp_name,
            sph_kode: item.kode_sph,
            product: item.product,
            total: item.total_price,
            file_url: item.file_sph
        };

        // Tampilkan loading overlay
        if ($('#sending-overlay').length === 0) {
            $('body').append(
                '<div id="sending-overlay" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:99999;background:rgba(255,255,255,0.85);display:flex;align-items:center;justify-content:center;flex-direction:column;">' +
                '<div class="spinner-border text-primary" style="width:4rem;height:4rem;"></div>' +
                '<div style="margin-top:1rem;font-size:1.2em;">Mengirim email...</div>' +
                '</div>'
            );
        }

        $.ajax({
            url: '/api/send-sph-mail',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                $('#sending-overlay').remove();
                Swal.fire('Berhasil!', res.message || 'Email berhasil dikirim!', 'success');
            },
            error: function(xhr) {
                $('#sending-overlay').remove();
                Swal.fire('Gagal!', (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Gagal mengirim email.', 'error');
            }
        });

    });

    // 7) Good Receipt
    let selectedSphId = null;
    $(document).on('click', '.btn-add-gr', function() {
        // Check permission for add GR
        @if(!PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.gr', 'sph.o.menu'))
        Swal.fire('Akses Ditolak', 'Anda tidak memiliki izin untuk menambahkan ke Good Receipt.', 'error');
        return;
        @endif
        selectedSphId = $(this).data('sph-id');
        $('#modalAddGoodReceipt').modal('show');
    });

    $('#btnConfirmAddGR').on('click', function () {
        if (!selectedSphId) return;
        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
        $.ajax({
            url: '/api/tambah-good-receipts',
            method: 'POST',
            data: { sph_id: selectedSphId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                $('#modalAddGoodReceipt').modal('hide');
                Swal.fire('Berhasil!', res.message || 'Berhasil menambahkan ke Good Receipt!', 'success');
                fetchSphWithFilter();
            },
            error: function (xhr) {
                Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal menambahkan!', 'error');
            },
            complete: function () {
                $btn.prop('disabled', false).text('Ya, Tambahkan');
            }
        });
    });

    // 8) Rupiah formatter
    function formatRupiah(x){
        x = parseFloat(x)||0;
        return 'Rp ' + x.toLocaleString('id-ID',{minimumFractionDigits:2});
    }

    // 10) Tampilkan PDF di modal
    $(document).on('click', '.btn-show-pdf', function() {
        // Check permission for view PDF
        @if(!PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.pdf', 'sph.o.menu'))
        Swal.fire('Akses Ditolak', 'Anda tidak memiliki izin untuk melihat PDF SPH.', 'error');
        return;
        @endif
        const rowIdx = $('#basic-1').DataTable().row($(this).closest('tr')).index();
        const item = window._sphDataRaw ? window._sphDataRaw[rowIdx] : null;
        if (!item || !item.file_sph) {
            Swal.fire('Oops!', 'File tidak ditemukan!', 'warning');
            return;
        }
        $('#pdfViewerFrame').attr('src', item.file_sph);
        $('#pdfViewerModal').data('sph-id', item.id || item.sph_id);
        $('#pdfViewerModal').modal('show');
    });

    $(document).on('click', '#btn-recreate-pdf-sph', function() {
        var sphId = $('#pdfViewerModal').data('sph-id');
        if (!sphId) {
            Swal.fire('Oops!', 'SPH ID tidak ditemukan.', 'warning');
            return;
        }
        var $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
        $.ajax({
            url: '/api/sph/' + sphId + '/recreate-pdf',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            contentType: 'application/json',
            data: JSON.stringify({}),
            success: function(res) {
                $btn.prop('disabled', false).html('Recreate');
                if (res && res.success) {
                    Swal.fire('Berhasil', res.message || 'PDF sedang digenerate ulang.', 'success');
                    $('#pdfViewerModal').modal('hide');
                    if (typeof fetchSphWithFilter === 'function') fetchSphWithFilter();
                } else {
                    Swal.fire('Gagal', (res && res.message) || 'Gagal recreate PDF', 'error');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html('Recreate');
                Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Gagal recreate PDF', 'error');
            }
        });
    });

    // 9) Initial load (langsung dengan filter all)
    // Inisialisasi datepicker bulan/tahun
    $('#filter-month').datepicker({
    language: 'en',
    minView: 'months',
    view: 'months',
    dateFormat: 'yyyy-mm',
    autoClose: true,
    onSelect: function(fd, date) {
        $('#filter-month').trigger('change');
    }
    });

    fetchSphWithFilter();

    // View handler - open dynamic form in modal and populate read-only
    $(document).on('click', '.btn-view-sph', function(){
        var id = $(this).attr('data-sph-id') || $(this).data('sphId');
        var templateId = $(this).attr('data-template-id') || $(this).data('templateId');
        var templateForm = $(this).attr('data-template-form') || $(this).data('templateForm') || 'create';
        if (!id) return;

        // Fetch details then load form and inject values
        $.get('/api/sph/details', { id: id, template_id: templateId })
        .done(function(resp){
            var dataWrap = (resp && resp.data) ? resp.data : resp;
            var header = (dataWrap && dataWrap.header) ? dataWrap.header : (dataWrap || {});
            // Normalize templateForm in case backend returns uppercase/misc
            templateForm = (templateForm||'').toString().trim().toLowerCase();
            var formUrl = '{{ route('sph.form.dynamic', ['form' => '___FORM___']) }}'.replace('___FORM___', templateForm) + '?view=1';
            // Ensure this handler is isolated to VIEW flow
            $('#formSphFrame').off('load.view load.edit load.relabel');
            $('#formSphFrame').on('load.view', function(){
                try {
                    var doc = this.contentWindow || this.contentDocument;
                    if (doc.document) doc = doc.document;
                    var $d = $(doc);
                    // Ensure we're in VIEW mode only (create flow must stay interactive)
                    var inView = (new URL(this.src, window.location.origin)).searchParams.get('view') === '1';
                    if (!inView) return; // do not touch create mode
                    // Fill common fields if exist
                    function setVal(sel, val){ var el = $d.find(sel); if (el.length){ el.val(val); el.attr('readonly', true); el.prop('disabled', true); } }
                    function setSelectText(sel, text){ var el = $d.find(sel); if (!el.length) return; el.find('option').remove(); if (text){ el.append('<option selected>'+text+'</option>'); } el.prop('disabled', true); }
                    function setSelectOrTextPersist(sel, text, persistMs){
                        var el = $d.find(sel); if (!el.length) return;
                        var t = (text==null? '': String(text));
                        var apply = function(){
                            // Rebuild options with a single selected value
                            el.find('option').remove();
                            var opt = new Option(t, t, true, true);
                            el.append(opt);
                            if (el.data('select2') || el.hasClass('select2')) {
                                el.trigger('change.select2');
                            }
                        };
                        apply();
                        // Persist selection for a short time to override async loaders inside iframe
                        var ttl = typeof persistMs === 'number' ? persistMs : 2000;
                        var startedAt = Date.now();
                        var iv = setInterval(function(){
                            apply();
                            if (Date.now() - startedAt > ttl) { clearInterval(iv); }
                        }, 200);
                        el.prop('disabled', true);
                    }
                    setVal('#type_sph', header.tipe_sph || header.type_sph || '');
                    setVal('#comp_name', header.comp_name || header.company_name || '');
                    setVal('#kode_sph', header.kode_sph || '');
                    setVal('#pic', header.pic || '');
                    setVal('#contact_no', header.contact_no || '');
                    setVal('#email', header.email || header.pic_email || '');
                    setSelectOrTextPersist('#product', header.product || '', 2500);
                    // Gawi (Lokasi OAT free text)
                    setVal('#lokasi_oat', header.biaya_lokasi || header.oat_lokasi || header.site_location || '');
                    // Preselect Biaya Lokasi (if exists on template create)
                    setSelectOrTextPersist('#biaya_lokasi', (header.biaya_lokasi || header.oat_lokasi || header.site_location || ''), 2500);
                    if ($d.find('#pbbkb_percentage').length) {
                        var pctVal = header.pbbkb_percentage || '';
                        if (!pctVal && (header.biaya_lokasi || header.pbbkb != null)) {
                            var bl = String(header.biaya_lokasi || '');
                            if (bl.indexOf('7.5') !== -1 || bl.indexOf('7,5') !== -1) pctVal = '7.5';
                            else if (bl.indexOf('10') !== -1 && bl.indexOf('7') === -1) pctVal = '10';
                            else if (bl.indexOf('5') !== -1) pctVal = '5';
                            else if (header.pbbkb != null && header.price_liter > 0) {
                                var pct = (parseFloat(header.pbbkb) / parseFloat(header.price_liter)) * 100;
                                if (Math.abs(pct - 7.5) < 1) pctVal = '7.5';
                                else if (Math.abs(pct - 10) < 1) pctVal = '10';
                                else if (Math.abs(pct - 5) < 1) pctVal = '5';
                            }
                        }
                        $d.find('#pbbkb_percentage').val(pctVal);
                    }
                    // Price & computed
                    if ($d.find('#price_liter_display').length){
                        var price = parseFloat(header.price_liter || 0);
                        $d.find('#price_liter_hidden').val(price);
                        $d.find('#price_liter_display').val(new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(price));
                    }
                    // OAT & PPN OAT (khusus form pbbkbinclude)
                    if ($d.find('#oat_display').length){
                        var oat = parseFloat(header.oat || 0);
                        $d.find('#oat_hidden').val(oat);
                        $d.find('#oat_display').val(new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(oat));
                    }
                    if ($d.find('#ppn_oat_display').length){
                        var ppnOat = parseFloat(header.ppn_oat || 0);
                        $d.find('#ppn_oat_hidden').val(ppnOat);
                        $d.find('#ppn_oat_display').val(new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(ppnOat));
                    }
                    if ($d.find('#site_location').length){
                        $d.find('#site_location').val(header.oat_lokasi || header.site_location || '');
                    }
                    if ($d.find('#oat_lokasi').length){
                        $d.find('#oat_lokasi').val(header.oat_lokasi || header.site_location || '');
                    }
                    setVal('#ppn_display', new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(header.ppn||0)));
                    $d.find('#ppn_hidden').val(parseFloat(header.ppn||0));
                    if ($d.find('#pbbkb_display').length){
                        setVal('#pbbkb_display', new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(header.pbbkb||0)));
                        $d.find('#pbbkb_hidden').val(parseFloat(header.pbbkb||0));
                    }
                    if ($d.find('#total_price_display').length){
                        setVal('#total_price_display', new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(header.total_price||0)));
                        $d.find('#total_price_hidden').val(parseFloat(header.total_price||0));
                    }
                    // If detail table exists (KMP/Kencana/Gawi), render rows from API response
                    try {
                        var details = (dataWrap && dataWrap.details) ? (dataWrap.details || []) : [];
                        // Hide add/clear buttons in view mode
                        $d.find('#btn-add-detail, #btn-clear-detail').hide();
                        $d.find('#btn-add-oat, #btn-clear-oat').hide();
                        
                        // KMP Static Table: Check if this is KMP template with 2 separate static tables
                        // Get templateForm from variable or header as fallback, or from URL
                        var currentTemplateForm = templateForm || (header.template_form || '').toString().trim().toLowerCase();
                        // Fallback: try to get from iframe URL if not found
                        if (!currentTemplateForm && this.src) {
                            try {
                                var urlObj = new URL(this.src, window.location.origin);
                                var pathParts = urlObj.pathname.split('/');
                                var formIndex = pathParts.indexOf('form');
                                if (formIndex !== -1 && pathParts[formIndex + 1]) {
                                    currentTemplateForm = pathParts[formIndex + 1].toLowerCase();
                                }
                            } catch(e) {}
                        }
                        var isKmpStatic = currentTemplateForm === 'kmp' && $d.find('#table-oat-lines-kalsel').length > 0 && $d.find('#table-oat-lines-kalteng').length > 0;
                        // Check for kencana static table - detect by table ID presence (more reliable)
                        var isKencanaStatic = ($d.find('#table-oat-lines-kencana').length > 0) || (currentTemplateForm === 'kencana');
                        
                        if (isKencanaStatic && details && details.length) {
                            // Kencana Static Table: Fill existing inputs in view mode
                            var kencanaCustomers = ['PT Agri Eastborneo Kencana', 'PT Agrojaya Tirta Kencana', 'PT Sawit Kaltim Lestari', 'PT Agro Inti Kencanamas'];
                            
                            // Helper function to format Rupiah
                            var formatRupiah = function(value) {
                                var num = parseFloat(value || 0);
                                return 'Rp ' + num.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            };
                            
                            // Fill Kencana table
                            $d.find('#table-oat-lines-kencana tbody tr').each(function() {
                                var $row = $(this);
                                var customerName = $row.attr('data-customer') || $row.data('customer') || '';
                                var qty = parseInt($row.attr('data-qty') || $row.data('qty') || $row.find('.qty').val() || 0, 10);
                                
                                if (customerName && kencanaCustomers.some(function(c) { return customerName.indexOf(c) !== -1; })) {
                                    // Find matching detail from API response
                                    // API response has customer name with "5KL" or "10KL" suffix (e.g., "PT Agri Eastborneo Kencana 5KL")
                                    // HTML has customer name without suffix (e.g., "PT Agri Eastborneo Kencana")
                                    var matchingDetail = details.find(function(d) {
                                        var detailCustomer = (d.cname_lname || '').toString().trim();
                                        var detailQty = parseInt(d.qty || 0, 10);
                                        // Remove KL suffix from detailCustomer for matching
                                        var detailCustomerBase = detailCustomer.replace(/\s*\d+KL\s*/i, '').trim();
                                        // Match by base customer name and qty
                                        var customerMatch = detailCustomerBase === customerName || 
                                                          detailCustomer.indexOf(customerName) !== -1;
                                        return customerMatch && detailQty === qty;
                                    });
                                    
                                    if (matchingDetail) {
                                        // Fill the existing inputs (readonly in view mode)
                                        $row.find('.qty').val(matchingDetail.qty || qty);
                                        $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0));
                                        $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0));
                                        $row.find('.pbbkb').val(formatRupiah(matchingDetail.pbbkb || 0));
                                        $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0));
                                        
                                        // Set lokasi for the customer group (rowspan) - only set once per customer group
                                        var $customerGroup = $d.find('#table-oat-lines-kencana tbody tr[data-customer="' + customerName + '"]');
                                        var $lokSelect = $customerGroup.find('.lokasi-select').first();
                                        if ($lokSelect.length && matchingDetail.biaya_lokasi && !$lokSelect.find('option:selected').length) {
                                            var lokasiText = matchingDetail.biaya_lokasi || '';
                                            // Extract percentage from lokasi text
                                            var pctMatch = lokasiText.match(/(\d+[\.,]?\d*)\s*%/);
                                            var pct = pctMatch ? parseFloat(String(pctMatch[1]).replace(',', '.')) : 7.5;
                                            
                                            // Set lokasi dropdown
                                            $lokSelect.append(new Option(lokasiText, lokasiText, true, true));
                                            $lokSelect.attr('data-percentage', pct);
                                            $lokSelect.data('percentage', pct);
                                            if ($lokSelect.hasClass('select2-hidden-accessible')) {
                                                $lokSelect.trigger('change.select2');
                                            } else {
                                                $lokSelect.trigger('change');
                                            }
                                        }
                                    }
                                }
                            });
                            
                            // Retry mechanism to ensure data is filled (in case iframe not fully loaded)
                            var retryCount = 0;
                            var maxRetries = 5;
                            var retryInterval = setInterval(function() {
                                retryCount++;
                                if (retryCount > maxRetries) {
                                    clearInterval(retryInterval);
                                    return;
                                }
                                
                                // Check if any row still has empty harga-dasar
                                var hasEmptyRows = false;
                                $d.find('#table-oat-lines-kencana tbody tr').each(function() {
                                    var $row = $(this);
                                    var customerName = $row.attr('data-customer') || '';
                                    var qty = parseInt($row.attr('data-qty') || 0, 10);
                                    var hargaDasar = $row.find('.harga-dasar').val();
                                    
                                    if (customerName && (!hargaDasar || hargaDasar === '0' || hargaDasar === '')) {
                                        // Try to fill again
                                        var matchingDetail = details.find(function(d) {
                                            var detailCustomer = (d.cname_lname || '').toString().trim();
                                            var detailQty = parseInt(d.qty || 0, 10);
                                            var detailCustomerBase = detailCustomer.replace(/\s*\d+KL\s*/i, '').trim();
                                            var customerMatch = detailCustomerBase === customerName || 
                                                              detailCustomer.indexOf(customerName) !== -1;
                                            return customerMatch && detailQty === qty;
                                        });
                                        
                                        if (matchingDetail) {
                                            hasEmptyRows = true;
                                            $row.find('.qty').val(matchingDetail.qty || qty);
                                            $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0));
                                            $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0));
                                            $row.find('.pbbkb').val(formatRupiah(matchingDetail.pbbkb || 0));
                                            $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0));
                                        }
                                    }
                                });
                                
                                // If no empty rows found, stop retrying
                                if (!hasEmptyRows) {
                                    clearInterval(retryInterval);
                                }
                            }, 500);
                        } else if (isKmpStatic && details && details.length) {
                            // KMP Static Table: Fill existing inputs, don't create new rows
                            var kalselLocations = ['Sesulung Estate', 'Desa Betung'];
                            var kaltengLocations = ['Pundu Pantai Harapan', 'Gunung Mas KHS', 'Mustika Sembuluh', 'Desa Amin', 'Gunung Makmur', 'Simpang Seluncing'];
                            
                            // Helper function to format Rupiah
                            var formatRupiah = function(value) {
                                var num = parseFloat(value || 0);
                                return 'Rp ' + num.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            };
                            
                            // Fill Kalsel table
                            $d.find('#table-oat-lines-kalsel tbody tr').each(function() {
                                var $row = $(this);
                                var locName = $row.attr('data-nama') || $row.data('nama') || '';
                                var qty = parseInt($row.attr('data-qty') || $row.data('qty') || $row.find('.qty').val() || 0, 10);
                                
                                if (locName && kalselLocations.indexOf(locName) !== -1) {
                                    // Find matching detail from API response
                                    var matchingDetail = details.find(function(d) {
                                        var detailLoc = d.biaya_lokasi || d.cname_lname || '';
                                        var detailQty = parseInt(d.qty || 0, 10);
                                        return detailLoc === locName && detailQty === qty;
                                    });
                                    
                                    if (matchingDetail) {
                                        // Fill the existing inputs
                                        $row.find('.qty').val(matchingDetail.qty || qty);
                                        $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0));
                                        $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0));
                                        $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0));
                                        $row.find('.transport').val(formatRupiah(matchingDetail.transport || 0));
                                        $row.find('.grand-total').val(formatRupiah(matchingDetail.grand_total || 0));
                                    }
                                }
                            });
                            
                            // Fill Kalteng table
                            $d.find('#table-oat-lines-kalteng tbody tr').each(function() {
                                var $row = $(this);
                                var locName = $row.attr('data-nama') || $row.data('nama') || '';
                                var qty = parseInt($row.attr('data-qty') || $row.data('qty') || $row.find('.qty').val() || 0, 10);
                                
                                if (locName && kaltengLocations.indexOf(locName) !== -1) {
                                    // Find matching detail from API response
                                    var matchingDetail = details.find(function(d) {
                                        var detailLoc = d.biaya_lokasi || d.cname_lname || '';
                                        var detailQty = parseInt(d.qty || 0, 10);
                                        return detailLoc === locName && detailQty === qty;
                                    });
                                    
                                    if (matchingDetail) {
                                        // Fill the existing inputs
                                        $row.find('.qty').val(matchingDetail.qty || qty);
                                        $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0));
                                        $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0));
                                        $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0));
                                        $row.find('.transport').val(formatRupiah(matchingDetail.transport || 0));
                                        $row.find('.grand-total').val(formatRupiah(matchingDetail.grand_total || 0));
                                    }
                                }
                            });
                        } else {
                            // Gawi: table id #oat-details-table → Lokasi | OAT 10KL | OAT 5KL | Aksi
                            if (details && details.length && $d.find('#oat-details-table').length){
                            var $tbodyGawi = $d.find('#oat-details-table tbody');
                            var htmlGawi = details.map(function(row){
                                return '<tr>'+
                                  '<td><input type="text" class="form-control form-control-sm" value="'+ (row.cname_lname||'') +'" disabled></td>'+
                                  '<td><input type="text" class="form-control form-control-sm" value="'+ (row.total_price||'') +'" disabled></td>'+
                                  '<td><input type="text" class="form-control form-control-sm" value="'+ (row.grand_total||'') +'" disabled></td>'+
                                  '<td></td>'+
                                '</tr>';
                            }).join('');
                            $tbodyGawi.html(htmlGawi);
                        }
                        if (details && details.length && $d.find('#table-oat-lines').length){
                            var $tbody = $d.find('#table-oat-lines tbody');
                            var htmlRows = details.map(function(row){
                                // Detect columns by header structure (KMP has Transport & Grand Total; Kencana does not transport)
                                var hasTransport = $d.find('#table-oat-lines thead th:contains("Transport")').length > 0;
                                var hasNamaLokasi = $d.find('#table-oat-lines thead th:contains("Nama Lokasi")').length > 0;
                                var isKencana = $d.find('#table-oat-lines thead th:contains("Customer")').length > 0;
                                var idr = function(x){ return new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(x||0)); };
                                if (!isKencana) {
                                    // KMP columns: Lokasi | Nama Lokasi | QTY | Harga Dasar | PPN | PBBKB | Total | Transport | Grand Total | Aksi
                                    return '<tr>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ (row.biaya_lokasi||'') +'" disabled></td>'+
                                      (hasNamaLokasi ? '<td><input type="text" class="form-control form-control-sm" value="'+ (row.cname_lname||'') +'" disabled></td>' : '')+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ (row.qty||'') +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.price_liter) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.ppn) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.pbbkb) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.total_price) +'" disabled></td>'+
                                      (hasTransport ? '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.transport) +'" disabled></td>' : '')+
                                      (hasTransport ? '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.grand_total) +'" disabled></td>' : '')+
                                      '<td></td>'+
                                    '</tr>';
                                } else {
                                    // Kencana columns: Customer | QTY | Harga Dasar | PPN | PBBKB | Total | Lokasi | Aksi
                                    return '<tr>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ (row.cname_lname||'') +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ (row.qty||'') +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.price_liter) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.ppn) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.pbbkb) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ idr(row.total_price) +'" disabled></td>'+
                                      '<td><input type="text" class="form-control form-control-sm" value="'+ (row.biaya_lokasi||'') +'" disabled></td>'+
                                      '<td></td>'+
                                    '</tr>';
                                }
                            }).join('');
                            $tbody.html(htmlRows);
                        }
                        }
                    } catch (err) { console.warn('Failed to render details rows:', err); }
                    // Susut radio or dropdown
                    var susutVal = (header.susut!=null)? String(header.susut): null;
                    if (susutVal){ $d.find('input[name="susut"][value="'+susutVal+'"]').prop('checked', true); }
                    if ($d.find('#susut').length && susutVal) { $d.find('#susut').val(susutVal); }
                    setSelectOrTextPersist('#pay_method', header.payment || header.pay_method || '', 2500);
                    setVal('#note_berlaku', header.note_berlaku || '');
                    // Disable all inputs/selects and hide submit buttons
                    $d.find('input, select, textarea, button[type="submit"]').prop('disabled', true).attr('readonly', true);
                    $d.find('button[type="submit"]').hide();
                } catch(e) { console.warn('Failed to inject view data:', e); }
            });
            $('#formSphFrame').attr('src', formUrl);
            $('#formSphModalTitle').text('View SPH');
            $('#formSphModal').modal('show');
        })
        .fail(function(){
            Swal.fire('Gagal', 'Tidak dapat memuat detail SPH.', 'error');
        });
    });

    // Edit/Revisi handler - open dynamic form in modal and allow editing
    $(document).on('click', '.btn-edit-sph', function(){
        var id = $(this).attr('data-sph-id') || $(this).data('sphId');
        var templateId = $(this).attr('data-template-id') || $(this).data('templateId');
        var templateForm = $(this).attr('data-template-form') || $(this).data('templateForm') || 'create';
        if (!id) return;

        $.get('/api/sph/details', { id: id, template_id: templateId })
        .done(function(resp){
            var dataWrap = (resp && resp.data) ? resp.data : resp;
            var header = (dataWrap && dataWrap.header) ? dataWrap.header : (dataWrap || {});
            templateForm = (templateForm||'').toString().trim().toLowerCase();
            var formUrl = '{{ route('sph.form.dynamic', ['form' => '___FORM___']) }}'.replace('___FORM___', templateForm);
            // Ensure this handler is isolated to EDIT flow but do not clear relabel handler
            $('#formSphFrame').off('load.edit');
            $('#formSphFrame').on('load.edit', function(){
                try {
                    var doc = this.contentWindow || this.contentDocument;
                    if (doc.document) doc = doc.document;
                    var $d = $(doc);
                    // Guard: if URL has view=1, skip (this is not edit/revisi)
                    var isViewSrc = (new URL(this.src, window.location.origin)).searchParams.get('view') === '1';
                    if (isViewSrc) return;
                    // Fill fields but KEEP editable (no disabling)
                    function setVal(sel, val){ var el = $d.find(sel); if (el.length){ el.val(val); } }
                    function setSelectOrText(sel, text){
                        var el = $d.find(sel); if (!el.length) return;
                        el.find('option').remove();
                        if (text != null) {
                            var opt = new Option(String(text), String(text), true, true);
                            el.append(opt).trigger('change');
                        }
                    }
                    function setSelectOrTextPersist(sel, text, persistMs){
                        var el = $d.find(sel); if (!el.length) return;
                        var t = (text==null? '': String(text));
                        var apply = function(){
                            el.find('option').remove();
                            var opt = new Option(t, t, true, true);
                            el.append(opt);
                            if (el.data('select2') || el.hasClass('select2')) {
                                el.trigger('change.select2');
                            } else {
                                el.trigger('change');
                            }
                        };
                        apply();
                        var ttl = typeof persistMs === 'number' ? persistMs : 2000;
                        var startedAt = Date.now();
                        var iv = setInterval(function(){
                            apply();
                            if (Date.now() - startedAt > ttl) { clearInterval(iv); }
                        }, 200);
                    }
                    setVal('#type_sph', header.tipe_sph || header.type_sph || '');
                    setVal('#comp_name', header.comp_name || header.company_name || '');
                    setVal('#kode_sph', header.kode_sph || '');
                    setVal('#pic', header.pic || '');
                    setVal('#contact_no', header.contact_no || '');
                    setVal('#email', header.email || header.pic_email || '');
                    setSelectOrTextPersist('#product', header.product || '', 2500);
                    if ($d.find('#price_liter_display').length){
                        var price = parseFloat(header.price_liter || 0);
                        $d.find('#price_liter_hidden').val(price);
                        $d.find('#price_liter_display').val(new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(price));
                    }
                    if ($d.find('#oat_display').length){
                        var oat = parseFloat(header.oat || 0);
                        $d.find('#oat_hidden').val(oat);
                        $d.find('#oat_display').val(new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(oat));
                    }
                    if ($d.find('#ppn_oat_display').length){
                        var ppnOat = parseFloat(header.ppn_oat || 0);
                        $d.find('#ppn_oat_hidden').val(ppnOat);
                        $d.find('#ppn_oat_display').val(new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(ppnOat));
                    }
                    if ($d.find('#site_location').length){ $d.find('#site_location').val(header.oat_lokasi || header.site_location || ''); }
                    if ($d.find('#oat_lokasi').length){ $d.find('#oat_lokasi').val(header.oat_lokasi || header.site_location || ''); }
                    if ($d.find('#ppn_display').length){ $d.find('#ppn_display').val(new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(header.ppn||0))); }
                    if ($d.find('#ppn_hidden').length){ $d.find('#ppn_hidden').val(parseFloat(header.ppn||0)); }
                    if ($d.find('#pbbkb_display').length){ $d.find('#pbbkb_display').val(new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(header.pbbkb||0))); }
                    if ($d.find('#pbbkb_hidden').length){ $d.find('#pbbkb_hidden').val(parseFloat(header.pbbkb||0)); }
                    if ($d.find('#total_price_display').length){ $d.find('#total_price_display').val(new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(header.total_price||0))); }
                    if ($d.find('#total_price_hidden').length){ $d.find('#total_price_hidden').val(parseFloat(header.total_price||0)); }

                    // Optional: render details rows if form provides table and we have details
                    try {
                        var details = (dataWrap && dataWrap.details) ? (dataWrap.details || []) : [];
                        
                        // KMP Static Table: Check if this is KMP template with 2 separate static tables
                        var currentTemplateForm = templateForm || (header.template_form || '').toString().trim().toLowerCase();
                        var isKmpStatic = currentTemplateForm === 'kmp' && $d.find('#table-oat-lines-kalsel').length > 0 && $d.find('#table-oat-lines-kalteng').length > 0;
                        var isKencanaStatic = currentTemplateForm === 'kencana' && $d.find('#table-oat-lines-kencana').length > 0;
                        
                        if (isKencanaStatic && details && details.length) {
                            // Kencana Static Table: Fill existing inputs with data from API response
                            var kencanaCustomers = ['PT Agri Eastborneo Kencana', 'PT Agrojaya Tirta Kencana', 'PT Sawit Kaltim Lestari', 'PT Agro Inti Kencanamas'];
                            
                            // Helper function to format Rupiah
                            var formatRupiah = function(value) {
                                var num = parseFloat(value || 0);
                                return 'Rp ' + num.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            };
                            
                            // Fill Kencana table
                            $d.find('#table-oat-lines-kencana tbody tr').each(function() {
                                var $row = $(this);
                                var customerName = $row.attr('data-customer') || $row.data('customer') || '';
                                var qty = parseInt($row.attr('data-qty') || $row.data('qty') || $row.find('.qty').val() || 0, 10);
                                
                                if (customerName && kencanaCustomers.some(function(c) { return customerName.indexOf(c) !== -1; })) {
                                    // Find matching detail from API response
                                    // API response has customer name with "5KL" or "10KL" suffix (e.g., "PT Agri Eastborneo Kencana 5KL")
                                    // HTML has customer name without suffix (e.g., "PT Agri Eastborneo Kencana")
                                    var matchingDetail = details.find(function(d) {
                                        var detailCustomer = (d.cname_lname || '').toString().trim();
                                        var detailQty = parseInt(d.qty || 0, 10);
                                        // Remove KL suffix from detailCustomer for matching
                                        var detailCustomerBase = detailCustomer.replace(/\s*\d+KL\s*/i, '').trim();
                                        // Match by base customer name and qty
                                        var customerMatch = detailCustomerBase === customerName || 
                                                          detailCustomer.indexOf(customerName) !== -1;
                                        return customerMatch && detailQty === qty;
                                    });
                                    
                                    if (matchingDetail) {
                                        // Fill the existing inputs (keep them editable)
                                        $row.find('.qty').val(matchingDetail.qty || qty).trigger('change');
                                        $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0)).trigger('change');
                                        $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0)).trigger('change');
                                        $row.find('.pbbkb').val(formatRupiah(matchingDetail.pbbkb || 0)).trigger('change');
                                        $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0)).trigger('change');
                                        
                                        // Set lokasi for the customer group (rowspan) - only set once per customer group
                                        var $customerGroup = $d.find('#table-oat-lines-kencana tbody tr[data-customer="' + customerName + '"]');
                                        var $lokSelect = $customerGroup.find('.lokasi-select').first();
                                        if ($lokSelect.length && matchingDetail.biaya_lokasi && !$lokSelect.find('option:selected').length) {
                                            var lokasiText = matchingDetail.biaya_lokasi || '';
                                            // Extract percentage from lokasi text
                                            var pctMatch = lokasiText.match(/(\d+[\.,]?\d*)\s*%/);
                                            var pct = pctMatch ? parseFloat(String(pctMatch[1]).replace(',', '.')) : 7.5; // Default to 7.5 if not found
                                            
                                            // Set lokasi dropdown
                                            $lokSelect.append(new Option(lokasiText, lokasiText, true, true));
                                            $lokSelect.attr('data-percentage', pct);
                                            $lokSelect.data('percentage', pct);
                                            if ($lokSelect.hasClass('select2-hidden-accessible')) {
                                                $lokSelect.trigger('change.select2');
                                            } else {
                                                $lokSelect.trigger('change');
                                            }
                                        }
                                    }
                                }
                            });
                            
                            // Trigger recalculation after filling data
                            setTimeout(function() {
                                // Try to call recalcAllRows from iframe window
                                try {
                                    var iframeWindow = $d[0].defaultView || window;
                                    if (typeof iframeWindow.recalcAllRows === 'function') {
                                        iframeWindow.recalcAllRows();
                                    }
                                } catch(e) {
                                    // Fallback: manually recalculate each row
                                    $d.find('#table-oat-lines-kencana tbody tr').each(function(){
                                        try {
                                            var iframeWindow = $d[0].defaultView || window;
                                            if (typeof iframeWindow.recalcRow === 'function') {
                                                iframeWindow.recalcRow($(this));
                                            }
                                        } catch(err) {}
                                    });
                                }
                            }, 1500);
                        } else if (isKmpStatic && details && details.length) {
                            // KMP Static Table: Fill existing inputs with data from API response
                            var kalselLocations = ['Sesulung Estate', 'Desa Betung'];
                            var kaltengLocations = ['Pundu Pantai Harapan', 'Gunung Mas KHS', 'Mustika Sembuluh', 'Desa Amin', 'Gunung Makmur', 'Simpang Seluncing'];
                            
                            // Helper function to format Rupiah
                            var formatRupiah = function(value) {
                                var num = parseFloat(value || 0);
                                return 'Rp ' + num.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            };
                            
                            // Helper function to format number without currency
                            var formatNumber = function(value) {
                                var num = parseFloat(value || 0);
                                return num.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            };
                            
                            // Fill Kalsel table
                            $d.find('#table-oat-lines-kalsel tbody tr').each(function() {
                                var $row = $(this);
                                // Try multiple ways to get location name
                                var locName = $row.attr('data-nama') || $row.data('nama') || 
                                             $row.find('td:first').text().trim() || 
                                             $row.find('[data-lokasi]').attr('data-lokasi') || 
                                             $row.find('[data-lokasi]').data('lokasi') || '';
                                var qty = parseInt($row.attr('data-qty') || $row.data('qty') || $row.find('.qty').val() || 0, 10);
                                
                                // Normalize location name for matching (trim and case-insensitive)
                                var normalizedLocName = locName.toString().trim();
                                
                                // Find matching detail from API response (try both biaya_lokasi and cname_lname)
                                var matchingDetail = details.find(function(d) {
                                    var detailLoc1 = (d.biaya_lokasi || '').toString().trim();
                                    var detailLoc2 = (d.cname_lname || '').toString().trim();
                                    var detailQty = parseInt(d.qty || 0, 10);
                                    return (detailLoc1 === normalizedLocName || detailLoc2 === normalizedLocName) && detailQty === qty;
                                });
                                
                                if (matchingDetail) {
                                    // Fill the existing inputs (keep them editable)
                                    $row.find('.qty').val(matchingDetail.qty || qty).trigger('change');
                                    $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0)).trigger('change');
                                    $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0)).trigger('change');
                                    $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0)).trigger('change');
                                    $row.find('.transport').val(formatRupiah(matchingDetail.transport || 0)).trigger('change');
                                    $row.find('.grand-total').val(formatRupiah(matchingDetail.grand_total || 0)).trigger('change');
                                    
                                    // Also set hidden values if they exist
                                    if ($row.find('.harga-dasar-hidden').length) {
                                        $row.find('.harga-dasar-hidden').val(matchingDetail.price_liter || 0).trigger('change');
                                    }
                                    if ($row.find('.ppn-hidden').length) {
                                        $row.find('.ppn-hidden').val(matchingDetail.ppn || 0).trigger('change');
                                    }
                                    if ($row.find('.total-hidden').length) {
                                        $row.find('.total-hidden').val(matchingDetail.total_price || 0).trigger('change');
                                    }
                                    if ($row.find('.transport-hidden').length) {
                                        $row.find('.transport-hidden').val(matchingDetail.transport || 0).trigger('change');
                                    }
                                    if ($row.find('.grand-total-hidden').length) {
                                        $row.find('.grand-total-hidden').val(matchingDetail.grand_total || 0).trigger('change');
                                    }
                                }
                            });
                            
                            // Fill Kalteng table
                            $d.find('#table-oat-lines-kalteng tbody tr').each(function() {
                                var $row = $(this);
                                // Try multiple ways to get location name
                                var locName = $row.attr('data-nama') || $row.data('nama') || 
                                             $row.find('td:first').text().trim() || 
                                             $row.find('[data-lokasi]').attr('data-lokasi') || 
                                             $row.find('[data-lokasi]').data('lokasi') || '';
                                var qty = parseInt($row.attr('data-qty') || $row.data('qty') || $row.find('.qty').val() || 0, 10);
                                
                                // Normalize location name for matching (trim and case-insensitive)
                                var normalizedLocName = locName.toString().trim();
                                
                                // Find matching detail from API response (try both biaya_lokasi and cname_lname)
                                var matchingDetail = details.find(function(d) {
                                    var detailLoc1 = (d.biaya_lokasi || '').toString().trim();
                                    var detailLoc2 = (d.cname_lname || '').toString().trim();
                                    var detailQty = parseInt(d.qty || 0, 10);
                                    return (detailLoc1 === normalizedLocName || detailLoc2 === normalizedLocName) && detailQty === qty;
                                });
                                
                                if (matchingDetail) {
                                    // Fill the existing inputs (keep them editable)
                                    $row.find('.qty').val(matchingDetail.qty || qty).trigger('change');
                                    $row.find('.harga-dasar').val(formatRupiah(matchingDetail.price_liter || 0)).trigger('change');
                                    $row.find('.ppn').val(formatRupiah(matchingDetail.ppn || 0)).trigger('change');
                                    $row.find('.total').val(formatRupiah(matchingDetail.total_price || 0)).trigger('change');
                                    $row.find('.transport').val(formatRupiah(matchingDetail.transport || 0)).trigger('change');
                                    $row.find('.grand-total').val(formatRupiah(matchingDetail.grand_total || 0)).trigger('change');
                                    
                                    // Also set hidden values if they exist
                                    if ($row.find('.harga-dasar-hidden').length) {
                                        $row.find('.harga-dasar-hidden').val(matchingDetail.price_liter || 0).trigger('change');
                                    }
                                    if ($row.find('.ppn-hidden').length) {
                                        $row.find('.ppn-hidden').val(matchingDetail.ppn || 0).trigger('change');
                                    }
                                    if ($row.find('.total-hidden').length) {
                                        $row.find('.total-hidden').val(matchingDetail.total_price || 0).trigger('change');
                                    }
                                    if ($row.find('.transport-hidden').length) {
                                        $row.find('.transport-hidden').val(matchingDetail.transport || 0).trigger('change');
                                    }
                                    if ($row.find('.grand-total-hidden').length) {
                                        $row.find('.grand-total-hidden').val(matchingDetail.grand_total || 0).trigger('change');
                                    }
                                }
                            });
                        } else if (details && $d.find('#table-oat-lines').length){
                            var $thead = $d.find('#table-oat-lines thead');
                            var $tbody = $d.find('#table-oat-lines tbody');
                            var idr = function(x){ return new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(parseFloat(x||0)); };
                            var isKmp = $thead.find('th:contains("Transport")').length > 0 && $thead.find('th:contains("Grand Total")').length > 0;
                            var isKencana = $thead.find('th:contains("Customer")').length > 0 && $thead.find('th:contains("Transport")').length === 0;
                            if (isKmp) {
                                // Pastikan kolom Aksi tetap ada untuk baris lama
                                // Build editable rows as requested mapping for KMP
                                var htmlRows = details.map(function(row){
                                    var lokasiText = String(row.biaya_lokasi||''); // keep percentage text e.g. "DKI (6%)"
                                    return ''+
                                    '<tr>'+
                                      // Lokasi as select2 (ajax), preselect current text
                                      '<td><select class="form-select form-select-sm lokasi-select" style="width:100%" data-current="'+ (lokasiText||'') +'"></select></td>'+
                                      '<td><input type="text" class="form-control form-control-sm nama-lokasi" value="'+ (row.cname_lname||'') +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm qty" value="'+ (row.qty||'') +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm price" value="'+ idr(row.price_liter) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm ppn" value="'+ idr(row.ppn) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm pbbkb" value="'+ idr(row.pbbkb) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm total" value="'+ idr(row.total_price) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm transport" value="'+ idr(row.transport) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm grand-total" value="'+ idr(row.grand_total) +'" /></td>'+
                                      '<td><button type="button" class="btn btn-sm btn-danger btn-remove" style="border-radius:8px;">Hapus</button></td>'+
                                    '</tr>';
                                }).join('');
                                $tbody.html(htmlRows);
                                // Init select2 for lokasi dropdowns and preselect current value
                                try {
                                    var $formRoot = $d.find('#sph-form');
                                    var $lokSelects = $d.find('#table-oat-lines tbody .lokasi-select');
                                    if ($.fn.select2 && $lokSelects.length) {
                                        $lokSelects.select2({
                                            dropdownParent: $formRoot,
                                            placeholder: 'Pilih Lokasi',
                                            allowClear: true,
                                            width: '100%',
                                            ajax: {
                                                url: '/api/master-lov/children',
                                                dataType: 'json', delay: 250,
                                                data: function(){ return { parent_code: 'LOKASI_MASTER' }; },
                                                processResults: function(data){
                                                    return { results: $.map(data, function(item){ return { id: item.id, text: item.code + ' ('+ item.value +'%)', percentage: item.value }; }) };
                                                }
                                            }
                                        });
                                        $lokSelects.each(function(){
                                            var $s = $(this);
                                            var txt = $s.data('current');
                                            if (txt) {
                                                // Extract percentage from text like "DKI (6.5%)" or even truncated with ellipsis
                                                var pct = 0; try { var m = String(txt).match(/(\d+[\.,]?\d*)\s*%/); if (!m){ var inParen = String(txt).match(/\(([^)]*)/); if (inParen){ var m2 = inParen[1].match(/(\d+[\.,]?\d*)/); if (m2) m = m2; } } pct = m ? parseFloat(String(m[1]).replace(',', '.')) : 0; } catch(e) { pct = 0; }
                                                $s.data('percentage', pct);
                                                $s.attr('data-percentage', pct);
                                                var opt = new Option(txt, txt, true, true);
                                                $s.append(opt).trigger('change.select2');
                                            }
                                        });
                                    }
                                } catch(err) { console.warn('Failed to init lokasi select2 (KMP edit):', err); }
                                // Ensure table editable
                                $d.find('#btn-add-detail, #btn-clear-detail').show();
                            } else if (isKencana) {
                                // Keep Aksi column visible in revisi
                                var htmlRows = details.map(function(row){
                                    var lokasiText = String(row.biaya_lokasi||''); // keep percentage text e.g. "DKI (6%)"
                                    return '<tr>'+
                                      // Customer as select2 (ajax), preselect current value
                                      '<td><select class="form-select form-select-sm customer-select" style="width:100%" data-current="'+ ((row.cname_lname||'')+'') +'"></select></td>'+
                                      '<td><input type="text" class="form-control form-control-sm qty" value="'+ (row.qty||'') +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm price" value="'+ idr(row.price_liter) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm ppn" value="'+ idr(row.ppn) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm pbbkb" value="'+ idr(row.pbbkb) +'" /></td>'+
                                      '<td><input type="text" class="form-control form-control-sm total" value="'+ idr(row.total_price) +'" /></td>'+
                                      '<td><select class="form-select form-select-sm lokasi-select" style="width:100%" data-current="'+ (lokasiText||'') +'"></select></td>'+
                                      '<td><button type="button" class="btn btn-sm btn-danger btn-remove" style="border-radius:8px;">Hapus</button></td>'+
                                    '</tr>';
                                }).join('');
                                $tbody.html(htmlRows);
                                // Init select2 for lokasi dropdowns and preselect current value (same as create)
                                try {
                                    var $formRoot = $d.find('#sph-form');
                                    var $lokSelects = $d.find('#table-oat-lines tbody .lokasi-select');
                                    if ($.fn.select2 && $lokSelects.length) {
                                        $lokSelects.select2({
                                            dropdownParent: $formRoot,
                                            placeholder: 'Pilih Lokasi',
                                            allowClear: true,
                                            width: '100%',
                                            ajax: {
                                                url: '/api/master-lov/children',
                                                dataType: 'json', delay: 250,
                                                data: function(){ return { parent_code: 'LOKASI_MASTER' }; },
                                                processResults: function(data){
                                                    return { results: $.map(data, function(item){ return { id: item.id, text: item.code + ' ('+ item.value +'%)', percentage: item.value }; }) };
                                                }
                                            }
                                        });
                                        $lokSelects.each(function(){
                                            var $s = $(this);
                                            var txt = $s.data('current');
                                            if (txt) {
                                                // Extract percentage from text and store on element for reliable calc on edit
                                                var pct = 0; try { var m = String(txt).match(/(\d+[\.,]?\d*)\s*%/); if (!m){ var inParen = String(txt).match(/\(([^)]*)/); if (inParen){ var m2 = inParen[1].match(/(\d+[\.,]?\d*)/); if (m2) m = m2; } } pct = m ? parseFloat(String(m[1]).replace(',', '.')) : 0; } catch(e) { pct = 0; }
                                                $s.data('percentage', pct);
                                                $s.attr('data-percentage', pct);
                                                var opt = new Option(txt, txt, true, true);
                                                $s.append(opt).trigger('change.select2');
                                            }
                                        });
                                    }
                                    // Init select2 for customer dropdowns and preselect current name
                                    var $custSelects = $d.find('#table-oat-lines tbody .customer-select');
                                    if ($.fn.select2 && $custSelects.length) {
                                        $custSelects.select2({
                                            dropdownParent: $formRoot,
                                            placeholder: 'Pilih Customer',
                                            allowClear: true,
                                            width: '100%',
                                            minimumInputLength: 0,
                                            ajax: {
                                                url: '/api/get-customers',
                                                dataType: 'json', delay: 250,
                                                data: function(params){
                                                    return {
                                                        type: $d.find('#type_sph').val() || '',
                                                        q: params.term || ''
                                                    };
                                                },
                                                processResults: function(data){
                                                    var results = (data || []).map(function(item){
                                                        return { id: item.id, text: item.name };
                                                    });
                                                    return { results: results };
                                                }
                                            }
                                        });
                                        $custSelects.each(function(){
                                            var $s = $(this);
                                            var txt = $s.data('current');
                                            if (txt) {
                                                var opt = new Option(txt, txt, true, true);
                                                $s.append(opt).trigger('change.select2');
                                            }
                                        });
                                    }
                                } catch(err) { console.warn('Failed to init lokasi select2 (Kencana edit):', err); }
                                $d.find('#btn-add-detail, #btn-clear-detail').show();
                                // After DOM/Select2 ready, trigger recalculation in iframe
                                try { if ($d[0].defaultView && typeof $d[0].defaultView.recalcAllRows === 'function') { $d[0].defaultView.recalcAllRows(); } } catch(e) {}
                            } else {
                                // Non-KMP fallback: simple rows similar to before
                                var htmlRows = details.map(function(row){
                                    return '<tr>'+
                                      (row.cname_lname!=null? '<td>'+ row.cname_lname +'</td>' : '')+
                                      (row.qty!=null? '<td>'+ row.qty +'</td>' : '')+
                                      (row.price_liter!=null? '<td>'+ idr(row.price_liter) +'</td>' : '')+
                                      (row.ppn!=null? '<td>'+ idr(row.ppn) +'</td>' : '')+
                                      (row.pbbkb!=null? '<td>'+ idr(row.pbbkb) +'</td>' : '')+
                                      (row.total_price!=null? '<td>'+ idr(row.total_price) +'</td>' : '')+
                                      (row.biaya_lokasi!=null? '<td>'+ row.biaya_lokasi +'</td>' : '')+
                                    '</tr>';
                                }).join('');
                                if (htmlRows) $tbody.html(htmlRows);
                            }
                        }
                    } catch (err) { console.warn('Failed to render details rows (edit):', err); }
                    // Preselect Biaya Lokasi when exists (create template)
                    setSelectOrTextPersist('#biaya_lokasi', (header.biaya_lokasi || header.oat_lokasi || header.site_location || ''), 2500);
                    if ($d.find('#pbbkb_percentage').length) {
                        var pctValEdit = header.pbbkb_percentage || '';
                        if (!pctValEdit && (header.biaya_lokasi || header.pbbkb != null)) {
                            var bl = String(header.biaya_lokasi || '');
                            if (bl.indexOf('7.5') !== -1 || bl.indexOf('7,5') !== -1) pctValEdit = '7.5';
                            else if (bl.indexOf('10') !== -1 && bl.indexOf('7') === -1) pctValEdit = '10';
                            else if (bl.indexOf('5') !== -1) pctValEdit = '5';
                            else if (header.pbbkb != null && header.price_liter > 0) {
                                var pct = (parseFloat(header.pbbkb) / parseFloat(header.price_liter)) * 100;
                                if (Math.abs(pct - 7.5) < 1) pctValEdit = '7.5';
                                else if (Math.abs(pct - 10) < 1) pctValEdit = '10';
                                else if (Math.abs(pct - 5) < 1) pctValEdit = '5';
                            }
                        }
                        $d.find('#pbbkb_percentage').val(pctValEdit);
                    }
                    // Susut radio or dropdown default
                    var susutValEdit = (header.susut!=null)? String(header.susut): null;
                    if (susutValEdit){ $d.find('input[name="susut"][value="'+susutValEdit+'"]').prop('checked', true); }
                    if ($d.find('#susut').length && susutValEdit) { $d.find('#susut').val(susutValEdit); }
                    // Payment method default
                    setSelectOrTextPersist('#pay_method', header.payment || header.pay_method || '', 2500);
                } catch(e) { console.warn('Failed to inject edit data:', e); }
            });
            // Pass status=2 and sph_id for revisi to show remark history in iframe
            var urlObj = new URL(formUrl, window.location.origin);
            urlObj.searchParams.set('status', header.status || 2);
            urlObj.searchParams.set('sph_id', header.id || id);
            // ensure template_id is available for the iframe form
            if (header.template_id || templateId) {
                urlObj.searchParams.set('template_id', header.template_id || templateId);
            }
            // Also pass derived common header fields to help iframe prefill reliably
            if (header.tipe_sph) urlObj.searchParams.set('tipe', header.tipe_sph);
            if (header.company_id) urlObj.searchParams.set('company', header.company_id);
            if (header.comp_name) urlObj.searchParams.set('company_name', header.comp_name);
            // If status is revisi, rename submit button after load (do not remove edit handler)
            $('#formSphFrame').off('load.relabel').on('load.relabel', function(){
                try {
                    var doc2 = this.contentWindow || this.contentDocument;
                    if (doc2.document) doc2 = doc2.document;
                    var $d2 = $(doc2);
                    if ((header.status||2) === 2) {
                        $d2.find('#btn-submit-sph').text('Ajukan Kembali');
                    }
                } catch(e) {}
            });
            $('#formSphFrame').attr('src', urlObj.toString());
            $('#formSphModalTitle').text('Edit SPH');
            $('#formSphModal').modal('show');
        })
        .fail(function(){
            Swal.fire('Gagal', 'Tidak dapat memuat detail SPH.', 'error');
        });
    });

    // Open Create SPH modal
    $('#btn-create-sph').on('click', function(){
        $('#createSphModal').modal('show');
    });

    // Enhance selects with Select2 if available
    if ($.fn.select2) {
        $('#field-tipe').select2({
            dropdownParent: $('#createSphModal'),
            width: '100%',
            minimumResultsForSearch: 0
        });
        $('#field-company').select2({
            dropdownParent: $('#createSphModal'),
            width: '100%',
            placeholder: 'Pilih Customer',
            allowClear: true,
            minimumResultsForSearch: 0
        });
    }

    // Match create page logic: load companies by type
    $('#field-tipe').on('change', function(){
        var type = $(this).val();
        var $company = $('#field-company');
        $company.html('<option value="">Loading...</option>').trigger('change.select2');
        if (type) {
            $.get('/api/get-customers', { type: type }, function(data){
                $company.empty().append('<option value="">Pilih Customer</option>');
                (data||[]).forEach(function(item){
                    // Store template_id and form from company response
                    $company.append('<option value="'+ item.id +'" data-template-id="'+ (item.template_id || '') +'" data-form="'+ (item.form || '') +'">'+ item.name +'</option>');
                });
                $company.trigger('change.select2');
            });
        } else {
            $company.empty().append('<option value="">Pilih Customer</option>').trigger('change.select2');
        }
    });


    // Handle Pilih click
    $('#btn-modal-pilih').on('click', function(){
        var form = document.getElementById('create-sph-form');
        // Reset validity visuals
        $('#field-tipe, #field-company').removeClass('is-invalid');
        if (!form.checkValidity()) {
            // show invalid feedback on each empty field
            if (!$('#field-tipe').val()) $('#field-tipe').addClass('is-invalid');
            if (!$('#field-company').val()) $('#field-company').addClass('is-invalid');
            return;
        }
        var tipe = $('#field-tipe').val();
        var comp = $('#field-company').val();
        var $selectedCompany = $('#field-company option:selected');
        // Get template_id and form from selected company (not from template dropdown)
        var tmplId = $selectedCompany.data('template-id') || '';
        var tmplForm = $selectedCompany.data('form') || '';

        if (!tmplId || !tmplForm) {
            Swal.fire('Error', 'Template ID atau Form tidak ditemukan untuk company yang dipilih.', 'error');
            return;
        }

        // If we have a form name, open the corresponding view inside a modal iframe
        if (tmplForm) {
            // Build a URL to dynamic form route (same as before, but using form from company)
            var formUrl = '{{ route('sph.form.dynamic', ['form' => '___FORM___']) }}'
                .replace('___FORM___', encodeURIComponent(tmplForm))
                + '?tipe=' + encodeURIComponent(tipe)
                + '&company=' + encodeURIComponent(comp)
                + '&company_name=' + encodeURIComponent($selectedCompany.text())
                + '&template_id=' + encodeURIComponent(tmplId);
            // Clear any previous iframe event handlers from view/edit flows
            $('#formSphFrame').off();
            $('#formSphFrame').attr('src', formUrl);
            $('#formSphModalTitle').text('Form SPH - ' + tmplForm.toUpperCase());
            $('#formSphModal').modal('show');
            $('#createSphModal').modal('hide');
            return;
        }
        // fallback navigate
        var url = '{{ route('sph_create') }}' + '?tipe=' + encodeURIComponent(tipe) + '&company=' + encodeURIComponent(comp) + '&template_id=' + encodeURIComponent(tmplId);
        window.location.href = url;
    });

    // Clear validation when user changes a field
    $('#field-tipe, #field-company').on('change', function(){
        if ($(this).val()) $(this).removeClass('is-invalid');
    });

    // Reset form validation on open
    $('#createSphModal').on('shown.bs.modal', function(){
        $('#create-sph-form')[0].reset();
        $('#field-tipe, #field-company').removeClass('is-invalid').trigger('change.select2');
    });
});
</script>
<script>
    // --- PENAMBAHAN: Pencegahan submit ganda pada form Good Receipt (submit event) ---
    // Asumsikan Anda punya form dengan id #formTerimaPO dan tombol #btnSimpanPO (ubah sesuai kebutuhan)
    $('#formTerimaPO').off('submit').on('submit', function(e){
        console.log('[DEBUG] Submit Good Receipt Triggered');
        e.preventDefault();

        var $btn = $('#btnSimpanPO');
        // Tambahkan spinner segera setelah $btn dideklarasikan
        $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
        if ($btn.prop('disabled')) {
            console.warn('[DEBUG] Tombol submit sedang dalam proses, abaikan klik ganda.');
            return;
        }
        // Ganti baris spinner di bawah ini sesuai instruksi
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');

        // ...AJAX logic Anda di sini, contoh:
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(res) {
                // Sukses, tutup modal/dll
                $('#modalAddGoodReceipt').modal('hide');
                Swal.fire('Berhasil!', res.message || 'Berhasil menambahkan ke Good Receipt!', 'success');
                // Refresh list/table jika perlu
            },
            error: function(xhr) {
                Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal menambahkan!', 'error');
            }
        }).always(function(){
            $btn.prop('disabled', false).html('Simpan');
        });
    });
</script>
@endsection
