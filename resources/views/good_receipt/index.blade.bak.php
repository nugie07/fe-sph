@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
#modalTerimaPO .modal-content {
  border-radius: 20px;
  position: relative;
}
/* Modal loading overlay & blur */
#modalTerimaPO .modal-loading-backdrop {
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  width: 100%; height: 100%;
  background: rgba(255,255,255,0.7);
  z-index: 2000;
  display: none;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(6px);
  border-radius: 20px;
}
#modalTerimaPO.loading .modal-content > .modal-body,
#modalTerimaPO.loading .modal-content > .modal-header,
#modalTerimaPO.loading .modal-content > .modal-footer {
  filter: blur(3px);
  pointer-events: none;
  user-select: none;
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

<!-- Modal Terima PO -->
<div class="modal fade" id="modalTerimaPO" tabindex="-1" aria-labelledby="modalTerimaPOLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form id="formTerimaPO" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="modalTerimaPOLabel">Buat Invoice Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4 py-3">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="fw-bold small">Kode SPH</div>
              <div id="modal-sph-code"></div>
            </div>
            <div class="col-sm-6">
              <div class="fw-bold small">Nama Customer / Client</div>
              <div id="modal-customer"></div>
            </div>
          </div>
          <div class="mb-3">
            <label class="fw-bold small">Upload PO (PDF Only) <span class="text-danger">(*maks 2mb)</span></label>
            <input type="file" class="form-control" id="file" name="file" accept="application/pdf" required>
          </div>
          <div class="mb-2">
            <label class="fw-bold small">View PO</label>
            <div id="pdfViewer" style="border: 1px solid #ddd; height: 500px; overflow: auto; display: none;">
			<iframe id="pdfFrame" src="" width="100%" height="100%" frameborder="0"></iframe>
			</div>
          </div>
          <div class="mb-2">
            <label class="fw-bold small">Masukan Nomer PO Customer <span class="text-danger">(*Pastikan Nomer PO Sesuai)</span></label>
            <input type="text" name="po_no" id="modal-po-no" class="form-control" required minlength="3" autocomplete="off" style="border:1px solid #495057; box-shadow:none;">
            <div class="form-text">Minimal 3 karakter.</div>
          </div>
          <div class="mb-2">
            <label class="fw-bold small">Purchase Order List <span class="text-danger">(*Pastikan item dari PO sudah sesuai)</span></label>
            <table class="table table-bordered" id="modal-po-items-table">
              <thead class="bg-primary text-white">
                <tr>
                  <th>NO</th>
                  <th>Nama Item</th>
                  <th>Quantity</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddPOItem" style="border-radius:8px;">Tambah Item</button>
          </div>
          <div class="row">
            <div class="col-sm-8 text-end fw-bold">Sub Total:</div>
            <div class="col-sm-4"><span id="po-subtotal">0</span></div>
            <div class="col-sm-8 text-end fw-bold">PPN 11%:</div>
            <div class="col-sm-4"><span id="po-ppn">0</span></div>
            <div class="col-sm-8 text-end fw-bold">PBBKB 7.5%:</div>
            <div class="col-sm-4"><span id="po-pbbkb">0</span></div>
            <div class="col-sm-8 text-end fw-bold">PPH 23 2%:</div>
            <div class="col-sm-4"><span id="po-pph">0</span></div>
            <div class="col-sm-8 text-end fw-bold">Total Tagihan:</div>
            <div class="col-sm-4"><span id="po-total">0</span></div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <span>Terbilang :</span>
              <span id="po-terbilang" class="fw-bold"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:8px;">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btnSimpanPO" style="border-radius:8px;">Simpan</button>
        </div>
      </form>
      <!-- Loading overlay -->
      <div class="modal-loading-backdrop" id="modalTerimaPOLoading">
        <div>
          <div class="spinner-border text-primary" style="width:3rem;height:3rem;"></div>
          <div class="mt-2 fw-bold text-primary">Memuat detail...</div>
        </div>
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
let CURRENT_PO_ID = null;
$(function(){
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
        return `<span class="badge bg-secondary px-3 py-2 border border-2 border-dark"
        style="font-size:14px; border-radius:8px; background-color:#f8f9fa; color:#333; display:inline-block; min-width:80px; text-align:center;">
        ${item.po_no}
        </span>`;
    }
    return `<span class="badge bg-primary px-3 py-2 border border-2 border-dark"
        style="font-size:14px; cursor:pointer; border-radius:8px; display:inline-block; min-width:80px; text-align:center;"
        data-po-id="${item.po_id}"
        data-kode-sph="${item.kode_sph||''}"
        data-nama-customer="${item.comp_name||''}"
        id="btnTerimaPO_${item.po_id}">
        Terima PO
    </span>`;
}
function renderFileBtn(item) {
    if (item.po_file && item.po_file.trim()) {

        const publicUrl = `https://is3.cloudhost.id/bensinkustorage/${item.po_file}`;
        return `<a href="#" class="badge bg-info px-3 py-2 border border-2 border-dark btn-view-pdf"
                    data-public-url="${publicUrl}"
                    style="font-size:14px; border-radius:8px; background-color:#e3f2fd; color:#fff; display:inline-block; min-width:80px; text-align:center;">
                    Download PO
                </a>`;
    } else {
        return `<span class="badge bg-danger ...">Tidak ada File</span>`;
        `<span class="badge bg-danger px-3 py-2 border border-2 border-dark"
                    style="font-size:14px; border-radius:8px; background-color:#fdecea; color:#fff; display:inline-block; min-width:80px; text-align:center;">
                    Tidak ada File
                    </span>`;
    }
}
function fetchList(){
    table.clear();
    $.get('/api/good-receipts/list')
    .done(function(res){
        $('#card-total_sph').text(res.cards.total_sph);
        $('#card-waiting').text(res.cards.waiting);
        $('#card-revisi').text(res.cards.received);

        var rows = res.data.map(function(item){
            return [
                item.tipe_sph ?? '-',
                item.kode_sph ?? '-',
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

// Klik "Terima PO" badge
$(document).on('click', '.badge.bg-primary', function(){
    const po_id = $(this).data('po-id');
    if (!po_id) return;
    CURRENT_PO_ID = po_id;
    $('#formTerimaPO').trigger('reset');
    $('#modal-po-items-table tbody').html('');
    $('#modal-sph-code, #modal-customer, #modal-view-po, #po-subtotal, #po-ppn, #po-pbbkb, #po-pph, #po-total, #po-terbilang').text('0');

    // Tampilkan modal lebih dulu, lalu loading overlay
    $('#modalTerimaPO').modal('show');
    $('#modalTerimaPO').addClass('loading');
    $('#modalTerimaPOLoading').show();

    $.get('/api/good-receipts/'+po_id+'/detail', function(res){
        $('#modal-sph-code').text(res.kode_sph || '-');
        $('#modal-customer').text(res.nama_customer || '-');

        if(res.items && res.items.length){
            res.items.forEach((item, idx)=>{
                addPOItemRow(idx+1, item.nama_item, item.qty, item.per_item, item.total_harga);
            });
        } else {
            addPOItemRow(1, '', 0, 0, 0);
        }
    }).always(function(){
        $('#modalTerimaPO').removeClass('loading');
        $('#modalTerimaPOLoading').hide();
    });
});

function addPOItemRow(no, nama='', qty=0, harga=0, jumlah=0){
    let html = `<tr>
        <td class="text-center align-middle">${no}</td>
        <td><input type="text" class="form-control po-item-nama" value="${nama}" style="border:1px solid #495057;"></td>
        <td><input type="number" min="0" class="form-control po-item-qty" value="${qty}" style="border:1px solid #495057;"></td>
        <td><input type="number" min="0" class="form-control po-item-harga" value="${harga}" style="border:1px solid #495057;"></td>
        <td class="po-item-jumlah text-center align-middle">${jumlah}</td>
        <td><button type="button" class="btn btn-danger btnRemovePOItem" style="border-radius:8px;">&times;</button></td>
    </tr>`;
    $('#modal-po-items-table tbody').append(html);
    updatePOCalc();
}
$(document).on('click', '#btnAddPOItem', function(){
    let count = $('#modal-po-items-table tbody tr').length+1;
    addPOItemRow(count);
});
$(document).on('click', '.btnRemovePOItem', function(){
    $(this).closest('tr').remove();
    updatePOCalc();
});
$(document).on('input', '.po-item-qty, .po-item-harga', function(){
    let $tr = $(this).closest('tr');
    let qty = parseFloat($tr.find('.po-item-qty').val()) || 0;
    let harga = parseFloat($tr.find('.po-item-harga').val()) || 0;
    $tr.find('.po-item-jumlah').text(qty*harga);
    updatePOCalc();
});
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
function updatePOCalc(){
let subtotal = 0;
$('#modal-po-items-table tbody tr').each(function(){
    let harga = parseFloat($(this).find('.po-item-harga').val()) || 0;
    let qty = parseFloat($(this).find('.po-item-qty').val()) || 0;
    subtotal += qty * harga;
});
let ppn    = subtotal * 0.11,
    pbbkb  = subtotal * 0.075,
    pph    = subtotal * 0.02,
    total  = subtotal + ppn + pbbkb + pph;

$('#po-subtotal').text(subtotal.toLocaleString('id-ID'));
$('#po-ppn').text(ppn.toLocaleString('id-ID'));
$('#po-pbbkb').text(pbbkb.toLocaleString('id-ID'));
$('#po-pph').text(pph.toLocaleString('id-ID'));
$('#po-total').text(total.toLocaleString('id-ID'));
$('#po-terbilang').text(subtotal === 0 ? '' : formatTerbilang(total));
}

    fetchList();

    // Refresh DataTable ketika modal benar-benar tertutup (setelah simpan/close)
    $('#modalTerimaPO').on('hidden.bs.modal', function () {
        console.log('Modal closed! Fetching list...');
        fetchList();
    });

    // Handle Submit or Save
    $('#formTerimaPO').on('submit', function(e){
        e.preventDefault();
        var $btn = $('#btnSimpanPO');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Sedang menyimpan...');

        var form = this;
        var formData = new FormData(form);

        // Items, serialisasi sebagai JSON string
        var items = [];
        $('#modal-po-items-table tbody tr').each(function(idx){
            var nama = $(this).find('.po-item-nama').val().trim();
            var qty  = parseFloat($(this).find('.po-item-qty').val()) || 0;
            var per  = parseFloat($(this).find('.po-item-harga').val()) || 0;
            var tot  = qty * per;
            items.push({ nama_item: nama, qty: qty, per_item: per, total_harga: tot });
        });

        // Hapus dulu jika sudah ada field items (jaga-jaga)
        formData.delete('items');
        // Tambahkan items sebagai JSON string
        formData.append('items', JSON.stringify(items));

        // Field numeric lain (pastikan up to date, replace/append saja)
        formData.set('po_no', $('#modal-po-no').val().trim());
        formData.set('sub_total', parseFloat($('#po-subtotal').text().replace(/\./g,'')) || 0);
        formData.set('ppn', parseFloat($('#po-ppn').text().replace(/\./g,'')) || 0);
        formData.set('pbbkb', parseFloat($('#po-pbbkb').text().replace(/\./g,'')) || 0);
        formData.set('pph', parseFloat($('#po-pph').text().replace(/\./g,'')) || 0);
        formData.set('total', parseFloat($('#po-total').text().replace(/\./g,'')) || 0);
        formData.set('terbilang', $('#po-terbilang').text().trim());
        formData.set('status', 1);

        $.ajax({
            url: '/api/good-receipts/' + CURRENT_PO_ID + '/update',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
        })
        .done(function(res){
            $('#modalTerimaPO').modal('hide');
            // Tidak perlu fetchList() di sini, cukup saat modal tertutup saja.
            alert(res.message || 'Berhasil disimpan');
        })
        .fail(function(xhr){
            alert(xhr.responseJSON?.message || 'Gagal menyimpan!');
        })
        .always(function(){
            $btn.prop('disabled', false).text('Simpan');
        });
    });

});
</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file');
        const pdfViewer = document.getElementById('pdfViewer');
        const pdfFrame = document.getElementById('pdfFrame');
        const uploadModal = document.getElementById('uploadModal');

        // Event listener untuk menampilkan PDF saat file diunggah
        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file && file.type === 'application/pdf') {
                const fileURL = URL.createObjectURL(file);
                pdfFrame.src = fileURL;
                pdfViewer.style.display = 'block';
            } else {
                // Reset input jika file bukan PDF
                alert('Hanya file PDF yang diperbolehkan.');
                fileInput.value = ''; // Reset input file
                pdfFrame.src = '';
                pdfViewer.style.display = 'none';
            }
        });

        // Event listener untuk menyembunyikan PDF viewer saat modal ditutup
        modalTerimaPO.addEventListener('hidden.bs.modal', function () {
            pdfFrame.src = ''; // Reset src iframe
            pdfViewer.style.display = 'none'; // Sembunyikan viewer
            fileInput.value = ''; // Reset input file
        });
    });
</script>
<script>
$(document).on('click', '.btn-view-pdf', function(e){
    e.preventDefault();
    const publicUrl = $(this).data('public-url');
    if (!publicUrl) {
        alert('File tidak ditemukan!');
        return;
    }
    $('#pdfViewerFrame').attr('src', publicUrl);
    $('#pdfModal').modal('show');
});
$('#pdfModal').on('hidden.bs.modal', function(){
    $('#pdfViewerFrame').attr('src', '');
});
</script>
@endsection
