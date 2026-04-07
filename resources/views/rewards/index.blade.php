@extends('layouts.app')

@section('title', 'Rewards')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Rewards</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Reward Catalogue</h4>
                <a href="{{ route('rewards.create') }}" class="btn btn-primary">Add Reward</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Points Required</th>
                                <th>Value</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Expires</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rewards as $reward)
                                <tr>
                                    <td>{{ $reward->id }}</td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $reward->reward_type)) }}</td>
                                    <td>{{ number_format($reward->points_required) }}</td>
                                    <td>{{ $reward->reward_value ?? '-' }}</td>
                                    <td>{{ is_null($reward->stock) ? 'Unlimited' : $reward->stock }}</td>
                                    <td>
                                        <span class="badge {{ $reward->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $reward->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ optional($reward->expires_at)->format('d M, Y') ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('rewards.show', $reward) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('rewards.edit', $reward) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('rewards.destroy', $reward) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this reward?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No rewards found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $rewards->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
