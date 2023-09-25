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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul><!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!--
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" id="fullscreen-btn" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      -->
      <li class="nav-item mr-3">
        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user mr-2"></i>
          {{ Auth::user()->username }}
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right mr-3">
          <div class=" dropdown-header noti-title">
            <h6 class="text-overflow m-0" style="text-align: left;">Welcome!</h6>
          </div>
          <a href="/admin/profile" class="dropdown-item">
            <i class="fa fa-user mr-2"></i>
            <span>My Profile</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
          class="dropdown-item">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>
            <span>{{ __('Logout') }}</span>
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../dist/acx-imgs/fav.png" alt="ACX Logo" class="brand-image img-circle elevation-0" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>ACX </b>Timelog</span>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img id="sidebar-img" src="../dist/acx-imgs/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Welcome, {{ Auth::user()->username }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
    -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item mt-2" id="nav-dash">
            <a href="/admin" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class=""></i>
              </p>
            </a>
          </li>
          <li class="nav-header">REPORTS</li>
          <li class="nav-item mt-2 " id="nav-timelog">
            <a href="/admin/timelogs" class="nav-link ">
              <i class="nav-icon fas fa-file-pen"></i>
              <p>
                Timelogs
                <i class=""></i>
              </p>
            </a>
          </li>
          <li class="nav-item mt-2" id="nav-eod">
            <a href="/admin/eod" class="nav-link">
              <i class="nav-icon fas fa-calendar-day"></i>
              <p>
                Daily Summary
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          {{-- <li class="nav-item mt-2" id="nav-tasks">
            <a href="/admin/tasks" class="nav-link">
              <i class="nav-icon fa-solid fa-list-check"></i>
              <p>
                Tasks Summary
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li> --}}
          <li class="nav-item mt-2" id="nav-hrs">
            <a href="/admin/reports" class="nav-link">
              <i class="nav-icon fas fa-clock"></i>
              <p>
                Hours Rendered
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-header">USER MANAGEMENT</li>
          <li class="nav-item mt-2" id="nav-emp">
            <a href="/admin/employees" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Employees
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-header">SETTINGS</li>
          <li class="nav-item mt-2" id="nav-conf">
            <a href="/admin/config" class="nav-link">
              <i class="nav-icon fas fa-gears"></i>
              <p>
                Configuration
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
