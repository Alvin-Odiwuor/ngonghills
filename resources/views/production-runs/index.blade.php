@extends('layouts.app')

@section('title', 'Production Runs')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Production Runs</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Production Runs</h4>
                <a href="{{ route('production-runs.create') }}" class="btn btn-primary">Add Production Run</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Batch</th>
                                <th>Recipe</th>
                                <th>Product</th>
                                <th>Outlet</th>
                                <th>Qty Produced</th>
                                <th>Date</th>
                                <th>Produced By</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productionRuns as $run)
                                <tr>
                                    <td>{{ $run->id }}</td>
                                    <td>{{ $run->batch_number }}</td>
                                    <td>{{ optional($run->recipe)->name ?? '-' }}</td>
                                    <td>{{ optional($run->product)->product_name ?? '-' }}</td>
                                    <td>{{ optional($run->outlet)->name ?? '-' }}</td>
                                    <td>{{ number_format((float) $run->quantity_produced, 3) }}</td>
                                    <td>{{ optional($run->production_date)->format('d M, Y') ?? '-' }}</td>
                                    <td>{{ optional($run->user)->name ?? '-' }}</td>
                                    <td>
                                        @php
                                            $badge = [
                                                'planned' => 'badge-secondary',
                                                'in-progress' => 'badge-info',
                                                'completed' => 'badge-success',
                                                'cancelled' => 'badge-danger',
                                            ][$run->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ ucfirst($run->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('production-runs.show', $run) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('production-runs.edit', $run) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('production-runs.destroy', $run) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this production run?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No production runs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $productionRuns->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
