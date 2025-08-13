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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
          <p class="text-center py-4">Data PO Supplier belum tersedia.</p>
        </div>
        {{-- PO Transporter --}}
        <div class="tab-pane fade" id="tab-po-trans" role="tabpanel">
          <p class="text-center py-4">Data PO Transporter belum tersedia.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Confirmation -->
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal" style="border-radius: 0.5rem !important;">Tutup</button>
        <button type="button" class="btn btn-success rounded-3 px-4" id="btnSaveApproval" style="border-radius: 0.5rem !important;">Simpan</button>
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

  <script>
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
        // Add restrict parameter based on permission
        var restrictParam = '';
        @if(PermissionHelper::hasActionAccess('sph.menu', 'sph.o.act.restrict', 'sph.o.menu') == 1)
        restrictParam = '&restrict=1';
        @else
        restrictParam = '&restrict=0';
        @endif

        $.get('/api/sph/list?status=approvallist' + restrictParam)
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

      // Handler untuk klik Confirmation badge
      $(document).on('click', '.confirmation-btn', function(){
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

        // Load remark riwayat via API
        $.get(`/api/sph/${sphId}/remarks`)
          .done(function(data){
            if (!data.length) {
              $('#remarkHistory').html('<li class="text-muted">Belum ada remark</li>');
              return;
            }
            var html = data.map(function(r){
              let color = 'primary';
              let uname = r.last_updateby || 'User';
              if ((uname||'').toLowerCase().includes('approve')) color = 'success';
              if ((uname||'').toLowerCase().includes('reject')) color = 'danger';
              return `<li class="mb-2 pb-2 border-bottom">
                <span class="fw-bold text-${color}">• ${uname}</span> -
                <span>${r.wf_comment||''}</span>
                <span class="text-muted ms-2 small">(${r.created_at||''})</span>
              </li>`;
            }).join('');
            $('#remarkHistory').html(html);
          })
          .fail(function(){
            $('#remarkHistory').html('<li class="text-danger">Gagal memuat riwayat.</li>');
          });

        $('#modalConfirmation').modal('show');
      });

      // Handler tombol Simpan di modal
      $(document).on('click', '#btnSaveApproval', function() {
        var sphId = $('#modalConfirmation').data('sph-id');
        var status = $('input[name="approval_status"]:checked').val();
        var comment = $('#approvalComment').val().trim();

        if (!status) {
          alert('Pilih status Approve/Revisi/Reject.');
          return;
        }
        if (!comment) {
          alert('Isi komentar wajib diisi.');
          $('#approvalComment').focus();
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
            alert(res.message);
            $('#modalConfirmation').modal('hide');
            $btn.prop('disabled', false).html('Simpan');
            fetchSph();
          },
          error: function(xhr) {
            alert(xhr.responseJSON?.message || 'Gagal simpan!');
            $btn.prop('disabled', false).html('Simpan');
          }
        });
      });

    });
  </script>
@endsection
