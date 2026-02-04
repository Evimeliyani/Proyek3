@extends('web.layouts.app')

@section('title','Quiz - Kuis Pintar')
@section('topbar_title','Quiz')

@section('content')
<style>
    .hero{
        background: rgba(255,255,255,.55);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 16px;
        box-shadow: var(--soft-shadow);
        display:flex;
        align-items:center;
        gap: 14px;
    }
    .hero-badge{
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size: 28px;
        box-shadow: 0 10px 18px rgba(0,0,0,.10);
    }
    .hero-title{ font-size: 22px; font-weight: 900; margin:0; line-height: 1.1; }
    .hero-sub{ margin-top:6px; color: var(--muted); font-weight: 700; font-size: 13px; }

    .page-title{
        text-align:center;
        font-size: 34px;
        font-weight: 900;
        margin: 18px 0 16px;
    }

    .grid{
        display:grid;
        grid-template-columns: repeat(2, minmax(220px, 1fr));
        gap: 18px;
        margin-top: 10px;
    }

    .card{
        background:#fff;
        border-radius: 18px;
        box-shadow: var(--card-shadow);
        padding: 22px 18px;
        text-decoration:none;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap: 12px;
        min-height: 160px;
        border: 1px solid rgba(0,0,0,.06);
    }
    .card:hover{ transform: translateY(-2px); transition: .15s ease; }

    .icon{ font-size: 44px; line-height: 1; }
    .label{ font-size: 18px; font-weight: 900; text-align:center; }

    @media (max-width: 860px){
        .page-title{ font-size: 26px; }
        .grid{ grid-template-columns: 1fr; }
        .card{ min-height: 140px; }
    }
</style>

@php
    $icons = [
        'penjumlahan' => '➕',
        'pengurangan' => '➖',
        'perkalian'   => '✖️',
        'pembagian'   => '➗',
    ];
@endphp

<div class="hero">
    <div class="hero-badge">🧮</div>
    <div>
        <div class="hero-title">Quiz Matematika</div>
        <div class="hero-sub">Pilih materi untuk masuk ke detail quiz & soal</div>
    </div>
</div>

<div class="page-title">Mata Pelajaran</div>

<div class="grid">
    @foreach($quizzes as $q)
        <a class="card" href="{{ route('web.quiz.show', $q->slug) }}">
            <div class="icon">{{ $icons[$q->slug] ?? '🧩' }}</div>
            <div class="label">{{ $q->title }}</div>
        </a>
    @endforeach
</div>
@endsection
