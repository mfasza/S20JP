@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/chart/progress.css')}}">
<link rel="stylesheet" href="{{asset('css/chart/Chart.css')}}">
<link rel="stylesheet" href="{{asset('css/chart/Chart.min.css')}}">

<div class="card">
    <div class="card-body" style="background-color:#efefef">
        <div class="widget-box shadow-sm">
            <div class="widget-title">
                <span class="icon"><i class="icon-ok"></i></span><h5>Progress</h5>
            </div>
            <div class="widget-content">
                <ul class="unstyled">
                    <li>
                        {{$satkers[0]->unit_kerja}}
                        <span class='pull-right strong'>{{$satkers[0]->tot_jp}}%</span>
                        <div class="progress progress-striped progress-warning">
                            <div style="width: {{$satkers[0]->tot_jp}}%" class='bar'></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="widget-box shadow-sm widget-primary">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-star"></i></span><h5>Top 3 Pegawai</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @if (sizeof($top3_peg)==0)
                                <li>Data Tidak Tersedia</li>
                            @else
                                @foreach($top3_peg as $l)
                                <li>{{$l->nama}} - @if($l->unit_eselon3 == null) {{$l->unit_eselon2}} @else {{$l->unit_eselon3}} @endif</li>
                                @endforeach
                            @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="widget-box shadow-sm widget-primary">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Top 3 Unit Kerja Eselon 3</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @foreach($top3_es3 as $t)
                            <li>{{$t->unit_eselon3}} ({{round($t->prs_jp,2)}}%)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="widget-box shadow-sm widget-danger">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-star"></i></span><h5>Bottom 3 Pegawai</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @if (sizeof($bottom3_peg)==0)
                                <li>Data Tidak Tersedia</li>
                            @else
                                @foreach($bottom3_peg as $l)
                                <li>{{$l->nama}} - @if($l->unit_eselon3 == null) {{$l->unit_eselon2}} @else {{$l->unit_eselon3}} @endif</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="widget-box shadow-sm widget-danger">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Bottom 3 Unit Kerja Eselon 3</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @foreach($bottom3_es3 as $t)
                            <li>{{$t->unit_eselon3}} ({{round($t->prs_jp,2)}}%)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="widget-box shadow-sm">
                    <div class="widget-title">
                        <span class='icon'><i class="icon-exclamation-sign"></i></span><h5>Progress Unit Kerja Eselon 3</h5>
                    </div>
                    <div class="widget-content" style="height:350px;overflow-y:auto">
                        <ul class="unstyled">
                            @foreach ($jml_peg_jp_es3 as $i)
                            <li>
                                {{$i->unit_eselon3}}
                                <span class='pull-right strong'> {{$i->tot_jp}}% </span>
                                <div class="progress progress-striped @if($i->tot_jp <= 10) progress-danger @elseif($i->tot_jp <= 30) progress-warning @elseif($i->tot_jp >=90) progress-success @else progress-striped @endif">
                                    <div style='width: {{$i->tot_jp}}%' class='bar'></div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="widget-box shadow-sm">
                    <div class="widget-title">
                        <span class='icon'><i class="icon-dashboard"></i></span><h5>Komposisi Pengembangan Kompetensi</h5>
                    </div>
                    <div class="widget-content" style="height:350px;overflow-y:auto">
                        <canvas id="doughnut"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-box shadow-sm">
            <div class="widget-title">
                <span class='icon'><i class="icon-exchange"></i></span><h5>Neighboorhood</h5>
            </div>
            <div class="widget-content"  style="height:350px;overflow-y:auto">
                <ul class="unstyled">
                    @foreach($progress_es2 as $s)
                        <li>
                            {{$s->unit_eselon2}}
                            <span class='pull-right strong'>{{($s->tot_jp == null) ? 0 : $s->tot_jp}}%</span>
                            <div class="progress progress-striped @if($s->tot_jp <= 10) progress-danger @elseif($s->tot_jp <= 30) progress-warning @elseif($s->tot_jp >=90) progress-success @else progress-striped @endif">
                                <div style='width: {{$s->tot_jp}}%' class='bar'></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/chart/Chart.js')}}"></script>
<script src="{{asset('js/chart/Chart.min.js')}}"></script>
<script src="{{asset('js/chart/Chart.bundle.js')}}"></script>
<script src="{{asset('js/chart/Chart.bundle.min.js')}}"></script>
<script>
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [@foreach($jenis_jp as $j)'{{$j->jml}}',@endforeach],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.purple,
                    window.chartColors.grey,
                ],
                label: 'Dataset 1'
            }],
            labels: [@foreach($jenis_jp as $j)'{{$j->jenis_pengembangan}}',@endforeach]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: "@if(sizeof($jenis_jp)== 0) Data Tidak Tersedia @else {{$satkers[0]->unit_kerja}} @endif"
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };
    window.onload = function() {
        var ctx = document.getElementById('doughnut').getContext('2d');
        window.myDoughnut = new Chart(ctx, config);
		};
</script>
@endsection
