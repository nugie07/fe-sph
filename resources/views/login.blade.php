@extends('others.others_layout.master')

@section('others_css')
<style>
/* Prevent text selection and copying on captcha */
#captchaDisplay {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: transparent;
}

#captchaSvg {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    pointer-events: none;
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: transparent;
}

/* Prevent context menu on captcha */
#captchaDisplay {
    -webkit-context-menu: none;
    -moz-context-menu: none;
    -ms-context-menu: none;
    context-menu: none;
}

/* Disable drag and drop */
#captchaDisplay, #captchaSvg {
    -webkit-user-drag: none;
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
    user-drag: none;
}

/* Prevent any text selection */
#captchaDisplay * {
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}
</style>
@endsection

@section('others_content')
<div class="container-fluid">
    <div class="row">
      <div class="col-xl-5"><img class="bg-img-cover bg-center"
        src="{{ asset('assets/images/login/login_imagebg_1.png') }}" alt="looginpage"></div>
      <div class="col-xl-7 p-0">
        <div class="login-card">
          <div>
            <div>
                <div style="margin-top: -30px;">
                    <a class="logo" href="/">
                        <img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo_minamaret.png') }}"
                        alt="looginpage" width="110" height="60">
                   <div style="color: #fff; font-weight: bold; font-size: 18px; margin-top: 10px; text-align: center;">
                        SPH - miniERP Surat Penawaran Harga
                    </div>
                    </a>

                </div>
            </div>
            <div class="login-main">
                <form class="theme-form" method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <h4 class="text-center">Login ke dalam aplikasi</h4>
                    @if ($errors->has('login'))
                        <div class="alert alert-danger text-center">
                            {{ $errors->first('login') }}
                        </div>
                    @endif
                    <p class="text-center">Masukkan email & password Anda untuk login</p>
                    <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" required placeholder="Test@gmail.com">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <div class="form-input position-relative">
                            <input class="form-control" type="password" name="password" required placeholder="*********">

                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="text-center mb-3">
                            <a href="javascript:void(0)" onclick="openResetPasswordModal()" class="text-primary" style="text-decoration: none; font-size: 14px;">
                                Reset Password
                            </a>
                        </div>
                        <div class="text-end mt-3">
                            <button id="btn-submit" class="btn btn-primary btn-block w-100" type="submit" style="border-radius: 10px;">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span class="btn-text">Login</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Step 1: Email and Captcha -->
                <div id="step1">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="resetEmail" placeholder="Masukan email anda" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Captcha *</label>
                                                                <div class="d-flex align-items-center">
                                    <div class="form-control p-0" id="captchaDisplay" style="background-color: #f8f9fa; border: 1px solid #dee2e6; min-height: 38px; display: flex; align-items: center; justify-content: center; user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; cursor: default;">
                                        <svg id="captchaSvg" width="120" height="30" style="pointer-events: none;"></svg>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary ms-2" onclick="generateCaptcha()" style="min-width: 40px; border-radius: 0.5rem;">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                                <small class="text-muted mt-1" id="captchaTimer" style="font-size: 11px;">Captcha akan diperbarui dalam 30 detik</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Masukkan Captcha *</label>
                                <input type="text" class="form-control" id="captchaInput" placeholder="Masukkan angka captcha" maxlength="6" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-primary w-100" id="requestOtpBtn" onclick="requestOTP()" disabled style="border-radius: 0.5rem;">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <span class="btn-text">Request OTP</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: OTP Verification -->
                <div id="step2" style="display: none;">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        OTP telah dikirim ke email <strong id="otpEmailDisplay"></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Masukkan OTP *</label>
                                <input type="text" class="form-control" id="otpInput" placeholder="Masukkan 6 digit OTP" maxlength="6" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-success w-100" id="resetPasswordBtn" onclick="resetPassword()" disabled style="border-radius: 0.5rem;">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <span class="btn-text">Reset Password</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-link" onclick="backToStep1()" style="border-radius: 0.5rem;">
                            <i class="fa fa-arrow-left"></i> Kembali ke langkah sebelumnya
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeResetPasswordModal()" style="border-radius: 0.5rem;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="resetPasswordToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@section('others_script')
<script>
  // Initialize page on load
  document.addEventListener('DOMContentLoaded', function() {
    generateCaptcha();
  });

  // Function to clear localStorage
  function clearLocalStorage() {
    localStorage.removeItem('user_permissions');
    localStorage.removeItem('api_token');
    localStorage.removeItem('token_expires_at');
    localStorage.removeItem('user_data');
  }

    // Handle login form submission
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = document.getElementById('btn-submit');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');

    // Disable submit button and show loading
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Mencoba Login...';

    fetch('{{ route("login") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: formData
    })
            .then(response => {
      console.log('Response status:', response.status);
      console.log('Response headers:', response.headers);

      if (response.redirected) {
        // Login successful, redirect to home
        window.location.href = response.url;
        return;
      }

      // Check if response is JSON
      const contentType = response.headers.get('content-type');
      console.log('Content-Type:', contentType);

      if (contentType && contentType.includes('application/json')) {
        return response.json().then(data => {
          // Add status to data for error handling
          data.status = response.status;
          return data;
        });
      } else {
        // If not JSON and status is 200, redirect to home (successful login)
        if (response.status === 200) {
          window.location.href = '{{ route("home") }}';
          return;
        } else {
          // If not JSON and status is not 200, treat as error
          return {
            success: false,
            message: 'Login failed',
            status: response.status
          };
        }
      }
    })
        .then(data => {
      console.log('Response data:', data);

      if (data && data.success) {
        // Store data in localStorage
        localStorage.setItem('api_token', data.token);
        localStorage.setItem('user_permissions', JSON.stringify(data.permissions));
        localStorage.setItem('user_data', JSON.stringify(data.user));
        if (data.expires_at) {
          localStorage.setItem('token_expires_at', data.expires_at);
        }

        // Redirect to home
        window.location.href = '{{ route("home") }}';
      } else if (data && data.errors) {
        // Handle validation errors
        const errorMessages = Object.values(data.errors).flat();
        showToast(errorMessages.join(', '), 'error');
      } else if (data && data.status && data.status >= 400) {
        // Handle HTTP error status
        showToast(data.message || 'Login failed', 'error');
      } else if (data && data.message) {
        // Handle any other error message
        showToast(data.message, 'error');
      } else {
        showToast('Login failed', 'error');
      }
    })
    .catch(error => {
      console.error('Login error:', error);
      showToast('Terjadi kesalahan saat login. Silakan coba lagi.', 'error');
    })
    .finally(() => {
      // Re-enable submit button
      submitBtn.disabled = false;
      spinner.classList.add('d-none');
      btnText.textContent = 'Login';
    });
  });

  // Reset Password Variables
  let captchaAnswer = '';
  let currentEmail = '';
  let currentOtp = '';
  let captchaTimer = null;
  let captchaTimeout = 30000; // 30 seconds

    function openResetPasswordModal() {
    // Reset form
    document.getElementById('resetEmail').value = '';
    document.getElementById('captchaInput').value = '';
    document.getElementById('otpInput').value = '';
    document.getElementById('requestOtpBtn').disabled = true;
    document.getElementById('resetPasswordBtn').disabled = true;

    // Show step 1
    document.getElementById('step1').style.display = 'block';
    document.getElementById('step2').style.display = 'none';

    // Generate new captcha
    generateCaptcha();

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
    modal.show();
  }

  function closeResetPasswordModal() {
    // Clear captcha timer when modal is closed
    if (captchaTimer) {
      clearTimeout(captchaTimer);
      captchaTimer = null;
    }

    // Clear countdown timer
    if (window.captchaCountdown) {
      clearInterval(window.captchaCountdown);
      window.captchaCountdown = null;
    }
  }

        function generateCaptcha() {
    // Clear existing timer
    if (captchaTimer) {
      clearTimeout(captchaTimer);
    }

    // Generate 6 random digits
    const digits = '0123456789';
    let captcha = '';
    for (let i = 0; i < 6; i++) {
      captcha += digits.charAt(Math.floor(Math.random() * digits.length));
    }

    captchaAnswer = captcha;

    // Generate SVG captcha
    const svg = document.getElementById('captchaSvg');
    svg.innerHTML = '';

    // Create SVG content
    let svgContent = '';

    // Add background noise (random dots)
    for (let i = 0; i < 20; i++) {
      const x = Math.random() * 120;
      const y = Math.random() * 30;
      const radius = Math.random() * 2 + 0.5;
      svgContent += `<circle cx="${x}" cy="${y}" r="${radius}" fill="#e0e0e0" opacity="0.3"/>`;
    }

    // Add random lines for noise
    for (let i = 0; i < 5; i++) {
      const x1 = Math.random() * 120;
      const y1 = Math.random() * 30;
      const x2 = Math.random() * 120;
      const y2 = Math.random() * 30;
      svgContent += `<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="#d0d0d0" stroke-width="1" opacity="0.4"/>`;
    }

    // Add each digit with random styling
    for (let i = 0; i < captcha.length; i++) {
      const digit = captcha[i];
      const x = 15 + (i * 18); // Space digits evenly
      const y = 20 + (Math.random() * 6 - 3); // Slight vertical variation
      const rotation = (Math.random() * 20 - 10); // Random rotation
      const fontSize = 16 + (Math.random() * 4 - 2); // Random font size
      const colors = ['#2c3e50', '#34495e', '#7f8c8d', '#95a5a6', '#2c3e50'];
      const color = colors[Math.floor(Math.random() * colors.length)];

      svgContent += `
        <text x="${x}" y="${y}"
              font-family="Arial, sans-serif"
              font-size="${fontSize}"
              font-weight="bold"
              fill="${color}"
              transform="rotate(${rotation} ${x} ${y})"
              text-anchor="middle">
          ${digit}
        </text>
      `;
    }

    svg.innerHTML = svgContent;

    // Clear captcha input and disable request button
    document.getElementById('captchaInput').value = '';
    document.getElementById('requestOtpBtn').disabled = true;

    // Start countdown timer
    startCaptchaCountdown();

    // Set timer to auto-refresh captcha after 30 seconds
    captchaTimer = setTimeout(() => {
      generateCaptcha();
      showToast('Captcha telah diperbarui otomatis', 'warning');
    }, captchaTimeout);
  }

  function startCaptchaCountdown() {
    let timeLeft = 30;
    const timerElement = document.getElementById('captchaTimer');

    const countdown = setInterval(() => {
      if (timeLeft > 0) {
        timerElement.textContent = `Captcha akan diperbarui dalam ${timeLeft} detik`;
        timeLeft--;
      } else {
        clearInterval(countdown);
        timerElement.textContent = 'Memperbarui captcha...';
      }
    }, 1000);

    // Store countdown interval to clear it when needed
    window.captchaCountdown = countdown;
  }

  // Check captcha input
  document.getElementById('captchaInput').addEventListener('input', function() {
    const captchaInput = this.value;
    const requestBtn = document.getElementById('requestOtpBtn');

    if (captchaInput === captchaAnswer && captchaInput.length === 6) {
      requestBtn.disabled = false;
    } else {
      requestBtn.disabled = true;
    }
  });

  // Check OTP input
  document.getElementById('otpInput').addEventListener('input', function() {
    const otpInput = this.value;
    const resetBtn = document.getElementById('resetPasswordBtn');

    if (otpInput.length === 6) {
      resetBtn.disabled = false;
    } else {
      resetBtn.disabled = true;
    }
  });

  function showToast(message, type = 'success') {
    const toast = document.getElementById('resetPasswordToast');
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
    btnText.textContent = 'Loading...';
  }

  function hideLoading(buttonId, originalText) {
    const button = document.getElementById(buttonId);
    const spinner = button.querySelector('.spinner-border');
    const btnText = button.querySelector('.btn-text');

    button.disabled = false;
    spinner.classList.add('d-none');
    btnText.textContent = originalText;
  }

  function requestOTP() {
    const email = document.getElementById('resetEmail').value.trim();
    const captchaInput = document.getElementById('captchaInput').value;

    if (!email) {
      showToast('Mohon masukkan email address', 'error');
      return;
    }

    if (captchaInput !== captchaAnswer) {
      showToast('Captcha tidak sesuai', 'error');
      return;
    }

    showLoading('requestOtpBtn');

    fetch('/api/auth/generate-otp', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        email: email
      })
    })
    .then(response => response.json())
    .then(data => {
      hideLoading('requestOtpBtn', 'Request OTP');

      if (data.success) {
        currentEmail = email;
        document.getElementById('otpEmailDisplay').textContent = email;

        // Show step 2
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';

        showToast(data.message, 'success');
      } else {
        showToast(data.message, 'error');
      }
    })
    .catch(error => {
      hideLoading('requestOtpBtn', 'Request OTP');
      console.error('Error:', error);
      showToast('Terjadi kesalahan saat request OTP', 'error');
    });
  }

  function resetPassword() {
    const otpInput = document.getElementById('otpInput').value;

    if (!otpInput || otpInput.length !== 6) {
      showToast('Mohon masukkan OTP yang valid', 'error');
      return;
    }

    showLoading('resetPasswordBtn');

    fetch('/api/auth/reset-password', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        email: currentEmail,
        otp: otpInput
      })
    })
    .then(response => response.json())
    .then(data => {
      hideLoading('resetPasswordBtn', 'Reset Password');

      if (data.success) {
        showToast(data.message, 'success');

        // Close modal after success
        setTimeout(() => {
          const modal = bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal'));
          modal.hide();
        }, 2000);
      } else {
        showToast(data.message, 'error');
      }
    })
    .catch(error => {
      hideLoading('resetPasswordBtn', 'Reset Password');
      console.error('Error:', error);
      showToast('Terjadi kesalahan saat reset password', 'error');
    });
  }

  function backToStep1() {
    document.getElementById('step1').style.display = 'block';
    document.getElementById('step2').style.display = 'none';
    document.getElementById('otpInput').value = '';
    document.getElementById('resetPasswordBtn').disabled = true;
  }
</script>

@endsection
