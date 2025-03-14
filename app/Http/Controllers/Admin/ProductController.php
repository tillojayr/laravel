<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Events\ProductCreated;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    public function index()
    {
        $products = Cache::remember('products_with_users', now()->addMinutes(10), function () {
            return Product::with('user')->get();
        });
    
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'quantity' => 'required|integer',
            'image' => 'required|image|max:2048'
        ]);

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

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'quantity' => 'required|integer',
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

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id) {
            return back()->with('error', 'Cannot delete product that is assigned to a user.');
        }

        $product->del_flag = true;
        $product->save();
        return back()->with('success', 'Product deleted successfully');
    }

    public function createFromApi()
    {
        $products = $this->productService->getAllProduct()->getData();
        return view('admin.products.createFromApi', compact('products'));
    }

    public function storeFromApi(int $productId) 
    {
        $product = $this->productService->getSingleProduct($productId)->getData();

        Product::create([
            'title' => $product->title,
            'body' => $product->description,
            'image_path' => (isset($product->image) ? $product->image : $product->images[0]),
        ]);

        Cache::forget('products_with_users');

        return redirect()->route('admin.products.index')->with('success', 'Products created successfully');
    }
}
