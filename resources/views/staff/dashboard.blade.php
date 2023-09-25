@extends('staff.app')
@section('main_content')


<style>
    .select2-selection--multiple .select2-selection__choice {
        display: block !important;
        width: 100% !important;
    }
    .select2-search--inline{
        width: 100% !important
    }
    #table-div{
        overflow-x: auto
    }
</style>
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
        <div class="row  pt-5">
            <div class="col-md-12">
                <h1 class="mb-5" style="font-weight: 700">Hello, {{Auth::user()->username}}!</h1>
            </div>
        </div>

        @if(is_null($attendance))

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" >
                            <div class="info-box ">
                                <span class="info-box-icon bg-warning"><i class="fas fa-stopwatch"></i></span>

                                <div class="info-box-content">
                                  <span class="info-box-number text-xl text-center" id="counter">-- <small class="text-xs">HRS</small> -- <small class="text-xs">MIN</small> -- <small class="text-xs">SEC</small> </span>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                        </div>
                    <div class="card-body">

                    <div id="" class="overlay timein-loader" style="display: none">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                        <style>
                             #location-switch label{
                                opacity: .5
                            }

                            #location-switch label.active{
                                opacity: 1
                            }
                        </style>
                      <form method="POST" action="{{ route('staff.timein') }}" enctype="multipart/form-data">
                        @csrf
                          <div class="form-row">
                            <div class="col-md-12">
                              <label>Location</label>
                              <div class="btn-group btn-group-toggle float-right" id="location-switch" data-toggle="buttons">
                                <label class="btn bg-info active">
                                  <input type="radio" name="location" class="location" value="On-site" id="onsite" autocomplete="off" checked> On-site
                                </label>
                                <label class="btn bg-warning ">
                                  <input type="radio" name="location" class="location" id="wfh" value="Work from Home (WFH)"> WFH
                                </label>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="form-row">
                            <div class="col-md-12">
                              <label for="">Goals for the Day</label>
                                <select class="select2" multiple="multiple" data-placeholder="Set your goals" name="goals[]" style="width: 100%; " required>
                                </select>
                            </div>
                          </div>
                          <br>
                          <div class="form-row">
                            <div class="col-md-12">
                              <input type="submit" style="width: 100%" name="time_in" value="Time In" class="btn btn-info timein-btn">
                            </div>
                          </div>
                        </form>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="card card-outline card-warning">
                        <div class="card-header">
                        <h3 class="card-title">Previous Logs</h3>

                        <div class="card-tools">
                            <a href="/staff/tracker" class="btn btn-outline-success">
                                <i class="fa-solid fa-clipboard mr-2"></i> View All
                            </a>
                        </div>
                        <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="prevlogs-tbl" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                <th>#</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $prevlogs as $log )
                                        <tr>
                                            <td>{{$log->id}}</td>
                                            <td>{{ date('d - M Y', strtotime($log->time_in) )}} &nbsp; <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($log->time_in)) }}</span></td>
                                            <td>{{ date('d - M Y', strtotime($log->time_out) )}} &nbsp; <span class=" badge bg-danger text-md">{{ date('h:i A', strtotime($log->time_out)) }}</span></td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        @else
            @if(is_null($attendance->time_out))

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" >
                                <div class="info-box ">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-stopwatch"></i></span>

                                    <div class="info-box-content">
                                      <span class="info-box-number text-xl text-center" id="counter">--:--</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                  </div>
                                  <!-- /.info-box -->
                            </div>
                        <div class="card-body">
                            <style>
                                #status-switch label{
                                    opacity: .5
                                }

                                #status-switch label.active{
                                    opacity: 1
                                }
                            </style>

                            <table class="table">
                                <tr>
                                    <td><strong>Time In</strong></td>
                                    <td><span class=" badge bg-success float-right text-md">{{date('h:i a',strtotime($attendance->time_in))}}</span><span class=" badge float-right text-md">{{date('d - M',strtotime($attendance->time_in))}} </span></td>
                                </tr>
                                <tr>
                                    <td><strong>Location</strong></td>
                                    <td>
                                        {{-- <div class="btn-group btn-group-toggle float-right" id="location-switch" data-toggle="buttons">
                                            <label class="btn bg-info @php if($attendances[0]->location=="On-site"){ echo 'active';} @endphp">
                                              <input type="radio" name="options" id="onsite" autocomplete="off" @php if($attendances[0]->location=="On-site"){ echo 'checked';} @endphp > On-site
                                            </label>
                                            <label class="btn bg-warning @php if($attendances[0]->location=="Work from Home (WFH)"){ echo 'active';} @endphp">
                                              <input type="radio" name="options" id="wfh" autocomplete="off" @php if($attendances[0]->location=="Work from Home (WFH)"){ echo 'checked';} @endphp> WFH
                                            </label>
                                          </div> --}}

                                        @if($attendance->location=="On-site")
                                            <span class=" badge bg-info float-right text-md">On-site</span>
                                        @else
                                            <span class=" badge bg-warning float-right text-md">WFH</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>

                                        <div class="btn-group btn-group-toggle float-right" id="status-switch" data-toggle="buttons">
                                        <label class="btn bg-success">
                                          <input type="radio" class="status_switch" status="online" name="options" id="online" autocomplete="off"  @php if($attendance->status=="online"){ echo 'checked';} @endphp> Online
                                        </label>
                                        <label class="btn bg-danger @php if($attendance->status=="break"){ echo 'active';} @endphp">
                                          <input type="radio" class="status_switch" status="break"  name="options" id="break" autocomplete="off" @php if($attendance->status=="break"){ echo 'checked';} @endphp> Break
                                        </label>
                                      </div>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <button class="btn btn-danger" onclick="time_out()" style="width: 100%">Time Out</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                            <h3 class="card-title">Goals Set for the Day</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul>
                                @php

                                try {
                                    foreach (json_decode($attendance->goal_tasks) as $task ) {
                                        echo '<li>'.$task.'</li>';
                                    }
                                } catch (\Throwable $th) {

                                }

                                @endphp
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            @else

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" >
                                <div class="info-box ">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-stopwatch"></i></span>

                                    <div class="info-box-content">
                                      <span class="info-box-number text-xl text-center" id="counter">-- <small class="text-xs">HRS</small> -- <small class="text-xs">MIN</small> -- <small class="text-xs">SEC</small> </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                  </div>
                                  <!-- /.info-box -->
                            </div>
                        <div class="card-body">
                            <div id="" class="overlay timein-loader" style="display: none">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                            <style>
                                 #location-switch label{
                                    opacity: .5
                                }

                                #location-switch label.active{
                                    opacity: 1
                                }
                            </style>
                          <form method="POST" action="{{ route('staff.timein') }}" enctype="multipart/form-data">
                            @csrf
                              <div class="form-row">
                                <div class="col-md-12">
                                  <label>Location</label>
                                  <div class="btn-group btn-group-toggle float-right" id="location-switch" data-toggle="buttons">
                                    <label class="btn bg-info active">
                                      <input type="radio" name="location" class="location" value="On-site" id="onsite" autocomplete="off" checked> On-site
                                    </label>
                                    <label class="btn bg-warning ">
                                      <input type="radio" name="location" class="location" id="wfh" value="Work from Home (WFH)"> WFH
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="form-row">
                                <div class="col-md-12">
                                  <label for="">Goals for the Day</label>
                                    <select class="select2" multiple="multiple" data-placeholder="Set your goals" name="goals[]" style="width: 100%; " required>
                                    </select>
                                </div>
                              </div>
                              <br>
                              <div class="form-row">
                                <div class="col-md-12">
                                  <input type="submit" style="width: 100%" name="time_in" value="Time In" class="btn btn-info timein-btn">
                                </div>
                              </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                            <h3 class="card-title">Previous Logs</h3>

                            <div class="card-tools">
                                <a href="/staff/tracker" class="btn btn-outline-success">
                                    <i class="fa-solid fa-clipboard mr-2"></i> View All
                                </a>
                            </div>
                            <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="prevlogs-tbl" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                    <th>#</th>
                                      <th>Time In</th>
                                      <th>Time Out</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $prevlogs as $log )
                                            <tr>
                                                <td>{{$log->id}}</td>
                                                <td>{{ date('d - M Y', strtotime($log->time_in) )}} &nbsp; <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($log->time_in)) }}</span></td>
                                                <td>{{ date('d - M Y', strtotime($log->time_out) )}} &nbsp; <span class=" badge bg-danger text-md">{{ date('h:i A', strtotime($log->time_out)) }}</span></td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                  </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            @endif

        @endif

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!--------------------- MODALS ---------------------------->
  @if(!is_null($attendance))

  <div class="modal fade" id="time_out">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-zoom">
      <div class="modal-content" style="">
        <div class="modal-body">

          <div class="card" style="box-shadow: none !important; margin-bottom:0 !important">
            <div class="card-header border-0" >
              <h3 style="display: inline !important">Daily Summary</h3 >
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="float-right" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card-body">

            <div id="timeout-loader" class="overlay" style="display: none">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
                {{-- action="{{ route('staff.timeout') }}"  --}}
              <form method="POST" id="timeout_form" action="{{ route('staff.timeout') }}" enctype="multipart/form-data">
              @csrf
                <input type="hidden" name="attendance_id" value="{{$attendance->id}}">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Time In</label><span class=" badge bg-success float-right text-md">{{date('h:i a',strtotime($attendance->time_in))}}</span><span class=" badge float-right text-md">{{date('d - M',strtotime($attendance->time_in))}} </span>
                  </div>
                  <div class="col-md-6">
                    <label>Location</label>
                    @if($attendance->location=="On-site")
                        <span class=" badge bg-info float-right text-md">On-site</span>
                    @else
                        <span class=" badge bg-warning float-right text-md">WFH</span>
                    @endif
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-12">

                    <label for="">Tasks Done for the Day</label>
                    <div id="table-div" >
                        <table id="task-items-tbl" class=" table table-bordered table-striped">
                            <thead>
                            <th style="min-width: 200px">PROJECT</th>
                            <th >TASKS DONE</th>
                            <th style="width: 30px">
                                <center><button type="button" name="add" class="btn btn-success addTaskField btn-sm"> <span class="fas fa-plus"></span> </button></center>
                            </th>

                        </thead>
                        <tbody id="tasks-tbody" style="">
                        </tbody>
                        <tfoot >
                            <th>PROJECT</th>
                            <th>TASKS DONE</th>
                            <th >
                                <center><button type="button" name="add" class="btn btn-success addTaskField btn-sm"> <span class="fas fa-plus"></span> </button></center>
                            </th>
                        </tfoot>
                    </table>
                    </div>

                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="button" id="timeout-btn" name="logTasks" value="Time Out" class="btn btn-danger">
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
@endif

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
    var  startDateTime = moment();;
    var attendanceValue = `{{$attendance}}`;

    if(attendanceValue === "" || attendanceValue === null ){
        startDateTime = moment();

    } else{
        <?php
            $time_in = null;
            $time_out = null;
            $goal_tasks = null;
            $att_id = null;
            try{
                $time_in = $attendance->time_in;
                $time_out = $attendance->time_out;
                $goal_tasks = $attendance->goal_tasks;
                $att_id = $attendance->id;
            } catch(Exception $e){
                $time_in = null;
                $time_out = null;
                $goal_tasks = null;
                $att_id = null;
            }
        ?>

        if('{{$time_in}}'===""){
            startDateTime = moment();
        } else{
            startDateTime = moment('{{$time_in}}');
        }
    }

    function updateTimer() {

          const now = moment();

          const duration = moment.duration(now.diff(startDateTime));
          const totalHours = duration.asHours();
          const days = Math.floor(totalHours / 24);
          const hours = Math.floor(totalHours % 24) + days * 24;
          const minutes = duration.minutes();
          const seconds = duration.seconds();

          $('#counter').html(`${hours} <small class="text-xs">HRS</small> ${String(minutes).padStart(2, '0')} <small class="text-xs">MIN</small> ${String(seconds).padStart(2, '0')} <small class="text-xs">SEC</small> `);
    }

    if('{{$time_in}}'!=="" && "{{$time_out}}"===""){

      updateTimer();
      intervalId = setInterval(updateTimer, 1000);
    }

    $(function () {

      if(@json(session()->all()).timein) {
          toastr.success('You have successfully marked your attendance!')
      }
      if(@json(session()->all()).timeout) {
          toastr.success('You have successfully timed out!')
      }
  });
  </script>
  <script>

$('#prevlogs-tbl').DataTable({
        "paging": false,
        "lengthChange": false,
        pageLength: 5,
        "searching": false,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true
      });
      $('#breaklogs-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        pageLength: 3,
        "searching": false,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true
      });

    $('.select2').select2({
         tags: true,
         theme: 'bootstrap4'
    });

    $('#timeout-btn[type="button"]').click(function(){

          var field_count = $('#tasks-tbody tr').length;
          
        if(field_count <= 0){

            toastr.error('Please add tasks done for the day!')
        } else {
            var isEmpty = 0;
            
            $('.project_list').each(function (index, element){
                
                if($(this).val() === "" || $(this).val().trim() === "" || $('.task_list').eq(0).val().length == 0 ){
                    isEmpty = 1;
                }
            })
            if(isEmpty == 0){
                
                $("#timeout-loader").css('display',"flex");
            }
        }

    })

  $('.addTaskField').on("click", function() {

        var field = `
        <tr>
        <td class='td_project'><textarea style="min-width: 200px" class="project_list" name="projects[]" required></textarea>
        </td>
        <td class="td_tasks"><select class="select2 task_list" multiple="multiple" data-placeholder="Tasks done" name="tasks[]" style="width: 100%; " required>
            @php echo fill_tasks($goal_tasks) @endphp
                        </select>
        </td>
        <td><center><button type="button" class=" btn btn-danger btnRemove " name="remove"" ><span class="fas fa-times"></span></button></center></td>

        </tr

        `;

        $("#tasks-tbody").append(field);
        $('.select2').select2({
            tags: true,
            theme: 'bootstrap4'
        });
        $('.project_list').on('input', function () {
            this.style.height = 'auto';

            this.style.height =
                (this.scrollHeight) + 'px';
        });
        reinitTaskNames()

    });

    function reinitTaskNames(){
        $('#tasks-tbody tr').each(function(index, element){
            $(this).find('.task_list').attr('name',`tasks_${index}[]`);
        });

        var field_count = $('#tasks-tbody tr').length;

        if(field_count > 0){
            $('#timeout-btn').attr('type','submit');
        } else{
            $('#timeout-btn').attr('type','button');
        }
    }

    $(document).on("click", ".btnRemove", function() {

        $(this).closest("tr").remove();
        reinitTaskNames();
    });

    $(document).on("click", ".timein-btn", function() {

        var goals = $(this).closest("form").find('select').val();
        if(goals != null && goals != ""){
            $(this).closest(".card-body").find(".timein-loader").css('display',"flex");
        }
    });

    function time_out(){
        $('#time_out').modal().show();
    }

    $('.status_switch').click(function(){
        var user_status = $(this).attr('status');
        $.ajax({
            url: "{{ route('staff.setstatus') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: user_status,
                attendance_id: '{{$att_id}}'
            },
            dataType: "json",
            beforeSend: function(){
                $('#loader').css('display','flex');
            },
            complete: function(){

                $('#loader').css('display','none');
            },
            success: function(data) {

                if(data.message === 'success'){
                  toastr.success(`Your status has been set to <strong>${user_status}</strong> successfully!`);
                } else{
                  toastr.error('Something went wrong!');
                }

                // const breaks = data.breaklogs;
                // var break_tbl = $('#breaklogs_tbl').DataTable();
                // break_tbl.clear().draw();

                // breaks.forEach( log => {

                //     break_tbl.row.add([
                //         log.id,
                //         moment(log.break_start).format('h:mm A'),
                //         moment(log.break_end).format('h:mm A')
                //     ]).draw();
                // });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });
    })

</script>

@endsection
