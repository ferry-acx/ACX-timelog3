@extends('admin.app')
@section('main_content')

    <script>
        $('#nav-dash a').toggleClass('active')
    </script>
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Configuration</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Configuration</li>
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
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">

                <div id="config-loader" class="overlay" style="display: none">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <style>
                    .config-input{
                        border: none;
                        width: 90%;
                        opacity: .7;
                    }

                    .config-input:focus-visible, .config-input:focus, .config-input:focus-within, .config-input:active, .config-input:visited{
                        border: none !important;
                        outline: none !important;
                        opacity: 1
                    }

                    .config-input button{
                        color: #0da548
                    }
                </style>
                @php

                    $discord_timein ='';
                    $discord_timeout ='';
                    foreach ($configs as $config) {
                        if($config->name=='discord_timein'){
                            $discord_timein = $config->value;
                        }
                        if($config->name=='discord_timeout'){
                            $discord_timeout = $config->value;
                        }
                    }
                @endphp
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box mb-3">
                            <span class="info-box-icon  elevation-1 " style="background-color: #5865F2"><i class="fa-brands fa-discord" style="color: #ffffff;"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Discord Webhook URL <span class="badge bg-info">TIMEIN</span></span>
                                <span class="info-box-number d-flex mr-3" style="width: 100%"><input class="config-input" type="text" field="discord_timein" value="{{$discord_timein}}"><button class="btn btn-lg save-btn" title="Save"><i class="fa-regular fa-floppy-disk ml-3" style="color: #0c9215"></i></button></span>
                            </div>
                              <!-- /.info-box-content -->
                        </div>
                            <!-- /.info-box -->
                    </div>
                    <div class="col-md-6 d-flex">


                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box mb-3">
                            <span class="info-box-icon  elevation-1 " style="background-color: #5865F2"><i class="fa-brands fa-discord" style="color: #ffffff;"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Discord Webhook URL <span class="badge bg-danger">TIMEOUT</span></span>
                                <span class="info-box-number d-flex mr-3" style="width: 100%"><input class="config-input" type="text" field="discord_timeout" value="{{$discord_timeout}}"><button class="btn btn-lg save-btn" title="Save"><i class="fa-regular fa-floppy-disk ml-3" style="color: #0c9215"></i></button></span>
                            </div>
                              <!-- /.info-box-content -->
                        </div>
                            <!-- /.info-box -->
                    </div>
                    <div class="col-md-6 d-flex">


                    </div>
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

  <script>
    $(function(){
        $('.save-btn').click(function(){
            var name = $(this).closest('span').find('input').attr('field');
            var value = $(this).closest('span').find('input').val();

            if(value===""){
                value=null
            }

            console.log(name);
            console.log(value);
            $.ajax({
                url: "{{ route('admin.config.save') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: name,
                    value: value
                },
                beforeSend: function(){
                    $('#config-loader').css('display','flex');
                },
                complete: function(){

                    $('#config-loader').css('display','none');
                },
                success: function(data) {

                    if(data.message === 'success'){
                      toastr.success('Configuration saved successfully!');
                    } else{
                      toastr.error('Something went wrong!');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            })
        })
    })
  </script>

@endsection
