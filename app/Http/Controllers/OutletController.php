<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutletRequest;
use App\Http\Requests\UpdateOutletRequest;
use App\Models\Outlet;
use App\Models\User;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlets = Outlet::query()
            ->with('manager')
            ->latest()
            ->paginate(15);

        return view('outlets.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = User::query()->orderBy('name')->get(['id', 'name']);

        return view('outlets.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutletRequest $request)
    {
        Outlet::create($request->validated());

        toast('Outlet Created!', 'success');

        return redirect()->route('outlets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Outlet $outlet)
    {
        $outlet->load('manager');

        return view('outlets.show', compact('outlet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outlet $outlet)
    {
        $managers = User::query()->orderBy('name')->get(['id', 'name']);

        return view('outlets.edit', compact('outlet', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutletRequest $request, Outlet $outlet)
    {
        $outlet->update($request->validated());

        toast('Outlet Updated!', 'info');

        return redirect()->route('outlets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outlet $outlet)
    {
        $outlet->delete();

        toast('Outlet Deleted!', 'warning');

        return redirect()->route('outlets.index');
    }
}
