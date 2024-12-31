<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Category;

use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{

    public function index()
    {
        $requirements = Category::query()

            ->get();

        return response()->json($requirements, 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request = $request->all();

        $validator = Validator::make($request, [
            'name' => 'required|string|max:40'
        ]);

        try
        {
            $newCategory = Category::create($validator->validated());
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category.',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => $newCategory
        ], 201);
    }


    public function show(Request $request, string $id)
    {
        try
        {
            $category = Category::query()

            ->when($request->has('incl'), function ($query) use ($request) {

                $incl = explode(',', $request->get('incl'));

                $query->with($incl);
            });
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to build query',
                'error' => $e->getMessage()
            ], 500);
        }

        try
        {
            $category = $category->findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }

        return response()->json($category, 200);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $request = $request->all();

        $validator = Validator::make($request, [
            'name' => 'string|max:40'
        ]);

        try
        {
            $validated = $validator->validated();
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Invallid update params',
                'error' => $e->getMessage()
            ], 500);
        }

        $category = Category::find($id);

        foreach ($validated as $key => $val) {
            $category->{$key} = $val;
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $category
        ], 200);
    }


    public function destroy(string $id)
    {
        try
        {
            $category = Category::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
            'data' => $category
        ], 200);
    }
}
