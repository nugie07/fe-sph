@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>SPH Monitoring</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item active">SPH Monitoring</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="mb-3">PDF Jobs</h4>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label for="filter-kode-sph" class="form-label">Kode SPH</label>
                                <input type="text" class="form-control" id="filter-kode-sph" placeholder="Contoh: GMK">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id="btn-search-pdf-jobs">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-pdf-jobs">
                                <thead>
                                    <tr>
                                        <th>Kode SPH</th>
                                        <th>Status</th>
                                        <th>Attempt</th>
                                        <th>Update File SPH</th>
                                        <th>Temp SPH Action</th>
                                        <th>PDF URL</th>
                                        <th>Error</th>
                                        <th>Triggered By User ID</th>
                                        <th>Finished At</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Can Recreate</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="pdf-jobs-pagination" class="mt-3"></div>
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
        $(document).ready(function() {
            var currentPage = 1;
            var perPage = 15;
            var currentKodeSph = '';

            function loadPdfJobs(page) {
                page = page || 1;
                currentPage = page;
                var params = { page: page, per_page: perPage };
                if (currentKodeSph) params.kode_sph = currentKodeSph;
                var query = $.param(params);
                $.get('/api/sph/pdf-jobs?' + query)
                    .done(function(res) {
                        if (!res.success || !res.data) {
                            $('#table-pdf-jobs tbody').html('<tr><td colspan="12" class="text-center">Tidak ada data</td></tr>');
                            $('#pdf-jobs-pagination').empty();
                            return;
                        }
                        var rows = res.data.map(function(row) {
                            var canRecreateCell = row.can_recreate
                                ? '<button type="button" class="btn btn-sm btn-primary btn-recreate-pdf-job" data-sph-id="' + (row.sph_id || '') + '" data-attempt="' + (row.attempt || 0) + '" data-id="' + (row.id || '') + '">Buat Ulang</button>'
                                : '<span class="text-muted">Tidak bisa Generate ulang</span>';
                            var finishedAt = row.finished_at ? new Date(row.finished_at).toLocaleString('id-ID') : '-';
                            var createdAt = row.created_at ? new Date(row.created_at).toLocaleString('id-ID') : '-';
                            var updatedAt = row.updated_at ? new Date(row.updated_at).toLocaleString('id-ID') : '-';
                            var pdfUrl = row.pdf_url ? '<a href="' + row.pdf_url + '" target="_blank" rel="noopener">Link</a>' : '-';
                            return '<tr>' +
                                '<td>' + (row.kode_sph || '-') + '</td>' +
                                '<td><span class="badge bg-' + (row.status === 'success' ? 'success' : 'danger') + '">' + (row.status || '-') + '</span></td>' +
                                '<td>' + (row.attempt != null ? row.attempt : '-') + '</td>' +
                                '<td>' + (row.update_file_sph != null ? row.update_file_sph : '-') + '</td>' +
                                '<td>' + (row.temp_sph_action || '-') + '</td>' +
                                '<td>' + pdfUrl + '</td>' +
                                '<td>' + (row.error || '-') + '</td>' +
                                '<td>' + (row.triggered_by_user_id != null ? row.triggered_by_user_id : '-') + '</td>' +
                                '<td>' + finishedAt + '</td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + updatedAt + '</td>' +
                                '<td>' + canRecreateCell + '</td>' +
                                '</tr>';
                        });
                        $('#table-pdf-jobs tbody').html(rows.length ? rows.join('') : '<tr><td colspan="12" class="text-center">Tidak ada data</td></tr>');

                        var meta = res.meta || {};
                        var lastPage = meta.last_page || 1;
                        var total = meta.total || 0;
                        var from = (meta.current_page - 1) * meta.per_page + 1;
                        var to = Math.min(meta.current_page * meta.per_page, total);
                        var paginationHtml = '<nav><ul class="pagination mb-0">';
                        if (meta.current_page > 1) {
                            paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + (meta.current_page - 1) + '">Prev</a></li>';
                        }
                        for (var p = 1; p <= lastPage; p++) {
                            if (p === meta.current_page) {
                                paginationHtml += '<li class="page-item active"><span class="page-link">' + p + '</span></li>';
                            } else {
                                paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + p + '">' + p + '</a></li>';
                            }
                        }
                        if (meta.current_page < lastPage) {
                            paginationHtml += '<li class="page-item"><a class="page-link" href="#" data-page="' + (meta.current_page + 1) + '">Next</a></li>';
                        }
                        paginationHtml += '</ul></nav>';
                        paginationHtml += '<small class="text-muted">Menampilkan ' + from + ' - ' + to + ' dari ' + total + ' data</small>';
                        $('#pdf-jobs-pagination').html(paginationHtml);
                    })
                    .fail(function(xhr) {
                        $('#table-pdf-jobs tbody').html('<tr><td colspan="12" class="text-center text-danger">Gagal memuat data</td></tr>');
                        $('#pdf-jobs-pagination').empty();
                    });
            }

            $('#btn-search-pdf-jobs').on('click', function() {
                currentKodeSph = $('#filter-kode-sph').val().trim();
                loadPdfJobs(1);
            });

            $(document).on('click', '#pdf-jobs-pagination .page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                if (page) loadPdfJobs(page);
            });

            $(document).on('click', '.btn-recreate-pdf-job', function() {
                var sphId = $(this).data('sph-id');
                var attempt = parseInt($(this).data('attempt'), 10) || 0;
                var $btn = $(this);
                if (!sphId) {
                    Swal.fire('Oops!', 'SPH ID tidak ditemukan.', 'warning');
                    return;
                }
                var doRecreate = function() {
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
                    $.ajax({
                        url: '/api/sph/' + sphId + '/recreate-pdf',
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        contentType: 'application/json',
                        data: JSON.stringify({}),
                        success: function(res) {
                            $btn.prop('disabled', false).html('Buat Ulang');
                            if (res && res.success) {
                                Swal.fire('Berhasil', res.message || 'PDF sedang digenerate ulang.', 'success');
                                loadPdfJobs(currentPage);
                            } else {
                                Swal.fire('Gagal', (res && res.message) || 'Gagal recreate PDF', 'error');
                            }
                        },
                        error: function(xhr) {
                            $btn.prop('disabled', false).html('Buat Ulang');
                            Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Gagal recreate PDF', 'error');
                        }
                    });
                };
                if (attempt >= 3) {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Attempt sudah 3. Yakin ingin generate ulang PDF?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Buat Ulang',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) doRecreate();
                    });
                } else {
                    doRecreate();
                }
            });

            loadPdfJobs(1);
        });
    </script>
@endsection
