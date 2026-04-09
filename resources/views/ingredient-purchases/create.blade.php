@extends('layouts.app')

@section('title', 'Create Ingredient Purchase')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ingredient-purchases.index') }}">Ingredient Purchases</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Ingredient Purchase</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ingredient-purchases.store') }}" method="POST">
                    @include('ingredient-purchases.partials.form', ['buttonText' => 'Create Ingredient Purchase'])
                </form>
            </div>
        </div>
    </div>
@endsection
