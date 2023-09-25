@extends('admin.app')
@section('main_content')

<script>
    $('#nav-timelog a').toggleClass('active')
</script>
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Timelogs</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Timelogs</li>
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
              <div class="card card-tabs">
                <div class="card-header p-0 pt-1">

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">

                  <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="current-logs" data-toggle="pill" href="#current-logs-panel" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Current Logs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="previous-logs" data-toggle="pill" href="#previous-logs-panel" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Previous Logs</a>
                    </li>
                  </ul>
                  <br>
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="current-logs-panel" role="tabpanel" aria-labelledby="current-logs">

                                    <style>
                                        #timelogs-tbl_wrapper .top, #timelogs-tbl_wrapper .bottom{
                                            display: flex;
                                            justify-content: space-between;
                                            flex-wrap: wrap;
                                        }
                                    </style>

                                <table id="timelogs-tbl" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Employee</th>
                                      <th>Department</th>
                                      <th>Position</th>
                                      <th>Time In</th>
                                      <th>Location</th>
                                      <th>Status</th>
                                      <th>Break Log</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $current_attendances as $attendance )
                                            <tr>
                                                <td>{{$attendance->id}}</td>
                                                <td>{{$attendance->user->first_name}} {{$attendance->user->last_name}}</td>
                                                <td style=" text-transform: capitalize;">


                                                    @if($attendance->user->division=='core')
                                                        <span class=" badge bg-danger">Core</span>
                                                    @elseif ($attendance->user->division=='publishing')
                                                        <span class=" badge bg-success">Publishing</span>
                                                    @elseif ($attendance->user->division=='relevate')
                                                        <span class=" badge bg-warning">Relevate</span>
                                                    @else
                                                        <span class=" badge bg-info">{{ $attendance->user->division }}</span>
                                                    @endif

                                                </td>
                                                <td>{{$attendance->user->position}}</td>
                                                <td>{{ date('d - M Y', strtotime($attendance->time_in) )}} <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($attendance->time_in)) }}</span></td>
                                                <td>{{$attendance->location}}</td>
                                                <td style=" text-transform: capitalize;">
                                                    @if($attendance->status=='online')
                                                        <span class=" badge bg-success">Online</span>
                                                    @elseif ($attendance->status=='break')
                                                        <span class=" badge bg-danger">Break</span>
                                                    @else
                                                        <span class=" badge bg-info">{{$attendance->status}}</span>
                                                    @endif
                                                </td>
                                                <td><button class="btn btn-outline-dark" onclick="getBreakLogs({{$attendance->id}})">View <span class="ml-2"><i class="fa-solid fa-caret-right"></i></span></button></td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Time In</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Break Log</th>
                                    </tr>
                                    </tfoot>
                                  </table>

                                </div>
                                <div class="tab-pane fade" id="previous-logs-panel" role="tabpanel" aria-labelledby="previous-logs" style="overflow-x: scroll;">

                                    <style>
                                        #prevlogs-tbl_wrapper .top, #prevlogs-tbl_wrapper .bottom{
                                            display: flex;
                                            justify-content: space-between;
                                            flex-wrap: wrap;
                                        }
                                    </style>

                                <table id="prevlogs-tbl" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                      <th>Employee</th>
                                      <th>Department</th>
                                      <th>Position</th>
                                      <th>Time In</th>
                                      <th>Time Out</th>
                                      <th>Location</th>
                                      <th>Break Log</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $previous_timelogs as $attendance )
                                            <tr>
                                                <td>{{$attendance->id}}</td>
                                                <td>{{$attendance->user->first_name}} {{$attendance->user->last_name}}</td>
                                                <td style=" text-transform: capitalize;">


                                                    @if($attendance->user->division=='core')
                                                        <span class=" badge bg-danger">Core</span>
                                                    @elseif ($attendance->user->division=='publishing')
                                                        <span class=" badge bg-success">Publishing</span>
                                                    @elseif ($attendance->user->division=='relevate')
                                                        <span class=" badge bg-warning">Relevate</span>
                                                    @else
                                                        <span class=" badge bg-info">{{ $attendance->user->division }}</span>
                                                    @endif

                                                </td>
                                                <td>{{$attendance->user->position}}</td>
                                                <td>{{ date('Y-m-d', strtotime($attendance->time_in) )}} <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($attendance->time_in)) }}</span></td>
                                                <td>{{ date('Y-m-d', strtotime($attendance->time_out) )}} <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($attendance->time_out)) }}</span></td>
                                                <td>{{$attendance->location}}</td>
                                                <td><button class="btn btn-outline-dark" onclick="getBreakLogs({{$attendance->id}})">View <span class="ml-2"><i class="fa-solid fa-caret-right"></i></span></button></td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Location</th>
                                        <th>Break Log</th>
                                    </tr>
                                    </tfoot>
                                  </table>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-4" id="break-log-col">
                            <div id="loader" class="overlay" style="display: none">
                                <i class="fas fa-spinner fa-spin"></i>
                              </div>
                            <strong>Break Logs</strong>
                            <hr>
                            <style>
                                #breaklog-tbl_wrapper .top, #breaklog-tbl_wrapper .bottom{
                                    display: flex;
                                    justify-content: space-around;
                                    flex-wrap: wrap;
                                }
                            </style>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Employee Name</td>
                                    <td><span class="float-right badge text-md" id="name">Name</span></td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td><span class="float-right badge  text-md" id="department">Department</span></td>
                                </tr>
                                <tr>
                                    <td>Position</td>
                                    <td><span class="float-right badge  text-md" id="position">Position</span></td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td><span class="float-right badge  text-md" id="date">Date</span></td>
                                </tr>
                                <tr>
                                    <td>Location</td>
                                    <td><span class="float-right badge text-md" id="location">Location</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <table id="breaklog-tbl" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Break Start</th>
                              <th>Break End</th>
                            </tr>
                            </thead>
                            <tbody id="logs">

                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
              </div>
            </div>
        </div>


      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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

<script src="../plugins/moment/moment.min.js"></script>
  <script>

    $(function (){

        $('#breaklog-tbl').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "dom": '<"top">rt<"bottom"ilp><"clear">'
      });

      $('#timelogs-tbl').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "buttons": [ "excel", "pdf"],
        "dom": '<"top"Bf>rt<"bottom"lp><"clear">'
      }).buttons().container().appendTo('#timelogs-tbl_wrapper .col-md-6:eq(0)');

      $('#prevlogs-tbl').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "buttons": [ "excel", "pdf"],
        "dom": '<"top"Bf>rt<"bottom"lp><"clear">'
      }).buttons().container().appendTo('#prevlogs-tbl_wrapper .col-md-6:eq(0)');


    });

    function updateViewWithData(data) {
        const user_info = data.user_info;
        const breaklogs = data.breaklogs;
        const attendance = data.attendance;

        const date = moment(attendance.time_in);

        $('#name').text(user_info.first_name+' '+user_info.last_name);
        $('#department').text(user_info.division);
        $('#position').text(user_info.position);
        $('#date').text(date.format('DD - MMM YYYY'));
        $('#location').text(attendance.location);

        // let records = '';

        // breaklogs.forEach( log => {
        //     records+=`
        //         <tr>
        //             <td>${moment(log.break_start).format('h:mm A')}</td>
        //             <td>${moment(log.break_end).format('h:mm A')}</td>
        //         </tr>
        //     `;
        // } );

        // $('#logs').html(records);
        var logs = $('#breaklog-tbl').DataTable();
            logs.clear().draw();
                //console.log(attendance);

        breaklogs.forEach( log => {

            logs.row.add([
                `${moment(log.break_start).format('h:mm A')}`,
                `${moment(log.break_end).format('h:mm A')}`
            ]).draw();
        } );

    }

    function getBreakLogs(id){
        $.ajax({
            url: "/admin/timelogs/breaklogs/"+id,
            type: "GET",
            dataType: "json",
            beforeSend: function(){
                $('#loader').css('display','flex');
            },
            complete: function(){

                $('#loader').css('display','none');
            },
            success: function(data) {
                updateViewWithData(data);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });
    }

  </script>

@endsection
