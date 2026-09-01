
@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Tableau de bord')

@section('content')

<div class="container-fluid">

    {{-- Message de bienvenue --}}
    <div class="mb-4">

        <h4>
            Bienvenue, {{ session('nom') }}
        </h4>

        <p class="text-muted mb-0">

            @if(session('role') === 'admin')

                Vous êtes connecté en tant qu'administrateur.

            @elseif(session('role') === 'caissier')

                Vous êtes connecté en tant que caissier.

            @elseif(session('role') === 'independant')

                Vous êtes connecté en tant qu'utilisateur indépendant.

            @endif

        </p>

    </div>


    {{-- Cartes principales --}}
    <div class="row g-4">

        {{-- Clients --}}
        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Caissier 
                    </h6>

                    <h2>
                        0
                    </h2>

                </div>

            </div>

        </div>


        {{-- Factures --}}
        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Factures
                    </h6>

                    <h2>
                        0
                    </h2>

                </div>

            </div>

        </div>


        {{-- Paiements --}}
        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Paiements
                    </h6>

                    <h2>
                        0
                    </h2>

                </div>

            </div>

        </div>


        {{-- Utilisateurs --}}
        <div class="col-md-3">

            @if(session('role') === 'admin')

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">
                            Utilisateurs
                        </h6>

                        <h2>
                            Visible
                        </h2>

                        <a
                            href="{{ route('utilisateurs.index') }}"
                            class="btn btn-primary btn-sm">

                            Gérer les utilisateurs

                        </a>

                    </div>

                </div>

            @else

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <h6 class="text-muted">
                            Utilisateurs
                        </h6>

                        <h2>
                            —
                        </h2>

                        <small class="text-muted">
                            Accès réservé à l'administrateur
                        </small>

                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- Informations sur le rôle --}}
    <div class="card shadow-sm border-0 mt-4">

        <div class="card-body">

            <h5>
                Votre compte
            </h5>

            <hr>

            <div class="row">

                <div class="col-md-4">

                    <strong>Nom :</strong>

                    {{ session('nom') }}

                </div>


                <div class="col-md-4">

                    <strong>Email :</strong>

                    {{ session('email') }}

                </div>


                <div class="col-md-4">

                    <strong>Rôle :</strong>


                    @if(session('role') === 'admin')

                        <span class="badge bg-danger">
                            Administrateur
                        </span>

                    @elseif(session('role') === 'caissier')

                        <span class="badge bg-primary">
                            Caissier
                        </span>

                    @elseif(session('role') === 'independant')

                        <span class="badge bg-success">
                            Utilisateur indépendant
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
