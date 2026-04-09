<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutletProductRequest;
use App\Http\Requests\UpdateOutletProductRequest;
use App\Models\Outlet;
use App\Models\OutletProduct;
use Modules\Product\Entities\Product;

class OutletProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outletProducts = OutletProduct::query()
            ->with(['outlet', 'product'])
            ->latest()
            ->paginate(15);

        return view('outlet-products.index', compact('outletProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $outlets = Outlet::query()->orderBy('name')->get(['id', 'name']);
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name', 'product_price']);

        return view('outlet-products.create', compact('outlets', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutletProductRequest $request)
    {
        OutletProduct::create($request->validated());

        toast('Outlet Product Created!', 'success');

        return redirect()->route('outlet-products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutletProduct $outletProduct)
    {
        $outletProduct->load(['outlet', 'product']);

        return view('outlet-products.show', compact('outletProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutletProduct $outletProduct)
    {
        $outlets = Outlet::query()->orderBy('name')->get(['id', 'name']);
        $products = Product::query()->orderBy('product_name')->get(['id', 'product_name', 'product_price']);

        return view('outlet-products.edit', compact('outletProduct', 'outlets', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutletProductRequest $request, OutletProduct $outletProduct)
    {
        $outletProduct->update($request->validated());

        toast('Outlet Product Updated!', 'info');

        return redirect()->route('outlet-products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutletProduct $outletProduct)
    {
        $outletProduct->delete();

        toast('Outlet Product Deleted!', 'warning');

        return redirect()->route('outlet-products.index');
    }
}
