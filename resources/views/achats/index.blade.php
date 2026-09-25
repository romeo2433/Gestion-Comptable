@extends('layouts.app')

@section('title','Achats')
@section('page-title','Gestion des Achats')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">

        <form action="{{ route('achats.upload') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="dropzone mb-3" onclick="document.getElementById('facture').click()">

                <input
                    type="file"
                    name="facture"
                    id="facture"
                    class="d-none"
                    accept=".pdf,.jpg,.jpeg,.png"
                    onchange="afficherNomFichier(this)">

                <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                    <path d="M7 18a4 4 0 0 1-.6-7.95A5.5 5.5 0 0 1 17 9.5a4 4 0 0 1 .5 7.9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M12 20v-8M9 14.5 12 11.5 15 14.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <div class="dz-title">Cliquez pour choisir une facture</div>
                <div class="dz-sub">PDF, JPG ou PNG — maximum 10 Mo</div>

                <div id="file-name">Aucun fichier choisi</div>

            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                        <path d="M12 16V4M8 8l4-4 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Importer
                </button>
            </div>

        </form>

    </div>
</div>



        @if(session('role') === 'admin')

        <div class="card mb-3">
            <div class="card-body">

                <form method="GET">

                    <div class="row">

                        <div class="col-md-4">

                            <label class="form-label">
                                Département
                            </label>

                            <select
                                name="departement"
                                class="form-select"
                            >

                                <option value="">
                                    Tous les départements
                                </option>

                                @foreach($departements as $dep)

                                    <option
                                        value="{{ $dep->id_departement }}"
                                        {{ $departementSelectionne == $dep->id_departement ? 'selected' : '' }}
                                    >
                                        {{ $dep->nom }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <button
                                class="btn btn-primary"
                                type="submit"
                            >
                                Filtrer
                            </button>

                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <a
                                href="{{ route('achats.index') }}"
                                class="btn btn-secondary"
                            >
                                Réinitialiser
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>

        @endif


{{-- Liste des achats --}}

<div class="card mt-4">

    <div class="card-header">
        <h5>Liste des achats</h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            @php
                $estAdmin = session('role') === 'admin';
            @endphp

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>Date de facture</th>
                        <th>Nom du fournisseur</th>
                        <th>Compte de charge</th>
                        <th>Montant total (Ar)</th>
                        <th>Compte TVA</th>
                        <th>Mode de paiement</th>
                        @if($estAdmin)
                            <th>Utilisateur</th>
                        @endif
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($achats as $achat)

                        <tr>

                            {{-- DATE --}}
                            <td>
                                {{ $achat->date_facture
                                    ? \Carbon\Carbon::parse($achat->date_facture)->format('d/m/Y')
                                    : 'Non renseignée'
                                }}
                            </td>

                            {{-- FOURNISSEUR --}}
                            <td>
                                {{ $achat->nom_fournisseur ?? 'Non renseigné' }}
                            </td>

                            {{-- COMPTE DE CHARGE --}}
                            <td>
                                {{ $achat->compte_charge ?? 'Non renseigné' }}
                            </td>

                            {{-- MONTANT TOTAL --}}
                            <td class="fw-semibold">
                                {{ number_format($achat->montant_total, 0, ',', ' ') }} Ar
                            </td>

                            

                            {{-- COMPTE TVA --}}
                            <td>
                                {{ $achat->compte_tva ?? 'Non renseigné' }}
                            </td>

                            {{-- MODE DE PAIEMENT --}}
                            <td>

                                @if($achat->paiement > 0)

                                    <form action="{{ route('achats.paiement.update', $achat->id_facture) }}"
                                          method="POST">

                                        @csrf
                                        @method('PUT')

                                        <select name="mode_paiement"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()">

                                            <option value="Espèces" {{ $achat->mode_paiement === 'Espèces' ? 'selected' : '' }}>Espèces</option>
                                            <option value="Chèque" {{ $achat->mode_paiement === 'Chèque' ? 'selected' : '' }}>Chèque</option>
                                            <option value="Carte bancaire" {{ $achat->mode_paiement === 'Carte bancaire' ? 'selected' : '' }}>Carte bancaire</option>
                                            <option value="Mobile Money" {{ $achat->mode_paiement === 'Mobile Money' ? 'selected' : '' }}>Mobile Money</option>

                                        </select>

                                    </form>

                                @else

                                    <span class="badge-unpaid">Non payé</span>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-success ms-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#paiementModal{{ $achat->id_facture }}"
                                        title="Ajouter un paiement">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>

                                @endif

                            </td>

                            {{-- UTILISATEUR (admin uniquement) --}}
                            @if($estAdmin)
                                <td>
                                    {{ $achat->nom_utilisateur ?? 'Non renseigné' }}
                                </td>
                            @endif

                            {{-- ACTIONS --}}
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">

                                    <a href="{{ route('achats.show', $achat->id_facture) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Voir les détails">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="1.6"/>
                                            <circle cx="12" cy="12" r="2.6" stroke="currentColor" stroke-width="1.6"/>
                                        </svg>
                                        Voir plus
                                    </a>

                                    {{--@if($estAdmin) --}}
                                        <form action="{{ route('achats.destroy', $achat->id_facture) }}"
                                              method="POST"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Supprimer">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                                                    <path d="M4 7h16M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m-8 0 1 13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1l1-13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                   {{-- @endif --}}

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $estAdmin ? 9 : 8 }}" class="empty-row">
                                Aucun achat trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function afficherNomFichier(input) {
        const fileName = document.getElementById('file-name');
        if (input.files.length > 0) {
            fileName.textContent = input.files[0].name;
        } else {
            fileName.textContent = 'Aucun fichier choisi';
        }
    }
</script>

@endsection