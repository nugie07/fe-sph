@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        /* Filter styling */
        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }



        .btn-square {
            border-radius: 4px;
            border: none;
        }

        /* Select2 customization */
        .select2-container--bootstrap-5 .select2-selection {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            min-height: 38px;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ced4da;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: #495057;
            line-height: 36px;
            padding-left: 12px;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border-color: #ced4da;
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
            background-color: #28a745;
        }

        /* Additional Select2 styling for better integration */
        .select2-container--bootstrap-5 {
            width: 100% !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            height: 38px;
            display: flex;
            align-items: center;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 12px;
            padding-right: 20px;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__clear {
            margin-right: 20px;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border-radius: 0.375rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .select2-container--bootstrap-5 .select2-results__option {
            padding: 8px 12px;
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            padding: 8px 12px;
            font-size: 14px;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Master Lokasi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">Master Lokasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <!-- Search and Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <label for="search-input" class="form-label">Cari Lokasi</label>
                    <input type="text" class="form-control" id="search-input" placeholder="Masukkan nama lokasi...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-square" id="btn-add-lokasi">
                            <i class="fa fa-plus"></i> Add Lokasi
                        </button>
                        <button type="button" class="btn btn-primary btn-square" id="btn-search">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary btn-square" id="btn-reset">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">Daftar Lokasi</h4>
                        <span>Management data lokasi master.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="lokasi-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lokasi</th>
                                        <th>Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Lokasi Modal -->
    <div class="modal fade" id="lokasiModal" tabindex="-1" aria-labelledby="lokasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lokasiModalLabel">Add New Lokasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="lokasiForm">
                    <div class="modal-body">
                        <input type="hidden" id="lokasi_id" name="lokasi_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Nama Lokasi</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">Value</label>
                                <input type="text" class="form-control" id="value" name="value" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-square" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-square" id="btn-save-lokasi">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let lokasiTable;
        let isEditMode = false;
        let currentFilters = {
            search: '',
            page: 1,
            per_page: 10
        };

        $(document).ready(function() {
            // Load initial data
            loadLokasiData();

            // Search button click
            $('#btn-search').on('click', function() {
                currentFilters.search = $('#search-input').val();
                currentFilters.page = 1;
                loadLokasiData();
            });

            // Reset button click
            $('#btn-reset').on('click', function() {
                $('#search-input').val('');
                currentFilters = {
                    search: '',
                    page: 1,
                    per_page: 10
                };
                loadLokasiData();
            });

            // Enter key on search input
            $('#search-input').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // Add Lokasi button
            $('#btn-add-lokasi').on('click', function() {
                openLokasiModal();
            });

            // Lokasi form submit
            $('#lokasiForm').on('submit', function(e) {
                e.preventDefault();
                saveLokasi();
            });
        });

        function loadLokasiData() {
            if (lokasiTable) {
                lokasiTable.destroy();
            }

            // Build query string
            const queryParams = new URLSearchParams();
            if (currentFilters.search) queryParams.append('search', currentFilters.search);
            queryParams.append('page', currentFilters.page);
            queryParams.append('per_page', currentFilters.per_page);

            lokasiTable = $('#lokasi-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: `/api/master-lov/lokasi/list?${queryParams.toString()}`,
                    type: 'GET',
                    dataSrc: function(json) {
                        return json.data || [];
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'code' },
                    { data: 'value' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning me-1" onclick="editLokasi(${row.id})" title="Edit" style="border-radius: 4px; border: none;">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteLokasi(${row.id}, '${row.value}')" title="Delete" style="border-radius: 4px; border: none;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
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
                order: [],
                responsive: true
            });
        }

        function openLokasiModal(lokasiData = null) {
            isEditMode = lokasiData !== null;
            $('#lokasiModalLabel').text(isEditMode ? 'Edit Lokasi' : 'Add New Lokasi');
            $('#btn-save-lokasi').text(isEditMode ? 'Update' : 'Save');

            if (isEditMode && lokasiData) {
                $('#lokasi_id').val(lokasiData.id);
                $('#code').val(lokasiData.code);
                $('#value').val(lokasiData.value);
            } else {
                $('#lokasiForm')[0].reset();
                $('#lokasi_id').val('');
            }

            $('#lokasiModal').modal('show');
        }

        function saveLokasi() {
            const $btn = $('#btn-save-lokasi');
            const $spinner = $btn.find('.spinner-border');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            const formData = {
                code: $('#code').val(),
                value: $('#value').val()
            };

            const lokasiId = $('#lokasi_id').val();
            const url = isEditMode ? `/api/master-lov/lokasi/${lokasiId}` : '/api/master-lov/lokasi';
            const method = isEditMode ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#lokasiModal').modal('hide');
                    loadLokasiData();
                    Swal.fire('Success!', data.message || 'Lokasi berhasil disimpan', 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Failed to save lokasi', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while saving lokasi', 'error');
            })
            .finally(() => {
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
            });
        }

        function editLokasi(id) {
            // Find lokasi data from DataTable
            const rowData = lokasiTable.rows().data().toArray().find(row => row.id === id);
            if (rowData) {
                openLokasiModal(rowData);
            } else {
                Swal.fire('Error!', 'Lokasi data not found', 'error');
            }
        }

        function deleteLokasi(id, value) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete lokasi "${value}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/master-lov/lokasi/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadLokasiData();
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete lokasi', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting lokasi', 'error');
                    });
                }
            });
        }
    </script>
@endsection
