@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="card">
    <div class="card-header">
        <span class="icon"><i class='icon-user'></i></span>&nbsp<b>Data Pegawai</b>
    </div>
    <div class="card-header bg-white shadow-sm">
        <a href="{{url('/pegawai/form')}}" class="btn btn-sm btn-primary">Submit Pegawai</a>&nbsp
        <a href="#modal-excel" data-toggle="modal" data-backdrop="static" class="btn btn-sm btn-primary">Upload Pegawai</a>
    </div>
    <div class="card-body" style="overflow-x:auto;">
        <!-- Input Success -->
        @if($sukses = session('sukses'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $sukses }}</strong>
            </div>
        @endif
        <!-- Error for excel validation -->
        @error('Kode Unit Eselon 3')
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times</button>
                <strong>{{$message}}</strong>
            </div>
        @enderror
        @if($e = session('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>Mohon lakukan perbaikan pada data dan submit ulang:</strong><br>
                @foreach($e as $error)
                    <strong>{{ '('.$error->row().'.'.$error->attribute().'):' }}</strong>
                    @foreach($error->errors() as $msg)
                        <strong>&nbsp{{$msg}}</strong><br>
                    @endforeach
                @endforeach
            </div>
        @endif
        <table class="table table-striped table-bordered" id="tabel" style="width:100%"> 
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Unit Eselon 2</th>
                    <th>Unit Eselon 3</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawai as $p)
                    <tr>
                        <td>{{$p->nip}}</td>
                        <td>{{$p->nama}}</td>
                        <td>{{$p->unit_eselon2}}</td>
                        <td>{{$p->unit_eselon3}}</td>
                        <td>
                            <a href="{{ route('pegawai.edit', $p->nip) }}" class="btn btn-sm btn-warning" rel="noopener noreferrer">Edit</a>
                            <button class="btn btn-sm btn-danger hapus" data-id="{{$p->nip}}" data-backdrop="static" data-toggle="modal" data-target="#modal-hapus">Hapus</button>
                        </td>
                    </tr>
                @endforeach            
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-hapus" role="dialog" aria-labeledBy="myModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('pegawai.delete')}}" method="post">
                <div class="modal-header">
                    <h5><span class="icon"><i class='icon-remove-sign' style="color:red"></i></span>&nbspKonfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <p class="text-center">Apakah anda yakin ingin menghapus data ?</p>
                    <input type="hidden" name="pegawai_id" id="peg_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-excel" role="dialog" aria-labeledBy="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('pegawai.import')}}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5><span class="icon"><i class='icon-table'></i></span>&nbspUpload Excel File</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <label>Pilih file excel:</label>
                    <div class="form-group">
                        <input class="form-control-file @error('excelFile') is-invalid @enderror" type="file" name="excelFile" required accept=".xlsx,.xls,.csv">

                        @error('excelFile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                        <a href="{{url('pegawai/download')}}" class='alert-success small' style="text-decoration: none">Download template Excel untuk import data pegawai.</a>
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
        // Get id of delete instance
        $('.hapus').on('click', function(event){
            var peg_id = $(this).data('id');
            $('#peg_id').val(peg_id);
        });
    });
</script>
@endsection