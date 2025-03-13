<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Events\ProductCreated;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->where(['user_id' => Auth()->user()->id])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'quantity' => 'required|integer',
        ]);

        $validated['user_id'] = Auth()->user()->id;

        $product = new Product();
        $product->fill($validated);
        $product->save();

        // Dispatch the event
        ProductCreated::dispatch($product);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'quantity' => 'required|integer',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->del_flag = true;
        $product->save();
        
        return back()->with('success', 'Product deleted successfully');
    }
}
