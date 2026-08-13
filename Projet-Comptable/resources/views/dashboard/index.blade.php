@extends('layouts.app')

@section('title','Dashboard')

@section('page-title','Tableau de bord')

@section('content')

<div class="row">

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h6>Clients</h6>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h6>Factures</h6>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h6>Paiements</h6>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h6>Utilisateurs</h6>

                <h2>

                    @if(session('utilisateur')->role == 'admin')

                        Visible

                    @else

                        —

                    @endif

                </h2>

            </div>

        </div>

    </div>

</div>

@endsection