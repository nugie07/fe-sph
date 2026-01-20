<!-- Tab Transportir -->
@php
    $isActive = $isActive ?? false;
    $activeClass = $isActive ? 'show active' : '';
@endphp
<div class="tab-pane fade {{ $activeClass }}" id="transportir" role="tabpanel" aria-labelledby="transportir-tab">
    <div class="card">
        <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Data Cetak PO</h4>
                <span>Data semua cetak PO untuk Supplier atau Transporter </span>
            </div>
            <div class="d-flex gap-2 mt-2 mt-md-0 align-items-center ms-auto">
                <button type="button" class="btn btn-success" id="btnAddPOTransportir"
                style="color:#fff; border-radius:8px; aspect-ratio:1/1; width:40px; height:40px; display:flex; align-items:center; justify-content:center;" title="Buat PO Transportir Baru">
                    <i class="fa fa-plus"></i>
                </button>
                <select class="form-select" id="filter-status-transportir" style="width:200px;max-width:220px;">
                    <option value="">Semua Status</option>
                    <option value="approvallist">Menunggu Approval</option>
                    <option value="reject">Reject</option>
                    <option value="draft">Draft</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1-transportir">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nomer PO</th>
                        <th>Nama Vendor Transportir</th>
                        <th>Qty / KL</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

