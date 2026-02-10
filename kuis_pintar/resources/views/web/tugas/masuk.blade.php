@extends('web.layouts.app')

@section('title','Tugas Masuk')
@section('topbar_title','Tugas Masuk')

@section('styles')
<style>
  .page-title{font-size:38px;font-weight:900;margin:8px 0 6px;}
  .tabs{display:flex;gap:10px;margin-bottom:12px;}
  .tabs a{font-weight:900;text-decoration:none;}
  .tabs .active{border-bottom:3px solid #111;padding-bottom:4px;}
  .card{background:#fff;border-radius:16px;box-shadow:var(--card-shadow);padding:16px;}
  .row{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin:12px 0;}
  .input, select{padding:10px 12px;border-radius:12px;border:1px solid rgba(0,0,0,.2);}
  .btn{border:0;border-radius:14px;padding:12px 16px;font-weight:900;cursor:pointer;box-shadow:0 10px 18px rgba(0,0,0,.12);background:rgba(188,209,255,.9);}
  table{width:100%;border-collapse:collapse;}
  th,td{border:1px solid #111;padding:12px;}
  th{background:rgba(188,209,255,.85);}
  .table-wrap{overflow:auto;}
  .nilai{display:inline-block;padding:6px 12px;border-radius:999px;font-weight:900;color:#fff;}
  .n-hijau{background:#00c853;}
  .n-merah{background:#ff1744;}
  .lihat{display:inline-block;padding:10px 14px;border-radius:12px;background:rgba(188,209,255,.8);font-weight:900;text-decoration:none;}
</style>
@endsection

@section('content')
  <div class="page-title">Tugas Siswa</div>

  <div class="tabs">
    <a href="{{ route('web.tugas.create') }}" style="color:var(--muted)">Buat Tugas</a>
    <a class="active" href="{{ route('web.tugas.masuk') }}">Tugas Masuk</a>
  </div>

  <div class="card">
    <div class="row">
      <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;">
        <select name="kategori" class="input">
          <option value="">Kategori Materi</option>
          @foreach(['Penjumlahan','Pengurangan','Perkalian','Pembagian'] as $k)
            <option value="{{ $k }}" @selected(request('kategori')==$k)>{{ $k }}</option>
          @endforeach
        </select>

        <select name="tugas_id" class="input">
          <option value="">Tugas</option>
          @foreach($tugasList as $t)
            <option value="{{ $t->id }}" @selected(request('tugas_id')==$t->id)>{{ $t->judul }}</option>
          @endforeach
        </select>

        <input class="input" name="search_siswa" value="{{ request('search_siswa') }}" placeholder="Cari Siswa">
        <button class="btn" type="submit">Filter</button>
      </form>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nama Siswa</th>
            <th>Tugas</th>
            <th>Nilai</th>
            <th>Tanggal</th>
            <th>Lihat</th>
          </tr>
        </thead>
        <tbody>
        @forelse($subs as $s)
          <tr>
            <td>{{ $s->siswa->name }}</td>
            <td>{{ $s->tugas->judul }}</td>
            <td>
              <span class="nilai {{ $s->nilai >= 60 ? 'n-hijau' : 'n-merah' }}">{{ $s->nilai }}</span>
            </td>
            <td>{{ optional($s->submitted_at)->format('d M Y') ?? '-' }}</td>
            <td>
              <a class="lihat" href="{{ route('web.tugas.show',$s->id) }}">👁</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">Belum ada tugas masuk.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:12px;">{{ $subs->links() }}</div>
  </div>
@endsection
