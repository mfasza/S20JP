@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="card">
    <div class="card-header">
        <span class='icon'><i class="icon-briefcase"></i></span>&nbsp<b>Pengembangan Kompetensi</b>
    </div>
    <div class="card-header bg-white shadow-sm">
        <a href="{{url('/kompetensi/form')}}" class="btn btn-sm btn-primary">Submit Kompetensi</a>&nbsp
        <a href="#modal-excel" data-toggle='modal' data-backdrop='static' data-keyboard='false' class='btn btn-sm btn-primary'>Upload Kompetensi</a>
    </div>
    <div class="card-body" style='overflow-x:auto;'>
        <!-- Input Success -->
        @if($sukses = session('sukses'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $sukses }}</strong>
            </div>
        @endif
        <!-- Error for excel validation -->
        @if(!empty($errors->all()))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Mohon lakukan perbaikan pada data dan submit ulang:</strong><br>
                <strong>{{ $errors->first() }}</strong><br>
            </div>
        @endif
        <table class="table table-striped table-bordered" id='tabel' style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Unit Eselon 2</th>
                <th>Unit Eselon 3</th>
                <th>Total JP</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jp as $j)
                <tr>
                    <td>{{$j->nama}}</td>
                    <td>{{$j->unit_eselon2}}</td>
                    <td>{{$j->unit_eselon3}}</td>
                    @if($j->jp === null)
                        <td>0</td>
                    @else
                        <td>{{$j->jp}}</td>
                    @endif
                    <td>
                        <a href="{{url('/kompetensi/detil',$j->nip)}}" class='btn btn-primary btn-sm'>Detil</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-excel" role="dialog" aria-labeledBy="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('kompetensi.import')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5><span class="icon"><i class="icon-table"></i></span>&nbspUpload Excel File</h5>
                    <button type="button" class='close' data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <label for="excelFile">Pilih file excel:</label>
                    <div class="form-group">
                        <input type="file" class="form-control-file @error('excelFile') is-invalid @enderror" name='excelFile' required accept=".xlsx,.xls,.csv">

                        @error('excelFile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                        <a href="{{url('/kompetensi/download')}}" class='alert-success small' style="text-decoration: none">Download template Excel untuk import data kompetensi.</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Data table show instance
        $('#tabel').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
</script>
@endsection
