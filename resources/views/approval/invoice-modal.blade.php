<!-- Invoice Approval Modal -->
<div class="modal fade" id="invoiceApprovalModal" tabindex="-1" aria-labelledby="invoiceApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceApprovalModalLabel">Detail Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-invoice-approval">
                    @csrf
                    <h5>Informasi Utama</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Dn No</label>
                            <input type="text" class="form-control" name="dn_no" id="modal_dn_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Customer PO</label>
                            <input type="text" class="form-control" name="po_no" id="modal_po_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nomor Invoice</label>
                            <input type="text" class="form-control" name="invoice_no" id="modal_invoice_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Invoice</label>
                            <input type="date" class="form-control" name="invoice_date" id="modal_invoice_date" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ditagihkan Kepada (Bill To)</label>
                            <textarea class="form-control" name="bill_to" id="modal_bill_to" rows="3" readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dikirimkan Kepada (Ship To)</label>
                            <textarea class="form-control" name="ship_to" id="modal_ship_to" rows="3" readonly></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <input type="text" class="form-control" name="payment_method" id="modal_payment_method" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">FOB</label>
                            <input type="text" class="form-control" name="fob" id="modal_fob" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jalur</label>
                            <input type="text" class="form-control" name="sent_via" id="modal_sent_via" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Sent Date</label>
                            <input type="date" class="form-control" name="sent_date" id="modal_sent_date" readonly>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <a href="#" id="modal_btn_lihat_po" class="btn btn-sq-rounded btn-outline-info shadow-sm px-4 py-2" target="_blank" style="border-radius: 12px; border-width: 2px; box-shadow: 0 2px 8px rgba(91,107,232,0.08); font-weight: 600; display:none;">
                                Lihat PO
                            </a>
                            <a href="#" id="modal_btn_lihat_bast" class="btn btn-sq-rounded btn-outline-warning shadow-sm px-4 py-2" target="_blank" style="border-radius: 12px; border-width: 2px; box-shadow: 0 2px 8px rgba(255,193,7,0.08); font-weight: 600; display:none;">
                                Lihat BAST
                            </a>
                        </div>
                    </div>
                    <hr class="mt-4 mb-4">
                    <h5>Detail Item</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="modal-invoice-items-table">
                            <thead>
                                <tr>
                                    <th style="width: 4%;">NO</th>
                                    <th style="width: 40%;">Nama Item</th>
                                    <th style="width: 15%;">Quantity</th>
                                    <th style="width: 20%;">Harga</th>
                                    <th style="width: 15%;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Baris item akan ditambahkan oleh JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-3">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between">
                                <span>Sub Total:</span>
                                <span id="modal_subtotal">0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PPN (11%):</span>
                                <span id="modal_tax">0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PBBKB (7,5%):</span>
                                <span id="modal_pbbkb">0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PPH 23 (2%):</span>
                                <span id="modal_pph23">0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total:</span>
                                <span id="modal_grand_total">0</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="fw-bold">Terbilang:</span>
                                <span id="modal_terbilang" class="fst-italic"></span>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">
                    <h5>Approval Decision</h5>

                    <!-- Remark History Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Remark History:</h6>
                        <div class="border rounded p-3 bg-light">
                            <ul class="list-unstyled mb-0 text-dark" id="modalRemarkHistory"></ul>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Decision:</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_approve" value="approve" required>
                                    <label class="form-check-label text-success fw-bold" for="decision_approve">
                                        Approve
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_revisi" value="revisi" required>
                                    <label class="form-check-label text-danger fw-bold" for="decision_revisi">
                                        Revisi
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Remark / Comment:</label>
                            <textarea class="form-control" name="remark" id="modal_remark" rows="4" placeholder="Masukkan komentar atau alasan approval/rejection..." required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sq-rounded text-white" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success btn-sq-rounded text-white" id="btn-submit-approval">
                    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom style mirip screenshot */
#modal-invoice-items-table thead th {
    background: #5b6be8 !important;
    color: #fff !important;
    text-align: left;
    vertical-align: middle;
}
#modal-invoice-items-table tbody td, #modal-invoice-items-table thead th {
    vertical-align: middle !important;
}
.btn-sq-rounded {
    border-radius: 8px !important;
    padding: 8px 20px !important;
    font-weight: 600;
    border: none !important;
    transition: 0.2s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.btn-sq-rounded:hover, .btn-sq-rounded:focus {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-1px);
}
</style>

<script>
// Terbilang Indonesia sederhana
function terbilang(nilai) {
    var satuan = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    nilai = Math.floor(nilai);
    if (nilai < 12) return satuan[nilai];
    if (nilai < 20) return terbilang(nilai - 10) + " belas";
    if (nilai < 100) return terbilang(Math.floor(nilai / 10)) + " puluh " + terbilang(nilai % 10);
    if (nilai < 200) return "seratus " + terbilang(nilai - 100);
    if (nilai < 1000) return terbilang(Math.floor(nilai / 100)) + " ratus " + terbilang(nilai % 100);
    if (nilai < 2000) return "seribu " + terbilang(nilai - 1000);
    if (nilai < 1000000) return terbilang(Math.floor(nilai / 1000)) + " ribu " + terbilang(nilai % 1000);
    if (nilai < 1000000000) return terbilang(Math.floor(nilai / 1000000)) + " juta " + terbilang(nilai % 1000000);
    if (nilai < 1000000000000) return terbilang(Math.floor(nilai / 1000000000)) + " milyar " + terbilang(nilai % 1000000000);
    return "";
}

// Format Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(angka || 0);
}

// Public URL for PDF files
const publicUrl = `https://is3.cloudhost.id/bensinkustorage/`;

// Load invoice data for modal
function loadInvoiceDataForModal(invoiceId) {
    console.log('Loading invoice data for modal, ID:', invoiceId);

    // Show loading state
    $('#modal-invoice-items-table tbody').html('<tr><td colspan="5" class="text-center"><div class="spinner-border text-primary"></div> Loading...</td></tr>');

    $.ajax({
        url: `/api/finance/invoices/${invoiceId}/view-details`,
        method: 'GET',
        success: function(response) {
            console.log('Modal API Response:', response);

            if (response.success && response.data) {
                const invoice = response.data.invoice;
                const details = response.data.details || [];

                // Populate form fields
                $('#modal_dn_no').val(invoice.drs_no || '');
                $('#modal_po_no').val(invoice.po_no || '');
                $('#modal_invoice_no').val(invoice.invoice_no || '');
                $('#modal_invoice_date').val(invoice.invoice_date || '');
                $('#modal_ship_to').val(invoice.ship_to || '');
                $('#modal_bill_to').val(invoice.bill_to || '');
                $('#modal_fob').val(invoice.fob || '');
                $('#modal_sent_via').val(invoice.sent_via || '');
                $('#modal_sent_date').val(invoice.sent_date || '');
                $('#modal_payment_method').val(invoice.terms || '');

                // Populate totals
                $('#modal_subtotal').text(formatRupiah(invoice.sub_total || 0));
                $('#modal_tax').text(formatRupiah(invoice.ppn || 0));
                $('#modal_pbbkb').text(formatRupiah(invoice.pbbkb || 0));
                $('#modal_pph23').text(formatRupiah(invoice.pph || 0));
                $('#modal_grand_total').text(formatRupiah(invoice.total || 0));

                // Calculate and display terbilang
                let grandTotal = invoice.total || 0;
                let valTerbilang = "";
                if (grandTotal > 0) {
                    valTerbilang = terbilang(grandTotal).replace(/\s+/g, ' ').trim() + " rupiah";
                    valTerbilang = valTerbilang.replace(/  +/g, ' ');
                }
                $('#modal_terbilang').text(valTerbilang);

                // Populate details table
                $('#modal-invoice-items-table tbody').empty();
                if (details.length > 0) {
                    details.forEach(function(item, index) {
                        let newRow = `
                            <tr>
                                <td class="text-center align-middle">${index + 1}</td>
                                <td class="align-middle">${item.nama_item || ''}</td>
                                <td class="text-center align-middle">${item.qty || 0}</td>
                                <td class="text-end align-middle">${formatRupiah(item.harga || 0)}</td>
                                <td class="text-end align-middle">${formatRupiah(item.total || 0)}</td>
                            </tr>
                        `;
                        $('#modal-invoice-items-table tbody').append(newRow);
                    });
                } else {
                    let newRow = `
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada detail item</td>
                        </tr>
                    `;
                    $('#modal-invoice-items-table tbody').append(newRow);
                }

                // Show PDF buttons if files exist
                if (invoice.po_file) {
                    $('#modal_btn_lihat_po').attr('href', publicUrl + invoice.po_file).attr('target', '_blank').show();
                } else {
                    $('#modal_btn_lihat_po').hide();
                }
                if (invoice.dn_file) {
                    $('#modal_btn_lihat_bast').attr('href', publicUrl + invoice.dn_file).attr('target', '_blank').show();
                } else {
                    $('#modal_btn_lihat_bast').hide();
                }

            } else {
                console.error('Invalid API response:', response);
                $('#modal-invoice-items-table tbody').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat data invoice</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Modal API Error:', xhr, status, error);
            $('#modal-invoice-items-table tbody').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat data invoice</td></tr>');
        }
    });
}

// Submit approval function
function submitInvoiceApproval(invoiceId) {
    const decision = $('input[name="decision"]:checked').val();
    const remark = $('#modal_remark').val();

    if (!decision) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Pilih decision (Approve/Reject)',
        });
        return;
    }

    if (!remark.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Remark/Comment harus diisi',
        });
        return;
    }

    const submitButton = $('#btn-submit-approval');
    const spinner = submitButton.find('.spinner-border');

    // Show loading state
    submitButton.prop('disabled', true);
    spinner.removeClass('d-none');

    $.ajax({
        url: `/api/approval/verify-invoice/${invoiceId}`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            decision: decision,
            remark: remark
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Approval berhasil disubmit',
            }).then(() => {
                $('#invoiceApprovalModal').modal('hide');
                // Reload the invoice table
                if (typeof invoiceTable !== 'undefined') {
                    invoiceTable.ajax.reload();
                }
                // Reload summary cards by calling the API
                $.get('/api/approval/details')
                    .done(function(res) {
                        if (res.data) {
                            $('#card-total_sph').text(res.data.sph.count || 0);
                            $('#card-waiting').text(res.data.supplier.count || 0);
                            $('#card-revisi').text(res.data.transporter.count || 0);
                            $('#card-invoice').text(res.data.invoice.count || 0);
                        }
                    })
                    .fail(function() {
                        console.log('Failed to reload summary cards');
                    });
            });
        },
        error: function(xhr) {
            let errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMsg,
            });
        },
        complete: function() {
            // Reset loading state
            submitButton.prop('disabled', false);
            spinner.addClass('d-none');
        }
    });
}

// Load remark history function
function loadRemarks(id, tipe, container) {
    // show loading spinner
    $(container).html('<li class="text-center py-2"><div class="spinner-border text-primary"></div> Memuat riwayat…</li>');

    $.get(`/api/remarks/${id}?tipe_trx=${tipe}`)
        .done(function(remarks){
            if (!remarks.length) {
                $(container).html('<li class="text-muted">Belum ada remark</li>');
                return;
            }
            var html = remarks.map(function(r){
                var color = 'primary';
                var user = r.user || r.last_updateby || 'User';
                var comment = r.comment || r.wf_comment || '';
                if (comment.toLowerCase().includes('approve')) color = 'success';
                if (comment.toLowerCase().includes('reject'))  color = 'danger';
                var created = r.created_at
                    ? new Date(r.created_at).toLocaleDateString('id-ID', { year:'numeric', month:'long', day:'numeric' })
                    : '';
                return `<li class="mb-2 pb-2 border-bottom">
                    <span class="fw-bold text-${color}">• ${user}</span> -
                    <span class="text-dark">${comment}</span>
                    <span class="text-muted ms-2 small">(${created})</span>
                </li>`;
            }).join('');
            $(container).html(html);
        })
        .fail(function(){
            $(container).html('<li class="text-danger">Gagal memuat riwayat.</li>');
        });
}

// Initialize modal events
$(document).ready(function() {
    // Submit button click handler
    $('#btn-submit-approval').on('click', function() {
        const invoiceId = $(this).data('invoice-id');
        submitInvoiceApproval(invoiceId);
    });

        // Modal show event - reset form
    $('#invoiceApprovalModal').on('show.bs.modal', function(event) {
        // Get invoice ID from submit button (set by click handler)
        const invoiceId = $('#btn-submit-approval').data('invoice-id');
        console.log('Modal show event - Invoice ID:', invoiceId);

        if (!invoiceId) {
            console.error('No invoice ID found in modal show event');
            return;
        }

                // Reset form
        $('#form-invoice-approval')[0].reset();
        $('#modal_remark').val('');

        // Load invoice data
        loadInvoiceDataForModal(invoiceId);

        // Load remark history
        loadRemarks(invoiceId, 'invoice', '#modalRemarkHistory');
    });
});
</script>
