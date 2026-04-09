@extends('layouts.app')

@section('title', 'Create Production Run Ingredient')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('production-run-ingredients.index') }}">Production Run Ingredients</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Consumption Log</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('production-run-ingredients.store') }}" method="POST">
                    @include('production-run-ingredients.partials.form', ['buttonText' => 'Create Log'])
                </form>
            </div>
        </div>
    </div>
@endsection
