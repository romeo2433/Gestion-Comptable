<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sidebar — aperçu</title>

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
        --emerald-darker:#0E2B26;
        --gold:#C79A4E;
        --line:#DCD6C8;
    }

    *{ box-sizing:border-box; }

    body{
        margin:0;
        display:flex;
        min-height:100vh;
        background:var(--paper);
        font-family:'Inter', sans-serif;
        color:var(--ink);
    }

    /* ================= SIDEBAR ================= */

    .sidebar{
        width:250px;
        flex:none;
        background:var(--emerald-dark);
        color:#EDEAE1;
        min-height:100vh;
        padding:26px 16px;
        display:flex;
        flex-direction:column;
        position:relative;
    }

    .sidebar::before{
        content:"";
        position:absolute; inset:0;
        background-image:repeating-linear-gradient(
            180deg, rgba(237,234,225,.04) 0px, rgba(237,234,225,.04) 1px,
            transparent 1px, transparent 28px
        );
        pointer-events:none;
    }

    .brand{
        display:flex;
        align-items:center;
        gap:9px;
        font-family:'Fraunces', serif;
        font-weight:500;
        font-size:18px;
        color:#F4F2ED;
        position:relative;
        z-index:1;
    }

    .brand svg{ flex:none; color:var(--gold); }

    .brand-sub{
        font-size:11.5px;
        color:#94A39C;
        margin:4px 0 18px 31px;
        position:relative;
        z-index:1;
    }

    hr{
        border:none;
        border-top:1px solid rgba(237,234,225,.14);
        margin:0 0 18px;
        position:relative;
        z-index:1;
    }

    /* --- user --- */
    .user-block{
        text-align:center;
        margin-bottom:20px;
        position:relative;
        z-index:1;
    }

    .user-block img{
        width:46px;
        height:46px;
        border-radius:50%;
        border:2px solid rgba(237,234,225,.25);
        margin-bottom:10px;
    }

    .user-block h6{
        margin:0 0 3px;
        font-size:14px;
        font-weight:600;
        color:#F4F2ED;
    }

    .user-block small{
        font-size:11.5px;
        color:#94A39C;
    }

    /* --- nav --- */
    .nav-group-label{
        font-size:10.5px;
        color:#7F8F87;
        margin:14px 4px 8px;
        text-transform:uppercase;
        letter-spacing:1.1px;
        font-weight:600;
        position:relative;
        z-index:1;
    }

    .nav-item{
        color:#D8DED9;
        text-decoration:none;
        display:flex;
        align-items:center;
        gap:11px;
        padding:9px 11px;
        border-radius:8px;
        margin-bottom:3px;
        font-size:13.5px;
        font-weight:500;
        border-left:2px solid transparent;
        transition:background .15s ease, color .15s ease;
        position:relative;
        z-index:1;
    }

    .nav-item svg{ flex:none; opacity:.85; }

    .nav-item:hover{
        background:rgba(237,234,225,.07);
        color:#F4F2ED;
    }

    .nav-item.active{
        background:rgba(199,154,78,.15);
        color:#F4F2ED;
        border-left-color:var(--gold);
    }

    .nav-item.active svg{ color:var(--gold); opacity:1; }

    .sidebar-bottom{
        margin-top:auto;
        position:relative;
        z-index:1;
    }

    /* ================= demo content (not part of the sidebar) ================= */

    .demo-main{
        flex:1;
        padding:40px 44px;
    }
    .demo-main h2{
        font-family:'Fraunces', serif;
        font-weight:500;
        margin:0 0 6px;
    }
    .demo-main p{
        color:var(--ink-soft);
        font-size:14px;
        max-width:44ch;
        line-height:1.6;
    }
</style>
</head>
<body>

<div class="sidebar">

    <!-- Logo -->
    <div class="brand">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M6 3h9l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.5"/>
            <path d="M8.5 10h7M8.5 13.5h7M8.5 17h4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Gestion Facturation
    </div>

    <div class="brand-sub">
        Administration
    </div>

    <hr>

    <!-- Utilisateur connecté -->
    <div class="user-block">

        @if(session('nom'))
            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(session('nom')) }}&background=1F5D50&color=F4F2ED"
                alt="{{ session('nom') }}">
        @endif

        <h6>{{ session('nom') }}</h6>

        <small>

            @if(session('role') === 'admin')
                Administrateur
            @elseif(session('role') === 'caissier')
                Caissier
            @elseif(session('role') === 'independant')
                Indépendant
            @endif

        </small>

    </div>

    <div class="nav-group-label">Menu</div>

    <!-- Tableau de bord -->
    <a href="{{ route('dashboard') }}"
       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <rect x="3.5" y="3.5" width="7.5" height="7.5" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
            <rect x="13" y="3.5" width="7.5" height="4.5" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
            <rect x="13" y="10.5" width="7.5" height="10" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
            <rect x="3.5" y="13.5" width="7.5" height="7" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
        </svg>
        Tableau de bord
    </a>

    <!-- Achats -->
    <a href="{{ route('achats.index') }}"
       class="nav-item {{ request()->routeIs('achats.*') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M6 8h12l-1 12.5a1.2 1.2 0 0 1-1.2 1H8.2a1.2 1.2 0 0 1-1.2-1L6 8Z" stroke="currentColor" stroke-width="1.5"/>
            <path d="M9 8V6a3 3 0 0 1 6 0v2" stroke="currentColor" stroke-width="1.5"/>
        </svg>
        Achat
    </a>

   <!-- Ventes -->
    <a href="{{ route('ventes.index') }}"
    class="nav-item {{ request()->routeIs('ventes.*') ? 'active' : '' }}">

    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <path d="M6 3h9l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"
            stroke="currentColor"
            stroke-width="1.5"/>

        <path d="M8.5 10h7M8.5 13.5h7M8.5 17h4.5"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"/>
    </svg>

    Ventes
    </a>
    <!-- Paiements -->
    <a href="{{ route('paiements.index') }}"
       class="nav-item {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="6" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/>
            <path d="M3 10.5h18" stroke="currentColor" stroke-width="1.5"/>
            <path d="M6.5 15h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Paiements
    </a>
    <!-- Entreprise -->
    <a href="{{ route('entreprises.edit') }}"
    class="nav-item {{ request()->routeIs('entreprises.*') ? 'active' : '' }}">

    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <path
            d="M3 21h18"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"/>

        <path
            d="M5 21V5a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16"
            stroke="currentColor"
            stroke-width="1.5"/>

        <path
            d="M15 9h3a1 1 0 0 1 1 1v11"
            stroke="currentColor"
            stroke-width="1.5"/>

        <path
            d="M8 7h4M8 11h4M8 15h4"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"/>
    </svg>

    Entreprise

    </a>

    <!-- Administration : uniquement pour l'admin -->
    @if(session('role') === 'admin')

        <div class="nav-group-label">Administration</div>

        <a href="{{ route('utilisateurs.index') }}"
           class="nav-item {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.5"/>
                <path d="M3 20c.8-3.6 3.3-5.5 6-5.5s5.2 1.9 6 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M16 8.5a2.6 2.6 0 1 0 0-5.2M18.5 20c-.5-2.3-1.6-3.9-3.2-4.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            Utilisateurs
        </a>

    @endif

    <!-- Déconnexion -->
    <div class="sidebar-bottom">
        <hr>
        <a href="{{ route('logout') }}" class="nav-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M9 20H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M16 16l4-4-4-4M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Déconnexion
        </a>
    </div>

</div>



</body>
</html>