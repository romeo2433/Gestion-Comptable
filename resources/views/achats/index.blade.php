@extends('layouts.app')

@section('title','Achats')
@section('page-title','Gestion des Achats')

@section('content')

<style>
    :root{
        --paper:#F4F2ED;
        --ink:#1B211F;
        --ink-soft:#5B6560;
        --emerald:#1F5D50;
        --emerald-dark:#123832;
        --emerald-tint:#E4EEEB;
        --gold:#B9863A;
        --gold-tint:#F4E9D6;
        --line:#DCD6C8;
        --danger:#B3402C;
        --danger-tint:#FBEAE6;
        --success:#1F5D50;
        --success-tint:#E4EEEB;
        --success-line:#CFE1DA;
    }

    h5{
        font-family:'Fraunces', serif;
        font-weight:500;
    }

    /* ---------- cards ---------- */
    .card{
        background:#FFFFFF;
        border:1px solid var(--line);
        border-radius:12px;
        box-shadow:none;
    }
    .card-header{
        background:#FFFFFF;
        border-bottom:1px solid var(--line);
        padding:16px 22px;
    }
    .card-header h5{ margin:0; font-size:16.5px; }
    .card-body{ padding:22px; }

    /* ---------- alerts ---------- */
    .alert{
        border-radius:10px;
        border:1px solid;
        font-size:13.5px;
        padding:12px 15px;
    }
    .alert-success{
        background:var(--success-tint);
        border-color:var(--success-line);
        color:var(--emerald-dark);
    }
    .alert-danger{
        background:var(--danger-tint);
        border-color:#E9C7BC;
        color:var(--danger);
    }
    .alert-danger ul{ padding-left:18px; margin:4px 0 0; }

    /* ---------- dropzone ---------- */
    .dropzone{
        border:1.5px dashed var(--line);
        border-radius:12px;
        padding:34px 20px;
        text-align:center;
        cursor:pointer;
        background:var(--paper);
        transition:border-color .15s ease, background .15s ease;
    }
    .dropzone:hover{
        border-color:var(--emerald);
        background:var(--emerald-tint);
    }
    .dropzone svg{ color:var(--emerald); margin-bottom:8px; }
    .dropzone .dz-title{
        font-size:14.5px;
        font-weight:600;
        margin-bottom:2px;
    }
    .dropzone .dz-sub{
        font-size:12.5px;
        color:var(--ink-soft);
    }
    #file-name{
        margin-top:10px;
        font-size:13px;
        font-weight:600;
        color:var(--emerald);
    }

    /* ---------- buttons ---------- */
    .btn-primary{
        background:var(--emerald);
        border-color:var(--emerald);
        font-weight:600;
        border-radius:8px;
    }
    .btn-primary:hover{
        background:var(--emerald-dark);
        border-color:var(--emerald-dark);
    }

    .btn-outline-primary{
        color:var(--emerald);
        border-color:var(--emerald);
        border-radius:8px;
    }
    .btn-outline-primary:hover{
        background:var(--emerald);
        border-color:var(--emerald);
    }

    .btn-outline-success{
        color:var(--emerald);
        border-color:var(--emerald);
        border-radius:8px;
    }
    .btn-outline-success:hover{
        background:var(--emerald);
        border-color:var(--emerald);
    }

    .btn-outline-danger{
        color:var(--danger);
        border-color:#E9C7BC;
        border-radius:8px;
    }
    .btn-outline-danger:hover{
        background:var(--danger);
        border-color:var(--danger);
    }

    .btn svg{ vertical-align:-2.5px; margin-right:3px; }

    /* ---------- table ---------- */
    .table thead th{
        background:var(--paper);
        color:var(--ink-soft);
        font-size:11.5px;
        text-transform:uppercase;
        letter-spacing:.5px;
        font-weight:600;
        border-bottom:1px solid var(--line);
        padding:11px 14px;
        white-space:nowrap;
    }
    .table tbody td{
        padding:13px 14px;
        font-size:13.5px;
        border-bottom:1px solid var(--line);
        vertical-align:middle;
    }
    .table tbody tr:hover{ background:var(--emerald-tint); }
    .table tbody tr:last-child td{ border-bottom:none; }

    .badge-unpaid{
        display:inline-block;
        background:var(--gold-tint);
        color:#8A5F1E;
        font-size:11.5px;
        font-weight:600;
        padding:4px 9px;
        border-radius:20px;
    }

    .form-select-sm{
        border-radius:7px;
        border-color:var(--line);
        font-size:13px;
    }
    .form-select-sm:focus{
        border-color:var(--emerald);
        box-shadow:0 0 0 3px var(--emerald-tint);
    }

    .empty-row{
        text-align:center;
        color:var(--ink-soft);
        padding:34px 0;
        font-size:13.5px;
    }
</style>

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