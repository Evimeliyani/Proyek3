@extends('web.layouts.app')

@section('title','Hasil Quiz')
@section('topbar_title','Hasil Quiz')

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

    .result-panel{
        background:#fff;
        border-radius:28px;
        padding:22px;
        box-shadow:
            0 9px 0 rgba(214,208,182,.62),
            0 18px 24px rgba(0,0,0,.08);
    }

    .panel-top{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        margin-bottom:18px;
    }

    .panel-top h2{
        margin:0;
        font-size:28px;
        font-weight:900;
        color:#111827;
    }

    .panel-top p{
        margin:4px 0 0;
        color:#6b7280;
        font-size:14px;
        font-weight:800;
    }

    .kkm-badge{
        padding:12px 18px;
        border-radius:18px;
        background:#fff0b3;
        color:#7a5710;
        font-size:15px;
        font-weight:900;
        white-space:nowrap;
        box-shadow:0 5px 0 #e6cd78;
    }

    .table-wrap{
        width:100%;
        overflow-x:auto;
        border-radius:22px;
    }

    .result-table{
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
        background:#fff;
        font-size:13px;
    }

    .result-table th{
        background:#c7d9ff;
        padding:13px 10px;
        text-align:left;
        font-size:13px;
        font-weight:900;
        color:#111827;
        border-bottom:1px solid #b8cafa;
    }

    .result-table td{
        padding:13px 10px;
        font-size:13px;
        font-weight:800;
        color:#111827;
        background:#fff;
        border-bottom:1px solid #eef2f7;
        vertical-align:middle;
        word-break:break-word;
    }

    .result-table tbody tr:hover td{
        background:#fffdf5;
    }

    .col-name{ width:16%; }
    .col-kelas{ width:8%; }
    .col-sekolah{ width:10%; }
    .col-kategori{ width:13%; }
    .col-waktu{ width:18%; }
    .col-durasi{ width:8%; }
    .col-nilai{ width:8%; }
    .col-status{ width:12%; }

    .score{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:42px;
        height:34px;
        border-radius:12px;
        font-weight:900;
        font-size:13px;
    }

    .status{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:8px 11px;
        border-radius:999px;
        font-size:12px;
        font-weight:900;
        white-space:nowrap;
    }

    .passed{
        background:#d8f3df;
        color:#166534;
    }

    .warning{
        background:#fff0b3;
        color:#7a5710;
    }

    .failed{
        background:#ffd3df;
        color:#9f1239;
    }

    .empty{
        text-align:center;
        padding:24px !important;
        color:#6b7280 !important;
    }

    @media(max-width:1100px){
        .result-table{
            min-width:980px;
            table-layout:auto;
        }
    }

    @media(max-width:860px){
        .page-heading h1{
            font-size:34px;
        }

        .tabs a{
            font-size:15px;
        }

        .result-panel{
            padding:16px;
            border-radius:24px;
        }

        .panel-top{
            flex-direction:column;
            align-items:flex-start;
        }

        .panel-top h2{
            font-size:24px;
        }
    }
</style>

<div class="page-heading">
    <h1>Quiz Matematika</h1>

    <div class="tabs">
        <a href="{{ route('web.quiz.index') }}">Buat Quiz</a>
        <a href="{{ route('quiz.result') }}" class="active">Hasil Quiz</a>
    </div>
</div>

<div class="result-panel">

    <div class="panel-top">
        <div>
            <h2>Hasil Quiz Siswa</h2>
            <p>Daftar nilai, waktu pengerjaan, dan status kelulusan siswa 🎉</p>
        </div>

        <div class="kkm-badge">KKM: 75</div>
    </div>

    <div class="table-wrap">
        <table class="result-table">
            <thead>
                <tr>
                    <th class="col-name">Nama Siswa</th>
                    <th class="col-kelas">Kelas</th>
                    <th class="col-sekolah">Sekolah</th>
                    <th class="col-kategori">Kategori</th>
                    <th class="col-waktu">Waktu Pengerjaan</th>
                    <th class="col-durasi">Durasi</th>
                    <th class="col-nilai">Nilai</th>
                    <th class="col-status">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($results as $result)
                    @php
                        $score = $result->score ?? 0;

                        if ($score > 75) {
                            $statusText = 'Lulus';
                            $statusClass = 'passed';
                        } elseif ($score == 75) {
                            $statusText = 'Pas KKM';
                            $statusClass = 'warning';
                        } else {
                            $statusText = 'Tidak Lulus';
                            $statusClass = 'failed';
                        }
                    @endphp

                    <tr>
                        <td>{{ $result->user->name ?? '-' }}</td>
                        <td>{{ $result->user->kelas ?? '-' }}</td>
                        <td>{{ $result->user->sekolah ?? '-' }}</td>
                        <td>{{ $result->kategori ?? '-' }}</td>
                        <td>
                            {{ $result->taken_at ? \Carbon\Carbon::parse($result->taken_at)->format('d M Y, H:i') : '-' }}
                        </td>
                        <td>-</td>
                        <td>
                            <span class="score {{ $statusClass }}">{{ $score }}</span>
                        </td>
                        <td>
                            <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            Belum ada hasil quiz.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
