<?php

namespace App\Http\Controllers;

use App\Models\brands;
use Illuminate\Http\Request;

class BrandsController extends Controller
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
        $brands = brands::orderBy('name')
            ->paginate(10); 
        return view('brands.index', compact('brands'));
    }

    // public function create()
    // {
    //     return view('brands.create');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:brands,name',            
        ]);

          
        brands::create($validated);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand created successfully');
    }

    public function edit(brands $brand)
    {
         $brands = brands::orderBy('name')
            ->paginate(10);  
        return view('brands.index', compact('brand','brands'));
    }

    public function update(Request $request, brands $brand)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:brands,name,' . $brand->id,        
        ]);
 
        
        $brand->update($validated);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand updated successfully');
    }

    public function destroy(brands $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()
                ->route('brands.index')
                ->with('error', 'Cannot delete brand with associated products');
        }

       
        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand deleted successfully');
    }
}