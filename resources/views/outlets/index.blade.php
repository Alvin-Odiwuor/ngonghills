@extends('layouts.app')

@section('title', 'Outlets')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Outlets</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-2 mb-md-0">Outlet Directory</h4>
                <a href="{{ route('outlets.create') }}" class="btn btn-primary">Add Outlet</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Manager</th>
                                <th>Extension</th>
                                <th>Hours</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($outlets as $outlet)
                                <tr>
                                    <td>{{ $outlet->id }}</td>
                                    <td>{{ $outlet->name }}</td>
                                    <td>{{ str_replace('_', ' ', ucfirst($outlet->type)) }}</td>
                                    <td>{{ $outlet->location }}</td>
                                    <td>{{ optional($outlet->manager)->name ?: '-' }}</td>
                                    <td>{{ $outlet->phone_extension ?: '-' }}</td>
                                    <td>
                                        {{ optional($outlet->opening_time)->format('H:i') }} - {{ optional($outlet->closing_time)->format('H:i') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $outlet->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ ucfirst($outlet->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('outlets.show', $outlet) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('outlets.edit', $outlet) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('outlets.destroy', $outlet) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this outlet?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No outlets found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $outlets->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
