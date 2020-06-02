@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/chart/progress.css')}}">
<link rel="stylesheet" href="{{asset('css/chart/Chart.css')}}">
<link rel="stylesheet" href="{{asset('css/chart/Chart.min.css')}}">

<div class="card">
    <div class="card-body" style="background-color:#efefef">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box shadow-sm">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-ok"></i></span><h5>Progress</h5>
                    </div>
                    <div class="widget-content">
                        <ul class="unstyled">
                            <li>
                                {{$satkers[0]->unit_kerja}}
                                <span class='pull-right strong'>{{$satkers[0]->tot_jp}}%</span>
                                <div class="progress progress-striped @if($satkers[0]->tot_jp <= 10) progress-danger @elseif($satkers[0]->tot_jp <= 30) progress-warning @elseif($satkers[0]->tot_jp >=90) progress-success @else progress-striped @endif">
                                    <div style="width: {{$satkers[0]->tot_jp}}%" class='bar'></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
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
                                <li><a href="{{url('/kompetensi/detil', $l->nip)}}">{{$l->nama}} - @if($l->unit_eselon3 == null) {{$l->unit_eselon2}} @else {{$l->unit_eselon3}} @endif</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="widget-box shadow-sm widget-danger">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Bottom 3 Pegawai</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @if (sizeof($bottom3_peg)==0)
                            <li>Data Tidak Tersedia</li>
                        @else
                            @foreach($bottom3_peg as $l)
                            <li><a href="{{url('/kompetensi/detil', $l->nip)}}">{{$l->nama}} - @if($l->unit_eselon3 == null) {{$l->unit_eselon2}} @else {{$l->unit_eselon3}} @endif</a></li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
            <div class="col-sm-6">
                <div class="widget-box shadow-sm">
                    <div class="widget-title">
                        <span class='icon'><i class="icon-exchange"></i></span><h5>Neighboorhood</h5>
                    </div>
                    <div class="widget-content"  style="height:350px;overflow-y:auto">
                        <ul class="unstyled">
                            @foreach($neighbor as $s)
                                <li>
                                    {{$s->unit_eselon3}}
                                    <span class='pull-right strong'>{{$s->tot_jp}}%</span>
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
        grey: 'rgb(201, 203, 207)',
        pink: '#f54291',
        blue1: '#1f4068',
        cream: '#ffe0ac',
        turquoise: '#00a1ab',
        brown: '#6f0000',
        lightbrown: '#f1e3cb',
        redbrown: '#c81912',
        maroon: '#44000d',
        retro11: '#f40552',
        retro12: '#fc7e2f',
        retro13: '#c3edea',
        retro14: '#f8f3eb',
        winter11: '#1cb3c8',
        winter12: '#dfe2e2',
        winter13: '#738598',
        winter14: '#3c415e',
        ijo: '#a7d129'
    };
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [@foreach($jenis_jp as $j)'{{$j->jml}}',@endforeach],
                backgroundColor: [
                    window.chartColors.retro11,
                    window.chartColors.retro12,
                    window.chartColors.retro13,
                    window.chartColors.retro14,
                    window.chartColors.red,
                    window.chartColors.blue1,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.redbrown,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.winter11,
                    window.chartColors.winter12,
                    window.chartColors.winter13,
                    window.chartColors.winter14,
                    window.chartColors.ijo,
                    window.chartColors.purple,
                    window.chartColors.grey,
                    window.chartColors.maroon,
                    window.chartColors.pink,
                    window.chartColors.cream,
                    window.chartColors.turquoise,
                    window.chartColors.brown,
                    window.chartColors.lightbrown,
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
            }
        }
    };
    window.onload = function() {
        var ctx = document.getElementById('doughnut').getContext('2d');
        window.myDoughnut = new Chart(ctx, config);
		};
</script>
@endsection
