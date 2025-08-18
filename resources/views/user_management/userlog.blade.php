@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
<style>
.search-filter-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.filter-btn {
    border-radius: 0.25rem !important;
    min-width: 120px;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-btn i {
    margin-right: 8px;
}
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>User System Logs</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item">User Management</li>
                    <li class="breadcrumb-item active">User System Logs</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <!-- Search and Filter Section -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="mb-3">Search & Filter</h4>
                    <span>Filter dan cari log aktivitas user berdasarkan username dan rentang tanggal.</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username-search" class="form-label">Search by Username</label>
                                <input type="text" class="form-control" id="username-search" placeholder="Enter username..." style="border-radius: 0.5rem;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date-range" class="form-label">Date Range</label>
                                <input type="text" class="form-control" id="date-range" placeholder="Select date range" style="border-radius: 0.5rem;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary filter-btn" id="btn-apply-filter">
                                        <i class="fa fa-search"></i>
                                        Search
                                    </button>
                                    <button type="button" class="btn btn-secondary filter-btn" id="btn-reset-filter">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="mb-3">User Activity Logs</h4>
                    <span>Monitor user activities and system interactions.</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="userlog-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Service</th>
                                    <th>Activity</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">Loading data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    console.log('Document ready. Initializing DataTable.');

    // Initialize DataTable
    var userlogTable = $('#userlog-table').DataTable({
        processing: true,
        serverSide: true, // AKTIFKAN SERVER-SIDE UNTUK PAGING
        ajax: {
            url: '/api/user-sys-logs',
            type: 'GET',
            data: function(d) {
                // Parameter untuk DataTables server-side
                const params = {
                    page: (d.start / d.length) + 1,
                    per_page: d.length,
                    order_column: d.columns[d.order[0].column].data,
                    order_dir: d.order[0].dir,
                    search: d.search.value // DataTables mengirim pencarian di sini
                };

                // Tambahkan parameter filter tambahan
                const usernameSearch = $('#username-search').val();
                if (usernameSearch) {
                    params.username = usernameSearch; // Sesuaikan dengan nama parameter di backend API
                }
                const dateRange = $('#date-range').val();
                if (dateRange) {
                    params.date_range = dateRange; // Sesuaikan dengan nama parameter di backend API
                }

                console.log('DataTable API request params:', params);
                return params;
            },
            dataSrc: function(json) {
                console.log('API response received:', json);
                // Pastikan format respons sesuai dengan DataTables server-side
                if (json.success && json.data) {
                    // DataTables membutuhkan total data dan data yang difilter
                    json.recordsTotal = json.pagination.total;
                    json.recordsFiltered = json.pagination.total;
                    return json.data;
                }
                console.error('Invalid API response format:', json);
                return {
                    recordsTotal: 0,
                    recordsFiltered: 0,
                    data: []
                };
            },
            error: function(xhr, status, error) {
                console.error('API call failed:', error);
                alert('Gagal memuat data log. Silakan coba lagi.');
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    const pageInfo = userlogTable.page.info();
                    return pageInfo.start + meta.row + 1;
                },
                orderable: false,
                searchable: false
            },
            { data: 'user_id' },
            { data: 'user_name' },
            {
                data: 'services',
                render: function(data) {
                    if (!data) return '-';

                    const parts = data.split('.');
                    if (parts.length >= 2) {
                        const action = parts[0];
                        const controller = parts[1];
                        let badgeClass = 'bg-secondary';
                        if (action.includes('store') || action.includes('create')) {
                            badgeClass = 'bg-success';
                        } else if (action.includes('update') || action.includes('edit')) {
                            badgeClass = 'bg-warning';
                        } else if (action.includes('destroy') || action.includes('delete')) {
                            badgeClass = 'bg-danger';
                        } else if (action.includes('approve') || action.includes('verify')) {
                            badgeClass = 'bg-info';
                        } else if (action.includes('login') || action.includes('logout')) {
                            badgeClass = 'bg-primary';
                        } else if (action.includes('export') || action.includes('generate')) {
                            badgeClass = 'bg-dark';
                        }

                        return `<span class="badge ${badgeClass}">${action}</span><br><small class="text-muted">${controller}</small>`;
                    }
                    return data;
                },
                orderable: true // Sesuaikan jika kolom services bisa diurutkan
            },
            {
                data: 'activity',
                render: function(data) {
                    return data || '-';
                },
                orderable: true // Sesuaikan
            },
            {
                data: 'timestamp',
                render: function(data) {
                    if (!data) return '-';
                    const date = new Date(data);
                    const formattedDate = date.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    const formattedTime = date.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                    return `<div>
                        <div class="fw-bold">${formattedDate}</div>
                        <small class="text-muted">${formattedTime}</small>
                    </div>`;
                },
                orderable: true // Sesuaikan
            }
        ],
        pageLength: 10,
        lengthMenu: [[10, 15, 25, 50, 100], [10, 15, 25, 50, 100]],
        language: {
            search: "Cari:",
            searchPlaceholder: "Cari data...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Belum ada data",
            zeroRecords: "Belum ada data",
            processing: "Memuat data..."
        },
        order: [[5, 'desc']],
        responsive: true
    });

    // Handle Search and Filter button clicks
    $('#btn-apply-filter').on('click', function() {
        console.log('Search button clicked. Reloading DataTable.');
        userlogTable.ajax.reload();
    });

    $('#btn-reset-filter').on('click', function() {
        console.log('Reset button clicked. Clearing filters and reloading DataTable.');
        $('#username-search').val('');
        $('#date-range').val('');
        userlogTable.ajax.reload();
    });

});
</script>
@endsection
