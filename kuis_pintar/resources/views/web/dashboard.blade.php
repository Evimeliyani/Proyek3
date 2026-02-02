<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Kuis Pintar</title>

    <style>
        :root{
            --bg: #fbf7e6;
            --sidebar: #bcd1ff;
            --sidebar-soft: rgba(255,255,255,0.35);
            --card-shadow: 0 10px 18px rgba(0,0,0,.15);
            --soft-shadow: 0 12px 28px rgba(0,0,0,.20);
            --radius: 16px;
            --text: #111;
        }

        *{ box-sizing: border-box; }
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--bg);
        }

        .layout{
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */
        .sidebar{
            width: 300px;
            background: var(--sidebar);
            padding: 26px 20px;
            display:flex;
            flex-direction:column;
            gap: 18px;
        }
        .profile{
            display:flex;
            flex-direction:column;
            align-items:center;
            gap: 14px;
            padding: 10px 10px 18px;
        }
        .avatar{
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: rgba(255,255,255,.6);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 40px;
            box-shadow: 0 8px 16px rgba(0,0,0,.18);
        }
        .name{
            font-size: 22px;
            font-weight: 700;
            text-align:center;
        }

        .nav{
            display:flex;
            flex-direction:column;
            gap: 10px;
            margin-top: 10px;
        }

        .nav a, .nav button{
            display:flex;
            align-items:center;
            gap: 12px;
            width:100%;
            border:0;
            text-decoration:none;
            color:#111;
            background: transparent;
            padding: 14px 14px;
            border-radius: 12px;
            cursor:pointer;
            font-size: 20px;
        }
        .nav a.active{
            background: var(--sidebar-soft);
            box-shadow: inset 0 0 0 2px rgba(255,255,255,.35);
        }
        .nav a:hover, .nav button:hover{
            background: rgba(255,255,255,.25);
        }

        .nav .ico{
            width: 34px;
            text-align:center;
            font-size: 22px;
        }

        .spacer{ flex:1; }

        /* CONTENT */
        .content{
            flex:1;
            padding: 38px 44px;
        }
        .heading h1{
            margin:0;
            font-size: 42px;
            line-height: 1.05;
        }
        .heading .sub{
            margin-top:6px;
            color: rgba(0,0,0,.55);
            font-size: 18px;
        }

        /* STAT CARDS */
        .stat-row{
            display:grid;
            grid-template-columns: repeat(3, minmax(240px, 1fr));
            gap: 22px;
            margin-top: 22px;
        }
        .stat-card{
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--card-shadow);
            display:flex;
            align-items:center;
            justify-content:space-between;
            min-height: 96px;
        }
        .stat-left{
            display:flex;
            align-items:center;
            gap: 16px;
        }
        .stat-icon{
            width: 62px;
            height: 62px;
            border-radius: 14px;
            background: rgba(255,255,255,.55);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size: 34px;
        }
        .stat-number{
            font-size: 44px;
            font-weight: 800;
            line-height: 1;
        }
        .stat-label{
            margin-top: 6px;
            font-size: 14px;
            color: rgba(0,0,0,.7);
            font-weight: 700;
        }

        .card-pink{ background: #ffd6da; }
        .card-yellow{ background: #fff4a8; }
        .card-green{ background: #d7ffd5; }

        /* CHART AREA */
        .section-title{
            margin: 28px 0 14px;
            font-size: 30px;
            font-weight: 800;
        }
        .chart-card{
            background: #fff;
            border-radius: 18px;
            box-shadow: var(--soft-shadow);
            padding: 18px 18px 12px;
            max-width: 980px;
        }

        /* Simple responsive */
        @media (max-width: 1100px){
            .stat-row{ grid-template-columns: 1fr; }
            .sidebar{ width: 260px; }
        }
        @media (max-width: 860px){
            .layout{ flex-direction:column; }
            .sidebar{ width:100%; }
            .content{ padding: 22px; }
            .chart-card{ max-width: 100%; }
        }
    </style>
</head>

<body>
<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile">
            <div class="avatar">👩‍🏫</div>
            <div class="name">
                {{ auth()->user()->name ?? 'Audy Zahra A.P' }}
            </div>
        </div>

        <nav class="nav">
            <a class="active" href="{{ route('web.dashboard') }}">
                <span class="ico">🏠</span> Dashboard
            </a>

            <a href="#">
                <span class="ico">📝</span> Quiz
            </a>

            <a href="#">
                <span class="ico">📈</span> Grafik
            </a>

            <a href="#">
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
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <div class="heading">
            <h1>Dashboard</h1>
            <div class="sub">Senin 20 Januari 2026</div>
        </div>

        <!-- STAT CARDS -->
        <section class="stat-row">
            <div class="stat-card card-pink">
                <div class="stat-left">
                    <div class="stat-icon">📚</div>
                    <div>
                        <div class="stat-number">4</div>
                        <div class="stat-label">Kategori Materi</div>
                    </div>
                </div>
            </div>

            <div class="stat-card card-yellow">
                <div class="stat-left">
                    <div class="stat-icon">📋</div>
                    <div>
                        <div class="stat-number">4</div>
                        <div class="stat-label">Jumlah Quiz</div>
                    </div>
                </div>
            </div>

            <div class="stat-card card-green">
                <div class="stat-left">
                    <div class="stat-icon">🧑‍🤝‍🧑</div>
                    <div>
                        <div class="stat-number">23</div>
                        <div class="stat-label">Jumlah Murid</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CHART -->
        <h2 class="section-title">Grafik Quiz Matematika</h2>

        <section class="chart-card">
            <!-- Placeholder chart (SVG) biar tampilannya mirip) -->
            <svg viewBox="0 0 980 420" width="100%" height="auto" aria-label="Chart">
                <!-- frame -->
                <rect x="10" y="10" width="960" height="380" rx="18" fill="#fff" stroke="#e9e9e9"/>
                <!-- grid lines -->
                <g stroke="#efefef" stroke-width="2">
                    <line x1="90" y1="330" x2="930" y2="330"/>
                    <line x1="90" y1="270" x2="930" y2="270"/>
                    <line x1="90" y1="210" x2="930" y2="210"/>
                    <line x1="90" y1="150" x2="930" y2="150"/>
                    <line x1="90" y1="90"  x2="930" y2="90"/>
                </g>

                <!-- y axis labels -->
                <g fill="#222" font-size="18" font-family="Arial">
                    <text x="45" y="336">70</text>
                    <text x="45" y="276">75</text>
                    <text x="45" y="216">80</text>
                    <text x="45" y="156">85</text>
                    <text x="45" y="96">90</text>
                </g>

                <!-- x labels -->
                <g fill="#222" font-size="20" font-family="Arial">
                    <text x="140" y="370">Penjumlahan</text>
                    <text x="360" y="370">Pengurangan</text>
                    <text x="585" y="370">Perkalian</text>
                    <text x="780" y="370">Pembagian</text>
                </g>

                <!-- line -->
                <polyline
                    fill="none"
                    stroke="#b8c9f0"
                    stroke-width="6"
                    points="200,120 420,180 640,250 830,210"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

                <!-- points -->
                <g fill="#2b60ff" stroke="#2b60ff">
                    <circle cx="200" cy="120" r="10"/>
                    <circle cx="420" cy="180" r="10"/>
                    <circle cx="640" cy="250" r="10"/>
                    <circle cx="830" cy="210" r="10"/>
                </g>
            </svg>
        </section>

    </main>
</div>
</body>
</html>
