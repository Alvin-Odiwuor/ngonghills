<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePointTransactionRequest;
use App\Http\Requests\UpdatePointTransactionRequest;
use App\Models\LoyaltyAccount;
use App\Models\PointTransaction;
use Modules\Sale\Entities\Sale;

class PointTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pointTransactions = PointTransaction::with(['loyaltyAccount.customer', 'sale'])
            ->latest()
            ->paginate(15);

        return view('point-transactions.index', compact('pointTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loyaltyAccounts = LoyaltyAccount::with('customer')->orderByDesc('id')->get();
        $sales = Sale::query()->latest()->limit(200)->get();

        return view('point-transactions.create', compact('loyaltyAccounts', 'sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePointTransactionRequest $request)
    {
        PointTransaction::create($request->validated());

        toast('Point Transaction Created!', 'success');

        return redirect()->route('point-transactions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PointTransaction $pointTransaction)
    {
        $pointTransaction->load(['loyaltyAccount.customer', 'sale']);

        return view('point-transactions.show', compact('pointTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PointTransaction $pointTransaction)
    {
        $loyaltyAccounts = LoyaltyAccount::with('customer')->orderByDesc('id')->get();
        $sales = Sale::query()->latest()->limit(200)->get();

        return view('point-transactions.edit', compact('pointTransaction', 'loyaltyAccounts', 'sales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePointTransactionRequest $request, PointTransaction $pointTransaction)
    {
        $pointTransaction->update($request->validated());

        toast('Point Transaction Updated!', 'info');

        return redirect()->route('point-transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PointTransaction $pointTransaction)
    {
        $pointTransaction->delete();

        toast('Point Transaction Deleted!', 'warning');

        return redirect()->route('point-transactions.index');
    }
}
