<!DOCTYPE html>
<html lang="en">
<head>
  @include('layout.head')
  @include('layout.css')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
    }
    
    .manual-guide-container {
      display: flex;
      flex-direction: column;
      height: 100vh;
      background: #fff;
    }
    
    .manual-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 30px;
      border-bottom: 1px solid #e0e0e0;
      background: #f8f9fa;
      flex-shrink: 0;
    }
    
    .logo-title-section {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .logo-title-section img {
      height: 45px;
      width: auto;
    }
    
    .logo-title-section span {
      color: #333;
      font-weight: bold;
      font-size: 1.5rem;
    }
    
    .manual-title-section {
      flex: 1;
      text-align: center;
    }
    
    .manual-title-section h2 {
      margin: 0;
      color: #333;
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .manual-body {
      display: flex;
      flex: 1;
      overflow: hidden;
    }
    
    .manual-sidebar {
      width: 300px;
      border-right: 1px solid #e0e0e0;
      overflow-y: auto;
      background: #f8f9fa;
      padding: 20px 0;
    }
    
    .manual-content {
      flex: 1;
      overflow-y: auto;
      padding: 30px;
      background: #fff;
    }
    
    .menu-item {
      padding: 12px 20px;
      cursor: pointer;
      border-bottom: 1px solid #e0e0e0;
      transition: background-color 0.2s;
    }
    
    .menu-item:hover {
      background-color: #e9ecef;
    }
    
    .menu-item.active {
      background-color: #007bff;
      color: #fff;
    }
    
    .menu-item-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .menu-item-title {
      font-weight: bold;
      font-size: 1rem;
    }
    
    .menu-item.active .menu-item-title {
      color: #fff;
    }
    
    .menu-chevron {
      transition: transform 0.3s;
      font-size: 0.875rem;
    }
    
    .menu-chevron.expanded {
      transform: rotate(90deg);
    }
    
    .menu-details {
      display: none;
      padding-left: 20px;
      background: #fff;
    }
    
    .menu-details.show {
      display: block;
    }
    
    .menu-detail-item {
      padding: 10px 20px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      transition: background-color 0.2s;
      font-size: 0.9rem;
    }
    
    .menu-detail-item:hover {
      background-color: #f0f0f0;
    }
    
    .menu-detail-item.active {
      background-color: #e7f3ff;
      color: #007bff;
      font-weight: 500;
    }
    
    .content-placeholder {
      text-align: center;
      color: #999;
      padding: 50px 20px;
      font-size: 1.1rem;
    }
    
    .content-display {
      display: none;
    }
    
    .content-display.show {
      display: block;
    }
    
    .content-display h3 {
      margin-top: 0;
      color: #333;
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    
    .content-display .content-body {
      line-height: 1.8;
      color: #555;
    }
    
    .content-display .content-body img {
      max-width: 100%;
      height: auto;
    }
    
    .content-display .content-body table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    
    .content-display .content-body table th,
    .content-display .content-body table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    
    .content-display .content-body table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="manual-guide-container">
    <!-- Header Section -->
    <div class="manual-header">
      <div class="logo-title-section">
        <img src="{{ asset('assets/images/logo/logo_minamaret.png') }}" alt="Logo">
        <span>SPH</span>
      </div>
      <div class="manual-title-section">
        <h2>{{ env('MANUAL', 'Manual Guide Penggunaan aplikasi Internal Mina Marret') }}</h2>
      </div>
      <div style="width: 200px;"></div> <!-- Spacer for centering -->
    </div>
    
    <!-- Body Section -->
    <div class="manual-body">
      <!-- Left Sidebar -->
      <div class="manual-sidebar" id="manualSidebar">
        <div class="text-center p-3">
          <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
          </div>
          <p class="mt-2 text-muted">Loading menu...</p>
        </div>
      </div>
      
      <!-- Right Content Pane -->
      <div class="manual-content">
        <div class="content-placeholder" id="contentPlaceholder">
          disini adalah Content dari Manual Detail yang dipilih di menu kiri
        </div>
        <div class="content-display" id="contentDisplay">
          <h3 id="contentTitle"></h3>
          <div class="content-body" id="contentBody"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap js-->
  <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <!-- feather icon js-->
  <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>

  <script>
  $(document).ready(function() {
    let menuData = [];
    let selectedMenuId = null;
    let selectedDetailId = null;
    
    // Fetch menu data from API
    // The proxy controller will use session token automatically
    $.ajax({
      url: '/api/manual',
      type: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        if (response.success && response.data) {
          menuData = response.data;
          renderMenu(menuData);
        } else {
          $('#manualSidebar').html('<div class="text-center p-3 text-danger">Tidak ada data menu</div>');
        }
      },
      error: function(xhr) {
        console.error('Error fetching menu data:', xhr);
        let errorMsg = 'Error loading menu data';
        if (xhr.status === 401) {
          errorMsg = 'Session expired. Silakan login kembali.';
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMsg = xhr.responseJSON.message;
        }
        $('#manualSidebar').html('<div class="text-center p-3 text-danger">' + errorMsg + '</div>');
      }
    });
    
    // Render menu items
    function renderMenu(menus) {
      let html = '';
      
      menus.forEach(function(menu) {
        if (menu.status !== 1) return; // Skip inactive menus
        
        const hasDetails = menu.details && menu.details.length > 0;
        const isExpanded = selectedMenuId === menu.id;
        
        html += '<div class="menu-item' + (isExpanded ? ' active' : '') + '" data-menu-id="' + menu.id + '">';
        html += '  <div class="menu-item-header">';
        html += '    <span class="menu-item-title">' + menu.sequence + '. ' + menu.title + '</span>';
        if (hasDetails) {
          html += '    <span class="menu-chevron' + (isExpanded ? ' expanded' : '') + '">▶</span>';
        }
        html += '  </div>';
        html += '</div>';
        
        // Details section
        if (hasDetails) {
          html += '<div class="menu-details' + (isExpanded ? ' show' : '') + '" data-menu-id="' + menu.id + '">';
          menu.details.forEach(function(detail) {
            const isActive = selectedDetailId === detail.id;
            html += '<div class="menu-detail-item' + (isActive ? ' active' : '') + '" data-detail-id="' + detail.id + '" data-menu-id="' + menu.id + '">';
            html += '  ' + detail.sequence + '. ' + (detail.content ? stripHtml(detail.content).substring(0, 50) + '...' : 'Detail ' + detail.sequence);
            html += '</div>';
          });
          html += '</div>';
        }
      });
      
      $('#manualSidebar').html(html);
      
      // Attach event handlers
      attachEventHandlers();
    }
    
    // Attach event handlers for menu items
    function attachEventHandlers() {
      // Menu item click (toggle expand/collapse)
      $('.menu-item').off('click').on('click', function(e) {
        e.stopPropagation();
        const menuId = $(this).data('menu-id');
        const $menuItem = $(this);
        const $details = $('.menu-details[data-menu-id="' + menuId + '"]');
        const $chevron = $menuItem.find('.menu-chevron');
        
        // Toggle active state
        if (selectedMenuId === menuId) {
          // Collapse
          selectedMenuId = null;
          $menuItem.removeClass('active');
          $details.removeClass('show');
          $chevron.removeClass('expanded');
          // Clear content
          showPlaceholder();
        } else {
          // Expand
          selectedMenuId = menuId;
          $('.menu-item').removeClass('active');
          $('.menu-details').removeClass('show');
          $('.menu-chevron').removeClass('expanded');
          $menuItem.addClass('active');
          $details.addClass('show');
          $chevron.addClass('expanded');
          // Clear detail selection
          selectedDetailId = null;
          $('.menu-detail-item').removeClass('active');
          showPlaceholder();
        }
      });
      
      // Detail item click (show content)
      $('.menu-detail-item').off('click').on('click', function(e) {
        e.stopPropagation();
        const detailId = $(this).data('detail-id');
        const menuId = $(this).data('menu-id');
        
        // Update active state
        $('.menu-detail-item').removeClass('active');
        $(this).addClass('active');
        selectedDetailId = detailId;
        
        // Find and display content
        const menu = menuData.find(m => m.id === menuId);
        if (menu && menu.details) {
          const detail = menu.details.find(d => d.id === detailId);
          if (detail) {
            displayContent(detail);
          }
        }
      });
    }
    
    // Display content in right pane
    function displayContent(detail) {
      $('#contentPlaceholder').hide();
      $('#contentTitle').text('Detail ' + detail.sequence);
      $('#contentBody').html(detail.content || '<p>No content available</p>');
      $('#contentDisplay').addClass('show');
    }
    
    // Show placeholder
    function showPlaceholder() {
      $('#contentDisplay').removeClass('show');
      $('#contentPlaceholder').show();
    }
    
    // Strip HTML tags for preview
    function stripHtml(html) {
      const tmp = document.createElement('DIV');
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || '';
    }
    
    // Initialize feather icons if available
    if (window.feather) {
      feather.replace();
    }
  });
  </script>
</body>
</html>
