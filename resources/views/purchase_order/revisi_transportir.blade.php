<!-- Pastikan Anda memuat library jQuery SEBELUM skrip Anda. Anda bisa letakkan ini di <head> atau sebelum </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
.modal-loading-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: none;
    z-index: 2000;
    border-radius: 0.5rem;
}

.modal-loading-backdrop .d-flex {
    min-height: 200px;
}

#modal-revisi-transportir.loading .modal-content {
    filter: blur(1px);
    pointer-events: none;
}
</style>

<!-- Kode Modal Anda -->
<div class="modal fade" id="modal-revisi-transportir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Revisi PO Transportir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="form-revisi-transportir" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <!-- Input fields -->
                        <input type="hidden" name="drs_unique" id="cp_drs_unique">
                        <input type="hidden" name="category" id="po_category" value="2">
                        <input type="hidden" name="po_id" id="po_id">

                        <div class="col-md-4">
                            <label>DRS No</label>
                            <input type="text" id="cp_drs_no" name="drs_no" class="form-control" readonly required>
                            <div class="invalid-feedback">Field DRS No wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Customer PO</label>
                            <input type="text" id="cp_customer_po" name="customer_po" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Customer PO wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Vendor PO</label>
                            <input type="text" id="cp_vendor_po" name="vendor_po" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Vendor PO wajib diisi.</div>
                        </div>

                        <div class="col-md-8">
                            <label>Vendor Name</label>
                            <input type="text" name="vendor_name" id="cp_vendor_name" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Vendor Name wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Tanggal PO</label>
                            <input type="text" name="tgl_po" id="cp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required>
                            <div class="invalid-feedback">Field Tanggal PO wajib diisi.</div>
                        </div>

                        <div class="col-md-6">
                            <label>Nama PIC</label>
                            <input type="text" name="pic_site" id="cp_nama" class="form-control" required>
                            <div class="invalid-feedback">Field Nama PIC wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                            <label>Contact</label>
                            <input type="text" name="pic_site_telp" id="cp_contact" class="form-control" required>
                            <div class="invalid-feedback">Field Contact wajib diisi.</div>
                        </div>
                        <div class="col-md-12">
                            <label>Alamat</label>
                            <input type="text" name="site_location" id="cp_alamat" class="form-control" required>
                            <div class="invalid-feedback">Field Alamat wajib diisi.</div>
                        </div>

                        <div class="col-md-12">
                            <label>Delivery To</label>
                            <input type="text" name="delivery_to" id="cp_delivery_to" class="form-control" required>
                            <div class="invalid-feedback">Field Delivery To wajib diisi.</div>
                        </div>

                        <div class="col-md-4">
                            <label>FOB</label>
                            <input type="text" name="fob" id="cp_fob" class="form-control" required>
                            <div class="invalid-feedback">Field FOB wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Loading Point</label>
                            <input type="text" name="loading_point" id="cp_loading_point" class="form-control" required>
                            <div class="invalid-feedback">Field Loading Point wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label>Shipped Via</label>
                            <input type="text" name="shipped_via" id="cp_shipped_via" class="form-control" required>
                            <div class="invalid-feedback">Field Shipped Via wajib diisi.</div>
                        </div>

                        <div class="col-md-3">
                            <label>Transport</label>
                            <input type="text" id="cp_transport" class="form-control" required>
                            <div class="invalid-feedback">Field Transport wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Uang Portal</label>
                            <input type="text" id="cp_portal" class="form-control" required>
                            <div class="invalid-feedback">Field Uang Portal wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Harga</label>
                            <input type="text" id="cp_harga" class="form-control" required>
                            <div class="invalid-feedback">Field Harga wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Qty</label>
                            <input type="number" name="qty" id="cp_qty" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Qty wajib diisi.</div>
                        </div>

                        <div class="col-md-4">
                            <label>Sub Total</label>
                            <input type="text" id="cp_sub_total" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Total</label>
                            <input type="text" id="cp_total" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Metode Pembayaran</label>
                            <select id="cp_term" name="term" class="form-control select2" required>
                            </select>
                            <div class="invalid-feedback">Field Metode Pembayaran wajib diisi.</div>
                        </div>

                        <!-- Hidden raw value inputs for decimal submission -->
                        <input type="hidden" id="cp_transport_raw" name="transport">
                        <input type="hidden" id="cp_portal_raw" name="portal">
                        <input type="hidden" id="cp_harga_raw" name="harga">
                        <input type="hidden" id="cp_sub_total_raw" name="sub_total">
                        <input type="hidden" id="cp_total_raw" name="total">

                        <div class="col-md-12">
                            <label>Terbilang</label>
                            <input type="text" name="terbilang" id="cp_terbilang" class="form-control" readonly>
                        </div>
                        <div class="col-md-12">
                            <label>Keterangan</label>
                            <textarea name="description" id="cp_description" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Additional Notes</label>
                            <textarea name="additional_notes" id="cp_additional_notes" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="form-revisi-transportir" id="btn-save-revisi-transportir" class="btn btn-primary" style="border-radius: 8px;">
                    <span class="txt">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span class="loading-text d-none">Saving...</span>
                </button>
            </div>

            <!-- Loading overlay -->
            <div class="modal-loading-backdrop" id="modalRevisiTransportirLoading">
              <div class="d-flex flex-column align-items-center justify-content-center h-100">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
                <div class="mt-3 fw-bold text-primary">Loading data...</div>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- Skrip yang diperbaiki -->
<script>
// Menjalankan skrip setelah semua elemen halaman (DOM) selesai dimuat
$(document).ready(function() {

    // Fungsi untuk memformat input menjadi format Rupiah saat diketik
    // dan memicu perhitungan ulang
    function formatAndCalcTransportir(event) {
        var $el = $(event.currentTarget);
        var numeric = $el.val().replace(/[^\d]/g, '');

        console.log('formatAndCalcTransportir - Element ID:', $el.attr('id'), 'Numeric value:', numeric);

        // Simpan nilai mentah ke input hidden dalam konteks modal
        var $modal = $('#modal-revisi-transportir');
        var rawFieldId = '#' + $el.attr('id') + '_raw';
        $modal.find(rawFieldId).val(numeric || 0);

        console.log('Updated raw field:', rawFieldId, 'with value:', numeric || 0);

        // Format nilai yang terlihat dengan format Rupiah
        $el.val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');

        // Panggil fungsi kalkulasi lokal untuk modal ini
        calcTransportirFieldsModal();
    }

    // Fungsi kalkulasi khusus untuk modal revisi transportir
    function calcTransportirFieldsModal() {
        console.log('calcTransportirFieldsModal called');

        var $modal = $('#modal-revisi-transportir');

        // Debug: Check raw field values
        console.log('Raw field values:');
        console.log('cp_qty:', $modal.find('#cp_qty').val());
        console.log('cp_harga_raw:', $modal.find('#cp_harga_raw').val());
        console.log('cp_portal_raw:', $modal.find('#cp_portal_raw').val());

        var qty = parseFloat($modal.find('#cp_qty').val().replace(/\D/g,'')) || 0;
        var harga = parseFloat($modal.find('#cp_harga_raw').val()) || 0;
        var portal = parseFloat($modal.find('#cp_portal_raw').val()) || 0;

        console.log('Modal values:', {qty: qty, harga: harga, portal: portal});

        var subTotal = qty * harga;
        var total = portal + subTotal;

        // Set transport equal to harga
        $modal.find('#cp_transport_raw').val(harga);
        $modal.find('#cp_transport').val(harga ? 'Rp. ' + harga.toLocaleString('id-ID') : '');

        console.log('Modal calculated:', {subTotal: subTotal, total: total});

        var subTotalText = 'Rp. ' + subTotal.toLocaleString('id-ID');
        var totalText = 'Rp. ' + total.toLocaleString('id-ID');

        // Update fields within modal context
        $modal.find('#cp_sub_total').val(subTotalText);
        $modal.find('#cp_sub_total_raw').val(subTotal);
        $modal.find('#cp_total').val(totalText);
        $modal.find('#cp_total_raw').val(total);

        var terbilangText = total ? terbilang(Math.round(total)) + ' rupiah' : 'nol rupiah';
        $modal.find('#cp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));

        console.log('Modal fields updated');
    }

    // Helper: Fungsi untuk mengubah angka menjadi terbilang dalam Bahasa Indonesia
    function terbilang(n) {
        var angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        n = Math.floor(n);
        if (n < 12) return angka[n];
        if (n < 20) return terbilang(n - 10) + " belas";
        if (n < 100) return terbilang(Math.floor(n / 10)) + " puluh" + (n % 10 ? " " + terbilang(n % 10) : "");
        if (n < 200) return "seratus" + (n - 100 ? " " + terbilang(n - 100) : "");
        if (n < 1000) return terbilang(Math.floor(n / 100)) + " ratus" + (n % 100 ? " " + terbilang(n % 100) : "");
        if (n < 2000) return "seribu" + (n - 1000 ? " " + terbilang(n - 1000) : "");
        if (n < 1000000) return terbilang(Math.floor(n / 1000)) + " ribu" + (n % 1000 ? " " + terbilang(n % 1000) : "");
        if (n < 1000000000) return terbilang(Math.floor(n / 1000000)) + " juta" + (n % 1000000 ? " " + terbilang(n % 1000000) : "");
        return terbilang(Math.floor(n / 1000000000)) + " miliar" + (n % 1000000000 ? " " + terbilang(n % 1000000000) : "");
    }

    // --- Event Listeners ---
    // Menggunakan event delegation untuk elemen yang mungkin ada di dalam modal
    $(document).on('keyup', '#cp_portal, #cp_harga', formatAndCalcTransportir);

    // Jika nilai Qty bisa berubah, event listener ini akan berguna
    $(document).on('keyup change', '#cp_qty', function() {
        calcTransportirFieldsModal();
    });

    // Event handler untuk datepicker - auto close setelah pilih tanggal
    $(document).on('change', '#cp_tgl_po', function() {
        // Trigger blur event untuk menutup datepicker
        $(this).blur();
    });

    // Alternative: Use datepicker's onSelect event if available
    $(document).on('dp.change', '#cp_tgl_po', function() {
        // Close datepicker after selection
        $(this).blur();
    });

    // Additional datepicker close handlers
    $(document).on('click', '#cp_tgl_po', function() {
        // Close datepicker when clicking on the input
        setTimeout(function() {
            $('#cp_tgl_po').blur();
        }, 100);
    });

    // Close datepicker when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.datepicker').length && !$(e.target).closest('#cp_tgl_po').length) {
            $('#cp_tgl_po').blur();
        }
    });

    // Menjalankan kalkulasi saat modal pertama kali ditampilkan
    $('#modal-revisi-transportir').on('shown.bs.modal', function() {
        // Memformat nilai awal portal dan harga saat modal dibuka
        $('#cp_portal').trigger('keyup');
        $('#cp_harga').trigger('keyup');
        // lalu panggil kalkulasi utama
        calcTransportirFieldsModal();
    });
});
</script>
