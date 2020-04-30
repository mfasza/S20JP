@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">

<div class="card">
    <div class="card-header">
        <h3 class="card-title text-center">Daftar Kode Unit Kerja</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered table-striped" id="kode_eselon2">
                    <thead>
                        <tr>
                            <th>Unit Eselon 2</th>
                            <th>Kode Eselon 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_es2 as $es2)
                        <tr>
                            <td>{{$es2->unit_eselon2}}</td>
                            <td>{{$es2->kode_eselon2}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table table-bordered table-striped" id="kode_eselon3">
                    <thead>
                        <tr>
                            <th>Kode Eselon 3</th>
                            <th>Unit Eselon 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_es3 as $es3)
                        <tr>
                            <td>{{$es3->unit_eselon3}}</td>
                            <td>{{$es3->kode_eselon3}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Data table show instance kode eselon 2
        $('#kode_eselon2').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
        // Data table show instance kode eselon 3
        $('#kode_eselon3').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
</script>
@endsection
