@extends('layouts.app')
@section('content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5><span class="icon"><i class='icon-pencil'></i></span>&nbsp{{ __('Input Riwayat Kompetensi') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kompetensi.insert') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="tgl_start" class='col-md-4 col-form-label text-md-right'>{{ __('Tanggal Mulai')}}</label>
                                <div class="col-md-6">
                                    <input type="date" name="tgl_start" id="tgl_start" class="form-control @error('tgl_start') is-invalid @enderror" value="{{ old('tgl_start') }}" required>
                                    @error('tgl_start')
                                        <span class='invalid-feedback' role=alert>
                                            <strong>{{ $message }}</strong> 
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_end" class='col-md-4 col-form-label text-md-right'>{{ __('Tanggal Selesai')}}</label>
                                <div class="col-md-6">
                                    <input type="date" name="tgl_end" id="tgl_end" class="form-control @error('tgl_end') is-invalid @enderror" value="{{ old('tgl_end') }}" required>
                                    @error('tgl_end')
                                        <span class='invalid-feedback' role=alert>
                                            <strong>{{ $message }}</strong> 
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_acara" class="col-md-4 col-form-label text-md-right">{{ __('Nama Kegiatan') }}</label>

                                <div class="col-md-6">
                                    <input id="nama_acara" type="text" class="form-control @error('nama_acara') is-invalid @enderror" name="nama_acara" value="{{ old('nama_acara') }}" required/>

                                    @error('nama_acara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="penyelenggara" class="col-md-4 col-form-label text-md-right">{{ __('Penyelenggara Kegiatan') }}</label>

                                <div class="col-md-6">
                                    <input id="penyelenggara" type="text" class="form-control @error('penyelenggara') is-invalid @enderror" name="penyelenggara" value="{{ old('penyelenggara') }}" required/>

                                    @error('penyelenggara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_pengembangan" class="col-md-4 col-form-label text-md-right">{{ __('Jenis Pengembangan') }}</label>

                                <div class="col-md-6">
                                    <select name="kode_pengembangan" id="kode_pengembangan" required style='width:100%' class="form-control @error('kode_pengembangan') is-invalid @enderror">
                                        <option value="">Pilih Jenis Pengembangan</option>
                                        @foreach($jenis_pengembangan as $j)
                                            <option value="{!! $j->kode_pengembangan !!}" @if($j->kode_pengembangan == old('kode_pengembangan')) selected @endif>{{ $j->kode_pengembangan.' - '.$j->jenis_pengembangan }}</option>
                                        @endforeach
                                    </select>

                                    @error('kode_pengembangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jp" class="col-md-4 col-form-label text-md-right">{{ __('Total Jam Pelajaran') }}</label>

                                <div class="col-md-6">
                                    <input id="jp" type="number" class="form-control @error('jp') is-invalid @enderror" name="jp" value="{{ old('jp') }}" required min="1"/>
                                    <span class="alert-danger small">1 Jam Pelajaran = 45 Menit</span>

                                    @error('jp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nip" class="col-md-4 col-form-label text-md-right">{{ __('NIP Peserta') }}</label>

                                <div class="col-md-6">
                                    <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') }}" required autocomplete="nip" autofocus/>

                                    @error('nip')
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
                            <a href="{{route('kompetensi.view')}}" class="btn btn-primary">Kembali</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        var today = new Date();
        var start = $("#tgl_start");
        var dd = String(today.getDate()-1).padStart(2, '0');
        var mm = String(today.getMonth()+1).padStart(2, '0');
        var yyyy = today.getFullYear();
        document.getElementById("tgl_start").setAttribute('max', String(yyyy+'-'+mm+'-'+dd));
        document.getElementById("tgl_end").setAttribute('max', String(yyyy+'-'+mm+'-'+dd));
        var end = document.getElementById("tgl_end");
        start.change(function(){
            end.setAttribute("min", start.val());
        })
    });
</script>
@endsection