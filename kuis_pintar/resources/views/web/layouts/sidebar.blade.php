@php
    $quizOpen = request()->routeIs('web.quiz.*') || request()->routeIs('quiz.result');
    $tugasOpen = request()->routeIs('web.tugas.*') || request()->is('tugas-siswa*');
@endphp

<aside class="sidebar app-sidebar">

    <div class="side-profile">
        <div class="profile-avatar">👩‍🏫</div>
        <div class="profile-name">{{ auth()->user()->name ?? 'Guru' }}</div>
        <div class="profile-caption">Selamat mengajar ✨</div>
    </div>

    <nav class="side-nav">

        <a href="{{ route('web.dashboard') }}"
           class="side-item {{ request()->routeIs('web.dashboard') ? 'active' : '' }}">
            <span class="side-icon icon-green">🏠</span>
            <span class="side-label">Dashboard</span>
            <span></span>
        </a>

        <details class="side-dropdown" {{ $quizOpen ? 'open' : '' }}>
            <summary class="side-item {{ $quizOpen ? 'active' : '' }}">
                <span class="side-icon icon-yellow">📝</span>
                <span class="side-label">Quiz</span>
                <span class="side-arrow">⌃</span>
            </summary>

            <div class="side-submenu">
                <a href="{{ route('web.quiz.index') }}"
                   class="side-subitem {{ request()->routeIs('web.quiz.*') ? 'active' : '' }}">
                    <span class="sub-icon">🧾</span>
                    <span>Buat Quiz</span>
                </a>

                <a href="{{ route('quiz.result') }}"
                   class="side-subitem {{ request()->routeIs('quiz.result') ? 'active' : '' }}">
                    <span class="sub-icon">📊</span>
                    <span>Hasil Quiz</span>
                </a>
            </div>
        </details>

        <a href="{{ route('web.grafik.index') }}"
           class="side-item {{ request()->routeIs('web.grafik.*') ? 'active' : '' }}">
            <span class="side-icon icon-purple">📈</span>
            <span class="side-label">Grafik</span>
            <span></span>
        </a>

        <details class="side-dropdown" {{ $tugasOpen ? 'open' : '' }}>
            <summary class="side-item {{ $tugasOpen ? 'active' : '' }}">
                <span class="side-icon icon-pink">🎒</span>
                <span class="side-label">Tugas Siswa</span>
                <span class="side-arrow">⌃</span>
            </summary>

            <div class="side-submenu">
                <a href="{{ route('web.tugas.create') }}"
                   class="side-subitem {{ request()->routeIs('web.tugas.create') ? 'active' : '' }}">
                    <span class="sub-icon">✏️</span>
                    <span>Buat Tugas</span>
                </a>

                <a href="{{ route('web.tugas.masuk') }}"
                   class="side-subitem {{ request()->routeIs('web.tugas.masuk') ? 'active' : '' }}">
                    <span class="sub-icon">📥</span>
                    <span>Tugas Masuk</span>
                </a>
            </div>
        </details>

        <div class="side-spacer"></div>

        <form method="POST" action="{{ route('web.logout') }}">
            @csrf
            <button type="submit" class="logout-side">
                <span>🚪</span>
                <span>Logout</span>
            </button>
        </form>

    </nav>
</aside>

<style>
    .app-sidebar {
        width: 268px;
        flex: 0 0 268px;
        min-height: 100vh;
        height: 100vh;
        position: sticky;
        top: 0;
        padding: 26px 18px;
        background: linear-gradient(180deg, #dce9ff 0%, #eef5ff 100%);
        box-shadow: 14px 0 32px rgba(87, 110, 180, .12);
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    .app-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .app-sidebar::-webkit-scrollbar-thumb {
        background: rgba(80, 98, 140, .25);
        border-radius: 99px;
    }

    .side-profile {
        padding: 28px 16px;
        margin-bottom: 28px;
        text-align: center;
        background: #eef5ff;
        border-radius: 28px;
        box-shadow:
            0 10px 0 #c7d9ff,
            0 22px 30px rgba(91, 119, 190, .14);
    }

    .profile-avatar {
        width: 84px;
        height: 84px;
        margin: 0 auto 14px;
        border-radius: 26px;
        display: grid;
        place-items: center;
        font-size: 42px;
        background: #fff3c4;
        box-shadow: 0 9px 0 #e4d89f;
    }

    .profile-name {
        font-size: 23px;
        font-weight: 900;
        color: #111827;
        line-height: 1.15;
    }

    .profile-caption {
        margin-top: 6px;
        font-size: 14px;
        font-weight: 900;
        color: #6b7280;
    }

    .side-nav {
        display: flex;
        flex-direction: column;
        gap: 14px;
        flex: 1;
    }

    .side-item {
        width: 100%;
        min-height: 64px;
        padding: 12px 18px;
        border: 0;
        outline: 0;
        text-decoration: none;
        cursor: pointer;
        display: grid;
        grid-template-columns: 42px 1fr 18px;
        align-items: center;
        column-gap: 16px;
        border-radius: 24px;
        background: #eef5ff;
        color: #172033;
        font-size: 17px;
        font-weight: 900;
        text-align: left;
        box-shadow:
            0 8px 0 #c7d9ff,
            0 16px 24px rgba(91, 119, 190, .12);
        transition: .16s ease;
    }

    .side-item:hover {
        transform: translateY(-2px);
        background: #ffffff;
    }

    .side-item:active {
        transform: translateY(5px);
        box-shadow:
            0 3px 0 #c7d9ff,
            0 8px 14px rgba(91, 119, 190, .10);
    }

    .side-item.active {
        background: #ffffff;
        color: #3152d4;
        box-shadow:
            0 8px 0 #b9d0ff,
            0 16px 24px rgba(77, 124, 254, .15);
    }

    .side-label {
        justify-self: start;
        text-align: left;
    }

    .side-icon {
        width: 42px;
        height: 42px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        font-size: 22px;
        box-shadow: inset 0 -4px 0 rgba(0,0,0,.08);
    }

    .icon-green {
        background: #c9f2d3;
    }

    .icon-yellow {
        background: #fff0b3;
    }

    .icon-purple {
        background: #ddceff;
    }

    .icon-pink {
        background: #ffd3df;
    }

    .side-arrow {
        justify-self: end;
        font-size: 17px;
        font-weight: 900;
        color: #111827;
        transition: .18s ease;
    }

    .side-dropdown summary {
        list-style: none;
    }

    .side-dropdown summary::-webkit-details-marker {
        display: none;
    }

    .side-dropdown:not([open]) .side-arrow {
        transform: rotate(180deg);
    }

    .side-submenu {
        display: flex;
        flex-direction: column;
        gap: 9px;
        margin: 12px 0 4px 54px;
    }

    .side-subitem {
        min-height: 45px;
        padding: 10px 14px;
        border-radius: 18px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 11px;
        background: #eef5ff;
        color: #1f2937;
        font-size: 15px;
        font-weight: 900;
        box-shadow:
            0 6px 0 #d7e4ff,
            0 10px 16px rgba(91, 119, 190, .09);
        transition: .16s ease;
    }

    .side-subitem:hover {
        background: #ffffff;
        transform: translateX(4px);
    }

    .side-subitem:active {
        transform: translateY(4px);
        box-shadow: 0 2px 0 #d7e4ff;
    }

    .side-subitem.active {
        background: #fff3bd;
        color: #7a5710;
        box-shadow:
            0 6px 0 #e6cd78,
            0 10px 16px rgba(226, 186, 75, .12);
    }

    .sub-icon {
        width: 24px;
        text-align: center;
    }

    .side-spacer {
        flex: 1;
    }

    .logout-side {
        width: 100%;
        min-height: 58px;
        border: 0;
        outline: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border-radius: 24px;
        background: #ef8290;
        color: white;
        font-size: 17px;
        font-weight: 900;
        box-shadow:
            0 8px 0 #cf5f6d,
            0 16px 24px rgba(207, 95, 109, .16);
        transition: .16s ease;
    }

    .logout-side:hover {
        background: #ea7685;
        transform: translateY(-2px);
    }

    .logout-side:active {
        transform: translateY(5px);
        box-shadow: 0 3px 0 #cf5f6d;
    }

    @media (max-width: 860px) {
        .app-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            z-index: 80;
            width: 82vw;
            max-width: 310px;
            transform: translateX(-110%);
            transition: transform .2s ease;
        }

        body.sidebar-open .app-sidebar {
            transform: translateX(0);
        }
    }
</style>
