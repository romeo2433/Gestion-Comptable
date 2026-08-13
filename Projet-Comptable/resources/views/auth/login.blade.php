<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f5f5;
        }

        .login-box{
            margin-top:90px;
            border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,.15);
        }
    </style>
</head>
<body>


<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card login-box">

                <div class="card-header text-center bg-primary text-white">
                    <h3>Connexion</h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Mot de passe</label>

                            <input
                                type="password"
                                name="mot_de_passe"
                                class="form-control"
                                required>

                        </div>

                        <button class="btn btn-primary w-100">

                            Se connecter

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="{{ route('register') }}">
                            Créer un compte
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>