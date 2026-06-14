<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets') }}/images/fav.png">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header">
            <h4 class="mb-0">Reset Password</h4>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <p class="text-muted">Masukkan password baru untuk akun <strong>{{ $email }}</strong></p>

            <form method="POST" action="{{ route('password.update') }}">
              @csrf
              <input type="hidden" name="email" value="{{ $email }}">

              <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <div class="position-relative">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required minlength="8" style="padding-right: 40px;">
                  <span class="position-absolute"
                    style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10;"
                    id="toggle-password">
                    <i class="fa fa-eye" id="eye-icon-password"></i>
                  </span>
                </div>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimal 8 karakter</small>
              </div>

              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="position-relative">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    required minlength="8" style="padding-right: 40px;">
                  <span class="position-absolute"
                    style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10;"
                    id="toggle-confirmation">
                    <i class="fa fa-eye" id="eye-icon-confirmation"></i>
                  </span>
                </div>
              </div>

              <button type="submit" class="btn btn-primary w-100">Update Password</button>
            </form>

            <div class="text-center mt-3">
              <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Function untuk toggle password visibility
    function setupPasswordToggle(toggleId, inputId, iconId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);

      toggle.addEventListener('click', function() {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);

        // Toggle icon
        if (type === 'text') {
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    }

    // Setup toggle untuk kedua password field
    document.addEventListener('DOMContentLoaded', function() {
      setupPasswordToggle('toggle-password', 'password', 'eye-icon-password');
      setupPasswordToggle('toggle-confirmation', 'password_confirmation', 'eye-icon-confirmation');
    });

    // Validasi password confirmation
    const password = document.querySelector('input[name="password"]');
    const confirmation = document.querySelector('input[name="password_confirmation"]');

    confirmation.addEventListener('input', function() {
      if (password.value !== this.value) {
        this.setCustomValidity('Password tidak cocok');
      } else {
        this.setCustomValidity('');
      }
    });
  </script>
</body>

</html>
