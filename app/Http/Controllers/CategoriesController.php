<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $allcategories = categories::orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('allcategories'));
    }

    public function create()
    { 
        return view('categories.create');
    } 

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255', 
        ]);
 
        
        categories::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(categories $categories)
    { 
        $allcategories = categories::orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('allcategories','categories')); 
    }

    public function update(Request $request, categories $categories)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',            
        ]);
 
        
        $categories->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(categories $categories)
    {
        // Check if category has products
        if ($categories->products()->count() > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Cannot delete category with associated products');
        }

        // Check if category has children
        if ($categories->children()->count() > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Cannot delete category with sub-categories');
        }
 

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }

    // Additional methods for category management

    public function updateOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->categories as $categoryData) {
            categories::where('id', $categoryData['id'])
                ->update(['order' => $categoryData['order']]);
        }

        return response()->json(['message' => 'Category order updated successfully']);
    }

    public function getSubcategories(categories $categories)
    {
        $subcategories = $categories->children()
            ->active()
            ->orderBy('order')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }
}