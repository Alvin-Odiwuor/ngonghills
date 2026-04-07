@extends('layouts.app')

@section('title', 'Create Reward')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Rewards</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Reward</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('rewards.store') }}" method="POST">
                    @include('rewards.partials.form', ['buttonText' => 'Create Reward'])
                </form>
            </div>
        </div>
    </div>
@endsection
