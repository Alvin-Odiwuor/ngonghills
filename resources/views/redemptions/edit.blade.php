@extends('layouts.app')

@section('title', 'Edit Redemption')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('redemptions.index') }}">Redemptions</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Redemption #{{ $redemption->id }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('redemptions.update', $redemption) }}" method="POST">
                    @method('PUT')
                    @include('redemptions.partials.form', ['buttonText' => 'Update Redemption'])
                </form>
            </div>
        </div>
    </div>
@endsection
