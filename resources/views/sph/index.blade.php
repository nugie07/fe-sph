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
      <div class="modal-header">
        <h5 class="modal-title">Lihat Dokumen SPH (PDF)</h5>
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
                switch(item.status){
                    case 1:
                        statusHtml = `<span class="badge bg-info badge-status-remark"
                            title="${item.workflow||''}"
                            style="cursor:pointer;" data-sph-id="${item.id}">Menunggu Approval</span>`;
                        actionHtml +=
                            `<i class="fa fa-trash text-danger fa-md" title="Cancel SPH" data-sph-id="${item.id}"
                            style="cursor:pointer;font-size:1.25em;"></i> <span class="text-danger fw-bold ms-1" style="font-size:0.8em;">Cancel</span>`;
                        break;
                    case 2:
                        statusHtml = `<span class="badge bg-warning badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">Revisi</span>
                            <span class="badge bg-primary text-white ms-1"><i class="fa fa-pencil"></i> Revisi</span>`;
                        actionHtml +=
                            `<i class="fa fa-trash text-danger fa-md" title="Cancel SPH" data-sph-id="${item.id}"
                            style="cursor:pointer;font-size:1.25em;"></i><span class="text-danger fw-bold ms-1" style="font-size:0.8em;">Cancel</span>`;
                        break;
                    case 3:
                        statusHtml = `<span class="badge bg-danger badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">Reject</span>`;
                        actionHtml +=
                            `<i class="fa fa-trash text-danger fa-md" title="Cancel SPH" data-sph-id="${item.id}"
                            style="cursor:pointer;font-size:1.25em;"></i> <span class="text-danger fw-bold ms-1" style="font-size:1em;">Cancel</span>`;
                        break;
                    case 4:
                        statusHtml = `<span class="badge bg-success badge-status-remark"
                            data-sph-id="${item.id}" style="cursor:pointer;">Approved</span>`;
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

                        // Check permission for Add GR button
                        @if(PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.gr', 'sph.o.menu'))
                        actionHtml += `<i class="fa fa-plus-circle text-success fa-md btn-add-gr"
                                title="Tambahkan ke Good Receipt"
                                data-sph-id="${item.id}"
                                style="cursor:pointer;font-size:1.25em;"></i>&nbsp;&nbsp;`;
                        @endif
                        break;
                    default:
                        statusHtml = item.status;
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
        $('#pdfViewerModal').modal('show');
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
});
</script>
<script>
    let selectedSphId = null;

    $(document).on('click', '.btn-add-gr', function() {
        selectedSphId = $(this).data('sph-id');
        $('#modalAddGoodReceipt').modal('show');
    });

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
