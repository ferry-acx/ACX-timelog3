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
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-business-time"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">On-shift</span>
                <span class="info-box-number text-xl" id="onshift">
                    {{ $core+$publishing+$relevate }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users-viewfinder"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">ACX Core</span>
                <span class="info-box-number text-xl" id="core">{{ $core }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Publishing</span>
                <span class="info-box-number text-xl" id="publishing">{{ $publishing }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shirt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Relevate</span>
                <span class="info-box-number text-xl" id="relevate">{{ $relevate }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Daily Time-in Records</h5>
                <div class="card-tools">
                    <a href="/admin/timelogs" type="button" class="btn btn-outline-success">
                        <i class="fas fa-file-pen mr-2"></i><span>View Timelogs</span>
                    </a>
                  </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9">


                <table id="dtr-tbl" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Employee</th>
                      <th>Department</th>
                      <th>Position</th>
                      <th>Time In</th>
                      <th>Location</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $attendances as $attendance )
                            <tr>
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
                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Time In</th>
                        <th>Location</th>
                    </tr>
                    </tfoot>
                  </table>

                  </div>
                  <!-- /.col -->
                  <div class="col-md-3">

                    <!-- Info Boxes Style 2 -->
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="fas fa-map-location-dot"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">On-site</span>
                        <span class="info-box-number text-xl" id="onsite">{{ $onsite }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-danger">
                        <span class="info-box-icon"><i class="fas fa-house-laptop"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Work from Home</span>
                        <span class="info-box-number text-xl" id="wfh">{{ $wfh }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-stopwatch"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Online</span>
                        <span class="info-box-number text-xl" id="online">{{ $online }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="fas fa-mug-hot"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">On-break</span>
                        <span class="info-box-number text-xl" id="onbreak">{{ $onbreak }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

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

  <script>

     $(function () {

      $('#dtr-tbl').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "buttons": []
      });
    });
     
    function updateViewWithData(data) {
        $('#onshift').text((data.core+data.publishing+data.relevate));
        $('#core').text(data.core);
        $('#publishing').text(data.publishing);
        $('#relevate').text(data.relevate);
        $('#onsite').text(data.onsite);
        $('#wfh').text(data.wfh);
        $('#online').text(data.online);
        $('#onbreak').text(data.onbreak);
    }

    function fetchRealTimeData() {
        $.ajax({
            url: "{{ route('admin.dashboard.realtime') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                updateViewWithData(data);
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
