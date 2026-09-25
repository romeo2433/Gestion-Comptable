<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inscription</title>

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
            <h1>Vos factures,<br>lues et classées&nbsp;en&nbsp;un&nbsp;instant.</h1>
            <p>Scannez un ticket, l'IA en extrait les données, votre comptabilité reste à jour — sans ressaisie.</p>
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
        <h2>Créer un compte</h2>
        <p class="sub">Quelques informations pour commencer.</p>

        <form action="{{ route('register.store') }}" method="POST" novalidate>
            @csrf

            <div class="field">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required autocomplete="name">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>

            <div class="field">
                <label for="mot_de_passe">Mot de passe</label>
                <div class="pass-wrap">
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required autocomplete="new-password">
                    <button type="button" class="toggle-pass" onclick="
                        const i=document.getElementById('mot_de_passe');
                        i.type = i.type==='password' ? 'text' : 'password';
                        this.textContent = i.type==='password' ? 'Afficher' : 'Masquer';
                    ">Afficher</button>
                </div>
            </div>

            <!-- Type de compte : le sélecteur "role-field" sert de point d'ancrage
                 pour la révélation CSS pur du champ département juste en dessous -->
            <div class="field role-field">
                <label>Type de compte</label>

                <div class="role-group">

                    <label class="role-card">
                        <input
                            type="radio"
                            name="role"
                            value="caissier"
                            required
                        >

                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <rect
                                x="3"
                                y="7"
                                width="18"
                                height="12"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="1.4"
                            />
                            <path
                                d="M3 11h18M7 15h4"
                                stroke="currentColor"
                                stroke-width="1.4"
                                stroke-linecap="round"
                            />
                        </svg>

                        <div class="r-title">Comptable</div>
                        <div class="r-desc">Rattaché à un département</div>
                    </label>


                    <label class="role-card">
                        <input
                            type="radio"
                            name="role"
                            value="independant"
                            required
                        >

                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <circle
                                cx="12"
                                cy="8"
                                r="3.2"
                                stroke="currentColor"
                                stroke-width="1.4"
                            />
                            <path
                                d="M5.5 20c1-3.8 4-5.5 6.5-5.5s5.5 1.7 6.5 5.5"
                                stroke="currentColor"
                                stroke-width="1.4"
                                stroke-linecap="round"
                            />
                        </svg>

                        <div class="r-title">Indépendant</div>
                        <div class="r-desc">Gère son activité seul</div>
                    </label>

                </div>
            </div>


            <!-- Département : révélé uniquement en CSS quand "caissier" est coché
                 (voir .role-field:has(input[value="caissier"]:checked) + #departement-container) -->
            <div
                class="field"
                id="departement-container"
            >

                <label for="id_departement">
                    Département <span style="color:red;">*</span>
                </label>

                <select
                    id="id_departement"
                    name="id_departement"
                >

                    <option value="">
                        -- Sélectionner un département --
                    </option>

                    @foreach(DB::table('departements')->orderBy('nom')->get() as $departement)

                        <option value="{{ $departement->id_departement }}">
                            {{ $departement->nom }}
                        </option>

                    @endforeach

                </select>

                @error('id_departement')
                    <small style="color:red;">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <button type="submit" class="submit-btn">S'inscrire</button>
        </form>

        <div class="foot-link">
            Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>

</div>

</body>
</html>