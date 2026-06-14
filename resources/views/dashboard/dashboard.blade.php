@extends('layouts.template')

@section('content')
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Dashboard </h3>
        </div>
      </div>
    </div>
  </div><!-- Container-fluid starts-->


  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xxl-4 col-sm-6 box-col-6">
        <div class="card profile-box">
          <div class="card-body">
            <div class="d-flex media-wrapper justify-content-between">
              <div class="flex-grow-1">
                <div class="greeting-user">
                  <h2 class="f-w-600">Selamat Datang <br>@namalengkap(Auth::user()->name)!</h2>
                  <p>Here whats happing in your account today</p>
                  {{-- <div class="whatsnew-btn"><a class="btn btn-outline-white" href="user-profile.html" target="_blank">View
                      Profile</a></div> --}}
                </div>
              </div>
              <div>
                <div class="clockbox"><svg id="clock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600">
                    <g id="face">
                      <circle class="circle" cx="300" cy="300" r="253.9"></circle>
                      <path class="hour-marks"
                        d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6">
                      </path>
                      <circle class="mid-circle" cx="300" cy="300" r="16.2"></circle>
                    </g>
                    <g id="hour">
                      <path class="hour-hand" d="M300.5 298V142"></path>
                      <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                    </g>
                    <g id="minute">
                      <path class="minute-hand" d="M300.5 298V67"> </path>
                      <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                    </g>
                    <g id="second">
                      <path class="second-hand" d="M300.5 350V55"></path>
                      <circle class="sizing-box" cx="300" cy="300" r="253.9"> </circle>
                    </g>
                  </svg></div>
                <div class="badge f-10 p-0" id="txt"></div>
              </div>
            </div>
            <div class="cartoon"><img class="img-fluid" src="{{ asset('') }}assets/images/dashboard/cartoon.svg"
                alt="vector women with leptop"></div>
          </div>
        </div>
      </div>
      @role('admin')
        @include('dashboard.role.admin-dashboard')
        @elserole('dosen')
        @include('dashboard.role.dosen-dashboard')
        @elserole('mahasiswa')
        @include('dashboard.role.mahasiswa-dashboard')
      @else
        <p>Role tidak dikenali.</p>
      @endrole
    </div>
  </div>

  <script>
    // Fungsi untuk animasi counter
    function animateCounter() {
      const counters = document.querySelectorAll('.counter');

      counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target')) || 0; // Default ke 0
        const increment = target > 0 ? target / 100 : 0;
        let current = 0;

        // Reset counter ke 0
        counter.textContent = '0';

        const updateCounter = () => {
          if (current < target && target > 0) {
            current += increment;
            if (current > target) {
              current = target;
            }
            counter.textContent = Math.floor(current);
            requestAnimationFrame(updateCounter);
          } else {
            // Tampilkan nilai final (termasuk 0)
            counter.textContent = target;
          }
        };

        updateCounter();
      });
    }

    // Jalankan ketika halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      animateCounter();
    });

    // Alternatif dengan jQuery jika Anda menggunakan jQuery
    /*
    $(document).ready(function() {
        $('.counter').each(function() {
            var $this = $(this);
            var target = parseInt($this.attr('data-target')) || 1; // Default ke 1

            $({ counter: 0 }).animate({
                counter: target
            }, {
                duration: 2000, // 2 detik
                easing: 'swing',
                step: function() {
                    $this.text(Math.ceil(this.counter));
                },
                complete: function() {
                    $this.text(target);
                }
            });
        });
    });
    */
  </script>
@endsection
