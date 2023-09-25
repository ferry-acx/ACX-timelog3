

  @extends('staff.app')
  @section('main_content')


<style>
    @media(min-width: 1024px){
        #myteam-container{
            max-width: 80vw;
        }
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
        <div class="container" id="myteam-container">
          <div class="row  pt-2">
              <div class="col-md-12">
                  <h2 class="mb-2" style="font-weight: 600">My Team</h2>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">

                  <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                              <!-- Widget: user widget style 2 -->
                            <div class="card card-widget widget-user-2">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class=" p-3 d-flex ">

                                    <form method="POST" id="addToPod" action="{{ route('staff.addtopod') }}" enctype="multipart/form-data" style="width: 100%">
                                            @csrf
                                        <span class="d-flex">
                                            <select class="form-control select2" name="member_id" id="emp" placeholder="Select New Team Member" required>
                                                <option value="">Select New Team Member</option>
                                                @foreach( $employees as $employee )
                                                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-outline-success" title="Add to Team"><i class="fa-solid fa-user-plus"></i></button>
                                        </span>
                                    </form>
                                </div>
                                <div class="card-footer p-0">
                                    <style>
                                        #pod_members li{
                                            padding: 10px;
                                        }
                                        #pod_members a{
                                            display: inline;
                                        }
                                        #pod_members a.remove-btn{
                                            visibility: hidden;
                                            opacity: 0;
                                            transition: opacity 300ms ease-in-out;
                                        }
                                        #pod_members li:hover a.remove-btn{
                                            visibility: visible;
                                            opacity: 1;
                                        }
                                    </style>
                                    <ul class="nav flex-column" id="pod_members">
                                        @foreach ( $members as $member )
                                            <li class="nav-item">

                                                <a href="#{{$member->username}}" onclick="viewLogs({{$member->id}})" class="nav-link">
                                                    {{$member->first_name}}

                                                        @php
                                                            try{
                                                                if($member->attendances->last()->status=="out"){
                                                                    echo '<span id="member-'.$member->id.'" class="float-right badge bg-danger">'.$member->attendances->last()->status.'</span>';
                                                                } elseif ($member->attendances->last()->status=="online") {
                                                                    echo '<span id="member-'.$member->id.'" class="float-right badge bg-success">'.$member->attendances->last()->status.'</span>';
                                                                } elseif ($member->attendances->last()->status=="break") {
                                                                    echo '<span id="member-'.$member->id.'" class="float-right badge bg-warning">'.$member->attendances->last()->status.'</span>';
                                                                } else {
                                                                    echo '<span id="member-'.$member->id.'" class="float-right badge bg-info">'.$member->attendances->last()->status.'</span>';
                                                                }

                                                            }catch(Exception $e){
                                                                echo '<span id="member-'.$member->id.'" class="float-right badge bg-info">N/A</span>';
                                                            }
                                                        @endphp
                                                </a>
                                                <a href="#" title="Remove" class="nav-link remove-btn"><span class="badge"><i class="fa-solid fa-user-xmark" style="color:#dc3545 "></i></span></a>

                                                <form id="" action="{{ route('staff.removefrpod') }}" method="POST" class="d-none remove-member">
                                                    @csrf
                                                    <input name="member_id" type="hidden" value="{{$member->id}}">
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <div class="col-md-9">


                            <!-- -->
                            <div id="log-loader" class="overlay" style="display: none">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>

                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">

                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary-content-tab" role="tab" aria-controls="custom-tabs-four-summary" aria-selected="true">Daily Summary</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="member-tab" data-toggle="pill" href="#member-content-tab" role="tab" aria-controls="custom-tabs-four-member" aria-selected="false"><strong id="member_name">Member's Log</strong></a>
                                    </li>
                                </ul>
                                </div>
                                <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="summary-content-tab" role="tabpanel" aria-labelledby="custom-tabs-four-summary-tab">

                                        <table id="summary-tbl" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Member</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                                <th>Goals</th>
                                                <th>Task Done</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ( $memberlogs as $memberlog )
                                                    <tr>
                                                        <td><a href="#{{$memberlog->user->username}}" onclick="viewLogs({{$memberlog->user_id}})">{{$memberlog->user->first_name}}</a></td>
                                                        <td>{{ date('d - M Y', strtotime($memberlog->time_in) )}} &nbsp; <span class=" badge bg-info text-md">{{ date('h:i A', strtotime($memberlog->time_in)) }}</span></td>
                                                        <td>
                                                            @if($memberlog->time_out == null )
                                                                <span class=" badge bg-warning text-md">On-shift</span>
                                                            @else
                                                                {{ date('d - M Y', strtotime($memberlog->time_out) )}} &nbsp; <span class=" badge bg-danger text-md">{{ date('h:i A', strtotime($memberlog->time_out)) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                @php
                                                                    try{
                                                                        
                                                                        foreach ( json_decode($memberlog->goal_tasks)  as $goal){
                                                                            echo '<li>'.$goal.'</li>';
                                                                        }
                                                                    }catch(Exception $e){
                                                                        echo '<span class=" badge bg-danger text-md">No Goals Set</span>';
                                                                    }
                                                                @endphp
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            @foreach ( $memberlog->tasklogs  as $task_done )
                                                                <strong>{{$task_done->project}}</strong>
                                                                <ul>
                                                                    @php
                                                                        try{
                                                                            foreach ( json_decode($task_done->tasks) as $task){
                                                                                
                                                                                echo '<li>'.$task.'</li>';
                                                                            }
                                                                        }catch(Exception $e){
                                                                            echo '<li>'.$task_done->tasks.'</li>';
                                                                        }
                                                                        
                                                                        
                                                                    @endphp
                                                                    
                                                                </ul>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Member</th>
                                                    <th>Time In</th>
                                                    <th>Time Out</th>
                                                    <th>Goals</th>
                                                    <th>Task Done</th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade" id="member-content-tab" role="tabpanel" aria-labelledby="custom-tabs-four-member-tab">


                                        <table id="memberlog-tbl" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Goals</th>
                                            <th>Tasks Done</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                                <th>Goals</th>
                                                <th>Tasks Done</th>
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


$('#memberlog-tbl').DataTable({
        "paging": true,
        pageLength: 3,
        "lengthChange": true,
        lengthMenu: [1,2,5,10,25,50,100],
        "searching": true,
        "ordering": true,
        order :[[0,'desc']],
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "emptyTable":  "Please select team member to view logs."
        }
      });


$('#summary-tbl').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true
      });



      $(function () {

        $('.select2').select2({});


        if(@json(session()->all()).added) {
            toastr.success('Employee has been addedd to pod!')
        }
        if(@json(session()->all()).removed) {
            toastr.success('Employee has been removed from pod!')
        }

        $('.remove-btn').click(function(){
            $(this).closest('li').find("form").submit();
        })

    });



    function viewLogs(id){
        $.ajax({
            url: "{{ route('staff.getlogs') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function(){
                $('#log-loader').css('display','flex');
            },
            complete: function(){

                $('#log-loader').css('display','none');
            },
            success: function(data) {
                $('#member_name').text(data.name+"'s Logs")
                    const attendance = data.attendances;

                    //console.log(attendance);

                    var log_tbl = $('#memberlog-tbl').DataTable();
                    log_tbl.clear().draw();
                    var goals_list = '<ul>';

                attendance.forEach( log => {
                    var goals_list = '<ul>';
                    try {
                        var goals = JSON.parse(log.goal_tasks);

                        goals.forEach( goal => {
                            goals_list += `<li>${goal}</li>`;
                        });

                    } catch (error) {
                        goals_list += `<li>${log.goal_tasks}</li>`;
                    }
                    goals_list += '</ul>';

                    var tasklogs = log.tasklogs;
                    let tasks_done  = '';


                    tasklogs.forEach( project => {
                        tasks_done += `<strong>${project.project}</strong>`;
                        tasks_done += `<ul>`;

                        try{
                            var tasks = JSON.parse(project.tasks);
                            tasks.forEach( task => {
                                tasks_done += `<li>${task}</li>`;
                            });
                        }catch(error){
                            tasks_done += `<li>${project.tasks}</li>`;
                        }

                        tasks_done += `</ul>`;
                    } );

                    var time_out = null;
                    if(log.time_out != null && log.time_out != ""){
                        time_out = `${moment(log.time_out).format('DD - MMM YYYY')}&nbsp;<span class=" badge bg-danger text-md">${moment(log.time_out).format('h:mm A')}</span>` ;
                    } else {
                        time_out = `<span class=" badge bg-warning text-md">On-shift</span>`;
                    }

                    log_tbl.row.add([
                        log.id,
                        `${moment(log.time_in).format('DD - MMM YYYY')}&nbsp;<span class=" badge bg-info text-md">${moment(log.time_in).format('h:mm A')}</span>`,
                        time_out,
                        `${goals_list}`,
                        `${tasks_done}`
                        ]).draw();
                } );

                $('#member-tab').click();

            },
            error: function(xhr, status, error) {
                toastr.error("Something went wrong!");
                console.log(error);

            }
        });
    }

    function fetchRealTimeData() {
        $.ajax({
            url: "{{ route('staff.mypod.realtime') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                data.forEach( member => {
                    if(member.status == "out"){
                        $("#member-"+member.id).attr('class',"float-right badge bg-danger");
                    }else if(member.status == "break"){
                        $("#member-"+member.id).attr('class',"float-right badge bg-warning");
                    }else if(member.status == "online"){
                        $("#member-"+member.id).attr('class',"float-right badge bg-success");
                    }else{
                        $("#member-"+member.id).attr('class',"float-right badge bg-info");
                    }
                    
                    if(member.status == null){
                        $("#member-"+member.id).text("N/A");
                    } else {
                        $("#member-"+member.id).text(member.status);
                    }
                })
            },
            error: function(xhr, status, error) {
                console.error("Error fetching real-time data:", error);
            }
        });
    }

    // Periodically fetch real-time data every 5 seconds (adjust the interval as needed)
    setInterval(fetchRealTimeData, 10000);

  </script>

@endsection
