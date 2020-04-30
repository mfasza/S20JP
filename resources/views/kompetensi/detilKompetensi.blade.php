@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="card">
    <div class="card-header">
        <span class="icon"><i class="icon-user"></i></span>&nbsp<b>Detil Riwayat Kompetensi {{$nama->nama}}</b>
    </div>
    <div class="card-header bg-white shadow-sm">
        <a href="{{route('kompetensi.view')}}" class="btn btn-sm btn-primary">Kembali</a>&nbsp
    </div>
    <div class="card-body" style="overflow-x:auto;">
        <!-- Input Success -->
        @if($sukses = session('sukses'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $sukses }}</strong>
            </div>
        @endif
        <table class="table table-striped table-bordered" id="tabel" style="width:100%">
            <thead>
                <tr>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Nama Kegiatan</th>
                    <th>Penyelenggara</th>
                    <th>Kode Pengembangan</th>
                    <th>Jumlah Jam Pelajaran</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detil as $d)
                    <tr>
                        <td>{{$d->tanggal_mulai}}</td>
                        <td>{{$d->tanggal_selesai}}</td>
                        <td>{{$d->nama_pengembangan}}</td>
                        <td>{{$d->penyelenggara}}</td>
                        <td>{{$d->kode_pengembangan}}</td>
                        <td>{{$d->jp}}</td>
                        <td>
                            <a href="{{route('kompetensi.edit', [$nip, $d->id_kompetensi])}}" class="btn btn-sm btn-warning" rel="noopener noreferrer">Edit</a>
                            <button class="btn btn-sm btn-danger hapus" data-id="{{$nip}}" data-komp="{{$d->id_kompetensi}}" data-backdrop="static" data-toggle="modal" data-target="#modal-hapus">Hapus</button>
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
            <form action="{{route('kompetensi.delete')}}" method="post">
                <div class="modal-header">
                    <h5><span class="icon"><i class='icon-remove-sign' style="color:red"></i></span>&nbspKonfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <p class="text-center">Apakah anda yakin ingin menghapus data ?</p>
                    <input type="hidden" name="id_pegawai" id="peg_id" value="">
                    <input type="hidden" name="id_kompetensi" id="komp_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
    // Get id of delete instance
    $('.hapus').on('click', function(event){
        var peg_id = $(this).data('id');
        var komp_id = $(this).data('komp');
        $('#peg_id').val(peg_id);
        $('#komp_id').val(komp_id);
    });
</script>
@endsection
