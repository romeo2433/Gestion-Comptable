<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Topbar — aperçu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    }

    body{
        margin:0;
        background:var(--paper);
        font-family:'Inter', sans-serif;
        color:var(--ink);
    }

    /* ================= TOPBAR ================= */

    .topbar{
        background:#FFFFFF;
        border-bottom:1px solid var(--line);
        box-shadow:none;
        padding:16px 0;
    }

    .topbar .container-fluid{
        padding-left:32px;
        padding-right:32px;
        display:flex;
        align-items:center;
    }

    .page-title{
        font-family:'Fraunces', serif;
        font-weight:500;
        font-size:21px;
        margin:0 0 2px;
        color:var(--ink);
    }

    .page-sub{
        font-size:13px;
        color:var(--ink-soft);
    }

    .who{
        text-align:right;
        margin-right:14px;
    }
    .who .name{
        font-size:13.5px;
        font-weight:600;
        color:var(--ink);
    }
    .who .role{
        font-size:12px;
        color:var(--ink-soft);
    }

    .avatar{
        width:34px;
        height:34px;
        border-radius:50%;
        background:var(--emerald);
        color:#F4F2ED;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:12.5px;
        font-weight:600;
        flex:none;
    }

    .account-btn{
        display:flex;
        align-items:center;
        gap:9px;
        background:var(--paper);
        border:1px solid var(--line);
        color:var(--ink);
        font-size:13.5px;
        font-weight:500;
        padding:6px 14px 6px 6px;
        border-radius:30px;
        transition:border-color .15s ease, background .15s ease;
    }
    .account-btn:hover,
    .account-btn:focus{
        background:var(--emerald-tint);
        border-color:#CFE1DA;
        color:var(--ink);
    }
    .account-btn::after{
        margin-left:2px;
        opacity:.6;
    }

    .dropdown-menu{
        border:1px solid var(--line);
        border-radius:10px;
        box-shadow:0 6px 20px rgba(27,33,31,.08);
        padding:6px;
        margin-top:8px !important;
        min-width:220px;
    }

    .dropdown-item-text{
        padding:8px 10px 4px;
        font-size:11.5px;
        text-transform:uppercase;
        letter-spacing:.5px;
        color:var(--ink-soft);
    }
    .dropdown-item-text strong{
        display:block;
        font-size:13.5px;
        text-transform:none;
        letter-spacing:0;
        color:var(--ink);
        font-weight:600;
        margin-top:2px;
    }

    .dropdown-divider{
        border-color:var(--line);
        margin:6px 2px;
    }

    .dropdown-item{
        border-radius:7px;
        padding:8px 10px;
        font-size:13.5px;
        color:var(--ink);
        display:flex;
        align-items:center;
        gap:8px;
    }
    .dropdown-item:hover,
    .dropdown-item:focus{
        background:var(--danger-tint, #FBEAE6);
        color:#B3402C;
    }

    /* ================= demo scaffold (not part of the topbar) ================= */
    .demo-body{ padding:40px 32px; color:var(--ink-soft); font-size:14px; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg topbar">

    <div class="container-fluid">

        <div>
            <h4 class="page-title">
                @yield('page-title', 'Tableau de bord')
            </h4>
            <small class="page-sub">
                Bienvenue dans votre espace de gestion.
            </small>
        </div>

        <div class="ms-auto d-flex align-items-center">

            <div class="who">
                <div class="name">{{ session('nom') }}</div>
                <small class="role">

                    @if(session('role') === 'admin')
                        Administrateur
                    @elseif(session('role') === 'caissier')
                        Caissier
                    @elseif(session('role') === 'independant')
                        Indépendant
                    @endif

                </small>
            </div>

            <div class="dropdown">

                <button
                    class="account-btn dropdown-toggle"
                    data-bs-toggle="dropdown"
                    type="button">
                    <span class="avatar">{{ strtoupper(substr(session('nom'), 0, 1)) }}</span>
                    Mon compte
                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <div class="dropdown-item-text">
                            Connecté en tant que
                            <strong>{{ session('email') }}</strong>
                        </div>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                <path d="M9 20H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <path d="M16 16l4-4-4-4M20 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Déconnexion
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>