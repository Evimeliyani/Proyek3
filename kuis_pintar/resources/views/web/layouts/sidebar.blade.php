<div class="profile">
    <div class="avatar">👩‍🏫</div>
    <div class="name">{{ auth()->user()->name ?? 'Guru' }}</div>
</div>

<nav class="nav">
    {{-- Dashboard --}}
    <a class="{{ request()->routeIs('web.dashboard') ? 'active' : '' }}"
       href="{{ route('web.dashboard') }}">
        <span class="ico">🏠</span> Dashboard
    </a>

    {{-- Quiz --}}
    <a class="{{ request()->routeIs('web.quiz.*') ? 'active' : '' }}"
       href="{{ route('web.quiz.index') }}">
        <span class="ico">📝</span> Quiz
    </a>

    {{-- Grafik --}}
    <a class="{{ request()->is('grafik*') ? 'active' : '' }}"
       href="{{ route('web.grafik.index') }}">
        <span class="ico">📈</span> Grafik
    </a>

    {{-- DROPDOWN: Tugas Siswa --}}
    @php
        // aktif jika berada di halaman tugas siswa
        $tugasOpen = request()->is('tugas-siswa*') || request()->routeIs('web.tugas.*');
    @endphp

    <button type="button"
            class="{{ $tugasOpen ? 'active' : '' }}"
            data-dd="tugas">
        <span class="ico">📷</span> Tugas Siswa
        <span style="margin-left:auto; font-size:14px;" id="ddIconTugas">
            {{ $tugasOpen ? '▲' : '▼' }}
        </span>
    </button>

    <div class="dd {{ $tugasOpen ? 'open' : '' }}" id="ddTugas">
        <a class="{{ request()->routeIs('web.tugas.create') ? 'active' : '' }}"
           href="{{ route('web.tugas.create') }}">
            <span class="ico">📝</span> Buat Tugas
        </a>

        <a class="{{ request()->routeIs('web.tugas.masuk') ? 'active' : '' }}"
           href="{{ route('web.tugas.masuk') }}">
            <span class="ico">📥</span> Tugas Masuk
        </a>
    </div>

    <div class="spacer"></div>

    {{-- Logout --}}
    <form method="POST" action="{{ route('web.logout') }}">
        @csrf
        <button type="submit">
            <span class="ico">🚪</span> Logout
        </button>
    </form>
</nav>

{{-- STYLE DROPDOWN (biar konsisten sama sidebar app.php) --}}
<style>
    .dd{
        display:none;
        flex-direction:column;
        gap: 6px;
        margin-left: 42px; /* indent ke kanan (mirip dropdown desain kamu) */
        margin-top: 6px;
        margin-bottom: 6px;
    }
    .dd.open{ display:flex; }

    .dd a{
        padding: 10px 12px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 800;
        background: rgba(255,255,255,.18);
    }
    .dd a:hover{
        background: rgba(255,255,255,.28);
    }
    .dd a.active{
        background: rgba(255,255,255,.45);
        box-shadow: inset 0 0 0 2px rgba(255,255,255,.35);
    }
</style>

{{-- SCRIPT DROPDOWN --}}
<script>
    // toggle dropdown tugas
    document.querySelectorAll('[data-dd="tugas"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const dd = document.getElementById('ddTugas');
            const icon = document.getElementById('ddIconTugas');

            dd.classList.toggle('open');
            icon.textContent = dd.classList.contains('open') ? '▲' : '▼';
        });
    });
</script>
