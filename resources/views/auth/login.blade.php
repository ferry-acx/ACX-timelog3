
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition" style="overflow: hidden">
    <div style="z-index: 5; position: absolute; height: 100vh; width: 100vw; background-image: url('dist/acx-imgs/desktop-background.png'); background-position: center center; background-size: cover; background-repeat: no-repeat">
        <style>
            .floating {
                animation-name: floating;
                animation-duration: 3s;
                animation-iteration-count: infinite;
                animation-timing-function: ease-in-out;
                margin-left: 30px;
                margin-top: 5px;
            }

            @keyframes floating {
                0% { transform: translate(0,  0px); }
                50%  { transform: translate(0, 15px); }
                100%   { transform: translate(0, -0px); }
            }
        </style>
        <div class="floating " style="padding-right: 200px; animation: floating 6s ease-in-out infinite; display: flex; justify-content: center; align-items: center; height: 100vh"><img src="dist/acx-imgs/desktop-person.png" style="width: auto; height: 350px"/></div>
    </div>
    <div class="container" style="z-index: 10; height: 100vh; display: flex;
    justify-content: center;
    align-items: center;
    position: relative;">
        <div class="col-md-6"></div>
        <div class="col-md-6 " style="padding: 100px">
            <form method="POST" action="{{ route('login') }}">
                @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
                @endif
                @csrf

                <div class="form-group row">
                    <div class="col">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

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
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
