@extends('layouts.app')

@section('title','Tugas Siswa')
@section('topbar_title','Tugas Siswa')

@section('styles')
<style>
  .page-title{font-size:38px;font-weight:900;margin:8px 0 6px;}
  .tabs{display:flex;gap:10px;margin-bottom:12px;}
  .tabs a{font-weight:900;text-decoration:none;}
  .tabs .active{border-bottom:3px solid #111;padding-bottom:4px;}
  .card{background:#fff;border-radius:16px;box-shadow:var(--card-shadow);padding:16px;}
  .row{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin:12px 0;}
  .input, select{padding:10px 12px;border-radius:12px;border:1px solid rgba(0,0,0,.2);outline:none;}
  .btn{border:0;border-radius:14px;padding:12px 16px;font-weight:900;cursor:pointer;box-shadow:0 10px 18px rgba(0,0,0,.12);}
  .btn-yellow{background:#ffe88a;}
  .btn-blue{background:rgba(188,209,255,.9);}
  table{width:100%;border-collapse:collapse;}
  th,td{border:1px solid #111;padding:12px;}
  th{background:rgba(188,209,255,.85);}
  .table-wrap{overflow:auto;}
  .aksi{display:flex;gap:10px;}
  .icon-btn{border:1px solid #111;background:#fff;border-radius:10px;padding:8px 10px;cursor:pointer;}
  @media(max-width:860px){ .page-title{font-size:30px;} }
</style>
@endsection

@section('content')
  <div class="page-title">Tugas Siswa</div>

  <div class="tabs">
    <a class="active" href="{{ route('web.tugas.create') }}">Buat Tugas</a>
    <a href="{{ route('web.tugas.masuk') }}" style="color:var(--muted)">Tugas Masuk</a>
  </div>

  @if(session('ok'))
    <div class="card" style="margin-bottom:12px;background:rgba(0,255,0,.08);">
      {{ session('ok') }}
    </div>
  @endif

  <div class="card">
    <div style="display:flex;justify-content:flex-end;">
      <button class="btn btn-yellow" onclick="document.getElementById('modalTambah').showModal()">
        Tambah Tugas ➕
      </button>
    </div>

    <div class="row">
      <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;">
        <select name="kategori" class="input">
          <option value="">Kategori Materi</option>
          @foreach(['Penjumlahan','Pengurangan','Perkalian','Pembagian'] as $k)
            <option value="{{ $k }}" @selected(request('kategori')==$k)>{{ $k }}</option>
          @endforeach
        </select>

        <input class="input" name="search" value="{{ request('search') }}" placeholder="Cari Tugas">
        <button class="btn btn-blue" type="submit">Filter</button>
      </form>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Judul Tugas</th>
            <th>Soal</th>
            <th>Kunci Jawaban</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        @forelse($tugas as $t)
          <tr>
            <td>{{ $t->judul }}</td>
            <td>{{ $t->soal }}</td>
            <td>{{ $t->kunci_jawaban }}</td>
            <td>
              <div class="aksi">
                <button class="icon-btn" onclick="openEdit({{ $t->id }}, @js($t->kategori), @js($t->judul), @js($t->soal), @js($t->kunci_jawaban))">✏️</button>

                <form method="POST" action="{{ route('web.tugas.destroy',$t->id) }}"
                      onsubmit="return confirm('Hapus tugas ini?')">
                  @csrf @method('DELETE')
                  <button class="icon-btn" type="submit">🗑️</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4">Belum ada tugas.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div style="margin-top:12px;">{{ $tugas->links() }}</div>
  </div>

  {{-- MODAL TAMBAH --}}
  <dialog id="modalTambah">
    <form method="POST" action="{{ route('web.tugas.store') }}" class="card" style="min-width:min(520px,92vw);">
      @csrf
      <div style="font-size:22px;font-weight:900;margin-bottom:10px;">Tambah Tugas</div>

      <div class="row">
        <select class="input" name="kategori" required>
          @foreach(['Penjumlahan','Pengurangan','Perkalian','Pembagian'] as $k)
            <option value="{{ $k }}">{{ $k }}</option>
          @endforeach
        </select>
      </div>

      <div class="row"><input class="input" name="judul" placeholder="Judul Tugas" required style="flex:1"></div>
      <div class="row"><input class="input" name="soal" placeholder="Soal (contoh: 50 + 25)" required style="flex:1"></div>
      <div class="row"><input class="input" name="kunci_jawaban" placeholder="Kunci Jawaban" required style="flex:1"></div>

      <div class="row" style="justify-content:flex-end;">
        <button class="btn" type="button" onclick="document.getElementById('modalTambah').close()">Tutup</button>
        <button class="btn btn-blue" type="submit">Simpan</button>
      </div>
    </form>
  </dialog>

  {{-- MODAL EDIT --}}
  <dialog id="modalEdit">
    <form method="POST" id="formEdit" class="card" style="min-width:min(520px,92vw);">
      @csrf @method('PUT')
      <div style="font-size:22px;font-weight:900;margin-bottom:10px;">Edit Tugas</div>

      <div class="row">
        <select class="input" name="kategori" id="eKategori" required>
          @foreach(['Penjumlahan','Pengurangan','Perkalian','Pembagian'] as $k)
            <option value="{{ $k }}">{{ $k }}</option>
          @endforeach
        </select>
      </div>

      <div class="row"><input class="input" name="judul" id="eJudul" required style="flex:1"></div>
      <div class="row"><input class="input" name="soal" id="eSoal" required style="flex:1"></div>
      <div class="row"><input class="input" name="kunci_jawaban" id="eKunci" required style="flex:1"></div>

      <div class="row" style="justify-content:flex-end;">
        <button class="btn" type="button" onclick="document.getElementById('modalEdit').close()">Tutup</button>
        <button class="btn btn-blue" type="submit">Simpan</button>
      </div>
    </form>
  </dialog>
@endsection

@section('scripts')
<script>
  function openEdit(id, kategori, judul, soal, kunci){
    const modal = document.getElementById('modalEdit');
    document.getElementById('formEdit').action = "{{ url('tugas-siswa/buat') }}/" + id;
    document.getElementById('eKategori').value = kategori;
    document.getElementById('eJudul').value = judul;
    document.getElementById('eSoal').value = soal;
    document.getElementById('eKunci').value = kunci;
    modal.showModal();
  }
</script>
@endsection
