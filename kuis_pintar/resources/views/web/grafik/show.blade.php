@extends('web.layouts.app')

@section('title','Detail Grafik')
@section('topbar_title','Detail Grafik')

@section('content')
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
        <a href="{{ route('web.grafik.index') }}"
           style="display:inline-block; padding:10px 14px; border-radius:14px; background:rgba(188,209,255,.6); font-weight:900; text-decoration:none;">
            ← Kembali
        </a>

        <h1 style="margin:0; font-size:34px; font-weight:900;">
            Grafik Pengembangan: {{ $user->name }}
        </h1>
    </div>

    <div style="display:grid; grid-template-columns: 1.3fr .7fr; gap:16px;">
        <div style="background:#fff; border-radius:16px; box-shadow:0 10px 18px rgba(0,0,0,.12); padding:16px;">
            <div style="font-weight:900; font-size:18px; margin-bottom:10px;">Grafik Per Kategori</div>
            <div style="position:relative; width:100%; height:360px;">
                <canvas id="chartNilai"></canvas>
            </div>
        </div>

        <div style="background:#fff; border-radius:16px; box-shadow:0 10px 18px rgba(0,0,0,.12); padding:16px;">
            <div style="font-weight:900; font-size:18px; margin-bottom:10px;">Analisis AI</div>
            <div style="line-height:1.6; color:rgba(0,0,0,.75);">
                {!! nl2br(e($aiInsight)) !!}
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 860px){
            .container > div[style*="grid-template-columns"]{
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const data = @json($data);

        const ctx = document.getElementById('chartNilai');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data,
                    tension: 0.35,
                    pointRadius: 5,
                    borderWidth: 3,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });
    </script>
@endsection
