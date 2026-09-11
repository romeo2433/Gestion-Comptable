@extends('layouts.app')

@section('title', 'Entreprise')
@section('page-title', 'Informations de l’entreprise')

@section('content')

<div class="container-fluid">

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">

            <strong>
                <i class="bi bi-exclamation-triangle me-2"></i>
                Veuillez corriger les erreurs suivantes :
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif


    {{-- Carte principale --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="mb-1 fw-bold">
                        <i class="bi bi-building me-2"></i>
                        Informations de l’entreprise
                    </h5>

                    <small class="text-muted">
                        Gérez les informations générales et administratives
                        de votre entreprise.
                    </small>
                </div>

            </div>

        </div>


        <div class="card-body">

            <form
                action="{{ route('entreprises.store') }}"
                method="POST">

                @csrf


                {{-- ===================================================== --}}
                {{-- INFORMATIONS GÉNÉRALES --}}
                {{-- ===================================================== --}}

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-building me-2"></i>
                    Informations générales
                </h6>

                <div class="row g-3">

                    {{-- Nom --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Nom de l'entreprise
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="nom"
                            class="form-control"
                            value="{{ old('nom', $entreprise->nom) }}"
                            placeholder="Ex : BICI"
                            required>

                    </div>


                    {{-- Nom commercial --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Nom commercial
                        </label>

                        <input
                            type="text"
                            name="nom_commercial"
                            class="form-control"
                            value="{{ old('nom_commercial', $entreprise->nom_commercial) }}"
                            placeholder="Ex : BICI Informatique">

                    </div>


                    {{-- Forme juridique --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Forme juridique
                        </label>

                        <select
                            name="forme_juridique"
                            class="form-select">

                            <option value="">
                                -- Sélectionner --
                            </option>

                            @foreach([
                                'Entreprise individuelle',
                                'SARL',
                                'SARLU',
                                'SA',
                                'SAS',
                                'SASU',
                                'EURL',
                                'Association',
                                'Autre'
                            ] as $forme)

                                <option
                                    value="{{ $forme }}"
                                    {{ old('forme_juridique', $entreprise->forme_juridique) == $forme ? 'selected' : '' }}>

                                    {{ $forme }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Secteur --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Secteur d'activité
                        </label>

                        <input
                            type="text"
                            name="secteur_activite"
                            class="form-control"
                            value="{{ old('secteur_activite', $entreprise->secteur_activite) }}"
                            placeholder="Ex : Informatique">

                    </div>


                    {{-- Date création --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Date de création
                        </label>

                        <input
                            type="date"
                            name="date_creation"
                            class="form-control"
                            value="{{ old(
                                'date_creation',
                                $entreprise->date_creation
                                    ? $entreprise->date_creation->format('Y-m-d')
                                    : ''
                            ) }}">

                    </div>

                </div>


                <hr class="my-4">


                {{-- ===================================================== --}}
                {{-- COORDONNÉES --}}
                {{-- ===================================================== --}}

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-geo-alt me-2"></i>
                    Coordonnées
                </h6>

                <div class="row g-3">

                    {{-- Adresse --}}
                    <div class="col-md-8">

                        <label class="form-label">
                            Adresse
                        </label>

                        <input
                            type="text"
                            name="adresse"
                            class="form-control"
                            value="{{ old('adresse', $entreprise->adresse) }}"
                            placeholder="Adresse de l'entreprise">

                    </div>


                    {{-- Ville --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Ville
                        </label>

                        <input
                            type="text"
                            name="ville"
                            class="form-control"
                            value="{{ old('ville', $entreprise->ville) }}"
                            placeholder="Ex : Antananarivo">

                    </div>


                    {{-- Téléphone --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Téléphone
                        </label>

                        <input
                            type="text"
                            name="telephone"
                            class="form-control"
                            value="{{ old('telephone', $entreprise->telephone) }}"
                            placeholder="Ex : 033 00 000 00">

                    </div>


                    {{-- Email --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $entreprise->email) }}"
                            placeholder="contact@entreprise.com">

                    </div>


                    {{-- Site web --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Site web
                        </label>

                        <input
                            type="url"
                            name="site_web"
                            class="form-control"
                            value="{{ old('site_web', $entreprise->site_web) }}"
                            placeholder="https://...">

                    </div>

                </div>


                <hr class="my-4">


                {{-- ===================================================== --}}
                {{-- INFORMATIONS ADMINISTRATIVES --}}
                {{-- ===================================================== --}}

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Informations administratives
                </h6>

                <div class="row g-3">

                    {{-- NIF --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            NIF
                        </label>

                        <input
                            type="text"
                            name="nif"
                            class="form-control"
                            value="{{ old('nif', $entreprise->nif) }}"
                            placeholder="Numéro d'identification fiscale">

                    </div>


                    {{-- STAT --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            STAT
                        </label>

                        <input
                            type="text"
                            name="stat"
                            class="form-control"
                            value="{{ old('stat', $entreprise->stat) }}"
                            placeholder="Numéro STAT">

                    </div>


                    {{-- RCS --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            RCS
                        </label>

                        <input
                            type="text"
                            name="rcs"
                            class="form-control"
                            value="{{ old('rcs', $entreprise->rcs) }}"
                            placeholder="Numéro RCS">

                    </div>

                </div>


                <hr class="my-4">


                {{-- ===================================================== --}}
                {{-- INFORMATIONS BANCAIRES --}}
                {{-- ===================================================== --}}

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-bank me-2"></i>
                    Informations bancaires
                </h6>

                <div class="row g-3">

                    {{-- Banque --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Nom de la banque
                        </label>

                        <input
                            type="text"
                            name="nom_banque"
                            class="form-control"
                            value="{{ old('nom_banque', $entreprise->nom_banque) }}"
                            placeholder="Ex : BNI">

                    </div>


                    {{-- Numéro compte --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Numéro de compte
                        </label>

                        <input
                            type="text"
                            name="numero_compte"
                            class="form-control"
                            value="{{ old('numero_compte', $entreprise->numero_compte) }}"
                            placeholder="Numéro du compte bancaire">

                    </div>


                    {{-- Titulaire --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Titulaire du compte
                        </label>

                        <input
                            type="text"
                            name="titulaire_compte"
                            class="form-control"
                            value="{{ old('titulaire_compte', $entreprise->titulaire_compte) }}"
                            placeholder="Nom du titulaire">

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- BOUTON --}}
                {{-- ===================================================== --}}

                @if(session('role') === 'admin')

                    <div class="d-flex justify-content-end mt-4">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-check-lg me-1"></i>
                            Enregistrer les modifications

                        </button>

                    </div>

                @else

                    <div class="alert alert-info mt-4 mb-0">

                        <i class="bi bi-info-circle me-2"></i>

                        Seul l'administrateur peut modifier les informations
                        de l'entreprise.

                    </div>

                @endif

            </form>

        </div>

    </div>

</div>

@endsection