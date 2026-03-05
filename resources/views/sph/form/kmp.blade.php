@extends('layout.template')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
@endsection

@section('main_content')
<div class="container-fluid">

  <div class="container-fluid form-validate">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4>Form SPH</h4><span class="mt-2">Form ini hanya digunakan untuk PT KMP</span>
          </div>
          <div class="card-body">
            <form class="needs-validation" id="sph-form" novalidate>
            <input type="hidden" name="template_id" id="template_id">
              <!-- Baris 1 -->
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label">Tipe SPH</label>
                  <input type="text" class="form-control" name="type_sph" id="type_sph" readonly required>

                  <div class="invalid-feedback">Type SPH is required.</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Nama Customer</label>
                  <input type="text" class="form-control" name="comp_name" id="comp_name" readonly required>
                  <div class="invalid-feedback">Company Name is required.</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Kode SPH</label>
                  <input type="text" class="form-control" name="kode_sph" id="kode_sph" readonly required>
                  <div class="invalid-feedback">Kode SPH is required.</div>
                </div>
              </div>

              <!-- Baris 2 -->
              <div class="row g-3">
                <div class="col-md-3">
                  <label class="form-label">PIC</label>
                  <input type="text" class="form-control" name="pic" id="pic" required>
                  <div class="invalid-feedback">PIC is required.</div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Contact No</label>
                  <input type="text" class="form-control" name="contact_no" id="contact_no" required>
                  <div class="invalid-feedback">Contact No is required.</div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Email</label>
                  <input type="text" class="form-control" name="email" id="email" required>
                  <div class="invalid-feedback">Email is required.</div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Product</label>
                  <select class="form-select select2" name="product" id="product" required>
                    <option value="">Pilih Product</option>
                  </select>
                  <div class="invalid-feedback">Product is required.</div>
              </div>

                <!-- Header & Detail (Static Table) -->
              <div class="row g-3 mt-3">
                <div class="col-md-12">
                  <label class="form-label fw-bold fs-5 mb-0">Detail OAT per Customer</label>
                </div>

                <div class="col-md-12">
                  <!-- Tabel Lokasi Kalsel -->
                  <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle" id="table-oat-lines-kalsel">
                      <thead class="table-light">
                        <tr>
                          <th style="min-width:200px;">Lokasi Kalsel</th>
                          <th style="min-width:90px;">Qty / KL</th>
                          <th style="min-width:140px;">Harga Dasar</th>
                          <th style="min-width:120px;">PPN</th>
                          <th style="min-width:140px;">Total</th>
                          <th style="min-width:140px;">Transport</th>
                          <th style="min-width:160px;">Grand Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Lokasi Kalsel -->
                        <tr data-lokasi="Kalsel" data-nama="Sesulung Estate" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Sesulung Estate</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalsel"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="1000"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalsel" data-nama="Sesulung Estate" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalsel"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="850"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalsel" data-nama="Desa Betung" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Desa Betung</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalsel"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="900"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalsel" data-nama="Desa Betung" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalsel"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="750"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <!-- Tabel Lokasi Kalteng -->
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="table-oat-lines-kalteng">
                      <thead class="table-light">
                        <tr>
                          <th style="min-width:200px;">Lokasi Kalteng</th>
                          <th style="min-width:90px;">Qty / KL</th>
                          <th style="min-width:140px;">Harga Dasar</th>
                          <th style="min-width:120px;">PPN</th>
                          <th style="min-width:140px;">Total</th>
                          <th style="min-width:140px;">Transport</th>
                          <th style="min-width:160px;">Grand Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Lokasi Kalteng -->
                        <tr data-lokasi="Kalteng" data-nama="Pundu Pantai Harapan" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Pundu Pantai Harapan</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="800"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Pundu Pantai Harapan" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="674"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Gunung Mas KHS" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Gunung Mas KHS</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="700"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Gunung Mas KHS" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="600"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Mustika Sembuluh" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Mustika Sembuluh</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="1000"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Mustika Sembuluh" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="850"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Desa Amin" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Desa Amin</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="1000"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Desa Amin" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="850"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Gunung Makmur" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Gunung Makmur</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="880"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Gunung Makmur" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="760"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Simpang Seluncing" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">Simpang Seluncing</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="830"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                        <tr data-lokasi="Kalteng" data-nama="Simpang Seluncing" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0" data-lokasi-type="Kalteng"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm transport" placeholder="0" value="700"></td>
                          <td><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Susut, Payment, Tanggal Berlaku -->
              <div class="row g-3 mt-2">
                <div class="col-md-3">
                  <label class="form-label">Toleransi Susut</label>
                  <select class="form-select" name="susut" id="susut" required>
                    <option value="">Pilih toleransi susut</option>
                    <option value="0.1">0.1</option>
                    <option value="0.2">0.2</option>
                    <option value="0.3">0.3</option>
                    <option value="0.4">0.4</option>
                    <option value="0.5">0.5</option>
                  </select>
                  <div class="invalid-feedback">Toleransi Susut is required.</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Payment Method</label>
                  <select class="form-select select2" name="pay_method" id="pay_method" required></select>
                  <div class="invalid-feedback">Payment Method is required.</div>
                </div>
                <div class="col-md-5">
                  <label class="form-label">Tanggal Berlaku</label>
                  <input type="text" class="form-control" name="note_berlaku" id="note_berlaku" readonly>
                  <div class="invalid-feedback">Tanggal Berlaku is required.</div>
                </div>
              </div>

              <!-- Workflow History (shown when status = 2 / revisi) -->
              <div id="remark-history" class="mt-4" style="display:none;">
                <h5 class="mb-2">Workflow History</h5>
                <div class="table-responsive">
                  <table class="table table-bordered" id="remark-history-table">
                    <thead>
                      <tr>
                        <th style="width:60px;">No</th>
                        <th>Pengisi</th>
                        <th>Remark</th>
                        <th style="width:180px;">Dibuat Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <button id="btn-submit-sph" class="btn btn-primary mt-4 rounded" type="submit">Create SPH</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        // Prefill from query params if present (when form opened in iframe)
        const urlParams = new URLSearchParams(window.location.search);
        const isView = urlParams.get('view') === '1';
        const passedTipe = urlParams.get('tipe') || '';
        const passedCompanyId = urlParams.get('company') || '';
        const passedCompanyName = urlParams.get('company_name') || '';
        const passedTemplateId = urlParams.get('template_id') || '';
        const passedStatus = parseInt(urlParams.get('status') || '0', 10);
        const passedSphId = urlParams.get('sph_id') || '';

        if (passedTemplateId) {
            $('#template_id').val(passedTemplateId);
        }
        if (passedTipe) {
            $('#type_sph').val(passedTipe).prop('readonly', true);
        }
        if (passedCompanyName) {
            // When we receive name directly, set text input; if your form uses select, replace accordingly
            $('#comp_name').val(passedCompanyName).prop('readonly', true);
        }

        // If type and company id provided, generate kode_sph via API detail same as original code
        (function autoGenerateKode(){
            const today = new Date();
            const year = today.getFullYear();
            if (passedCompanyId) {
                $.get('/api/get-customer-detail', { id: passedCompanyId }, function(data) {
                    const romawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][today.getMonth() + 1];
                    const periode = today.getDate() <= 14 ? 'P1' : 'P2';
                    $('#kode_sph').val(`${data.cust_code||''}/${data.alias||''}/${data.type||''}/${romawi}/${periode}/${year}`);
                    $('#pic').val(data.pic_name || ''); $('#email').val(data.email || ''); $('#contact_no').val(data.pic_contact || '');
                    if (data.susut != null && data.susut !== '') { var s = String(data.susut).trim(); if (s === '05') s = '0.5'; $('#susut').val(s); }
                    else $('#susut').val('');
                    if (data.payment != null && data.payment !== '') {
                        var $pm = $('#pay_method');
                        var payText = String(data.payment).trim();
                        if ($pm.find('option').filter(function(){ return $(this).text() === payText; }).length) $pm.val($pm.find('option').filter(function(){ return $(this).text() === payText; }).val()).trigger('change');
                        else { $pm.append(new Option(payText, payText, true, true)).trigger('change'); }
                    }
                });
            }
        })();

        // View-mode hardening: hide action buttons and disable form controls
        if (isView) {
            $('#sph-form').find('input, select, textarea').prop('disabled', true).attr('readonly', true);
            $('#sph-form').find('button[type="submit"]').hide();
        }
        // Revisi: show remark history and relabel submit button
        if (passedStatus === 2 && passedSphId) {
            $('#remark-history').show();
            $('#btn-submit-sph').text('Ajukan Kembali');
            const $tbody = $('#remark-history-table tbody');
            $tbody.html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
            $.get(`{{ url('/api/remarks') }}/${encodeURIComponent(passedSphId)}?tipe_trx=sph`)
            .done(function(remarks){
                if (!Array.isArray(remarks) || remarks.length === 0){
                    $tbody.html('<tr><td colspan="4" class="text-center">Tidak ada remark</td></tr>');
                    return;
                }
                const rows = remarks.map(function(r, i){
                    const created = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID', {year:'numeric', month:'long', day:'numeric'}) : '';
                    return `<tr>
                        <td>${i+1}</td>
                        <td>${r.user||''}</td>
                        <td>${r.comment||''}</td>
                        <td>${created}</td>
                    </tr>`;
                }).join('');
                $tbody.html(rows);
            })
            .fail(function(){
                $tbody.html('<tr><td colspan="4" class="text-center text-danger">Gagal memuat remark</td></tr>');
            });
        }
        const PPN_PERCENT = {{ env('PPN', 11) }};

        // Fungsi untuk memformat angka menjadi format mata uang Rupiah dengan 2 desimal
        function formatRupiah(angka) {
            // Menggunakan Intl.NumberFormat untuk performa dan akurasi yang lebih baik
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(angka || 0);
        }

        // Fungsi untuk mendapatkan nilai numerik dari format Rupiah
        // Menangani format Indonesia: "Rp 14.500,00" atau "14.500,00" atau "14.500"
        function parseRupiah(stringRupiah) {
            if (!stringRupiah) return 0;
            
            let str = String(stringRupiah).trim();
            
            // Hapus "Rp" dan spasi
            str = str.replace(/Rp\s*/gi, '').trim();
            
            // Jika ada koma, berarti ada desimal (format: "14.500,00")
            if (str.includes(',')) {
                const parts = str.split(',');
                const integerPart = parts[0].replace(/\./g, ''); // Hapus titik (pemisah ribuan)
                const decimalPart = parts[1] || '00';
                return parseFloat(integerPart + '.' + decimalPart) || 0;
            } else {
                // Jika tidak ada koma, hapus titik dan parse sebagai integer
                // Format: "14.500" atau "14500"
                str = str.replace(/\./g, '');
                return parseFloat(str) || 0;
            }
        }

        // Fungsi utama untuk menghitung total
        function calculateTotal() {
            const priceLiter = parseFloat($('#price_liter_hidden').val()) || 0;
            const ppn = priceLiter * PPN_PERCENT / 100;
            const oat = parseFloat($('#oat_hidden').val()) || 0;
            const ppnOat = oat * PPN_PERCENT / 100;
            const total = priceLiter + ppn + oat + ppnOat;

            $('#ppn_display').val(formatRupiah(ppn));
            $('#ppn_hidden').val(ppn.toFixed(2));
            $('#ppn_oat_display').val(formatRupiah(ppnOat));
            $('#ppn_oat_hidden').val(ppnOat.toFixed(2));
            $('#total_price_display').val(formatRupiah(total));
            $('#total_price_hidden').val(total.toFixed(2));
        }

        // --- Event Listeners ---

        // Input harga dasar: parse dan simpan; format hanya saat blur agar koma (,) bisa dipakai
        $('#price_liter_display').on('input', function(e) {
            let rawValue = parseRupiah($(this).val());
            $('#price_liter_hidden').val(rawValue);
            calculateTotal();
        });
        $('#price_liter_display').on('blur', function() {
            let rawValue = parseRupiah($(this).val());
            $('#price_liter_hidden').val(rawValue);
            $(this).val(formatRupiah(rawValue));
            calculateTotal();
        });

        // Event listener untuk produk
        $('#product').on('change', function() {
            const price = $(this).find(':selected').data('price') || 0;
            $('#price_liter_hidden').val(price);
            // Update juga display input agar konsisten
            $('#price_liter_display').val(formatRupiah(price));
            calculateTotal();
        });

        // Event listener untuk OAT input: format hanya saat blur agar koma (,) bisa dipakai
        $('#oat_display').on('input', function(){
            let rawValue = parseRupiah($(this).val());
            $('#oat_hidden').val(rawValue);
            calculateTotal();
        });
        $('#oat_display').on('blur', function(){
            let rawValue = parseRupiah($(this).val());
            $('#oat_hidden').val(rawValue);
            $(this).val(formatRupiah(rawValue));
            calculateTotal();
        });

        // Static table calculation handlers
        function recalcRow($row){
            const hargaDasar = parseRupiah($row.find('.harga-dasar').val());
            const ppn = hargaDasar * PPN_PERCENT / 100;
            const total = hargaDasar + ppn;
            const transport = parseRupiah($row.find('.transport').val());
            const grandTotal = total + transport;
            
            // Update calculated fields
            $row.find('.ppn').val(formatRupiah(ppn));
            $row.find('.total').val(formatRupiah(total));
            $row.find('.grand-total').val(formatRupiah(grandTotal));
        }

        // Helper: kunci kolom terhitung agar tidak bisa di-edit manual
        function enforceReadonlyForComputed($scope){
            ($scope || $(document)).find('.ppn, .total, .grand-total')
                .prop('readonly', true)
                .attr('tabindex', '-1')
                .on('keydown paste input', function(e){ e.preventDefault(); $(this).blur(); return false; });
        }

        // Event listener untuk input harga dasar
        $(document).on('input', '#table-oat-lines-kalsel tbody .harga-dasar, #table-oat-lines-kalteng tbody .harga-dasar', function(){
            const raw = parseRupiah($(this).val());
            if (String($(this).val()).trim() === '') {
                $(this).data('lastRaw', 0);
            } else {
                $(this).data('lastRaw', raw);
            }
            recalcRow($(this).closest('tr'));
        });

        // Formatkan kembali ketika keluar dari input harga dasar
        $(document).on('blur', '#table-oat-lines-kalsel tbody .harga-dasar, #table-oat-lines-kalteng tbody .harga-dasar', function(){
            const raw = $(this).data('lastRaw') || 0;
            $(this).val(formatRupiah(raw));
        });

        // Event listener untuk input transport
        $(document).on('input', '#table-oat-lines-kalsel tbody .transport, #table-oat-lines-kalteng tbody .transport', function(){
            const raw = parseRupiah($(this).val());
            if (String($(this).val()).trim() === '') {
                $(this).data('lastRaw', 0);
            } else {
                $(this).data('lastRaw', raw);
            }
            recalcRow($(this).closest('tr'));
        });

        // Formatkan kembali ketika keluar dari input transport
        $(document).on('blur', '#table-oat-lines-kalsel tbody .transport, #table-oat-lines-kalteng tbody .transport', function(){
            const raw = $(this).data('lastRaw') || 0;
            $(this).val(formatRupiah(raw));
        });

        // Event listener untuk input QTY - hanya integer
        $(document).on('input', '#table-oat-lines-kalsel tbody .qty, #table-oat-lines-kalteng tbody .qty', function(){
            // Hanya izinkan angka bulat (integer)
            let value = $(this).val().replace(/[^0-9]/g, '');
            if (value === '') {
                value = '0';
            }
            $(this).val(value);
        });

        // Pastikan kolom terhitung terkunci
        enforceReadonlyForComputed($('#table-oat-lines-kalsel tbody, #table-oat-lines-kalteng tbody'));

        // Normalisasi format angka pada kolom yang dapat diinput saat mode revisi
        if (passedStatus === 2) {
            $('#table-oat-lines-kalsel tbody tr, #table-oat-lines-kalteng tbody tr').each(function(){
                const $r = $(this);
                const hargaDasar = parseRupiah($r.find('.harga-dasar').val());
                if (!isNaN(hargaDasar) && hargaDasar > 0) { 
                    $r.find('.harga-dasar').val(formatRupiah(hargaDasar)); 
                }
                const transport = parseRupiah($r.find('.transport').val());
                if (!isNaN(transport) && transport > 0) { 
                    $r.find('.transport').val(formatRupiah(transport)); 
                }
                recalcRow($r);
            });
        }

        // --- Inisialisasi Halaman ---

        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth();
        const monthName = today.toLocaleString('default', { month: 'long' });
        let startDay = today.getDate() <= 14 ? 1 : 15;
        let endDay = today.getDate() <= 14 ? 14 : new Date(year, month + 1, 0).getDate();
        $('#note_berlaku').val(`Harga berlaku dari tanggal ${startDay} - ${endDay} ${monthName} ${year}`);

        $('#type_sph').on('change', function() {
            const type = $(this).val();
            const $customer = $('#comp_name');
            $customer.html('<option value="">Loading...</option>').trigger('change');
            if (type) {
                $.get('/api/get-customers', { type }, function(data) {
                    $customer.empty().append('<option value="">Pilih Customer</option>');
                    data.forEach(item => {
                        $customer.append(`<option value="${item.id}">${item.name}</option>`);
                    });
                });
            } else {
                $customer.empty().append('<option value="">Pilih Customer</option>');
            }
        });

        $('#comp_name').on('change', function() {
            const id = $(this).val();
            if (id) {
                $.get('/api/get-customer-detail', { id: id }, function(data) {
                    const romawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][today.getMonth() + 1];
                    const periode = today.getDate() <= 14 ? 'P1' : 'P2';
                    $('#kode_sph').val(`${data.cust_code||''}/${data.alias||''}/${data.type||''}/${romawi}/${periode}/${year}`);
                    $('#pic').val(data.pic_name || ''); $('#email').val(data.email || ''); $('#contact_no').val(data.pic_contact || '');
                    if (data.susut != null && data.susut !== '') { var s = String(data.susut).trim(); if (s === '05') s = '0.5'; $('#susut').val(s); }
                    else $('#susut').val('');
                    if (data.payment != null && data.payment !== '') {
                        var $pm = $('#pay_method');
                        var payText = String(data.payment).trim();
                        if ($pm.find('option').filter(function(){ return $(this).text() === payText; }).length) $pm.val($pm.find('option').filter(function(){ return $(this).text() === payText; }).val()).trigger('change');
                        else { $pm.append(new Option(payText, payText, true, true)).trigger('change'); }
                    }
                });
            } else $('#susut').val('');
        });

        $.get('/api/get-products', function(data) {
            const $product = $('#product');
            $product.empty().append('<option value="">Pilih Product</option>');
            data.forEach(item => {
                $product.append(`<option value="${item.id}" data-price="${item.price}">${item.product_name}</option>`);
            });
        });


        $('#pay_method').select2({
            placeholder: 'Pilih Metode',
            ajax: {
                url: '/api/master-lov/children',
                dataType: 'json', delay: 250,
                data: () => ({ parent_code: 'PAYMENT_METHOD' }),
                processResults: data => ({ results: $.map(data, item => ({ id: item.id, text: item.value })) })
            }
        });

        // Form Submission
        $('#sph-form').on('submit', function(e) {
            e.preventDefault();
            if (!this.checkValidity()) {
                e.stopPropagation();
                $(this).addClass('was-validated');
                return;
            }

            const $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Process menyimpan...');

            // Serialize static table rows into details array
            const details = [];
            $('#table-oat-lines-kalsel tbody tr, #table-oat-lines-kalteng tbody tr').each(function(){
                const $r = $(this);
                // Kolom 1: Nama Lokasi (Sesulung Estate, dll)
                // Jika menggunakan rowspan, baris kedua tidak punya nama lokasi, ambil dari data attribute
                let lokasiText = $r.find('td:first').text().trim();
                if (!lokasiText) {
                    // Jika kosong, ambil dari data attribute atau dari baris sebelumnya
                    lokasiText = $r.data('nama') || '';
                    if (!lokasiText) {
                        // Coba ambil dari baris sebelumnya (jika ada rowspan)
                        const $prevRow = $r.prev();
                        if ($prevRow.length) {
                            lokasiText = $prevRow.find('td:first').text().trim() || $prevRow.data('nama') || '';
                        }
                    }
                }
                const qty = parseInt($r.find('.qty').val() || '0', 10) || 0;
                const hargaDasar = parseRupiah($r.find('.harga-dasar').val());
                const ppnAmt = parseRupiah($r.find('.ppn').val());
                const totalAmt = parseRupiah($r.find('.total').val());
                const transport = parseRupiah($r.find('.transport').val());
                const grand = parseRupiah($r.find('.grand-total').val());
                const productText = $('#product').find(':selected').text() || '';

                details.push({
                    biaya_lokasi: lokasiText,
                    cname_lname: lokasiText,
                    product: productText,
                    qty: qty,
                    price_liter: hargaDasar,
                    ppn: ppnAmt,
                    pbbkb: 0, // Tidak ada PBBKB di tabel statis
                    transport: transport,
                    total_price: totalAmt,
                    grand_total: grand
                });
            });

            const urlParams2 = new URLSearchParams(window.location.search);
            const isRevisi = (parseInt(urlParams2.get('status')||'0',10) === 2) && !!(urlParams2.get('sph_id'));
            const formData = {
                template_id: $('#template_id').val(),
                tipe_sph: $('#type_sph').val(),
                kode_sph: $('#kode_sph').val(),
                comp_name: $('#comp_name').is('select') ? $('#comp_name').find(':selected').text() : $('#comp_name').val(),
                pic: $('#pic').val(),
                contact_no: $('#contact_no').val(),
                product: $('#product').find(':selected').text(),
                price_liter: $('#price_liter_hidden').val(),
                ppn: $('#ppn_hidden').val(),
                oat: $('#oat_hidden').val(),
                ppn_oat: $('#ppn_oat_hidden').val(),
                total_price: $('#total_price_hidden').val(),
                pbbkb: 0,
                pay_method: $('#pay_method').find(':selected').text(),
                payment: $('#pay_method').find(':selected').text(),
                susut: $('#susut').val(),
                note_berlaku: $('#note_berlaku').val(),
                site_location: $('#site_location').val(),
                oat_lokasi: $('#site_location').val(),
                details: details
            };
            if (isRevisi) { formData.sph_id = urlParams2.get('sph_id'); }

            const endpoint = isRevisi ? '/api/sph/update' : '/api/sph/validator';
            $.ajax({
                url: endpoint,
                method: 'POST',
                data: formData,
                success: function(res) {
                    var sphNo = $('#kode_sph').val() || (res && (res.kode_sph || (res.data && res.data.kode_sph))) || '';
                    var isRevisiNow = (new URLSearchParams(window.location.search).get('status')|0) === 2;
                    var showAndClose = function(){
                        try {
                            if (window.parent && window.parent.$) {
                                window.parent.$('#formSphModal').modal('hide');
                                window.parent.$('#createSphModal').modal('hide');
                                if (typeof window.parent.fetchSphWithFilter === 'function') {
                                    window.parent.fetchSphWithFilter();
                                } else {
                                    window.parent.location.reload();
                                }
                            } else {
                                window.location.reload();
                            }
                        } catch (e) {
                            window.location.reload();
                        }
                    };

                    if (window.parent && window.parent.Swal) {
                        window.parent.Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: (isRevisiNow
                                ? 'Revisi SPH dengan Nomor SPH : <b>' + sphNo + '</b> Berhasil Diajukan Kembali'
                                : 'Pembuatan SPH dengan Nomor SPH : <b>' + sphNo + '</b> Berhasil'),
                            confirmButtonText: 'OK'
                        }).then(showAndClose);
                    } else {
                        alert(isRevisiNow
                            ? ('Revisi SPH dengan Nomor SPH: ' + sphNo + ' Berhasil Diajukan Kembali')
                            : ('Pembuatan SPH dengan Nomor SPH: ' + sphNo + ' Berhasil'));
                        showAndClose();
                    }
                },
                error: function(err) {
                    alert('Gagal simpan data!');
                    console.log(err);
                    if (isRevisi) {
                        $btn.prop('disabled', false).html('Ajukan Kembali');
                    } else {
                        $btn.prop('disabled', false).html('Create SPH');
                    }
                }
            });
        });
    });
</script>
@endsection
