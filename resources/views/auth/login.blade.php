<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

<div class="panel">

    <div class="brand">
        <span class="mark">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <path d="M6 3h9l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.4"/>
                <path d="M8.5 10h7M8.5 13.5h7M8.5 17h4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
            Factures
        </span>

        <div class="brand-copy">
            <h1>Content de vous revoir.</h1>
            <p>Reprenez là où vous vous êtes arrêté : vos factures scannées et classées vous attendent.</p>
        </div>

        <div class="receipt">
            <div>
                <p class="num">02s</p>
                <p class="lbl">par scan</p>
            </div>
            <div>
                <p class="num">100%</p>
                <p class="lbl">sans ressaisie</p>
            </div>
        </div>
    </div>

    <div class="form-side">
        <h2>Connexion</h2>
        <p class="sub">Entrez vos identifiants pour accéder à votre espace.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>

            <div class="field">
                <label for="mot_de_passe">Mot de passe</label>
                <div class="pass-wrap">
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required autocomplete="current-password">
                    <button type="button" class="toggle-pass" onclick="
                        const i=document.getElementById('mot_de_passe');
                        i.type = i.type==='password' ? 'text' : 'password';
                        this.textContent = i.type==='password' ? 'Afficher' : 'Masquer';
                    ">Afficher</button>
                </div>
            </div>

            <button type="submit" class="submit-btn">Se connecter</button>
        </form>

        <div class="foot-link">
            Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>

</div>

</body>
</html>