<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Events\ProductCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'required|image|max:2048'
        ]);

        $validated['user_id'] = Auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            
            // Get the file content
            $fileContent = file_get_contents($image->getRealPath());
            
            // Use Storage facade to store the file
            $stored = Storage::disk('ftp')->put('products/'.$filename, $fileContent);
            
            if (!$stored) {
                return back()->with('error', 'Failed to upload image to FTP server.');
            }
            
            $validated['image_path'] = 'products/'.$filename;
        }

        $product = Product::create($validated);
        
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
            'image' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('ftp')->delete('products/' . $product->image_path);
            }
            
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            
            // Get the file content
            $fileContent = file_get_contents($image->getRealPath());
            
            // Use Storage facade to store the file
            $stored = Storage::disk('ftp')->put('products/'.$filename, $fileContent);
            
            if (!$stored) {
                return back()->with('error', 'Failed to upload image to FTP server.');
            }
            
            $validated['image_path'] = 'products/'.$filename;
        }

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
