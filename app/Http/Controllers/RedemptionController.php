<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRedemptionRequest;
use App\Http\Requests\UpdateRedemptionRequest;
use App\Models\LoyaltyAccount;
use App\Models\Reward;
use App\Models\Redemption;

class RedemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $redemptions = Redemption::with(['loyaltyAccount.customer', 'reward'])
            ->latest()
            ->paginate(15);

        return view('redemptions.index', compact('redemptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loyaltyAccounts = LoyaltyAccount::with('customer')->orderByDesc('id')->get();
        $rewards = Reward::query()->where('is_active', true)->orderBy('name')->get();

        return view('redemptions.create', compact('loyaltyAccounts', 'rewards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRedemptionRequest $request)
    {
        Redemption::create($request->validated());

        toast('Redemption Created!', 'success');

        return redirect()->route('redemptions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Redemption $redemption)
    {
        $redemption->load(['loyaltyAccount.customer', 'reward']);

        return view('redemptions.show', compact('redemption'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Redemption $redemption)
    {
        $loyaltyAccounts = LoyaltyAccount::with('customer')->orderByDesc('id')->get();
        $rewards = Reward::query()->orderBy('name')->get();

        return view('redemptions.edit', compact('redemption', 'loyaltyAccounts', 'rewards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRedemptionRequest $request, Redemption $redemption)
    {
        $redemption->update($request->validated());

        toast('Redemption Updated!', 'info');

        return redirect()->route('redemptions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Redemption $redemption)
    {
        $redemption->delete();

        toast('Redemption Deleted!', 'warning');

        return redirect()->route('redemptions.index');
    }
}
