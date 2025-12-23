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
                          <th style="min-width:220px;">Customer</th>
                          <th style="min-width:80px;">QTY</th>
                          <th style="min-width:140px;">Harga Dasar</th>
                          <th style="min-width:120px;">PPN</th>
                          <th style="min-width:120px;">PBBKB</th>
                          <th style="min-width:140px;">Total</th>
                          <th style="min-width:220px;">Lokasi</th>
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

        // View-mode hardening for Kencana
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
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(angka || 0);
        }

        // Fungsi untuk mendapatkan nilai numerik dari format Rupiah (ID locale)
        // Contoh yang didukung: "14.500,00", "Rp 2.300", "20.000", "2,5"
        function parseRupiah(stringRupiah) {
            if (stringRupiah == null) return 0;
            let s = String(stringRupiah).trim();
            // hapus semua karakter selain angka, titik, koma, minus
            s = s.replace(/[^0-9,.-]/g, '');
            // buang semua pemisah ribuan "." lalu ganti koma menjadi titik sebagai desimal
            s = s.replace(/\./g, '').replace(/,/g, '.');
            const n = parseFloat(s);
            return isNaN(n) ? 0 : n;
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

        // PERBAIKAN: Event listener untuk input manual harga dasar
        $('#price_liter_display').on('input', function(e) {
            // 1. Ambil nilai numerik dari input
            let rawValue = parseRupiah($(this).val());

            // 2. Update input tersembunyi dengan nilai numerik
            $('#price_liter_hidden').val(rawValue);

            // 3. Format ulang input yang terlihat
            // Simpan posisi kursor agar tidak loncat
            let cursorPos = this.selectionStart;
            let originalLength = this.value.length;
            $(this).val(formatRupiah(rawValue));
            let newLength = this.value.length;
            this.setSelectionRange(cursorPos + (newLength - originalLength), cursorPos + (newLength - originalLength));

            // 4. Panggil kalkulasi total
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

        // Event listener untuk OAT input
        $('#oat_display').on('input', function(){
            let rawValue = parseRupiah($(this).val());
            $('#oat_hidden').val(rawValue);
            let cursorPos = this.selectionStart;
            let originalLength = this.value.length;
            $(this).val(formatRupiah(rawValue));
            let newLength = this.value.length;
            this.setSelectionRange(cursorPos + (newLength - originalLength), cursorPos + (newLength - originalLength));
            calculateTotal();
        });

        // Dynamic table handlers
        function addLineRow(initial){
            const row = $(
                '<tr>'+
                '<td style="width:220px;"><select class="form-select form-select-sm customer-select" style="width:100%"></select></td>'+
                '<td style="width:100px;"><input type="text" class="form-control form-control-sm qty" placeholder="per KL" inputmode="numeric" pattern="[0-9]*"></td>'+
                '<td style="width:150px;"><input type="text" class="form-control form-control-sm price" placeholder="0"></td>'+
                '<td style="width:130px;"><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>'+
                '<td style="width:130px;"><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>'+
                '<td style="width:150px;"><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>'+
                '<td style="width:220px;"><select class="form-select form-select-sm lokasi-select" style="width:100%"></select></td>'+
                '<td style="width:80px;"><button type="button" class="btn btn-sm btn-danger btn-remove" style="border-radius:8px;">Hapus</button></td>'+
                '</tr>'
            );
            $('#table-oat-lines tbody').append(row);
            // initialize select2 for customer select with search and API
            if ($.fn.select2) {
                row.find('.customer-select').select2({
                    dropdownParent: $('#sph-form'),
                    placeholder: 'Pilih Customer',
                    allowClear: true,
                    width: '100%',
                    minimumInputLength: 0,
                    ajax: {
                        url: '/api/get-customers',
                        dataType: 'json', delay: 250,
                        data: function(params){
                            return {
                                type: $('#type_sph').val() || '',
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
                            return {
                                results: $.map(data, function(item){
                                    // Ensure percentage is numeric (parseFloat) and text shows cleaned percent
                                    var pct = (item.value == null || item.value === '') ? null : parseFloat(String(item.value).replace(/,/g,'.'));
                                    var displayPct = (pct == null || isNaN(pct)) ? '' : (' (' + pct + '%)');
                                    return { id: item.id, text: item.code + displayPct, percentage: pct };
                                })
                            };
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

            // Resolve PBBKB percentage with precedence and prefer visible option text when it differs
            // Precedence attempted: 1) select2('data'), 2) stored attr/data-percentage, 3) parse visible option text
            // If stored and visible text both exist and are different, prefer visible text (user's selected value)
            let lokasiPercentage = 0;
            let storedPctRaw = null;
            try {
                var $sel = $row.find('.lokasi-select');

                // 1) try select2 data
                try {
                    const s2data = ($sel.select2 && $sel.select2('data')) || [];
                    if (Array.isArray(s2data) && s2data.length) {
                        const cand = s2data[0].percentage;
                        if (cand != null && cand !== '' && !isNaN(parseFloat(cand))) {
                            lokasiPercentage = parseFloat(cand);
                        }
                    }
                } catch (e) {
                    // ignore select2 access errors
                }

                // 2) read stored attribute / jQuery data
                try {
                    const attrVal = $sel.attr('data-percentage');
                    const dataVal = $sel.data('percentage');
                    storedPctRaw = (attrVal != null && attrVal !== '') ? attrVal : ((typeof dataVal !== 'undefined' && dataVal !== null) ? dataVal : null);
                    if ((storedPctRaw != null && storedPctRaw !== '') && !lokasiPercentage) {
                        if (!isNaN(parseFloat(storedPctRaw))) lokasiPercentage = parseFloat(String(storedPctRaw).replace(',', '.'));
                    }
                } catch (e) {
                    // ignore
                }

                // 3) parse visible option text
                let parsedFromText = 0;
                try {
                    const optText = $sel.find('option:selected').text() || '';
                    let m = optText.match(/(\d+[\.,]?\d*)\s*%/);
                    if (!m) { const ip = optText.match(/\(([^)]*)\)/); if (ip) { const m2 = ip[1].match(/(\d+[\.,]?\d*)/); if (m2) m = m2; } }
                    if (m) parsedFromText = parseFloat(String(m[1]).replace(',', '.')) || 0;
                } catch (e) {
                    parsedFromText = 0;
                }

                // If both stored and parsedFromText exist and differ, prefer parsedFromText (visible text)
                if (parsedFromText && storedPctRaw != null && storedPctRaw !== '') {
                    const storedNum = parseFloat(String(storedPctRaw).replace(',', '.')) || 0;
                    if (storedNum !== parsedFromText) {
                        lokasiPercentage = parsedFromText;
                    } else if (!lokasiPercentage) {
                        lokasiPercentage = storedNum;
                    }
                } else if (parsedFromText && !lokasiPercentage) {
                    lokasiPercentage = parsedFromText;
                }

                // Defensive numeric
                lokasiPercentage = (isNaN(lokasiPercentage) ? 0 : Number(lokasiPercentage));
            } catch (err) {
                lokasiPercentage = 0;
                console.warn('recalcRow lokasi parse error', err);
            }

            const pbbkb = price * (lokasiPercentage || 0) / 100;
            const total = price + ppn + pbbkb;
            $row.find('.ppn').val(formatIdr(ppn));
            $row.find('.pbbkb').val(formatIdr(pbbkb));
            $row.find('.total').val(formatIdr(total));
        }

        $('#btn-add-detail').on('click', function(){ addLineRow(false); });
        $('#btn-clear-detail').on('click', function(){ $('#table-oat-lines tbody').empty(); });
        $(document).on('input', '#table-oat-lines tbody .price', function(){
            // numeric-only with IDR formatting on-the-fly
            let raw = parseRupiah($(this).val());
            let cursorPos = this.selectionStart;
            let originalLength = this.value.length;
            $(this).val(formatRupiah(raw));
            let newLength = this.value.length;
            this.setSelectionRange(cursorPos + (newLength - originalLength), cursorPos + (newLength - originalLength));
            recalcRow($(this).closest('tr'));
        });
        // Recalculate when QTY changed as well (some teams expect totals to react on QTY edits)
        $(document).on('input change', '#table-oat-lines tbody .qty', function(){
            recalcRow($(this).closest('tr'));
        });
        // Recalculate when lokasi changed (works with select2) and persist percentage on element
        $(document).on('change select2:select select2:clear', '#table-oat-lines tbody .lokasi-select', function(e){
            const $this = $(this);
            try {
                const data = $this.select2('data') || [];
                if (data.length) {
                    let pct = null;
                    if (data[0].percentage != null && data[0].percentage !== '') {
                        pct = parseFloat(data[0].percentage);
                    }
                    if (isNaN(pct)) {
                        const t = String(data[0].text || '');
                        let m = t.match(/(\d+[\.,]?\d*)\s*%/);
                        if (!m) { const ip = t.match(/\(([^)]*)\)/); if (ip) { const m2 = ip[1].match(/(\d+[\.,]?\d*)/); if (m2) m = m2; } }
                        if (m) pct = parseFloat(String(m[1]).replace(',', '.'));
                    }
                    if (!isNaN(pct)) {
                        $this.data('percentage', pct);
                        $this.attr('data-percentage', pct);
                    }
                }
            } catch (err) {
                console.warn('Lokasi parsing error', err);
            }
            // Pastikan selalu hitung ulang segera setelah pemilihan lokasi, tanpa delay
            const $row = $this.closest('tr');
            recalcRow($row);
        });
        $(document).on('click', '#table-oat-lines tbody .btn-remove', function(){
            $(this).closest('tr').remove();
        });

        // --- Inisialisasi Halaman ---

        // Recalculate all prefilled rows (useful on revisi where rows are injected by parent)
        function recalcAllRows(){
            try {
                $('#table-oat-lines tbody tr').each(function(){
                    recalcRow($(this));
                });
            } catch (e) {}
        }
        // Run immediately and also retry a few times to let select2 finish attaching data
        // expose to parent (index.blade) so it can trigger after rows injected
        window.recalcAllRows = recalcAllRows;
        recalcAllRows();
        (function(){
            var start = Date.now();
            var iv = setInterval(function(){
                recalcAllRows();
                if (Date.now() - start > 2000) clearInterval(iv);
            }, 200);
        })();

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

            // Build details array for dynamic table (Kencana)
            const details = [];
            $('#table-oat-lines tbody tr').each(function(){
                const $r = $(this);
                // Lokasi: prefer select2 data text; fallback to selected option text
                const $lok = $r.find('.lokasi-select');
                let locData = [];
                try { locData = $lok.select2('data') || []; } catch(e) { locData = []; }
                let lokasiText = locData.length ? (locData[0].text || '') : ($lok.find('option:selected').text() || '');
                // Persentase lokasi: try select2 percentage, else data attribute, else parse dari teks
                let lokasiPercentage = 0;
                if (locData.length && locData[0].percentage != null && locData[0].percentage !== '') {
                    lokasiPercentage = parseFloat(locData[0].percentage) || 0;
                } else {
                    const storedPct = $lok.attr('data-percentage') || $lok.data('percentage');
                    if (storedPct != null && storedPct !== '' && !isNaN(parseFloat(storedPct))) {
                        lokasiPercentage = parseFloat(String(storedPct).replace(',', '.')) || 0;
                    } else if (lokasiText) {
                        const m = String(lokasiText).match(/(\d+[\.,]?\d*)\s*%/);
                        if (m) lokasiPercentage = parseFloat(String(m[1]).replace(',', '.')) || 0;
                    }
                }
                // Customer: prefer select2 data; fallback to selected option text (if any)
                const $cust = $r.find('.customer-select');
                let custData = [];
                try { custData = $cust.select2('data') || []; } catch(e) { custData = []; }
                let customerText = custData.length ? (custData[0].text || '') : ($cust.find('option:selected').text() || '');
                const qty = parseInt($r.find('.qty').val() || '0', 10) || 0;
                const price = parseRupiah($r.find('.price').val());
                const ppnAmt = price * PPN_PERCENT / 100;
                const pbbkbAmt = price * (lokasiPercentage || 0) / 100;
                const totalAmt = price + ppnAmt + pbbkbAmt;
                const productText = $('#product').find(':selected').text() || '';

                details.push({
                    biaya_lokasi: lokasiText,
                    cname_lname: customerText,
                    product: productText,
                    qty: qty,
                    price_liter: price,
                    ppn: ppnAmt,
                    pbbkb: pbbkbAmt,
                    total_price: totalAmt
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
