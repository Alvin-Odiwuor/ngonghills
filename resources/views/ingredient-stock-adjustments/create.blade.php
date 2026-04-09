@extends('layouts.app')

@section('title', 'Create Ingredient Adjustment')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ingredient-stock-adjustments.index') }}">Ingredient Adjustments</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Ingredient Adjustment</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ingredient-stock-adjustments.store') }}" method="POST">
                    @include('ingredient-stock-adjustments.partials.form', ['buttonText' => 'Create Adjustment'])
                </form>
            </div>
        </div>
    </div>
@endsection
