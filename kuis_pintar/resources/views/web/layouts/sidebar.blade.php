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
    <a class="{{ request()->routeIs('web.grafik.*') ? 'active' : '' }}"
       href="{{ route('web.grafik.index') }}">
        <span class="ico">📈</span> Grafik
    </a>

    {{-- ===== DROPDOWN TUGAS SISWA ===== --}}
    @php
        $tugasOpen = request()->is('tugas-siswa*') || request()->routeIs('web.tugas.*');
    @endphp

    <button type="button"
            class="{{ $tugasOpen ? 'active' : '' }}"
            id="btnTugasDropdown">
        <span class="ico">📷</span> Tugas Siswa
        <span style="margin-left:auto;font-size:14px" id="iconTugas">
            {{ $tugasOpen ? '▲' : '▼' }}
        </span>
    </button>

    <div class="dropdown-menu {{ $tugasOpen ? 'open' : '' }}" id="menuTugas">
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

{{-- ===== STYLE DROPDOWN ===== --}}
<style>
    .dropdown-menu{
        display:none;
        flex-direction:column;
        gap:6px;
        margin-left:42px;
        margin-top:6px;
        margin-bottom:6px;
    }
    .dropdown-menu.open{
        display:flex;
    }
    .dropdown-menu a{
        padding:10px 12px;
        border-radius:12px;
        font-size:15px;
        font-weight:700;
        background: rgba(255,255,255,.25);
        text-decoration:none;
    }
    .dropdown-menu a:hover{
        background: rgba(255,255,255,.35);
    }
</style>

{{-- ===== SCRIPT DROPDOWN ===== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnTugasDropdown');
    const menu = document.getElementById('menuTugas');
    const icon = document.getElementById('iconTugas');

    if(!btn || !menu || !icon) return;

    btn.addEventListener('click', () => {
        menu.classList.toggle('open');
        icon.textContent = menu.classList.contains('open') ? '▲' : '▼';
    });
});
</script>
