@extends('layouts.app')

@section('title', 'Create Loyalty Account')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('loyalty-accounts.index') }}">Loyalty Accounts</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Loyalty Account</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('loyalty-accounts.store') }}" method="POST">
                    @include('loyalty-accounts.partials.form', ['buttonText' => 'Create Loyalty Account'])
                </form>
            </div>
        </div>
    </div>
@endsection
