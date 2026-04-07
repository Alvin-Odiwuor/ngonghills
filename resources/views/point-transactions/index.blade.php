@extends('layouts.app')

@section('title', 'Point Transactions')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Point Transactions</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Point Transactions</h4>
                <a href="{{ route('point-transactions.create') }}" class="btn btn-primary">Add Point Transaction</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Loyalty Account</th>
                                <th>Order</th>
                                <th>Type</th>
                                <th>Points</th>
                                <th>Expires</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pointTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>
                                        #{{ optional($transaction->loyaltyAccount)->id }}
                                        @if(optional(optional($transaction->loyaltyAccount)->customer)->customer_name)
                                            - {{ optional($transaction->loyaltyAccount->customer)->customer_name }}
                                        @endif
                                    </td>
                                    <td>{{ optional($transaction->order)->reference ?? '-' }}</td>
                                    <td><span class="badge badge-secondary">{{ ucfirst($transaction->type) }}</span></td>
                                    <td class="{{ $transaction->points >= 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                        {{ $transaction->points >= 0 ? '+' : '' }}{{ $transaction->points }}
                                    </td>
                                    <td>{{ optional($transaction->expires_at)->format('d M, Y') ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('point-transactions.show', $transaction) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('point-transactions.edit', $transaction) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('point-transactions.destroy', $transaction) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this point transaction?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No point transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pointTransactions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
