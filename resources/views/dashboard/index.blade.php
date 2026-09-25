@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Tableau de bord')

@section('content')

<div class="container-fluid">


    {{-- ========================================================= --}}
    {{-- BIENVENUE --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body py-4">

            <h3 class="mb-2">
                Bienvenue, {{ session('nom') }}
            </h3>

            <p class="text-muted mb-0">

                @if(session('role') === 'admin')

                    Bienvenue sur votre espace d'administration.
                    Vous pouvez suivre les utilisateurs, les factures
                    de vente et les factures d'achat.

                @elseif(session('role') === 'caissier')

                    Bienvenue sur votre espace de gestion.
                    Vous pouvez suivre vos factures de vente
                    et vos factures d'achat.

                @elseif(session('role') === 'independant')

                    Bienvenue sur votre espace personnel.
                    Vous pouvez gérer vos factures de vente
                    et vos factures d'achat.

                @endif

            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FILTRE ADMIN --}}
    {{-- ========================================================= --}}

    @if(session('role') === 'admin')

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h5 class="mb-1">
                            Filtrer par département
                        </h5>

                        <p class="text-muted mb-0">
                            Affichez les activités d'un département spécifique.
                        </p>

                    </div>

                    @if($nomDepartementSelectionne)

                        <span class="badge bg-primary">
                            {{ $nomDepartementSelectionne }}
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Tous les départements
                        </span>

                    @endif

                </div>


                <form
                    method="GET"
                    action="{{ route('dashboard') }}"
                    class="row g-3 align-items-end"
                >

                    <div class="col-md-6">

                        <label
                            for="departement"
                            class="form-label"
                        >
                            Département
                        </label>

                        <select
                            name="departement"
                            id="departement"
                            class="form-select"
                        >

                            <option value="">
                                Tous les départements
                            </option>

                            @foreach($departements as $departement)

                                <option
                                    value="{{ $departement->id_departement }}"
                                    {{ (string) $departementSelectionne === (string) $departement->id_departement ? 'selected' : '' }}
                                >
                                    {{ $departement->nom }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-auto">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Filtrer
                        </button>

                    </div>


                    @if(!empty($departementSelectionne))

                        <div class="col-md-auto">

                            <a
                                href="{{ route('dashboard') }}"
                                class="btn btn-outline-secondary"
                            >
                                Réinitialiser
                            </a>

                        </div>

                    @endif

                </form>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- STATISTIQUES --}}
    {{-- ========================================================= --}}

    <div class="row g-4">


        {{-- Caissiers --}}
        @if(session('role') === 'admin')

            <div class="col-md-3">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <h6 class="text-muted">
                            Caissiers
                        </h6>

                        <h2>
                            {{ $nombreCaissiers }}
                        </h2>

                        <small class="text-muted">

                            @if($nomDepartementSelectionne)

                                Dans {{ $nomDepartementSelectionne }}

                            @else

                                Tous les départements

                            @endif

                        </small>

                    </div>

                </div>

            </div>

        @endif


        {{-- Factures vente --}}
        <div class="col-md-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Factures de vente
                    </h6>

                    <h2>
                        {{ $nombreFacturesVente }}
                    </h2>

                    <small class="text-muted">

                        @if($nomDepartementSelectionne)

                            {{ $nomDepartementSelectionne }}

                        @else

                            Tous les départements

                        @endif

                    </small>

                </div>

            </div>

        </div>


        {{-- Factures achat --}}
        <div class="col-md-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Factures d'achat
                    </h6>

                    <h2>
                        {{ $nombreFacturesAchat }}
                    </h2>

                    <small class="text-muted">

                        @if($nomDepartementSelectionne)

                            {{ $nomDepartementSelectionne }}

                        @else

                            Tous les départements

                        @endif

                    </small>

                </div>

            </div>

        </div>


        {{-- Impayées --}}
        <div class="col-md-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Factures impayées
                    </h6>

                    <h2>
                        {{ $nombreImpayees }}
                    </h2>

                    <small class="text-muted">
                        Factures à vérifier
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMATION FILTRE --}}
    {{-- ========================================================= --}}

    @if(session('role') === 'admin')

        <div class="card shadow-sm border-0 mt-4">

            <div class="card-body">

                <h5 class="mb-2">
                    Vue d'ensemble
                </h5>

                @if($nomDepartementSelectionne)

                    <p class="text-muted mb-0">

                        Les statistiques affichées correspondent
                        uniquement au département
                        <strong>
                            {{ $nomDepartementSelectionne }}
                        </strong>.

                    </p>

                @else

                    <p class="text-muted mb-0">

                        Les statistiques affichées correspondent
                        à l'ensemble des départements.

                    </p>

                @endif

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- GRAPHIQUE ADMIN --}}
    {{-- ========================================================= --}}

    @if(session('role') === 'admin')

        <div class="card shadow-sm border-0 mt-4 mb-4">

            <div class="card-body">


                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h5 class="mb-1">
                            Activité des factures
                        </h5>

                        <p class="text-muted mb-0">

                            @if($nomDepartementSelectionne)

                                Activité du département
                                <strong>
                                    {{ $nomDepartementSelectionne }}
                                </strong>

                            @else

                                Activité de tous les départements

                            @endif

                        </p>

                    </div>


                    <span class="badge bg-light text-dark">

                        12 derniers mois

                    </span>

                </div>


                <div style="height: 380px;">

                    <canvas id="facturesChart"></canvas>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- CHART.JS --}}
    {{-- ========================================================= --}}

    @if(session('role') === 'admin')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            const labels =
                @json($labelsGraphique);

            const ventesCaissiers =
                @json($ventesCaissiers);

            const achatsCaissiers =
                @json($achatsCaissiers);

            const ventesIndependants =
                @json($ventesIndependants);

            const achatsIndependants =
                @json($achatsIndependants);


            const ctx =
                document
                    .getElementById('facturesChart')
                    .getContext('2d');


            new Chart(ctx, {

                type: 'line',

                data: {

                    labels: labels,

                    datasets: [

                        {
                            label: 'Ventes - Caissiers',

                            data: ventesCaissiers,

                            borderWidth: 2,

                            tension: 0.3,

                            fill: false
                        },

                        {
                            label: 'Achats - Caissiers',

                            data: achatsCaissiers,

                            borderWidth: 2,

                            tension: 0.3,

                            fill: false
                        },

                        {
                            label: 'Ventes - Indépendants',

                            data: ventesIndependants,

                            borderWidth: 2,

                            tension: 0.3,

                            fill: false
                        },

                        {
                            label: 'Achats - Indépendants',

                            data: achatsIndependants,

                            borderWidth: 2,

                            tension: 0.3,

                            fill: false
                        }

                    ]

                },


                options: {

                    responsive: true,

                    maintainAspectRatio: false,


                    interaction: {

                        intersect: false,

                        mode: 'index'

                    },


                    plugins: {

                        legend: {

                            position: 'bottom'

                        },


                        tooltip: {

                            callbacks: {

                                label: function(context) {

                                    return context.dataset.label
                                        + ' : '
                                        + context.parsed.y
                                        + ' facture(s)';

                                }

                            }

                        }

                    },


                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            },

                            title: {

                                display: true,

                                text: 'Nombre de factures'

                            }

                        },


                        x: {

                            title: {

                                display: true,

                                text: 'Mois'

                            }

                        }

                    }

                }

            });

        </script>

    @endif


</div>

@endsection