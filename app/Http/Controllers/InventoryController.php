<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use Illuminate\Http\Request; 
use App\Models\inventory_images; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\categories;
use App\Models\brands;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
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
    
       public function index(Request $request)
    {
         $query = inventory::query()->with(['brand', 'category', 'images']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%") 
                  ->orWhere('barcode', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%");
            });
        }

        
        // Brand Filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Stock Status Filter
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 10);
                    break;
                case 'low_stock':
                    $query->whereBetween('stock_quantity', [1, 10]);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '=', 0);
                    break;
            } 
        }

        $items = $query->latest()->paginate(3)->withQueryString(); 
        $brands = brands::orderBy('name')->get();
        $categories = categories::orderBy('name')->get();

        return view('inventory.index', compact('items', 'brands', 'categories'));
        
        // $items = inventory::with('images')
        //     ->orderBy('name')
        //     ->paginate(2);
        //     $brands = brands::orderBy('name')->get();
        //    $categories = categories::orderBy('name')->get(); 

        // return view('inventory.index', compact('items','brands','categories'));
    }

    public function create()
    {
          
  
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code'=> 'required',
            'barcode' => 'nullable',
            'name' => 'required|max:255',
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'gender' => 'nullable',
            'age' => 'nullable',
            'colour' => 'nullable',
            'volume' => 'nullable',
            'unit_cost'=> 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',     
            'discount_percentage'  => 'nullable',    
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

  
// return($validated);

        $inventory = inventory::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('inventory', 'public');
                
                $inventoryImage = new inventory_images([
                    'image_path' => $path,
                    'is_primary' => $key === 0, // First image is primary
                    'sort_order' => $key
                ]);

                $inventory->images()->save($inventoryImage);
            }
        }

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Item created successfully');
    }

    public function show(inventory $inventory)
    {
        $inventory->load('images');
        return view('inventory.show', compact('inventory'));
    }

    public function edit(inventory $inventory)
    {
        $inventory->load('images');
         $brands = brands::orderBy('name')->get();
           $categories = categories::orderBy('name')->get();  
        return view('inventory.edit', compact('inventory', 'brands', 'categories'));
    }

    public function update(Request $request, inventory $inventory)
    {
        $validated = $request->validate([
            'item_code'=> 'required',
            'barcode' => 'nullable',
            'name' => 'required|max:255',
            'brand_id' => 'nullable',
            'category_id' => 'nullable',
            'description' => 'nullable',
            'gender' => 'nullable',
            'age' => 'nullable',
            'colour' => 'nullable',
            'volume' => 'nullable',
            'unit_cost'=> 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',  
            'discount_percentage'  => 'nullable',               
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048' 
        ]); 

        $inventory->update($validated);

        if ($request->hasFile('images')) {
            // Delete old images if replace_images is true
            if ($request->boolean('replace_images')) {
                foreach ($inventory->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $inventory->images()->delete();
            }

            // Add new images
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('inventory', 'public');
                
                $inventoryImage = new inventory_images([
                    'image_path' => $path,
                    'is_primary' => $key === 0 && $request->boolean('replace_images'),
                    'sort_order' => $inventory->images()->count() + $key
                ]);

                $inventory->images()->save($inventoryImage);
            }
        }

        return redirect()
            ->route('inventory.show', $inventory)
            ->with('success', 'Item updated successfully');
    }

    public function destroy(inventory $inventory)
    {
        // Delete associated images from storage
        foreach ($inventory->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $inventory->delete();

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Item deleted successfully');
    }

    // Additional methods for image management
    public function updateImageOrder(Request $request, inventory $inventory)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*.id' => 'required|exists:inventory_images,id',
            'images.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->images as $imageData) {
            inventory_images::where('id', $imageData['id'])
                ->update(['sort_order' => $imageData['sort_order']]);
        }

        return response()->json(['message' => 'Image order updated successfully']);
    }

  public function setPrimary(inventory_images $image)
    {
        

        try {
            DB::beginTransaction();
 
            // Update all other images for this inventory item
            inventory_images::where('inventory_id', $image->inventory_id)
                ->where('id', '!=', $image->id)
                ->update(['is_primary' => false]);

            // Set this image as primary
            $image->is_primary = true;
            $image->save();

            DB::commit();

           

            return response()->json([
                'success' => true,
                'message' => 'Primary image updated successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
           

            return response()->json([
                'success' => false,
                'message' => 'Error setting primary image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteImage(inventory_images $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }

    // Stock management methods
    public function adjustStock(Request $request, inventory $inventory)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'operation' => 'required|in:add,subtract'
        ]);

        $inventory->updateStock(
            $request->quantity,
            $request->operation
        );

        return redirect()
            ->back()
            ->with('success', 'Stock updated successfully');
    }
}