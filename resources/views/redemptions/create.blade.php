@extends('layouts.app')

@section('title', 'Create Redemption')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('redemptions.index') }}">Redemptions</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Redemption</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('redemptions.store') }}" method="POST">
                    @include('redemptions.partials.form', ['buttonText' => 'Create Redemption'])
                </form>
            </div>
        </div>
    </div>
@endsection
