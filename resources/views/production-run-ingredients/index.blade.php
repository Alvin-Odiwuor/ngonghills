@extends('layouts.app')

@section('title', 'Production Run Ingredients')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Production Run Ingredients</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Consumed Ingredients Log</h4>
                <a href="{{ route('production-run-ingredients.create') }}" class="btn btn-primary">Add Consumption Log</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Batch</th>
                                <th>Ingredient</th>
                                <th>Quantity Used</th>
                                <th>Unit Cost</th>
                                <th>Total Cost</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productionRunIngredients as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ optional($item->productionRun)->batch_number ?? '-' }}</td>
                                    <td>{{ optional($item->ingredient)->name ?? '-' }}</td>
                                    <td>{{ number_format((float) $item->quantity_used, 3) }}</td>
                                    <td>{{ number_format((float) $item->unit_cost_at_time, 4) }}</td>
                                    <td>{{ number_format((float) $item->total_cost, 4) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('production-run-ingredients.show', $item) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('production-run-ingredients.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('production-run-ingredients.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this log entry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No consumption logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $productionRunIngredients->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
