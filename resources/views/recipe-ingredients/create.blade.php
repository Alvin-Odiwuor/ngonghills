@extends('layouts.app')

@section('title', 'Create Recipe Ingredient')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('recipe-ingredients.index') }}">Recipe Ingredients</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Recipe Ingredient</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('recipe-ingredients.store') }}" method="POST">
                    @include('recipe-ingredients.partials.form', ['buttonText' => 'Create Recipe Ingredient'])
                </form>
            </div>
        </div>
    </div>
@endsection
