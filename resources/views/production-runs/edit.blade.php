@extends('layouts.app')

@section('title', 'Edit Production Run')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('production-runs.index') }}">Production Runs</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Production Run</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('production-runs.update', $productionRun) }}" method="POST">
                    @method('PUT')
                    @include('production-runs.partials.form', ['buttonText' => 'Update Production Run'])
                </form>
            </div>
        </div>
    </div>
@endsection
