@extends('web.layouts.app')

@section('title','Detail Grafik')
@section('topbar_title','Detail Grafik')

@section('content')

@php

    $chartData = collect($data)->values()->toArray();

    $highest = collect($chartData)->max();
    $lowest = collect($chartData)->min();

    $highestIndex = array_search($highest, $chartData);
    $lowestIndex = array_search($lowest, $chartData);

    $bestCategory = $labels[$highestIndex] ?? '-';
    $weakCategory = $labels[$lowestIndex] ?? '-';

    $average = count($chartData)
        ? round(array_sum($chartData) / count($chartData))
        : 0;

    $consistency =
        ($highest - $lowest <= 10)
        ? 'Stabil'
        : 'Belum Stabil';

@endphp

<style>

    .top-section{
        display:flex;
        align-items:center;
        gap:14px;
        margin-bottom:18px;
        flex-wrap:wrap;
    }

    .btn-back{
        display:inline-flex;
        align-items:center;
        gap:8px;

        padding:10px 16px;

        border-radius:16px;

        background:#c7d9ff;

        text-decoration:none;

        color:#111827;

        font-weight:900;

        box-shadow:0 5px 0 #adc3f7;

        transition:.2s;
    }

    .btn-back:hover{
        transform:translateY(-2px);
    }

    .page-title{
        margin:0;
        font-size:34px;
        font-weight:900;
        color:#111827;
        letter-spacing:-1px;
    }

    .main-card{
        background:#fff;
        border-radius:28px;
        padding:22px;

        box-shadow:
            0 10px 0 rgba(214,208,182,.5),
            0 18px 30px rgba(0,0,0,.08);
    }

    .card-title{
        display:flex;
        align-items:center;
        gap:10px;

        margin-bottom:18px;

        font-size:22px;
        font-weight:900;
        color:#111827;
    }

    .chart-container{
        position:relative;
        width:100%;
        height:420px;
    }

    /* ANALYSIS */

    .analysis-wrapper{
        margin-top:22px;

        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:16px;
    }

    .analysis-item{
        padding:18px;
        border-radius:22px;

        border:2px dashed transparent;

        transition:.2s;
    }

    .analysis-item:hover{
        transform:translateY(-2px);
    }

    .analysis-item h4{
        margin:0 0 10px;

        font-size:16px;
        font-weight:900;
        color:#111827;

        line-height:1.4;
    }

    .analysis-item p{
        margin:0;

        font-size:14px;
        line-height:1.8;

        color:#4b5563;
        font-weight:700;
    }

    .good{
        background:#dcfce7;
        border-color:#86efac;
    }

    .danger{
        background:#ffe4e6;
        border-color:#fda4af;
    }

    .info{
        background:#eef2ff;
        border-color:#c7d2fe;
    }

    .warning{
        background:#fff7ed;
        border-color:#fdba74;
    }

    @media(max-width:1100px){

        .analysis-wrapper{
            grid-template-columns:1fr 1fr;
        }

    }

    @media(max-width:700px){

        .analysis-wrapper{
            grid-template-columns:1fr;
        }

        .page-title{
            font-size:28px;
        }

        .chart-container{
            height:320px;
        }

    }

</style>

<div class="top-section">

    <a href="{{ route('web.grafik.index') }}"
       class="btn-back">

        ← Kembali

    </a>

    <h1 class="page-title">
        Grafik Pengembangan {{ $user->name }} ✨
    </h1>

</div>

<div class="main-card">

    {{-- CHART --}}
    <div class="card-title">
        📈 Grafik Per Kategori
    </div>

    <div class="chart-container">
        <canvas id="chartNilai"></canvas>
    </div>

    {{-- ANALISIS --}}
    <div class="analysis-wrapper">

        <div class="analysis-item good">

            <h4>
                🏆 Kategori Terkuat
            </h4>

            <p>
                {{ $user->name }} paling unggul pada materi
                <b>{{ $bestCategory }}</b>
                dengan rata-rata nilai
                <b>{{ $highest }}</b>.
            </p>

        </div>

        <div class="analysis-item danger">

            <h4>
                📚 Perlu Pendampingan
            </h4>

            <p>
                Materi
                <b>{{ $weakCategory }}</b>
                masih perlu latihan tambahan karena rata-rata nilai berada di
                <b>{{ $lowest }}</b>.
            </p>

        </div>

        <div class="analysis-item info">

            <h4>
                📊 Konsistensi Belajar
            </h4>

            <p>
                Nilai rata-rata keseluruhan
                <b>{{ $average }}</b>.

                Status belajar:
                <b>{{ $consistency }}</b>.
            </p>

        </div>

        <div class="analysis-item warning">

            <h4>
                💡 Rekomendasi Guru
            </h4>

            <p>
                Fokus latihan mingguan pada
                <b>{{ $weakCategory }}</b>
                dengan quiz rutin dan latihan visual interaktif.
            </p>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const labels = @json($labels);
    const data = @json($chartData);

    const ctx = document.getElementById('chartNilai');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels,

            datasets: [{

                label: 'Rata-rata Nilai',

                data,

                tension: 0.4,

                pointRadius: 6,

                pointHoverRadius: 8,

                borderWidth: 4,

                borderColor: '#5aa9ff',

                backgroundColor: 'rgba(90,169,255,.18)',

                fill: true,

                pointBackgroundColor: '#ffffff',

                pointBorderColor: '#5aa9ff',

                pointBorderWidth: 4,

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    labels: {

                        color:'#374151',

                        font:{
                            size:14,
                            weight:'bold'
                        }

                    }

                }

            },

            scales: {

                y: {

                    min:0,
                    max:100,

                    ticks:{

                        stepSize:10,

                        color:'#6b7280',

                        font:{
                            weight:'bold'
                        }

                    },

                    grid:{
                        color:'rgba(0,0,0,.06)'
                    }

                },

                x: {

                    ticks:{

                        color:'#374151',

                        font:{
                            size:14,
                            weight:'bold'
                        }

                    },

                    grid:{
                        display:false
                    }

                }

            }

        }

    });

</script>

@endsection
