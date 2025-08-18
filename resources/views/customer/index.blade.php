@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <style>
        /* Filter styling */
        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .summary-cards {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .summary-card {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;w
            margin-bottom: 10px;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .summary-card.success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
        }

        .summary-card.warning {
            background: linear-gradient(45deg, #ffc107, #e0a800);
        }

        .summary-card.danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
        }

        .summary-card.info {
            background: linear-gradient(45deg, #17a2b8, #138496);
        }

        /* Modal styling */
        .modal-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }

        .btn-square {
            border-radius: 4px;
            border: none;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Customer Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">Customer Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <!-- Summary Cards -->
        <div class="row summary-cards">
            <div class="col-md-4">
                <div class="summary-card">
                    <h4 id="total-active">0</h4>
                    <p>Total Active</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card warning">
                    <h4 id="total-inactive">0</h4>
                    <p>Total Inactive</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card info">
                    <h4 id="total-customers">0</h4>
                    <p>Total Customers</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-4">
                    <label for="type-filter" class="form-label">Type</label>
                    <select class="form-control" id="type-filter">
                        <option value="">All Types</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="company-search" class="form-label">Search Company</label>
                    <input type="text" class="form-control" id="company-search" placeholder="Search company name...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary btn-square" id="btn-apply-filter">
                            <i class="fa fa-search"></i> Apply Filter
                        </button>
                        <button type="button" class="btn btn-secondary btn-square" id="btn-reset-filter">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                        <button type="button" class="btn btn-success btn-square" id="btn-add-customer">
                            <i class="fa fa-plus"></i> Add Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">Customer List</h4>
                        <span>Management data customer database.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="customer-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Code</th>
                                        <th>Alias</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>PIC Name</th>
                                        <th>PIC Contact</th>
                                        <th>Email</th>
                                        <th>Status</th>
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

    <!-- Add/Edit Customer Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customerForm">
                    <div class="modal-body">
                        <input type="hidden" id="customer_id" name="customer_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cust_code" class="form-label">Customer Code</label>
                                <input type="text" class="form-control" id="cust_code" name="cust_code" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="alias" class="form-label">Alias</label>
                                <input type="text" class="form-control" id="alias" name="alias" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Pilih Type</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pic_name" class="form-label">PIC Name</label>
                                <input type="text" class="form-control" id="pic_name" name="pic_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pic_contact" class="form-label">PIC Contact</label>
                                <input type="text" class="form-control" id="pic_contact" name="pic_contact" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bill_to" class="form-label">Bill To</label>
                                <textarea class="form-control" id="bill_to" name="bill_to" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ship_to" class="form-label">Ship To</label>
                                <textarea class="form-control" id="ship_to" name="ship_to" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-square" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-square" id="btn-save-customer">
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

    <script>
        let customerTable;
        let isEditMode = false;

                $(document).ready(function() {
            // Initialize DataTable
            initializeDataTable();

            // Load type options for filter dropdown
            loadTypeOptionsForFilter();

            // Filter handlers
            $('#btn-apply-filter').on('click', function() {
                reloadDataTable();
            });

            $('#btn-reset-filter').on('click', function() {
                $('#type-filter').val('');
                $('#company-search').val('');
                reloadDataTable();
            });

            // Add customer button
            $('#btn-add-customer').on('click', function() {
                openCustomerModal();
            });

            // Customer form submit
            $('#customerForm').on('submit', function(e) {
                e.preventDefault();
                saveCustomer();
            });

            // Enter key on company search
            $('#company-search').on('keypress', function(e) {
                if (e.which === 13) {
                    reloadDataTable();
                }
            });

            // Load type options when modal is shown
            $('#customerModal').on('show.bs.modal', function() {
                loadTypeOptions();
            });
        });

        function initializeDataTable() {
            customerTable = $('#customer-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/customer-database',
                    type: 'GET',
                    data: function(d) {
                        const params = {};

                        // Add search parameter if not empty (prioritas utama)
                        const searchValue = $('#company-search').val();
                        if (searchValue && searchValue.trim() !== '') {
                            params.search = searchValue.trim();
                            return params; // Hanya kirim search parameter
                        }

                        // Jika tidak ada search, tambahkan parameter lainnya
                        params.page = (d.start / d.length) + 1;
                        params.per_page = d.length;
                        params.status = 1; // Only active records

                        // Add type parameter if selected
                        const typeFilter = $('#type-filter').val();
                        if (typeFilter && typeFilter !== '') {
                            params.type = typeFilter;
                        }

                        return params;
                    },
                    dataSrc: function(json) {
                        // Update summary cards
                        if (json.summary) {
                            $('#total-active').text(json.summary.total_active || 0);
                            $('#total-inactive').text(json.summary.total_inactive || 0);

                            // Calculate total customers from type breakdown
                            let totalCustomers = 0;
                            if (json.summary.total_by_type && Array.isArray(json.summary.total_by_type)) {
                                json.summary.total_by_type.forEach(function(item) {
                                    totalCustomers += item.total || 0;
                                });
                            }
                            $('#total-customers').text(totalCustomers);
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
                    { data: 'cust_code' },
                    { data: 'alias' },
                    {
                        data: 'type',
                        render: function(data) {
                            return data === 'VIP' ? '<span class="badge bg-warning">VIP</span>' :
                                   data === 'Regular' ? '<span class="badge bg-info">Regular</span>' : data;
                        }
                    },
                    { data: 'name' },
                    {
                        data: 'address',
                        render: function(data) {
                            return data ? (data.length > 50 ? data.substring(0, 50) + '...' : data) : '-';
                        }
                    },
                    { data: 'pic_name' },
                    { data: 'pic_contact' },
                                        { data: 'email' },
                    {
                        data: 'status',
                        render: function(data) {
                            console.log('Status data:', data, 'Type:', typeof data, 'Value:', data);
                            return data == 1 ? '<span class="badge bg-success">Active</span>' :
                                   '<span class="badge bg-danger">Inactive</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning me-1" onclick="editCustomer(${row.id})" title="Edit" style="border-radius: 4px; border: none;">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCustomer(${row.id}, '${row.name}')" title="Delete" style="border-radius: 4px; border: none;">
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

        function reloadDataTable() {
            if (customerTable) {
                customerTable.ajax.reload();
            }
        }

        function openCustomerModal(customerData = null) {
            isEditMode = customerData !== null;
            $('#customerModalLabel').text(isEditMode ? 'Edit Customer' : 'Add New Customer');
            $('#btn-save-customer').text(isEditMode ? 'Update' : 'Save');

            if (isEditMode && customerData) {
                $('#customer_id').val(customerData.id);
                $('#cust_code').val(customerData.cust_code);
                $('#alias').val(customerData.alias);
                $('#type').val(customerData.type);
                $('#name').val(customerData.name);
                $('#address').val(customerData.address);
                $('#pic_name').val(customerData.pic_name);
                $('#pic_contact').val(customerData.pic_contact);
                $('#email').val(customerData.email);
                $('#bill_to').val(customerData.bill_to);
                $('#ship_to').val(customerData.ship_to);
            } else {
                $('#customerForm')[0].reset();
                $('#customer_id').val('');
            }

            $('#customerModal').modal('show');
        }

        function loadTypeOptions() {
            $.get('/api/master-lov/children', { parent_code: 'SPH_TYPE' })
                .done(function(response) {
                    const $typeSelect = $('#type');
                    // Clear existing options except the first one
                    $typeSelect.find('option:not(:first)').remove();

                    console.log('API Response:', response); // Debug log

                    // Handle different response structures
                    let data = response;
                    if (response && response.data) {
                        data = response.data;
                    }

                    if (data && Array.isArray(data)) {
                        data.forEach(function(item) {
                            console.log('Processing item:', item); // Debug log
                            $typeSelect.append(`<option value="${item.value}">${item.value}</option>`);
                        });
                    }
                })
                .fail(function(xhr) {
                    console.error('Failed to load type options:', xhr);
                });
        }

        function loadTypeOptionsForFilter() {
            $.get('/api/master-lov/children', { parent_code: 'SPH_TYPE' })
                .done(function(response) {
                    const $typeFilterSelect = $('#type-filter');
                    // Clear existing options except the first one
                    $typeFilterSelect.find('option:not(:first)').remove();

                    console.log('Filter API Response:', response); // Debug log

                    // Handle different response structures
                    let data = response;
                    if (response && response.data) {
                        data = response.data;
                    }

                    if (data && Array.isArray(data)) {
                        data.forEach(function(item) {
                            console.log('Processing filter item:', item); // Debug log
                            $typeFilterSelect.append(`<option value="${item.value}">${item.value}</option>`);
                        });
                    }
                })
                .fail(function(xhr) {
                    console.error('Failed to load type filter options:', xhr);
                });
        }

        function saveCustomer() {
            const $btn = $('#btn-save-customer');
            const $spinner = $btn.find('.spinner-border');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            const formData = {
                cust_code: $('#cust_code').val(),
                alias: $('#alias').val(),
                type: $('#type').val(),
                name: $('#name').val(),
                address: $('#address').val(),
                pic_name: $('#pic_name').val(),
                pic_contact: $('#pic_contact').val(),
                email: $('#email').val(),
                bill_to: $('#bill_to').val(),
                ship_to: $('#ship_to').val()
            };

            const customerId = $('#customer_id').val();
            const url = isEditMode ? `/api/customer-database/${customerId}` : '/api/customer-database';
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
                    $('#customerModal').modal('hide');
                    reloadDataTable();
                    Swal.fire('Success!', data.message, 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Failed to save customer', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while saving customer', 'error');
            })
            .finally(() => {
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
            });
        }

        function editCustomer(id) {
            // Find customer data from DataTable
            const rowData = customerTable.rows().data().toArray().find(row => row.id === id);
            if (rowData) {
                openCustomerModal(rowData);
            } else {
                Swal.fire('Error!', 'Customer data not found', 'error');
            }
        }

        function deleteCustomer(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete customer "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/customer-database/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            reloadDataTable();
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to delete customer', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting customer', 'error');
                    });
                }
            });
        }
    </script>
@endsection
