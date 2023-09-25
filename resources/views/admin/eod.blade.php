@extends('admin.app')
@section('main_content')

<script>
    $('#nav-eod a').toggleClass('active')
</script>
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daily Summary Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Daily Summary</li>
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
                        <div class="col-md-12">
                            <div id="eod-loader" class="overlay" style="display: none">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                            <style>
                                #eod-tbl_wrapper .top, #eod-tbl_wrapper .bottom{
                                    display: flex;
                                    justify-content: space-between;
                                    flex-wrap: wrap;
                                }

                                #eod-tbl_filter label{
                                    display: flex;
                                    flex-wrap: wrap;
                                }

                                #eod-tbl_wrapper > div > div {
                                    display: flex;
                                    flex-wrap: wrap;
                                }

                                #eod-tbl_wrapper > div .form-group {
                                    margin-bottom: 0;
                                }

                            </style>
                            <table id="eod-tbl" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Employee</th>
                                  <th>Date</th>
                                  <th>Goals</th>
                                  <th>Tasks Done</th>
                                  <th>Assessment</th>
                                </tr>
                                </thead>
                                <tbody id="eod-tbl-body">
                                    @foreach ( $attendances as $attendance )
                                        <tr>
                                            <td>{{$attendance->id}}</td>
                                            <td>{{$attendance->user->first_name}} {{$attendance->user->last_name}}</td>
                                            <td>{{ date('d - M Y', strtotime($attendance->time_in) )}}</td>
                                            <td>
                                                <ul>
                                                    @php
                                                        try {
                                                            foreach ( json_decode($attendance->goal_tasks) as $goal ){
                                                                echo '<li>'.$goal.'</li>';
                                                            }
                                                        } catch (\Throwable $th) {
                                                            echo $attendance->goal_tasks;
                                                        }
                                                    @endphp
                                                </ul>
                                            </td>
                                            <td>
                                                    @php
                                                        

                                                            foreach(json_decode($attendance->tasklogs) as $tasklog){
                                                                    echo '<strong>'.$tasklog->project.'</strong>';
                                                                    $tasks = json_decode($tasklog->tasks);
                                                                if(is_array($tasks)){
                                                                    echo "<ul>";
                                                                    foreach($tasks as $task){
                                                                        echo '<li>'.$task.'</li>';
                                                                    }
                                                                    echo '</ul>';
                                                                } else {
                                                                    echo '<li>'.$tasklog->tasks.'</li>';
                                                                }
                                                            }
                                                      
                                                    @endphp
                                            </td>
                                            {{-- <td><button class="btn btn-outline-dark"  onclick="getTaskLogs({{$attendance->id}})">View <span class="ml-2"><i class="fa-solid fa-caret-right"></i></span></button></td> --}}
                                            <td>
                                                <div class="form-group" style="position: relative">
                                                    <textarea class="form-control" rows="3" placeholder="Enter assessment" value="{{$attendance->assessment}}" id="assessment-{{$attendance->id}}">{{$attendance->assessment}}</textarea>
                                                    <input type="hidden" value="{{$attendance->id}}" id="attendance_id-{{$attendance->id}}" />
                                                    <button onClick="updateAssessment({{$attendance->id}})" title="Save" style=" position:absolute; top: 0; right: 0" class="btn btn-outline-success save-btn btn-xs"><i class="fas fa-floppy-disk"></i></button>

                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Goals</th>
                                    <th>Tasks Done</th>
                                    <th>Assessment</th>
                                </tr>
                                </tfoot>
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
    $(function () {


      $('#eod-tbl').DataTable({
        "paging": true,
        "lengthChange": true,
        lengthMenu: [10, 25, 50, 100, 200, 500],
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "buttons" : [
            {
                extend: 'excel',
                text: 'Excel'
            },
            {
                extend: 'pdf',
                text: 'PDF',
                customize: function(doc) {
                    doc.pageSize = 'A4'; // Set the page size to A4
                    doc.pageOrientation = 'landscape'; // Set the page orientation to landscape
                    // You can add more customization options here if needed
                }
            }
        ],
        "dom": '<"top"<"tbl-buttons"B>f>rt<"bottom"lp><"clear">'
      }).buttons().container().appendTo('#eod-tbl_wrapper .col-md-6:eq(0)');

      $('#tasklogs-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true
      })

      $("#eod-tbl_wrapper .tbl-buttons").prepend(  `
                    <!-- Date and time range -->
            <form method="POST" action="{{ route('admin.eod.summary')}}" enctype="multipart/form-data" id='eod-date'>
                @csrf
                <div class="form-group mr-2">
                  <div class="input-group">
                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                      <i class="far fa-calendar-alt"></i><span id="reportrange" class="ml-2 mr-2"> Select Date</span>
                      <i class="fas fa-caret-down"></i>
                    </button>
                    <input type='hidden' name='startdate' id='startdate'>
                    <input type='hidden' name='enddate' id='enddate'>
                  </div>
                </div>
            </form>

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
            $('#startdate').val(start.format('YYYY-MM-DD'));
            $('#enddate').val(end.clone().endOf('day').format('YYYY-MM-DD HH:mm:ss'));

            $('#eod-date').submit();

        });

    });


    /*
        .buttons().container().appendTo('#dtr-tbl_wrapper .col-md-6:eq(0)');
    */
  </script>
  <script>

    function updateAssessment(id){
        // console.log($('#attendance_id').val());
        //  console.log($('#assessment').val());
        $.ajax({
            url: "{{ route('admin.eod.assessment') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: $('#attendance_id-'+id).val(),
                assessment: $('#assessment-'+id).val()
            },
            dataType: "json",
            beforeSend: function(){
                $('#loader').css('display','flex');
            },
            complete: function(){

                $('#loader').css('display','none');
            },
            success: function(data) {
                toastr.success(data.message);
            },
            error: function(xhr, status, error) {
                toastr.error("Something went wrong!");
                console.log(error);

            }
        });
    }

    $(document).ready(function(){
        var start = `<?php
            if(isset($range)){
                echo $range['start'];
            }
        ?>`;
        var end = `<?php
            if(isset($range)){
                echo $range['end'];
            }
        ?>`;
        if(start != ""){
            $('#reportrange').html(moment(start).format('MMMM D, YYYY') + ' - ' + moment(end).format('MMMM D, YYYY'));
        }

    })

  </script>

@endsection
