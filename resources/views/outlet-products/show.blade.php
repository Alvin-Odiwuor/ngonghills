@extends('layouts.app')

@section('title', 'Outlet Product Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('outlet-products.index') }}">Outlet Products</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Outlet Product Details</h4>
                <a href="{{ route('outlet-products.edit', $outletProduct) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Outlet:</strong>
                        <div>{{ optional($outletProduct->outlet)->name ?: '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Product:</strong>
                        <div>{{ optional($outletProduct->product)->product_name ?: '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Outlet Price:</strong>
                        <div>{{ number_format((float) $outletProduct->price, 4) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Base Product Price:</strong>
                        <div>{{ number_format((float) optional($outletProduct->product)->product_price, 4) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($outletProduct->status) }}</div>
                    </div>
                </div>

                <a href="{{ route('outlet-products.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
