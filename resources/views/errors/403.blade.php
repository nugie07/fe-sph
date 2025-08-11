@extends('others.others_layout.master')

@section('others_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-5">
            <img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/login_imagebg_1.png') }}" alt="error page">
        </div>
        <div class="col-xl-7 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <div style="margin-top: -30px;">
                            <a class="logo" href="{{ route('dashboard') }}">
                                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo_minamaret.png') }}" alt="logo" width="110" height="60">
                                <div style="color: #fff; font-weight: bold; font-size: 18px; margin-top: 10px; text-align: center;">
                                    SPH - miniERP Surat Penawaran Harga
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="login-main">
                        <div class="text-center">
                            <div class="mb-4">
                                <i data-feather="shield-off" style="width: 80px; height: 80px; color: #dc3545;"></i>
                            </div>
                            <h2 class="text-danger mb-3">Access Denied</h2>
                            <h4 class="mb-3">You don't have access to this page</h4>
                            <p class="text-muted mb-4">
                                Sorry, you don't have the required permissions to access this page.
                                Please contact your administrator if you believe this is an error.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('home') }}" class="btn btn-primary" style="border-radius: 0.5rem;">
                                    <i data-feather="home"></i>
                                    Go to Dashboard
                                </a>
                                <a href="javascript:history.back()" class="btn btn-outline-secondary" style="border-radius: 0.5rem;">
                                    <i data-feather="arrow-left"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
