<!-- WORKFLOW REMARKS MODAL -->
<div class="modal fade" id="workflow-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Loading overlay for Workflow Modal -->
            <div class="modal-loading-backdrop" id="workflowModalLoading">
                <div class="spinner-border text-primary spinner-lg" role="status"></div>
            </div>
            
            <div class="modal-header">
                <h5 class="modal-title">Workflow History</h5>
                <button type="button" class="btn btn-danger rounded-square" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="workflow-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengisi</th>
                                <th>Remark</th>
                                <th>Di Buat Tanggal</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 