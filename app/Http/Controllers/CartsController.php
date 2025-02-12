<?php

namespace App\Http\Controllers;

use App\Models\carts;
use Illuminate\Http\Request;
use App\Models\cart_items;
use App\Models\inventory; 
use App\Models\inventory_images; 
use App\Models\sales; 

class CartsController extends Controller
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

    $query = carts::with(['customer'])
            ->latest();

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply date filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $carts = $query->paginate(10);
 

    return view('cart.index', compact('carts')); 
    
    }





    public function show($id) 
    {
        $cart = carts::with(['customer'])->find($id);  
        return view('cart.view', compact('cart'));      
      
    }


  

    public function updateStatus(Request $request, $cartid)
    { 
        try {
            $cart = carts::find($cartid); 
            $cart->status = $request->input('status');  
            if($request->input('status')=="paid"){
               
            $sale = new sales();
            $sale->customer_id = $cart->customer_id; 
            $sale->invoice_number = sales::generateInvoiceNumber();
            $sale->payment_method = 'bank_transfer';
            $sale->payment_status = 'paid';
            $sale->subtotal =$cart->total;
            $sale->tax = 0;
            $sale->discount = 0;
            $sale->total = $cart->total;
            $sale->sales_type="online";
            $sale->cart_number=$cart->cart_number;           
            $sale->save();  
               foreach ($cart->items as $cartItem) { 
                 $cart_items = new cart_items(); 
                 $cart_items->sales_id= $sale->id;
                 $cart_items->inventory_id= $cartItem->product_id;
                 $cart_items->quantity = $cartItem->quantity;
                 $cart_items->unit_price= $cartItem->price;
                 $cart_items->subtotal = $cartItem->subtotal;
                 $sale->save(); 
            }
      
 
            }      
              $cart->save();

            return redirect()->back()->with('success', 'Cart status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update cart status.');
        }
    }

    public function destroy(carts $cart)
    {
        $cart->delete();
        return response()->json(['message' => 'Cart deleted successfully']);
    }


    public function checkNewOrders()
    {
        $hasNewOrders = carts::where('status', 'neworder') 
            ->exists();

        return response()->json([
            'hasNewOrders' => $hasNewOrders
        ]);
    }
}