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

                <!-- Header & Detail (Dynamic Table) -->
              <div class="row g-3 mt-3">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                  <label class="form-label fw-bold fs-5 mb-0">Detail OAT per Customer</label>
                  <div>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-add-detail" style="border-radius:8px;">Tambah Baris</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-clear-detail" style="border-radius:8px;">Bersihkan</button>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="table-oat-lines">
                      <thead class="table-light">
                        <tr>
                          <th style="min-width:200px;">Lokasi</th>
                          <th style="min-width:200px;">Nama Lokasi</th>
                          <th style="min-width:90px;">QTY</th>
                          <th style="min-width:140px;">Harga Dasar</th>
                          <th style="min-width:120px;">PPN</th>
                          <th style="min-width:120px;">PBBKB</th>
                          <th style="min-width:140px;">Total</th>
                          <th style="min-width:140px;">Transport</th>
                          <th style="min-width:160px;">Grand Total</th>
                          <th style="min-width:70px;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Susut, Payment, Tanggal Berlaku -->
              <div class="row g-3 mt-2">
                <div class="col-md-3">
                  <label class="form-label">Toleransi Susut</label>
                  <div class="d-flex gap-3">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="susut" id="susut01" value="0.1" required>
                      <label class="form-check-label" for="susut01">0.1</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="susut" id="susut02" value="0.2">
                      <label class="form-check-label" for="susut02">0.2</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="susut" id="susut03" value="0.3">
                      <label class="form-check-label" for="susut03">0.3</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="susut" id="susut04" value="0.4">
                      <label class="form-check-label" for="susut04">0.4</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="susut" id="susut05" value="0.5">
                      <label class="form-check-label" for="susut05">0.5</label>
                    </div>
                  </div>
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
                    $('#kode_sph').val(`${data.cust_code}/${data.alias}/${data.type}/${romawi}/${periode}/${year}`);
                    // Autofill contact fields based on customer detail
                    $('#pic').val(data.pic_name || '');
                    $('#email').val(data.email || '');
                    $('#contact_no').val(data.pic_contact || '');
                });
            }
        })();

        // View-mode hardening: hide action buttons and disable form controls
        if (isView) {
            $('#btn-add-detail, #btn-clear-detail').hide();
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

        // Fungsi untuk memformat angka menjadi format mata uang Rupiah
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
        function parseRupiah(stringRupiah) {
            if (!stringRupiah) return 0;
            let str = String(stringRupiah).trim().replace(/Rp\s*/gi, '').trim();
            if (str.includes(',')) {
                const parts = str.split(',');
                const integerPart = parts[0].replace(/\./g, '');
                const decimalPart = parts[1] || '00';
                return parseFloat(integerPart + '.' + decimalPart) || 0;
            }
            return parseFloat(str.replace(/\./g, '')) || 0;
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

        // Input harga dasar: format hanya saat blur agar koma (,) bisa dipakai
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

        // OAT input: format hanya saat blur agar koma (,) bisa dipakai
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

        // Cache lokasi master untuk fallback lookup persen saat revisi
        let LOKASI_CACHE = null;
        let LOKASI_CACHE_LOADING = false;
        function ensureLokasiCache(done){
            if (LOKASI_CACHE) { if (typeof done === 'function') done(); return; }
            if (LOKASI_CACHE_LOADING) { return; }
            LOKASI_CACHE_LOADING = true;
            $.get('/api/master-lov/children', { parent_code: 'LOKASI_MASTER' })
            .done(function(data){
                LOKASI_CACHE = {};
                (data||[]).forEach(function(item){
                    if (item && item.code != null) {
                        LOKASI_CACHE[String(item.code).toLowerCase()] = item.value;
                    }
                });
            })
            .always(function(){ LOKASI_CACHE_LOADING = false; if (typeof done === 'function') done(); });
        }

        // Dynamic table handlers
        function addLineRow(initial){
            const row = $(
                '<tr>'+
                '<td style="width:220px;"><select class="form-select form-select-sm lokasi-select" style="width:100%"></select></td>'+
                '<td style="width:200px;"><input type="text" class="form-control form-control-sm nama-lokasi" placeholder="Nama Lokasi"></td>'+
                '<td style="width:100px;"><input type="text" class="form-control form-control-sm qty" placeholder="per KL" inputmode="numeric" pattern="[0-9]*"></td>'+
                '<td style="width:150px;"><input type="text" class="form-control form-control-sm price" placeholder="0"></td>'+
                '<td style="width:130px;"><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>'+
                '<td style="width:130px;"><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>'+
                '<td style="width:150px;"><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>'+
                '<td style="width:140px;"><input type="text" class="form-control form-control-sm transport" placeholder="0"></td>'+
                '<td style="width:160px;"><input type="text" class="form-control form-control-sm grand-total" placeholder="0" readonly></td>'+
                '<td style="width:80px;"><button type="button" class="btn btn-sm btn-danger btn-remove" style="border-radius:8px;">Hapus</button></td>'+
                '</tr>'
            );
            $('#table-oat-lines tbody').append(row);
            // Pastikan kolom terhitung tidak bisa diedit pada baris baru
            enforceReadonlyForComputed(row);
            // initialize select2 for lokasi
            if ($.fn.select2) {
                row.find('.lokasi-select').select2({
                    dropdownParent: $('#sph-form'),
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
            }
            // initialize select2 for lokasi (ambil dari master-lov/children seperti create)
            if ($.fn.select2) {
                row.find('.lokasi-select').select2({
                    dropdownParent: $('#sph-form'),
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
            }
            if (!initial) recalcRow(row);
        }

        function parseNum(val){ return parseFloat(String(val).replace(/[^0-9.]/g,'')||'0'); }
        function formatIdr(x){ return new Intl.NumberFormat('id-ID',{minimumFractionDigits:2}).format(x||0); }

        function recalcRow($row){
            const price = parseRupiah($row.find('.price').val());
            const ppn = price * PPN_PERCENT / 100;
            // Baca persentase PBBKB dengan prioritas:
            // 1) Persisted di baris (hasil API pbbkb_persen atau hasil pilihan lokasi)
            // 2) Nilai dari hidden/input bernama pbbkb_persen
            // 3) Data dari select2 option/attribute
            // 4) Turunan dari teks option
            let lokasiPercentage = parseFloat($row.data('pbbkb_percent')) || 0;
            if (!lokasiPercentage) {
                // Cari hidden/input bernama pbbkb_persen (nilai bisa "10.00")
                const rawEl = $row.find('[name*="pbbkb_persen"], .pbbkb_persen').first();
                if (rawEl.length) {
                    const rawVal = rawEl.val();
                    const parsed = parseFloat(String(rawVal).replace(',', '.'));
                    if (!isNaN(parsed)) lokasiPercentage = parsed;
                } else {
                    // Cek data attribute pada elemen pbbkb
                    const pbbkbField = $row.find('.pbbkb');
                    const d1 = parseFloat(pbbkbField.data('percent'));
                    const d2 = parseFloat(pbbkbField.data('persen'));
                    if (!isNaN(d1)) lokasiPercentage = d1; else if (!isNaN(d2)) lokasiPercentage = d2;
                }
            }
            if (!lokasiPercentage) {
                lokasiPercentage = parseFloat($row.find('.lokasi-select').data('percentage')) || 0;
            }
            if (!lokasiPercentage) {
                let lokasiData = [];
                try { lokasiData = $row.find('.lokasi-select').select2('data') || []; } catch(e) { lokasiData = []; }
                lokasiPercentage = lokasiData.length ? parseFloat(lokasiData[0].percentage || 0) : 0;
            }
            if (!lokasiPercentage) {
                const opt = $row.find('.lokasi-select option:selected');
                const optPct = parseFloat(opt.data('percentage'));
                if (!isNaN(optPct)) lokasiPercentage = optPct;
            }
            if (!lokasiPercentage) {
                // Fallback parse dari teks option, contoh: "DKI Jakarta (10%)"
                const txt = ($row.find('.lokasi-select option:selected').text() || '').trim();
                const m = txt.match(/\(([-+]?\d+(?:[\.,]\d+)?)\s*%\)/);
                if (m) {
                    lokasiPercentage = parseFloat(String(m[1]).replace(',', '.')) || 0;
                } else if (txt) {
                    // Terakhir: coba lookup dari cache master lokasi jika text = kode
                    ensureLokasiCache();
                    const key = txt.toLowerCase();
                    if (LOKASI_CACHE && LOKASI_CACHE[key] != null) {
                        lokasiPercentage = parseFloat(LOKASI_CACHE[key]) || 0;
                    }
                }
            }
            // HAPUS fallback derive dari amount untuk menghindari lonjakan angka tak wajar
            // Validasi dan normalisasi persen [0..100]
            if (isFinite(lokasiPercentage)) {
                if (lokasiPercentage < 0) lokasiPercentage = 0;
                if (lokasiPercentage > 100) lokasiPercentage = 100;
            } else {
                lokasiPercentage = 0;
            }
            // Persist kembali agar tidak hilang saat edit harga dasar
            if (isFinite(lokasiPercentage)) {
                $row.data('pbbkb_percent', lokasiPercentage);
                $row.find('.lokasi-select').data('percentage', lokasiPercentage);
            }
            const pbbkb = price * (lokasiPercentage || 0) / 100;
            const total = price + ppn + pbbkb;
            $row.find('.ppn').val(formatIdr(ppn));
            $row.find('.pbbkb').val(formatIdr(pbbkb));
            $row.find('.total').val(formatIdr(total));
            const transport = parseRupiah($row.find('.transport').val());
            const grand = total + transport;
            $row.find('.grand-total').val(formatIdr(grand));
        }

        // Helper: kunci kolom terhitung agar tidak bisa di-edit manual
        function enforceReadonlyForComputed($scope){
            ($scope || $(document)).find('.ppn, .pbbkb, .total, .grand-total')
                .prop('readonly', true)
                .attr('tabindex', '-1')
                .on('keydown paste input', function(e){ e.preventDefault(); $(this).blur(); return false; });
        }

        $('#btn-add-detail').on('click', function(){ addLineRow(false); });
        $('#btn-clear-detail').on('click', function(){ $('#table-oat-lines tbody').empty(); });
        $(document).on('input', '#table-oat-lines tbody .price, #table-oat-lines tbody .transport', function(){
            // numeric-only; jangan force-format saat mengetik supaya tidak mengganggu input
            const raw = parseRupiah($(this).val());
            if (String($(this).val()).trim() === '') {
                $(this).data('lastRaw', 0);
            } else {
                $(this).data('lastRaw', raw);
            }
            recalcRow($(this).closest('tr'));
        });
        // Formatkan kembali ketika keluar dari input untuk tampilan rapi
        $(document).on('blur', '#table-oat-lines tbody .price, #table-oat-lines tbody .transport', function(){
            const raw = $(this).data('lastRaw');
            $(this).val(formatRupiah(raw));
        });
        // Recalculate when lokasi changed (works with select2)
        $(document).on('change select2:select', '#table-oat-lines tbody .lokasi-select', function(){
            const $r = $(this).closest('tr');
            // Ambil persentase dari pilihan lokasi terbaru dan persist ke row
            let newPct = 0;
            let dataSel = [];
            try { dataSel = $(this).select2('data') || []; } catch(e) { dataSel = []; }
            if (dataSel.length) {
                newPct = parseFloat(dataSel[0].percentage || 0) || 0;
            }
            if (!newPct) {
                const opt = $(this).find('option:selected');
                const optPct = parseFloat(opt.data('percentage'));
                if (!isNaN(optPct)) newPct = optPct;
            }
            if (!newPct) {
                const txt = ($(this).find('option:selected').text() || '').trim();
                const m = txt.match(/\(([-+]?\d+(?:[\.,]\d+)?)\s*%\)/);
                if (m) newPct = parseFloat(String(m[1]).replace(',', '.')) || 0;
            }
            if (newPct) {
                if (newPct < 0) newPct = 0;
                if (newPct > 100) newPct = 100;
                $r.data('pbbkb_percent', newPct);
                $(this).data('percentage', newPct);
            }
            recalcRow($r);
        });
        // enforce numeric for qty
        $(document).on('input', '#table-oat-lines tbody .qty', function(){
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $(document).on('click', '#table-oat-lines tbody .btn-remove', function(){
            $(this).closest('tr').remove();
        });

        // Pastikan kolom terhitung terkunci untuk baris yang mungkin sudah dirender (mode revisi)
        enforceReadonlyForComputed($('#table-oat-lines tbody'));

        // Saat membuka mode revisi, pastikan select2 terinisialisasi, derive persentase jika hilang, lalu hitung ulang
        if (passedStatus === 2) {
            $('#table-oat-lines tbody tr').each(function(){
                const $r = $(this);
                const $lok = $r.find('.lokasi-select');
                // Init select2 jika belum
                if ($.fn.select2 && !$lok.data('select2')) {
                    $lok.select2({
                        dropdownParent: $('#sph-form'),
                        placeholder: 'Pilih Lokasi', allowClear: true, width: '100%',
                        ajax: {
                            url: '/api/master-lov/children', dataType: 'json', delay: 250,
                            data: function(){ return { parent_code: 'LOKASI_MASTER' }; },
                            processResults: function(data){
                                return { results: $.map(data, function(item){ return { id: item.id, text: item.code + ' ('+ item.value +'%)', percentage: item.value }; }) };
                            }
                        }
                    });
                }
                // Normalisasi format angka pada kolom yang dapat diinput
                const price = parseRupiah($r.find('.price').val());
                if (!isNaN(price)) { $r.find('.price').val(formatRupiah(price)); }
                const transport = parseRupiah($r.find('.transport').val());
                if (!isNaN(transport)) { $r.find('.transport').val(formatRupiah(transport)); }
                // Ambil pbbkb_persen dari atribut/hidden yang mungkin diberikan server/API
                let pct = (function(){
                    // 1) data attribute pada row atau field
                    let v = parseFloat($r.data('pbbkb_persen'))
                         || parseFloat($r.data('pbbkb-percent'))
                         || parseFloat($r.find('.pbbkb').data('percent'))
                         || parseFloat($r.find('.pbbkb').data('persen'));
                    if (!v) {
                        // 2) input hidden bernama pbbkb_persen
                        const raw = ($r.find('[name*="pbbkb_persen"], .pbbkb_persen').first().val() || '').toString();
                        const parsed = parseFloat(raw.replace(',', '.'));
                        if (!isNaN(parsed)) v = parsed;
                    }
                    if (!v) {
                        // 3) dari select lokasi
                        v = parseFloat($lok.data('percentage')) || 0;
                    }
                    return v || 0;
                })();
                if (pct) {
                    if (pct < 0) pct = 0;
                    if (pct > 100) pct = 100;
                    $lok.data('percentage', pct);
                    $r.data('pbbkb_percent', pct);
                }
                recalcRow($r);
            });
        }

        // Jika ada baris yang ditambahkan dinamis dari luar, amati perubahan DOM dan kunci kolom terhitung
        if (window.MutationObserver) {
            const observer = new MutationObserver(function(mutations){
                mutations.forEach(function(m){
                    $(m.addedNodes).each(function(){
                        const $node = $(this);
                        if ($node.is('tr') || $node.find('tr').length) {
                            enforceReadonlyForComputed($node);
                            $node.find('tr').each(function(){ recalcRow($(this)); });
                        }
                    });
                });
            });
            observer.observe(document.querySelector('#table-oat-lines tbody'), { childList: true, subtree: false });
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
                    $('#kode_sph').val(`${data.cust_code}/${data.alias}/${data.type}/${romawi}/${periode}/${year}`);
                    $('#pic').val(data.pic_name); $('#email').val(data.email); $('#contact_no').val(data.pic_contact);
                });
            }
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

            // Serialize dynamic table rows into details array
            const details = [];
            $('#table-oat-lines tbody tr').each(function(){
                const $r = $(this);
                let locData = [];
                try { locData = $r.find('.lokasi-select').select2('data') || []; } catch(e) { locData = []; }
                let lokasiText = locData.length ? (locData[0].text || '') : '';
                // Ambil persentase PBBKB yang dipersist di baris terlebih dahulu
                let lokasiPercentage = parseFloat($r.data('pbbkb_percent')) || 0;
                if (!lokasiPercentage) {
                    lokasiPercentage = locData.length ? parseFloat(locData[0].percentage || 0) : 0;
                }
                if (!lokasiText) {
                    lokasiText = ($r.find('.lokasi-select option:selected').text() || '').trim();
                }
                if (!lokasiPercentage) {
                    const m = (lokasiText||'').match(/\(([-+]?\d+(?:[\.,]\d+)?)\s*%\)/);
                    if (m) {
                        lokasiPercentage = parseFloat(String(m[1]).replace(',', '.')) || 0;
                    }
                }
                // Clean lokasiText to only city name (remove percentage if present)
                lokasiText = String(lokasiText).replace(/\s*\([^)]*\)\s*$/, '');
                const qty = parseInt($r.find('.qty').val() || '0', 10) || 0;
                const price = parseRupiah($r.find('.price').val());
                const ppnAmt = price * PPN_PERCENT / 100;
                const pbbkbAmt = price * (lokasiPercentage || 0) / 100;
                const totalAmt = price + ppnAmt + pbbkbAmt;
                const transport = parseRupiah($r.find('.transport').val());
                const grand = totalAmt + transport;
                const cname = $r.find('.nama-lokasi').val() || '';
                const productText = $('#product').find(':selected').text() || '';

                details.push({
                    biaya_lokasi: lokasiText,
                    cname_lname: cname,
                    product: productText,
                    qty: qty,
                    price_liter: price,
                    // Kirimkan NILAI (amount) sesuai yang tampil di kolom, bukan persentase
                    ppn: ppnAmt,
                    pbbkb: pbbkbAmt,
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
                // biaya_lokasi removed on this template
                ppn: $('#ppn_hidden').val(),
                oat: $('#oat_hidden').val(),
                ppn_oat: $('#ppn_oat_hidden').val(),
                total_price: $('#total_price_hidden').val(),
                pay_method: $('#pay_method').find(':selected').text(),
                susut: $('input[name="susut"]:checked').val(),
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
