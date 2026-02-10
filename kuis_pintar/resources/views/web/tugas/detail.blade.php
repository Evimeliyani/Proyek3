@extends('web.layouts.app')

@section('title','Detail Tugas')
@section('topbar_title','Detail Tugas')

@section('styles')
<style>
  .card{background:#fff;border-radius:16px;box-shadow:var(--card-shadow);padding:16px;}
  .back{display:inline-block;padding:10px 14px;border-radius:12px;background:rgba(188,209,255,.7);font-weight:900;text-decoration:none;}
  .row{display:grid;grid-template-columns: 1fr 1fr;gap:14px;margin-top:12px;}
  @media(max-width:860px){ .row{grid-template-columns:1fr;} }
  .pill{display:inline-block;padding:6px 12px;border-radius:999px;font-weight:900;color:#fff;background:#00c853;}
</style>
@endsection

@section('content')
  <a class="back" href="{{ route('web.tugas.masuk') }}">⬅ Kembali</a>

  <div class="card" style="margin-top:12px;">
    <div style="font-size:26px;font-weight:900;">{{ $submission->tugas->judul }}</div>
    <div style="color:var(--muted);margin-top:4px;">
      Siswa: <b>{{ $submission->siswa->name }}</b> • Kategori: <b>{{ $submission->tugas->kategori }}</b>
    </div>

    <div class="row">
      <div class="card">
        <div style="font-weight:900;margin-bottom:10px;">Soal</div>
        <div style="font-size:18px;">{{ $submission->tugas->soal }}</div>

        <div style="margin-top:14px;font-weight:900;">Kunci Jawaban</div>
        <div>{{ $submission->tugas->kunci_jawaban }}</div>

        <div style="margin-top:14px;font-weight:900;">Jawaban OCR</div>
        <div>{{ $submission->jawaban_ocr ?? '-' }}</div>
      </div>

      <div class="card">
        <div style="font-weight:900;margin-bottom:10px;">Nilai</div>
        <div class="pill">{{ $submission->nilai }}</div>

        <div style="margin-top:14px;font-weight:900;">Tanggal</div>
        <div>{{ optional($submission->submitted_at)->format('d M Y H:i') ?? '-' }}</div>

        <div style="margin-top:14px;font-weight:900;">Foto Jawaban</div>
        @if($submission->photo_path)
          <img src="{{ asset('storage/'.$submission->photo_path) }}" style="width:100%;border-radius:12px;border:1px solid rgba(0,0,0,.15)">
        @else
          <div>-</div>
        @endif
      </div>
    </div>
  </div>
@endsection
