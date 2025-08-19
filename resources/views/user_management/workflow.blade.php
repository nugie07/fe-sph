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

        /* Override pill buttons */
        .btn-pill {
            border-radius: 8px !important;
        }

        /* DataTable action buttons */
        .dataTables_wrapper .btn {
            border-radius: 6px !important;
        }

        /* Force all buttons to be rounded, not pill */
        .btn,
        .btn-sm,
        .btn-lg,
        .btn-group .btn,
        .dataTables_wrapper .btn,
        .modal .btn {
            border-radius: 8px !important;
        }

        .btn-sm,
        .dataTables_wrapper .btn-sm {
            border-radius: 6px !important;
        }

        /* Override any pill classes */
        .btn-pill,
        .btn.rounded-pill {
            border-radius: 8px !important;
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
                    <h3>Workflow Engine Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active">Workflow Engine</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">Filter & Search</h4>
                        <span>Filter dan cari data workflow berdasarkan tipe transaksi.</span>
                    </div>
                    <div class="card-body">
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search-input" class="form-label">Search Workflow</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search-input" placeholder="Cari tipe transaksi..." style="border-radius: 8px 0 0 8px;">
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
                                            <button type="button" class="btn btn-secondary btn-square" id="btn-reset">
                                                <i class="fa fa-refresh"></i> Reset
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
                        <h4 class="mb-3">Data Workflow</h4>
                        <span>Daftar workflow yang tersedia dalam sistem.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="workflow-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Tipe Transaksi</th>
                                        <th>Approval Pertama</th>
                                        <th>Approval Kedua</th>
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

    <!-- Add/Edit Workflow Modal -->
    <div class="modal fade" id="workflowModal" tabindex="-1" aria-labelledby="workflowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workflowModalLabel">Edit Workflow</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="workflowForm">
                    <div class="modal-body">
                        <input type="hidden" id="workflow_id" name="workflow_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipe_trx" class="form-label">Tipe Transaksi</label>
                                <input type="text" class="form-control" id="tipe_trx" name="tipe_trx" required readonly>
                                <small class="text-muted">Tipe transaksi tidak dapat diubah</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_appr" class="form-label">Approval Pertama</label>
                                <select class="form-control" id="first_appr" name="first_appr" required>
                                    <option value="">-- Pilih Approval Pertama --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="second_appr" class="form-label">Approval Kedua</label>
                                <select class="form-control" id="second_appr" name="second_appr" required>
                                    <option value="">-- Pilih Approval Kedua --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-square" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-square" id="btn-save-workflow">
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
        let workflowTable;
        let isEditMode = false;
        let currentFilters = {
            search: '',
            page: 1,
            per_page: 10
        };

        $(document).ready(function() {
            // Load initial data
            loadWorkflowData();

            // Search button click
            $('#btn-search').on('click', function() {
                currentFilters.search = $('#search-input').val();
                currentFilters.page = 1;
                loadWorkflowData();
            });

            // Reset button click
            $('#btn-reset').on('click', function() {
                $('#search-input').val('');
                currentFilters = {
                    search: '',
                    page: 1,
                    per_page: 10
                };
                loadWorkflowData();
            });

            // Enter key on search input
            $('#search-input').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btn-search').click();
                }
            });



            // Workflow form submit
            $('#workflowForm').on('submit', function(e) {
                e.preventDefault();

                // Prevent double submission
                const $btn = $('#btn-save-workflow');
                if ($btn.prop('disabled')) {
                    console.log('Form submission blocked - button already disabled');
                    return false;
                }

                saveWorkflow();
            });

            // Reset tipe_trx field when modal is hidden
            $('#workflowModal').on('hidden.bs.modal', function() {
                $('#tipe_trx').prop('disabled', false);
            });
        });

        function loadWorkflowData() {
            if (workflowTable) {
                workflowTable.destroy();
                $('#workflow-table').empty().append(`
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Tipe Transaksi</th>
                            <th>Approval Pertama</th>
                            <th>Approval Kedua</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `);
            }

            workflowTable = $('#workflow-table').DataTable({
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
                        url: '/api/approval/workflow-engine',
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
                            const pageInfo = workflowTable.page.info();
                            return pageInfo.start + meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        orderable: true
                    },
                    {
                        data: 'tipe_trx',
                        orderable: true
                    },
                    {
                        data: 'first_appr_name',
                        orderable: true
                    },
                    {
                        data: 'second_appr_name',
                        orderable: true
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editWorkflow(${row.id})" style="border-radius: 6px !important;">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteWorkflow(${row.id}, '${row.tipe_trx}')" style="border-radius: 6px !important;">
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
                order: [[1, 'desc']],
                responsive: true
            });
        }

                function loadRolesDropdown() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/api/approval/roles-dropdown',
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const firstApprSelect = $('#first_appr');
                            const secondApprSelect = $('#second_appr');

                            // Clear existing options
                            firstApprSelect.empty().append('<option value="">-- Pilih Approval Pertama --</option>');
                            secondApprSelect.empty().append('<option value="">-- Pilih Approval Kedua --</option>');

                            // Add options
                            response.data.forEach(role => {
                                firstApprSelect.append(`<option value="${role.id}">${role.name}</option>`);
                                secondApprSelect.append(`<option value="${role.id}">${role.name}</option>`);
                            });

                            resolve(response.data);
                        } else {
                            reject(new Error('Failed to load roles'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading roles dropdown:', error);
                        Swal.fire('Error!', 'Gagal memuat data roles', 'error');
                        reject(error);
                    }
                });
            });
        }

        function openWorkflowModal(workflowData) {
            isEditMode = true;
            $('#workflowModalLabel').text('Edit Workflow');

            if (workflowData) {
                $('#workflow_id').val(workflowData.id);
                $('#tipe_trx').val(workflowData.tipe_trx);
                $('#tipe_trx').prop('disabled', true); // Disable tipe transaksi field

                // Store the approval values to set after dropdown is loaded
                const firstApprValue = workflowData.first_appr;
                const secondApprValue = workflowData.second_appr;

                // Load roles dropdown and set values
                loadRolesDropdown().then(() => {
                    // Set dropdown values after they are loaded
                    $('#first_appr').val(firstApprValue);
                    $('#second_appr').val(secondApprValue);

                    // Trigger change event to update Select2 display
                    $('#first_appr').trigger('change');
                    $('#second_appr').trigger('change');
                });
            }

            $('#workflowModal').modal('show');
        }

        function saveWorkflow() {
            const $btn = $('#btn-save-workflow');
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
                tipe_trx: $('#tipe_trx').val(),
                first_appr: $('#first_appr').val(),
                second_appr: $('#second_appr').val()
            };

            const workflowId = $('#workflow_id').val();
            const url = `/api/approval/workflow-engine/${workflowId}`;
            const method = 'PUT';

            console.log('Saving workflow:', { url, method, formData });

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
                    $('#workflowModal').modal('hide');
                    workflowTable.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Workflow berhasil disimpan',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Failed to save workflow', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving workflow:', error);
                Swal.fire('Error!', 'An error occurred while saving workflow. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
                $btnText.text('Save');
            });
        }

        function editWorkflow(id) {
            // Find workflow data from DataTable
            const rowData = workflowTable.rows().data().toArray().find(row => row.id === id);
            if (rowData) {
                openWorkflowModal(rowData);
            } else {
                Swal.fire('Error!', 'Workflow data not found', 'error');
            }
        }

        function deleteWorkflow(id, tipeTrx) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete workflow "${tipeTrx}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/approval/workflow-engine/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            workflowTable.ajax.reload(null, false);
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete workflow', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting workflow', 'error');
                    });
                }
            });
        }
    </script>
@endsection
