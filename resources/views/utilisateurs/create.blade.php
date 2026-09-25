@extends('layouts.app')

@section('title', 'Ajouter un utilisateur')

@section('page-title', 'Ajouter un utilisateur')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <h4 class="mb-4">
                Ajouter un utilisateur
            </h4>

            <form method="POST"
                  action="{{ route('utilisateurs.store') }}">

                @csrf


                {{-- Nom --}}
                <div class="mb-3">

                    <label class="form-label">
                        Nom <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="nom"
                           class="form-control @error('nom') is-invalid @enderror"
                           value="{{ old('nom') }}"
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
                           value="{{ old('email') }}"
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
                            class="form-select @error('role') is-invalid @enderror"
                            required>

                        <option value="">
                            -- Sélectionner un rôle --
                        </option>

                        <option value="admin"
                            {{ old('role') === 'admin' ? 'selected' : '' }}>
                            Administrateur
                        </option>

                        <option value="caissier"
                            {{ old('role') === 'caissier' ? 'selected' : '' }}>
                            Comptable
                        </option>

                        <option value="independant"
                            {{ old('role') === 'independant' ? 'selected' : '' }}>
                            Indépendant
                        </option>

                    </select>

                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Mot de passe --}}
                <div class="mb-3">

                    <label class="form-label">
                        Mot de passe <span class="text-danger">*</span>
                    </label>

                    <input type="password"
                           name="mot_de_passe"
                           class="form-control @error('mot_de_passe') is-invalid @enderror"
                           required>

                    <small class="text-muted">
                        Minimum 8 caractères.
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
                        Confirmer le mot de passe <span class="text-danger">*</span>
                    </label>

                    <input type="password"
                           name="mot_de_passe_confirmation"
                           class="form-control"
                           required>

                </div>


                {{-- Boutons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">

                        Ajouter l'utilisateur

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