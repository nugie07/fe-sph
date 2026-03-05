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
            <h4>Form SPH</h4><span class="mt-2">Form untuk membuat SPH - Surat Penawaran Harga dengan Template UMUM</span>
          </div>
          <div class="card-body">
            <form class="needs-validation" id="sph-form" novalidate>
            <input type="hidden" name="template_id" id="template_id">
            <input type="hidden" name="sph_id" id="sph_id">
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
                <div class="col-md-4">
                  <label class="form-label">PIC</label>
                  <input type="text" class="form-control" name="pic" id="pic" required>
                  <div class="invalid-feedback">PIC is required.</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Contact No</label>
                  <input type="text" class="form-control" name="contact_no" id="contact_no" required>
                  <div class="invalid-feedback">Contact No is required.</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Email</label>
                  <input type="text" class="form-control" name="email" id="email" required>
                  <div class="invalid-feedback">Email is required.</div>
                </div>

              </div>


              <!-- Baris 3: Product - Harga Dasar - PPN - Total (1 baris) -->
              <div class="row g-3 mt-2">
                <div class="col-md-3">
                  <label class="form-label">Product</label>
                  <select class="form-select select2" name="product" id="product" required>
                    <option value="">Pilih Product</option>
                  </select>
                  <div class="invalid-feedback">Product is required.</div>
                </div>

                <div class="col-md-3">
                  <label class="form-label">Harga dasar per liter</label>
                  <input type="text" class="form-control" id="price_liter_display" >
                  <input type="hidden" name="price_liter" id="price_liter_hidden">
                  <div class="invalid-feedback">Harga per Liter is required.</div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">PPN</label>
                  <input type="text" class="form-control" id="ppn_display" readonly>
                  <input type="hidden" name="ppn" id="ppn_hidden">
                  <div class="invalid-feedback">PPN is required.</div>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Total Harga</label>
                  <input type="text" class="form-control" id="total_price_display" readonly>
                  <input type="hidden" name="total_price" id="total_price_hidden">
                  <div class="invalid-feedback">Total Harga is required.</div>
                </div>
              </div>

              <!-- Lokasi OAT Section -->
              <div class="row g-3 mt-3">
                <div class="col-md-6">
                  <label class="form-label">Lokasi OAT</label>
                  <select class="form-select" id="lokasi_oat" name="lokasi_oat">
                    <option value="">Pilih Lokasi</option>
                    <option value="Kalsel">Kalsel</option>
                    <option value="Kalteng">Kalteng</option>
                  </select>
                </div>
              </div>

              <div class="row g-3 mt-3">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                  <label class="form-label fw-bold fs-5 mb-0">Detail OAT</label>
                  <div>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-add-oat" style="border-radius:8px;">Tambah</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-clear-oat" style="border-radius:8px;">Bersihkan</button>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="oat-details-table">
                      <thead class="table-light">
                        <tr>
                          <th style="min-width:220px;">Lokasi</th>
                          <th style="min-width:120px;">OAT 10KL</th>
                          <th style="min-width:120px;">OAT 5KL</th>
                          <th style="min-width:70px;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                  <div class="text-start"><small class="text-muted">*OAT tidak kena PPN</small></div>
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
        const passedSphId = urlParams.get('sph_id') || urlParams.get('id') || '';

        // Fallback: try to read id/template_id from parent window's URL when opened in iframe
        let effectiveSphId = passedSphId;
        let effectiveTemplateId = passedTemplateId;
        try {
            if (window.parent && window.parent !== window) {
                const parentSearch = window.parent.location && window.parent.location.search ? window.parent.location.search : '';
                if (parentSearch) {
                    const parentParams = new URLSearchParams(parentSearch);
                    effectiveSphId = effectiveSphId || parentParams.get('sph_id') || parentParams.get('id') || '';
                    effectiveTemplateId = effectiveTemplateId || parentParams.get('template_id') || '';
                }
            }
        } catch (e) {
            // ignore cross-origin or other errors
        }

        if (effectiveTemplateId) {
            $('#template_id').val(effectiveTemplateId);
        }
        if (effectiveSphId) {
            $('#sph_id').val(effectiveSphId);
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

        // View-mode: lock inputs and hide submit/actions
        if (isView) {
            $('#btn-submit-sph').hide();
            $('#btn-add-oat, #btn-clear-oat').hide();
            $('#sph-form').find('input, select, textarea').prop('disabled', true).attr('readonly', true);
            console.log('[Gawi][View] Enabled with params', { passedSphId, passedTemplateId, effectiveSphId, effectiveTemplateId });
        }
        const PPN_PERCENT = {{ env('PPN', 11) }};

        // Fungsi untuk memformat angka menjadi format mata uang Rupiah (2 desimal, koma untuk desimal)
        function formatRupiah(angka) {
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

        // Fungsi utama untuk menghitung total: hanya Harga Dasar + PPN (tanpa PBBKB)
        function calculateTotal() {
            const priceLiter = parseFloat($('#price_liter_hidden').val()) || 0;
            const ppn = priceLiter * PPN_PERCENT / 100;
            const total = priceLiter + ppn;

            $('#ppn_display').val(formatRupiah(ppn));
            $('#ppn_hidden').val(ppn.toFixed(2));
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

        // Dynamic OAT table handlers
        function parseNum(val){ return parseFloat(String(val).replace(/[^0-9.]/g,'')||'0'); }
        // Function untuk parse angka format Indonesia (koma sebagai desimal, titik sebagai thousand separator)
        function parseNumIndonesian(val) {
            if (!val) return 0;
            let str = String(val).trim();
            // Hapus semua karakter selain angka, titik, dan koma
            str = str.replace(/[^0-9.,]/g, '');
            if (!str) return 0;
            
            // Jika tidak ada koma, hapus titik (thousand separator) dan parse
            if (str.indexOf(',') === -1) {
                return parseFloat(str.replace(/\./g, '')) || 0;
            }
            
            // Jika ada koma, cari koma terakhir (desimal separator)
            const lastCommaIndex = str.lastIndexOf(',');
            const afterComma = str.substring(lastCommaIndex + 1);
            const beforeComma = str.substring(0, lastCommaIndex);
            
            // Jika setelah koma ada 1-3 digit angka, kemungkinan koma adalah desimal separator
            if (afterComma.length > 0 && afterComma.length <= 3 && /^\d+$/.test(afterComma)) {
                // Format Indonesia: titik sebagai thousand separator, koma sebagai desimal
                const integerPart = beforeComma.replace(/\./g, '');
                const decimalPart = afterComma;
                const result = parseFloat(integerPart + '.' + decimalPart);
                return isNaN(result) ? 0 : result;
            }
            
            // Jika format tidak jelas, coba hapus semua separator dan parse
            // Tapi jika ada koma di tengah dengan banyak digit setelahnya, mungkin thousand separator
            // Untuk safety, hapus semua separator dan parse sebagai integer
            return parseFloat(str.replace(/[,.]/g, '')) || 0;
        }
        function addOatRow(initial){
            const row = $(
                '<tr>'+
                '<td><input type="text" class="form-control form-control-sm oat-lokasi" placeholder="Nama lokasi"></td>'+
                '<td style="width:150px;"><input type="text" class="form-control form-control-sm oat-10" placeholder="0"></td>'+
                '<td style="width:150px;"><input type="text" class="form-control form-control-sm oat-5" placeholder="0"></td>'+
                '<td style="width:80px;"><button type="button" class="btn btn-sm btn-danger btn-oat-remove" style="border-radius:8px;">Hapus</button></td>'+
                '</tr>'
            );
            $('#oat-details-table tbody').append(row);
            if (initial) {
                if (Object.prototype.hasOwnProperty.call(initial, 'lokasi')) row.find('.oat-lokasi').val(initial.lokasi);
                if (Object.prototype.hasOwnProperty.call(initial, 'oat10')) row.find('.oat-10').val(initial.oat10);
                if (Object.prototype.hasOwnProperty.call(initial, 'oat5')) row.find('.oat-5').val(initial.oat5);
            }
            if (isView) {
                row.find('input').prop('disabled', true).attr('readonly', true);
                row.find('.btn-oat-remove').hide();
            }
        }
        $('#btn-add-oat').on('click', function(){ addOatRow(); });
        $('#btn-clear-oat').on('click', function(){ $('#oat-details-table tbody').empty(); });
        $(document).on('click', '#oat-details-table tbody .btn-oat-remove', function(){ $(this).closest('tr').remove(); });

        // Event listener untuk Lokasi OAT dropdown - Load data dari JSON dan populate datatable
        $('#lokasi_oat').on('change', function(){
            const selectedLokasi = $(this).val();
            if (!selectedLokasi) {
                $('#oat-details-table tbody').empty();
                return;
            }

            // Load data dari JSON file
            $.getJSON('{{ route("sph.form.oat_gawi.json") }}')
                .done(function(data){
                    // Cari data berdasarkan lokasi yang dipilih
                    const lokasiData = data.find(function(item){
                        return item.lokasi === selectedLokasi;
                    });

                    if (lokasiData && lokasiData.details && lokasiData.details.length > 0) {
                        // Clear datatable terlebih dahulu
                        $('#oat-details-table tbody').empty();

                        // Format function untuk format angka dengan koma sebagai desimal
                        function formatOatValue(value) {
                            return parseFloat(value || 0).toFixed(2).replace('.', ',');
                        }

                        // Add row untuk setiap detail lokasi
                        lokasiData.details.forEach(function(detail){
                            addOatRow({
                                lokasi: detail.nama_lokasi,
                                oat10: formatOatValue(detail.oat10kl),
                                oat5: formatOatValue(detail.oat5kl)
                            });
                        });
                    } else {
                        // Jika tidak ada data, clear table
                        $('#oat-details-table tbody').empty();
                    }
                })
                .fail(function(xhr, status, error){
                    console.error('Error loading OAT data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data OAT. Silakan coba lagi.',
                        timer: 3000
                    });
                });
        });

        // Event listener untuk produk
        $('#product').on('change', function() {
            const price = $(this).find(':selected').data('price') || 0;
            $('#price_liter_hidden').val(price);
            // Update juga display input agar konsisten
            $('#price_liter_display').val(formatRupiah(price));
            calculateTotal();
        });

        // (dihilangkan) biaya lokasi & PBBKB tidak digunakan pada template ini

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

        // Load data dari API untuk tampilan VIEW (atau jika param id & template tersedia)
        function populateFromResponse(res){
            console.log('[Gawi][Populate] raw response:', res);
            var header = res && res.header ? res.header : (res && res.data && res.data.header ? res.data.header : null);
            if (header && typeof header.biaya_lokasi !== 'undefined' && header.biaya_lokasi !== null) {
                $('#lokasi_oat').val(header.biaya_lokasi);
                console.log('[Gawi][Populate] Lokasi OAT set to', header.biaya_lokasi);
            }
            var detailsArr = Array.isArray(res && res.details) ? res.details : (Array.isArray(res && res.data && res.data.details) ? res.data.details : []);
            if (detailsArr && detailsArr.length) {
                $('#oat-details-table tbody').empty();
                detailsArr.forEach(function(d){
                    addOatRow({
                        lokasi: d.cname_lname || '',
                        oat10: (d.total_price !== undefined && d.total_price !== null) ? d.total_price : '',
                        oat5: (d.grand_total !== undefined && d.grand_total !== null) ? d.grand_total : ''
                    });
                });
                console.log('[Gawi][Populate] Rows filled:', detailsArr.length);
            } else {
                console.log('[Gawi][Populate] No details array found');
            }
        }

        function fetchDetailsAndPopulate(){
            if (!(effectiveSphId && effectiveTemplateId)) {
                console.warn('[Gawi][Fetch] Missing id/template_id; cannot load details', { effectiveSphId, effectiveTemplateId });
                return;
            }
            const endpoints = [
                `{{ url('/api/sph/details') }}?id=${encodeURIComponent(effectiveSphId)}&template_id=${encodeURIComponent(effectiveTemplateId)}`,
                `/api/sph/details?id=${encodeURIComponent(effectiveSphId)}&template_id=${encodeURIComponent(effectiveTemplateId)}`
            ];
            let idx = 0;
            const attempt = () => {
                if (idx >= endpoints.length) return;
                const url = endpoints[idx];
                console.log('[Gawi][Fetch] Attempt', url);
                $.ajax({ url: url, method: 'GET', dataType: 'json' })
                    .done(function(res){ console.log('[Gawi][Fetch] Success from', url); populateFromResponse(res); })
                    .fail(function(err){ console.warn('[Gawi][Fetch] Failed', url, err); idx += 1; attempt(); });
            };
            attempt();
        }

        if (isView || (effectiveSphId && effectiveTemplateId)) {
            fetchDetailsAndPopulate();
        }

        // (dihilangkan) inisialisasi select2 untuk biaya lokasi

        $('#pay_method').select2({
            placeholder: 'Pilih Metode',
            ajax: {
                url: '/api/master-lov/children',
                dataType: 'json', delay: 250,
                data: () => ({ parent_code: 'PAYMENT_METHOD' }),
                processResults: data => ({ results: $.map(data, item => ({ id: item.id, text: item.value })) })
            }
        });

        // --- Tampilkan remark & ganti label tombol jika status revisi ---
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

            const isRevisi = (passedStatus === 2) && !!($('#sph_id').val());

            // Build details array dari OAT table
            const details = [];
            $('#oat-details-table tbody tr').each(function(){
                const $r = $(this);
                const lokasi = ($r.find('.oat-lokasi').val() || '').trim();
                // Gunakan parseNumIndonesian untuk handle format Indonesia (koma sebagai desimal)
                const oat10 = parseNumIndonesian($r.find('.oat-10').val());
                const oat5 = parseNumIndonesian($r.find('.oat-5').val());
                const productText = $('#product').find(':selected').text() || '';
                if (lokasi || oat10 || oat5) {
                    details.push({
                        cname_lname: lokasi,
                        product: productText,
                        total_price: oat10,
                        grand_total: oat5
                    });
                }
            });

            const formData = {
                template_id: $('#template_id').val(),
                tipe_sph: $('#type_sph').val(),
                kode_sph: $('#kode_sph').val(),
                comp_name: $('#comp_name').is('select') ? $('#comp_name').find(':selected').text() : $('#comp_name').val(),
                pic: $('#pic').val(),
                contact_no: $('#contact_no').val(),
                product: $('#product').find(':selected').text(),
                price_liter: $('#price_liter_hidden').val(),
                biaya_lokasi: $('#lokasi_oat').val(),
                ppn: $('#ppn_hidden').val(),
                total_price: $('#total_price_hidden').val(),
                pbbkb: 0,
                pay_method: $('#pay_method').find(':selected').text(),
                payment: $('#pay_method').find(':selected').text(),
                susut: $('#susut').val(),
                note_berlaku: $('#note_berlaku').val(),
                details: details
            };
            if (isRevisi) { formData.sph_id = $('#sph_id').val(); }

            const endpoint = isRevisi ? '/api/sph/update' : '/api/sph/validator';

            $.ajax({
                url: endpoint,
                method: 'POST',
                data: formData,
                success: function(res) {
                    var sphNo = $('#kode_sph').val() || (res && (res.kode_sph || (res.data && res.data.kode_sph))) || '';
                    var isRevisiNow = (passedStatus === 2);
                    
                    // Update JSON file dengan data OAT dari datatable
                    const selectedLokasi = $('#lokasi_oat').val();
                    if (selectedLokasi && details.length > 0) {
                        // Build details untuk JSON (format sesuai struktur JSON)
                        const jsonDetails = [];
                        details.forEach(function(detail) {
                            // Parse nilai OAT (detail.total_price dan detail.grand_total sudah dalam bentuk number dari parseNum)
                            const oat10 = parseFloat(detail.total_price) || 0;
                            const oat5 = parseFloat(detail.grand_total) || 0;
                            
                            jsonDetails.push({
                                nama_lokasi: detail.cname_lname || '',
                                oat5kl: oat5,
                                oat10kl: oat10
                            });
                        });
                        
                        // Update JSON file via API
                        $.ajax({
                            url: '{{ route("sph.form.oat_gawi.json.update") }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                lokasi: selectedLokasi,
                                details: jsonDetails
                            },
                            success: function(updateRes) {
                                console.log('OAT JSON file updated successfully');
                            },
                            error: function(updateErr) {
                                console.error('Failed to update OAT JSON file:', updateErr);
                                // Tidak perlu show error ke user, karena form sudah berhasil disimpan
                            }
                        });
                    }
                    
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
                    // restore button label depending on mode
                    if (passedStatus === 2) {
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
