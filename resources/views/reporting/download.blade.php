@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <style>
        .filter-section { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .badge-ready { background: #28a745; }
        .badge-pending { background: #ffc107; color: #333; }
        .badge-failed { background: #dc3545; }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Download Report</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Reporting</a></li>
                        <li class="breadcrumb-item active">Download Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="filter-section">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Daftar Export Report</h5>
                </div>
                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-primary" id="btn-refresh">
                        <i class="fa fa-refresh"></i> Refresh
                    </button>
                    <a href="{{ route('reporting.generate') }}" class="btn btn-outline-secondary ms-2">Generate Report</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="export-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>File Name</th>
                                        <th>Tipe Report</th>
                                        <th>AP Sub Type</th>
                                        <th>Date Range</th>
                                        <th>Status</th>
                                        <th>Filename</th>
                                        <th>Created At</th>
                                        <th>Action</th>
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
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var exportTable;

        $(document).ready(function() {
            initDataTable();
            $('#btn-refresh').on('click', function() {
                if (exportTable) exportTable.ajax.reload(null, false);
            });
        });

        function initDataTable() {
            exportTable = $('#export-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/reporting/exports',
                    type: 'GET',
                    dataSrc: function(res) {
                        if (res && res.data) return res.data;
                        if (Array.isArray(res)) return res;
                        return [];
                    },
                    error: function() {
                        return [];
                    }
                },
                columns: [
                    { data: 'id', title: 'ID' },
                    {
                        data: 'filename',
                        title: 'File Name',
                        render: function(v) { return v || '-' ; }
                    },
                    {
                        data: 'report_type',
                        title: 'Tipe Report',
                        render: function(v) { return (v || '-').toUpperCase(); }
                    },
                    {
                        data: 'ap_sub_type',
                        title: 'AP Sub Type',
                        render: function(v) { return v || '-'; }
                    },
                    {
                        title: 'Date Range',
                        render: function(d, t, row) {
                            var from = row.date_from || '';
                            var to = row.date_to || '';
                            if (!from && !to) return '-';
                            return from + ' s/d ' + to;
                        }
                    },
                    {
                        data: 'status',
                        title: 'Status',
                        render: function(v) {
                            var c = 'badge-pending';
                            if (v === 'ready') c = 'badge-ready';
                            else if (v === 'failed') c = 'badge-failed';
                            return '<span class="badge ' + c + '">' + (v || 'pending') + '</span>';
                        }
                    },
                    {
                        data: 'filename',
                        title: 'Filename',
                        render: function(v) { return v || '-'; }
                    },
                    {
                        data: 'created_at',
                        title: 'Created At',
                        render: function(v) {
                            if (!v) return '-';
                            try {
                                var d = new Date(v);
                                return isNaN(d.getTime()) ? v : d.toLocaleString('id-ID');
                            } catch (e) { return v; }
                        }
                    },
                    {
                        title: 'Action',
                        orderable: false,
                        searchable: false,
                        render: function(d, t, row) {
                            var id = row.id;
                            var status = (row.status || '').toLowerCase();
                            var filename = row.filename || '';
                            var canDownload = status === 'ready' || (filename && filename.length > 0);
                            var url = row.download_url;
                            if (canDownload && !url) url = '/api/reporting/exports/' + id + '/download';
                            if (canDownload) {
                                var label = (filename && filename.length) ? filename : 'Download Report';
                                return '<a href="' + url + '" class="btn btn-sm btn-success" target="_blank" rel="noopener">' + label + '</a>';
                            }
                            return '<span class="text-muted">-' + (status === 'failed' && row.error ? ' ' + row.error : '') + '</span>';
                        }
                    }
                ],
                order: [[0, 'desc']],
                pageLength: 25,
                language: { emptyTable: 'Tidak ada data export.' }
            });
        }
    </script>
@endsection
