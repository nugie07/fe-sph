<!-- CREATE PO SUPPLIER MODAL -->
<div class="modal fade" id="modal-create-po-supplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pembuatan PO Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-create-po-supplier" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <input type="hidden" name="drs_unique" id="sp_drs_unique">
                        <input type="hidden" name="category" id="po_category" value="1">
                        
                        <div class="col-md-4">
                            <label>Nomer PO</label>
                            <input type="text" name="vendor_po" id="sp_vendor_po" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Nomer PO wajib diisi.</div>
                        </div>
                        <div class="col-md-5">
                            <label>DRS No</label>
                            <select id="sp_drs_no" name="drs_no" class="form-control select2" required></select>
                            <div class="invalid-feedback">Field DRS No wajib diisi.</div>
                        </div>
                        <div class="col-md-3">
                            <label>Dn No</label>
                            <input type="text" id="sp_dn_no" class="form-control" readonly required>
                            <div class="invalid-feedback">Field Dn No wajib diisi.</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label>Vendor Name</label>
                            <select id="sp_vendor_name" name="vendor_name" class="form-control select2" required></select>
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
                        
                        <div class="col-md-4">
                            <label>Sub Total</label>
                            <input type="text" id="sp_sub_total" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>PPN</label>
                            <input type="text" id="sp_ppn" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>PPH</label>
                            <input type="text" id="sp_pph" class="form-control" readonly>
                        </div>
                        
                        <div class="col-md-4">
                            <label>PBBKB</label>
                            <input type="text" id="sp_pbbkb" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>BPH</label>
                            <input type="text" id="sp_bph" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Total</label>
                            <input type="text" id="sp_total" class="form-control" readonly>
                        </div>
                        
                        <!-- Hidden raw value inputs for decimal submission -->
                        <input type="hidden" id="sp_transport_raw" name="transport">
                        <input type="hidden" id="sp_harga_raw" name="harga">
                        <input type="hidden" id="sp_sub_total_raw" name="sub_total">
                        <input type="hidden" id="sp_ppn_raw" name="ppn">
                        <input type="hidden" id="sp_pbbkb_raw" name="pbbkb">
                        <input type="hidden" id="sp_pph_raw" name="pph">
                        <input type="hidden" id="sp_bph_raw" name="bph">
                        <input type="hidden" id="sp_total_raw" name="total">
                        
                        <div class="col-md-12">
                            <label>Terbilang</label>
                            <input type="text" name="terbilang" id="sp_terbilang" class="form-control" readonly>
                        </div>
                        <div class="col-md-12">
                            <label>Keterangan</label>
                            <textarea name="description" id="sp_description" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Additional Notes</label>
                            <textarea name="additional_notes" id="sp_additional_notes" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form-create-po-supplier" id="btn-save-supplier" class="btn btn-primary rounded-square">
                    <span class="txt">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
            
            <!-- Loading overlay -->
            <div class="modal-loading-backdrop" id="modalCreatePOLoading">
                <div class="d-flex flex-column align-items-center">
                    <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"></div>
                    <div class="mt-2 fw-bold text-primary">Loading data...</div>
                </div>
            </div>
        </div>
    </div>
</div> 