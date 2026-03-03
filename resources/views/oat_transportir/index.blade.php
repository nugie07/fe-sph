@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .filter-section { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .vendor-info {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn-square { border-radius: 4px; border: none; }
        .select2-container--bootstrap-5 .select2-selection { border: 1px solid #ced4da; border-radius: 0.375rem; min-height: 38px; }
        .select2-container--bootstrap-5 { width: 100% !important; }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>OAT Transportir</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">OAT Transportir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <label for="vendor-select" class="form-label">Select Vendor</label>
                    <select class="form-control" id="vendor-select">
                        <option value="">Pilih Vendor (Transporter)</option>
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

        <div class="vendor-info" id="vendor-info" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <h5 id="vendor-name">Vendor Name</h5>
                    <p id="vendor-alias" class="mb-0">Alias</p>
                </div>
                <div class="col-md-6 text-end">
                    <h6 class="mb-0">Total: <span id="total-records">0</span></h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">OAT Transportir List</h4>
                        <span>Management OAT volume per vendor (transporter). Pilih vendor terlebih dahulu.</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="oat-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Wilayah</th>
                                        <th>Lokasi (Name)</th>
                                        <th>OAT</th>
                                        <th>Value</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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
                    <h5 class="modal-title" id="oatModalLabel">Add OAT</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="oatForm">
                    <div class="modal-body">
                        <input type="hidden" id="oat_id" name="oat_id">
                        <input type="hidden" id="oat_vendor_id" name="vendor_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="oat_wilayah" class="form-label">Wilayah</label>
                                <select class="form-control" id="oat_wilayah" name="wilayah_id" required>
                                    <option value="">Pilih Wilayah</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="oat_name" class="form-label">Lokasi (Name)</label>
                                <input type="text" class="form-control" id="oat_name" name="name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="oat_oat" class="form-label">OAT</label>
                                <input type="text" class="form-control" id="oat_oat" name="oat" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="oat_value" class="form-label">Value</label>
                                <input type="text" class="form-control" id="oat_value" name="value" required>
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
        let selectedVendorId = null;
        let selectedVendorName = '';
        let selectedVendorAlias = '';

        $(document).ready(function() {
            $('#vendor-select').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih Vendor (Transporter)',
                allowClear: true,
                width: '100%'
            });

            loadVendorOptions();
            loadWilayahOptions();

            $('#vendor-select').on('change', function() {
                const vendorId = $(this).val();
                if (vendorId) {
                    const opt = $(this).find('option:selected');
                    selectedVendorId = vendorId;
                    selectedVendorName = opt.text() || '';
                    selectedVendorAlias = opt.data('alias') || '';
                    loadOatData(vendorId);
                    showVendorInfo();
                } else {
                    selectedVendorId = null;
                    selectedVendorName = '';
                    selectedVendorAlias = '';
                    hideVendorInfo();
                    if (oatTable) {
                        oatTable.destroy();
                        oatTable = null;
                    }
                }
            });

            $('#btn-add-oat').on('click', function() {
                if (!selectedVendorId) {
                    Swal.fire('Warning!', 'Pilih vendor terlebih dahulu (Select Vendor).', 'warning');
                    return;
                }
                openOatModal();
            });

            $('#oatForm').on('submit', function(e) {
                e.preventDefault();
                saveOat();
            });

            $(document).on('click', '.btn-edit-oat', function() {
                const id = $(this).data('id');
                if (id) editOat(id);
            });
            $(document).on('click', '.btn-delete-oat', function() {
                const id = $(this).data('id');
                const name = $(this).data('name') || '';
                if (id) deleteOat(id, name);
            });
        });

        function loadVendorOptions() {
            $.get('/api/oat-transportir/vendors')
                .done(function(response) {
                    const $select = $('#vendor-select');
                    $select.find('option:not(:first)').remove();
                    const data = response.data || (response.success && response.data) || [];
                    if (Array.isArray(data)) {
                        data.forEach(function(v) {
                            const label = v.nama || v.name || v.alias || v.id;
                            $select.append($('<option></option>').val(v.id).text(label).data('alias', v.alias || ''));
                        });
                    }
                    $select.trigger('change.select2');
                })
                .fail(function(xhr) {
                    console.error('Failed to load vendors:', xhr);
                    Swal.fire('Error!', 'Gagal memuat daftar vendor.', 'error');
                });
        }

        function loadWilayahOptions() {
            $.get('/api/master-wilayah')
                .done(function(response) {
                    const $select = $('#oat_wilayah');
                    $select.find('option:not(:first)').remove();
                    let data = response.data || response;
                    if (!Array.isArray(data)) data = [];
                    data.forEach(function(w) {
                        const id = w.id != null ? w.id : w.code;
                        const nama = w.nama != null ? w.nama : (w.name || w.value || String(id));
                        $select.append($('<option></option>').val(id).text(nama));
                    });
                })
                .fail(function(xhr) {
                    console.error('Failed to load wilayah:', xhr);
                });
        }

        function loadOatData(vendorId) {
            if (oatTable) {
                oatTable.destroy();
                oatTable = null;
            }

            oatTable = $('#oat-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/api/oat-transportir',
                    type: 'GET',
                    data: { vendor_id: vendorId },
                    dataSrc: function(json) {
                        if (json && !json.success && json.message) {
                            return [];
                        }
                        const data = json.data || [];
                        const pag = json.pagination || {};
                        $('#total-records').text(pag.total != null ? pag.total : data.length);
                        return data;
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'wilayah', defaultContent: '-' },
                    { data: 'name', defaultContent: '-' },
                    { data: 'oat', defaultContent: '-' },
                    { data: 'value', defaultContent: '-' },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleString('id-ID') : '-';
                        }
                    },
                    {
                        data: 'updated_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleString('id-ID') : '-';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            const name = (row.name || '').replace(/"/g, '&quot;');
                            return `
                                <button class="btn btn-sm btn-warning me-1 btn-edit-oat" data-id="${row.id}" title="Edit" style="border-radius: 4px; border: none;">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete-oat" data-id="${row.id}" data-name="${name}" title="Delete" style="border-radius: 4px; border: none;">
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
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Belum ada data",
                    zeroRecords: "Belum ada data",
                    emptyTable: "Belum ada data. Pilih vendor lalu klik Add OAT.",
                    paginate: { first: "Pertama", last: "Terakhir", next: "Selanjutnya", previous: "Sebelumnya" }
                },
                order: [],
                responsive: true
            });
        }

        function showVendorInfo() {
            $('#vendor-name').text(selectedVendorName);
            $('#vendor-alias').text(selectedVendorAlias ? 'Alias: ' + selectedVendorAlias : '');
            $('#vendor-info').show();
        }

        function hideVendorInfo() {
            $('#vendor-info').hide();
        }

        function openOatModal(oatData = null) {
            isEditMode = oatData !== null;
            $('#oatModalLabel').text(isEditMode ? 'Edit OAT' : 'Add OAT');
            $('#btn-save-oat').text(isEditMode ? 'Update' : 'Save');
            $('#oat_vendor_id').val(selectedVendorId);

            if (isEditMode && oatData) {
                $('#oat_id').val(oatData.id);
                $('#oat_wilayah').val(oatData.wilayah_id || '');
                $('#oat_name').val(oatData.name || '');
                $('#oat_oat').val(oatData.oat != null ? oatData.oat : '');
                $('#oat_value').val(oatData.value != null ? oatData.value : '');
            } else {
                $('#oat_id').val('');
                $('#oat_name').val('');
                $('#oat_oat').val('');
                $('#oat_value').val('');
                $('#oat_wilayah').val('');
            }
            $('#oatModal').modal('show');
        }

        function saveOat() {
            const $btn = $('#btn-save-oat');
            const $spinner = $btn.find('.spinner-border');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            var oatVal = $('#oat_oat').val();
            if (typeof oatVal === 'string') oatVal = oatVal.trim();
            const payload = {
                vendor_id: parseInt($('#oat_vendor_id').val(), 10),
                wilayah_id: parseInt($('#oat_wilayah').val(), 10),
                name: $('#oat_name').val().trim(),
                oat: (oatVal === '' || oatVal == null) ? null : String(oatVal),
                value: $('#oat_value').val().trim()
            };

            const oatId = $('#oat_id').val();
            const url = isEditMode ? `/api/oat-transportir/${oatId}` : '/api/oat-transportir';
            const method = isEditMode ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(payload)
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    $('#oatModal').modal('hide');
                    loadOatData(selectedVendorId);
                    Swal.fire('Success!', data.message || 'OAT berhasil disimpan', 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Gagal menyimpan OAT', 'error');
                }
            })
            .catch(function(err) {
                console.error('Error:', err);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan.', 'error');
            })
            .finally(function() {
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
            });
        }

        function editOat(id) {
            fetch(`/api/oat-transportir/${id}`, {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success && res.data) {
                    openOatModal(res.data);
                } else {
                    Swal.fire('Error!', res.message || 'Data tidak ditemukan', 'error');
                }
            })
            .catch(function(err) {
                console.error('Error:', err);
                Swal.fire('Error!', 'Gagal memuat detail OAT', 'error');
            });
        }

        function deleteOat(id, name) {
            Swal.fire({
                title: 'Yakin ingin hapus?',
                text: name ? `Hapus OAT "${name}"?` : 'Hapus data OAT ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    fetch(`/api/oat-transportir/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.success) {
                            loadOatData(selectedVendorId);
                            Swal.fire('Deleted!', data.message || 'OAT berhasil dihapus', 'success');
                        } else {
                            Swal.fire('Error!', data.message || 'Gagal menghapus OAT', 'error');
                        }
                    })
                    .catch(function(err) {
                        console.error('Error:', err);
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus.', 'error');
                    });
                }
            });
        }
    </script>
@endsection
