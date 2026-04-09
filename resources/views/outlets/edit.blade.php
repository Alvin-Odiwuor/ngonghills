@extends('layouts.app')

@section('title', 'Edit Outlet')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('outlets.index') }}">Outlets</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Outlet</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('outlets.update', $outlet) }}" method="POST">
                    @method('PUT')
                    @include('outlets.partials.form', ['buttonText' => 'Update Outlet'])
                </form>
            </div>
        </div>
    </div>
@endsection
