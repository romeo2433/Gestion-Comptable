@extends('layouts.app')

@section('title','Achats')
@section('page-title','Gestion des Achats')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('achats.upload') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="border border-2 border-dashed rounded-3 p-4 text-center mb-3"
                 style="cursor: pointer;"
                 onclick="document.getElementById('facture').click()">

                <input
                    type="file"
                    name="facture"
                    id="facture"
                    class="d-none"
                    accept=".pdf,.jpg,.jpeg,.png"
                    onchange="afficherNomFichier(this)"
                >

                <i class="bi bi-cloud-upload fs-1 text-primary mb-2"></i>

                <p class="mb-1 fw-semibold">
                    Cliquez pour choisir une facture
                </p>

                <small class="text-muted">
                    PDF, JPG ou PNG — maximum 10 Mo
                </small>

                <div class="mt-2 text-primary" id="file-name">
                    Aucun fichier choisi
                </div>

            </div>

            <div class="text-end">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i>
                    Importer
                </button>

            </div>

        </form>

    </div>

</div>


{{-- Liste des achats --}}

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">
            Liste des achats
        </h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Facture</th>
                        <th>Date de facture</th>
                        <th>Nom du fournisseur</th>
                        <th>Compte de charge</th>
                        <th>Montant total (Ar)</th>
                        <th>TVA</th>
                        <th>Compte TVA</th>
                        <th>Paiement</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($achats as $achat)

                        <tr>
                            <td>
                                @if($achat->fichier_facture)
                            
                                    <a href="{{ asset('storage/' . $achat->fichier_facture) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                            
                                        <i class="bi bi-file-earmark-text"></i>
                                        Voir
                            
                                    </a>
                            
                                @else
                            
                                    <span class="text-muted">
                                        Aucun fichier
                                    </span>
                            
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($achat->date_facture)->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ $achat->nom_fournisseur ?? 'Non renseigné' }}
                            </td>

                            <td>
                                {{ $achat->compte_charge ?? 'Non renseigné' }}
                            </td>

                            <td class="fw-semibold">
                                {{ number_format($achat->montant_total, 0, ',', ' ') }} Ar
                            </td>

                            <td>
                                {{ number_format($achat->tva, 0, ',', ' ') }} Ar
                            </td>

                            <td>
                                {{ $achat->compte_tva ?? 'Non renseigné' }}
                            </td>

                            <td>
                                @if($achat->paiement > 0)
                                    <span class="badge bg-success">
                                        {{ number_format($achat->paiement, 0, ',', ' ') }} Ar
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Non payé
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-4">
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