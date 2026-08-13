<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
        }

        .register-box{
            margin-top:60px;
            border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,.15);
        }

    </style>

</head>
<body>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card register-box">

                <div class="card-header bg-success text-white text-center">

                    <h3>Inscription</h3>

                </div>

                <div class="card-body">

                    <form action="{{ route('register.store') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label>Nom</label>

                            <input
                                type="text"
                                name="nom"
                                class="form-control"
                                required>

                        </div>

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
                        <button class="btn btn-success w-100">
                            S'inscrire
                        </button>
                    </form>

                    <div class="text-center mt-3">

                        <a href="{{ route('login') }}">
                            Déjà un compte ? Se connecter
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>