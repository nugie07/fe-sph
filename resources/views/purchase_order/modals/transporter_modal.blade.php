<!-- CREATE PO TRANSPORTER MODAL -->
<div class="modal fade" id="modal-create-po" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Loading overlay for transporter modal -->
            <div class="modal-loading-backdrop" id="modalCreatePOTransporterLoading">
                <div class="spinner-border text-primary" role="status" style="width:3rem; height:3rem;"></div>
            </div>
            
            <form id="form-create-po">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pembuatan PO Transportir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <input type="hidden" name="drs_unique" id="cp_drs_unique">
                    
                    <!-- Baris 1 -->
                    <div class="col-md-4">
                        <label>DRS No</label>
                        <input type="text" id="cp_drs_no" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Customer PO</label>
                        <input type="text" id="cp_customer_po" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Vendor PO</label>
                        <input type="text" id="cp_vendor_po" class="form-control" readonly required>
                    </div>

                    <!-- Baris 2 -->
                    <div class="col-md-8">
                        <label>Vendor Name</label>
                        <input type="text" name="vendor_name" id="cp_vendor_name" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal PO</label>
                        <input type="text" name="tgl_po" id="cp_tgl_po" class="form-control datepicker-here" data-language="en" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" required>
                    </div>

                    <!-- Baris 3 -->
                    <div class="col-md-6">
                        <label>Nama PIC</label>
                        <input type="text" name="pic_site" id="cp_nama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Contact</label>
                        <input type="text" name="pic_site_telp" id="cp_contact" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Alamat</label>
                        <input type="text" name="site_location" id="cp_alamat" class="form-control" required>
                    </div>

                    <!-- Baris 4 -->
                    <div class="col-md-12">
                        <label>Delivery To</label>
                        <input type="text" name="delivery_to" id="cp_delivery_to" class="form-control" required>
                    </div>

                    <!-- Baris 5 -->
                    <div class="col-md-4">
                        <label>FOB</label>
                        <input type="text" name="fob" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Loading Point</label>
                        <input type="text" name="loading_point" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Shipped Via</label>
                        <input type="text" name="shipped_via" class="form-control" required>
                    </div>
                    
                    <!-- Comments Or Special Notes -->
                    <div class="col-md-12">
                        <label>Comments Or Special Notes</label>
                        <textarea name="special_notes" id="cp_special_notes" class="form-control"></textarea>
                    </div>

                    <!-- Baris 6 -->
                    <div class="col-md-3">
                        <label>Transport</label>
                        <input type="hidden" name="transport" id="cp_transport_raw" required>
                        <input type="text" id="cp_transport" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-3">
                        <label>Uang Portal</label>
                        <input type="hidden" name="portal" id="cp_portal_raw" required>
                        <input type="text" id="cp_portal" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-3">
                        <label>Harga</label>
                        <input type="hidden" name="harga" id="cp_harga_raw" required>
                        <input type="text" id="cp_harga" class="form-control" placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-3">
                        <label>Qty</label>
                        <input type="text" id="cp_qty" class="form-control" readonly required>
                    </div>

                    <!-- Baris 7 -->
                    <div class="col-md-4">
                        <label>
                            Sub Total&nbsp;
                            <i class="fa fa-info-circle text-secondary" data-bs-toggle="tooltip" title="Rumus SubTotal = (Qty * Harga) * Transport" style="cursor: help;"></i>
                        </label>
                        <input type="hidden" name="sub_total" id="cp_sub_total_raw" required>
                        <input type="text" id="cp_sub_total" class="form-control" readonly placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-4">
                        <label>
                            Total&nbsp;
                            <i class="fa fa-info-circle text-secondary" data-bs-toggle="tooltip" title="Rumus Total = SubTotal + Portal" style="cursor: help;"></i>
                        </label>
                        <input type="hidden" name="total" id="cp_total_raw" required>
                        <input type="text" id="cp_total" class="form-control" readonly placeholder="Rp. 0" required>
                    </div>
                    <div class="col-md-4">
                        <label>Metode Pembayaran</label>
                        <select id="cp_term" name="term" class="form-control select2" data-placeholder="Pilih Metode Pembayaran" style="width:100%" required>
                            <option value=""></option>
                        </select>
                    </div>

                    <!-- Baris 8 -->
                    <div class="col-md-12">
                        <label>Terbilang</label>
                        <input type="text" name="terbilang" id="cp_terbilang" class="form-control" readonly required>
                    </div>

                    <!-- Baris 9 -->
                    <div class="col-md-12">
                        <label>Keterangan</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <!-- Baris 10 -->
                    <div class="col-md-12">
                        <label>Additional Notes</label>
                        <textarea name="additional_notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save-po" class="btn btn-primary rounded-square">
                        <span class="txt">Simpan</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 