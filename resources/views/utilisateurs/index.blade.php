@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('page-title', 'Gestion des utilisateurs')

@section('content')

<div class="container-fluid">

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- En-tête --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-1">
                        Utilisateurs
                    </h4>

                    <p class="text-muted mb-0">
                        Gérez les comptes et les rôles des utilisateurs.
                    </p>
                </div>

                <a href="{{ route('utilisateurs.create') }}"
                   class="btn btn-primary">
                    + Ajouter un utilisateur
                </a>
            </div>
        </div>
    </div>
    {{-- Tableau --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Créé le</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($utilisateurs as $utilisateur)
                        <tr>
                            {{-- Nom --}}
                            <td>
                                <strong>
                                    {{ $utilisateur->nom }}
                                </strong>
                            </td>


                            {{-- Email --}}
                            <td>
                                {{ $utilisateur->email }}
                            </td>


                            {{-- Rôle --}}
                            <td>

                                @if($utilisateur->role === 'admin')

                                    <span class="badge bg-danger">
                                        Admin
                                    </span>

                                @elseif($utilisateur->role === 'caissier')

                                    <span class="badge bg-primary">
                                        Caissier
                                    </span>

                                @elseif($utilisateur->role === 'independant')

                                    <span class="badge bg-secondary">
                                        Indépendant
                                    </span>

                                @endif

                            </td>


                            {{-- Statut --}}
                            <td>

                                @if($utilisateur->statut === 'actif')

                                    <span class="badge bg-success">
                                        Actif
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Désactivé
                                    </span>

                                @endif

                            </td>


                            {{-- Date --}}
                            <td>

                                {{ \Carbon\Carbon::parse($utilisateur->created_at)->format('d/m/Y') }}

                            </td>


                            {{-- Actions --}}
                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-2">

                                    {{-- Modifier --}}
                                    <a href="{{ route('utilisateurs.edit', $utilisateur->id_utilisateur) }}"
                                       class="btn btn-sm btn-outline-primary">

                                        Modifier

                                    </a>


                                    {{-- Activer / Désactiver --}}
                                    @if($utilisateur->id_utilisateur != session('id_utilisateur'))

                                        <form method="POST"
                                              action="{{ route('utilisateurs.toggleStatut', $utilisateur->id_utilisateur) }}">

                                            @csrf
                                            @method('PATCH')

                                            @if($utilisateur->statut === 'actif')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-warning">

                                                    Désactiver

                                                </button>

                                            @else

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success">

                                                    Activer

                                                </button>

                                            @endif

                                        </form>

                                    @endif


                                    {{-- Supprimer --}}
                                    @if($utilisateur->id_utilisateur != session('id_utilisateur'))

                                        <form method="POST"
                                              action="{{ route('utilisateurs.destroy', $utilisateur->id_utilisateur) }}"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">

                                                Supprimer

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted py-4">

                                Aucun utilisateur enregistré.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection