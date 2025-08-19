@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
<style>
.permission-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    margin-left: 0;
    margin-right: 0;
}

/* Sticky header for role selection */
.sticky-role-header {
    position: sticky;
    top: 0;
    background: white;
    z-index: 1000;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
    margin: 0 -20px 20px -20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: calc(100% + 40px);
}

/* Scrollable permissions section */
.scrollable-permissions {
    max-height: calc(100vh - 300px);
    overflow-y: auto;
    padding: 0 10px 0 0;
}

/* Custom scrollbar for permissions section */
.scrollable-permissions::-webkit-scrollbar {
    width: 8px;
}

.scrollable-permissions::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.scrollable-permissions::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.scrollable-permissions::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.permission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.permission-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 15px;
    transition: all 0.2s ease;
}

.permission-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0,123,255,0.1);
}

.permission-item.checked {
    background: #e7f3ff;
    border-color: #007bff;
}

.permission-checkbox {
    margin-right: 10px;
    transform: scale(1.2);
}

.permission-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.permission-meta {
    font-size: 12px;
    color: #6c757d;
}



.save-permissions-btn {
    border-radius: 0.25rem !important;
    min-width: 150px;
    min-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.save-permissions-btn .btn-text {
    display: flex;
    align-items: center;
    justify-content: center;
}

.save-permissions-btn i {
    margin-right: 8px;
}

.add-role-btn {
    min-width: 150px;
    min-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-role-btn .btn-text {
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-role-btn i {
    margin-right: 8px;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

/* Ensure proper container spacing */
.container-fluid {
    padding-left: 15px;
    padding-right: 15px;
}

.card-body {
    overflow-x: hidden;
}
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>Role Permission Management</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">User Management</li>
                    <li class="breadcrumb-item active">Role Permissions</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="mb-3">Manage Role Permissions</h4>
                    <span>Kelola akses permission untuk setiap role yang ada dalam sistem.</span>
                </div>
                <div class="card-body">
                    <!-- Sticky Role Selection Header -->
                    <div class="sticky-role-header">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Role *</label>
                                <select class="form-control" id="roleSelect" style="border-radius: 0.5rem;">
                                    <option value="">-- Pilih Role --</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="button" class="btn btn-success add-role-btn me-2" onclick="openAddRoleModal()" style="border-radius: 0.25rem;">
                                    <span class="btn-text">
                                        <i data-feather="plus"></i>
                                        Add Role
                                    </span>
                                </button>
                                <button type="button" class="btn btn-primary save-permissions-btn" id="savePermissionsBtn" onclick="savePermissions()" disabled>
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <span class="btn-text">
                                        <i data-feather="save"></i>
                                        Simpan Permissions
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- Permissions Section -->
                    <div id="permissionsSection" style="display: none; position: relative;">
                        <div class="loading-overlay" id="permissionsLoading">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div class="scrollable-permissions">
                            <div class="permission-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">
                                        <i data-feather="list"></i>
                                        Available Permissions
                                    </h5>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="selectAllPermissions()" style="border-radius: 0.5rem;">
                                            <i data-feather="check-square"></i>
                                            Select All
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm ms-2" onclick="deselectAllPermissions()" style="border-radius: 0.5rem;">
                                            <i data-feather="square"></i>
                                            Deselect All
                                        </button>
                                    </div>
                                </div>

                                <div class="permission-grid" id="permissionsGrid">
                                    <!-- Permissions will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5 px-3">
                        <i data-feather="shield-off" style="width: 64px; height: 64px; color: #6c757d;"></i>
                        <h5 class="mt-3 text-muted">Pilih Role untuk Melihat Permissions</h5>
                        <p class="text-muted">Silakan pilih role dari dropdown di atas untuk mengelola permissions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="permissionToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">
                    <i data-feather="plus-circle"></i>
                    Add New Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name *</label>
                        <input type="text" class="form-control" id="roleName" name="name" required placeholder="Enter role name">
                        <div class="invalid-feedback" id="error-roleName"></div>
                    </div>
                    <div class="mb-3">
                        <label for="guardName" class="form-label">Guard Name *</label>
                        <select class="form-control" id="guardName" name="guard_name" required>
                            <option value="">-- Select Guard --</option>
                            <option value="web" selected>Web</option>
                            <option value="api">API</option>
                        </select>
                        <div class="invalid-feedback" id="error-guardName"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 0.25rem;">
                    <i data-feather="x"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-success" id="saveRoleBtn" onclick="saveRole()" style="border-radius: 0.25rem;">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span class="btn-text">
                        <i data-feather="save"></i>
                        Save Role
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>

<script>
let currentRoleId = null;
let permissions = [];

$(document).ready(function() {
    // Initialize Select2
    $('#roleSelect').select2({
        placeholder: '-- Pilih Role --',
        allowClear: true
    });

    // Load roles
    loadRoles();

    // Role change handler
    $('#roleSelect').on('change', function() {
        const roleId = $(this).val();
        if (roleId) {
            currentRoleId = roleId;
            loadRolePermissions(roleId);
        } else {
            currentRoleId = null;
            showEmptyState();
        }
    });
});

function showToast(message, type = 'success') {
    const toast = document.getElementById('permissionToast');
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
    btnText.innerHTML = '<i data-feather="loader"></i> Menyimpan...';
}

function hideLoading(buttonId, originalText) {
    const button = document.getElementById(buttonId);
    const spinner = button.querySelector('.spinner-border');
    const btnText = button.querySelector('.btn-text');

    button.disabled = false;
    spinner.classList.add('d-none');
    btnText.innerHTML = originalText;

    // Re-initialize feather icons
    feather.replace();
}

function loadRoles() {
    $.ajax({
        url: '/api/user-management/list/roles',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const roleSelect = $('#roleSelect');
                roleSelect.empty().append('<option value="">-- Pilih Role --</option>');

                response.data.forEach(role => {
                    roleSelect.append(`<option value="${role.id}">${role.name}</option>`);
                });
            }
        },
        error: function(xhr) {
            console.error('Error loading roles:', xhr);
            showToast('Gagal memuat data roles', 'error');
        }
    });
}

function loadRolePermissions(roleId) {
    // Immediately show permissions section and hide empty state
    $('#emptyState').hide();
    $('#permissionsSection').show();
    $('#permissionsLoading').show();

    $.ajax({
        url: `/api/user-management/roles/${roleId}/permissions`,
        method: 'GET',
        success: function(response) {
            hidePermissionsLoading();

            if (response.success) {
                permissions = response.data;
                displayPermissions(response.data);
                enableSaveButton();
            } else {
                showToast(response.message || 'Gagal memuat permissions', 'error');
                showEmptyState();
            }
        },
        error: function(xhr) {
            hidePermissionsLoading();
            console.error('Error loading permissions:', xhr);
            showToast('Gagal memuat data permissions', 'error');
            showEmptyState();
        }
    });
}



function displayPermissions(permissionsData) {
    const grid = $('#permissionsGrid');
    grid.empty();

    if (!permissionsData || permissionsData.length === 0) {
        grid.append('<div class="text-center py-3"><p class="text-muted">Tidak ada permissions untuk role ini</p></div>');
        return;
    }

    permissionsData.forEach(permission => {
        const isChecked = permission.is_assigned === 1;
        const checkedClass = isChecked ? 'checked' : '';

        const permissionHtml = `
            <div class="permission-item ${checkedClass}" data-permission-id="${permission.id}" style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px; background: #f8f9fa;">
                <div class="d-flex align-items-start">
                    <input type="checkbox" class="permission-checkbox"
                           data-permission-id="${permission.id}"
                           ${isChecked ? 'checked' : ''}
                           onchange="togglePermissionItem(this)"
                           style="margin-right: 10px;">
                    <div class="flex-grow-1">
                        <div class="permission-name" style="font-weight: bold; color: #333;">${permission.name}</div>
                        <div class="permission-meta">
                            <small style="color: #666;">
                                <i data-feather="shield" style="width: 12px; height: 12px;"></i>
                                Guard: ${permission.guard_name}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        `;

        grid.append(permissionHtml);
    });

    // Re-initialize feather icons
    feather.replace();
}

function togglePermissionItem(checkbox) {
    const permissionId = $(checkbox).data('permission-id');
    const permissionItem = $(`.permission-item[data-permission-id="${permissionId}"]`);

    if (checkbox.checked) {
        permissionItem.addClass('checked');
    } else {
        permissionItem.removeClass('checked');
    }
}

function selectAllPermissions() {
    $('.permission-checkbox').prop('checked', true);
    $('.permission-item').addClass('checked');
}

function deselectAllPermissions() {
    $('.permission-checkbox').prop('checked', false);
    $('.permission-item').removeClass('checked');
}

function showPermissionsSection() {
    $('#emptyState').hide();
    $('#permissionsSection').show();
}



function showEmptyState() {
    $('#permissionsSection').hide();
    $('#emptyState').show();
    disableSaveButton();
}

function showPermissionsLoading() {
    $('#permissionsLoading').show();
}

function hidePermissionsLoading() {
    $('#permissionsLoading').hide();
}

function enableSaveButton() {
    $('#savePermissionsBtn').prop('disabled', false);
}

function disableSaveButton() {
    $('#savePermissionsBtn').prop('disabled', true);
}

function savePermissions() {
    if (!currentRoleId) {
        showToast('Pilih role terlebih dahulu', 'error');
        return;
    }

    // Get checked permission IDs
    const checkedPermissions = [];
    $('.permission-checkbox:checked').each(function() {
        checkedPermissions.push(parseInt($(this).data('permission-id')));
    });

    showLoading('savePermissionsBtn');

    $.ajax({
        url: `/api/user-management/roles/${currentRoleId}/sync-permissions`,
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
            permission_ids: checkedPermissions
        }),
        success: function(response) {
            hideLoading('savePermissionsBtn', '<i data-feather="save"></i> Simpan Permissions');

            if (response.success) {
                showToast(response.message || 'Permissions berhasil disimpan!', 'success');

                // Reload permissions to show updated state
                loadRolePermissions(currentRoleId);
            } else {
                showToast(response.message || 'Gagal menyimpan permissions', 'error');
            }
        },
        error: function(xhr) {
            hideLoading('savePermissionsBtn', '<i data-feather="save"></i> Simpan Permissions');

            if (xhr.responseJSON && xhr.responseJSON.message) {
                showToast(xhr.responseJSON.message, 'error');
            } else {
                showToast('Terjadi kesalahan saat menyimpan permissions', 'error');
            }
        }
    });
}

// Add Role Functions
function openAddRoleModal() {
    // Clear form and validation errors
    $('#addRoleForm')[0].reset();
    clearValidationErrors();

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('addRoleModal'));
    modal.show();
}

function clearValidationErrors() {
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty().hide();
}

function displayValidationErrors(errors) {
    clearValidationErrors();

    Object.keys(errors).forEach(field => {
        const input = $(`[name="${field}"]`);
        const errorDiv = $(`#error-${field}`);

        if (input.length && errorDiv.length) {
            input.addClass('is-invalid');
            errorDiv.text(errors[field][0]).show();
        }
    });
}

function saveRole() {
    // Get form data
    const formData = {
        name: $('#roleName').val().trim(),
        guard_name: $('#guardName').val()
    };

    // Basic validation
    if (!formData.name) {
        showToast('Role name is required', 'error');
        return;
    }

    if (!formData.guard_name) {
        showToast('Guard name is required', 'error');
        return;
    }

    // Show loading
    showLoading('saveRoleBtn');

    $.ajax({
        url: '/api/user-management/roles',
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify(formData),
        success: function(response) {
            hideLoading('saveRoleBtn', '<i data-feather="save"></i> Save Role');

            if (response.success) {
                showToast(response.message || 'Role berhasil ditambahkan!', 'success');

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addRoleModal'));
                modal.hide();

                // Refresh roles dropdown
                loadRoles();

                // Clear form
                $('#addRoleForm')[0].reset();
            } else {
                showToast(response.message || 'Gagal menambahkan role', 'error');
            }
        },
        error: function(xhr) {
            hideLoading('saveRoleBtn', '<i data-feather="save"></i> Save Role');

            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                displayValidationErrors(xhr.responseJSON.errors);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                showToast(xhr.responseJSON.message, 'error');
            } else {
                showToast('Terjadi kesalahan saat menambahkan role', 'error');
            }
        }
    });
}
</script>
@endsection
