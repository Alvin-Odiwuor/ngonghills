@extends('layouts.app')

@section('title', 'Edit Recipe')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">Recipes</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Recipe</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('recipes.update', $recipe) }}" method="POST">
                    @method('PUT')
                    @include('recipes.partials.form', ['buttonText' => 'Update Recipe'])
                </form>
            </div>
        </div>
    </div>
@endsection
