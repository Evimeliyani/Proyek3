@extends('web.layouts.app')

@section('title','Quiz - Kuis Pintar')
@section('topbar_title','Quiz')

@section('content')

<style>
    .page-heading{
        margin-bottom:18px;
    }

    .page-heading h1{
        margin:0;
        font-size:42px;
        font-weight:900;
        color:#111827;
        line-height:1;
        letter-spacing:-1px;
    }

    .tabs{
        display:flex;
        align-items:center;
        gap:16px;
        margin-top:12px;
    }

    .tabs a{
        text-decoration:none;
        font-size:17px;
        font-weight:900;
        color:#6b7280;
        padding-bottom:6px;
        border-bottom:4px solid transparent;
        line-height:1;
    }

    .tabs a.active{
        color:#111827;
        border-bottom-color:#111827;
    }

    .hero{
        background: rgba(255,255,255,.60);
        border-radius:24px;
        padding:18px 22px;
        box-shadow:
            0 8px 0 rgba(214,208,182,.55),
            0 18px 24px rgba(0,0,0,.08);
        display:flex;
        align-items:center;
        gap:16px;
    }

    .hero-badge{
        width:60px;
        height:60px;
        border-radius:18px;
        background:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:30px;
        box-shadow:0 6px 0 #e5e7eb;
    }

    .hero-title{
        font-size:24px;
        font-weight:900;
        margin:0;
        color:#111827;
    }

    .hero-sub{
        margin-top:4px;
        color:#6b7280;
        font-weight:800;
        font-size:14px;
    }

    .page-title{
        text-align:center;
        font-size:38px;
        font-weight:900;
        margin:26px 0 20px;
        color:#111827;
        letter-spacing:-1px;
    }

    .grid{
        display:grid;
        grid-template-columns:repeat(2, minmax(220px, 1fr));
        gap:22px;
    }

    .card{
        background:#fff;
        border-radius:28px;
        text-decoration:none;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:14px;
        min-height:155px;
        box-shadow:
            0 9px 0 rgba(214,208,182,.62),
            0 18px 24px rgba(0,0,0,.08);
        transition:.15s ease;
    }

    .card:hover{
        transform:translateY(-3px);
    }

    .card:active{
        transform:translateY(5px);
        box-shadow:
            0 4px 0 rgba(214,208,182,.62),
            0 10px 16px rgba(0,0,0,.08);
    }

    .icon{
        font-size:48px;
        line-height:1;
    }

    .label{
        font-size:20px;
        font-weight:900;
        text-align:center;
        color:#111827;
    }

    @media(max-width:860px){
        .page-heading h1{
            font-size:34px;
        }

        .tabs a{
            font-size:15px;
        }

        .page-title{
            font-size:30px;
        }

        .grid{
            grid-template-columns:1fr;
        }

        .card{
            min-height:140px;
        }
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

<div class="page-heading">
    <h1>Quiz Matematika</h1>

    <div class="tabs">
        <a href="{{ route('web.quiz.index') }}" class="active">Buat Quiz</a>
        <a href="{{ route('quiz.result') }}">Hasil Quiz</a>
    </div>
</div>

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
