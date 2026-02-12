@extends('web.layouts.app')

@section('title','Grafik')
@section('topbar_title','Grafik')

@section('content')
    <h1 style="margin:0 0 14px; font-size:42px; font-weight:900;">Grafik</h1>

    <div style="background:#fff; border-radius:16px; box-shadow:0 10px 18px rgba(0,0,0,.12); overflow:hidden;">
        <div style="padding:18px 18px 10px; font-weight:900; font-size:20px;">Daftar Siswa</div>

        <div style="overflow:auto;">
            <table style="width:100%; border-collapse:collapse; min-width:520px;">
                <thead>
                    <tr style="background:rgba(188,209,255,.45);">
                        <th style="text-align:left; padding:14px; border-top:1px solid rgba(0,0,0,.12);">Nama</th>
                        <th style="text-align:left; padding:14px; border-top:1px solid rgba(0,0,0,.12);">Lihat grafik pengembangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr style="border-top:1px solid rgba(0,0,0,.12);">
                            <td style="padding:14px; font-weight:800;">{{ $u->name }}</td>
                            <td style="padding:14px;">
                                <a href="{{ route('web.grafik.show', $u->id) }}"
                                   style="display:inline-block; padding:12px 18px; background:#ffb48a; border-radius:16px; font-weight:900; text-decoration:none;">
                                    Lihat selengkapnya
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding:14px;">Belum ada data nilai quiz.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
