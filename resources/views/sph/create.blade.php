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
                  <label class="form-label">Biaya Lokasi</label>
                  <select class="form-select select2" name="biaya_lokasi" id="biaya_lokasi" required></select>
                  <div class="invalid-feedback">Biaya Lokasi is required.</div>
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
        let lokasiPercentage = 0;

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

        // Fungsi untuk mendapatkan nilai numerik dari format Rupiah
        function parseRupiah(stringRupiah) {
            return parseFloat(stringRupiah.replace(/[^0-9]/g, '')) || 0;
        }

        // Fungsi utama untuk menghitung total
        function calculateTotal() {
            const priceLiter = parseFloat($('#price_liter_hidden').val()) || 0;
            const ppn = priceLiter * PPN_PERCENT / 100;
            const pbbkb = priceLiter * lokasiPercentage / 100;
            const total = priceLiter + ppn + pbbkb;

            $('#ppn_display').val(formatRupiah(ppn));
            $('#ppn_hidden').val(ppn.toFixed(2));
            $('#pbbkb_display').val(formatRupiah(pbbkb));
            $('#pbbkb_hidden').val(pbbkb.toFixed(2));
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

        // Event listener untuk biaya lokasi
        $('#biaya_lokasi').on('select2:select', function(e) {
            lokasiPercentage = parseFloat(e.params.data.percentage || 0);
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

        $('#biaya_lokasi').select2({
            placeholder: 'Pilih Lokasi',
            ajax: {
                url: '/api/master-lov/children',
                dataType: 'json', delay: 250,
                data: () => ({ parent_code: 'LOKASI_MASTER' }),
                processResults: data => ({ results: $.map(data, item => ({ id: item.id, text: `${item.code} (${item.value}%)`, percentage: item.value })) })
            }
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
                biaya_lokasi: $('#biaya_lokasi').find(':selected').text(),
                ppn: $('#ppn_hidden').val(),
                pbbkb: $('#pbbkb_hidden').val(),
                total_price: $('#total_price_hidden').val(),
                pay_method: $('#pay_method').find(':selected').text(),
                susut: $('input[name="susut"]:checked').val(),
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
