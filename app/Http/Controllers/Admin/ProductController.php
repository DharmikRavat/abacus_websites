<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name'        => 'required|string|max:255',
            'item_brand'       => 'nullable|string|max:255',
            'item_type'        => 'nullable|string|max:255',
            'item_description' => 'nullable|string',
            'discount_on_item' => 'required|numeric|min:0',
            'item_price'       => 'required|numeric|min:0',
            'item_qty'         => 'required|integer|min:0',
            'item_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'status'           => 'required|boolean',
        ]);

        $imagePath = null;

        if ($request->hasFile('item_image')) {

            $uploadPath = public_path('uploads/products');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image = $request->file('item_image');

            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $image->move($uploadPath, $imageName);

            $imagePath = 'uploads/products/' . $imageName;
        }

        $product = Product::create([
            'item_name'        => $request->item_name,
            'item_brand'       => $request->item_brand,
            'item_type'        => $request->item_type,
            'item_description' => $request->item_description,
            'discount_on_item' => $request->discount_on_item,
            'item_price'       => $request->item_price,
            'item_qty'         => $request->item_qty,
            'item_image'       => $imagePath,
            'status'           => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'item_name'        => 'required|string|max:255',
            'item_brand'       => 'nullable|string|max:255',
            'item_type'        => 'nullable|string|max:255',
            'item_description' => 'nullable|string',
            'discount_on_item' => 'required|numeric|min:0',
            'item_price'       => 'required|numeric|min:0',
            'item_qty'         => 'required|integer|min:0',
            'item_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'status'           => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->item_image;

        if ($request->hasFile('item_image')) {

            // Delete old image
            if ($product->item_image) {

                $oldImage = public_path($product->item_image);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $uploadPath = public_path('uploads/products');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image = $request->file('item_image');

            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $image->move($uploadPath, $imageName);

            $imagePath = 'uploads/products/' . $imageName;
        }

        $product->update([
            'item_name'        => $request->item_name,
            'item_brand'       => $request->item_brand,
            'item_type'        => $request->item_type,
            'item_description' => $request->item_description,
            'discount_on_item' => $request->discount_on_item,
            'item_price'       => $request->item_price,
            'item_qty'         => $request->item_qty,
            'item_image'       => $imagePath,
            'status'           => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete image from public folder
        if ($product->item_image) {

            $imagePath = public_path($product->item_image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}