<div class="profile">
    <div class="avatar">👩‍🏫</div>
    <div class="name">{{ auth()->user()->name ?? 'Guru' }}</div>
</div>

<nav class="nav">
    <a class="{{ request()->routeIs('web.dashboard') ? 'active' : '' }}" href="{{ route('web.dashboard') }}">
        <span class="ico">🏠</span> Dashboard
    </a>

    <a class="{{ request()->routeIs('web.quiz.*') ? 'active' : '' }}" href="{{ route('web.quiz.index') }}">
        <span class="ico">📝</span> Quiz
    </a>

    <a href="#" onclick="alert('Menu Grafik belum dibuat'); return false;">
        <span class="ico">📈</span> Grafik
    </a>

    <a href="#" onclick="alert('Menu Tugas Siswa belum dibuat'); return false;">
        <span class="ico">📷</span> Tugas Siswa
    </a>

    <div class="spacer"></div>

    <form method="POST" action="{{ route('web.logout') }}">
        @csrf
        <button type="submit">
            <span class="ico">🚪</span> Logout
        </button>
    </form>
</nav>
