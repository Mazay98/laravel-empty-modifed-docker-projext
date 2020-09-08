<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel - empty prepared project
        </div>
        <div class="heart">
            <a href="https://github.com/Mazay98/laravel-empty-modifed-docker-projext">
                <canvas data-scale="16" id="heart"></canvas>
            </a>
        </div>
        <div class="links">
            <a href="https://laravel.com/docs">Docs</a>
            <a href="https://github.com/Mazay98">GitHub</a>
        </div>
    </div>
</div>
</body>
<script>
    const canvas = document.getElementById('heart')
    const s = Number(canvas.getAttribute('data-scale'))

    let ctx = canvas.getContext('2d')
    let t = 'transparent', r = '#f66', w = 'fff', b = '#000'
    let x = 0, y = 0

    const imgData = [
            t, t, t, t, t, t, t, t, t, t, t, t, t,
            t, t, b, b, b, t, t, t, b, b, b, t, t,
            t, b, r, r, r, b, t, b, r, r, r, b, t,
            b, r, w, w, r, r, b, r, r, r, r, r, b,
            b, r, w, r, r, r, r, r, r, r, r, r, b,
            b, r, r, r, r, r, r, r, r, r, r, r, b,
            t, b, r, r, r, r, r, r, r, r, r, b, t,
            t, t, b, r, r, r, r, r, r, r, b, t, t,
            t, t, t, b, r, r, r, r, r, b, t, t, t,
            t, t, t, t, b, r, r, r, b, t, t, t, t,
            t, t, t, t, t, b, r, b, t, t, t, t, t,
            t, t, t, t, t, t, b, t, t, t, t, t, t,
            t, t, t, t, t, t, t, t, t, t, t, t, t,
    ]

    w = 13
    canvas.setAttribute('width', s * w);
    canvas.setAttribute('height', s * w);

    for (let i = 0; i < imgData.length; i++) {
        if (x == w * s) {
            x = 0;
            y += s;
        }
        ctx.fillStyle = imgData[i];
        ctx.fillRect(x, y, s, s);
        x += s;
    }
</script>
</html>
