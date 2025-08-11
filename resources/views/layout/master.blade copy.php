<!DOCTYPE html>
<html lang="en" @if (Route::currentRouteName()=='layout_rtl') dir="rtl" @endif>

<head>
    @include('layout.head')
    <!-- comman css-->
    @include('layout.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  // PAKAI SESSION kalau token di simpan di session
//   const token = '{{ session('api_token') }}';

//   $.ajaxSetup({
//     beforeSend: function(xhr) {
//       if (token) {
//         xhr.setRequestHeader('Authorization', 'Bearer ' + token);
//       }
//       xhr.setRequestHeader('Accept', 'application/json');
//       xhr.setRequestHeader('X-Client-Secret', '{{ config('services.api.client_secret') }}');
//     }
//   });

//   console.log('Bearer Token:', token);
</script>
{{-- // For Loading --}}
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
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
</body>
</html>
