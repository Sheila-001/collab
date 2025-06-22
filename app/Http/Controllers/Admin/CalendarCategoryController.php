<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CalendarCategoryController extends Controller
{
    public function index()
    {
        $categories = CalendarCategory::orderBy('name')->get();
        return view('admin.calendar.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.calendar.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        CalendarCategory::create($validated);

        return redirect()
            ->route('admin.calendar-categories.index')
            ->with('success', 'Category has been created successfully.');
    }

    public function edit(CalendarCategory $calendar_category)
    {
        return view('admin.calendar.categories.edit', compact('calendar_category'));
    }

    public function update(Request $request, CalendarCategory $calendar_category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string|max:7',
                'description' => 'nullable|string',
            ]);

            $validated['slug'] = Str::slug($validated['name']);
            $calendar_category->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category has been updated successfully.'
                ]);
            }

            return redirect()
                ->route('admin.calendar-categories.index')
                ->with('success', 'Category has been updated successfully.');
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

    public function destroy(Request $request, CalendarCategory $calendar_category)
    {
        try {
            $calendar_category->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category has been deleted successfully.'
                ]);
            }

            return redirect()
                ->route('admin.calendar-categories.index')
                ->with('success', 'Category has been deleted successfully.');
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