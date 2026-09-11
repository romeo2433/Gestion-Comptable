<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    :root{
        --paper:#F4F2ED;
        --ink:#1B211F;
        --ink-soft:#5B6560;
        --emerald:#1F5D50;
        --emerald-dark:#123832;
        --emerald-tint:#E4EEEB;
        --gold:#B9863A;
        --line:#DCD6C8;
        --white:#FFFFFF;
        --danger:#B3402C;
        --danger-tint:#FBEAE6;
        --danger-line:#E9C7BC;
        --success:#1F5D50;
        --success-tint:#E4EEEB;
        --success-line:#CFE1DA;
        --radius:14px;
    }

    *{ box-sizing:border-box; }

    body{
        margin:0;
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        background:var(--paper);
        background-image:radial-gradient(circle at 1px 1px, rgba(27,33,31,.05) 1px, transparent 0);
        background-size:22px 22px;
        font-family:'Inter', sans-serif;
        color:var(--ink);
        padding:32px 16px;
    }

    .panel{
        width:100%;
        max-width:860px;
        background:var(--white);
        border:1px solid var(--line);
        border-radius:var(--radius);
        display:grid;
        grid-template-columns:0.85fr 1.15fr;
        overflow:hidden;
        box-shadow:0 1px 2px rgba(27,33,31,.04);
        animation:rise .5s ease both;
    }

    @keyframes rise{
        from{ opacity:0; transform:translateY(10px); }
        to{ opacity:1; transform:translateY(0); }
    }

    /* ---------- Brand side ---------- */
    .brand{
        position:relative;
        background:var(--emerald-dark);
        color:#EFEDE4;
        padding:44px 38px;
        display:flex;
        flex-direction:column;
        justify-content:space-between;
    }

    .brand::before{
        content:"";
        position:absolute; inset:0;
        background-image:repeating-linear-gradient(
            180deg, rgba(244,242,237,.05) 0px, rgba(244,242,237,.05) 1px,
            transparent 1px, transparent 28px
        );
        pointer-events:none;
    }

    .mark{
        display:inline-flex;
        align-items:center;
        gap:9px;
        font-family:'Fraunces', serif;
        font-size:19px;
        font-weight:500;
        z-index:1;
    }

    .brand-copy{ z-index:1; }

    .brand-copy h1{
        font-family:'Fraunces', serif;
        font-weight:500;
        font-size:clamp(24px,3vw,29px);
        line-height:1.25;
        margin:0 0 14px;
    }

    .brand-copy p{
        margin:0;
        font-size:14.5px;
        line-height:1.6;
        color:#C9D3CE;
        max-width:28ch;
    }

    .receipt{
        z-index:1;
        border-top:1px dashed rgba(239,237,228,.3);
        padding-top:18px;
        display:flex;
        gap:22px;
    }
    .receipt div p{ margin:0; }
    .receipt .num{ font-family:'Fraunces', serif; font-size:22px; }
    .receipt .lbl{ font-size:11.5px; color:#9FADA6; margin-top:2px; }

    /* ---------- Form side ---------- */
    .form-side{ padding:44px 42px; }

    .form-side h2{
        font-family:'Fraunces', serif;
        font-weight:500;
        font-size:23px;
        margin:0 0 6px;
    }

    .form-side .sub{
        font-size:14px;
        color:var(--ink-soft);
        margin:0 0 22px;
    }

    .alert{
        border-radius:10px;
        padding:11px 14px;
        font-size:13.5px;
        line-height:1.5;
        margin-bottom:18px;
        border:1px solid;
    }
    .alert-success{
        background:var(--success-tint);
        border-color:var(--success-line);
        color:var(--emerald-dark);
    }
    .alert-danger{
        background:var(--danger-tint);
        border-color:var(--danger-line);
        color:var(--danger);
    }

    .field{ margin-bottom:18px; }

    .field label{
        display:block;
        font-size:13px;
        font-weight:500;
        color:var(--ink);
        margin-bottom:6px;
    }

    .field input{
        width:100%;
        padding:11px 13px;
        font-size:14.5px;
        font-family:inherit;
        color:var(--ink);
        background:var(--white);
        border:1px solid var(--line);
        border-radius:9px;
        transition:border-color .15s ease, box-shadow .15s ease;
    }

    .field input:focus{
        outline:none;
        border-color:var(--emerald);
        box-shadow:0 0 0 3px var(--emerald-tint);
    }

    .pass-wrap{ position:relative; }
    .pass-wrap input{ padding-right:44px; }

    .toggle-pass{
        position:absolute;
        right:6px; top:50%;
        transform:translateY(-50%);
        background:none;
        border:none;
        color:var(--ink-soft);
        font-size:12.5px;
        font-family:inherit;
        cursor:pointer;
        padding:6px 8px;
        border-radius:6px;
    }
    .toggle-pass:hover{ color:var(--ink); background:var(--paper); }
    .toggle-pass:focus-visible{ outline:2px solid var(--emerald); outline-offset:1px; }

    .submit-btn{
        width:100%;
        margin-top:6px;
        padding:12px;
        font-family:inherit;
        font-size:14.5px;
        font-weight:600;
        color:#F4F2ED;
        background:var(--emerald);
        border:none;
        border-radius:9px;
        cursor:pointer;
        transition:background .15s ease;
    }
    .submit-btn:hover{ background:var(--emerald-dark); }
    .submit-btn:focus-visible{ outline:2px solid var(--gold); outline-offset:2px; }

    .foot-link{
        text-align:center;
        margin-top:20px;
        font-size:13.5px;
        color:var(--ink-soft);
    }
    .foot-link a{
        color:var(--emerald-dark);
        font-weight:600;
        text-decoration:none;
    }
    .foot-link a:hover{ text-decoration:underline; }

    @media (max-width:760px){
        .panel{ grid-template-columns:1fr; }
        .brand{ padding:32px 28px; }
        .receipt{ display:none; }
        .form-side{ padding:34px 26px; }
    }

    @media (prefers-reduced-motion:reduce){
        .panel{ animation:none; }
    }
</style>
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