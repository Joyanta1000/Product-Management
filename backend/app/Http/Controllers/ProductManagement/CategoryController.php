<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => Category::paginate(request()->get('per_page')),
                'message' => 'Categories retrieved successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Something went wrong!',
            ]);
        }
    }

    public function categoriesProductAdd()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => Category::all(),
                'message' => 'Categories retrieved successfully',
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $createCategory = Category::create([
                'name' => $request->name
            ]);

            return response()->json([
                'status' => true,
                'data' => $createCategory,
                'message' => 'Category created successfully',
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
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Category not found',
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $category,
                'message' => 'Category retrieved successfully',
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
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Category not found',
                ]);
            }

            $category->update([
                'name' => $request->name
            ]);

            return response()->json([
                'status' => true,
                'data' => $category,
                'message' => 'Category updated successfully',
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
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Category not found',
                ]);
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Category deleted successfully',
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
