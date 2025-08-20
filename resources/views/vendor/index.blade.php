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
            text-align: center;
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
                    <h3>Vendor Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">Vendor Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <!-- Summary Cards -->
        <div class="row summary-cards">
            <div class="col-md-3">
                <div class="summary-card">
                    <h4 id="total-active">0</h4>
                    <p>Total Active</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card warning">
                    <h4 id="total-inactive">0</h4>
                    <p>Total Inactive</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card success">
                    <h4 id="total-supplier">0</h4>
                    <p>Total Supplier</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card info">
                    <h4 id="total-transporter">0</h4>
                    <p>Total Transporter</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-4">
                    <label for="status-filter" class="form-label">Category</label>
                    <select class="form-control" id="status-filter">
                        <option value="">All Category</option>
                        <option value="1">Supplier</option>
                        <option value="2">Transporter</option>
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
                        <button type="button" class="btn btn-success btn-square" id="btn-add-vendor">
                            <i class="fa fa-plus"></i> Add Vendor
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">Vendor List</h4>
                        <span>Management data supplier dan transporter.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="vendor-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe</th>
                                        <th>Format</th>
                                        <th>Alias</th>
                                        <th>Nama</th>
                                        <th>PIC</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Category</th>
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

    <!-- Add/Edit Vendor Modal -->
    <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorModalLabel">Add New Vendor</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="vendorForm">
                    <div class="modal-body">
                        <input type="hidden" id="vendor_id" name="vendor_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipe" class="form-label">Tipe</label>
                                <select class="form-control" id="tipe" name="tipe" required>
                                    <option value="">Pilih Tipe</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="format" class="form-label">Format</label>
                                <input type="text" class="form-control" id="format" name="format" readonly required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alias" class="form-label">Alias</label>
                                <input type="text" class="form-control" id="alias" name="alias" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pic" class="form-label">PIC</label>
                                <input type="text" class="form-control" id="pic" name="pic" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_no" class="form-label">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">Pilih Category</option>
                                    <option value="1">Supplier</option>
                                    <option value="2">Transporter</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-square" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-square" id="btn-save-vendor">
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
        let vendorTable;
        let isEditMode = false;

                $(document).ready(function() {
            // Initialize DataTable
            initializeDataTable();

            // Filter handlers
            $('#btn-apply-filter').on('click', function() {
                reloadDataTable();
            });

            $('#btn-reset-filter').on('click', function() {
                $('#status-filter').val('');
                $('#company-search').val('');
                reloadDataTable();
            });

            // Add vendor button
            $('#btn-add-vendor').on('click', function() {
                openVendorModal();
            });

            // Vendor form submit
            $('#vendorForm').on('submit', function(e) {
                e.preventDefault();
                saveVendor();
            });

            // Enter key on company search
            $('#company-search').on('keypress', function(e) {
                if (e.which === 13) {
                    reloadDataTable();
                }
            });

            // Load tipe options when modal is shown
            $('#vendorModal').on('show.bs.modal', function() {
                loadTipeOptions();
            });

            // Auto-generate format when tipe or alias changes
            $('#tipe, #alias').on('change keyup', function() {
                generateFormat();
            });
        });

        function initializeDataTable() {
            vendorTable = $('#vendor-table').DataTable({
                processing: true,
                serverSide: false,
                                ajax: {
                    url: '/api/supplier-transporter',
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

                        // Add filter_status parameter if selected
                        const filterStatus = $('#status-filter').val();
                        if (filterStatus && filterStatus !== '') {
                            params.filter_status = filterStatus;
                        }

                        return params;
                    },
                    dataSrc: function(json) {
                        // Update summary cards
                        if (json.summary) {
                            $('#total-active').text(json.summary.total_active || 0);
                            $('#total-inactive').text(json.summary.total_inactive || 0);
                            $('#total-supplier').text(json.summary.total_supplier || 0);
                            $('#total-transporter').text(json.summary.total_transporter || 0);
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
                    { data: 'tipe' },
                    { data: 'format' },
                    { data: 'alias' },
                    { data: 'nama' },
                    { data: 'pic' },
                    { data: 'contact_no' },
                    { data: 'email' },
                    {
                        data: 'address',
                        render: function(data) {
                            return data ? (data.length > 50 ? data.substring(0, 50) + '...' : data) : '-';
                        }
                    },
                                        {
                        data: 'status',
                        render: function(data) {
                            return data === 1 ? '<span class="badge bg-success">Active</span>' :
                                   '<span class="badge bg-danger">Inactive</span>';
                        }
                    },
                    {
                        data: 'category',
                        render: function(data) {
                            return data === 1 ? '<span class="badge bg-success">Supplier</span>' :
                                   data === 2 ? '<span class="badge bg-info">Transporter</span>' : '-';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning me-1" onclick="editVendor(${row.id})" title="Edit" style="border-radius: 4px; border: none;">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteVendor(${row.id}, '${row.nama}')" title="Delete" style="border-radius: 4px; border: none;">
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
            if (vendorTable) {
                vendorTable.ajax.reload();
            }
        }

                function openVendorModal(vendorData = null) {
            isEditMode = vendorData !== null;
            $('#vendorModalLabel').text(isEditMode ? 'Edit Vendor' : 'Add New Vendor');
            $('#btn-save-vendor').text(isEditMode ? 'Update' : 'Save');

            if (isEditMode && vendorData) {
                $('#vendor_id').val(vendorData.id);
                $('#tipe').val(vendorData.tipe);
                $('#alias').val(vendorData.alias);
                $('#nama').val(vendorData.nama);
                $('#pic').val(vendorData.pic);
                $('#contact_no').val(vendorData.contact_no);
                $('#email').val(vendorData.email);
                $('#address').val(vendorData.address);
                $('#category').val(vendorData.category);
                // Generate format after setting tipe and alias
                setTimeout(function() {
                    generateFormat();
                }, 100);
            } else {
                $('#vendorForm')[0].reset();
                $('#vendor_id').val('');
                $('#format').val('');
            }

            $('#vendorModal').modal('show');
        }

            function loadTipeOptions() {
            $.get('/api/master-lov/children', { parent_code: 'SPH_TYPE' })
                .done(function(response) {
                    const $tipeSelect = $('#tipe');
                    // Clear existing options except the first one
                    $tipeSelect.find('option:not(:first)').remove();

                    console.log('API Response:', response); // Debug log

                    // Handle different response structures
                    let data = response;
                    if (response && response.data) {
                        data = response.data;
                    }

                    if (data && Array.isArray(data)) {
                        data.forEach(function(item) {
                            console.log('Processing item:', item); // Debug log
                            $tipeSelect.append(`<option value="${item.value}">${item.value}</option>`);
                        });
                    }
                })
                .fail(function(xhr) {
                    console.error('Failed to load tipe options:', xhr);
                });
        }

        function generateFormat() {
            const tipe = $('#tipe').val();
            const alias = $('#alias').val();

            if (tipe && alias) {
                // Format: {NOMOR}/MMTEI-TNL/{BULAN}/{TAHUN}
                // MMTEI = tipe yang dipilih, TNL = alias
                const format = `{NOMOR}/${tipe}-${alias}/{BULAN}/{TAHUN}`;
                $('#format').val(format);
            } else {
                $('#format').val('');
            }
        }

        function saveVendor() {
            const $btn = $('#btn-save-vendor');
            const $spinner = $btn.find('.spinner-border');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            const formData = {
                tipe: $('#tipe').val(),
                format: $('#format').val(),
                alias: $('#alias').val(),
                nama: $('#nama').val(),
                pic: $('#pic').val(),
                contact_no: $('#contact_no').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                category: $('#category').val()
            };

            const vendorId = $('#vendor_id').val();
            const url = isEditMode ? `/api/supplier-transporter/${vendorId}` : '/api/supplier-transporter';
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
                    $('#vendorModal').modal('hide');
                    reloadDataTable();
                    Swal.fire('Success!', data.message, 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Failed to save vendor', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while saving vendor', 'error');
            })
            .finally(() => {
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
            });
        }

        function editVendor(id) {
            // Find vendor data from DataTable
            const rowData = vendorTable.rows().data().toArray().find(row => row.id === id);
            if (rowData) {
                openVendorModal(rowData);
            } else {
                Swal.fire('Error!', 'Vendor data not found', 'error');
            }
        }

        function deleteVendor(id, nama) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete vendor "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/supplier-transporter/${id}`, {
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
                            Swal.fire('Error!', data.message || 'Failed to delete vendor', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting vendor', 'error');
                    });
                }
            });
        }
    </script>
@endsection
