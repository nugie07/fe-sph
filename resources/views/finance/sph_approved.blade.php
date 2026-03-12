@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <style>
        .filter-section { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        #modalViewSph .modal-dialog { max-width: 90%; }
        #modalViewSph iframe { width: 100%; height: 80vh; border: 0; }
        .btn-view-sph {
            background-color: #0d6efd !important;
            color: #fff !important;
            border: none;
        }
        .btn-view-sph:hover {
            background-color: #0d6efd !important;
            color: #fff !important;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Approved SPH</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Finance Center</a></li>
                        <li class="breadcrumb-item active">Approved SPH</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="filter-section">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="button" class="btn btn-primary" id="btn-filter">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="btn-reset">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="sph-approved-table">
                                <thead>
                                    <tr>
                                        <th>Tipe SPH</th>
                                        <th>Kode SPH</th>
                                        <th>Nama Perusahaan</th>
                                        <th>File SPH</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View File SPH --}}
    <div class="modal fade" id="modalViewSph" tabindex="-1" aria-labelledby="modalViewSphLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewSphLabel">View File SPH</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="iframeViewSph" src="about:blank" title="File SPH"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script>
        var sphTable;

        $(document).ready(function() {
            initDataTable();
            $('#btn-filter').on('click', function() {
                if (sphTable) sphTable.ajax.reload();
            });
            $('#btn-reset').on('click', function() {
                $('#date_from').val('');
                $('#date_to').val('');
                if (sphTable) sphTable.ajax.reload();
            });
            $(document).on('click', '.btn-view-sph', function() {
                var url = $(this).data('url');
                $('#iframeViewSph').attr('src', url);
                new bootstrap.Modal(document.getElementById('modalViewSph')).show();
            });
            $('#modalViewSph').on('hidden.bs.modal', function() {
                $('#iframeViewSph').attr('src', 'about:blank');
            });
        });

        function initDataTable() {
            sphTable = $('#sph-approved-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/finance/sph_approved',
                    type: 'GET',
                    data: function(d) {
                        var from = $('#date_from').val();
                        var to = $('#date_to').val();
                        if (from) d.date_from = from;
                        if (to) d.date_to = to;
                        return d;
                    },
                    dataSrc: function(res) {
                        if (res && res.success && Array.isArray(res.data)) return res.data;
                        return [];
                    }
                },
                columns: [
                    { data: 'tipe_sph', render: function(v) { return v || '-'; } },
                    { data: 'kode_sph', render: function(v) { return v || '-'; } },
                    { data: 'comp_name', render: function(v) { return v || '-'; } },
                    {
                        data: 'file_sph',
                        orderable: false,
                        render: function(v) {
                            if (!v) return '<span class="text-muted">-</span>';
                            return '<button type="button" class="btn btn-sm btn-view-sph" data-url="' + v.replace(/"/g, '&quot;') + '">View</button>';
                        }
                    },
                    { data: 'created_by', render: function(v) { return v || '-'; } },
                    {
                        data: 'created_at',
                        render: function(v) {
                            if (!v) return '-';
                            try {
                                var d = new Date(v);
                                return isNaN(d.getTime()) ? v : d.toLocaleString('id-ID');
                            } catch (e) { return v; }
                        }
                    }
                ],
                order: [[5, 'desc']],
                pageLength: 25,
                language: { emptyTable: 'Tidak ada data SPH approved.' }
            });
        }
    </script>
@endsection
