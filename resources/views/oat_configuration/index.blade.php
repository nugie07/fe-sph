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

        .customer-info {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
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
            background-color: #007bff;
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
                    <h3>OAT Configuration</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">OAT Configuration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <!-- Customer Selection Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <label for="customer-select" class="form-label">Select Customer</label>
                    <select class="form-control" id="customer-select">
                        <option value="">Pilih Customer</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-square" id="btn-add-oat">
                            <i class="fa fa-plus"></i> Add OAT
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info Section -->
        <div class="customer-info" id="customer-info" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <h5 id="customer-name">Customer Name</h5>
                    <p id="customer-alias">Customer Alias</p>
                </div>
                <div class="col-md-6 text-end">
                    <h6>Total Records: <span id="total-records">0</span></h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">OAT Configuration List</h4>
                        <span>Management OAT configuration berdasarkan customer yang dipilih.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="oat-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Location</th>
                                        <th>Qty</th>
                                        <th>OAT</th>
                                        <th>Created At</th>
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

    <!-- Add/Edit OAT Modal -->
    <div class="modal fade" id="oatModal" tabindex="-1" aria-labelledby="oatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="oatModalLabel">Add New OAT</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="oatForm">
                    <div class="modal-body">
                        <input type="hidden" id="oat_id" name="oat_id">
                        <input type="hidden" id="cust_id" name="cust_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="text" class="form-control" id="qty" name="qty" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="oat" class="form-label">OAT</label>
                                <input type="text" class="form-control" id="oat" name="oat" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-square" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-square" id="btn-save-oat">
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
        let oatTable;
        let isEditMode = false;
        let selectedCustomerId = null;

        $(document).ready(function() {
            // Initialize Select2 for customer dropdown
            $('#customer-select').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Customer',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Tidak ada hasil yang ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // Load customer options
            loadCustomerOptions();

            // Customer selection change
            $('#customer-select').on('change', function() {
                const customerId = $(this).val();
                if (customerId) {
                    selectedCustomerId = customerId;
                    loadOatData(customerId);
                    showCustomerInfo();
                } else {
                    selectedCustomerId = null;
                    hideCustomerInfo();
                    if (oatTable) {
                        oatTable.destroy();
                    }
                }
            });

            // Add OAT button
            $('#btn-add-oat').on('click', function() {
                if (!selectedCustomerId) {
                    Swal.fire('Warning!', 'Please select a customer first', 'warning');
                    return;
                }
                openOatModal();
            });

            // OAT form submit
            $('#oatForm').on('submit', function(e) {
                e.preventDefault();
                saveOat();
            });
        });

        function loadCustomerOptions() {
            $.get('/api/customer-database/list/customers')
                .done(function(response) {
                    const $customerSelect = $('#customer-select');
                    $customerSelect.find('option:not(:first)').remove();

                    if (response.success && response.data) {
                        response.data.forEach(function(customer) {
                            $customerSelect.append(`<option value="${customer.id}">${customer.name} (${customer.alias})</option>`);
                        });
                    }

                    // Trigger Select2 to update
                    $customerSelect.trigger('change.select2');
                })
                .fail(function(xhr) {
                    console.error('Failed to load customer options:', xhr);
                    Swal.fire('Error!', 'Failed to load customer list', 'error');
                });
        }

        function loadOatData(customerId) {
            if (oatTable) {
                oatTable.destroy();
            }

            oatTable = $('#oat-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: `/api/customer-database/list/oat?customer_id=${customerId}`,
                    type: 'GET',
                    dataSrc: function(json) {
                        if (json.success && json.customer) {
                            $('#customer-name').text(json.customer.name);
                            $('#customer-alias').text(json.customer.alias);
                            $('#total-records').text(json.total || 0);
                        }
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
                    { data: 'location' },
                    {
                        data: 'qty',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'oat',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning me-1" onclick="editOat(${row.id})" title="Edit" style="border-radius: 4px; border: none;">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteOat(${row.id}, '${row.location}')" title="Delete" style="border-radius: 4px; border: none;">
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

        function showCustomerInfo() {
            $('#customer-info').show();
        }

        function hideCustomerInfo() {
            $('#customer-info').hide();
        }

        function openOatModal(oatData = null) {
            isEditMode = oatData !== null;
            $('#oatModalLabel').text(isEditMode ? 'Edit OAT' : 'Add New OAT');
            $('#btn-save-oat').text(isEditMode ? 'Update' : 'Save');

            if (isEditMode && oatData) {
                $('#oat_id').val(oatData.id);
                $('#cust_id').val(oatData.cust_id);
                $('#location').val(oatData.location);
                $('#qty').val(oatData.qty);
                $('#oat').val(oatData.oat);
            } else {
                $('#oatForm')[0].reset();
                $('#oat_id').val('');
                $('#cust_id').val(selectedCustomerId);
            }

            $('#oatModal').modal('show');
        }

        function saveOat() {
            const $btn = $('#btn-save-oat');
            const $spinner = $btn.find('.spinner-border');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            const formData = {
                cust_id: $('#cust_id').val(),
                location: $('#location').val(),
                qty: $('#qty').val(),
                oat: $('#oat').val()
            };

            const oatId = $('#oat_id').val();
            const url = isEditMode ? `/api/customer-database/oat/${oatId}` : '/api/customer-database/oat';
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
                    $('#oatModal').modal('hide');
                    loadOatData(selectedCustomerId);
                    Swal.fire('Success!', data.message || 'OAT berhasil disimpan', 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Failed to save OAT', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while saving OAT', 'error');
            })
            .finally(() => {
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
            });
        }

        function editOat(id) {
            // Find OAT data from DataTable
            const rowData = oatTable.rows().data().toArray().find(row => row.id === id);
            if (rowData) {
                openOatModal(rowData);
            } else {
                Swal.fire('Error!', 'OAT data not found', 'error');
            }
        }

        function deleteOat(id, location) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete OAT "${location}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/customer-database/oat/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadOatData(selectedCustomerId);
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete OAT', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting OAT', 'error');
                    });
                }
            });
        }
    </script>
@endsection
