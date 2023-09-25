@extends('admin.app')
@section('main_content')

    <script>
        $('#nav-dash a').toggleClass('active')
    </script>
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">My Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12">
            <div class="card" style=" min-height: 80vh;">
              <!-- /.card-header -->
              <div class="card-body p-5">
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
                  <!-- /.col -->
                  <div class="col-md-8 pl-3">

                    <div class="card">
                        <div class="card-header p-3 ml-2">
                            <i class="fas fa-circle-info mr-2"></i>
                            <span><strong>Edit Info</strong></span>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="{{ route('admin.profile.save') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{Auth::user()->id}}" name="user_id" required>
                                <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Employee ID</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ Auth::user()->employee_id }}" class="form-control" name="emp_id" placeholder="Employee ID" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fname" value="{{ Auth::user()->first_name }}" placeholder="First Name" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label" >Last Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="lname" value="{{ Auth::user()->last_name }}" placeholder="Last Name" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Department</label>
                                <div class="col-sm-10">

                                    <select class="form-control select2 " name="department" id="emp_department" style="width: 100%;" required>
                                        <option value="core"  @php if(Auth::user()->division=='core'){ echo 'selected'; } @endphp>ACX Core</option>
                                        <option value="publishing" @php if(Auth::user()->division=='publishing'){ echo 'selected'; } @endphp>Publishing</option>
                                        <option value="relevate" @php if(Auth::user()->division=='relevate'){ echo 'selected'; } @endphp>Relevate</option>
                                        @if(Auth::user()->division != 'relevate' && Auth::user()->division != 'core' && Auth::user()->division != 'publishing' )
                                        <option value="{{Auth::user()->division}}" selected >{{Auth::user()->division}}</option>
                                        @endif
                                    </select>

                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Position</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" name="position" id="emp_position" style="width: 100%;" required>

                                        @foreach( $positions as $position )
                                            <option value="{{$position->position}}" @php if(Auth::user()->position==$position->position){ echo 'selected'; } @endphp >{{$position->position}}</option>
                                        @endforeach
                                  </select>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 col-form-label">Access Level</label>
                                    <div class="col-sm-10 p-6">
                                       <div style="width: 100%; border: 1px solid #ced4da; display: flex; align-items: center; justify-content: space-between; padding: 10px;"><span>Admin</span><small class="float-right">Use another admin account to change role</small></div>
                                    </div>
                                </div>
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
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      </div><!--/. container-fluid -->
    </section>
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
            toastr.error('Error occured while updating profile! Make sure that employee ID and username are unique.')
        }

    });

  </script>

@endsection
