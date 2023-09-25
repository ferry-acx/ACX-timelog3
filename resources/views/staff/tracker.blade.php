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

        <div id="page-loader" class="overlay" style="display: none">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <div class="row  pt-2">
            <div class="col-md-12">
                <h2 class="mb-2" style="font-weight: 600">Tracker Logs</h2>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">

                <div class="card">
                <div class="card-body">
                    <div id="table-loader" class="overlay" style="display: none">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <table id="prevlogs-tbl" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>Shift Duration</th>
                          <th>Break</th>
                          <th>Time Rendered</th>
                          <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ( $attendances as $attendance )

                            @php

                            $start = new DateTime($attendance->time_in);
                            $end = new DateTime($attendance->time_out);

                            $interval = $start->diff($end);
                            $hours = $interval->days * 24 + $interval->h;
                            $mins = $interval->i;

                            $breakMinutes = 0;
                            foreach ($attendance->breaklogs as $break) {
                                $breakStart = new DateTime($break->break_start);
                                $breakEnd = new DateTime($break->break_end);
                                $breakInterval = $breakStart->diff($breakEnd);
                                $breakMinutes += ($breakInterval->days * 24 * 60) + ($breakInterval->h * 60) + $breakInterval->i;
                            }
                            // Subtract break time from the interval
                            $totalMinutesForDate = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i - $breakMinutes;
                        @endphp

                                <tr>
                                    <td>{{$attendance->id}}</td>
                                    <td>{{ date('d - M Y', strtotime($attendance->time_in) )}} &nbsp; <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($attendance->time_in)) }}</span></td>
                                    <td>{{ date('d - M Y', strtotime($attendance->time_out) )}} &nbsp; <span class=" badge bg-danger text-md">{{ date('h:i A', strtotime($attendance->time_out)) }}</span></td>
                                    <td>{{$hours}}&nbsp;hrs :&nbsp;{{$mins}}&nbsp;mins</td>
                                    <td>{{floor($breakMinutes / 60)}}&nbsp;hrs :&nbsp;{{ floor($breakMinutes % 60 ) }}&nbsp;mins</td>
                                    <td><span class=" badge bg-warning text-md">{{floor($totalMinutesForDate / 60)}}&nbsp;hrs :&nbsp;{{ floor($totalMinutesForDate % 60 ) }}&nbsp;mins</span></td>
                                    <td><button class="btn btn-outline-dark" onclick="viewInfo({{$attendance->id}})">View <span class="ml-2"><i class="fa-solid fa-caret-right"></i></span></button></td>
                                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Shift Duration</th>
                              <th>Break</th>
                              <th>Time Rendered</th>
                              <th>Details</th>
                            </tr>
                        </tfoot>
                      </table>
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

  <div class="modal fade" id="logInfo">
    <div class="modal-dialog modal-lg  modal-dialog-centered modal-dialog-zoom">
      <div class="modal-content" style="">
        <div class="modal-body">
          <div class="card" style="box-shadow: none !important; margin-bottom:0 !important">
            <div class="card-header border-0" >
              <h3 style="display: inline !important">Log Info</h3 >
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="float-right" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Date</strong> <span class="badge bg-success text-md ml-3" id="date"></span>
                    </div>

                    <div class="col-md-6">
                        <strong>Location</strong> <span class="badge bg-warning text-md ml-3" id="location"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <strong>Goals Set</strong>
                        <p id="goals">

                        </p>

                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tasklogs-tbl" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                            <th>Projects</th>
                            <th>Tasks Done</th>
                            </tr>
                            </thead>
                            <tbody id="logs">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <strong>Break Logs</strong>
                        <table id="breaklogs-tbl" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                            <th>Break Start</th>
                            <th>Break End</th>
                            </tr>
                            </thead>
                            <tbody id="">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <strong>Assessment</strong>
                        <p id="assessment">

                        </p>
                    </div>
                </div>
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
  <script src="../plugins/moment/moment.min.js"></script>
  <!-- Select2 -->
  <script src="../plugins/select2/js/select2.full.min.js"></script>
  <script>

function viewInfo(id){

    $.ajax({
        url: "{{ route('staff.tracker.getinfo') }}",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            attendance_id: id
        },
        dataType: "json",
        beforeSend: function(){
            $('#page-loader').css('display','flex');
        },
        complete: function(){

            $('#page-loader').css('display','none');
        },
        success: function(data) {

            const attendance = data.attendances;
            const breaklogs = data.breaklogs;
            const tasklogs = data.tasklogs;

            //console.log(attendance);

            $('#date').text(moment(attendance.time_in).format('D - MMM YYYY'));
            $('#location').text(attendance.location);

            if(attendance.assessment === null){
                $('#assessment').html("<span class='badge bg-danger'>Not yet evaluated!</span>");
            } else {
                $('#assessment').text(attendance.assessment);
            }

            try{

                let goal_text = '<ul>';
                var goals = JSON.parse(attendance.goal_tasks);
                goals.forEach(function(item) {
                    goal_text += `<li>${item}</li>`
                });

                goal_text += '</ul>';
                $('#goals').html(goal_text);
            } catch (error) {

                $('#goals').text(attendance.goal_tasks);
            }


            var tasklogs_tbl = $('#tasklogs-tbl').DataTable();
            tasklogs_tbl.clear().draw();
                tasklogs.forEach( log => {

                let task_list = '';
                        try{
                         task_list = '<ul>';
                            var tasks = JSON.parse(log.tasks);
                                tasks.forEach(function(item) {
                                    task_list += `<li>${item}</li>`
                            });

                            task_list += '</ul>';

                        } catch (error) {
                            task_list = log.tasks;
                        }


                    tasklogs_tbl.row.add([
                        `${log.project}`,
                        `${task_list}`
                    ]).draw();

                } );

            var breaklogs_tbl = $('#breaklogs-tbl').DataTable();
            breaklogs_tbl.clear().draw();
                breaklogs.forEach( log => {

                    breaklogs_tbl.row.add([
                        `${moment(log.break_start).format('h:mm A')}`,
                        `${moment(log.break_end).format('h:mm A')}`
                    ]).draw();
                } );

                 $('#logInfo').modal().show();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });

}

$('#prevlogs-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true
      });

      $('#breaklogs-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        pageLength: 5,
        "autoWidth": false,
        "responsive": true
      });

      $('#tasklogs-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        pageLength: 3,
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true
      });
</script>

<script>

    $(function (){


        $("#prevlogs-tbl_wrapper .col-md-6:eq(0)").prepend(  `
            <!-- Date and time range -->
            <div class="form-group mr-2">
            <div class="input-group">
            <button type="button" class="btn btn-default float-right" id="daterange-btn">
            <i class="far fa-calendar-alt"></i><span id="reportrange" class="ml-2 mr-2"> Select Date</span>
            <i class="fas fa-caret-down"></i>
            </button>
            </div>
            </div>
            `);

        $('#daterange-btn').daterangepicker({
            ranges   : {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
        },
        function (start, end) {
            $('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // console.log(start.format('YYYY-MM-DD'));
            // console.log(end.format('YYYY-MM-DD'));

            $.ajax({
                url: "{{ route('staff.tracker.daterange') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    startdate: start.format('YYYY-MM-DD'),
                    enddate: end.clone().endOf('day').format('YYYY-MM-DD HH:mm:ss')
                },
                dataType: "json",
                beforeSend: function(){
                    $('#table-loader').css('display','flex');
                },
                complete: function(){

                    $('#table-loader').css('display','none');
                },
                success: function(data) {

                    const attendance = data.attendances;
                    var eod_tbl = $('#prevlogs-tbl').DataTable();
                    eod_tbl.clear().draw();
                //console.log(attendance);

                attendance.forEach( log => {

                    //console.log(log);

                    const start = moment(log.time_in);
                    const end = moment(log.time_out);
                    const rendered = moment(log.rendered,"HH:mm");
                    var totbreak = '';
                    var net = '';

                    if(log.total_break === null || log.total_break === ""){
                        totbreak = '0 hrs : 0 mins';
                        net = rendered.hours()+' hrs : '+rendered.minutes()+' mins ';
                    } else{
                        totbreak = moment(log.total_break, "HH:mm").hours()+' hrs : '+moment(log.total_break,"HH:mm").minutes()+' mins ';
                        net = moment(log.net_time,"HH:mm").hours()+' hrs : '+moment(log.net_time,"HH:mm").minutes()+' mins ';

                    }

                    eod_tbl.row.add([
                        log.id,
                        `${start.format('DD - MMM YYYY')}&nbsp;<span class=" badge bg-info text-md">${start.format('h:mm A')}</span>`,
                        `${end.format('DD - MMM YYYY')}&nbsp;<span class=" badge bg-info text-md">${end.format('h:mm A')}</span>`,
                        `${rendered.hours()+' hrs : '+rendered.minutes()+' mins '}`,
                        `${totbreak}`,
                        `<span class=" badge bg-warning text-md">${net}</span>`,
                        `<button class="btn btn-outline-dark" onclick="viewInfo(${log.id})">View <span class="ml-2"><i class="fa-solid fa-caret-right"></i></span></button>`
                        ]).draw();
                } );

            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });

    });
});

</script>

@endsection
