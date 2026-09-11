
@extends('layouts.app')

@section('title', 'Détail de l’achat')
@section('page-title', 'Détail de la facture')

@section('content')

<div class="card border-0 shadow-sm">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0 fw-bold">
            <i class="bi bi-receipt"></i>
            Détail de la facture
        </h5>

        <a href="{{ route('achats.index') }}"
           class="btn btn-sm btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>
            Retour

        </a>

    </div>


    <div class="card-body">

        <div class="row g-4">


            {{-- ========================================================= --}}
            {{-- COLONNE GAUCHE : INFORMATIONS --}}
            {{-- ========================================================= --}}

            <div class="col-lg-6">

                {{-- INFORMATIONS GENERALES --}}
                <div class="card border mb-4">

                    <div class="card-header bg-light fw-bold">
                        <i class="bi bi-info-circle"></i>
                        Informations de la facture
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <strong>Numéro de facture</strong>

                                <div class="text-muted">
                                    {{ $achat->numero_facture ?? 'Non renseigné' }}
                                </div>

                            </div>


                            <div class="col-md-6 mb-3">

                                <strong>Fournisseur</strong>

                                <div class="text-muted">
                                    {{ $achat->nom_fournisseur ?? 'Non renseigné' }}
                                </div>

                            </div>


                            <div class="col-md-6 mb-3">

                                <strong>Date de facture</strong>

                                <div class="text-muted">

                                    {{ $achat->date_facture
                                        ? \Carbon\Carbon::parse($achat->date_facture)->format('d/m/Y')
                                        : 'Non renseignée'
                                    }}

                                </div>

                            </div>


                            <div class="col-md-6 mb-3">

                                <strong>Date d'échéance</strong>

                                <div class="text-muted">

                                    {{ $achat->date_echeance
                                        ? \Carbon\Carbon::parse($achat->date_echeance)->format('d/m/Y')
                                        : 'Non renseignée'
                                    }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- MONTANTS --}}
                {{-- ========================================================= --}}

                <div class="card border mb-4">

                    <div class="card-header bg-light fw-bold">

                        <i class="bi bi-cash-stack"></i>
                        Montants

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <small class="text-muted">
                                    Montant HT
                                </small>

                                <div class="fw-semibold">

                                    {{ number_format($achat->montant_ht, 0, ',', ' ') }}
                                    Ar

                                </div>

                            </div>


                            <div class="col-md-4 mb-3">

                                <small class="text-muted">
                                    TVA
                                </small>

                                <div class="fw-semibold">

                                    {{ number_format($achat->montant_tva, 0, ',', ' ') }}
                                    Ar

                                </div>

                            </div>


                            <div class="col-md-4 mb-3">

                                <small class="text-muted">
                                    Total TTC
                                </small>

                                <div class="fw-bold text-primary">

                                    {{ number_format($achat->montant_ttc, 0, ',', ' ') }}
                                    Ar

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- COMPTABILITE --}}
                {{-- ========================================================= --}}

                <div class="card border mb-4">

                    <div class="card-header bg-light fw-bold">

                        <i class="bi bi-calculator"></i>
                        Comptabilité

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <strong>Compte de charge</strong>

                                <div class="text-muted">

                                    {{ $achat->compte_charge ?? 'Non renseigné' }}

                                </div>

                            </div>


                            <div class="col-md-6 mb-3">

                                <strong>Compte TVA</strong>

                                <div class="text-muted">

                                    {{ $achat->compte_tva ?? 'Non renseigné' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- LIGNES DE FACTURE --}}
                {{-- ========================================================= --}}

                <div class="card border mb-4">

                    <div class="card-header bg-light fw-bold">

                        <i class="bi bi-list-ul"></i>
                        Lignes de facture

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th>Désignation</th>
                                        <th>Qté</th>
                                        <th>Prix unitaire</th>
                                        <th>Montant</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($lignes as $ligne)

                                        <tr>

                                            <td>
                                                {{ $ligne->designation }}
                                            </td>

                                            <td>
                                                {{ $ligne->quantite }}
                                            </td>

                                            <td>

                                                {{ number_format(
                                                    $ligne->prix_unitaire,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}
                                                Ar

                                            </td>

                                            <td>

                                                {{ number_format(
                                                    $ligne->montant,
                                                    0,
                                                    ',',
                                                    ' '
                                                ) }}
                                                Ar

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="4"
                                                class="text-center text-muted py-3">

                                                Aucune ligne de facture.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- COLONNE DROITE : FACTURE --}}
            {{-- ========================================================= --}}

            <div class="col-lg-6">

                <div class="card border">

                    <div class="card-header bg-light d-flex justify-content-between align-items-center">

                        <span class="fw-bold">

                            <i class="bi bi-file-earmark-text"></i>
                            Aperçu de la facture

                        </span>

                        @if($achat->fichier_facture)

                        <a href="{{ route('facture.preview', $achat->id_facture) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary">
                         
                             <i class="bi bi-box-arrow-up-right"></i>
                             Ouvrir
                         
                         </a>

                        @endif

                    </div>


                    <div class="card-body p-2"
                         style="height: 80vh; overflow: auto; background: #f5f5f5;">

                        @if($achat->fichier_facture)

                            @php

                                $extension = strtolower(
                                    pathinfo(
                                        $achat->fichier_facture,
                                        PATHINFO_EXTENSION
                                    )
                                );

                            @endphp


                            {{-- PDF --}}
                            @if($extension === 'pdf')

                            <iframe
                                src="{{ route('facture.preview', $achat->id_facture) }}"
                                width="100%"
                                height="100%"
                                style="border:none;">
                            </iframe>

                            {{-- IMAGE --}}
                            @elseif(in_array($extension, ['jpg', 'jpeg', 'png']))

                                <div class="text-center">

                                    <img
                                        src="{{ asset('storage/' . $achat->fichier_facture) }}"
                                        alt="Facture"
                                        class="img-fluid"
                                        style="
                                            max-width: 100%;
                                            height: auto;
                                            box-shadow: 0 2px 10px rgba(0,0,0,.15);
                                        "
                                    >

                                </div>


                            {{-- FORMAT INCONNU --}}
                            @else

                                <div class="alert alert-warning m-3">

                                    Format de fichier non supporté.

                                </div>

                            @endif


                        @else

                            <div class="text-center text-muted py-5">

                                <i class="bi bi-file-earmark-x fs-1"></i>

                                <p class="mt-3">
                                    Aucun fichier de facture disponible.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection