@extends('layouts.app')

@section('title', 'Outlet Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('outlets.index') }}">Outlets</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Outlet Details</h4>
                <a href="{{ route('outlets.edit', $outlet) }}" class="btn btn-primary">Edit</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <div>{{ $outlet->name }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Type:</strong>
                        <div>{{ str_replace('_', ' ', ucfirst($outlet->type)) }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Status:</strong>
                        <div>{{ ucfirst($outlet->status) }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Location / Floor:</strong>
                        <div>{{ $outlet->location }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Manager:</strong>
                        <div>{{ optional($outlet->manager)->name ?: '-' }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong>Phone Extension:</strong>
                        <div>{{ $outlet->phone_extension ?: '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Opening Time:</strong>
                        <div>{{ optional($outlet->opening_time)->format('H:i') }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Closing Time:</strong>
                        <div>{{ optional($outlet->closing_time)->format('H:i') }}</div>
                    </div>
                </div>

                <a href="{{ route('outlets.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
