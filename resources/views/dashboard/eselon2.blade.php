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
                        BPS Propinsi Jawa Timur
                        <span class='pull-right strong'>20%</span>
                        <div class="progress progress-striped progress-warning">
                            <div style='width: 20%' class='bar'></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="widget-box shadow-sm pull-left" style="width:49.5%;">
            <div class="widget-title">
                <span class='icon'><i class="icon-exclamation-sign"></i></span><h5>Progress per Satuan Kerja</h5>
            </div>
            <div class="widget-content" style="height:350px;overflow-y:auto">
                <ul class="unstyled">
                    <li>
                        Kabupaten Gresik
                        <span class='pull-right strong'>100%</span>
                        <div class="progress progress-striped progress-success">
                            <div style='width: 100%' class='bar'></div>
                        </div>
                    </li>
                    <li>
                        Kabupaten Mojokerto
                        <span class='pull-right strong'>80%</span>
                        <div class="progress progress-striped">
                            <div style='width: 80%' class='bar'></div>
                        </div>
                    </li>
                    <li>
                        Kabupaten Lamongan
                        <span class='pull-right strong'>60%</span>
                        <div class="progress progress-striped">
                            <div style='width: 60%' class='bar'></div>
                        </div>
                    </li>
                    <li>
                        Kabupaten Sidoarjo
                        <span class='pull-right strong'>40%</span>
                        <div class="progress progress-striped">
                            <div style='width: 40%' class='bar'></div>
                        </div>
                    </li>
                    <li>
                        Kota Surabaya
                        <span class='pull-right strong'>20%</span>
                        <div class="progress progress-striped progress-warning">
                            <div style='width: 20%' class='bar'></div>
                        </div>
                    </li>
                    <li>
                        Kabupaten Malang
                        <span class='pull-right strong'>10%</span>
                        <div class="progress progress-striped progress-danger">
                            <div style='width: 10%' class='bar'></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="widget-box shadow-sm pull-right" style="width:49.5%;clear:none">
            <div class="widget-title">
                <span class='icon'><i class="icon-dashboard"></i></span><h5>Komposisi Pengembangan Kompetensi</h5>
            </div>
            <div class="widget-content" style="height:350px;overflow-y:auto">
                <canvas id="doughnut"></canvas>
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
                data: [30, 20, 50],
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
            labels: ['Tugas Belajar', 'Bimbingan Teknis', 'Seminar']
        },
        options: {
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'BPS Propinsi Jawa Timur'
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