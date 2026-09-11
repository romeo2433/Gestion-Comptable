<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Informations de l'entreprise</title>

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
        --radius:14px;
    }

    *{ box-sizing:border-box; }

    body{
        margin:0;
        background:var(--paper);
        background-image:radial-gradient(circle at 1px 1px, rgba(27,33,31,.05) 1px, transparent 0);
        background-size:22px 22px;
        font-family:'Inter', sans-serif;
        color:var(--ink);
        padding:40px 16px 60px;
    }

    .wrap{ max-width:840px; margin:0 auto; }

    .card{
        background:var(--white);
        border:1px solid var(--line);
        border-radius:var(--radius);
        overflow:hidden;
        box-shadow:0 1px 2px rgba(27,33,31,.04);
    }

    /* ---------- header ---------- */
    .head{
        background:var(--emerald-dark);
        color:#EFEDE4;
        padding:30px 36px;
        position:relative;
    }
    .head::before{
        content:"";
        position:absolute; inset:0;
        background-image:repeating-linear-gradient(
            180deg, rgba(244,242,237,.05) 0px, rgba(244,242,237,.05) 1px,
            transparent 1px, transparent 28px
        );
        pointer-events:none;
    }
    .head h1{
        font-family:'Fraunces', serif;
        font-weight:500;
        font-size:24px;
        margin:0 0 6px;
        position:relative;
    }
    .head p{
        margin:0;
        font-size:13.5px;
        color:#C9D3CE;
        position:relative;
    }

    .body{ padding:34px 36px 8px; }

    /* ---------- welcome note ---------- */
    .welcome{
        background:var(--emerald-tint);
        border:1px solid #CFE1DA;
        border-radius:10px;
        padding:14px 16px;
        font-size:13.5px;
        line-height:1.55;
        margin-bottom:22px;
    }
    .welcome strong{ color:var(--emerald-dark); }

    /* ---------- errors ---------- */
    .errors{
        background:var(--danger-tint);
        border:1px solid #E9C7BC;
        border-radius:10px;
        padding:14px 16px;
        margin-bottom:22px;
    }
    .errors strong{
        display:block;
        font-size:13.5px;
        color:var(--danger);
        margin-bottom:6px;
    }
    .errors ul{ margin:0; padding-left:18px; }
    .errors li{ font-size:13px; color:#7A2C1D; line-height:1.6; }

    /* ---------- legend ---------- */
    .legend{
        font-size:12.5px;
        color:var(--ink-soft);
        margin-bottom:26px;
    }
    .legend .dot{
        display:inline-block;
        width:5px; height:5px;
        border-radius:50%;
        background:var(--danger);
        margin-right:5px;
        vertical-align:middle;
    }

    /* ---------- sections ---------- */
    .section{ margin-bottom:30px; }

    .section-head{
        display:flex;
        align-items:center;
        gap:9px;
        border-bottom:1px solid var(--line);
        padding-bottom:10px;
        margin-bottom:20px;
    }
    .section-head svg{ color:var(--emerald); flex:none; }
    .section-head h5{
        font-family:'Fraunces', serif;
        font-weight:500;
        font-size:16.5px;
        margin:0;
        color:var(--ink);
    }

    .grid{
        display:grid;
        grid-template-columns:repeat(12, 1fr);
        gap:16px 18px;
    }
    .c6{ grid-column:span 6; }
    .c4{ grid-column:span 4; }
    .c8{ grid-column:span 8; }
    .c12{ grid-column:span 12; }

    .field label{
        display:block;
        font-size:13px;
        font-weight:500;
        color:var(--ink);
        margin-bottom:6px;
    }
    .field .req{ color:var(--danger); }

    .field input,
    .field select{
        width:100%;
        padding:10px 12px;
        font-size:14px;
        font-family:inherit;
        color:var(--ink);
        background:var(--white);
        border:1px solid var(--line);
        border-radius:9px;
        transition:border-color .15s ease, box-shadow .15s ease;
    }
    .field input:focus,
    .field select:focus{
        outline:none;
        border-color:var(--emerald);
        box-shadow:0 0 0 3px var(--emerald-tint);
    }
    .field input::placeholder{ color:#A7ADA9; }

    select{
        appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%235B6560' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right 13px center;
        padding-right:32px;
    }

    /* ---------- footer ---------- */
    .foot{
        display:flex;
        justify-content:flex-end;
        padding:20px 36px 32px;
    }

    .submit-btn{
        padding:12px 26px;
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

    @media (max-width:640px){
        .head, .body{ padding-left:22px; padding-right:22px; }
        .foot{ padding-left:22px; padding-right:22px; }
        .c6,.c4,.c8{ grid-column:span 12; }
    }
</style>
</head>
<body>

<div class="wrap">
    <div class="card">

        <div class="head">
            <h1>Informations de votre entreprise</h1>
            <p>Complétez les informations de votre entreprise</p>
        </div>

        <div class="body">

            @if($errors->any())
                <div class="errors">
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="welcome">
                <strong>Bienvenue {{ session('nom') }} !</strong><br>
                Avant d'accéder à votre espace, veuillez renseigner les informations de votre entreprise.
            </div>

            <div class="legend">
                <span class="dot"></span>Champs obligatoires
            </div>

            <form action="{{ route('entreprise.store') }}" method="POST">
                @csrf

                <!-- ===== Informations générales ===== -->
                <div class="section">
                    <div class="section-head">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M4 21V6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v15" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M14 21V10a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v11" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M7 9h1M7 12h1M7 15h1M17 13h1M17 16h1" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        <h5>Informations générales</h5>
                    </div>

                    <div class="grid">
                        <div class="field c6">
                            <label>Nom de l'entreprise <span class="req">*</span></label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required>
                        </div>

                        <div class="field c6">
                            <label>Nom commercial</label>
                            <input type="text" name="nom_commercial" value="{{ old('nom_commercial') }}">
                        </div>

                        <div class="field c6">
                            <label>Forme juridique <span class="req">*</span></label>
                            <select name="forme_juridique" required>
                                <option value="">-- Choisir --</option>
                                <option value="Entreprise individuelle" {{ old('forme_juridique') == 'Entreprise individuelle' ? 'selected' : '' }}>Entreprise individuelle</option>
                                <option value="SARL" {{ old('forme_juridique') == 'SARL' ? 'selected' : '' }}>SARL</option>
                                <option value="SA" {{ old('forme_juridique') == 'SA' ? 'selected' : '' }}>SA</option>
                                <option value="SAS" {{ old('forme_juridique') == 'SAS' ? 'selected' : '' }}>SAS</option>
                                <option value="Autre" {{ old('forme_juridique') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div class="field c6">
                            <label>Secteur d'activité <span class="req">*</span></label>
                            <input type="text" name="secteur_activite" value="{{ old('secteur_activite') }}" placeholder="Ex : Commerce, Informatique..." required>
                        </div>

                        <div class="field c6">
                            <label>Date de création</label>
                            <input type="date" name="date_creation" value="{{ old('date_creation') }}">
                        </div>
                    </div>
                </div>

                <!-- ===== Coordonnées ===== -->
                <div class="section">
                    <div class="section-head">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21s7-6.3 7-11.5A7 7 0 0 0 5 9.5C5 14.7 12 21 12 21Z" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="12" cy="9.5" r="2.3" stroke="currentColor" stroke-width="1.4"/>
                        </svg>
                        <h5>Coordonnées</h5>
                    </div>

                    <div class="grid">
                        <div class="field c8">
                            <label>Adresse <span class="req">*</span></label>
                            <input type="text" name="adresse" value="{{ old('adresse') }}" required>
                        </div>

                        <div class="field c4">
                            <label>Ville <span class="req">*</span></label>
                            <input type="text" name="ville" value="{{ old('ville') }}" required>
                        </div>

                        <div class="field c6">
                            <label>Téléphone <span class="req">*</span></label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}" required>
                        </div>

                        <div class="field c6">
                            <label>Email professionnel</label>
                            <input type="email" name="email" value="{{ old('email') }}">
                        </div>

                        <div class="field c12">
                            <label>Site web</label>
                            <input type="text" name="site_web" value="{{ old('site_web') }}" placeholder="https://...">
                        </div>
                    </div>
                </div>

                <!-- ===== Informations légales ===== -->
                <div class="section">
                    <div class="section-head">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M6 3h9l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M8.5 10h7M8.5 13.5h7M8.5 17h4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        <h5>Informations légales</h5>
                    </div>

                    <div class="grid">
                        <div class="field c4">
                            <label>NIF</label>
                            <input type="text" name="nif" value="{{ old('nif') }}">
                        </div>

                        <div class="field c4">
                            <label>STAT</label>
                            <input type="text" name="stat" value="{{ old('stat') }}">
                        </div>

                        <div class="field c4">
                            <label>RCS</label>
                            <input type="text" name="rcs" value="{{ old('rcs') }}">
                        </div>
                    </div>
                </div>

                <!-- ===== Informations bancaires ===== -->
                <div class="section">
                    <div class="section-head">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M3 9.5 12 4l9 5.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5 10v9M9.5 10v9M14.5 10v9M19 10v9" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M3.5 19.5h17" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        <h5>Informations bancaires</h5>
                    </div>

                    <div class="grid">
                        <div class="field c4">
                            <label>Nom de la banque</label>
                            <input type="text" name="nom_banque" value="{{ old('nom_banque') }}">
                        </div>

                        <div class="field c4">
                            <label>Numéro de compte</label>
                            <input type="text" name="numero_compte" value="{{ old('numero_compte') }}">
                        </div>

                        <div class="field c4">
                            <label>Titulaire du compte</label>
                            <input type="text" name="titulaire_compte" value="{{ old('titulaire_compte') }}">
                        </div>
                    </div>
                </div>

                <div class="foot">
                    <button type="submit" class="submit-btn">Enregistrer mon entreprise</button>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>