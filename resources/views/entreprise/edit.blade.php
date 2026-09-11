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
                Veuillez corriger les erreurs :
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif


    <form
        action="{{ route('entreprises.update') }}"
        method="POST">

        @csrf
        @method('PUT')


        {{-- ================================================= --}}
        {{-- INFORMATIONS GENERALES --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="mb-1 fw-bold">
                    <i class="bi bi-building me-2"></i>
                    Informations générales
                </h5>

                <small class="text-muted">
                    Informations principales de votre entreprise.
                </small>

            </div>

            <div class="card-body">

                <div class="row g-3">

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
                            required>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Nom commercial
                        </label>

                        <input
                            type="text"
                            name="nom_commercial"
                            class="form-control"
                            value="{{ old('nom_commercial', $entreprise->nom_commercial) }}">

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Forme juridique
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="forme_juridique"
                            class="form-select"
                            required>

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


                    <div class="col-md-6">

                        <label class="form-label">
                            Secteur d'activité
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="secteur_activite"
                            class="form-control"
                            value="{{ old('secteur_activite', $entreprise->secteur_activite) }}"
                            required>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Date de création
                        </label>

                        <input
                            type="date"
                            name="date_creation"
                            class="form-control"
                            value="{{ old('date_creation', $entreprise->date_creation) }}">

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- COORDONNEES --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="mb-1 fw-bold">
                    <i class="bi bi-geo-alt me-2"></i>
                    Coordonnées
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-8">

                        <label class="form-label">
                            Adresse
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="adresse"
                            class="form-control"
                            value="{{ old('adresse', $entreprise->adresse) }}"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Ville
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="ville"
                            class="form-control"
                            value="{{ old('ville', $entreprise->ville) }}"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Téléphone
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="telephone"
                            class="form-control"
                            value="{{ old('telephone', $entreprise->telephone) }}"
                            required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $entreprise->email) }}">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Site web
                        </label>

                        <input
                            type="url"
                            name="site_web"
                            class="form-control"
                            value="{{ old('site_web', $entreprise->site_web) }}">

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- INFORMATIONS FISCALES --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="mb-1 fw-bold">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Informations fiscales et administratives
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">
                            NIF
                        </label>

                        <input
                            type="text"
                            name="nif"
                            class="form-control"
                            value="{{ old('nif', $entreprise->nif) }}">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            STAT
                        </label>

                        <input
                            type="text"
                            name="stat"
                            class="form-control"
                            value="{{ old('stat', $entreprise->stat) }}">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            RCS
                        </label>

                        <input
                            type="text"
                            name="rcs"
                            class="form-control"
                            value="{{ old('rcs', $entreprise->rcs) }}">

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- INFORMATIONS BANCAIRES --}}
        {{-- ================================================= --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="mb-1 fw-bold">
                    <i class="bi bi-bank me-2"></i>
                    Informations bancaires
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">
                            Nom de la banque
                        </label>

                        <input
                            type="text"
                            name="nom_banque"
                            class="form-control"
                            value="{{ old('nom_banque', $entreprise->nom_banque) }}">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Numéro de compte
                        </label>

                        <input
                            type="text"
                            name="numero_compte"
                            class="form-control"
                            value="{{ old('numero_compte', $entreprise->numero_compte) }}">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Titulaire du compte
                        </label>

                        <input
                            type="text"
                            name="titulaire_compte"
                            class="form-control"
                            value="{{ old('titulaire_compte', $entreprise->titulaire_compte) }}">

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- BOUTON --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-end mb-4">

            <button
                type="submit"
                class="btn btn-primary px-4">

                <i class="bi bi-check-lg me-2"></i>

                Enregistrer les modifications

            </button>

        </div>

    </form>

</div>

@endsection