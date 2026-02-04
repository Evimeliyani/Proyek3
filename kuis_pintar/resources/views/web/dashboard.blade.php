@extends('web.layouts.app')

@section('title','Dashboard - Kuis Pintar')
@section('topbar_title','Dashboard')

@section('content')
<style>
    .heading h1{ margin:0; font-size: 34px; line-height: 1.1; }
    .heading .sub{ margin-top:6px; color: var(--muted); font-size: 14px; font-weight: 700; }

    .stat-row{
        display:grid;
        grid-template-columns: repeat(3, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 18px;
    }
    .stat-card{
        border-radius: var(--radius);
        padding: 16px;
        box-shadow: var(--card-shadow);
        display:flex;
        align-items:center;
        min-height: 88px;
    }
    .stat-left{ display:flex; align-items:center; gap: 12px; }
    .stat-icon{
        width: 54px; height: 54px; border-radius: 14px;
        background: rgba(255,255,255,.55);
        display:flex; align-items:center; justify-content:center;
        font-size: 28px;
    }
    .stat-number{ font-size: 34px; font-weight: 900; line-height: 1; }
    .stat-label{ margin-top: 6px; font-size: 13px; color: rgba(0,0,0,.7); font-weight: 800; }

    .card-pink{ background: #ffd6da; }
    .card-yellow{ background: #fff4a8; }
    .card-green{ background: #d7ffd5; }

    .section-title{ margin: 22px 0 12px; font-size: 22px; font-weight: 900; }

    .chart-card{
        background: #fff;
        border-radius: 18px;
        box-shadow: var(--soft-shadow);
        padding: 14px 14px 10px;
        overflow:auto;
        border: 1px solid rgba(0,0,0,.06);
    }
    .chart-wrap{ min-width: 760px; }

    @media (max-width: 860px){
        .heading h1{ font-size: 26px; }
        .stat-row{ grid-template-columns: 1fr; }
        .chart-wrap{ min-width: 640px; }
    }
</style>

<div class="heading">
    <h1>Dashboard</h1>
    <div class="sub">{{ now()->translatedFormat('l, d F Y') }}</div>
</div>

<section class="stat-row">
    <div class="stat-card card-pink">
        <div class="stat-left">
            <div class="stat-icon">📚</div>
            <div>
                <div class="stat-number">{{ $kategori }}</div>
                <div class="stat-label">Kategori Materi</div>
            </div>
        </div>
    </div>

    <div class="stat-card card-yellow">
        <div class="stat-left">
            <div class="stat-icon">📋</div>
            <div>
                <div class="stat-number">{{ $totalQuiz }}</div>
                <div class="stat-label">Jumlah Quiz</div>
            </div>
        </div>
    </div>

    <div class="stat-card card-green">
        <div class="stat-left">
            <div class="stat-icon">🧑‍🤝‍🧑</div>
            <div>
                <div class="stat-number">{{ $totalMurid }}</div>
                <div class="stat-label">Jumlah Murid</div>
            </div>
        </div>
    </div>
</section>

<h2 class="section-title">Grafik Quiz Matematika</h2>

<section class="chart-card">
    <div class="chart-wrap">
        <svg viewBox="0 0 980 420" width="980" height="420" aria-label="Chart">
            <rect x="10" y="10" width="960" height="380" rx="18" fill="#fff" stroke="#e9e9e9"/>
            <g stroke="#efefef" stroke-width="2">
                <line x1="90" y1="330" x2="930" y2="330"/>
                <line x1="90" y1="270" x2="930" y2="270"/>
                <line x1="90" y1="210" x2="930" y2="210"/>
                <line x1="90" y1="150" x2="930" y2="150"/>
                <line x1="90" y1="90"  x2="930" y2="90"/>
            </g>
            <g fill="#222" font-size="18" font-family="Arial">
                <text x="45" y="336">70</text>
                <text x="45" y="276">75</text>
                <text x="45" y="216">80</text>
                <text x="45" y="156">85</text>
                <text x="45" y="96">90</text>
            </g>
            <g fill="#222" font-size="20" font-family="Arial">
                <text x="140" y="370">Penjumlahan</text>
                <text x="360" y="370">Pengurangan</text>
                <text x="585" y="370">Perkalian</text>
                <text x="780" y="370">Pembagian</text>
            </g>
            <polyline fill="none" stroke="#b8c9f0" stroke-width="6"
                      points="200,120 420,180 640,250 830,210"
                      stroke-linecap="round" stroke-linejoin="round" />
            <g fill="#2b60ff" stroke="#2b60ff">
                <circle cx="200" cy="120" r="10"/>
                <circle cx="420" cy="180" r="10"/>
                <circle cx="640" cy="250" r="10"/>
                <circle cx="830" cy="210" r="10"/>
            </g>
        </svg>
    </div>
</section>
@endsection
