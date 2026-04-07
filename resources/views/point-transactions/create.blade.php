@extends('layouts.app')

@section('title', 'Create Point Transaction')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('point-transactions.index') }}">Point Transactions</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        @include('utils.alerts')

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create Point Transaction</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('point-transactions.store') }}" method="POST">
                    @include('point-transactions.partials.form', ['buttonText' => 'Create Point Transaction'])
                </form>
            </div>
        </div>
    </div>
@endsection
