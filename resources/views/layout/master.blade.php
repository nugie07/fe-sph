<!DOCTYPE html>
<html lang="en" @if (Route::currentRouteName()=='layout_rtl') dir="rtl" @endif>

<head>
    @include('layout.head')
    <!-- comman css-->
    @include('layout.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- // For Loading --}}
</head>

@switch(Route::currentRouteName())
    @case('dashboard')
        <body onload="startTime()">
        @break

    @case('box_layout')
        <body class="box-layout">
        @break

    @case('layout_rtl')
        <body class="rtl">
        @break

    @case('layout_dark')
        <body class="dark-only">
        @break

    @default
        <body>
@endswitch

<div id="loading-overlay" style="
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: none; /* Default hidden */
        flex-direction: column;
        align-items: center;
        justify-content: center;
        ">
  <div class="loader-10"></div>
  <div style="margin-top: 1rem; font-weight: bold; color: #333;">
    Loading... tunggu sebentar ya
  </div>
</div>

    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"> </div>
        <div class="dot"></div>
    </div>
    <!-- Loader ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper compact-sidebar" id="pageWrapper">

        <!-- Page Header Start-->
        @include('layout.header')
        <!-- Page Header Ends-->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            @include('layout.sidebar')
            <!-- Page Sidebar Ends-->


            <div class="page-body">
                @yield('main_content')
                <!-- Container-fluid Ends-->
            </div>

            <!-- footer start-->
            @include('layout.footer')

        </div>
    </div>
    {{-- scripts --}}
    @include('layout.script')
    {{--end scripts --}}

<script>
// 1. Fungsi Modal & Logout
function showSessionExpiredModal() {
    if ($('#sessionExpiredModal').length === 0) {
        $('body').append(`
            <div class="modal fade" id="sessionExpiredModal" tabindex="-1" aria-labelledby="sessionExpiredLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sessionExpiredLabel">Maaf Sesi Habis !!</h5>
                        </div>
                        <div class="modal-body">
                            Sesi anda sudah habis, tolong login kembali.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary rounded-square" id="btnSessionExpiredOk" style="border-radius: 0.5rem; min-width: 48px; min-height: 48px;" data-bs-dismiss="modal">
                                <i data-feather="alert-triangle"></i>
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    $('#sessionExpiredModal').modal({backdrop: 'static', keyboard: false});
    $('#sessionExpiredModal').modal('show');
    $('#btnSessionExpiredOk').off('click').on('click', function(){
        logout();
    });
}

// Cek session langsung saat page load
function checkSessionOnce() {
    // Check if we're on login page - if so, don't check permissions
    if (window.location.pathname === '/' || window.location.pathname === '/login') {
        return;
    }

    // Check permissions in localStorage first
    const permissions = localStorage.getItem('user_permissions');
    const token = localStorage.getItem('api_token');

    if (!permissions || !token) {
        // If no permissions or token, redirect to login page
        window.location.href = '/';
        return;
    }

    // Check if token is expired
    const tokenExpiry = localStorage.getItem('token_expires_at');
    if (tokenExpiry && new Date() > new Date(tokenExpiry)) {
        // Token expired, clear storage and redirect to login
        clearLocalStorage();
        window.location.href = '/';
        return;
    }

    // Additional server-side check
    $.ajax({
        url: '/api/check-session',
        method: 'GET',
        success: function(res){
            // Token masih valid, tidak perlu aksi
        },
        error: function(xhr){
            if(xhr.status === 401) {
                clearLocalStorage();
                showSessionExpiredModal();
            }
        }
    });
}

// Function to clear localStorage
function clearLocalStorage() {
    localStorage.removeItem('user_permissions');
    localStorage.removeItem('api_token');
    localStorage.removeItem('token_expires_at');
    localStorage.removeItem('user_data');
}

// Interval checker (5 menit, bisa diubah)
function startSessionChecker() {
    setInterval(checkSessionOnce, 5 * 60 * 1000);
}

// Logout via POST (submit form)
function logout() {
    // Clear localStorage before logout
    clearLocalStorage();

    // Check if logout form exists
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm) {
        logoutForm.submit();
    } else {
        // Fallback: redirect to login page
        window.location.href = '/';
    }
}

$(function(){
    // Only check session if not on login page
    if (window.location.pathname !== '/' && window.location.pathname !== '/login') {
        checkSessionOnce();     // Cek session saat page load
        startSessionChecker();  // Interval auto checker
    }
});
</script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
</body>
</html>
