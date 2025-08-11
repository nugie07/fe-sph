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

#modal-revisi-po-supplier.loading .modal-content {
    filter: blur(1px);
    pointer-events: none;
}
</style>

<!-- Kode Modal Anda -->
<div class="modal fade" id="modal-revisi-po-supplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Revisi PO Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="form-revisi-po-supplier" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <!-- Input fields (tidak ada perubahan di sini) -->
                        <input type="hidden" name="drs_unique" id="sp_drs_unique">
                        <input type="hidden" name="category" id="po_category" value="1">
                        <input type="hidden" name="po_id" id="po_id">
                        <div class="col-md-4">
                          <label>Nomer PO</label>
                          <input type="text" name="vendor_po" id="sp_vendor_po" class="form-control" readonly required>
                          <div class="invalid-feedback">Field Nomer PO wajib diisi.</div>
                        </div>
                        <div class="col-md-5">
                            <label>DRS No</label>
                            <input type="text" id="sp_drs_no" name="drs_no" class="form-control" readonly>
                            <div class="invalid-feedback">Field DRS No wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                          <label>Dn No</label>
                          <input type="text" id="sp_dn_no" name="dn_no" class="form-control" readonly required>
                          <div class="invalid-feedback">Field Dn No wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                          <label>Vendor Name</label>
                          <select id="sp_vendor_name" name="vendor_name" class="form-control select2" required>
                          </select>
                          <div class="invalid-feedback">Field Vendor Name wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                          <label>Customer PO</label>
                          <input type="text" name="customer_po" id="sp_customer_po" class="form-control" readonly required>
                          <div class="invalid-feedback">Field Customer PO wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                          <label>Tanggal PO</label>
                          <input type="text" name="tgl_po" id="sp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required>
                          <div class="invalid-feedback">Field Tanggal PO wajib diisi.</div>
                        </div>
                        <div class="col-md-5">
                          <label>Nama PIC</label>
                          <input type="text" name="nama" id="sp_nama" class="form-control" required>
                          <div class="invalid-feedback">Field Nama PIC wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>Contact</label>
                          <input type="text" name="contact" id="sp_contact" class="form-control" required>
                          <div class="invalid-feedback">Field Contact wajib diisi.</div>
                        </div>
                        <div class="col-md-12">
                          <label>Alamat</label>
                          <input type="text" name="alamat" id="sp_alamat" class="form-control" required>
                          <div class="invalid-feedback">Field Alamat wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>Metode Pembayaran</label>
                          <select id="sp_term" name="term" class="form-control select2" required></select>
                          <div class="invalid-feedback">Field Metode Pembayaran wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>FOB</label>
                          <input type="text" name="fob" id="sp_fob" class="form-control" required>
                          <div class="invalid-feedback">Field FOB wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>Shipped Via</label>
                          <input type="text" name="shipped_via" id="sp_shipped_via" class="form-control" required>
                          <div class="invalid-feedback">Field Shipped Via wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                          <label>Loading Point</label>
                          <input type="text" name="loading_point" id="sp_loading_point" class="form-control" required>
                          <div class="invalid-feedback">Field Loading Point wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                          <label>Delivery To</label>
                          <input type="text" name="delivery_to" id="sp_delivery_to" class="form-control" required>
                          <div class="invalid-feedback">Field Delivery To wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>Transport</label>
                          <input type="text" id="sp_transport" class="form-control" required>
                          <div class="invalid-feedback">Field Transport wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>Harga</label>
                          <input type="text" id="sp_harga" class="form-control" required>
                          <div class="invalid-feedback">Field Harga wajib diisi.</div>
                        </div>
                        <div class="col-md-4">
                          <label>Qty</label>
                          <input type="number" name="qty" id="sp_qty" class="form-control" readonly required>
                          <div class="invalid-feedback">Field Qty wajib diisi.</div>
                        </div>
                        <div class="col-md-4"><label>Sub Total</label><input type="text" id="sp_sub_total" class="form-control" readonly></div>
                        <div class="col-md-4"><label>PPN</label><input type="text" id="sp_ppn" class="form-control" readonly></div>
                        <div class="col-md-4"><label>PPH</label><input type="text" id="sp_pph" class="form-control" readonly></div>
                        <div class="col-md-4"><label>PBBKB</label><input type="text" id="sp_pbbkb" class="form-control" readonly></div>
                        <div class="col-md-4"><label>BPH</label><input type="text" id="sp_bph" class="form-control" readonly></div>
                        <div class="col-md-4"><label>Total</label><input type="text" id="sp_total" class="form-control" readonly></div>

                        <!-- Hidden raw value inputs for decimal submission -->
                        <input type="hidden" id="sp_transport_raw" name="transport">
                        <input type="hidden" id="sp_harga_raw" name="harga">
                        <input type="hidden" id="sp_sub_total_raw" name="sub_total">
                        <input type="hidden" id="sp_ppn_raw" name="ppn">
                        <input type="hidden" id="sp_pbbkb_raw" name="pbbkb">
                        <input type="hidden" id="sp_pph_raw" name="pph">
                        <input type="hidden" id="sp_bph_raw" name="bph">
                        <input type="hidden" id="sp_total_raw" name="total">

                        <div class="col-md-12"><label>Terbilang</label><input type="text" name="terbilang" id="sp_terbilang" class="form-control" readonly></div>
                        <div class="col-md-12"><label>Keterangan</label><textarea name="description" id="sp_description" class="form-control"></textarea></div>
                        <div class="col-md-12"><label>Additional Notes</label><textarea name="additional_notes" id="sp_additional_notes" class="form-control"></textarea></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="form-revisi-po-supplier" id="btn-save-revisi-supplier" class="btn btn-primary" style="border-radius: 8px;">
                    <span class="txt">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span class="loading-text d-none">Saving...</span>
                </button>
            </div>
            <!-- Loading overlay -->
            <div class="modal-loading-backdrop" id="modalRevisiSupplierLoading">
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
    function formatAndCalc(event) {
        var $el = $(event.currentTarget); // Menggunakan event.currentTarget untuk kejelasan
        var numeric = $el.val().replace(/[^\d]/g, ''); // Hanya ambil angka, hapus semua karakter non-digit

        console.log('formatAndCalc - Element ID:', $el.attr('id'), 'Numeric value:', numeric);

        // Simpan nilai mentah ke input hidden dalam konteks modal
        var $modal = $('#modal-revisi-po-supplier');
        var rawFieldId = '#' + $el.attr('id') + '_raw';
        $modal.find(rawFieldId).val(numeric || 0);

        console.log('Updated raw field:', rawFieldId, 'with value:', numeric || 0);

        // Format nilai yang terlihat dengan format Rupiah
        $el.val(numeric ? 'Rp. ' + parseInt(numeric, 10).toLocaleString('id-ID') : '');

        // Panggil fungsi kalkulasi lokal untuk modal ini
        calcSupplierFieldsModal();
    }

        // Fungsi kalkulasi khusus untuk modal revisi supplier
    function calcSupplierFieldsModal() {
        console.log('calcSupplierFieldsModal called');

        var $modal = $('#modal-revisi-po-supplier');

        // Debug: Check raw field values
        console.log('Raw field values:');
        console.log('sp_qty:', $modal.find('#sp_qty').val());
        console.log('sp_harga_raw:', $modal.find('#sp_harga_raw').val());
        console.log('sp_transport_raw:', $modal.find('#sp_transport_raw').val());

        var qty = parseFloat($modal.find('#sp_qty').val().replace(/\D/g,'')) || 0;
        var harga = parseFloat($modal.find('#sp_harga_raw').val()) || 0;
        var transport = parseFloat($modal.find('#sp_transport_raw').val()) || 0;

        console.log('Modal values:', {qty: qty, harga: harga, transport: transport});

        var subtotal = (qty * harga) + transport;
        var valPPN = subtotal * 0.11;
        var valPBBKB = (qty * harga) * 0.075;
        var valPPh = (qty * harga) * 0.03;
        var valBPH = (qty * harga) * 0.025;
        var total = subtotal + valPPN + valPBBKB + valPPh + valBPH;

        console.log('Modal calculated:', {subtotal: subtotal, total: total});

        var subTotalText = 'Rp. ' + subtotal.toLocaleString('id-ID');
        var ppnText = 'Rp. ' + Math.round(valPPN).toLocaleString('id-ID');
        var pbbkbText = 'Rp. ' + Math.round(valPBBKB).toLocaleString('id-ID');
        var bphText = 'Rp. ' + Math.round(valBPH).toLocaleString('id-ID');
        var pphText = 'Rp. ' + Math.round(valPPh).toLocaleString('id-ID');
        var totalText = 'Rp. ' + Math.round(total).toLocaleString('id-ID');

        // Update fields within modal context
        $modal.find('#sp_sub_total').val(subTotalText);
        $modal.find('#sp_sub_total_raw').val(subtotal);
        $modal.find('#sp_ppn').val(ppnText);
        $modal.find('#sp_ppn_raw').val(Math.round(valPPN));
        $modal.find('#sp_pbbkb').val(pbbkbText);
        $modal.find('#sp_pbbkb_raw').val(Math.round(valPBBKB));
        $modal.find('#sp_bph').val(bphText);
        $modal.find('#sp_bph_raw').val(Math.round(valBPH));
        $modal.find('#sp_pph').val(pphText);
        $modal.find('#sp_pph_raw').val(Math.round(valPPh));
        $modal.find('#sp_total').val(totalText);
        $modal.find('#sp_total_raw').val(Math.round(total));

        var terbilangText = total ? terbilang(Math.round(total)) + ' rupiah' : 'nol rupiah';
        $modal.find('#sp_terbilang').val(terbilangText.charAt(0).toUpperCase() + terbilangText.slice(1));

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
    // 'keyup' lebih responsif daripada 'input' atau 'change' untuk pemformatan
    $(document).on('keyup', '#sp_transport, #sp_harga', formatAndCalc);

    // Jika nilai Qty bisa berubah, event listener ini akan berguna
    $(document).on('keyup change', '#sp_qty', function() {
        calcSupplierFieldsModal();
    });

    // Event handler untuk Vendor Name change - update PIC, Contact, dan Alamat
    $(document).on('change', '#sp_vendor_name', function() {
        var $modal = $('#modal-revisi-po-supplier');
        var $sel = $(this).find('option:selected');

        // Update PIC, Contact, dan Alamat berdasarkan vendor yang dipilih
        $modal.find('#sp_nama').val($sel.data('nama') || '');
        $modal.find('#sp_contact').val($sel.data('contact') || '');
        $modal.find('#sp_alamat').val($sel.data('alamat') || '');

        // Update Vendor PO jika ada format
        var format = $sel.data('format') || '';
        var dnNo = $modal.find('#sp_dn_no').val();
        if (format && dnNo) {
            var now = new Date();
            var romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][now.getMonth()];
            var tahun = now.getFullYear();
            var vendorPO = format.replace(/{nomor}|{NOMOR}/g, dnNo)
                                 .replace(/{bulan}|{BULAN}/g, romawi)
                                 .replace(/{tahun}|{TAHUN}/g, tahun);
            $modal.find('#sp_vendor_po').val(vendorPO);
        }
    });

        // Event handler untuk datepicker - auto close setelah pilih tanggal
    $(document).on('change', '#sp_tgl_po', function() {
        // Trigger blur event untuk menutup datepicker
        $(this).blur();
    });

    // Alternative: Use datepicker's onSelect event if available
    $(document).on('dp.change', '#sp_tgl_po', function() {
        // Close datepicker after selection
        $(this).blur();
    });

    // Additional datepicker close handlers
    $(document).on('click', '#sp_tgl_po', function() {
        // Close datepicker when clicking on the input
        setTimeout(function() {
            $('#sp_tgl_po').blur();
        }, 100);
    });

    // Close datepicker when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.datepicker').length && !$(e.target).closest('#sp_tgl_po').length) {
            $('#sp_tgl_po').blur();
        }
    });

    // Menjalankan kalkulasi saat modal pertama kali ditampilkan
    $('#modal-revisi-po-supplier').on('shown.bs.modal', function() {
        // Memformat nilai awal transport dan harga saat modal dibuka
        $('#sp_transport').trigger('keyup');
        $('#sp_harga').trigger('keyup');
        // lalu panggil kalkulasi utama
        calcSupplierFieldsModal();
    });
});
</script>
