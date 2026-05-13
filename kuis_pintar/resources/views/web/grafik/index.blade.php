@extends('web.layouts.app')

@section('title','Grafik')
@section('topbar_title','Grafik')

@section('content')

<style>

    .page-title{
        margin:0 0 18px;
        font-size:48px;
        font-weight:900;
        color:#111827;
        letter-spacing:-1px;
    }

    .student-panel{
        background:#ffffff;
        border-radius:34px;
        overflow:hidden;

        box-shadow:
            0 10px 0 rgba(214,208,182,.5),
            0 22px 35px rgba(0,0,0,.08);
    }

    .panel-header{
        padding:24px 26px 18px;
    }

    .panel-header h2{
        margin:0;
        font-size:34px;
        font-weight:900;
        color:#111827;
    }

    .panel-header p{
        margin:8px 0 0;
        font-size:15px;
        font-weight:700;
        color:#6b7280;
    }

    .table-wrap{
        overflow:auto;
    }

    .student-table{
        width:100%;
        border-collapse:collapse;
        min-width:700px;
    }

    .student-table thead tr{
        background:#c7d9ff;
    }

    .student-table th{
        padding:18px 20px;
        text-align:left;
        font-size:16px;
        font-weight:900;
        color:#111827;
    }

    .student-table td{
        padding:22px 20px;
        border-top:1px solid #edf2f7;
        font-size:16px;
        font-weight:800;
        color:#111827;
    }

    .student-table tbody tr{
        transition:.2s;
    }

    .student-table tbody tr:hover{
        background:#fffdf5;
    }

    .student-name{
        display:flex;
        align-items:center;
        gap:12px;
    }

    .student-avatar{
        width:48px;
        height:48px;
        border-radius:16px;

        display:flex;
        align-items:center;
        justify-content:center;

        background:#ffe9b8;

        font-size:22px;

        box-shadow:0 5px 0 #efd58f;
    }

    .student-info h4{
        margin:0;
        font-size:18px;
        font-weight:900;
    }

    .student-info p{
        margin:4px 0 0;
        color:#6b7280;
        font-size:13px;
        font-weight:700;
    }

    .btn-detail{
        display:inline-flex;
        align-items:center;
        gap:8px;

        padding:12px 18px;

        background:#ffb48a;

        border-radius:18px;

        color:#111827;
        text-decoration:none;

        font-weight:900;
        font-size:15px;

        transition:.2s;

        box-shadow:0 6px 0 #ea986c;
    }

    .btn-detail:hover{
        transform:translateY(-2px);
    }

    .empty{
        padding:30px !important;
        text-align:center;
        color:#6b7280;
        font-size:15px;
        font-weight:800;
    }

    @media(max-width:860px){

        .page-title{
            font-size:38px;
        }

        .panel-header h2{
            font-size:28px;
        }

    }

</style>

<h1 class="page-title">
    Grafik 📈
</h1>

<div class="student-panel">

    <div class="panel-header">
        <h2>Daftar Siswa 🎓</h2>

        <p>
            Pantau perkembangan belajar siswa dengan tampilan visual yang lebih interaktif ✨
        </p>
    </div>

    <div class="table-wrap">

        <table class="student-table">

            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Lihat Grafik Pengembangan</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $u)

                    <tr>

                        <td>

                            <div class="student-name">

                                <div class="student-avatar">
                                    👦
                                </div>

                                <div class="student-info">
                                    <h4>{{ $u->name }}</h4>
                                    <p>
                                        Monitoring perkembangan quiz siswa
                                    </p>
                                </div>

                            </div>

                        </td>

                        <td>

                            <a href="{{ route('web.grafik.show', $u->id) }}"
                               class="btn-detail">

                                📊 Lihat Selengkapnya

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="2" class="empty">
                            🚀 Belum ada data nilai quiz.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
