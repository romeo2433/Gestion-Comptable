<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','Gestion de Facturation')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>

        :root{
            --ink:#1B2A4A;
            --ink-light:#2E4268;
            --paper:#ffffff;
            --parchment:#F6F3EC;
            --brick:#B5502F;
            --clay-line:#D8CFBF;
            --danger:#B23A3A;
            --success:#4C6B52;
        }

        *{
            box-sizing:border-box;
        }

        body{

            margin:0;

            background:#e8e4da;

            font-family:'Inter',sans-serif;

            color:var(--ink);

        }

        .wrapper{

            display:flex;

            min-height:100vh;

        }

        .content{

            flex:1;

            display:flex;

            flex-direction:column;

        }

        .main-content{

            padding:30px;

            flex:1;

        }

        .card-custom{

            background:white;

            border:1px solid var(--clay-line);

            border-radius:6px;

            padding:20px;

        }

        h1,h2,h3{

            font-family:'Fraunces',serif;

        }

    </style>

    @stack('css')

</head>

<body>

<div class="wrapper">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="content">

        {{-- Navbar --}}
        @include('partials.navbar')

        <main class="main-content">

            @yield('content')

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('js')

</body>

</html>