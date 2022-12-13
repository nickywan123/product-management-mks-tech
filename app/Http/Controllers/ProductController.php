<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct() 
    {
    $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|min:3|max:255',
            'product_description' => 'required',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'name' => $request->product_name,
            'description' => $request->product_description,
            'quantity' => $request->product_quantity,
            'price' => $request->product_price
        ]);

        return redirect()->route('products.show', [$product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product_images = $product->getMedia('product-images');
        
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|min:3|max:255',
            'product_description' => 'required',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
        ]);

        $product = Product::find($id);

        $product->update([
            'name' => $request->product_name,
            'description' => $request->product_description,
            'quantity' => $request->product_quantity,
            'price' => $request->product_price
        ]);

        //process product images upload
        
        if (count($product->getMedia('product-images')) > 0) {
            foreach ($product->getMedia('product-images') as $media) {
                if (!in_array($media->file_name, $request->input('document', []))) {
                    $media->delete();
                }
            }
        }
    
        $media = $product->getMedia('product-images')->pluck('file_name')->toArray();
    
        foreach ($request->input('document', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia(storage_path('images/' . $file))->toMediaCollection('product-images');
            }
        }

        return redirect()->route('products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product has been deleted.');
    }

    public function storeMedia(Request $request) {
        $path = storage_path('/images');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
