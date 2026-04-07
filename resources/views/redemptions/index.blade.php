@extends('layouts.app')

@section('title', 'Redemptions')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Redemptions</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Reward Redemptions</h4>
                <a href="{{ route('redemptions.create') }}" class="btn btn-primary">Create Redemption</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Loyalty Account</th>
                                <th>Customer</th>
                                <th>Reward</th>
                                <th>Points Used</th>
                                <th>Status</th>
                                <th>Redeemed At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($redemptions as $redemption)
                                <tr>
                                    <td>{{ $redemption->id }}</td>
                                    <td>{{ $redemption->loyaltyAccount->account_number ?? '-' }}</td>
                                    <td>{{ optional(optional($redemption->loyaltyAccount)->customer)->customer_name ?? '-' }}</td>
                                    <td>{{ optional($redemption->reward)->name ?? '-' }}</td>
                                    <td>{{ number_format($redemption->points_used) }}</td>
                                    <td>
                                        @php
                                            $badge = [
                                                'pending' => 'badge-warning',
                                                'approved' => 'badge-info',
                                                'rejected' => 'badge-danger',
                                                'used' => 'badge-success',
                                            ][$redemption->status] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ ucfirst($redemption->status) }}</span>
                                    </td>
                                    <td>{{ optional($redemption->redeemed_at)->format('d M, Y H:i') ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('redemptions.show', $redemption) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('redemptions.edit', $redemption) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('redemptions.destroy', $redemption) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this redemption?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No redemptions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $redemptions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
