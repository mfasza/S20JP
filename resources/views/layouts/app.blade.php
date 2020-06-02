<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
</head>
<body class="bg-dark">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('img/bps.png')}}" height='25px' width='30px' alt="Logo" />&nbsp{{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pegawai.view') }}">{{ __('Pegawai') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kompetensi.view') }}">{{ __('Kompetensi') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-target="#modal-report" data-backdrop="static" data-toggle="modal">{{ __('Unduh') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarBantuan" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Bantuan</a><span class="caret"></span>
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledBy="navbarBantuan">
                        <a href="{{url('/bantuan/panduan')}}" class="dropdown-item">Panduan</a>
                            <a href="{{url('/bantuan/kodeUnitKerja')}}" class="dropdown-item">Daftar Kode Unit Kerja</a>
                        </div>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @switch(Auth::user()->role)
                                    @case('eselon2')
                                        {{App\Eselon2::where('kode_eselon2', Auth::user()->kode_satker)->first()->unit_eselon2}}
                                        @break
                                    @case('eselon3')
                                        {{App\Eselon3::where('kode_eselon3', Auth::user()->kode_satker)->first()->unit_eselon3}}
                                        @break
                                    @case('admin')
                                        Admin
                                        @break
                                @endswitch<span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        @yield('content')

    </div>

    {{-- modal generate report --}}
    <div class="modal fade" id="modal-report" role="dialog" aria-labeledBy="myModal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5><span class="icon"><i class='icon-download-alt'></i></span>&nbsp;Unduh Data</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('download')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <h6>Jenis Data: </h6>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_data" id="inlineRadio1" value="raw" required>
                                <label class="form-check-label" for="inlineRadio1">Raw</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_data" id="inlineRadio2" value="agregat" required>
                                <label class="form-check-label" for="inlineRadio2">Agregat</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="filter"><h6>Filter: </h6></label>
                            <select class="form-control" id="filter" name="filter" required>
                                <option value="">-- Pilih --</option>
                                @if (Auth::user()->role != 'eselon3')
                                    <option value="eselon2">Eselon 2</option>
                                @endif
                                <option value="eselon3">Eselon 3</option>
                            </select>
                        </div>

                        <label for="unit-kerja-selector"><h6>Unit Kerja: </h6></label>
                        <div id="unit-kerja-selector" class="form-group" style='width: 100%; height: 200px; overflow: auto; border: 1px solid #999; padding: 15px;'>
                            <div class='form-check'>
                                <input class='form-check-input' type='checkbox' onClick='toggle(this)' id='all'>
                                <label class='form-check-label' for='all'>
                                    Pilih Semua
                                </label>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                        <button id="generate" type="submit" class="btn btn-success">Unduh</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- akhir modal generate report --}}
<script src="{{asset('js/download.js')}}"></script>
<script>
    $(document).ready(function(){
        document.getElementById('filter').addEventListener('change', function(){
            if($(this).val() != ''){
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url : "{{url('/report/selection')}}",
                    type : "post",
                    data : {value: value, _token: _token},
                    success : function(result){
                        $('#unit-kerja-selector').html(result);
                    }
                })
            }
        });
    });
</script>
</body>
</html>
