<!DOCTYPE html>
<html lang="en">

<head>
        <title>Pusdiklat BPS 20JP</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('css/bootstrap-responsive.min.css')}}" />
        <link rel="stylesheet" href="{{asset('css/matrix-login.css')}}" />
        <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">
            <form id="loginform" class="form-vertical" action="{{route('login')}}" method="POST">
                @csrf
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
				<div class="control-group normal_text"> <h3><img src="img/bps.png" height='12.5%' width='12.5%' alt="Logo" />{{__('Pusdiklat BPS')}}</h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input id='username' name='username' type="text" class="form-control @error('username') invalid-feedback @enderror" placeholder="Username" autofocus autocomplete="username" value="{{old('username')}}" /><br>
                            @error('username')
                                <span class='invalid-feedback' role='alert'>
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="password" name="password" class="form-control @error('password') is-invalid @enderror" type="password" autocomplete="current-password" placeholder="Password" /><br>
                            @error('password')
                                <span>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lupa password?</a></span>
                    <span class="pull-right"><a id='login' type="submit" class="btn btn-success" onclick="document.getElementById('loginform').submit()"> Login</a></span>
                </div>
            </form>
            <form id="recoverform" action="{{route('password.email')}}" class="form-vertical" method='post'>
                @csrf
				<p class="normal_text">Masukkan alamat email yang anda daftarkan dan kami akan mengirimkan tautan untuk reset password.</p>

                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input id='email' name='email' type="text" placeholder="E-mail address" /><br>
                            @error('email')
                                <span>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Kembali</a></span>
                    <span class="pull-right"><a id='recover' class="btn btn-info" onclick="document.getElementById('recoverform').submit()" >Pulihkan</a></span>
                </div>
            </form>
        </div>
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/matrix.login.js')}}"></script>
        <script>
            function submit(field_id, submit_id) {
                var input = document.getElementById(field_id);
                input.addEventListener("keyup", function(event) {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                        document.getElementById(submit_id).click();
                    }
                });
            };
            submit('username', 'login');
            submit('password', 'login');
        </script>
    </body>

</html>
