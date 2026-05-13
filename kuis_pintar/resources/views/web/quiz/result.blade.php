@extends('web.layouts.app')

@section('title','Hasil Quiz')
@section('topbar_title','Hasil Quiz')

@section('content')

<style>

    *{
        box-sizing:border-box;
    }

    body{
        background:#f7f8fc;
    }

    .page-heading{
        margin-bottom:22px;
    }

    .page-heading h1{
        margin:0;
        font-size:46px;
        font-weight:900;
        color:#111827;
        line-height:1;
        letter-spacing:-1px;
    }

    .tabs{
        display:flex;
        align-items:center;
        gap:18px;
        margin-top:14px;
    }

    .tabs a{
        text-decoration:none;
        font-size:18px;
        font-weight:900;
        color:#6b7280;
        padding-bottom:7px;
        border-bottom:4px solid transparent;
        transition:.2s;
    }

    .tabs a:hover{
        color:#111827;
    }

    .tabs a.active{
        color:#111827;
        border-bottom-color:#111827;
    }

    .result-panel{
        background:#ffffff;
        border-radius:34px;
        padding:26px;
        box-shadow:
            0 10px 0 rgba(214,208,182,.55),
            0 22px 35px rgba(0,0,0,.08);
    }

    .panel-top{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
        margin-bottom:24px;
    }

    .panel-top h2{
        margin:0;
        font-size:32px;
        font-weight:900;
        color:#111827;
    }

    .panel-top p{
        margin:8px 0 0;
        color:#6b7280;
        font-size:15px;
        font-weight:800;
    }

    /* KKM BADGE */

    .kkm-badge{
        display:flex;
        align-items:center;
        gap:8px;

        padding:10px 16px;

        border-radius:18px;

        background:#ffeaa7;
        color:#7c5a00;

        font-size:15px;
        font-weight:900;

        white-space:nowrap;

        box-shadow:0 5px 0 #e7c96f;
    }

    .kkm-icon{
        font-size:16px;
    }

    /* FILTER */

    .filter-wrapper{
        display:grid;
        grid-template-columns:1fr 1fr 1fr;
        gap:16px;
        margin-bottom:22px;
    }

    .filter-box{
        background:linear-gradient(
            135deg,
            #eef2ff,
            #ffffff
        );

        padding:14px;

        border-radius:20px;

        box-shadow:
            0 5px 0 rgba(199,210,254,.7),
            0 10px 18px rgba(0,0,0,.04);

        transition:.2s;
    }

    .filter-box:hover{
        transform:translateY(-1px);
    }

    .filter-label{
        display:flex;
        align-items:center;
        gap:6px;

        margin-bottom:8px;

        font-size:13px;
        font-weight:900;
        color:#374151;
    }

    .filter-icon{
        font-size:15px;
        line-height:1;
    }

    .filter-input,
    .filter-select{
        width:100%;
        border:none;
        outline:none;

        background:#f9fafb;

        padding:12px 14px;

        border-radius:15px;

        font-size:14px;
        font-weight:800;

        color:#111827;

        transition:.2s;

        box-shadow:inset 0 0 0 2px transparent;
    }

    .filter-input:focus,
    .filter-select:focus{
        background:#fff;
        box-shadow:inset 0 0 0 2px #c7d2fe;
    }

    .filter-input::placeholder{
        color:#9ca3af;
    }

    /* TABLE */

    .table-wrap{
        width:100%;
        overflow-x:auto;
        border-radius:24px;
    }

    .result-table{
        width:100%;
        border-collapse:collapse;
        background:#fff;
        overflow:hidden;
    }

    .result-table thead th{
        background:#c7d9ff;
        color:#111827;
        padding:18px 14px;
        text-align:left;
        font-size:15px;
        font-weight:900;
    }

    .result-table tbody td{
        padding:20px 14px;
        font-size:15px;
        font-weight:800;
        color:#111827;
        border-bottom:1px solid #edf2f7;
        vertical-align:middle;
    }

    .result-table tbody tr{
        transition:.2s;
    }

    .result-table tbody tr:hover{
        background:#fffdf5;
    }

    .score{
        display:inline-flex;
        align-items:center;
        justify-content:center;

        min-width:64px;
        height:48px;

        border-radius:18px;

        font-size:20px;
        font-weight:900;
    }

    .status{
        display:inline-flex;
        align-items:center;
        justify-content:center;

        padding:12px 18px;

        border-radius:999px;

        font-size:14px;
        font-weight:900;

        white-space:nowrap;
    }

    .passed{
        background:#d8f3df;
        color:#166534;
    }

    .warning{
        background:#fff1b8;
        color:#8a5a00;
    }

    .failed{
        background:#ffd7e2;
        color:#9f1239;
    }

    .empty{
        text-align:center;
        padding:40px !important;
        font-size:16px !important;
        color:#6b7280 !important;
    }

    .student-name{
        font-weight:900;
    }

    .kategori-badge{
        display:inline-flex;
        align-items:center;
        gap:6px;

        padding:10px 14px;

        border-radius:999px;

        background:#eef2ff;
        color:#4338ca;

        font-size:13px;
        font-weight:900;
    }

    @media(max-width:1100px){

        .result-table{
            min-width:1050px;
        }

    }

    @media(max-width:860px){

        .page-heading h1{
            font-size:36px;
        }

        .result-panel{
            padding:18px;
            border-radius:24px;
        }

        .panel-top{
            flex-direction:column;
            align-items:flex-start;
        }

        .panel-top h2{
            font-size:26px;
        }

        .filter-wrapper{
            grid-template-columns:1fr;
        }

    }

</style>

<div class="page-heading">

    <h1>Quiz Matematika ✨</h1>

    <div class="tabs">
        <a href="{{ route('web.quiz.index') }}">
            Buat Quiz
        </a>

        <a href="{{ route('quiz.result') }}" class="active">
            Hasil Quiz
        </a>
    </div>

</div>

<div class="result-panel">

    <div class="panel-top">

        <div>
            <h2>Hasil Quiz Siswa 🎉</h2>

            <p>
                Pantau nilai siswa dengan tampilan seru dan penuh warna 🌈
            </p>
        </div>

        <div class="kkm-badge">
            <span class="kkm-icon">🎯</span>
            KKM: 75
        </div>

    </div>

    {{-- FILTER --}}
    <div class="filter-wrapper">

        <div class="filter-box">

            <div class="filter-label">
                <span class="filter-icon">🔎</span>
                Nama Siswa
            </div>

            <input
                type="text"
                id="searchName"
                class="filter-input"
                placeholder="Cari nama siswa..."
            >

        </div>

        <div class="filter-box">

            <div class="filter-label">
                <span class="filter-icon">🏆</span>
                Status Kelulusan
            </div>

            <select id="filterStatus" class="filter-select">

                <option value="">
                    Semua Status
                </option>

                <option value="Lulus">
                    Lulus
                </option>

                <option value="Tidak Lulus">
                    Tidak Lulus
                </option>

                <option value="Pas KKM">
                    Pas KKM
                </option>

            </select>

        </div>

        <div class="filter-box">

            <div class="filter-label">
                <span class="filter-icon">📚</span>
                Kategori Materi
            </div>

            <select id="filterKategori" class="filter-select">

                <option value="">
                    Semua Materi
                </option>

                <option value="Penjumlahan">
                    Penjumlahan
                </option>

                <option value="Pengurangan">
                    Pengurangan
                </option>

                <option value="Perkalian">
                    Perkalian
                </option>

                <option value="Pembagian">
                    Pembagian
                </option>

            </select>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-wrap">

        <table class="result-table">

            <thead>

                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Sekolah</th>
                    <th>Kategori</th>
                    <th>Waktu Pengerjaan</th>
                    <th>Durasi</th>
                    <th>Nilai</th>
                    <th>Status</th>
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

                    <tr class="result-row">

                        <td class="student-name">
                            {{ $result->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $result->user->kelas ?? '-' }}
                        </td>

                        <td>
                            {{ $result->user->sekolah ?? '-' }}
                        </td>

                        <td class="kategori-text">

                            <span class="kategori-badge">
                                📘 {{ $result->kategori ?? '-' }}
                            </span>

                        </td>

                        <td>

                            {{
                                $result->taken_at
                                ? \Carbon\Carbon::parse($result->taken_at)->format('d M Y, H:i')
                                : '-'
                            }}

                        </td>

                        <td>
                            -
                        </td>

                        <td>

                            <span class="score {{ $statusClass }}">
                                {{ $score }}
                            </span>

                        </td>

                        <td>

                            <span class="status {{ $statusClass }} status-text">
                                {{ $statusText }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="empty">
                            🚀 Belum ada hasil quiz nih~
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script>

    const searchName = document.getElementById('searchName');
    const filterStatus = document.getElementById('filterStatus');
    const filterKategori = document.getElementById('filterKategori');

    const rows = document.querySelectorAll('.result-row');

    function filterTable() {

        const nameValue =
            searchName.value.toLowerCase();

        const statusValue =
            filterStatus.value.toLowerCase();

        const kategoriValue =
            filterKategori.value.toLowerCase();

        rows.forEach(row => {

            const studentName =
                row.querySelector('.student-name')
                .textContent
                .toLowerCase();

            const statusText =
                row.querySelector('.status-text')
                .textContent
                .toLowerCase()
                .trim();

            const kategoriText =
                row.querySelector('.kategori-text')
                .textContent
                .toLowerCase();

            const matchName =
                studentName.includes(nameValue);

            const matchStatus =
                statusValue === '' ||
                statusText === statusValue;

            const matchKategori =
                kategoriValue === '' ||
                kategoriText.includes(kategoriValue);

            if (
                matchName &&
                matchStatus &&
                matchKategori
            ) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    }

    searchName.addEventListener(
        'keyup',
        filterTable
    );

    filterStatus.addEventListener(
        'change',
        filterTable
    );

    filterKategori.addEventListener(
        'change',
        filterTable
    );

</script>

@endsection
