<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
        }

        .login-box,
        .register-box{

            margin-top:90px;

            border-radius:10px;

            box-shadow:0 0 15px rgba(0,0,0,.15);

        }

    </style>

    @stack('css')

</head>

<body>

<div class="container">

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('js')

</body>

</html>