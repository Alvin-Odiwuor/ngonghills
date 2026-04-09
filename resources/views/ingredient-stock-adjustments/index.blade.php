@extends('layouts.app')

@section('title', 'Ingredient Stock Adjustments')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Ingredient Adjustments</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Ingredient Stock Adjustments</h4>
                <a href="{{ route('ingredient-stock-adjustments.create') }}" class="btn btn-primary">Add Adjustment</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ingredient</th>
                                <th>Outlet</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Reason</th>
                                <th>Reference</th>
                                <th>Adjusted By</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ingredientStockAdjustments as $adjustment)
                                <tr>
                                    <td>{{ $adjustment->id }}</td>
                                    <td>{{ optional($adjustment->ingredient)->name ?? '-' }}</td>
                                    <td>{{ optional($adjustment->outlet)->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $adjustment->adjustment_type === 'addition' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($adjustment->adjustment_type) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format((float) $adjustment->quantity, 3) }}</td>
                                    <td>{{ ucfirst($adjustment->reason) }}</td>
                                    <td>
                                        @if($adjustment->reference_type)
                                            {{ class_basename($adjustment->reference_type) }} #{{ $adjustment->reference_id }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ optional($adjustment->user)->name ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('ingredient-stock-adjustments.show', $adjustment) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('ingredient-stock-adjustments.edit', $adjustment) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('ingredient-stock-adjustments.destroy', $adjustment) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this adjustment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No adjustments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $ingredientStockAdjustments->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
