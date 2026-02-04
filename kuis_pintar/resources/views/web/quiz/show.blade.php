@extends('web.layouts.app')

@section('title', 'Quiz - ' . $quiz->title)
@section('topbar_title','Detail Quiz')

@section('content')
<style>
    .topRow{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .btnBack{
        display:inline-flex;
        align-items:center;
        gap:10px;
        background:#bcd1ff;
        border-radius:14px;
        padding:10px 14px;
        font-size:14px;
        text-decoration:none;
        color:#111;
        font-weight:900;
        width:max-content;
        box-shadow: 0 10px 18px rgba(0,0,0,.10);
    }

    .hero{
        background:#fff;
        border-radius: 18px;
        box-shadow: var(--soft-shadow);
        padding: 16px;
        border: 1px solid rgba(0,0,0,.06);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }
    .heroLeft{
        display:flex;
        align-items:center;
        gap: 12px;
    }
    .heroIcon{
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(188,209,255,.55);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size: 28px;
        box-shadow: 0 10px 18px rgba(0,0,0,.10);
    }
    .bigTitle{
        font-size: 22px;
        font-weight: 900;
        margin:0;
        line-height: 1.2;
    }
    .subMuted{
        margin-top:6px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 700;
    }

    .actions{
        display:flex;
        gap:10px;
        align-items:center;
        justify-content:flex-end;
    }
    .actionBtn{
        background:#bcd1ff;
        border:0;
        border-radius:14px;
        padding:10px 14px;
        font-size:14px;
        cursor:pointer;
        display:flex;
        align-items:center;
        gap:8px;
        font-weight: 900;
        box-shadow: 0 10px 18px rgba(0,0,0,.10);
    }

    .sectionTitle{
        font-size: 18px;
        font-weight: 900;
        margin: 8px 0 10px;
    }

    .tableWrap{
        background:#fff;
        border-radius: 18px;
        box-shadow: var(--soft-shadow);
        padding: 10px;
        overflow:auto;
        border: 1px solid rgba(0,0,0,.06);
    }
    table{
        width:100%;
        border-collapse:collapse;
        min-width: 760px;
        background:#fff;
    }
    th, td{
        border:2px solid #000;
        padding:12px 12px;
        text-align:center;
        font-size:14px;
        vertical-align: middle;
    }
    th{
        background:#bcd1ff;
        font-weight:900;
        white-space: nowrap;
    }
    td.left{ text-align:left; }

    .iconCell{
        display:flex;
        gap:10px;
        justify-content:center;
        align-items:center;
    }
    .eyeBtn, .trashBtn{
        background:transparent;
        border:0;
        cursor:pointer;
        font-size:18px;
    }

    /* MODAL */
    .modal-backdrop{
        display:none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.40);
        z-index: 100;
        align-items: center;
        justify-content: center;
        padding: 14px;
    }
    .modal{
        width: 640px;
        max-width: 100%;
        background:#fff;
        border-radius: 18px;
        overflow:hidden;
        box-shadow: 0 18px 40px rgba(0,0,0,.22);
    }
    .mhead{
        background:#bcd1ff;
        padding: 12px 14px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        font-weight: 900;
    }
    .mhead button{
        border:0;
        background: rgba(255,255,255,.7);
        border-radius: 12px;
        padding: 8px 10px;
        cursor:pointer;
        font-weight: 900;
    }
    .mbody{
        padding: 14px;
        background: #f7f9ff;
    }

    .row{
        display:flex;
        flex-direction:column;
        gap:8px;
        margin-bottom: 12px;
    }
    label{
        font-weight: 900;
        font-size: 13px;
    }
    input[type="text"], select{
        width:100%;
        border: 2px solid rgba(0,0,0,.18);
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 14px;
        outline: none;
        background: #fff;
    }
    .radioRow{
        display:flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 14px;
        font-weight: 800;
    }
    .btn-wrap{
        display:flex;
        justify-content:center;
        margin-top: 12px;
    }
    .btn{
        background:#3b6cff;
        border:0;
        color:#fff;
        font-weight:900;
        border-radius: 14px;
        padding: 12px 18px;
        cursor:pointer;
        font-size: 14px;
        min-width: 160px;
        box-shadow: 0 12px 22px rgba(0,0,0,.16);
    }
    .pill{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #d7ffd5;
        font-weight: 900;
        font-size: 14px;
        width: max-content;
    }

    @media (max-width: 860px){
        .modal{ width: 100%; }
        table{ min-width: 680px; }
        .bigTitle{ font-size: 18px; }
        .actionBtn{ width: 100%; justify-content:center; }
        .actions{ width:100%; }
        .btnBack{ width:100%; justify-content:center; }
    }
</style>

<div class="topRow">
    <a class="btnBack" href="{{ url('/quiz') }}">← Kembali</a>
</div>

<div class="hero">
    <div class="heroLeft">
        <div class="heroIcon">🧩</div>
        <div>
            <div class="bigTitle">Nama Quiz: {{ $quiz->title }}</div>
            <div class="subMuted">Kelola soal: tambah, edit, lihat detail, dan hapus</div>
        </div>
    </div>

    <div class="actions">
        <button class="actionBtn" type="button" id="btnOpenAdd">Tambah ➕</button>
    </div>
</div>

<div class="sectionTitle">Daftar Soal</div>

<div class="tableWrap">
    <table>
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Level</th>
                <th>Kunci Jawaban</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($questions as $q)
            <tr>
                <td class="left">{{ $q->question }}</td>
                <td>{{ $q->level }}</td>
                <td>{{ $q->correct_option }}. {{
                    match($q->correct_option){
                        'A' => $q->option_a,
                        'B' => $q->option_b,
                        'C' => $q->option_c,
                        'D' => $q->option_d,
                        default => ''
                    }
                }}</td>
                <td>
                    <div class="iconCell">
                        <button class="eyeBtn"
                            data-action="detail"
                            data-id="{{ $q->id }}"
                            data-question="{{ e($q->question) }}"
                            data-a="{{ e($q->option_a) }}"
                            data-b="{{ e($q->option_b) }}"
                            data-c="{{ e($q->option_c) }}"
                            data-d="{{ e($q->option_d) }}"
                            data-correct="{{ $q->correct_option }}"
                            data-level="{{ $q->level }}"
                            title="Detail">👁️</button>

                        <button class="eyeBtn"
                            data-action="edit"
                            data-id="{{ $q->id }}"
                            data-question="{{ e($q->question) }}"
                            data-a="{{ e($q->option_a) }}"
                            data-b="{{ e($q->option_b) }}"
                            data-c="{{ e($q->option_c) }}"
                            data-d="{{ e($q->option_d) }}"
                            data-correct="{{ $q->correct_option }}"
                            data-level="{{ $q->level }}"
                            title="Edit">✏️</button>

                        <form method="POST" action="{{ route('web.quiz.questions.destroy', $q->id) }}"
                              onsubmit="return confirm('Yakin hapus soal ini?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="trashBtn" title="Hapus">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="padding:18px; font-weight:800;">Belum ada soal. Klik <b>Tambah</b>.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL: TAMBAH / EDIT --}}
<div class="modal-backdrop" id="modalFormBackdrop">
    <div class="modal">
        <div class="mhead">
            <div id="modalFormTitle">Tambah / Edit Soal</div>
            <button type="button" id="btnCloseForm">✕</button>
        </div>
        <div class="mbody">
            <form id="formQuestion" method="POST" action="{{ route('web.quiz.questions.store', $quiz->slug) }}">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value="POST" />

                <div class="row">
                    <label>Pertanyaan:</label>
                    <input type="text" name="question" id="f_question" required>
                </div>

                <div class="row"><label>Pilihan A:</label><input type="text" name="option_a" id="f_a" required></div>
                <div class="row"><label>Pilihan B:</label><input type="text" name="option_b" id="f_b" required></div>
                <div class="row"><label>Pilihan C:</label><input type="text" name="option_c" id="f_c" required></div>
                <div class="row"><label>Pilihan D:</label><input type="text" name="option_d" id="f_d" required></div>

                <div class="row">
                    <label>Jawaban Benar:</label>
                    <div class="radioRow">
                        <label><input type="radio" name="correct_option" value="A" required> A</label>
                        <label><input type="radio" name="correct_option" value="B"> B</label>
                        <label><input type="radio" name="correct_option" value="C"> C</label>
                        <label><input type="radio" name="correct_option" value="D"> D</label>
                    </div>
                </div>

                <div class="row">
                    <label>Level Soal:</label>
                    <select name="level" id="f_level" required>
                        <option value="Mudah">Mudah</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Sulit">Sulit</option>
                    </select>
                </div>

                <div class="btn-wrap">
                    <button class="btn" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL: DETAIL --}}
<div class="modal-backdrop" id="modalDetailBackdrop">
    <div class="modal" style="width:560px;">
        <div class="mhead">
            <div>Detail Soal</div>
            <button type="button" id="btnCloseDetail">✕</button>
        </div>
        <div class="mbody" style="background:#fff;">
            <div style="font-size:13px; font-weight:900; margin-bottom:6px;">Pertanyaan:</div>
            <div id="d_question" style="font-size:18px; font-weight:900; margin-bottom:12px;"></div>

            <div style="display:grid; gap:8px; font-size:14px; font-weight:800;">
                <div id="d_a">A.</div>
                <div id="d_b">B.</div>
                <div id="d_c">C.</div>
                <div id="d_d">D.</div>
            </div>

            <div style="margin-top:12px;">
                <div style="font-size:13px; font-weight:900; margin-bottom:8px;">Kunci Jawaban:</div>
                <div class="pill" id="d_key">C. 14</div>
            </div>

            <div style="margin-top:12px;">
                <div style="font-size:13px; font-weight:900;">Level: <span id="d_level" style="font-weight:800;"></span></div>
            </div>

            <div class="btn-wrap" style="margin-top:14px;">
                <button class="btn" type="button" id="btnCloseDetail2">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modalForm = document.getElementById('modalFormBackdrop');
    const modalDetail = document.getElementById('modalDetailBackdrop');

    const btnOpenAdd = document.getElementById('btnOpenAdd');
    const btnCloseForm = document.getElementById('btnCloseForm');
    const btnCloseDetail = document.getElementById('btnCloseDetail');
    const btnCloseDetail2 = document.getElementById('btnCloseDetail2');

    const form = document.getElementById('formQuestion');
    const methodSpoof = document.getElementById('methodSpoof');
    const modalFormTitle = document.getElementById('modalFormTitle');

    function openFormAdd(){
        modalFormTitle.innerText = 'Tambah Soal';
        form.action = "{{ route('web.quiz.questions.store', $quiz->slug) }}";
        methodSpoof.value = 'POST';
        form.reset();
        modalForm.style.display = 'flex';
    }

    function openFormEdit(data){
        modalFormTitle.innerText = 'Edit Soal';
        form.action = "{{ url('/quiz/questions') }}/" + data.id;
        methodSpoof.value = 'PUT';

        document.getElementById('f_question').value = data.question;
        document.getElementById('f_a').value = data.a;
        document.getElementById('f_b').value = data.b;
        document.getElementById('f_c').value = data.c;
        document.getElementById('f_d').value = data.d;
        document.getElementById('f_level').value = data.level;

        document.querySelectorAll('input[name="correct_option"]').forEach(r => {
            r.checked = (r.value === data.correct);
        });

        modalForm.style.display = 'flex';
    }

    function openDetail(data){
        document.getElementById('d_question').innerText = data.question;
        document.getElementById('d_a').innerText = 'A. ' + data.a;
        document.getElementById('d_b').innerText = 'B. ' + data.b;
        document.getElementById('d_c').innerText = 'C. ' + data.c;
        document.getElementById('d_d').innerText = 'D. ' + data.d;

        const keyText = (data.correct === 'A') ? data.a :
                        (data.correct === 'B') ? data.b :
                        (data.correct === 'C') ? data.c : data.d;

        document.getElementById('d_key').innerText = data.correct + '. ' + keyText;
        document.getElementById('d_level').innerText = data.level;

        modalDetail.style.display = 'flex';
    }

    btnOpenAdd?.addEventListener('click', openFormAdd);
    btnCloseForm?.addEventListener('click', () => modalForm.style.display = 'none');
    btnCloseDetail?.addEventListener('click', () => modalDetail.style.display = 'none');
    btnCloseDetail2?.addEventListener('click', () => modalDetail.style.display = 'none');

    document.querySelectorAll('button[data-action]').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = {
                id: btn.dataset.id,
                question: btn.dataset.question,
                a: btn.dataset.a,
                b: btn.dataset.b,
                c: btn.dataset.c,
                d: btn.dataset.d,
                correct: btn.dataset.correct,
                level: btn.dataset.level,
            };

            if(btn.dataset.action === 'detail') openDetail(data);
            if(btn.dataset.action === 'edit') openFormEdit(data);
        });
    });

    modalForm.addEventListener('click', (e) => { if(e.target === modalForm) modalForm.style.display = 'none'; });
    modalDetail.addEventListener('click', (e) => { if(e.target === modalDetail) modalDetail.style.display = 'none'; });

    document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape'){
            modalForm.style.display = 'none';
            modalDetail.style.display = 'none';
        }
    });
</script>
@endsection
