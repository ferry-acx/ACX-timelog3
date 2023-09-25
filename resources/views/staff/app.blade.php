<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ACX Attendance System</title>

  <link rel="icon" href="../dist/acx-imgs/logo.png" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.0/css/all.css' rel='stylesheet'>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>

</head>
<body class="hold-transition layout-top-nav">
    <style>
      .content-wrapper {
          background-image: url('../dist/acx-imgs/desktop-background.png');
          background-size: cover;
          background-position: center center;
          background-repeat: no-repeat
      }
      .overlay{
            opacity: 1;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
    }

    .select2-container .select2-selection--single {
      height: unset;
    }
    
    .select2-search__field{
        width: 100% !important;
    }

    .btn {
      text-wrap: nowrap;
    }

    </style>

<div class="wrapper">

  <!-- PAGE LOADER -->
  <div id="page-loader" class="overlay" style="display: none">
    <i class="fas fa-spinner fa-spin"></i>
  </div>

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="../dist/acx-imgs/fav.png" alt="ACXLogo" height="60" width="60">
  </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white p-3">
        <div class="container">
          <a href="/staff" class="navbar-brand">
            <img src="../dist/acx-imgs/logo-acx.png" alt="ACX Logo" class="" style="width: 180px">
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarCollapse">
          <!-- Right navbar links -->
          <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a href="/staff" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="/staff/tracker" class="nav-link">Tracker Logs</a>
            </li>
            @if(Auth::user()->role==3)
            <li class="nav-item">
                <a href="/staff/mypod" class="nav-link">My Team</a>
            </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user mr-2"></i>
                    {{ Auth::user()->username }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-header">Welcome!</span>
                  <div class="dropdown-divider"></div>
                  <a href="/staff/profile" class="dropdown-item">
                    <i class="fa fa-user mr-2"></i>
                    <span>My profile</span>
                  </a>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>
                    <span>{{ __('Logout') }}</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
              </li>

          </ul>
          </div>
        </div>
      </nav>
      <!-- /.navbar -->

  @yield('main_content')

   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">ACX Attendance System</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- date-range-picker -->
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>


</body>
</html>
