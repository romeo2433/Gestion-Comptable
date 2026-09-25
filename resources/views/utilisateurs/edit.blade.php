@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('page-title', 'Modifier un utilisateur')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h4 class="mb-4">
                Modifier l'utilisateur
            </h4>

            <form method="POST"
                  action="{{ route('utilisateurs.update', $utilisateur->id_utilisateur) }}">

                @csrf
                @method('PUT')


                {{-- Nom --}}
                <div class="mb-3">

                    <label class="form-label">
                        Nom <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="nom"
                           class="form-control @error('nom') is-invalid @enderror"
                           value="{{ old('nom', $utilisateur->nom) }}"
                           required>

                    @error('nom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="mb-3">

                    <label class="form-label">
                        Email <span class="text-danger">*</span>
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $utilisateur->email) }}"
                           required>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Rôle --}}
                <div class="mb-3">

                    <label class="form-label">
                        Rôle <span class="text-danger">*</span>
                    </label>

                    <select name="role"
                            class="form-select"
                            {{ $utilisateur->id_utilisateur == session('id_utilisateur') ? 'disabled' : '' }}>

                        <option value="admin"
                            {{ $utilisateur->role === 'admin' ? 'selected' : '' }}>
                            Administrateur
                        </option>

                        <option value="caissier"
                            {{ $utilisateur->role === 'caissier' ? 'selected' : '' }}>
                            Comptable
                        </option>

                        <option value="independant"
                            {{ $utilisateur->role === 'independant' ? 'selected' : '' }}>
                            Indépendant
                        </option>

                    </select>

                    @if($utilisateur->id_utilisateur == session('id_utilisateur'))

                        <small class="text-muted">
                            Vous ne pouvez pas modifier votre propre rôle.
                        </small>

                    @endif

                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Nouveau mot de passe --}}
                <div class="mb-3">

                    <label class="form-label">
                        Nouveau mot de passe
                    </label>

                    <input type="password"
                           name="mot_de_passe"
                           class="form-control @error('mot_de_passe') is-invalid @enderror">

                    <small class="text-muted">
                        Laissez vide si vous ne souhaitez pas modifier le mot de passe.
                    </small>

                    @error('mot_de_passe')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Confirmation --}}
                <div class="mb-4">

                    <label class="form-label">
                        Confirmer le nouveau mot de passe
                    </label>

                    <input type="password"
                           name="mot_de_passe_confirmation"
                           class="form-control">

                </div>


                {{-- Boutons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Enregistrer les modifications

                    </button>

                    <a href="{{ route('utilisateurs.index') }}"
                       class="btn btn-secondary">

                        Annuler

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection