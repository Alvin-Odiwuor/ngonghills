@extends('layouts.app')

@section('title', 'Ingredient Purchases')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Ingredient Purchases</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Ingredient Purchases</h4>
                <a href="{{ route('ingredient-purchases.create') }}" class="btn btn-primary">Add Ingredient Purchase</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ingredient</th>
                                <th>Supplier</th>
                                <th>Qty</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th>Purchase Date</th>
                                <th>Invoice</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ingredientPurchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ optional($purchase->ingredient)->name ?? '-' }}</td>
                                    <td>{{ optional($purchase->supplier)->supplier_name ?? '-' }}</td>
                                    <td>{{ number_format((float) $purchase->quantity, 3) }}</td>
                                    <td>{{ number_format((float) $purchase->unit_cost, 4) }}</td>
                                    <td>{{ number_format((float) $purchase->total_cost, 4) }}</td>
                                    <td>{{ optional($purchase->purchase_date)->format('d M, Y') ?? '-' }}</td>
                                    <td>{{ $purchase->invoice_number }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('ingredient-purchases.show', $purchase) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('ingredient-purchases.edit', $purchase) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('ingredient-purchases.destroy', $purchase) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this ingredient purchase?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No ingredient purchases found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $ingredientPurchases->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
