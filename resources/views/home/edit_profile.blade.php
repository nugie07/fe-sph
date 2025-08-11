@extends('layout.master')

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-sm-6">
        <h3>Edit Profile</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}"><i data-feather="home"></i></a>
          </li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Edit Profile</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">

        <!-- Sidebar Card -->
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header pb-0">
              <h4 class="card-title mb-0">My Profile</h4>
            </div>
            <div class="card-body">
              <form id="profile-main-form">
                <div class="row mb-2">
                  <div class="profile-title">
                    <div class="d-lg-flex d-block align-items-center">
                    <!-- Avatar with first letter of first_name from session and random background color -->
                    @php
                        $firstName = session('user.first_name', '');
                        $initial = strtoupper(substr($firstName, 0, 1));
                        // Generate a random color based on the first name
                        function stringToColor($str) {
                                $hash = 0;
                                for ($i = 0; $i < strlen($str); $i++) {
                                        $hash = ord($str[$i]) + (($hash << 5) - $hash);
                                }
                                $color = '#';
                                for ($i = 0; $i < 3; $i++) {
                                        $value = ($hash >> ($i * 8)) & 0xFF;
                                        $color .= str_pad(dechex($value), 2, '0', STR_PAD_LEFT);
                                }
                                return $color;
                        }
                        $bgColor = stringToColor($firstName);
                    @endphp
                    <span class="img-70 rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                style="font-size:2rem; background:{{ $bgColor }};">
                        {{ $initial ?: '?' }}
                    </span>
                      <div class="flex-grow-1">
                        <h3 id="profile-name" class="mb-1 f-20 txt-primary">...</h3>
                        <p class="f-12 mb-0" id="profile-role">...</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label f-w-500">Email-Address</label>
                  <input id="email" class="form-control" placeholder="your-email@domain.com" readonly>
                </div>
                <div class="mb-3">
                  <label class="form-label f-w-500">Password</label>
                  <input id="password" class="form-control" type="password" placeholder="Leave blank to keep current">
                </div>

                <div class="form-footer">
                  <button class="btn btn-primary btn-block rounded" type="submit">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Main Form -->
        <div class="col-xl-8">
          <form id="profile-main-form">
            <div class="card-header pb-0">
              <h4 class="card-title mb-0">Edit Profile</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                    <label class="form-label f-w-500">First Name</label>
                    <input id="first_name" class="form-control" type="text" placeholder="First Name">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                    <label class="form-label f-w-500">Last Name</label>
                    <input id="last_name" class="form-control" type="text" placeholder="Last Name">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label f-w-500">Address</label>
                    <input id="address" class="form-control" type="text" placeholder="Home Address">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="mb-3">
                    <label class="form-label f-w-500">Country</label>
                    <select id="country" class="form-control btn-square">
                      <option value="Indonesia">Indonesia</option>
                      <option value="Singapore">Singapore</option>
                      <option value="Malaysia">Malaysia</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-end rounded">
              <button class="btn btn-primary rounded" type="submit">Update Profile</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Tampilkan overlay
  $('#loading-overlay').show();

  $.ajax({
    url: '/api/profile-details',
    method: 'GET',
    success: function(data) {
      const profile = data.profile_details;

      $('#profile-name').text(`${profile.first_name} ${profile.last_name}`);
      $('#profile-role').text(profile.role);

      $('#email').val(profile.email || '');
      $('#first_name').val(profile.first_name || '');
      $('#last_name').val(profile.last_name || '');
      $('#address').val(profile.address || '');
      $('#country').val(profile.country || '');
      $('#password').val('');
    },
    error: function(xhr) {
      alert(xhr.responseJSON?.message || 'Gagal memuat data profil.');
    },
    complete: function() {
      // Sembunyikan overlay
      $('#loading-overlay').hide();
    }
  });
});
</script>
<script>
$(document).ready(function() {
  $('#profile-main-form').submit(function(e) {
    e.preventDefault();

    var firstName = $('#first_name').val();
    var lastName  = $('#last_name').val();
    var address   = $('#address').val();
    var country   = $('#country').val();

    var payload = {};
    if (firstName) payload.first_name = firstName;
    if (lastName)  payload.last_name  = lastName;
    if (address)   payload.address    = address;
    if (country)   payload.country    = country;

    if ($.isEmptyObject(payload)) {
      alert('Nothing to update!');
      return;
    }

    // Tampilkan overlay
    $('#loading-overlay').show();

    $.ajax({
      url: '/api/update-profile',
      method: 'POST',
      data: payload,
      success: function(res) {
        alert(res.message || 'Profile updated successfully!');
      },
      error: function(xhr) {
        let msg = 'Update failed.';
        if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
        if (xhr.responseJSON?.errors) {
          msg = Object.values(xhr.responseJSON.errors).join('\n');
        }
        alert(msg);
      },
      complete: function() {
        // Sembunyikan overlay
        $('#loading-overlay').hide();
      }
    });
  });
});
</script>

@endsection
