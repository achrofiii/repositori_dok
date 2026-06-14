@if (session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const Toast = Swal.mixin({
        toast: true,
        position: "bottom-start",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        },
      });
      Toast.fire({
        icon: "success",
        title: "{{ session('success') }}",
      });
    });
  </script>
@endif

@if (session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const Toast = Swal.mixin({
        toast: true,
        position: "bottom-start",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        },
      });
      Toast.fire({
        icon: "error",
        title: "{{ session('error') }}",
      });
    });
  </script>
@endif

<script>
  function confirmDelete(button) {
    Swal.fire({
      title: 'Anda yakin?',
      text: 'Data ini akan dihapus secara permanen!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Submit form untuk menghapus kategori
        button.closest('form').submit();
      } else {
        Swal.fire(
          'Dibatalkan',
          'Penghapusan data dibatalkan.',
          'info'
        );
      }
    });
  }
</script>

<!-- Jika ada session sukses -->
@if (session('delete_success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire(
        'Terhapus!',
        '{{ session('delete_success') }}',
        'success'
      );
    });
  </script>
@endif

<!-- Jika ada session error -->
@if (session('delete_error'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire(
        'Gagal!',
        '{{ session('delete_error') }}',
        'error'
      );
    });
  </script>
@endif

{{-- SweetAlert untuk login sukses --}}
@if (session('login_success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        title: "Good job!",
        text: "{{ session('login_success') }}",
        icon: "success",
      });
    });
  </script>
@endif

{{-- sweet alert form error --}}
@if ($errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        type: 'error',
        icon: 'error',
        title: 'Oops...',
        html: `
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                `,
        didOpen: () => {
          // Menyembunyikan elemen swal2-select
          const swalSelect = document.querySelector('.swal2-select');
          if (swalSelect) {
            swalSelect.style.display = 'none';
          }
        }
      });
    });
  </script>
@endif

