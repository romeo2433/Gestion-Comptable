<div class="sidebar">

    <!-- Logo -->
    <div class="brand">
        Gestion Facturation
    </div>

    <div class="brand-sub">
        Administration
    </div>

    <hr style="border-color:rgba(255,255,255,.15);">

    <!-- Utilisateur connecté -->
    <div class="text-center mb-4">

        <img src="https://ui-avatars.com/api/?name={{ urlencode(session('utilisateur')->nom) }}&background=ffffff&color=1B2A4A"
             class="rounded-circle mb-2"
             width="70">

        <h6 class="text-white mb-1">
            {{ session('utilisateur')->nom }}
        </h6>

        <small class="text-light">

            @if(session('utilisateur')->role=="admin")

                Administrateur

            @else

                Caissier

            @endif

        </small>

    </div>

    <div class="nav-group-label">
        MENU
    </div>

    <!-- Tableau de bord -->
    <a href="{{ route('dashboard') }}"
       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

        <span class="nav-dot"></span>

        Tableau de bord

    </a>

    <!-- Clients -->
    <a href="{{ route('achats.index') }}"
       class="nav-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">

        <span class="nav-dot"></span>

        Achat

    </a>

    <!-- Factures -->
    <a href="{{ route('factures.index') }}"
       class="nav-item {{ request()->routeIs('factures.*') ? 'active' : '' }}">

        <span class="nav-dot"></span>

        Ventes

    </a>

    <!-- Paiements -->
    <a href="{{ route('paiements.index') }}"
       class="nav-item {{ request()->routeIs('paiements.*') ? 'active' : '' }}">

        <span class="nav-dot"></span>

        Paiements

    </a>

    <!-- Visible uniquement par l'administrateur -->
    @if(session('utilisateur')->role=="admin")

        <div class="nav-group-label">
            Administration
        </div>

        <a href="{{ route('utilisateurs.index') }}"
           class="nav-item {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">

            <span class="nav-dot"></span>

            Utilisateurs

        </a>

    @endif

    <div style="margin-top:auto;">

        <hr style="border-color:rgba(255,255,255,.15);">

        <a href="{{ route('logout') }}"
           class="nav-item">

            <span class="nav-dot"></span>

            Déconnexion

        </a>

    </div>

</div>

<style>

.sidebar{

    width:250px;

    background:#1B2A4A;

    color:white;

    min-height:100vh;

    padding:25px 18px;

    display:flex;

    flex-direction:column;

}

.brand{

    font-size:24px;

    font-family:'Fraunces',serif;

    font-weight:bold;

}

.brand-sub{

    font-size:12px;

    color:#d4d4d4;

    margin-bottom:20px;

}

.nav-group-label{

    font-size:11px;

    color:#aaa;

    margin:15px 0 10px;

    text-transform:uppercase;

    letter-spacing:1px;

}

.nav-item{

    color:white;

    text-decoration:none;

    display:flex;

    align-items:center;

    gap:10px;

    padding:12px;

    border-radius:6px;

    margin-bottom:5px;

    transition:.3s;

}

.nav-item:hover{

    background:rgba(255,255,255,.1);

    color:white;

}

.nav-item.active{

    background:#B5502F;

    color:white;

}

.nav-dot{

    width:8px;

    height:8px;

    border-radius:50%;

    background:white;

}

</style>