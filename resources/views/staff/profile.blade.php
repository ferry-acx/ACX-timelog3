

  @extends('staff.app')
  @section('main_content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          {{-- <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> Top Navigation <small>Example 3.0</small></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Layout</a></li>
                <li class="breadcrumb-item active">Top Navigation</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row --> --}}
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container">
          <div class="row  pt-2">
              <div class="col-md-12">
                  <h2 class="mb-2" style="font-weight: 600">My Profile</h2>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">

                  <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                              <!-- Widget: user widget style 2 -->
                            <div class="card card-widget widget-user-2">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-warning">
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="../dist/acx-imgs/user.png" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                                <h5 class="widget-user-desc">{{ Auth::user()->position }}</h5>
                                </div>
                                <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Employee ID <span class="float-right badge bg-primary">{{ Auth::user()->employee_id }}</span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Department <span class="float-right badge bg-info">{{ Auth::user()->division }}</span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Username <span class="float-right badge bg-success">{{ Auth::user()->username }}</span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        Access Level <span class="float-right badge bg-danger">{{ Auth::user()->role }}</span>
                                    </a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <div class="col-md-8">
                            <div class="card card-outline-warning">
                                <div class="card-header">
                                    <strong>Update Login Credentials</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('staff.profile.save') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="username" class="form-control" id="" value="{{ Auth::user()->username }}" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" class="form-control" id="" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-outline-success"><i class="fa-solid fa-floppy-disk mr-2"></i>Save</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                  </div>
                </div>

            </div>
            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
  <script>

      $(function () {

        $('.select2').select2({
            tags: true
        });

        if(@json(session()->all()).updated) {
            toastr.success('Profile has beeen updated successfully!')
        }
        if(@json(session()->all()).not_updated) {
            toastr.error('Error occured while updating profile! Try to use different username.')
        }

    });

  </script>

@endsection
