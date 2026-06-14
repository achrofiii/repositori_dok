<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets') }}/images/fav.png">
  <title>Verifikasi OTP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header">
            <h4 class="mb-0">Verifikasi Kode OTP</h4>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <p class="text-muted">Masukkan kode OTP 6 digit yang telah dikirim ke email
              <strong>{{ $email }}</strong></p>

            <form method="POST" action="{{ route('password.verify-otp') }}">
              @csrf
              <input type="hidden" name="email" value="{{ $email }}">

              <div class="mb-3">
                <label for="otp" class="form-label">Kode OTP</label>
                <input type="text" class="form-control text-center @error('otp') is-invalid @enderror" name="otp"
                  maxlength="6" placeholder="000000" required style="font-size: 1.5rem; letter-spacing: 0.5rem;">
                @error('otp')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary w-100">Verifikasi OTP</button>
            </form>

            <div class="text-center mt-3">
              <p class="text-muted">Tidak menerima kode?</p>
              <button type="button" class="btn btn-outline-secondary btn-sm" id="resend-otp">
                Kirim Ulang OTP
              </button>
            </div>

            <div class="text-center mt-3">
              <a href="{{ route('password.request') }}" class="text-decoration-none">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('resend-otp').addEventListener('click', function() {
      const btn = this;
      const email = '{{ $email }}';

      btn.disabled = true;
      btn.textContent = 'Mengirim...';

      fetch('{{ route('password.resend-otp') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            email: email
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Kode OTP baru telah dikirim ke email Anda');
          } else {
            alert('Gagal mengirim OTP: ' + data.error);
          }
        })
        .catch(error => {
          alert('Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(() => {
          btn.disabled = false;
          btn.textContent = 'Kirim Ulang OTP';
        });
    });

    // Auto focus dan format input OTP
    const otpInput = document.querySelector('input[name="otp"]');
    otpInput.addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');
    });
  </script>
</body>

</html>
