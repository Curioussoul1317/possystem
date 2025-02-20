@extends('layouts.app')

@section('content')
 <main class="container-fluid">
         <div class="container breadcrumbs">
            <div class="row justify-content-between" style="font-size: x-large;
               color: #03226a;">
               <div class="col-10">
                  <div class="row justify-content-start">
                     <div class="col-1">
                        <a href="{{ route('home') }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
                     </div>
                     <div class="col-4 backicon breadcrumbstext">
                       SALES HISTORY
                     </div>
                  </div>
               </div>
               <div class="col-2"> 
                  <a class="text-decoration-none"   href="{{ route('sales.create') }}"  > NEW SALES
                  <i class="fa-solid fa-square-plus  breadcrumbsicon"></i>
                  </a>
               </div>
            </div>
         </div>
         <!-- ///////////////// -->
  

         <!-- ///////////////// -->
   <div class="row justify-content-center" > 
 <div class="col-10  "  >
 <div class="col-12">
<div class="card " style="margin-bottom:5px;   ">
 <div class="card-header listtablehead">
                  FILTTER 
                  </div>
<div class="card-body">

<form  action="{{ route('sales.index') }}" method="GET">
  <div class="row">
       
<div class="form-group col-md-3">  
    <select name="quick_date" id="quick_date" class="form-select posinput"
                                onchange="handleQuickDateChange(this.value)">
                                <option value="">Select Filter</option>
                                <option value="today" {{ request('quick_date') == 'today' ? 'selected' : '' }}>Today
                                </option>
                                <option value="yesterday" {{ request('quick_date') == 'yesterday' ? 'selected' : '' }}>
                                    Yesterday</option>
                                <option value="this_week" {{ request('quick_date') == 'this_week' ? 'selected' : '' }}>
                                    This
                                    Week</option>
                                <option value="this_month"
                                    {{ request('quick_date') == 'this_month' ? 'selected' : '' }}>
                                    This Month</option>
                                <option value="last_month"
                                    {{ request('quick_date') == 'last_month' ? 'selected' : '' }}>
                                    Last Month</option>
                                <option value="custom" {{ request('quick_date') == 'custom' ? 'selected' : '' }}>Custom
                                    Range</option>
                            </select> 
    </div>
<div class="form-group col-md-3">  
    <div id="custom_dates"
                                class="  {{ request('quick_date') == 'custom' ? '' : 'hidden' }}">
                                <div class="input-group"> 
<input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="form-control posinput" placeholder="Start Date" >
 <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="form-control posinput" placeholder="End Date" >
</div> 
                            </div>
    </div>
<div class="form-group col-md-2">  
       <select name="payment_status" class="form-select posinput">
                                    <option value="">All Statuses</option>
                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>
                                        Paid
                                    </option>
                                    <option value="pending"
                                        {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="voided"
                                        {{ request('payment_status') == 'voided' ? 'selected' : '' }}>Voided
                                    </option>
                                </select>
    </div>
 

<div class="form-group col-md-2">  
<select name="payment_method" class="form-select posinput">
                                <option value="">All Methods</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card
                                </option>
                                <option value="bank_transfer"
                                    {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                </option>
                            </select>
    </div>

 
    <div class="form-group col-md-2"> 
       <div class="btn-group mr-2" role="group" aria-label="Second group">
    <button type="submit" class="btn btn-danger ">APPLY</button>
     <a href="{{ route('sales.index') }}" class="btn btn-success">
                                    Clear Filters
     </a> 
     <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    V
  </button>
  </div>
    </div>
<div class="hr"></div>
 
 
 
</form>
</div>

 </div>
</div>
 </div>
</div>

<!-- ///////////////// -->
         <div class="row justify-content-center"> 
           
            <div class="col-10">
                 <div class="collapse" id="collapseExample">
  <div class="card card-body">
    <div class="card-header listtablehead">
                   TOTAL PROFIT AND LOST FOR THE SELECTED DATE
                  </div>
 <table class="table table-vcenter card-table">
                            <thead>
                                <tr> 
                                    <th>Total Items Sold {{$totalItems}}</th>
                                    <th>Total Cost {{$total_cost}}</th>
                                    <th>Total Revenue {{$totalRevenue}}</th>
                                    <th>Total Profit {{$totalRevenue-$total_cost}}</th> 
                                </tr>
                            </thead>
                        </table>
  </div>
</div>

               <div class="card">
                  <div class="card-header listtablehead">
                    SALES HISTORY
                  </div>
                  <div class="card-body">
                     <table class="table table-striped">
                          <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Qty</th>
                                    <th>Cost</th>
                                    <th>Total</th>
                                    <th>Profit</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Sales Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                           <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td>
                                        {{ $sale->invoice_number }}
                                    </td>
                                    <td>
                                        @if(isset($sale->customer_id))
                                        {{ $sale->customer->first_name . ' ' . $sale->customer->last_name  }}
                                        @else
                                        Walk-in Customer
                                        @endif
                                    </td>
                                    <td>
                                        {{ $sale->items->count() }}
                                    </td>
                                    <td>
                                        Mrf {{ number_format($sale->total_cost, 2) }}
                                    </td>
                                     <td>
                                        Mrf {{ number_format($sale->total, 2) }}
                                    </td>
                                      <td>
                                         Mrf {{ number_format((float)$sale->total - (float)$sale->total_cost, 2) }} 
                                    </td>
                                    <td>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                       {{ $sale->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                          ($sale->payment_status === 'voided' ? 'bg-red-100 text-red-800' : 
                                           'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($sale->payment_status) }} 
                                        </span>
                                    </td>
                                    <td>
                                        {{ $sale->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td>
                                        {{ $sale->sales_type }}
                                        @if($sale->sales_type=="online")
                                        No: {{$sale->cart_number  }}
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example"
                                            style="float: right;">
                                            <a href=" {{ route('sales.show', $sale) }}" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                            <a href="{{ route('sales.invoice', $sale) }}"
                                                class="btn btn-success btn-sm">
                                                Invoice
                                            </a>
                                            @if($sale->payment_status !== 'voided')
                                            <form action="{{ route('sales.void', $sale) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to void this sale?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Void
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>


                                @endforeach
                            </tbody>
                     </table>
                  </div>
                  <div class="card-footer text-muted">
                      {{ $sales->links() }}
                  </div>
               </div>
            </div>
         </div>
      </main>
<script>
    document.getElementById('barcode-input').addEventListener('keypress', function(event) {
    // Prevent form submission on Enter key
    if (event.key === 'Enter') {
        event.preventDefault(); 
        let barcodeValue = this.value; 
    }
});
    </script>
@endsection 












































 