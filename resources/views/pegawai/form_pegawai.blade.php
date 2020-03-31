@extends('layouts.app')
@section('content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><span class="icon"><i class='icon-pencil'></i></span>&nbsp{{ __('Register Pegawai') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('pegawai.insert')}}">
                            @csrf                        
                            <div class="form-group row">
                                <label for="nip" class="col-md-4 col-form-label text-md-right">{{ __('NIP') }}</label>

                                <div class="col-md-6">
                                    <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required autocomplete="nip" autofocus  placeholder='18-digit NIP'>

                                    @error('nip')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autocomplete="nama" autofocus required placeholder='Nama Pegawai'>

                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eselon2" class="col-md-4 col-form-label text-md-right">{{ __('Unit Eselon 2') }}</label>

                                <div class="col-md-6">
                                    @switch(Auth::user()->role)
                                        @case('admin')
                                            <select name="eselon2" id="kode_eselon2" required style="width: 100%" class="form-control @error('eselon2') is-invalid @enderror dynamic" data-dependent='unit_eselon3'>
                                                <option value="">Pilih Unit Eselon 2</option>
                                                @foreach($satker as $es2)
                                                    <option value="{!! $es2->kode_eselon2 !!}">{{ $es2->kode_eselon2.' - '.$es2->unit_eselon2 }}</option>
                                                @endforeach                                        
                                            </select>
                                            @break
                                        @default
                                            <select name="eselon2" id="kode_eselon2" required style="width: 100%" class="form-control @error('eselon2') is-invalid @enderror" readonly>
                                                <option value="{!! $satker->first()->kode_eselon2 !!}">{{ $satker->first()->kode_eselon2.' - '.$satker->first()->unit_eselon2 }}</option>
                                            </select>
                                            @break
                                    @endswitch

                                    @error('eselon2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eselon3" class="col-md-4 col-form-label text-md-right">{{ __('Unit Eselon 3') }}</label>

                                <div class="col-md-6">
                                    @switch(Auth::user()->role)
                                        @case('eselon2')
                                            <select name="eselon3" id="eselon3" style="width: 100%" class="form-control @error('eselon3') is-invalid @enderror" >
                                                <option value="">Pilih Unit Eselon 3</option>
                                                @foreach($satker as $es3)
                                                    <option value="{!! $es3->kode_eselon3 !!}" @if($es3->kode_eselon3 == old('eselon3')) selected @endif>{{ $es3->kode_eselon3.' - '.$es3->unit_eselon3 }}</option>
                                                @endforeach                                        
                                            </select>
                                            @break
                                        @case('eselon3')
                                            <select name="eselon3" id="eselon3" required style="width: 100%" class="form-control @error('eselon3') is-invalid @enderror" readonly>
                                                <option value="{!! $satker->first()->kode_eselon3 !!}">{{ $satker->first()->kode_eselon3.' - '.$satker->first()->unit_eselon3 }}</option>
                                            </select>
                                            @break
                                        @case('admin')
                                            <select name="eselon3" id="unit_eselon3" style="width: 100%" class="form-control @error('eselon3') is-invalid @enderror">
                                                <option value="">Pilih Unit Eselon 3</option>
                                            </select>
                                            @break
                                    @endswitch

                                    @error('eselon3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success">
                                {{ __('Register') }}
                            </button>
                            <a href="{{route('pegawai.view')}}" class="btn btn-primary">Kembali</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
        document.getElementById('kode_eselon2').addEventListener('change', function(){
            if($(this).val() != ''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url : "{{route('pegawai.adminFill')}}",
                    type : "post",
                    data : {select: select, value: value, _token: _token, dependent: dependent},
                    success : function(result){
                        $('#'+dependent).html(result);
                    }
                })
            }
        });
    });
</script>
@endsection
