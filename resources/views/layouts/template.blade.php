<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from admin.pixelstrap.com/cuba/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Apr 2025 08:48:03 GMT -->

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
  <meta name="keywords"
    content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">

  <style>
    .ck-editor__editable_inline {
      height: 300px;
    }
  </style>

  <x-template.link></x-template.link>

</head>

<body onload="startTime()">
  <!-- loader starts-->
  <div class="loader-wrapper">
    <div class="loader-index"> <span></span></div><svg>
      <defs></defs>
      <filter id="goo">
        <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
        </fecolormatrix>
      </filter>
    </svg>
  </div>
  <!-- loader ends-->

  <!-- tap on top starts-->
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->

  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">

    <x-template.header></x-template.header>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

      <x-template.seeder></x-template.seeder>

      <div class="page-body">

        @yield('content')

      </div>

      <x-template.footer></x-template.footer>

    </div>
  </div>

  <x-template.script></x-template.script>
  <x-template.alert></x-template.alert>

</body>
<!-- Mirrored from admin.pixelstrap.com/cuba/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Apr 2025 08:49:21 GMT -->

</html>
