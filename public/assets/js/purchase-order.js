/**
 * Purchase Order Management JavaScript
 * Handles all PO-related functionality including modals, calculations, and API calls
 */

class PurchaseOrderManager {
    constructor() {
        this.table = null;
        this.init();
    }

    init() {
        console.log('PurchaseOrderManager: Initializing...');
        try {
            this.initDataTable();
            this.loadSummary();
            this.initEventHandlers();
            this.initModalEvents();
            console.log('PurchaseOrderManager: Initialization complete');
        } catch (error) {
            console.error('PurchaseOrderManager: Initialization error:', error);
        }
    }

    // ===== HELPER FUNCTIONS =====
    formatRupiah(angka) {
        if (!angka) return 'Rp 0';
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    formatDateTime(iso) {
        if (!iso) return '-';
        const d = new Date(iso);
        const utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        const nd = new Date(utc + (3600000 * 7));
        const day = nd.getDate();
        const monthNames = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        const month = monthNames[nd.getMonth()];
        const year = nd.getFullYear();
        const hours = nd.getHours().toString().padStart(2,'0');
        const minutes = nd.getMinutes().toString().padStart(2,'0');
        return `${day} ${month} ${year} ${hours}:${minutes}`;
    }

    getStatusBadge(status) {
        const statusMap = {
            0: '<span class="badge bg-dark">Draft</span>',
            1: '<span class="badge bg-info text-white">Menunggu Approval</span>',
            2: '<span class="badge bg-warning text-dark">Revisi</span>',
            3: '<span class="badge bg-danger">Reject</span>',
            4: '<span class="badge bg-success">Approved</span>'
        };
        return statusMap[Number(status)] || '<span class="badge bg-secondary">-</span>';
    }

    getTipePO(category) {
        const categoryMap = { 1: 'Supplier', 2: 'Transportir' };
        return categoryMap[category] || '-';
    }

    // ===== DATA TABLE INITIALIZATION =====
    initDataTable() {
        this.table = $('#basic-1').DataTable({
            processing: true,
            serverSide: false,
            paging: true,
            searching: true,
            ordering: false,
            autoWidth: false,
            destroy: true,
            ajax: {
                url: '/api/purchase-order/list',
                data: (d) => {
                    d.status = $('#filter-status').val();
                    d.category = $('#filter-category').val();
                },
                dataSrc: (json) => {
                    return (json.data || []).map((row, i) => ({
                        no: row.no || '-',
                        category: this.getTipePO(row.category),
                        category_code: row.category,
                        dn_no: row.dn_no || '-',
                        drs_no: row.drs_no || '-',
                        vendor_name: row.vendor_name || '-',
                        total: this.formatRupiah(row.total || 0),
                        status: this.getStatusBadge(row.status),
                        status_code: row.status,
                        drs_unique: row.drs_unique || ''
                    }));
                }
            },
            language: {
                emptyTable: "Data belum tersedia",
                loadingRecords: "",
                processing: "Data Loading..."
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Export',
                titleAttr: 'Export to Excel',
                className: 'btn btn-sm btn-success'
            }],
            columns: [
                { data: 'no' },
                { data: 'category' },
                { data: 'dn_no' },
                { data: 'drs_no' },
                { data: 'vendor_name' },
                { data: 'total' },
                { 
                    data: 'status',
                    render: function(data, type, row) {
                        return data + `
                            <div class="mt-1">
                                <button class="btn btn-sm btn-outline-primary btn-revisi-po" data-category="${row.category_code}" data-drs="${row.drs_unique}">
                                    <i class="fa fa-edit"></i> Revisi
                                </button>
                                <button class="btn btn-sm btn-outline-info status-click" data-drs="${row.drs_unique}" data-category="${row.category_code}">
                                    <i class="fa fa-history"></i> Workflow
                                </button>
                            </div>
                        `;
                    }
                }
            ]
        });
    }

    loadSummary() {
        $.get('/api/purchase-order/list')
            .done((res) => {
                const summary = res.summary || {};
                $('#card-total_po').text(`${summary.total_supplier || 0}|${summary.total_transporter || 0}`);
                $('#card-draft').text(summary.waiting_approval || 0);
                $('#card-approved').text(summary.approved || 0);
                $('#card-approved_reject').text(summary.rejected || 0);
            })
            .fail((xhr) => {
                console.error('Summary API Error:', xhr);
            });
    }

    // ===== EVENT HANDLERS =====
    initEventHandlers() {
        console.log('Initializing event handlers...');
        
        // Debug: Check if elements exist
        console.log('Add PO button exists:', $('.btn-add-po').length > 0);
        console.log('Filter status exists:', $('#filter-status').length > 0);
        console.log('Filter category exists:', $('#filter-category').length > 0);
        
        // Filter changes
        $('#filter-status, #filter-category').on('change', () => {
            this.table.ajax.reload();
            this.loadSummary();
        });
        
        // Add PO button
        console.log('Setting up Add PO button handler...');
        $('.btn-add-po').on('click', (e) => {
            console.log('Add PO button clicked');
            e.preventDefault();
            $('#modal-create-po-supplier').modal('show');
        });
        console.log('Add PO button handler set up');
        
        // Revisi PO button
        $(document).on('click', '.btn-revisi-po', (e) => {
            e.preventDefault();
            const category = $(e.target).closest('.btn-revisi-po').data('category');
            const drsUnique = $(e.target).closest('.btn-revisi-po').data('drs');
            
            console.log('Revisi PO clicked:', { category, drsUnique });
            
            if (!drsUnique) {
                Swal.fire('Error', 'Data DRS tidak ditemukan', 'error');
                return;
            }
            
            if (category === 1) {
                $('#modal-revisi-po-supplier').find('[name="drs_unique"]').val(drsUnique);
                $('#modal-revisi-po-supplier').modal('show');
            } else if (category === 2) {
                $('#modal-revisi-transportir').find('[name="drs_unique"]').val(drsUnique);
                $('#modal-revisi-transportir').modal('show');
            } else {
                Swal.fire('Error', 'Kategori tidak valid', 'error');
            }
        });
        
        // Status click for workflow
        $(document).on('click', '.status-click', (e) => {
            e.preventDefault();
            
            const drs = $(e.target).closest('.status-click').data('drs');
            const cat = $(e.target).closest('.status-click').data('category');
            const tipe = cat === 1 ? 'po_supplier' : 'po_transporter';
            
            console.log('Workflow clicked:', { drs, cat, tipe });
            
            if (!drs) {
                Swal.fire('Error', 'Data DRS tidak ditemukan', 'error');
                return;
            }
            
            $('#workflowModalLoading').show();
            $('#workflow-modal').modal('show');
            $('#workflow-table tbody').empty();
            
            $.get(`/api/remarks/${drs}?tipe_trx=${tipe}`)
                .done((res) => {
                    const list = Array.isArray(res) ? res : (res.data || []);
                    
                    if (list.length === 0) {
                        $('#workflow-table tbody').append(`
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fa fa-info-circle"></i> Tidak ada data workflow untuk DRS ini
                                </td>
                            </tr>
                        `);
                    } else {
                        list.forEach((item, idx) => {
                            $('#workflow-table tbody').append(`
                                <tr>
                                    <td class="text-center">${idx+1}</td>
                                    <td>${item.user || item.created_by || item.pengisi || ''}</td>
                                    <td>${item.comment || item.remark || item.remarks || ''}</td>
                                    <td>${this.formatDateTime(item.created_at || item.created_date)}</td>
                                </tr>
                            `);
                        });
                    }
                })
                .fail((xhr) => {
                    console.error('Workflow API Error:', xhr);
                    $('#workflow-table tbody').append(`
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                <i class="fa fa-exclamation-triangle"></i> Gagal memuat data workflow
                            </td>
                        </tr>
                    `);
                    Swal.fire('Error', 'Gagal memuat data workflow', 'error');
                })
                .always(() => {
                    $('#workflowModalLoading').hide();
                });
        });
    }

    initModalEvents() {
        console.log('Modal events initialized');
        
        // Supplier modal show
        $('#modal-create-po-supplier').on('show.bs.modal', () => {
            console.log('Supplier modal opening...');
            this.resetSupplierForm();
        });
        
        // Revision Supplier Modal
        $('#modal-revisi-po-supplier').on('show.bs.modal', () => {
            const $modal = $('#modal-revisi-po-supplier');
            const drsUnique = $modal.find('[name="drs_unique"]').val();

            console.log('Loading supplier revision data for DRS:', drsUnique);

            // Show loading overlay
            $('#modalRevisiSupplierLoading').show();

            // Fetch PO data by drs_unique with category filter
            $.get('/api/purchase-order/list', { drs_unique: drsUnique, category: 1 })
                .done((res) => {
                    console.log('Supplier revision API response:', res);
                    
                    // Get the first matching record (should be only one due to filter)
                    const data = res.data && res.data.length > 0 ? res.data[0] : null;
                    
                    if (!data) {
                        Swal.fire('Error', 'Data PO Supplier tidak ditemukan', 'error');
                        $('#modal-revisi-po-supplier').modal('hide');
                        return;
                    }

                    // Populate all fields
                    $modal.find('#sp_vendor_po').val(data.vendor_po || '');
                    $modal.find('#sp_drs_no').val(data.drs_no || '');
                    $modal.find('#sp_dn_no').val(data.dn_no || '');
                    $modal.find('#sp_vendor_name').val(data.vendor_name || '');
                    $modal.find('#sp_customer_po').val(data.customer_po || '');
                    $modal.find('#sp_tgl_po').val(data.tgl_po || '');
                    $modal.find('#sp_nama').val(data.nama || '');
                    $modal.find('#sp_contact').val(data.contact || '');
                    $modal.find('#sp_alamat').val(data.alamat || '');
                    $modal.find('#sp_term').val(data.term || '');
                    $modal.find('#sp_fob').val(data.fob || '');
                    $modal.find('#sp_shipped_via').val(data.shipped_via || '');
                    $modal.find('#sp_loading_point').val(data.loading_point || '');
                    $modal.find('#sp_delivery_to').val(data.delivery_to || '');
                    $modal.find('#sp_transport').val(this.formatRupiah(data.transport || 0));
                    $modal.find('#sp_transport_raw').val(data.transport || 0);
                    $modal.find('#sp_harga').val(this.formatRupiah(data.harga || 0));
                    $modal.find('#sp_harga_raw').val(data.harga || 0);
                    $modal.find('#sp_qty').val(data.qty || '');
                    $modal.find('#sp_sub_total').val(this.formatRupiah(data.sub_total || 0));
                    $modal.find('#sp_sub_total_raw').val(data.sub_total || 0);
                    $modal.find('#sp_ppn').val(this.formatRupiah(data.ppn || 0));
                    $modal.find('#sp_ppn_raw').val(data.ppn || 0);
                    $modal.find('#sp_pbbkb').val(this.formatRupiah(data.pbbkb || 0));
                    $modal.find('#sp_pbbkb_raw').val(data.pbbkb || 0);
                    $modal.find('#sp_pph').val(this.formatRupiah(data.pph || 0));
                    $modal.find('#sp_pph_raw').val(data.pph || 0);
                    $modal.find('#sp_bph').val(this.formatRupiah(data.bph || 0));
                    $modal.find('#sp_bph_raw').val(data.bph || 0);
                    $modal.find('#sp_total').val(this.formatRupiah(data.total || 0));
                    $modal.find('#sp_total_raw').val(data.total || 0);
                    $modal.find('#sp_terbilang').val(data.terbilang || '');
                    $modal.find('#sp_description').val(data.description || '');
                    $modal.find('#sp_additional_notes').val(data.additional_notes || '');
                })
                .fail((xhr) => {
                    console.error('Supplier revision API error:', xhr);
                    Swal.fire('Error', 'Gagal memuat data PO Supplier', 'error');
                    $('#modal-revisi-po-supplier').modal('hide');
                })
                .always(() => {
                    $('#modalRevisiSupplierLoading').hide();
                });
        });
    }

    resetSupplierForm() {
        try {
            console.log('Resetting supplier form...');
            
            // Reset form safely
            const form = document.getElementById('form-create-po-supplier');
            if (form) {
                form.reset();
            }
            
            // Clear all input fields
            $('#sp_vendor_po, #sp_drs_no, #sp_dn_no, #sp_vendor_name, #sp_customer_po, #sp_tgl_po, #sp_nama, #sp_contact, #sp_alamat, #sp_term, #sp_fob, #sp_shipped_via, #sp_loading_point, #sp_delivery_to, #sp_transport, #sp_harga, #sp_qty, #sp_sub_total, #sp_ppn, #sp_pbbkb, #sp_pph, #sp_bph, #sp_total, #sp_terbilang, #sp_description, #sp_additional_notes').val('');
            
            // Clear raw value fields
            $('#sp_transport_raw, #sp_harga_raw, #sp_sub_total_raw, #sp_ppn_raw, #sp_pbbkb_raw, #sp_pph_raw, #sp_bph_raw, #sp_total_raw').val('');
            
            console.log('Supplier form reset successfully');
        } catch (error) {
            console.error('Error in resetSupplierForm:', error);
        }
    }
}

// Initialize when document is ready
$(document).ready(() => {
    new PurchaseOrderManager();
}); 