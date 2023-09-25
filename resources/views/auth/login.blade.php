
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ACX Attendance System | Log in</title>

  <link rel="icon" href="../dist/acx-imgs/logo.png" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition" style="overflow: hidden; background-image: url('dist/acx-imgs/desktop-background.png'); background-position: center center; background-size: cover; background-repeat: no-repeat">
    <style>
        .floating {
            animation-name: floating;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            margin-left: 30px;
            margin-top: 5px;
        }

        @media(max-width: 767px){
            .floating{
                width: 100%;
                height: auto;
            }
        }

        @keyframes floating {
            0% { transform: translate(0,  0px); }
            50%  { transform: translate(0, 15px); }
            100%   { transform: translate(0, -0px); }
        }
    </style>
    <div class="container" style="z-index: 10; height: 100vh; display: flex;
    justify-content: center;
    align-items: center;
    position: relative; ">
    <div class="row" style="width: 100%">
        <div class="col-md-6" style="">
            <img class="floating" src="dist/acx-imgs/desktop-person.png" />
        </div>
        <div class="col-md-6 p-3" style="display: flex;   align-items: center;">
            <div class="card shadow" style="height: fit-content; width: 100%; background-color: #ffffff52">
                <div class="card-body p-5">
                    <div class="mb-4" style="    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;" ><img src="dist/acx-imgs/desktop-logo.svg" style="height: 100px"/><div><h3 class="text-center">ACX ATTENDANCE SYSTEM</h3></div></div>
                    <hr>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <div class="col">
                        <input id="username" placeholder="Username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                </div>

                <div class="form-group row mb-0 mt-0">
                    <div class="col">
                        <button type="submit" class="btn btn-primary col">
                            {{ __('Log In') }}
                        </button>
                    </div>
                </div>
            </form>
            </div>
            </div>

        </div>
    </div>
    </div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<script>
    if(@json(session()->all()).error) {
            toastr.error('Incorrect credentials!')
        }

</script>
</body>
</html>
