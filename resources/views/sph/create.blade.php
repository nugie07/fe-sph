@extends('layout.master')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6">
        <h3>Create SPH</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item active">Create SPH</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="container-fluid form-validate">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0">
            <h4>Form SPH</h4><span class="mt-2">Form untuk membuat SPH - Surat Penawaran Harga</span>
          </div>
          <div class="card-body">
            <form class="needs-validation" id="sph-form" novalidate>
              <!-- Baris 1 -->
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label">Tipe SPH</label>
                  <select class="form-select select2" name="type_sph" id="type_sph" required>
                    <option value="">Pilih Type SPH</option>
                    <option value="MMLN">MMLN</option>
                    <option value="MMTEI">MMTEI</option>
                    <option value="IASE">IASE</option>
                  </select>
                  <div class="invalid-feedback">Type SPH is required.</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Nama Customer</label>
                  <select class="form-select select2" name="comp_name" id="comp_name" required>
                    <option value="">Pilih Customer</option>
                  </select>
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


              <!-- Baris 3 -->
              <div class="row g-3 mt-2">
                <div class="col-md-4">
                  <label class="form-label">Product</label>
                  <select class="form-select select2" name="product" id="product" required>
                    <option value="">Pilih Product</option>
                  </select>
                  <div class="invalid-feedback">Product is required.</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Harga dasar per liter</label>
                  <input type="text" class="form-control" id="price_liter_display" >
                  <input type="hidden" name="price_liter" id="price_liter_hidden">
                  <div class="invalid-feedback">Harga per Liter is required.</div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">PBBKB %</label>
                  <select class="form-select" name="pbbkb_percentage" id="pbbkb_percentage" required>
                    <option value="">Pilih nilai PBBKB</option>
                    <option value="5">5%</option>
                    <option value="7.5">7.5%</option>
                    <option value="10">10%</option>
                  </select>
                  <div class="invalid-feedback">PBBKB % is required.</div>
                </div>
              </div>

              <!-- Baris 4 -->
              <div class="row g-3 mt-2">
                <div class="col-md-4">
                  <label class="form-label">PPN</label>
                  <input type="text" class="form-control" id="ppn_display" readonly>
                  <input type="hidden" name="ppn" id="ppn_hidden">
                  <div class="invalid-feedback">PPN is required.</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label">PBBKB</label>
                  <input type="text" class="form-control" id="pbbkb_display" readonly>
                  <input type="hidden" name="pbbkb" id="pbbkb_hidden">
                  <div class="invalid-feedback">PBBKB is required.</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Total Harga</label>
                  <input type="text" class="form-control" id="total_price_display" readonly>
                  <input type="hidden" name="total_price" id="total_price_hidden">
                  <div class="invalid-feedback">Total Harga is required.</div>
                </div>
              </div>

              <!-- Catatan -->
              <div class="row g-3 mt-2">
                <div class="col-md-12">
                  <label class="form-label fw-bold fs-5">Catatan</label>
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

              <button class="btn btn-primary mt-4 rounded" type="submit">Create SPH</button>
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
        const PPN_PERCENT = {{ env('PPN', 11) }};
        let pbbkbPercentage = 0;

        // Fungsi untuk memformat angka menjadi format mata uang Rupiah (2 desimal, koma untuk desimal)
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(angka || 0);
        }

        // Fungsi untuk mendapatkan nilai numerik dari format Rupiah (format ID: 13.500,20)
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
            const pbbkb = priceLiter * pbbkbPercentage / 100;
            const total = priceLiter + ppn + pbbkb;

            $('#ppn_display').val(formatRupiah(ppn));
            $('#ppn_hidden').val(ppn.toFixed(2));
            $('#pbbkb_display').val(formatRupiah(pbbkb));
            $('#pbbkb_hidden').val(pbbkb.toFixed(2));
            $('#total_price_display').val(formatRupiah(total));
            $('#total_price_hidden').val(total.toFixed(2));
        }

        // --- Event Listeners ---

        // Input harga dasar: parse dan simpan; jangan timpa tampilan saat mengetik agar koma (,) bisa dipakai
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

        // Event listener untuk PBBKB %
        $('#pbbkb_percentage').on('change', function() {
            pbbkbPercentage = parseFloat($(this).val()) || 0;
            calculateTotal();
        });

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
                    $('#kode_sph').val(`${data.cust_code || ''}/${data.alias || ''}/${data.type || ''}/${romawi}/${periode}/${year}`);
                    $('#pic').val(data.pic_name || ''); $('#email').val(data.email || ''); $('#contact_no').val(data.pic_contact || '');
                    if (data.pbbkb != null && data.pbbkb !== '') {
                        var pbbkbNum = parseFloat(data.pbbkb);
                        var isPct = (Math.abs(pbbkbNum - 5) < 0.01 || Math.abs(pbbkbNum - 7.5) < 0.01 || Math.abs(pbbkbNum - 10) < 0.01);
                        if (isPct) {
                            var pctVal = (Math.abs(pbbkbNum - 5) < 0.01) ? '5' : (Math.abs(pbbkbNum - 7.5) < 0.01) ? '7.5' : '10';
                            $('#pbbkb_percentage').val(pctVal);
                            pbbkbPercentage = parseFloat(pctVal) || 0;
                            calculateTotal();
                        } else {
                            var priceLiter = parseFloat($('#price_liter_hidden').val()) || 0;
                            if (priceLiter > 0) {
                                var pct = (pbbkbNum / priceLiter) * 100;
                                if (Math.abs(pct - 5) < 1) $('#pbbkb_percentage').val('5');
                                else if (Math.abs(pct - 7.5) < 1) $('#pbbkb_percentage').val('7.5');
                                else if (Math.abs(pct - 10) < 1) $('#pbbkb_percentage').val('10');
                                else $('#pbbkb_percentage').val('');
                                pbbkbPercentage = parseFloat($('#pbbkb_percentage').val()) || 0;
                                calculateTotal();
                            } else {
                                $('#pbbkb_display').val(formatRupiah(pbbkbNum));
                                $('#pbbkb_hidden').val(pbbkbNum.toFixed(2));
                                $('#pbbkb_percentage').val('');
                                var total = (parseFloat($('#price_liter_hidden').val()) || 0) + (parseFloat($('#ppn_hidden').val()) || 0) + pbbkbNum;
                                $('#total_price_display').val(formatRupiah(total));
                                $('#total_price_hidden').val(total.toFixed(2));
                            }
                        }
                    } else {
                        $('#pbbkb_percentage').val('');
                        pbbkbPercentage = 0;
                        calculateTotal();
                    }
                    if (data.susut != null && data.susut !== '') {
                        var s = String(data.susut).trim();
                        if (s === '05') s = '0.5';
                        $('#susut').val(s);
                    } else $('#susut').val('');
                    if (data.payment != null && data.payment !== '') {
                        var $pm = $('#pay_method');
                        var payText = String(data.payment).trim();
                        if ($pm.find('option').filter(function(){ return $(this).text() === payText; }).length) $pm.val($pm.find('option').filter(function(){ return $(this).text() === payText; }).val()).trigger('change');
                        else { $pm.append(new Option(payText, payText, true, true)).trigger('change'); }
                    }
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

            const formData = {
                tipe_sph: $('#type_sph').val(),
                kode_sph: $('#kode_sph').val(),
                comp_name: $('#comp_name').find(':selected').text(),
                pic: $('#pic').val(),
                contact_no: $('#contact_no').val(),
                product: $('#product').find(':selected').text(),
                price_liter: $('#price_liter_hidden').val(),
                pbbkb_percentage: $('#pbbkb_percentage').val(),
                ppn: $('#ppn_hidden').val(),
                pbbkb: $('#pbbkb_hidden').val(),
                total_price: $('#total_price_hidden').val(),
                pay_method: $('#pay_method').find(':selected').text(),
                payment: $('#pay_method').find(':selected').text(),
                susut: $('#susut').val(),
                note_berlaku: $('#note_berlaku').val()
            };

            $.ajax({
                url: '/api/sph/store',
                method: 'POST',
                data: formData,
                success: function(res) {
                    alert(res.message);
                    location.reload();
                },
                error: function(err) {
                    alert('Gagal simpan data!');
                    console.log(err);
                    $btn.prop('disabled', false).html('Create SPH');
                }
            });
        });
    });
</script>
@endsection
