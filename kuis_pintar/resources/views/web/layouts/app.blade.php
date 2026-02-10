<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Kuis Pintar')</title>

    <style>
        :root{
            --bg: #fbf7e6;
            --sidebar: #bcd1ff;
            --sidebar-soft: rgba(255,255,255,0.45);
            --card-shadow: 0 10px 18px rgba(0,0,0,.12);
            --soft-shadow: 0 12px 28px rgba(0,0,0,.18);
            --radius: 16px;
            --text: #111;
            --muted: rgba(0,0,0,.55);
            --line: rgba(0,0,0,.12);
        }

        *{ box-sizing: border-box; }
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--bg);
        }
        a{ color: inherit; }

        .layout{ display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar{
            width: 280px;
            background: var(--sidebar);
            padding: 22px 18px;
            display:flex;
            flex-direction:column;
            gap: 16px;
            position: sticky;
            top:0;
            height: 100vh;
        }
        .profile{
            display:flex;
            flex-direction:column;
            align-items:center;
            gap: 12px;
            padding: 8px 10px 10px;
        }
        .avatar{
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background: rgba(255,255,255,.6);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 34px;
            box-shadow: 0 8px 16px rgba(0,0,0,.12);
        }
        .name{
            font-size: 18px;
            font-weight: 800;
            text-align:center;
            line-height: 1.2;
        }

        .nav{
            display:flex;
            flex-direction:column;
            gap: 8px;
            margin-top: 6px;
        }
        .nav a, .nav button, .nav summary{
            display:flex;
            align-items:center;
            gap: 12px;
            width:100%;
            border:0;
            text-decoration:none;
            color:#111;
            background: transparent;
            padding: 12px 12px;
            border-radius: 12px;
            cursor:pointer;
            font-size: 16px;
            font-weight: 700;
        }
        .nav a.active, .nav summary.active{
            background: var(--sidebar-soft);
            box-shadow: inset 0 0 0 2px rgba(255,255,255,.35);
        }
        .nav a:hover, .nav button:hover, .nav summary:hover{ background: rgba(255,255,255,.25); }
        .nav .ico{ width: 30px; text-align:center; font-size: 18px; }
        .spacer{ flex:1; }

        /* CONTENT */
        .content{ flex:1; padding: 28px 28px; }
        .container{ max-width: 1100px; }

        /* MOBILE TOPBAR */
        .topbar{
            display:none;
            align-items:center;
            justify-content:space-between;
            gap: 10px;
            padding: 12px 14px;
            background: rgba(255,255,255,.65);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top:0;
            z-index: 50;
            backdrop-filter: blur(8px);
        }
        .hamburger{
            border:0;
            background: #fff;
            border-radius: 12px;
            padding: 10px 12px;
            cursor:pointer;
            box-shadow: 0 8px 16px rgba(0,0,0,.10);
            font-size: 18px;
            font-weight: 900;
        }
        .topbar-title{ font-weight: 900; font-size: 16px; }

        @media (max-width: 980px){ .sidebar{ width: 250px; } }

        @media (max-width: 860px){
            .layout{ flex-direction:column; }
            .topbar{ display:flex; }

            .sidebar{
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                z-index: 80;
                transform: translateX(-110%);
                transition: transform .2s ease;
                box-shadow: 0 14px 30px rgba(0,0,0,.18);
                width: 82vw;
                max-width: 320px;
            }
            body.sidebar-open .sidebar{ transform: translateX(0); }

            .sidebar-overlay{
                display:none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.35);
                z-index: 70;
            }
            body.sidebar-open .sidebar-overlay{ display:block; }

            .content{ padding: 16px 14px; }
        }

        /* ===== DROPDOWN (TUGAS SISWA) TANPA JS ===== */
        details.dd-wrap summary { list-style: none; }
        details.dd-wrap summary::-webkit-details-marker { display:none; }

        .dd-wrap{ margin:0; padding:0; }
        .dd-summary{
            /* sudah ikut style .nav summary */
            user-select:none;
        }
        .dd-caret{
            margin-left:auto;
            font-weight:900;
            transition: transform .15s ease;
        }
        details.dd-wrap[open] .dd-caret{ transform: rotate(180deg); }

        .dd-menu{
            display:flex;
            flex-direction:column;
            gap:6px;
            margin-left:42px;
            margin-top:6px;
            margin-bottom:6px;
        }
        .dd-menu a{
            padding:10px 12px;
            border-radius:12px;
            font-size:15px;
            font-weight:800;
            background: rgba(255,255,255,.18);
        }
        .dd-menu a:hover{ background: rgba(255,255,255,.28); }

        /* override kalau ada class .active dari tempat lain (misal jadi hijau) */
        .nav a.active, .nav summary.active, .dd-menu a.active{
            background: var(--sidebar-soft) !important;
            box-shadow: inset 0 0 0 2px rgba(255,255,255,.35) !important;
            color:#111 !important;
        }
    </style>

    @yield('styles')
</head>

<body>
    <div class="topbar">
        <button class="hamburger" type="button" id="btnSidebar">☰</button>
        <div class="topbar-title">@yield('topbar_title','Kuis Pintar')</div>
        <div style="width:44px"></div>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="layout">
        <aside class="sidebar" aria-label="Sidebar">
            <div class="profile">
                <div class="avatar">👩‍🏫</div>
                <div class="name">{{ auth()->user()->name ?? 'Guru' }}</div>
            </div>

            <nav class="nav">
                <a class="{{ request()->routeIs('web.dashboard') ? 'active' : '' }}"
                   href="{{ route('web.dashboard') }}">
                    <span class="ico">🏠</span> Dashboard
                </a>

                <a class="{{ request()->routeIs('web.quiz.*') ? 'active' : '' }}"
                   href="{{ route('web.quiz.index') }}">
                    <span class="ico">📝</span> Quiz
                </a>

                <a class="{{ request()->routeIs('web.grafik.*') ? 'active' : '' }}"
                   href="{{ route('web.grafik.index') }}">
                    <span class="ico">📈</span> Grafik
                </a>

                {{-- DROPDOWN TUGAS SISWA (NO JS) --}}
                @php
                    $tugasOpen = request()->is('tugas-siswa*') || request()->routeIs('web.tugas.*');
                @endphp

                <details class="dd-wrap" {{ $tugasOpen ? 'open' : '' }}>
                    <summary class="dd-summary {{ $tugasOpen ? 'active' : '' }}">
                        <span class="ico">📷</span> Tugas Siswa
                        <span class="dd-caret">▾</span>
                    </summary>

                    <div class="dd-menu">
                        <a class="{{ request()->routeIs('web.tugas.create') ? 'active' : '' }}"
                           href="{{ route('web.tugas.create') }}">
                            <span class="ico">📝</span> Buat Tugas
                        </a>

                        <a class="{{ request()->routeIs('web.tugas.masuk') ? 'active' : '' }}"
                           href="{{ route('web.tugas.masuk') }}">
                            <span class="ico">📥</span> Tugas Masuk
                        </a>
                    </div>
                </details>

                <div class="spacer"></div>

                <form method="POST" action="{{ route('web.logout') }}">
                    @csrf
                    <button type="submit"><span class="ico">🚪</span> Logout</button>
                </form>
            </nav>
        </aside>

        <main class="content">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const btnSidebar = document.getElementById('btnSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar(){ document.body.classList.add('sidebar-open'); }
        function closeSidebar(){ document.body.classList.remove('sidebar-open'); }

        btnSidebar?.addEventListener('click', () => {
            document.body.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
        });
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // close sidebar on mobile when click links
        document.querySelectorAll('.sidebar a').forEach(a => {
            a.addEventListener('click', () => {
                if(window.innerWidth <= 860) closeSidebar();
            });
        });

        // close sidebar on mobile when click dropdown links
        document.querySelectorAll('.dd-menu a').forEach(a => {
            a.addEventListener('click', () => {
                if(window.innerWidth <= 860) closeSidebar();
            });
        });
    </script>

    @yield('scripts')

</body>
</html>
