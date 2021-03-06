@extends('layouts.app')
@section('content')
<!-- css style -->
<link rel="stylesheet" href="{{asset('css/chart/progress.css')}}">
<link rel="stylesheet" href="{{asset('css/chart/Chart.css')}}">
<link rel="stylesheet" href="{{asset('css/chart/Chart.min.css')}}">

<div class="card">
    <div class="card-body" style="background-color:#efefef">
        <div class="row">
            <div class="col-sm-4">
                <div class="widget-box shadow-sm">
                    <div class="widget-title"><span class="icon"><i class="icon-ok"></i></span>
                        <h5>Pilih</h5>
                    </div>
                    <div class="widget-content" style='height:95px'>
                        <select name="region" id="region" class="form-control">
                            <option value="Indonesia">Indonesia</option>
                            @foreach($eselon2 as $es2)
                            <option value="{{$es2->unit_eselon2}}">{{$es2->unit_eselon2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="widget-box shadow-sm">
                    <div class="widget-title"><span class='icon'><i class="icon-arrow-right"></i></span>
                        <h5>Progress</h5>
                    </div>
                    <div id="progress" class="widget-content">
                        <ul class="unstyled">
                            @foreach($satkers as $s)
                            <li>
                                {{$s->unit_kerja}}
                                <span class='pull-right strong'>{{($s->tot_jp == null) ? 0 : $s->tot_jp}}%</span>
                                <div class="progress progress-striped @if($s->tot_jp <= 10) progress-danger @elseif($s->tot_jp <= 30) progress-warning @elseif($s->tot_jp >=90) progress-success @endif">
                                    <div style='width: {{$s->tot_jp}}%' class='bar'></div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="widget-box shadow-sm">
                    <div class="widget-title"><span class='icon'><i class="icon-exclamation-sign"></i></span>
                        <h5>Progress per Unit Kerja</h5>
                    </div>
                    <div id="progressPerUnit" class="widget-content" style="height:350px;overflow-y:auto">
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
            <div class="col-sm-6">
                <div class="widget-box shadow-sm">
                    <div class="widget-title"><span class='icon'><i class="icon-dashboard"></i></span>
                        <h5>Komposisi Pengembangan Kompetensi</h5>
                    </div>
                    <div class="widget-content" style="height:350px;overflow-y:auto">
                        <canvas id="doughnut"></canvas>
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
                    <div id="top3_peg" class="widget-content text-center">
                        <ul class="unstyled">
                            @if(sizeof($top3_peg)==0)
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
                        <span class="icon"><i class="icon-star"></i></span><h5>Bottom 3 Pegawai</h5>
                    </div>
                    <div id="bottom3_peg" class="widget-content text-center">
                        <ul class="unstyled">
                            @if(sizeof($bottom3_peg)==0)
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
            <div id="top3_es2" class="col-sm-3">
                <div class="widget-box shadow-sm widget-primary">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Top 3 Unit Kerja Eselon 2</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @foreach($top3_es2 as $t)
                            <li>{{$t->unit_eselon2}} ({{round($t->prs_jp,2)}}%)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div id="top3_es3_col" class="col-sm-3">
                <div class="widget-box shadow-sm widget-primary">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Top 3 Unit Kerja Eselon 3</h5>
                    </div>
                    <div id="top3_es3" class="widget-content text-center">
                        <ul class="unstyled">
                            @foreach($top3_es3 as $t)
                            <li>{{$t->unit_eselon3}} ({{round($t->prs_jp,2)}}%)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div id="bottom3_es2" class="col-sm-3">
                <div class="widget-box shadow-sm widget-danger">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Bottom 3 Unit Kerja Eselon 2</h5>
                    </div>
                    <div class="widget-content text-center">
                        <ul class="unstyled">
                            @foreach($bottom3_es2 as $t)
                            <li>{{$t->unit_eselon2}} ({{round($t->prs_jp,2)}}%)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div id="bottom3_es3_col" class="col-sm-3">
                <div class="widget-box shadow-sm widget-danger">
                    <div class="widget-title">
                        <span class="icon"><i class="icon-building"></i></span><h5>Bottom 3 Unit Kerja Eselon 3</h5>
                    </div>
                    <div id="bottom3_es3" class="widget-content text-center">
                        <ul class="unstyled">
                            @foreach($bottom3_es3 as $t)
                            <li>{{$t->unit_eselon3}} ({{round($t->prs_jp,2)}}%)</li>
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
                data: [@foreach($komposisi_plt as $j)'{{$j->jml}}',@endforeach],
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
            labels: [@foreach($komposisi_plt as $j)'{{$j->jenis_pengembangan}}',@endforeach]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: "@if(sizeof($komposisi_plt)== 0) Data Tidak Tersedia @else {{$satkers[0]->unit_kerja}} @endif"
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
<script>
    document.getElementById('region').addEventListener('change', function(){
        var value = $(this).val();
        var _token = $('input[name="_token"').val();
        if (value != 'Indonesia') {
            $.ajax({
                url: "{{url('/dashboard/progressEselon2')}}",
                type: "get",
                data: {value: value, _token: _token},
                success: function(result){
                    $('#progress').html(result);
                }
            });
            $.ajax({
                url: "{{url('/dashboard/progressPerUnit')}}",
                type: "get",
                data: {value: value, _token: _token},
                success: function(result){
                    $('#progressPerUnit').html(result);
                }
            });
            $.ajax({
                url: "{{url('/dashboard/komposisiJP')}}",
                type: 'get',
                data: {value: value, _token: _token},
                success: function(result){
                    var data = [];
                    var label = [];
                    result.forEach(item => {
                        data.push(item.jml);
                        label.push(item.jenis_pengembangan);
                    });
                    window.myDoughnut.data.datasets.forEach(dataset => {
                        dataset.data = data;
                    });
                    if (data.length == 0) {
                        window.myDoughnut.options.title.text = "Data Tidak Tersedia";
                    } else {
                        window.myDoughnut.options.title.text = value;
                    }
                    window.myDoughnut.data.labels = label;
                    window.myDoughnut.update();
                }
            });
            $.ajax({
                url: "{{url('/dashboard/top3_peg')}}",
                type: "get",
                data: {value: value, _token: _token},
                success: function(result){
                    $('#top3_peg').html(result);
                }
            });
            $.ajax({
                url: "{{url('/dashboard/bottom3_peg')}}",
                type: "get",
                data: {value: value, _token: _token},
                success: function(result){
                    $('#bottom3_peg').html(result);
                }
            });
            if (document.getElementById("top3_es2")) {
                document.getElementById("top3_es2").remove();
                document.getElementById("top3_es3_col").className = "col-sm-6";
            }
            if (document.getElementById("bottom3_es2")) {
                document.getElementById("bottom3_es2").remove();
                document.getElementById("bottom3_es3_col").className = "col-sm-6"
            }
            $.ajax({
                url: "{{url('/dashboard/top3_es3')}}",
                type: "get",
                data: {value: value, _token: _token},
                success: function(result){
                    $('#top3_es3').html(result);
                }
            });
            $.ajax({
                url: "{{url('/dashboard/bottom3_es3')}}",
                type: "get",
                data: {value: value, _token: _token},
                success: function(result){
                    $('#bottom3_es3').html(result);
                }
            });
        } else {
            window.location.href = "{{url('/dashboard')}}";
        }
    })
</script>
@endsection
