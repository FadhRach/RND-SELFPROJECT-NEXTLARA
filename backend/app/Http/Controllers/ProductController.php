<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::all()->map(function($product){
            $product->product_image = $product->product_image ? asset("storage/" . $product->product_image) : null;
            return $product;
        });

        return response()->json([
            "status" => true,
            "products" => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name'    => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|integer|min:0',
            'stock'           => 'required|integer|min:0',
            'id_category'     => 'required|exists:categories,id_category',
            'product_status'  => 'required|',
        ]);

        $data["id_user"] = auth()->user()->id_user;
        if($request->hasFile("product_image")){
            $data["product_image"] = $request->file("product_image")->store("products", "public");
        }

        Product::create($data);

        return response()->json([
            "status" => true,
            "message" => "Product created successfully"
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, $id_product)
    {
        $product = Product::findOrFail($id_product);
        $product->product_image = $product->product_image ? asset("storage/" . $product->product_image) : null;

        return response()->json([
            "status" => true,
            "message" => "Product data found",
            "product" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'product_name'    => 'sometimes|required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'sometimes|required|integer|min:0',
            'stock'           => 'sometimes|required|integer|min:0',
            'id_category'     => 'sometimes|required|exists:categories,id_category',
            'product_status'  => 'sometimes|required|',
        ]);

        if($request->hasFile("product_image")){
            if($product->product_image){
                Storage::disk("public")->delete($product->product_image);
            }

            $data["product_image"] = $request->file("product_image")->store("products", "public");
        }

        $product->update($data);

        return response()->json([
            "status" => true,
            "message" => "Product updated successfully",
            "product" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            "status" => true,
            "message" => "Product deleted successfully",
        ]);
    }
}
