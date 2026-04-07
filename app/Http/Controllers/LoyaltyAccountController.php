<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoyaltyAccountRequest;
use App\Http\Requests\UpdateLoyaltyAccountRequest;
use App\Models\LoyaltyAccount;
use Modules\People\Entities\Customer;

class LoyaltyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loyaltyAccounts = LoyaltyAccount::with('customer')
            ->latest()
            ->paginate(15);

        return view('loyalty-accounts.index', compact('loyaltyAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::query()
            ->orderBy('customer_name')
            ->get();

        return view('loyalty-accounts.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoyaltyAccountRequest $request)
    {
        LoyaltyAccount::create($request->validated());

        toast('Loyalty Account Created!', 'success');

        return redirect()->route('loyalty-accounts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoyaltyAccount $loyaltyAccount)
    {
        $loyaltyAccount->load('customer');

        return view('loyalty-accounts.show', compact('loyaltyAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoyaltyAccount $loyaltyAccount)
    {
        $customers = Customer::query()
            ->orderBy('customer_name')
            ->get();

        return view('loyalty-accounts.edit', compact('loyaltyAccount', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoyaltyAccountRequest $request, LoyaltyAccount $loyaltyAccount)
    {
        $loyaltyAccount->update($request->validated());

        toast('Loyalty Account Updated!', 'info');

        return redirect()->route('loyalty-accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoyaltyAccount $loyaltyAccount)
    {
        $loyaltyAccount->delete();

        toast('Loyalty Account Deleted!', 'warning');

        return redirect()->route('loyalty-accounts.index');
    }
}
