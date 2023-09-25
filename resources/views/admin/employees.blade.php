@extends('admin.app')
@section('main_content')

    <script>
        $('#nav-emp a').toggleClass('active')
    </script>
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Employees</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Employees</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!--< div class="card-header">
                <h5 class="card-title">Employees</h5>
                <div class="card-tools">

                  </div>

              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">


                <table id="employee-tbl" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Department</th>
                      <th>Position</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $users as $user )
                            <tr>
                                <td>{{$user->employee_id}}</td>
                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                <td>{{$user->username}}</td>
                                <td style=" text-transform: capitalize;">


                                    @if($user->division=='core')
                                        <span class=" badge bg-danger">Core</span>
                                    @elseif ($user->division=='publishing')
                                        <span class=" badge bg-success">Publishing</span>
                                    @elseif ($user->division=='relevate')
                                        <span class=" badge bg-warning">Relevate</span>
                                    @else
                                        <span class=" badge bg-info">{{ $user->division }}</span>
                                    @endif

                                </td>
                                <td>{{$user->position}}</td>
                                <td>
                                    @if( $user->id == Auth::user()->id)
                                        <span class="badge bg-success text-lg" >IT'S ME!</span>
                                    @else

                                        <button class="btn btn-warning mr-2" onclick="editEmployee({{$user->id}})" ><i class="fas fa-user-pen mr-2"></i>Edit</button>
                                        <button class="btn btn-info mr-2" onclick="resetLogin({{$user->id}})" ><i class="fa-solid fa-clock-rotate-left mr-2"></i>Reset Password</button>
                                        @if($user->attendances->count()==0)
                                            <button class="btn btn-danger mr-2" onclick="deleteEmployee({{$user->id}})" ><i class="fas fa-trash"></i>Delete</button>
                                        @else
                                            <button class="btn btn-danger disabled mr-2" ><i class="fas fa-trash mr-2"></i>Delete</button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Username</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>

                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">

              </div>
              <!-- /.card-footer -->
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

  <!--------------------- MODALS ---------------------------->

  <div class="modal fade" id="addEmployee">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
    <div class="modal-content" style="">
      <div class="modal-body">
        <div class="card" style="box-shadow: none !important; margin-bottom:0 !important">
          <div class="card-header border-0" >
            <h3 style="display: inline !important">Employee Info</h3 >
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="float-right" aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.employees.addemployee') }}" enctype="multipart/form-data">
            @csrf
              <div class="form-row">
                <div class="col-md-12">
                  <label>Employee ID</label>
                  <input type="text" name="emp_id" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>First Name</label>
                  <input type="text" name="emp_fname" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Last Name</label>
                  <input type="text" name="emp_lname" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Department</label>
                  <select id="" class="form-control select2 " required name="emp_department" style="width: 100%;">
                    <option value="" disabled selected="selected">Select Department</option>
                    <option value="core">ACX Core</option>
                    <option value="publishing">Publishing</option>
                    <option value="relevate">Relevate</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Position</label>
                  <select id="" class="form-control select2" required name="emp_position" style="width: 100%;">
                    <option value="" disabled selected="selected">Select Position</option>

                        @foreach( $positions as $position )
                            <option value="{{$position->position}}">{{$position->position}}</option>
                        @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Access Level</label>
                  <select id="" class="form-control  " required name="emp_role" style="width: 100%;">
                    <option selected value="2">Staff Member</option>
                    <option value="3">Project Coordinator</option>
                    <option value="1">Admin</option>
                  </select>
                </div>
              </div>
              <br>

              <div class="form-row">
                <div class="col-md-6">
                  <input type="submit" name="addEmployee" value="Add Employee" class="btn btn-success">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

 <div class="modal fade" id="editEmployee">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom">
    <div class="modal-content" style="">
      <div class="modal-body">
        <div class="card" style="box-shadow: none !important; margin-bottom:0 !important">
          <div class="card-header border-0" >
            <h3 style="display: inline !important">Employee Info</h3 >
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="float-right" aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card-body">
            <form method="POST" id="editEmployeeForm" action="{{ route('admin.employees.editemployee') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" id="user_id">
              <div class="form-row">
                <div class="col-md-12">
                  <label>Employee ID</label>
                  <input type="text" name="emp_id" id="emp_id" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>First Name</label>
                  <input type="text" name="emp_fname" id="emp_fname" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Last Name</label>
                  <input type="text" name="emp_lname" id="emp_lname" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Department</label>
                  <select class="form-control select2 " name="emp_department" id="emp_department" style="width: 100%;" required>
                    <option value="core">ACX Core</option>
                    <option value="publishing">Publishing</option>
                    <option value="relevate">Relevate</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Position</label>
                  <select class="form-control select2" name="emp_position" id="emp_position" style="width: 100%;" required>

                        @foreach( $positions as $position )
                            <option value="{{$position->position}}">{{$position->position}}</option>
                        @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <label>Access Level</label>
                  <select class="form-control  " name="emp_role" id="emp_role" style="width: 100%;" required>
                    <option value="1">Admin</option>
                    <option value="2">Staff Member</option>
                    <option value="3">Project Coordinator</option>
                  </select>
                </div>
              </div>
              <br>

              <div class="form-row">
                <div class="col-md-6">
                  <input type="submit" name="editEmployee"  value="Save" class="btn btn-success" value=""> <!-- onclick="saveEditEmployee()" -->
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>

  <script>

    function saveEditEmployee(){

      var formData = $('#editEmployeeForm').serialize();

      $.ajax({
            url: "{{ route('admin.employees.editemployee') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            beforeSend: function(){
                $('#page-loader').css('display','flex');
            },
            complete: function(){

                $('#page-loader').css('display','none');
            },
            success: function(data) {

                // if(data.message === 'success'){
                //   toastr.success('Employee saved successfully!');
                // } else{
                //   toastr.error('Something went wrong!');
                // }

                // location.reload();
                // //$('#editEmployee').modal().hide();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });
    }

    function addEmployee(){

      $('#addEmployee').modal().show();
    }

    function resetLogin(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset password!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.employees.resetlogin') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: id
                    },
                    beforeSend: function(){
                        $('#page-loader').css('display','flex');
                    },
                    complete: function(){
                        $('#page-loader').css('display','none');
                    },
                    success: function(data) {

                        if(data.message === 'success'){
                            toastr.success('Employee login credentials has been set to default!');
                        } else{
                            toastr.error('Something went wrong!');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("Error", error);
                    }
                });
            }
        })
    }

    function deleteEmployee(id){

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.employees.deleteemployee') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: id
                    },
                    beforeSend: function(){
                        $('#page-loader').css('display','flex');
                    },
                    complete: function(){
                        $('#page-loader').css('display','none');
                    },
                    success: function(data) {

                        if(data.message === 'deleted'){
                            toastr.success('Employee deleted successfully!');
                        } else{
                            toastr.error('Something went wrong!');
                        }

                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error", error);
                    }
                });
            }
        })

    }

    function editEmployee(id){

       $.ajax({
            url: "{{ route('admin.employees.getemployee') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: id
            },
            dataType: "json",
            beforeSend: function(){
                $('#page-loader').css('display','flex');
            },
            complete: function(){

                $('#page-loader').css('display','none');
            },
            success: function(data) {

                //console.log(data);
                const user = data.user;

                $('#user_id').val(id);
                $('#emp_id').val(user.employee_id);
                $('#emp_fname').val(user.first_name);
                $('#emp_lname').val(user.last_name);

                var depts = ['core','relevate', 'publishing']
                if(depts.indexOf(user.division) === -1){
                    $('#editEmployee #emp_department').append(`<option value="${user.division}">${user.division}</option>`);
                }
                $('#editEmployee #emp_department').val(user.division).change();
                $('#editEmployee #emp_position').val(user.position).change();
                $('#editEmployee #emp_role').val(user.role).change();

                $('#editEmployee').modal().show();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });

    }

     $(function () {

        if(@json(session()->all()).updated) {
            toastr.success('Employee has beeen updated successfully!')
        }

        if(@json(session()->all()).added) {
            toastr.success('Employee has beeen added successfully!')
        }


        if(@json(session()->all()).not_updated) {
            toastr.error('Error occured while updating info! Make sure that employee ID is unique.')
        }

        if(@json(session()->all()).not_added) {
            toastr.error('Error occured while adding employee! Make sure that employee ID is unique.')
        }


      $('.select2').select2({
        tags: true
      });

      $('#employee-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ['excel','pdf']
      }).buttons().container().appendTo('#employee-tbl_wrapper .col-md-6:eq(0)');

      $("#employee-tbl_wrapper .col-md-6:eq(0)").prepend(  `

            <button type="button" onClick="addEmployee()" class="btn btn-outline-success" id="">
            <i class="fas fa-user-plus"></i><span id="" class="ml-2 mr-2"> Add Employee</span>
            </button>

      `);

    });

</script>

@endsection
