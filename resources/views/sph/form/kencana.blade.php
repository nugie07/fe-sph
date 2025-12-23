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
            <h4>Form SPH</h4><span class="mt-2">Form ini hanya digunakan untuk PT Kencana</span>
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
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="table-oat-lines-kencana">
                      <thead class="table-light">
                        <tr>
                          <th style="min-width:220px;">Customer</th>
                          <th style="min-width:90px;">Qty /KL</th>
                          <th style="min-width:150px;">Harga Dasar</th>
                          <th style="min-width:130px;">PPN</th>
                          <th style="min-width:130px;">PBBKB</th>
                          <th style="min-width:150px;">Total</th>
                          <th style="min-width:220px;">Lokasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- PT Agri Eastborneo Kencana -->
                        <tr data-customer="PT Agri Eastborneo Kencana" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">PT Agri Eastborneo Kencana</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td rowspan="2" style="vertical-align: middle;"><select class="form-select form-select-sm lokasi-select" style="width:100%"></select></td>
                        </tr>
                        <tr data-customer="PT Agri Eastborneo Kencana" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                        </tr>
                        <!-- PT Agrojaya Tirta Kencana -->
                        <tr data-customer="PT Agrojaya Tirta Kencana" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">PT Agrojaya Tirta Kencana</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td rowspan="2" style="vertical-align: middle;"><select class="form-select form-select-sm lokasi-select" style="width:100%"></select></td>
                        </tr>
                        <tr data-customer="PT Agrojaya Tirta Kencana" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                        </tr>
                        <!-- PT Sawit Kaltim Lestari -->
                        <tr data-customer="PT Sawit Kaltim Lestari" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">PT Sawit Kaltim Lestari</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td rowspan="2" style="vertical-align: middle;"><select class="form-select form-select-sm lokasi-select" style="width:100%"></select></td>
                        </tr>
                        <tr data-customer="PT Sawit Kaltim Lestari" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                        </tr>
                        <!-- PT Agro Inti Kencanamas -->
                        <tr data-customer="PT Agro Inti Kencanamas" data-qty="5">
                          <td rowspan="2" style="vertical-align: middle;">PT Agro Inti Kencanamas</td>
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="5" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
                          <td rowspan="2" style="vertical-align: middle;"><select class="form-select form-select-sm lokasi-select" style="width:100%"></select></td>
                        </tr>
                        <tr data-customer="PT Agro Inti Kencanamas" data-qty="10">
                          <td><input type="number" class="form-control form-control-sm qty" placeholder="0" value="10" min="0" step="1" required></td>
                          <td><input type="text" class="form-control form-control-sm harga-dasar" placeholder="0"></td>
                          <td><input type="text" class="form-control form-control-sm ppn" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm pbbkb" placeholder="0" readonly></td>
                          <td><input type="text" class="form-control form-control-sm total" placeholder="0" readonly></td>
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

        // --- Event Listeners ---

        // Static table calculation handlers
        function recalcRow($row){
            const hargaDasar = parseRupiah($row.find('.harga-dasar').val());
            const ppn = hargaDasar * PPN_PERCENT / 100;

            // Get PBBKB percentage from lokasi dropdown
            // Find lokasi select in the same customer group (could be in rowspan cell)
            let lokasiPercentage = 0;
            try {
                // Lokasi select is in rowspan, so find it from the customer group
                const customerName = $row.attr('data-customer') || $row.data('customer');
                const $customerGroup = customerName ? 
                    $('#table-oat-lines-kencana tbody tr[data-customer="' + customerName + '"]') : 
                    $row.siblings().addBack();
                
                const $sel = $customerGroup.find('.lokasi-select').first();
                
                // Try select2 data first
                try {
                    const s2data = ($sel.select2 && $sel.select2('data')) || [];
                    if (Array.isArray(s2data) && s2data.length && s2data[0].percentage != null) {
                        lokasiPercentage = parseFloat(s2data[0].percentage) || 0;
                    }
                } catch (e) {}

                // Fallback to data attribute
                if (!lokasiPercentage) {
                    const storedPct = $sel.attr('data-percentage') || $sel.data('percentage');
                    if (storedPct != null && storedPct !== '') {
                        lokasiPercentage = parseFloat(String(storedPct).replace(',', '.')) || 0;
                    }
                }

                // Fallback to parse from option text
                if (!lokasiPercentage) {
                    const optText = $sel.find('option:selected').text() || '';
                    const m = optText.match(/(\d+[\.,]?\d*)\s*%/);
                    if (m) {
                        lokasiPercentage = parseFloat(String(m[1]).replace(',', '.')) || 0;
                    }
                }
            } catch (err) {
                console.warn('Lokasi percentage parse error', err);
                lokasiPercentage = 0;
            }

            const pbbkb = hargaDasar * (lokasiPercentage || 0) / 100;
            const total = hargaDasar + ppn + pbbkb;
            
            // Update calculated fields
            $row.find('.ppn').val(formatRupiah(ppn));
            $row.find('.pbbkb').val(formatRupiah(pbbkb));
            $row.find('.total').val(formatRupiah(total));
        }

        // Helper: kunci kolom terhitung agar tidak bisa di-edit manual
        function enforceReadonlyForComputed($scope){
            ($scope || $(document)).find('.ppn, .pbbkb, .total')
                .prop('readonly', true)
                .attr('tabindex', '-1')
                .on('keydown paste input', function(e){ e.preventDefault(); $(this).blur(); return false; });
        }

        // Initialize lokasi dropdowns with default "Kalimantan Timur"
        function initLokasiDropdowns() {
            $('#table-oat-lines-kencana tbody .lokasi-select').each(function(){
                const $sel = $(this);
                if ($.fn.select2) {
                    $sel.select2({
                        dropdownParent: $('#sph-form'),
                        placeholder: 'Pilih Lokasi',
                        allowClear: true,
                        width: '100%',
                        ajax: {
                            url: '/api/master-lov/children',
                            dataType: 'json', delay: 250,
                            data: function(){ return { parent_code: 'LOKASI_MASTER' }; },
                            processResults: function(data){
                                var results = $.map(data, function(item){
                                    var pct = (item.value == null || item.value === '') ? null : parseFloat(String(item.value).replace(/,/g,'.'));
                                    var displayPct = (pct == null || isNaN(pct)) ? '' : (' (' + pct + '%)');
                                    return { id: item.id, text: item.code + displayPct, percentage: pct };
                                });
                                
                                // Check if Kalimantan Timur exists, if not add it
                                var hasKaltim = results.some(function(r) {
                                    return r.text.toLowerCase().includes('kalimantan timur') || r.text.toLowerCase().includes('kaltim');
                                });
                                
                                if (!hasKaltim) {
                                    results.unshift({ id: 'kaltim', text: 'Kalimantan Timur (7.5%)', percentage: 7.5 });
                                }
                                
                                return { results: results };
                            }
                        }
                    });

                    // Set default to "Kalimantan Timur" (7.5%) only if no value is set
                    setTimeout(function(){
                        // Check if already has a selected value (from edit mode)
                        if (!$sel.find('option:selected').length || !$sel.val()) {
                            // Set default option
                            var defaultOption = new Option('Kalimantan Timur (7.5%)', 'Kalimantan Timur (7.5%)', true, true);
                            $sel.append(defaultOption);
                            $sel.attr('data-percentage', 7.5);
                            $sel.data('percentage', 7.5);
                            $sel.trigger('change.select2');
                            
                            // Recalculate all rows in the same customer group after setting default
                            const customerName = $sel.closest('tr').attr('data-customer') || $sel.closest('tr').data('customer');
                            if (customerName) {
                                $('#table-oat-lines-kencana tbody tr[data-customer="' + customerName + '"]').each(function(){
                                    recalcRow($(this));
                                });
                            }
                        }
                    }, 1000);
                }
            });
        }

        // Event listener untuk input harga dasar dengan format rupiah
        $(document).on('input', '#table-oat-lines-kencana tbody .harga-dasar', function(){
            const raw = parseRupiah($(this).val());
            // Simpan nilai raw untuk format saat blur
            $(this).data('lastRaw', raw);
            
            // Recalculate row saat input
            recalcRow($(this).closest('tr'));
        });

        // Formatkan kembali ketika keluar dari input harga dasar
        $(document).on('blur', '#table-oat-lines-kencana tbody .harga-dasar', function(){
            const raw = $(this).data('lastRaw') || 0;
            $(this).val(formatRupiah(raw));
        });

        // Event listener untuk input QTY - hanya integer
        $(document).on('input', '#table-oat-lines-kencana tbody .qty', function(){
            // Hanya izinkan angka bulat (integer)
            let value = $(this).val().replace(/[^0-9]/g, '');
            if (value === '') {
                value = '0';
            }
            $(this).val(value);
        });

        // Recalculate when lokasi changed (lokasi is shared per customer group via rowspan)
        $(document).on('change select2:select select2:clear', '#table-oat-lines-kencana tbody .lokasi-select', function(e){
            const $this = $(this);
            try {
                const data = $this.select2('data') || [];
                if (data.length && data[0].percentage != null) {
                    const pct = parseFloat(data[0].percentage) || 0;
                    $this.data('percentage', pct);
                    $this.attr('data-percentage', pct);
                } else {
                    // Parse from text
                    const optText = $this.find('option:selected').text() || '';
                    const m = optText.match(/(\d+[\.,]?\d*)\s*%/);
                    if (m) {
                        const pct = parseFloat(String(m[1]).replace(',', '.')) || 0;
                        $this.data('percentage', pct);
                        $this.attr('data-percentage', pct);
                    }
                }
            } catch (err) {
                console.warn('Lokasi parsing error', err);
            }
            
            // Recalculate all rows in the same customer group
            const customerName = $this.closest('tr').attr('data-customer') || $this.closest('tr').data('customer');
            if (customerName) {
                $('#table-oat-lines-kencana tbody tr[data-customer="' + customerName + '"]').each(function(){
                    recalcRow($(this));
                });
            }
        });

        // Pastikan kolom terhitung terkunci
        enforceReadonlyForComputed($('#table-oat-lines-kencana tbody'));

        // Initialize lokasi dropdowns
        initLokasiDropdowns();

        // Recalculate all rows function (exposed to parent for edit mode)
        function recalcAllRows(){
            try {
                $('#table-oat-lines-kencana tbody tr').each(function(){
                    recalcRow($(this));
                });
            } catch (e) {}
        }
        window.recalcAllRows = recalcAllRows;

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

            // Build details array for static table (Kencana)
            const details = [];
            $('#table-oat-lines-kencana tbody tr').each(function(){
                const $r = $(this);
                // Get customer name from data attribute or first column
                const customerText = $r.attr('data-customer') || $r.find('td:first').text().trim();
                
                // Get lokasi: prefer select2 data text; fallback to selected option text
                // Lokasi is in rowspan, so find it from the customer group
                const customerName = $r.attr('data-customer') || $r.data('customer');
                const $customerGroup = customerName ? 
                    $('#table-oat-lines-kencana tbody tr[data-customer="' + customerName + '"]') : 
                    $r.siblings().addBack();
                
                const $lok = $customerGroup.find('.lokasi-select').first();
                let locData = [];
                try { locData = $lok.select2('data') || []; } catch(e) { locData = []; }
                let lokasiText = locData.length ? (locData[0].text || '') : ($lok.find('option:selected').text() || '');
                
                // Get lokasi percentage
                let lokasiPercentage = 0;
                if (locData.length && locData[0].percentage != null && locData[0].percentage !== '') {
                    lokasiPercentage = parseFloat(locData[0].percentage) || 0;
                } else {
                    const storedPct = $lok.attr('data-percentage') || $lok.data('percentage');
                    if (storedPct != null && storedPct !== '') {
                        lokasiPercentage = parseFloat(String(storedPct).replace(',', '.')) || 0;
                    } else if (lokasiText) {
                        const m = String(lokasiText).match(/(\d+[\.,]?\d*)\s*%/);
                        if (m) lokasiPercentage = parseFloat(String(m[1]).replace(',', '.')) || 0;
                    }
                }
                
                const qty = parseInt($r.find('.qty').val() || '0', 10) || 0;
                const hargaDasar = parseRupiah($r.find('.harga-dasar').val());
                const ppnAmt = parseRupiah($r.find('.ppn').val());
                const pbbkbAmt = parseRupiah($r.find('.pbbkb').val());
                const totalAmt = parseRupiah($r.find('.total').val());
                const productText = $('#product').find(':selected').text() || '';

                details.push({
                    biaya_lokasi: lokasiText,
                    cname_lname: customerText,
                    product: productText,
                    qty: qty,
                    price_liter: hargaDasar,
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
