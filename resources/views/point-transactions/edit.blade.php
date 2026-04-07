@extends('layouts.app')

@section('title', 'Edit Point Transaction')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('point-transactions.index') }}">Point Transactions</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Point Transaction</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('point-transactions.update', $pointTransaction) }}" method="POST">
                    @method('PUT')
                    @include('point-transactions.partials.form', ['buttonText' => 'Update Point Transaction'])
                </form>
            </div>
        </div>
    </div>
@endsection
