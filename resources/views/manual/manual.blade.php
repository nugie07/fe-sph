@extends('layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
  .manual-details-row {
    display: none;
  }
  .manual-details-row.show {
    display: table-row;
  }
  .collapse-icon {
    cursor: pointer;
    transition: transform 0.3s;
  }
  .collapse-icon.expanded {
    transform: rotate(90deg);
  }
  .detail-badge {
    margin-left: 10px;
  }
</style>
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6">
        <h3>Manual Guide</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
          <li class="breadcrumb-item active">Manual Guide</li>
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
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="mb-0">Daftar Manual Guide</h4>
              <span>Kelola manual guide dan detailnya</span>
            </div>
            <button type="button" class="btn btn-primary rounded-3" id="btnAddManual">
              <i data-feather="plus"></i> Add Manual
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive theme-scrollbar">
            <table class="display" id="manual-table" style="width:100%">
              <thead>
                <tr>
                  <th width="50px"></th>
                  <th>Sequence</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th width="150px">Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add/Edit Manual -->
<div class="modal fade" id="modalManual" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalManualLabel">Add Manual</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formManual">
        <div class="modal-body">
          <input type="hidden" id="manual_id" name="id">
          <div class="mb-3">
            <label for="manual_title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="manual_title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="manual_sequence" class="form-label">Sequence <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="manual_sequence" name="sequence" min="1" required>
          </div>
          <div class="mb-3">
            <label for="manual_status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-control" id="manual_status" name="status" required>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-3" id="btnSaveManual">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Add/Edit Manual Detail -->
<div class="modal fade" id="modalManualDetail" tabindex="-1" aria-labelledby="modalManualDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalManualDetailLabel">Add Manual Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formManualDetail">
        <div class="modal-body">
          <input type="hidden" id="detail_id" name="id">
          <input type="hidden" id="detail_menu_id" name="menu_id">
          <div class="mb-3">
            <label for="detail_sequence" class="form-label">Sequence <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="detail_sequence" name="sequence" min="1" required>
          </div>
          <div class="mb-3">
            <label for="detail_title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="detail_title" name="title" required>
          </div>
          <div class="mb-3">
            <label for="detail_content" class="form-label">Content <span class="text-danger">*</span></label>
            <textarea class="form-control" id="detail_content" name="content" rows="10" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-3" id="btnSaveDetail">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>

<script>
$(document).ready(function() {
  let manualTable;
  let currentManualId = null;

  // Initialize CKEditor for manual detail content
  let ckeditorInstance = null;
  
  function initCKEditor() {
    // Destroy existing instance if any
    if (ckeditorInstance) {
      try {
        ckeditorInstance.destroy();
        ckeditorInstance = null;
      } catch(e) {
        console.log('CKEditor destroy error:', e);
      }
    }
    // Initialize CKEditor
    if (typeof CKEDITOR !== 'undefined') {
      ckeditorInstance = CKEDITOR.replace('detail_content', {
        height: 300,
        toolbar: [
          { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
          { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
          { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
          { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
          '/',
          { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
          { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
          { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
          { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
          '/',
          { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
          { name: 'colors', items: ['TextColor', 'BGColor'] },
          { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ]
      });
    }
  }
  
  // Initialize when modal is shown
  $('#modalManualDetail').on('shown.bs.modal', function() {
    setTimeout(function() {
      initCKEditor();
    }, 100);
  });
  
  // Destroy editor when modal is hidden
  $('#modalManualDetail').on('hidden.bs.modal', function() {
    if (ckeditorInstance) {
      try {
        ckeditorInstance.destroy();
        ckeditorInstance = null;
      } catch(e) {
        console.log('CKEditor destroy error:', e);
      }
    }
  });

  // Initialize DataTable
  manualTable = $('#manual-table').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
      url: '/api/manual',
      type: 'GET',
      dataSrc: function(json) {
        return json.data || [];
      }
    },
    columns: [
      {
        data: null,
        orderable: false,
        className: 'text-center',
        render: function(data, type, row) {
          const hasDetails = row.details && row.details.length > 0;
          return hasDetails 
            ? '<i class="fa fa-chevron-right collapse-icon" data-id="' + row.id + '"></i>'
            : '';
        }
      },
      {
        data: 'sequence',
        render: function(data, type, row) {
          return `
            <div class="d-flex align-items-center gap-2">
              <span>${data}</span>
              <div class="btn-group-vertical" style="line-height: 1;">
                <button class="btn btn-xs btn-outline-secondary rounded-3 p-0 sequence-up" 
                        data-id="${row.id}" 
                        data-sequence="${data}" 
                        style="width: 20px; height: 16px; font-size: 10px; line-height: 1;"
                        title="Move Up">
                  <i class="fa fa-chevron-up"></i>
                </button>
                <button class="btn btn-xs btn-outline-secondary rounded-3 p-0 sequence-down" 
                        data-id="${row.id}" 
                        data-sequence="${data}" 
                        style="width: 20px; height: 16px; font-size: 10px; line-height: 1;"
                        title="Move Down">
                  <i class="fa fa-chevron-down"></i>
                </button>
              </div>
            </div>
          `;
        }
      },
      {
        data: 'title',
        render: function(data, type, row) {
          const detailCount = row.details ? row.details.length : 0;
          return data + (detailCount > 0 ? '<span class="badge bg-info detail-badge">' + detailCount + ' details</span>' : '');
        }
      },
      {
        data: 'status_label',
        render: function(data, type, row) {
          const badgeClass = row.status == 1 ? 'bg-success' : 'bg-secondary';
          return '<span class="badge ' + badgeClass + '">' + data + '</span>';
        }
      },
      {
        data: 'created_at',
        render: function(data) {
          return data ? new Date(data).toLocaleDateString('id-ID') : '';
        }
      },
      {
        data: null,
        orderable: false,
        render: function(data, type, row) {
          return `
            <button class="btn btn-sm btn-primary rounded-3 btn-edit-manual" data-id="${row.id}" title="Edit">
              <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-success rounded-3 btn-add-detail" data-id="${row.id}" title="Add Detail">
              <i class="fa fa-plus"></i>
            </button>
            <button class="btn btn-sm btn-danger rounded-3 btn-delete-manual" data-id="${row.id}" title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          `;
        }
      }
    ],
    order: [[1, 'asc']], // Sort by sequence (column index 1)
    drawCallback: function() {
      if (window.feather) feather.replace();
    }
  });

  // Toggle collapse/expand details
  $(document).on('click', '.collapse-icon', function() {
    const manualId = $(this).data('id');
    const $icon = $(this);
    const $row = $icon.closest('tr');
    const $nextRow = $row.next('.manual-details-row[data-manual-id="' + manualId + '"]');
    
    if ($nextRow.length) {
      // Toggle existing row
      $nextRow.toggleClass('show');
      $icon.toggleClass('expanded');
    } else {
      // Load and show details
      loadManualDetails(manualId, $row);
      $icon.addClass('expanded');
    }
  });

  // Load manual details
  function loadManualDetails(manualId, $parentRow) {
    $.ajax({
      url: '/api/manual/' + manualId,
      type: 'GET',
      success: function(response) {
        if (response.success && response.data) {
          const details = response.data.details || [];
          let html = '<tr class="manual-details-row show" data-manual-id="' + manualId + '">';
          html += '<td colspan="6">';
          html += '<div class="p-3 bg-light">';
          html += '<h6 class="mb-3">Manual Details:</h6>';
          
          if (details.length > 0) {
            html += '<table class="table table-bordered table-sm">';
            html += '<thead><tr><th width="80px">Sequence</th><th>Title</th><th>Content</th><th width="150px">Action</th></tr></thead>';
            html += '<tbody>';
            
            details.forEach(function(detail) {
              // Strip HTML tags for preview
              const contentText = detail.content ? detail.content.replace(/<[^>]*>/g, '').substring(0, 100) : '';
              html += '<tr data-detail-id="' + detail.id + '">';
              html += '<td>' + detail.sequence + '</td>';
              html += '<td><strong>' + (detail.title || '-') + '</strong></td>';
              html += '<td><div class="content-preview">' + contentText + (contentText.length >= 100 ? '...' : '') + '</div></td>';
              html += '<td>';
              html += '<button class="btn btn-sm btn-primary btn-edit-detail" data-id="' + detail.id + '" title="Edit">';
              html += '<i class="fa fa-edit"></i></button> ';
              html += '<button class="btn btn-sm btn-danger btn-delete-detail" data-id="' + detail.id + '" title="Delete">';
              html += '<i class="fa fa-trash"></i></button>';
              html += '</td>';
              html += '</tr>';
            });
            
            html += '</tbody></table>';
          } else {
            html += '<p class="text-muted">No details available</p>';
          }
          
          html += '</div></td></tr>';
          $parentRow.after(html);
        }
      },
      error: function(xhr) {
        Swal.fire('Error', 'Failed to load manual details', 'error');
      }
    });
  }

  // Add Manual button
  $('#btnAddManual').on('click', function() {
    $('#modalManualLabel').text('Add Manual');
    $('#formManual')[0].reset();
    $('#manual_id').val('');
    $('#modalManual').modal('show');
  });

  // Edit Manual button
  $(document).on('click', '.btn-edit-manual', function() {
    const manualId = $(this).data('id');
    $.ajax({
      url: '/api/manual/' + manualId,
      type: 'GET',
      success: function(response) {
        if (response.success && response.data) {
          const data = response.data;
          $('#modalManualLabel').text('Edit Manual');
          $('#manual_id').val(data.id);
          $('#manual_title').val(data.title);
          $('#manual_sequence').val(data.sequence);
          $('#manual_status').val(data.status);
          $('#modalManual').modal('show');
        }
      },
      error: function(xhr) {
        Swal.fire('Error', 'Failed to load manual data', 'error');
      }
    });
  });

  // Delete Manual button
  $(document).on('click', '.btn-delete-manual', function() {
    const manualId = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This will delete the manual and all its details',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/api/manual/' + manualId,
          type: 'DELETE',
          success: function(response) {
            if (response.success) {
              Swal.fire('Deleted!', response.message, 'success');
              // Remove any detail rows for this manual
              $('.manual-details-row[data-manual-id="' + manualId + '"]').remove();
              manualTable.ajax.reload();
            } else {
              Swal.fire('Error', response.message, 'error');
            }
          },
          error: function(xhr) {
            const message = xhr.responseJSON?.message || 'Failed to delete manual';
            Swal.fire('Error', message, 'error');
          }
        });
      }
    });
  });

  // Sequence Up button
  $(document).on('click', '.sequence-up', function(e) {
    e.stopPropagation();
    const manualId = $(this).data('id');
    const currentSequence = parseInt($(this).data('sequence'));
    const newSequence = currentSequence - 1;
    
    if (newSequence < 1) {
      Swal.fire('Warning', 'Sequence cannot be less than 1', 'warning');
      return;
    }
    
    // Get current manual data
    $.ajax({
      url: '/api/manual/' + manualId,
      type: 'GET',
      success: function(response) {
        if (response.success && response.data) {
          const data = response.data;
          // Update sequence
          $.ajax({
            url: '/api/manual/' + manualId,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
              title: data.title,
              sequence: newSequence,
              status: data.status
            }),
            success: function(updateResponse) {
              if (updateResponse.success) {
                Swal.fire('Success', 'Sequence updated', 'success');
                manualTable.ajax.reload();
              }
            },
            error: function(xhr) {
              Swal.fire('Error', 'Failed to update sequence', 'error');
            }
          });
        }
      },
      error: function(xhr) {
        Swal.fire('Error', 'Failed to load manual data', 'error');
      }
    });
  });

  // Sequence Down button
  $(document).on('click', '.sequence-down', function(e) {
    e.stopPropagation();
    const manualId = $(this).data('id');
    const currentSequence = parseInt($(this).data('sequence'));
    const newSequence = currentSequence + 1;
    
    // Get current manual data
    $.ajax({
      url: '/api/manual/' + manualId,
      type: 'GET',
      success: function(response) {
        if (response.success && response.data) {
          const data = response.data;
          // Update sequence
          $.ajax({
            url: '/api/manual/' + manualId,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
              title: data.title,
              sequence: newSequence,
              status: data.status
            }),
            success: function(updateResponse) {
              if (updateResponse.success) {
                Swal.fire('Success', 'Sequence updated', 'success');
                manualTable.ajax.reload();
              }
            },
            error: function(xhr) {
              Swal.fire('Error', 'Failed to update sequence', 'error');
            }
          });
        }
      },
      error: function(xhr) {
        Swal.fire('Error', 'Failed to load manual data', 'error');
      }
    });
  });

  // Add Detail button
  $(document).on('click', '.btn-add-detail', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const manualId = $(this).data('id');
    console.log('Add Detail clicked, manualId:', manualId); // Debug
    currentManualId = manualId;
    $('#modalManualDetailLabel').text('Add Manual Detail');
    $('#formManualDetail')[0].reset();
    $('#detail_id').val('');
    $('#detail_menu_id').val(manualId);
    $('#detail_sequence').val('');
    $('#detail_title').val('');
    // Show modal first, then initialize editor
    $('#modalManualDetail').modal('show');
  });

  // Edit Detail button
  $(document).on('click', '.btn-edit-detail', function() {
    const detailId = $(this).data('id');
    $.ajax({
      url: '/api/manual-details/' + detailId,
      type: 'GET',
      success: function(response) {
        if (response.success && response.data) {
          const data = response.data;
          currentManualId = data.menu_id;
          $('#modalManualDetailLabel').text('Edit Manual Detail');
          $('#detail_id').val(data.id);
          $('#detail_menu_id').val(data.menu_id);
          $('#detail_sequence').val(data.sequence);
          $('#detail_title').val(data.title || '');
          // Show modal first, then set content after editor is initialized
          $('#modalManualDetail').modal('show');
          // Set content after a short delay to ensure editor is ready
          setTimeout(function() {
            if (ckeditorInstance) {
              ckeditorInstance.setData(data.content || '');
            }
          }, 200);
        }
      },
      error: function(xhr) {
        Swal.fire('Error', 'Failed to load detail data', 'error');
      }
    });
  });

  // Delete Detail button
  $(document).on('click', '.btn-delete-detail', function() {
    const detailId = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This will delete the manual detail',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/api/manual-details/' + detailId,
          type: 'DELETE',
          success: function(response) {
            if (response.success) {
              Swal.fire('Deleted!', response.message, 'success');
              // Remove detail row from DOM
              $('tr[data-detail-id="' + detailId + '"]').remove();
              // Check if detail container is now empty
              $('.manual-details-row').each(function() {
                const $container = $(this);
                if ($container.find('tbody tr').length === 0) {
                  $container.remove();
                  // Also remove collapse icon expanded state
                  const manualId = $container.data('manual-id');
                  $('.collapse-icon[data-id="' + manualId + '"]').removeClass('expanded');
                }
              });
              // Reload table to update detail count badge
              manualTable.ajax.reload();
            }
          },
          error: function(xhr) {
            const message = xhr.responseJSON?.message || 'Failed to delete detail';
            Swal.fire('Error', message, 'error');
          }
        });
      }
    });
  });

  // Save Manual form
  $('#formManual').on('submit', function(e) {
    e.preventDefault();
    const manualId = $('#manual_id').val();
    const url = manualId ? '/api/manual/' + manualId : '/api/manual';
    const method = manualId ? 'PUT' : 'POST';
    
    const data = {
      title: $('#manual_title').val(),
      sequence: parseInt($('#manual_sequence').val()),
      status: parseInt($('#manual_status').val())
    };

    $.ajax({
      url: url,
      type: method,
      contentType: 'application/json',
      data: JSON.stringify(data),
      success: function(response) {
        if (response.success) {
          Swal.fire('Success', response.message, 'success');
          $('#modalManual').modal('hide');
          // Remove any expanded detail rows
          $('.manual-details-row').remove();
          manualTable.ajax.reload();
        }
      },
      error: function(xhr) {
        const message = xhr.responseJSON?.message || 'Failed to save manual';
        Swal.fire('Error', message, 'error');
      }
    });
  });

  // Save Manual Detail form
  $('#formManualDetail').on('submit', function(e) {
    e.preventDefault();
    const detailId = $('#detail_id').val();
    const url = detailId ? '/api/manual-details/' + detailId : '/api/manual-details';
    const method = detailId ? 'PUT' : 'POST';
    
    // Get content from CKEditor
    let content = '';
    if (ckeditorInstance) {
      content = ckeditorInstance.getData();
    } else {
      content = $('#detail_content').val();
    }
    
    const data = {
      menu_id: parseInt($('#detail_menu_id').val()),
      sequence: parseInt($('#detail_sequence').val()),
      title: $('#detail_title').val(),
      content: content
    };

    $.ajax({
      url: url,
      type: method,
      contentType: 'application/json',
      data: JSON.stringify(data),
      success: function(response) {
        if (response.success) {
          Swal.fire('Success', response.message, 'success');
          $('#modalManualDetail').modal('hide');
          // Remove expanded detail rows to force reload
          $('.manual-details-row').remove();
          // Reset collapse icons
          $('.collapse-icon').removeClass('expanded');
          manualTable.ajax.reload();
        }
      },
      error: function(xhr) {
        const message = xhr.responseJSON?.message || 'Failed to save detail';
        Swal.fire('Error', message, 'error');
      }
    });
  });
});
</script>
@endsection

