@extends('layouts.app')

@section('title', 'Recipe Ingredient Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('recipe-ingredients.index') }}">Recipe Ingredients</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Recipe Ingredient Details</h4>
                <a href="{{ route('recipe-ingredients.edit', $recipeIngredient) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Recipe:</strong>
                        <div>{{ optional($recipeIngredient->recipe)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Ingredient:</strong>
                        <div>{{ optional($recipeIngredient->ingredient)->name ?? '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Quantity Required:</strong>
                        <div>{{ number_format((float) $recipeIngredient->quantity_required, 3) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Unit:</strong>
                        <div>{{ $recipeIngredient->unit }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Notes:</strong>
                        <div>{{ $recipeIngredient->notes ?: '-' }}</div>
                    </div>
                </div>

                <a href="{{ route('recipe-ingredients.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
