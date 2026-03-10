@php
use App\Helpers\PermissionHelper;
$hasReportingDropdown = PermissionHelper::hasPermission('reporting.dropdown');
@endphp
@extends('layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
    <style>
        .report-form-card { max-width: 600px; }
        .form-label.required::after { content: ' *'; color: #dc3545; }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Generate Report</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Reporting</a></li>
                        <li class="breadcrumb-item active">Generate Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card report-form-card">
                    <div class="card-header pb-0">
                        <h4 class="mb-2">Request Generate Report</h4>
                        <span>Report akan ditambahkan ke antrian. Cek menu Download Report untuk mengambil file.</span>
                    </div>
                    <div class="card-body">
                        <form id="form-generate-report">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Tipe Report</label>
                                    <select class="form-select" id="report_type" name="report_type" required>
                                        <option value="">Pilih Tipe</option>
                                        @if($hasReportingDropdown)
                                        <option value="ar">AR</option>
                                        @endif
                                        <option value="ap">AP</option>
                                    </select>
                                    @if(!$hasReportingDropdown)
                                    <small class="text-muted">Akses terbatas: hanya AP (Transportir).</small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipe (AP)</label>
                                    <select class="form-select" id="ap_sub_type" name="ap_sub_type" disabled>
                                        @if($hasReportingDropdown)
                                        <option value="all">All</option>
                                        <option value="supplier">Supplier</option>
                                        <option value="transportir">Transportir</option>
                                        @else
                                        <option value="transportir">Transportir</option>
                                        @endif
                                    </select>
                                    <small class="text-muted">Hanya aktif jika Tipe Report = AP{{ !$hasReportingDropdown ? ' (akses terbatas: Transportir saja)' : '' }}</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to">
                                </div>
                                <div class="col-12">
                                    <small class="text-muted">AR wajib isi Date From & Date To. AP opsional.</small>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" id="btn-submit-report">
                                        <span class="txt">Submit</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                    <a href="{{ route('reporting.download') }}" class="btn btn-outline-secondary ms-2">Ke Download Report</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#report_type').on('change', function() {
                var val = $(this).val();
                if (val === 'ap') {
                    $('#ap_sub_type').prop('disabled', false);
                    var hasAll = $('#ap_sub_type option[value="all"]').length > 0;
                    if (!hasAll) $('#ap_sub_type').val('transportir');
                } else {
                    $('#ap_sub_type').prop('disabled', true).val($('#ap_sub_type option:first').val());
                }
            });

            $('#form-generate-report').on('submit', function(e) {
                e.preventDefault();
                var reportType = $('#report_type').val();
                if (!reportType) {
                    Swal.fire('Perhatian', 'Pilih Tipe Report.', 'warning');
                    return;
                }
                var dateFrom = $('#date_from').val();
                var dateTo = $('#date_to').val();
                if (reportType === 'ar' && (!dateFrom || !dateTo)) {
                    Swal.fire('Perhatian', 'AR wajib mengisi Date From dan Date To.', 'warning');
                    return;
                }

                var payload = {
                    report_type: reportType,
                    date_from: dateFrom || null,
                    date_to: dateTo || null
                };
                if (reportType === 'ap') {
                    payload.ap_sub_type = $('#ap_sub_type').val() || 'transportir';
                }

                var $btn = $('#btn-submit-report');
                $btn.prop('disabled', true);
                $btn.find('.txt').addClass('d-none');
                $btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: '/api/reporting/request',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    }
                }).done(function(res) {
                    Swal.fire('Berhasil', res.message || 'Report request berhasil ditambahkan ke antrian.', 'success');
                    $('#form-generate-report')[0].reset();
                    $('#ap_sub_type').prop('disabled', true);
                }).fail(function(xhr) {
                    Swal.fire('Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Request report gagal.', 'error');
                }).always(function() {
                    $btn.prop('disabled', false);
                    $btn.find('.spinner-border').addClass('d-none');
                    $btn.find('.txt').removeClass('d-none');
                });
            });
        });
    </script>
@endsection
