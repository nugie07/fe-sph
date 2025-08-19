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
            border-radius: 8px;
            border: none;
        }

        /* Rounded buttons for all buttons */
        .btn {
            border-radius: 8px !important;
        }

        .btn-sm {
            border-radius: 6px !important;
        }

        .btn-lg {
            border-radius: 10px !important;
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

        /* Loading button styles */
        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Prevent text selection during loading */
        .btn:disabled .btn-text {
            user-select: none;
        }

        /* Rounded form controls */
        .form-control {
            border-radius: 8px !important;
        }

        .form-select {
            border-radius: 8px !important;
        }

        /* DataTable pagination buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
        }

        /* SweetAlert2 buttons */
        .swal2-popup .swal2-actions .swal2-confirm,
        .swal2-popup .swal2-actions .swal2-cancel {
            border-radius: 8px !important;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Master Wilayah</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">Master Data</li>
                        <li class="breadcrumb-item active">Wilayah</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">Filter & Search</h4>
                        <span>Filter dan cari data wilayah berdasarkan nama wilayah.</span>
                    </div>
                    <div class="card-body">
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search-input" class="form-label">Search Wilayah</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search-input" placeholder="Cari nama wilayah..." style="border-radius: 8px 0 0 8px;">
                                            <button class="btn btn-primary" type="button" id="btn-search" style="border-radius: 0 8px 8px 0;">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-secondary" id="btn-reset">
                                                <i class="fa fa-refresh"></i> Reset
                                            </button>
                                            <button type="button" class="btn btn-success" id="btn-add-wilayah">
                                                <i class="fa fa-plus"></i> Add Wilayah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">Data Wilayah</h4>
                        <span>Daftar wilayah yang tersedia dalam sistem.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="wilayah-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Wilayah</th>
                                        <th>Value</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
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

    <!-- Add/Edit Wilayah Modal -->
    <div class="modal fade" id="wilayahModal" tabindex="-1" aria-labelledby="wilayahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wilayahModalLabel">Add New Wilayah</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="wilayahForm">
                    <div class="modal-body">
                        <input type="hidden" id="wilayah_id" name="wilayah_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Wilayah</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">Value</label>
                                <input type="text" class="form-control" id="value" name="value" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-square" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-square" id="btn-save-wilayah">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                            <span class="btn-text">Save</span>
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
        let wilayahTable;
        let isEditMode = false;
        let currentFilters = {
            search: '',
            page: 1,
            per_page: 10
        };

        $(document).ready(function() {
            // Load initial data
            loadWilayahData();

            // Search button click
            $('#btn-search').on('click', function() {
                currentFilters.search = $('#search-input').val();
                currentFilters.page = 1;
                loadWilayahData();
            });

            // Reset button click
            $('#btn-reset').on('click', function() {
                $('#search-input').val('');
                currentFilters = {
                    search: '',
                    page: 1,
                    per_page: 10
                };
                loadWilayahData();
            });

            // Enter key on search input
            $('#search-input').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });

            // Add Wilayah button
            $('#btn-add-wilayah').on('click', function() {
                openWilayahModal();
            });

            // Wilayah form submit
            $('#wilayahForm').on('submit', function(e) {
                e.preventDefault();

                // Prevent double submission
                const $btn = $('#btn-save-wilayah');
                if ($btn.prop('disabled')) {
                    console.log('Form submission blocked - button already disabled');
                    return false;
                }

                saveWilayah();
            });
        });

        function loadWilayahData() {
            if (wilayahTable) {
                wilayahTable.destroy();
                $('#wilayah-table').empty().append(`
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Wilayah</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `);
            }

            wilayahTable = $('#wilayah-table').DataTable({
                processing: true,
                serverSide: true,   // gunakan server-side agar paging berdasarkan API
                paging: true,
                pageLength: currentFilters.per_page,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: function (data, callback) {
                    const params = {
                        page: (data.start / data.length) + 1,
                        per_page: data.length,
                        search: currentFilters.search || data.search.value
                    };

                    console.log('DataTable API request params:', params);

                    $.ajax({
                        url: '/api/master-wilayah',
                        type: 'GET',
                        data: params,
                        success: function(response) {
                            console.log('API response:', response);
                            if (response.success) {
                                callback({
                                    recordsTotal: response.pagination.total,
                                    recordsFiltered: response.pagination.total,
                                    data: response.data
                                });
                            } else {
                                callback({
                                    recordsTotal: 0,
                                    recordsFiltered: 0,
                                    data: []
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('API error:', error);
                            callback({
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                data: []
                            });
                        }
                    });
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            const pageInfo = wilayahTable.page.info();
                            return pageInfo.start + meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        orderable: true
                    },
                    {
                        data: 'value',
                        orderable: true
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            return data == 1 ?
                                '<span class="badge bg-success">Active</span>' :
                                '<span class="badge bg-danger">Inactive</span>';
                        },
                        orderable: true
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            if (!data) return '-';
                            const date = new Date(data);
                            return date.toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        },
                        orderable: true
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editWilayah(${row.id})" style="border-radius: 6px;">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteWilayah(${row.id}, '${row.nama}')" style="border-radius: 6px;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
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
                order: [[4, 'desc']],
                responsive: true
            });
        }

        function openWilayahModal(wilayahData = null) {
            isEditMode = wilayahData !== null;
            $('#wilayahModalLabel').text(isEditMode ? 'Edit Wilayah' : 'Add New Wilayah');

            if (wilayahData) {
                $('#wilayah_id').val(wilayahData.id);
                $('#nama').val(wilayahData.nama);
                $('#value').val(wilayahData.value);
                $('#status').val(wilayahData.status ? '1' : '0');
            } else {
                $('#wilayahForm')[0].reset();
                $('#wilayah_id').val('');
            }

            $('#wilayahModal').modal('show');
        }

        function saveWilayah() {
            const $btn = $('#btn-save-wilayah');
            const $spinner = $btn.find('.spinner-border');
            const $btnText = $btn.find('.btn-text');

            // Prevent double submission
            if ($btn.prop('disabled')) {
                console.log('Save button already disabled, preventing double click');
                return;
            }

            // Show loading state
            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');
            $btnText.text('Saving...');

            const formData = {
                nama: $('#nama').val(),
                value: $('#value').val(),
                status: $('#status').val() === '1'
            };

            const wilayahId = $('#wilayah_id').val();
            const url = isEditMode ? `/api/master-wilayah/${wilayahId}` : '/api/master-wilayah';
            const method = isEditMode ? 'PUT' : 'POST';

            console.log('Saving wilayah:', { url, method, formData });

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Save response:', data);
                if (data.success) {
                    $('#wilayahModal').modal('hide');
                    wilayahTable.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Wilayah berhasil disimpan',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Failed to save wilayah', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving wilayah:', error);
                Swal.fire('Error!', 'An error occurred while saving wilayah. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
                $btnText.text('Save');
            });
        }

        function editWilayah(id) {
            // Find wilayah data from DataTable
            const rowData = wilayahTable.rows().data().toArray().find(row => row.id === id);
            if (rowData) {
                openWilayahModal(rowData);
            } else {
                Swal.fire('Error!', 'Wilayah data not found', 'error');
            }
        }

        function deleteWilayah(id, nama) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete wilayah "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/master-wilayah/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            wilayahTable.ajax.reload(null, false);
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete wilayah', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting wilayah', 'error');
                    });
                }
            });
        }
    </script>
@endsection
