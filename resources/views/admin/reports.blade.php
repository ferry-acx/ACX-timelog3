@extends('admin.app')
@section('main_content')

<script>
    $('#nav-hrs a').toggleClass('active')
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hours Rendered</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Hours Rendered</li>
          </ol>
      </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid p-2">


    <div class="row">
        <div class="col-md-7">
            <style>
                #attendances-tbl_wrapper .top, #attendances-tbl_wrapper .bottom{
                    display: flex;
                    justify-content: space-between;
                    flex-wrap: wrap;
                }

                #attendances-tbl_filter label{
                    display: flex;
                    flex-wrap: wrap;
                }

                #attendances-tbl_wrapper > div > div {
                    display: flex;
                    flex-wrap: wrap;
                }

                #attendances-tbl_wrapper > div .form-group {
                    margin-bottom: 0;
                }
            </style>
            <div class="card ">

              <div class="card-body">
                <div id="attendances-loader" class="overlay" style="display: none">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <table id="attendances-tbl" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th>#</th>
                          <th>Employee</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>Shift Duration</th>
                          <th>Total Break</th>
                          <th>Time Rendered</th>

                      </tr>
                  </thead>
                  <tbody id="eod-tbl-body">
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
                        <td>{{$attendance->user->first_name}} {{$attendance->user->last_name}}</td>
                        <td>{{ date('d - M Y', strtotime($attendance->time_in) )}} &nbsp; <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($attendance->time_in)) }}</span></td>
                        <td>{{ date('d - M Y', strtotime($attendance->time_out) )}} &nbsp; <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($attendance->time_out)) }}</span></td>
                        <td>{{$hours}}&nbsp;hrs :&nbsp;{{$mins}}&nbsp;mins</td>
                        <td>{{floor($breakMinutes / 60)}}&nbsp;hrs :&nbsp;{{ floor($breakMinutes % 60 ) }}&nbsp;mins</td>
                        <td><span class=" badge bg-warning text-md">{{floor($totalMinutesForDate / 60)}}&nbsp;hrs :&nbsp;{{ floor($totalMinutesForDate % 60 ) }}&nbsp;mins</span></td>
                    </tr>
                    @endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Shift Duration</th>
                            <th>Total Break</th>
                            <th>Time Rendered</th>
                        </tr>
                    </tfoot>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
    </div>
    <div class="col-md-5">

        <div class="card ">
            <div class="card-header">
              <h3 class="card-title"><strong>Check by Employee</strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <div id="loader" class="overlay" style="display: none">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <div class="row">
                <div class="form-group" style="width: 100%">
                    <div class="input-group mb-2">
                      <select id="employee_selector" class="form-control select2" style="width: 100%;">
                        <option value="" disabled selected="selected">Select Employee</option>

                            @foreach( $users as $user )
                                <option value="{{$user->id}}">{{$user->first_name}}&nbsp;{{$user->last_name}}</option>
                            @endforeach
                      </select>
                    </div>
                    <div class="input-group mb-2">
                        <button type="button" class="btn btn-default float-right" id="emp-daterange-btn" style="width: 100%; text-align: left;">
                            <i class="far fa-calendar-alt"></i><span id="emp-reportrange" class="ml-2 mr-2"> Select Date</span>
                            <i class="fas fa-caret-down float-right"></i>
                        </button>
                        <input type="hidden" class="hidden" id="start-date" name="">
                        <input type="hidden" class="hidden" id="end-date" name="">
                    </div>
                    <div class="input-group mb-2">
                        <button type="button"  id="submit-btn" onclick="getTime()" class="btn btn-outline-info" id="emp-daterange-btn">
                            <i class="far"></i><span class="ml-2 mr-2"> CHECK</span>
                        </button>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-stopwatch"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-number text-xl" id="time-rendered" style="text-align: center;"> -- <small>HRS</small> : -- <small>MINS</small> </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </div>
            </div>
          </div>
          <!-- /.card-body -->
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
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script>

    $(function (){

        $('#employee_selector').select2({
          theme: 'bootstrap4'
        })

        $('#attendances-tbl').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            order :[[0,'desc']],
            "info": false,
            "autoWidth": false,
            "responsive": true,
            'buttons': ["excel", "pdf"]
        }).buttons().container().appendTo('#attendances-tbl_wrapper .col-md-6:eq(0)');

        $("#attendances-tbl_wrapper .col-md-6:eq(0)").prepend(  `
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
                url: "{{ route('admin.reports.daterange') }}",
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
                    $('#attendances-loader').css('display','flex');
                },
                complete: function(){

                    $('#attendances-loader').css('display','none');
                },
                success: function(data) {

                    const attendance = data.attendances;
                    var eod_tbl = $('#attendances-tbl').DataTable();
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
                        `${log.name }` ,
                        `${start.format('DD - MMM YYYY')}&nbsp;<span class=" badge bg-info text-md">${start.format('h:mm A')}</span>`,
                        `${end.format('DD - MMM YYYY')}&nbsp;<span class=" badge bg-info text-md">${end.format('h:mm A')}</span>`,
                        `${rendered.hours()+' hrs : '+rendered.minutes()+' mins '}`,
                        `${totbreak}`,
                        `<span class=" badge bg-warning text-md">${net}</span>`
                        ]).draw();
                } );

            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });

    });

        $('#emp-daterange-btn').daterangepicker({
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
                $('#emp-reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                // console.log(start.format('YYYY-MM-DD'));
                 //console.log(moment(end).clone().endOf('day').format('YYYY-MM-DD HH:mm:ss'));

                $('#start-date').val(start.format('YYYY-MM-DD'));
                $('#end-date').val(moment(end).clone().endOf('day').format('YYYY-MM-DD HH:mm:ss'));

        });

    });

        function getTime(){


            if($('#employee_selector').val()==="" || $('#employee_selector').val()=== null){
                toastr.error('Please select employee!')
            } else{

                $.ajax({
                    url: "{{ route('admin.reports.hoursbyemployee') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: $('#employee_selector').val(),
                        startdate: $("#start-date").val(),
                        enddate: $("#end-date").val()
                    },
                    dataType: "json",
                    beforeSend: function(){
                        $('#loader').css('display','flex');
                    },
                    complete: function(){

                        $('#loader').css('display','none');
                    },
                    success: function(data) {

                        console.log(data)


                        const attendances = data.attendances;
                        let hours = 0;
                        let mins =0;

                        attendances.forEach( date => {
                            const start = new Date(date.time_in);
                            const end = new Date(date.time_out);

                            const diff = end - start;

                            hours += Math.floor(diff / (1000 * 60 * 60));
                            mins += Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
                        } );

                        if(data.breaks.length != 0 ){
                             const breaks = data.breaks;
                            let breakmins =0;

                            breaks.forEach( break_log => {
                                const break_start = new Date(break_log.break_start);
                                const break_end = new Date(break_log.break_end);

                                const break_diff = break_end - break_start;

                                breakmins += Math.floor(break_diff / (1000 * 60 ));
                            } );


                            // console.log(hours);
                            // console.log(mins);
                            // console.log(breakmins);

                            mins -= breakmins;

                        }

                        if(mins<0){
                            hours -= 1;
                            mins += 60;
                        }

                        hours += Math.floor(mins / 60);
                        mins %= 60;

                        $('#time-rendered').html(hours+' <small>HRS</small> : '+mins+' <small>MINS</Small> ');

                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching real-time data:", error);
                    }
                });
            }

        }

</script>

@endsection
