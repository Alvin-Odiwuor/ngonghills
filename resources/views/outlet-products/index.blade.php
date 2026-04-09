@extends('layouts.app')

@section('title', 'Outlet Products')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Outlet Products</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Product Availability by Outlet</h4>
                <a href="{{ route('outlet-products.create') }}" class="btn btn-primary">Assign Product</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Outlet</th>
                                <th>Product</th>
                                <th>Outlet Price</th>
                                <th>Base Price</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($outletProducts as $outletProduct)
                                <tr>
                                    <td>{{ $outletProduct->id }}</td>
                                    <td>{{ optional($outletProduct->outlet)->name ?: '-' }}</td>
                                    <td>{{ optional($outletProduct->product)->product_name ?: '-' }}</td>
                                    <td>{{ number_format((float) $outletProduct->price, 4) }}</td>
                                    <td>{{ number_format((float) optional($outletProduct->product)->product_price, 4) }}</td>
                                    <td>
                                        <span class="badge {{ $outletProduct->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ ucfirst($outletProduct->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('outlet-products.show', $outletProduct) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('outlet-products.edit', $outletProduct) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('outlet-products.destroy', $outletProduct) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this outlet product assignment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No outlet products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $outletProducts->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
