@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Tableau de bord')

@section('content')

<div class="container-fluid">

    {{-- Bienvenue --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-4">

            <h3 class="mb-2">
                Bienvenue, {{ session('nom') }}
            </h3>

            <p class="text-muted mb-0">

                @if(session('role') === 'admin')

                    Bienvenue sur votre espace d'administration.
                    Vous pouvez suivre les utilisateurs, les factures de vente
                    et les factures d'achat enregistrées dans le système.

                @elseif(session('role') === 'caissier')

                    Bienvenue sur votre espace de gestion.
                    Depuis ce tableau de bord, vous pouvez suivre vos factures
                    de vente et vos factures d'achat.

                @elseif(session('role') === 'independant')

                    Bienvenue sur votre espace personnel.
                    Vous pouvez gérer vos factures de vente et vos factures
                    d'achat en toute indépendance.

                @endif

            </p>

        </div>
    </div>


    {{-- Statistiques --}}
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
                        Comptes caissiers
                    </small>

                </div>
            </div>

        </div>

        @endif


        {{-- Factures de vente --}}
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
                        Factures de vente enregistrées
                    </small>

                </div>
            </div>

        </div>


        {{-- Factures d'achat --}}
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
                        Factures d'achat enregistrées
                    </small>

                </div>
            </div>

        </div>


        {{-- Factures impayées --}}
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


    {{-- Présentation du tableau de bord --}}
    <div class="card shadow-sm border-0 mt-4">

        <div class="card-body">

            <h5 class="mb-3">
                Vue d'ensemble
            </h5>

            <p class="text-muted mb-0">
                Ce tableau de bord vous permet d'avoir une vue rapide sur
                l'activité de votre compte. Les informations affichées
                correspondent à vos droits d'accès et à votre rôle dans
                l'application.
            </p>

        </div>

    </div>
    {{-- Graphique : uniquement pour l'administrateur --}}
        @if(session('role') === 'admin')

        <div class="card shadow-sm border-0 mt-4 mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <h5 class="mb-1">
                            Activité des factures
                        </h5>

                        <p class="text-muted mb-0">
                            Nombre de factures par mois et par type d'utilisateur
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


        {{-- Chart.js --}}
        @if(session('role') === 'admin')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            const labels = @json($labelsGraphique);

            const ventesCaissiers = @json($ventesCaissiers);

            const achatsCaissiers = @json($achatsCaissiers);

            const ventesIndependants = @json($ventesIndependants);

            const achatsIndependants = @json($achatsIndependants);


            const ctx = document
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