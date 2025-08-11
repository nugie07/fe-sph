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

  <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center">
    <!-- Export XLSX -->
    <div class="ms-auto">

    </div>
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
        <h5 class="modal-title">Konfirmasi Penghapusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan menghapus data ini?<br>
        <small class="text-danger">Relasi data akan dihapus dan tidak dapat dikembalikan.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning rounded" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger rounded" id="confirmDeleteBtn">Ya, Hapus</button>
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

  // 2) Fetch & render
  function fetchSph(){
    console.log('🌐 GET /api/sph/list');
    table.clear().draw();
    $('#basic-1 tbody').html(
      '<tr><td colspan="11" class="text-center py-4">'+
        '<div class="spinner-border text-primary" role="status"></div>'+
        ' <span>Loading...</span>'+
      '</td></tr>'
    );

    $.get('/api/sph/list')
      .done(function(res){
        console.log('✅ response:', res);

        // update cards
        $('#card-total_sph').text(res.cards.total_sph);
        $('#card-waiting').text(res.cards.waiting);
        $('#card-revisi').text(res.cards.revisi);
        $('#card-approved_reject').text(res.cards.approved + ' | ' + res.cards.reject);

        // build row arrays
        var rows = res.data.map(function(item){
          // workflow badge
          var statusHtml;
          switch(item.status){
            case 1:
              statusHtml = `<span class="badge bg-info" title="${item.workflow||''}" style="cursor:help;">Menunggu Approval</span>`;
              break;
            case 2:
              statusHtml = `<span class="badge bg-warning">Revisi</span>
                <i class="fa fa-exclamation-circle text-danger ms-2 fa-md" title="Lakukan Revisi" style="cursor:pointer;font-size:1.25em;"></i>`;
              break;
            case 3:
              statusHtml = `<span class="badge bg-danger">Reject</span>`;
              break;
            case 4:
              statusHtml = `<span class="badge bg-success">Approved</span>`;
              break;
            default:
              statusHtml = item.status;
          }
          // action icons (both get data-sph-id)
          var actionHtml =
            `<i class="fa fa-comment text-primary me-2 fa-md"
                title="Remark"
                data-sph-id="${item.id}"
                style="cursor:pointer;font-size:1.25em;"></i>` +
            `<i class="fa fa-trash text-danger fa-md"
                title="Delete"
                data-sph-id="${item.id}"
                style="cursor:pointer;font-size:1.25em;"></i>`;

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

        // render to table
        table.clear().rows.add(rows).draw();
        $('[title]').tooltip({ trigger: 'hover' });
      })
      .fail(function(){
        console.error('❌ Failed to load /api/sph/list');
        table.clear().draw();
        $('#basic-1 tbody').html(
          '<tr><td colspan="11" class="text-center text-danger py-4">'+
            'Gagal memuat data SPH.'+
          '</td></tr>'
        );
      });
  }

  // 3) Remark modal
  $(document).on('click', '.fa-comment', function(){
    var sphId = $(this).data('sph-id');
    console.log('🔍 Load remarks for SPH=', sphId);
    $('#remarkModal').modal('show');
    $('#remark-table tbody').html(
      '<tr><td colspan="3" class="text-center py-3">'+
        '<div class="spinner-border text-primary" role="status"></div>'+
        ' <span>Loading remarks…</span></td></tr>'
    );
    $.get(`/api/sph/${sphId}/remarks`)
      .done(function(remarks){
        var html = remarks.length
          ? remarks.map((r,i)=>`<tr>
              <td>${i+1}</td>
              <td>${r.wf_comment}</td>
              <td>${r.created_at}</td>
            </tr>`).join('')
          : '<tr><td colspan="3" class="text-center">Tidak ada remark</td></tr>';
        $('#remark-table tbody').html(html);
      })
      .fail(function(){
        $('#remark-table tbody').html(
          '<tr><td colspan="3" class="text-center text-danger">Gagal memuat remark.</td></tr>'
        );
      });
  });

  // 4) Delete flow
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
        fetchSph();
        alert(res.message);
      },
      error: function(xhr){
        alert('Gagal menghapus: ' + (xhr.responseJSON?.message||xhr.statusText));
        $('#confirmDeleteModal').modal('hide');
        $('#confirmDeleteBtn').prop('disabled', false).text('Ya, Hapus');
      }
    });
  });

  // 5) Rupiah formatter
  function formatRupiah(x){
    x = parseFloat(x)||0;
    return 'Rp ' + x.toLocaleString('id-ID',{minimumFractionDigits:2});
  }

  // Initial load
  fetchSph();
});
</script>
@endsection
