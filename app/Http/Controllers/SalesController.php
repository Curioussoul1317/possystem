<?php

namespace App\Http\Controllers;

use App\Models\sales;
use App\Models\sale_items;
use App\Models\customers;
use App\Models\inventory;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SalesController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
     public function index(Request $request)
    {
        // $sales = sales::with(['customer', 'items.inventory'])
        //     ->latest()
        //     ->paginate(10);

        // return view('sales.index', compact('sales'));
          $query = sales::with(['customer', 'items.inventory']);

        // Apply date filters
        $this->applyDateFilters($query, $request);
        
        // Apply payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Apply payment method filter
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Calculate statistics for filtered data
        $stats = $this->calculateStatistics($query->clone());

        // Get paginated results
        $sales = $query->latest()->paginate(50)->withQueryString(); 
        return view('sales.index', [
            'sales' => $sales,
            'salesCount' => $stats['count'],
            'totalRevenue' => $stats['revenue'],
            'total_cost'=>$stats['total_cost'],
            'averageSale' => $stats['average'],
            'totalItems' => $stats['items'],
        ]);
    }


      private function applyDateFilters($query, Request $request)
    {
        if ($request->filled('quick_date')) {
            switch ($request->quick_date) {
                case 'today':
                    $query->whereDate('sales.created_at', Carbon::today());
                    break;

                case 'yesterday':
                    $query->whereDate('sales.created_at', Carbon::yesterday());
                    break;

                case 'this_week':
                    $query->whereBetween('sales.created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;

                case 'this_month':
                    $query->whereMonth('sales.created_at', Carbon::now()->month)
                          ->whereYear('sales.created_at', Carbon::now()->year);
                    break;

                case 'last_month':
                    $lastMonth = Carbon::now()->subMonth();
                    $query->whereMonth('sales.created_at', $lastMonth->month)
                          ->whereYear('sales.created_at', $lastMonth->year);
                    break;

                case 'custom':
                    if ($request->filled('start_date')) {
                        $query->whereDate('sales.created_at', '>=', $request->start_date);
                    }
                    if ($request->filled('end_date')) {
                        $query->whereDate('sales.created_at', '<=', $request->end_date);
                    }
                    break;
            }
        }

        return $query;
    }

    private function calculateStatistics($query)
    {
        // Calculate basic stats
        $basicStats = $query->select([
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total) as total_revenue'),
            DB::raw('SUM(total_cost) as total_cost'),
            DB::raw('AVG(total) as avg_sale')
        ])->first();

        // Calculate total items sold
        $totalItems = $query->join('sale_items', 'sales.id', '=', 'sale_items.sales_id') 
            ->sum('sale_items.quantity');

        return [
            'count' => $basicStats->count ?? 0,
            'revenue' => $basicStats->total_revenue ?? 0,
            'total_cost' => $basicStats->total_cost ?? 0,
            'average' => $basicStats->avg_sale ?? 0,
            'items' => $totalItems ?? 0
        ];
    }

    

    public function create()
    {
        $customers = customers::orderBy('first_name')->get();
        return view('sales.create', compact('customers'));
    }

    // public function searchProducts(Request $request)
    // {
    //     $search = $request->get('search');

    //     $products = inventory::where(function($query) use ($search) {
    //         $query->where('name', 'like', "%{$search}%") 
    //         ->orWhere('item_code', 'like', "%{$search}%")
    //               ->orWhere('barcode', 'like', "%{$search}%");
    //     })
    //     ->where('stock_quantity', '>', 0)
    //     ->with(['brand', 'category'])
    //     ->limit(10)
    //     ->get()
    //     ->map(function ($product) {
    //         return [
    //             'id' => $product->id,
    //             'name' => $product->name, 
    //             'price' => $product->unit_price,
    //             'cost' => $product->unit_cost,
    //             'discount_percentage' => $product->discount_percentage,
    //             'stock' => $product->stock_quantity,
    //             'brand' => optional($product->brand)->name,
    //             'category' => optional($product->category)->name,
    //             'image' => $product->getPrimaryImage() ? asset('storage/' . $product->getPrimaryImage()->image_path) : null
    //         ];
    //     });

    //     return response()->json($products);
    // }


    public function searchProducts(Request $request)
{
    $search = $request->get('search');

    $products = Inventory::where(function($query) use ($search) {
        $query->where('name', 'like', "%{$search}%") 
              ->orWhere('item_code', 'like', "%{$search}%")
              ->orWhere('barcode', 'like', "%{$search}%");
    })
    ->where('stock_quantity', '>', 0)
    ->with(['brand', 'category'])
    ->limit(10)
    ->get()
    ->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name, 
            'price' => $product->unit_price,
            'cost' => $product->unit_cost,
            'discount_percentage' => $product->discount_percentage,
            'stock' => $product->stock_quantity,
            'brand' => optional($product->brand)->name,
            'category' => optional($product->category)->name,
            'image' => $product->getPrimaryImage() ? asset('storage/' . $product->getPrimaryImage()->image_path) : null
        ];
    });

    if ($products->isEmpty()) {
        return response()->json([]);
    }

    return response()->json($products);
}



    public function store(Request $request)
    {
          
           $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventories,id', 
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.itemdiscount'  => 'nullable',
            'discount' => 'min:0',
            'total_cost'=> 'min:0',
            'tax' => 'min:0',            
            'payment_method' => 'required|in:cash,card,bank_transfer'
        ]);

        

        try {
            DB::beginTransaction();

            $subtotal = 0; 
            $items = collect($validated['items'])->map(function ($item) use (&$subtotal) { 
            if($item['itemdiscount'] !=0){
               $tempitemSubtotal = $item['unit_price'] * (1 - $item['itemdiscount']/100); 
                $itemSubtotal = $item['quantity'] * $tempitemSubtotal;
            }else{
               $itemSubtotal = $item['quantity'] *$item['unit_price'];
            } 
            $subtotal += $itemSubtotal;
            return array_merge($item, ['subtotal' => $itemSubtotal]);
        });

        $tax = $subtotal * config('pos.tax_rate', 0.08); // 10% tax
        $total = $subtotal + $tax;
        $total_cost=$validated['total_cost'];
 
            // Create sale
            $sale = new sales();
            $sale->customer_id = $validated['customer_id'];
            $sale->invoice_number = sales::generateInvoiceNumber();
            $sale->payment_method = $validated['payment_method'];
            $sale->payment_status = 'paid';
            $sale->subtotal =round($subtotal);
            $sale->tax = round($tax); 
            $sale->discount =  $validated['discount'];
            $sale->total = round($total);
            $sale->total_cost = round($total_cost);
            $sale->sales_type="shop";
            $sale->cart_number="";  
            $sale->save();
 

            // Add items and update inventory           

              foreach ($validated['items'] as $item) {
                $inventory = inventory::findOrFail($item['inventory_id']);
                
                // Check stock
                if ($inventory->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$inventory->name}");
                }

                // Create sale item
                $saleItem = new sale_items([
                    'inventory_id' => $item['inventory_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);

                $sale->items()->save($saleItem);

                // Update inventory
                $inventory->stock_quantity -= $item['quantity'];
                $inventory->save();
            }

            // $sale->calculateTotal();
            
            // Calculate totals
            $tax = $subtotal * config('pos.tax_rate', 0.08); // 10% tax
            $totalone = $subtotal + $tax;
            $total =$totalone-$validated['discount'];

            $sale->update([
                'subtotal' => round($subtotal),
                'tax' => round($tax),
                'total' => round($total),
            ]);

            DB::commit();

            Log::info('Sale completed successfully', ['sale_id' => $sale->id]);

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully',
                'sale' => $sale->load('items.inventory', 'customer')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sale failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
   

    public function show(sales $sale)
    {
        $sale->load('items.inventory', 'customer');
        return view('sales.show', compact('sale'));
    }

    public function generateInvoice(sales $sale)
    {
        $sale->load('items.inventory', 'customer');
        return view('sales.invoice', compact('sale'));
    }

    public function voidSale(sales $sale)
    {
          try {
            DB::beginTransaction();

            // Return items to inventory
            foreach ($sale->items as $item) {
                $inventory = $item->inventory;
                $inventory->stock_quantity += $item->quantity;
                $inventory->save();
            }

            // Update sale status
            $sale->update([
                'payment_status' => 'voided',  // This value must match exactly with the ENUM values
                'voided_at' => now()
            ]);

            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', 'Sale voided successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error voiding sale: ' . $e->getMessage());
            
            return redirect()
                ->route('sales.index')
                ->with('error', 'Error voiding sale: ' . $e->getMessage());
        }
    }
}