@extends('layouts.app')

@section('title', 'Edit Outlet Product')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('outlet-products.index') }}">Outlet Products</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Outlet Product</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('outlet-products.update', $outletProduct) }}" method="POST">
                    @method('PUT')
                    @include('outlet-products.partials.form', ['buttonText' => 'Update Assignment'])
                </form>
            </div>
        </div>
    </div>
@endsection
