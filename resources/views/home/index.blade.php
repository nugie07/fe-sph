@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
    <style>
        /* Row styling for status = 9 */
        .status-canceled {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }
        .status-canceled:hover {
            background-color: #f5c6cb !important;
        }

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

        /* Modal button styling */
        .modal .btn {
            border-radius: 0.5rem !important;
        }

        /* Toast styling */
        .toast {
            border-radius: 0.5rem;
        }

        /* Manual Guide Modal Styling */
        .manual-guide-icons {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            padding: 20px 0;
        }

        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .icon-item.highlighted .icon-wrapper {
            border: 3px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .icon-item i {
            width: 30px;
            height: 30px;
            stroke-width: 1.5;
        }

        .icon-label {
            margin-top: 10px;
            font-size: 12px;
            color: #333;
            text-align: center;
            max-width: 120px;
            font-weight: 500;
        }

        .icon-item.highlighted .icon-label {
            color: #007bff;
            font-weight: 600;
        }

        #manualGuideModal .modal-body {
            padding: 30px;
        }

        #manualGuideModal .modal-body p {
            font-size: 16px;
            color: #495057;
        }

        #manualGuideModal .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 20px;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Logbook Tracking</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">Logbook Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <!-- Summary Cards -->
        <div class="row summary-cards">
            <div class="col-md-2">
                <div class="summary-card">
                    <h4 id="total-records">0</h4>
                    <p>Total Records</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="summary-card info">
                    <h4 id="on-progress">0</h4>
                    <p>On Progress</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="summary-card success">
                    <h4 id="ontime">0</h4>
                    <p>On Time</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="summary-card warning">
                    <h4 id="early">0</h4>
                    <p>Early</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="summary-card danger">
                    <h4 id="late">0</h4>
                    <p>Late</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-3">
                    <label for="start-date" class="form-label">Start Date</label>
                    <input type="text" class="form-control datepicker-here" id="start-date" data-language="en" data-date-format="yyyy-mm-dd" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <label for="end-date" class="form-label">End Date</label>
                    <input type="text" class="form-control datepicker-here" id="end-date" data-language="en" data-date-format="yyyy-mm-dd" placeholder="End Date">
                </div>
                <div class="col-md-3">
                    <label for="po-search" class="form-label">PO Number</label>
                    <input type="text" class="form-control" id="po-search" placeholder="Search PO Number">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary" id="btn-apply-filter" style="border-radius: 4px; border: none;">
                            <i class="fa fa-search"></i> Apply Filter
                        </button>
                        <button type="button" class="btn btn-secondary" id="btn-reset-filter" style="border-radius: 4px; border: none;">
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
                        <h4 class="mb-3">Logbook Tracking Data</h4>
                        <span>Monitoring delivery status dan progress order yang sedang berjalan.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="delivery-tracking-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer</th>
                                        <th>PO Number</th>
                                        <th>Created At</th>
                                        <th>Qty</th>
                                        <th>Req Date</th>
                                        <th>Wilayah</th>
                                        <th>SO</th>
                                        <th>Vendor PO</th>
                                        <th>Vendor Name</th>
                                        <th>PO Qty</th>
                                        <th>Tanggal Bongkar</th>
                                        <th>Arrival Date</th>
                                        <th>BAST Date</th>
                                        <th>Driver</th>
                                        <th>Nopol</th>
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
        </div>
    </div>

    <!-- Create Password Modal -->
    <div class="modal fade" id="createPasswordModal" tabindex="-1" aria-labelledby="createPasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPasswordModalLabel">Buat Password anda yang mudah diingat</h5>
                </div>
                <form id="createPasswordForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required minlength="8" placeholder="Masukkan password minimal 8 karakter">
                            <div class="invalid-feedback" id="passwordError"></div>
                            <small class="text-muted">Password minimal 8 karakter</small>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password *</label>
                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required minlength="8" placeholder="Konfirmasi password">
                            <div class="invalid-feedback" id="confirmPasswordError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="savePasswordBtn" style="border-radius: 0.5rem;">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="btn-text">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Manual Guide Modal - HIDDEN --}}
    {{-- <div class="modal fade" id="manualGuideModal" tabindex="-1" aria-labelledby="manualGuideModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manualGuideModalLabel">Akses ke Manual Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-4">Gunakan Manual Guides sebagai panduan penggunaan Aplikasi SPH</p>
                    
                    <!-- Icon Row -->
                    <div class="manual-guide-icons mb-4">
                        <div class="icon-item highlighted">
                            <div class="icon-wrapper">
                                <i data-feather="book" class="icon-book"></i>
                            </div>
                            <p class="icon-label">Ini adalah menu manual guides</p>
                        </div>
                        <div class="icon-item">
                            <div class="icon-wrapper">
                                <i data-feather="message-square" class="icon-message"></i>
                            </div>
                        </div>
                        <div class="icon-item">
                            <div class="icon-wrapper">
                                <i data-feather="maximize-2" class="icon-maximize"></i>
                            </div>
                        </div>
                        <div class="icon-item">
                            <div class="icon-wrapper">
                                <i data-feather="user" class="icon-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" id="btnOpenManualGuide" style="border-radius: 0.5rem;">
                        Buka Manual Guide
                    </button>
                    <button type="button" class="btn btn-secondary" id="btnSkipManualGuide" style="border-radius: 0.5rem;">
                        Skip
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="passwordToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let deliveryTrackingTable;

        $(document).ready(function() {
            // Check email verification status
            checkEmailVerification();

            // Initialize datepickers
            $('#start-date').datepicker({
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                autoClose: true
            });

            $('#end-date').datepicker({
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                autoClose: true
            });

            // Initialize DataTable
            initializeDataTable();

            // Filter handlers
            $('#btn-apply-filter').on('click', function() {
                reloadDataTable();
            });

            $('#btn-reset-filter').on('click', function() {
                $('#start-date').val('');
                $('#end-date').val('');
                $('#po-search').val('');
                reloadDataTable();
            });

            // Enter key on PO search
            $('#po-search').on('keypress', function(e) {
                if (e.which === 13) {
                    reloadDataTable();
                }
            });

            // Password form submission
            $('#createPasswordForm').on('submit', function(e) {
                e.preventDefault();
                createPassword();
            });

            // Password validation
            $('#confirmPassword').on('input', function() {
                validatePasswordConfirmation();
            });

            // Manual Guide Modal handlers - DISABLED
            // initManualGuideModal();
        });

        function initializeDataTable() {
            deliveryTrackingTable = $('#delivery-tracking-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/delivery-tracking',
                    type: 'GET',
                    data: function(d) {
                        return {
                            start_date: $('#start-date').val(),
                            end_date: $('#end-date').val(),
                            po_number: $('#po-search').val()
                        };
                    },
                    dataSrc: function(json) {
                        // Update summary cards
                        if (json.summary) {
                            $('#total-records').text(json.summary.total_records || 0);
                            $('#on-progress').text(json.summary.on_progress || 0);
                            $('#ontime').text(json.summary.ontime || 0);
                            $('#early').text(json.summary.early || 0);
                            $('#late').text(json.summary.late || 0);
                        }
                        return json.data || [];
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: true,
                        searchable: false,
                        orderData: [0]
                    },
                    { data: 'nama_customer' },
                    { data: 'po_no' },
                    {
                        data: 'created_at',
                        render: function(data) {
                            if (!data) return '-';
                            // Format: "2024-01-15 10:30"
                            var date = new Date(data);
                            return date.toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit'
                            }) + ' ' + date.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    },
                    {
                        data: 'qty',
                        render: function(data) {
                            return data ? data.toLocaleString('id-ID') : '-';
                        }
                    },
                    {
                        data: 'req_date',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    { data: 'nama' },
                    { 
                        data: 'so',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    { 
                        data: 'vendor_po',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    { 
                        data: 'vendor_name',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'po_qty',
                        render: function(data) {
                            return data ? data.toLocaleString('id-ID') : '-';
                        }
                    },
                    {
                        data: 'tgl_bongkar',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    {
                        data: 'arrival_date',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    {
                        data: 'bast_date',
                        render: function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    { 
                        data: 'driver_name',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    { 
                        data: 'nopol',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'delivery_ket',
                        render: function(data, type, row) {
                            if (!data) return '<span class="badge bg-secondary">-</span>';
                            
                            var ket = data.toLowerCase();
                            if (ket.includes('telat') || ket.includes('late')) {
                                return '<span class="badge bg-danger">' + data + '</span>';
                            } else if (ket.includes('ontime') || ket.includes('tepat')) {
                                return '<span class="badge bg-success">' + data + '</span>';
                            } else if (ket.includes('lebih awal') || ket.includes('early')) {
                                return '<span class="badge bg-warning">' + data + '</span>';
                            } else if (ket.includes('progress') || ket.includes('on progress')) {
                                return '<span class="badge bg-info">' + data + '</span>';
                            } else {
                                return '<span class="badge bg-secondary">' + data + '</span>';
                            }
                        }
                    }
                ],
                pageLength: 15,
                lengthMenu: [[10, 15, 25, 50], [10, 15, 25, 50]],
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
                order: [[1, 'asc']],
                responsive: true,
                createdRow: function(row, data, dataIndex) {
                    // Add red background for canceled status
                    if (data.delivery_ket && (data.delivery_ket.toLowerCase().includes('canceled') || data.delivery_ket.toLowerCase().includes('batal'))) {
                        $(row).addClass('status-canceled');
                    }
                }
            });
        }

        function reloadDataTable() {
            if (deliveryTrackingTable) {
                deliveryTrackingTable.ajax.reload();
            }
        }

        function checkEmailVerification() {
            // Check session data directly
            @if(session('user.email_verified_at') === null)
                // Show password creation modal
                const modal = new bootstrap.Modal(document.getElementById('createPasswordModal'));
                modal.show();
            @endif
        }

        function validatePasswordConfirmation() {
            const password = $('#newPassword').val();
            const confirmPassword = $('#confirmPassword').val();
            const confirmPasswordError = $('#confirmPasswordError');
            const saveBtn = $('#savePasswordBtn');

            if (confirmPassword && password !== confirmPassword) {
                confirmPasswordError.text('Konfirmasi password tidak sesuai').show();
                $('#confirmPassword').addClass('is-invalid');
                saveBtn.prop('disabled', true);
            } else {
                confirmPasswordError.text('').hide();
                $('#confirmPassword').removeClass('is-invalid');
                if (password && password.length >= 8) {
                    saveBtn.prop('disabled', false);
                }
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('passwordToast');
            const toastMessage = document.getElementById('toastMessage');

            // Set message
            toastMessage.textContent = message;

            // Set background color based on type
            if (type === 'error') {
                toast.style.backgroundColor = '#dc3545';
            } else if (type === 'warning') {
                toast.style.backgroundColor = '#ffc107';
                toast.style.color = '#000';
            } else {
                toast.style.backgroundColor = '#198754';
            }

            // Show toast
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }

        function showLoading(buttonId) {
            const button = document.getElementById(buttonId);
            const spinner = button.querySelector('.spinner-border');
            const btnText = button.querySelector('.btn-text');

            button.disabled = true;
            spinner.classList.remove('d-none');
            btnText.textContent = 'Menyimpan...';
        }

        function hideLoading(buttonId, originalText) {
            const button = document.getElementById(buttonId);
            const spinner = button.querySelector('.spinner-border');
            const btnText = button.querySelector('.btn-text');

            button.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = originalText;
        }

                function initManualGuideModal() {
            // Get MAN_SETTINGS from env (1 = always show, 0 or not set = show once per session)
            var manSettings = {{ env('MAN_SETTINGS', 0) }};
            
            // Check if modal should be shown
            // If MAN_SETTINGS = 1, always show (ignore sessionStorage)
            // If MAN_SETTINGS != 1, show only once per session
            var manualGuideShown = sessionStorage.getItem('manualGuideModalShown');
            var shouldShow = (manSettings == 1) ? true : !manualGuideShown;
            
            // Function to show modal
            function showModal() {
                var passwordModal = document.getElementById('createPasswordModal');
                var isPasswordModalShown = passwordModal && $(passwordModal).hasClass('show');
                
                // Only show manual guide modal if password modal is not shown
                if (!isPasswordModalShown) {
                    var modal = new bootstrap.Modal(document.getElementById('manualGuideModal'));
                    modal.show();
                    
                    // Initialize feather icons after modal is shown (one-time event)
                    $('#manualGuideModal').one('shown.bs.modal', function() {
                        setTimeout(function() {
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }
                        }, 100);
                    });
                } else {
                    // If password modal is shown, wait for it to close
                    $('#createPasswordModal').one('hidden.bs.modal', function() {
                        setTimeout(function() {
                            var modal = new bootstrap.Modal(document.getElementById('manualGuideModal'));
                            modal.show();
                            
                            // Initialize feather icons after modal is shown
                            $('#manualGuideModal').one('shown.bs.modal', function() {
                                setTimeout(function() {
                                    if (typeof feather !== 'undefined') {
                                        feather.replace();
                                    }
                                }, 100);
                            });
                        }, 500);
                    });
                }
            }
            
            if (shouldShow) {
                // Wait a bit for page to load, then show modal
                setTimeout(showModal, 1500);
            }

            // Button "Buka Manual Guide" handler
            $('#btnOpenManualGuide').on('click', function() {
                // Try to find and click the manual guide button in header
                var manualGuideLink = document.querySelector('.manual-guides a');
                var manualGuideUrl = '{{ route("manual-books") }}';
                
                if (manualGuideLink && manualGuideLink.href) {
                    // Open the link (it already has target="_blank")
                    window.open(manualGuideLink.href, '_blank');
                } else if (manualGuideUrl) {
                    // Fallback: use route URL
                    window.open(manualGuideUrl, '_blank');
                } else {
                    console.warn('Manual guide route not found');
                }
                
                // Close modal
                var modal = bootstrap.Modal.getInstance(document.getElementById('manualGuideModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Only mark as shown if MAN_SETTINGS is not 1 (not forced to show)
                if (manSettings != 1) {
                    sessionStorage.setItem('manualGuideModalShown', 'true');
                }
            });

            // Button "Skip" handler
            $('#btnSkipManualGuide').on('click', function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById('manualGuideModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Only mark as shown if MAN_SETTINGS is not 1 (not forced to show)
                if (manSettings != 1) {
                    sessionStorage.setItem('manualGuideModalShown', 'true');
                }
            });

            // Also handle close button (X)
            $('#manualGuideModal').on('hidden.bs.modal', function() {
                // Only mark as shown if MAN_SETTINGS is not 1 (not forced to show)
                if (manSettings != 1) {
                    sessionStorage.setItem('manualGuideModalShown', 'true');
                }
            });
        }

        function createPassword() {
            const password = $('#newPassword').val();
            const confirmPassword = $('#confirmPassword').val();

            // Validation
            if (!password || password.length < 8) {
                showToast('Password minimal 8 karakter', 'error');
                return;
            }

            if (password !== confirmPassword) {
                showToast('Konfirmasi password tidak sesuai', 'error');
                return;
            }

            showLoading('savePasswordBtn');

            $.ajax({
                url: '/api/update-profile',
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({
                    password: password,
                    password_confirmation: confirmPassword
                }),
                                                                success: function(response) {
                    hideLoading('savePasswordBtn', 'Simpan');

                    console.log('Response:', response); // Debug log

                    // Check if response is successful (handle both success and message formats)
                    if (response.success || response.message === 'Profile updated successfully') {
                                                showToast('Anda akan relogin kembali untuk menggunakan password baru.', 'success');

                        // Close modal immediately and logout after short delay
                        const modal = bootstrap.Modal.getInstance(document.getElementById('createPasswordModal'));
                        if (modal) {
                            modal.hide();
                        } else {
                            // Fallback: hide modal directly
                            $('#createPasswordModal').modal('hide');
                        }

                        // Logout after modal closes
                        setTimeout(() => {
                            console.log('Attempting logout...'); // Debug log
                            if (typeof logout === 'function') {
                                logout();
                            } else {
                                // Fallback logout
                                const logoutForm = document.getElementById('logout-form');
                                if (logoutForm) {
                                    logoutForm.submit();
                                } else {
                                    // Direct redirect to logout
                                    window.location.href = '{{ route("logout") }}';
                                }
                            }
                        }, 1000);
                    } else {
                        showToast(response.message || 'Gagal membuat password', 'error');
                    }
                },
                error: function(xhr) {
                    hideLoading('savePasswordBtn', 'Simpan');

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        // Display validation errors
                        const errors = xhr.responseJSON.errors;
                        if (errors.password) {
                            showToast(errors.password[0], 'error');
                        } else if (errors.password_confirmation) {
                            showToast(errors.password_confirmation[0], 'error');
                        } else {
                            showToast('Terjadi kesalahan validasi', 'error');
                        }
                    } else {
                        showToast('Terjadi kesalahan saat menyimpan password', 'error');
                    }
                }
            });
        }



    </script>
@endsection
