<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Kuis Pintar</title>
    <style>
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background: #bcd1ff;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
        }
        .card{
            background:#fff9e8;
            width: 520px;
            border-radius:18px;
            padding:40px 40px 28px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.25);
            text-align:center;
        }
        .logo{ font-size:46px; margin-bottom:10px; }
        h1{ margin:0; font-size:34px; }
        .spark{ font-size:20px; vertical-align:middle; }
        .form{ text-align:left; margin-top:22px; }
        label{ display:block; margin-top:18px; font-size:18px; }
        input{
            width:100%;
            margin-top:10px;
            border:0;
            outline:none;
            background:#d8d8d8;
            padding:16px 14px;
            border-radius:12px;
            font-size:16px;
        }
        .btn{
            width:220px;
            display:block;
            margin:26px auto 0;
            background:#d9d9d9;
            border:0;
            padding:14px 16px;
            border-radius:14px;
            font-size:22px;
            cursor:pointer;
        }
        .btn:hover{ filter:brightness(0.95); }
        .alert{
            margin-top:12px;
            padding:12px 14px;
            border-radius:12px;
            font-size:14px;
        }
        .alert-error{ background:#ffd9d9; color:#7b0000; }
        .alert-success{ background:#d9ffdf; color:#0f5b1b; }
    </style>
</head>
<body>

<div class="card">
    <div class="logo">📖</div>
    <h1>Selamat Datang <span class="spark">✨</span></h1>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="form" method="POST" action="{{ route('web.login.submit') }}">
        @csrf

        {{-- penting: API kamu butuh client --}}
        <input type="hidden" name="client" value="web">

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button class="btn" type="submit">Login</button>
    </form>
</div>

</body>
</html>
