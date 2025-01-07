<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => Product::with('categories')->paginate(10),
                'message' => 'Products retrieved successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            $product->categories()->attach($request->categories);

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $originalFileName = $image->getClientOriginalName();

                $newFileName = Hash::make(Date::now()) . random_int(1000, 9999) . '.' . $image->getClientOriginalExtension();

                $path = $image->storeAs('public/product_images', $newFileName);

                $product->update(['image' => $newFileName]);
            }

            return response()->json([
                'status' => true,
                'data' => $product,
                'message' => 'Product created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with(['categories'])->find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Product not found',
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $product,
                'message' => 'Product retrieved successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {

        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Product not found',
                ]);
            }

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            $product->categories()->sync($request->categories);

            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $originalFileName = $image->getClientOriginalName();

                $newFileName = Hash::make(Date::now()) . random_int(1000, 9999) . '.' . $image->getClientOriginalExtension();

                $path = $image->storeAs('public/product_images', $newFileName);

                $product->update(['image' => $newFileName]);
            }

            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Product updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Something went wrong!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Product not found',
                ]);
            }

            $product->delete();

            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Product deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Something went wrong!',
            ]);
        }
    }
}
