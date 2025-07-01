<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // Assuming a Category model exists
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.campaigns.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.campaigns.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|size:7|regex:/^#[A-Fa-f0-9]{6}$/',
            'description' => 'nullable|string'
        ]);

        // Generate a unique slug from the name
        $slug = Str::slug($validated['name']);
        $baseSlug = $slug;
        $counter = 1;

        // Ensure slug uniqueness
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Create the category with the generated slug
        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'color' => $validated['color'],
            'description' => $validated['description']
        ]);

        return redirect()
            ->route('admin.campaigns-categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Implement show logic here
        return view('admin.campaigns.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Implement edit form logic here
        return view('admin.campaigns.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string|size:7|regex:/^#[A-Fa-f0-9]{6}$/',
                'description' => 'nullable|string'
            ]);

            // Only update slug if name has changed
            if ($category->name !== $validated['name']) {
                $slug = Str::slug($validated['name']);
                $baseSlug = $slug;
                $counter = 1;

                // Ensure slug uniqueness
                while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $validated['slug'] = $slug;
            }

            $category->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category updated successfully.'
                ]);
            }

            return redirect()
                ->route('admin.campaigns-categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update category: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Failed to update category: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        try {
            $category->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category deleted successfully.'
                ]);
            }

            return redirect()
                ->route('admin.campaigns-categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete category: ' . $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => 'Failed to delete category: ' . $e->getMessage()]);
        }
    }
} 