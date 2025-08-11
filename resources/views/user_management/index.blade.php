@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
<style>
.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
    transition: background-color 0.2s;
}

.sortable:hover {
    background-color: #f8f9fa;
}

.sort-icon {
    margin-left: 5px;
    opacity: 0.5;
    font-size: 12px;
}

.sortable:hover .sort-icon {
    opacity: 1;
}

.sort-icon.fa-sort-up,
.sort-icon.fa-sort-down {
    opacity: 1;
    color: #007bff;
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.invalid-feedback:not(:empty) {
    display: block;
}

.form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
</style>
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>User Management</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Administration</li>
                    <li class="breadcrumb-item active">User Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>User List</h4>
                        <button class="btn btn-primary rounded-square d-flex align-items-center" type="button" onclick="openCreateModal()" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                            <i data-feather="plus" style="margin-right: 8px;"></i>
                            Add New User
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Controls -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Search Users</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by name or email...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-info rounded-square form-control d-flex align-items-center justify-content-center" type="button" onclick="searchUsers()" style="border-radius: 0.5rem; min-height: 48px;">
                                    <i data-feather="search" style="margin-right: 8px;"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-secondary rounded-square form-control d-flex align-items-center justify-content-center" type="button" onclick="resetSearch()" style="border-radius: 0.5rem; min-height: 48px;">
                                    <i data-feather="refresh-cw" style="margin-right: 8px;"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="table-responsive theme-scrollbar">
                        <table class="table table-striped" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="sortable" data-sort="full_name">
                                        Full Name
                                        <i class="fa fa-sort sort-icon" data-sort="full_name"></i>
                                    </th>
                                    <th class="sortable" data-sort="email">
                                        Email
                                        <i class="fa fa-sort sort-icon" data-sort="email"></i>
                                    </th>
                                    <th class="sortable" data-sort="rolename">
                                        Role
                                        <i class="fa fa-sort sort-icon" data-sort="rolename"></i>
                                    </th>
                                    <th class="sortable" data-sort="status">
                                        Status
                                        <i class="fa fa-sort sort-icon" data-sort="status"></i>
                                    </th>
                                    <th class="sortable" data-sort="created_at">
                                        Created Date
                                        <i class="fa fa-sort sort-icon" data-sort="created_at"></i>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Data will be populated via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="pagination-info">
                                <span id="paginationInfo">Showing 0 to 0 of 0 entries</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end" id="pagination">
                                    <!-- Pagination buttons will be populated via JavaScript -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createUserForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="first_name" required>
                                <div class="invalid-feedback" id="error-first_name"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" name="last_name" required>
                                <div class="invalid-feedback" id="error-last_name"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                                <div class="invalid-feedback" id="error-email"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Password *</label>
                                <input type="password" class="form-control" name="password" required>
                                <div class="invalid-feedback" id="error-password"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role *</label>
                                <select class="form-control" name="role_id" id="createRoleSelect" required>
                                    <option value="">Select Role</option>
                                </select>
                                <div class="invalid-feedback" id="error-role_id"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-control" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback" id="error-status"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-square d-flex align-items-center" data-bs-dismiss="modal" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                        <i data-feather="x" style="margin-right: 8px;"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-square d-flex align-items-center" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                        <i data-feather="save" style="margin-right: 8px;"></i>
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                <input type="hidden" name="user_id" id="editUserId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="first_name" id="editFirstName" required>
                                <div class="invalid-feedback" id="edit-error-first_name"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" name="last_name" id="editLastName" required>
                                <div class="invalid-feedback" id="edit-error-last_name"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                                <div class="invalid-feedback" id="edit-error-email"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="editPassword" placeholder="Leave blank to keep current password">
                                <small class="text-muted">Leave blank to keep current password</small>
                                <div class="invalid-feedback" id="edit-error-password"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role *</label>
                                <select class="form-control" name="role_id" id="editRoleSelect" required>
                                    <option value="">Select Role</option>
                                </select>
                                <div class="invalid-feedback" id="edit-error-role_id"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-control" name="status" id="editStatus" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <div class="invalid-feedback" id="edit-error-status"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-square d-flex align-items-center" data-bs-dismiss="modal" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                        <i data-feather="x" style="margin-right: 8px;"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-square d-flex align-items-center" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                        <i data-feather="save" style="margin-right: 8px;"></i>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>User:</strong> <span id="deleteUserName"></span><br>
                    <strong>Email:</strong> <span id="deleteUserEmail"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-square d-flex align-items-center" data-bs-dismiss="modal" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                    <i data-feather="x" style="margin-right: 8px;"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-danger rounded-square d-flex align-items-center" onclick="confirmDelete()" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;">
                    <i data-feather="trash-2" style="margin-right: 8px;"></i>
                    Delete User
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>

<script>
let currentPage = 1;
let perPage = 10;
let searchQuery = '';
let deleteUserId = null;
let sortBy = '';
let sortOrder = 'asc';

$(document).ready(function() {
    // Initialize Select2 for role dropdowns
    $('#createRoleSelect').select2({
        placeholder: 'Select a role',
        dropdownParent: $('#createUserModal')
    });

    $('#editRoleSelect').select2({
        placeholder: 'Select a role',
        dropdownParent: $('#editUserModal')
    });

    // Load initial data
    loadUsers();
    loadRoles();

    // Search on Enter key
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) {
            searchUsers();
        }
    });

    // Add sorting click handlers
    $('.sortable').on('click', function() {
        const column = $(this).data('sort');
        handleSort(column);
    });

    // Form submissions
    $('#createUserForm').on('submit', function(e) {
        e.preventDefault();
        createUser();
    });

    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        updateUser();
    });
});

function showLoading() {
    $('#loading-overlay').show();
}

function hideLoading() {
    $('#loading-overlay').hide();
}

function showAlert(message, type = 'success') {
    const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // Remove existing alerts
    $('.alert').remove();

    // Add new alert at the top of the container
    $('.container-fluid').first().after(alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}

function loadUsers(page = 1) {
    showLoading();
    currentPage = page;

    const params = new URLSearchParams({
        page: page,
        per_page: perPage,
        search: searchQuery
    });

    // Add sorting parameters if set
    if (sortBy) {
        params.append('sort_by', sortBy);
        params.append('sort_order', sortOrder);
    }

    $.ajax({
        url: `/api/user-management?${params.toString()}`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                populateUsersTable(response.data);
                updatePagination(response.pagination);
                updateSortIcons();
            } else {
                showAlert('Failed to load users', 'error');
            }
        },
        error: function(xhr) {
            console.error('Error loading users:', xhr);
            showAlert('Error loading users data', 'error');
        },
        complete: function() {
            hideLoading();
        }
    });
}

function populateUsersTable(users) {
    const tbody = $('#usersTableBody');
    tbody.empty();

    if (users.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="7" class="text-center">No users found</td>
            </tr>
        `);
        return;
    }

    users.forEach((user, index) => {
        const statusBadge = user.status == 1
            ? '<span class="badge badge-success">Active</span>'
            : '<span class="badge badge-danger">Inactive</span>';

        // Calculate row number based on current page and index
        const rowNumber = ((currentPage - 1) * perPage) + index + 1;

        const row = `
            <tr>
                <td>${rowNumber}</td>
                <td>${user.full_name}</td>
                <td>${user.email}</td>
                <td>${user.rolename}</td>
                <td>${statusBadge}</td>
                <td>${new Date(user.created_at).toLocaleDateString()}</td>
                <td>
                    <ul class="action">
                        <li class="edit">
                            <a href="javascript:void(0)" onclick="openEditModal(${user.id})" title="Edit">
                                <i class="icon-pencil-alt"></i>
                            </a>
                        </li>
                        <li class="delete">
                            <a href="javascript:void(0)" onclick="openDeleteModal(${user.id}, '${user.full_name}', '${user.email}')" title="Delete">
                                <i class="icon-trash"></i>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        `;
        tbody.append(row);
    });
}

function updatePagination(pagination) {
    const paginationInfo = `Showing ${((pagination.current_page - 1) * pagination.per_page) + 1} to ${Math.min(pagination.current_page * pagination.per_page, pagination.total)} of ${pagination.total} entries`;
    $('#paginationInfo').text(paginationInfo);

    const paginationContainer = $('#pagination');
    paginationContainer.empty();

    // Previous button
    const prevDisabled = !pagination.has_prev_page ? 'disabled' : '';
    paginationContainer.append(`
        <li class="page-item ${prevDisabled}">
            <a class="page-link" href="javascript:void(0)" onclick="loadUsers(${pagination.current_page - 1})" style="border-radius: 0.5rem; margin-right: 5px;">
                <i data-feather="chevron-left"></i>
            </a>
        </li>
    `);

    // Page numbers
    for (let i = 1; i <= pagination.total_pages; i++) {
        const active = i === pagination.current_page ? 'active' : '';
        paginationContainer.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="javascript:void(0)" onclick="loadUsers(${i})" style="border-radius: 0.5rem; margin-right: 5px;">${i}</a>
            </li>
        `);
    }

    // Next button
    const nextDisabled = !pagination.has_next_page ? 'disabled' : '';
    paginationContainer.append(`
        <li class="page-item ${nextDisabled}">
            <a class="page-link" href="javascript:void(0)" onclick="loadUsers(${pagination.current_page + 1})" style="border-radius: 0.5rem;">
                <i data-feather="chevron-right"></i>
            </a>
        </li>
    `);

    // Re-initialize feather icons
    feather.replace();
}

function loadRoles() {
    $.ajax({
        url: '/api/user-management/list/roles',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const options = response.data.map(role =>
                    `<option value="${role.id}">${role.name}</option>`
                ).join('');

                $('#createRoleSelect').append(options);
                $('#editRoleSelect').append(options);
            }
        },
        error: function(xhr) {
            console.error('Error loading roles:', xhr);
            showAlert('Error loading roles data', 'error');
        }
    });
}

function searchUsers() {
    searchQuery = $('#searchInput').val().trim();
    loadUsers(1);
}

function resetSearch() {
    searchQuery = '';
    $('#searchInput').val('');
    loadUsers(1);
}

function handleSort(column) {
    if (sortBy === column) {
        // Toggle sort order if clicking the same column
        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
    } else {
        // Set new column and default to ascending
        sortBy = column;
        sortOrder = 'asc';
    }

    // Reset to first page when sorting
    loadUsers(1);
}

function updateSortIcons() {
    // Reset all sort icons
    $('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');

    // Update the active sort column icon
    if (sortBy) {
        const activeIcon = $(`.sort-icon[data-sort="${sortBy}"]`);
        activeIcon.removeClass('fa-sort');

        if (sortOrder === 'asc') {
            activeIcon.addClass('fa-sort-up');
        } else {
            activeIcon.addClass('fa-sort-down');
        }
    }
}

function clearValidationErrors(formPrefix = '') {
    const prefix = formPrefix ? formPrefix + '-' : '';

    // Remove error classes and clear error messages
    $(`#${prefix}error-first_name, #${prefix}error-last_name, #${prefix}error-email, #${prefix}error-password, #${prefix}error-role_id, #${prefix}error-status`).text('').hide();

    // Remove is-invalid class from inputs
    $(`.form-control`).removeClass('is-invalid');
}

function displayValidationErrors(errors, formPrefix = '') {
    const prefix = formPrefix ? formPrefix + '-' : '';

    // Clear previous errors first
    clearValidationErrors(formPrefix);

    // Display each error
    Object.keys(errors).forEach(field => {
        const errorElement = $(`#${prefix}error-${field}`);
        const inputElement = $(`[name="${field}"]`);

        if (errorElement.length > 0) {
            // Show error message
            errorElement.text(errors[field][0]).show();

            // Add invalid class to input
            if (formPrefix === 'edit') {
                $(`#edit${field.charAt(0).toUpperCase() + field.slice(1)}`).addClass('is-invalid');
            } else {
                $(`[name="${field}"]`).addClass('is-invalid');
            }
        }
    });
}

function openCreateModal() {
    $('#createUserForm')[0].reset();
    $('#createRoleSelect').val('').trigger('change');
    clearValidationErrors();
    $('#createUserModal').modal('show');
}

function createUser() {
    showLoading();

    // Clear previous validation errors
    clearValidationErrors();

    const formData = {
        first_name: $('input[name="first_name"]', '#createUserForm').val(),
        last_name: $('input[name="last_name"]', '#createUserForm').val(),
        email: $('input[name="email"]', '#createUserForm').val(),
        password: $('input[name="password"]', '#createUserForm').val(),
        role_id: parseInt($('select[name="role_id"]', '#createUserForm').val()),
        status: parseInt($('select[name="status"]', '#createUserForm').val())
    };

    $.ajax({
        url: '/api/user-management',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            $('#createUserModal').modal('hide');
            showAlert('User created successfully!');
            loadUsers(currentPage);
        },
        error: function(xhr) {
            console.error('Error creating user:', xhr);

            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                // Display validation errors in the form
                displayValidationErrors(xhr.responseJSON.errors);
            } else {
                // Display general error message
                let errorMessage = 'Error creating user';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showAlert(errorMessage, 'error');
            }
        },
        complete: function() {
            hideLoading();
        }
    });
}

function openEditModal(userId) {
    showLoading();

    // Find user data from the current table
    $.ajax({
        url: `/api/user-management?search=${userId}`,
        method: 'GET',
        success: function(response) {
            if (response.success && response.data.length > 0) {
                const user = response.data.find(u => u.id == userId);
                if (user) {
                    $('#editUserId').val(user.id);
                    $('#editFirstName').val(user.first_name);
                    $('#editLastName').val(user.last_name);
                    $('#editEmail').val(user.email);
                    $('#editPassword').val('');
                    $('#editRoleSelect').val(user.role_id).trigger('change');
                    $('#editStatus').val(user.status);

                    // Clear any previous validation errors
                    clearValidationErrors('edit');

                    $('#editUserModal').modal('show');
                }
            }
        },
        error: function(xhr) {
            console.error('Error loading user data:', xhr);
            showAlert('Error loading user data', 'error');
        },
        complete: function() {
            hideLoading();
        }
    });
}

function updateUser() {
    showLoading();

    // Clear previous validation errors
    clearValidationErrors('edit');

    const userId = $('#editUserId').val();
    const formData = {
        first_name: $('#editFirstName').val(),
        last_name: $('#editLastName').val(),
        email: $('#editEmail').val(),
        role_id: parseInt($('#editRoleSelect').val()),
        status: parseInt($('#editStatus').val())
    };

    // Only include password if it's not empty
    const password = $('#editPassword').val();
    if (password.trim() !== '') {
        formData.password = password;
    }

    $.ajax({
        url: `/api/user-management/${userId}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            $('#editUserModal').modal('hide');
            showAlert('User updated successfully!');
            loadUsers(currentPage);
        },
        error: function(xhr) {
            console.error('Error updating user:', xhr);

            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                // Display validation errors in the form
                displayValidationErrors(xhr.responseJSON.errors, 'edit');
            } else {
                // Display general error message
                let errorMessage = 'Error updating user';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showAlert(errorMessage, 'error');
            }
        },
        complete: function() {
            hideLoading();
        }
    });
}

function openDeleteModal(userId, userName, userEmail) {
    deleteUserId = userId;
    $('#deleteUserName').text(userName);
    $('#deleteUserEmail').text(userEmail);
    $('#deleteUserModal').modal('show');
}

function confirmDelete() {
    if (!deleteUserId) return;

    showLoading();

    $.ajax({
        url: `/api/user-management/${deleteUserId}`,
        method: 'DELETE',
        success: function(response) {
            $('#deleteUserModal').modal('hide');
            showAlert('User deleted successfully!');
            loadUsers(currentPage);
            deleteUserId = null;
        },
        error: function(xhr) {
            console.error('Error deleting user:', xhr);
            let errorMessage = 'Error deleting user';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert(errorMessage, 'error');
        },
        complete: function() {
            hideLoading();
        }
    });
}
</script>
@endsection
