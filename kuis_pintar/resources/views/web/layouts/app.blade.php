<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Proyek 3')</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@600;700;800;900&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Nunito', Arial, sans-serif;
            background: #fbf7e6;
            color: #111827;
        }

        a {
            color: inherit;
        }

        .page-shell {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            padding: 34px 38px;
            background: #fbf7e6;
        }

        .topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: rgba(255,255,255,.78);
            border-bottom: 1px solid rgba(0,0,0,.08);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(8px);
        }

        .hamburger {
            border: 0;
            background: #ffffff;
            border-radius: 14px;
            padding: 9px 12px;
            cursor: pointer;
            box-shadow: 0 5px 0 #d7e4ff;
            font-size: 18px;
            font-weight: 900;
        }

        .hamburger:active {
            transform: translateY(3px);
            box-shadow: 0 2px 0 #d7e4ff;
        }

        .topbar-title {
            font-weight: 900;
            font-size: 16px;
        }

        .sidebar-overlay {
            display: none;
        }

        .card,
        .box,
        .panel,
        .quiz-card,
        .task-card,
        .stat-card {
            border-radius: 24px !important;
            box-shadow:
                0 10px 0 rgba(210, 205, 180, .45),
                0 20px 30px rgba(60, 60, 60, .10) !important;
        }

        button,
        .btn,
        .button {
            font-family: 'Nunito', Arial, sans-serif;
            border-radius: 18px;
            font-weight: 900;
            transition: .16s ease;
        }

        table {
            overflow: hidden;
        }

        thead,
        .table-light {
            background: #c7d9ff !important;
        }

        @media (max-width: 860px) {
            .topbar {
                display: flex;
            }

            .page-shell {
                display: block;
            }

            .main-content {
                padding: 18px 14px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.35);
                z-index: 70;
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    <div class="topbar">
        <button class="hamburger" type="button" id="btnSidebar">☰</button>
        <div class="topbar-title">@yield('topbar_title','Proyek 3')</div>
        <div style="width:44px"></div>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="page-shell">
        @include('web.layouts.sidebar')

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        const btnSidebar = document.getElementById('btnSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function closeSidebar() {
            document.body.classList.remove('sidebar-open');
        }

        btnSidebar?.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-open');
        });

        sidebarOverlay?.addEventListener('click', closeSidebar);

        document.querySelectorAll('.app-sidebar a').forEach(a => {
            a.addEventListener('click', () => {
                if (window.innerWidth <= 860) closeSidebar();
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
