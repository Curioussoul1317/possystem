 @extends('layouts.app')

 @section('content')

 <div class="page-header d-print-none">
     <div class="container-xl">
         <div class="row g-2 align-items-center">
             <div class="col">
                 <!-- Page pre-title -->
                 <h2 class="page-title">
                     All Orders
                 </h2>
             </div>
             <!-- Page title actions -->
             <div class="col-auto ms-auto d-print-none">

             </div>
         </div>
         <!-- ////////////////// -->

         <div class="card card-active">
             <div class="card-body">
                 <div class="row">
                     <div class="col">
                         <select name="status" id="status-filter" class="form-select">
                             <option value="">All Statuses</option>
                             <option value="neworder">New Order</option>
                             <option value="processing">Processing</option>
                             <option value="paid">Paid</option>
                             <option value="delivered">Delivered</option>
                             <option value="cancelled">Cancelled</option>
                         </select>
                     </div>
                     <div class="col">
                         <input type="date" id="date-filter" class="form-control">
                     </div>
                 </div>
             </div>
         </div>

         <!-- /////////////// -->
     </div>
 </div>

 <div class="page-body">
     <div class="container-xl">
         <!-- CONTENTS -->


         <div class="row row-cards">

             <div class="col-12">
                 <div class="card">
                     <div class="table-responsive">
                         <table class="table table-vcenter card-table">
                             <thead>
                                 <tr>
                                     <th>
                                         Order ID
                                     </th>
                                     <th>
                                         Customer
                                     </th>
                                     <th>
                                         Items
                                     </th>
                                     <th>
                                         Total
                                     </th>
                                     <th>
                                         Status
                                     </th>
                                     <th>
                                         Date
                                     </th>
                                     <th>
                                         Actions
                                     </th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($carts as $cart)
                                 <tr>
                                     <th>
                                         {{ $cart->cart_number }}
                                     </th>
                                     <th>
                                         {{ $cart->customer->first_name }} {{ $cart->customer->last_name }} /
                                         {{ $cart->customer->email }}
                                     </th>
                                     <th>
                                         {{ $cart->items->count() }} items
                                     </th>
                                     <th>
                                         ${{ number_format($cart->total, 2) }}
                                     </th>
                                     <th>
                                         <div class="badges-list">
                                             <span class="@if($cart->status === 'neworder')
                                             badge bg-azure text-azure-fg
                                             @elseif($cart->status === 'processing')
                                             badge bg-indigo text-indigo-fg
                                             @elseif($cart->status === 'paid')
                                             badge bg-purple text-purple-fg
                                              @elseif($cart->status === 'delivered')
                                              badge bg-cyan text-cyan-fg
                                              @else badge bg-green text-green-fg
                                              @endif">{{ ucfirst($cart->status) }}</span>
                                         </div>
                                     </th>
                                     <th>
                                         {{ $cart->created_at->format('M d, Y H:i') }}
                                     </th>
                                     <th>
                                         <a href="{{ route('cart.show', $cart->id) }}"
                                             class="btn btn-primary d-none d-sm-inline-block">
                                             View Details
                                         </a>
                                         @if($cart->status !== 'paid')
                                         <form action="{{ route('cart.updateStatus', $cart->id) }}" method="POST">
                                             @csrf
                                             <div class="input-group">
                                                 <select class="form-select" name="status" id="status">
                                                     @foreach(['neworder', 'processing', 'paid', 'delivered',
                                                     'cancelled'] as $status)
                                                     @if($cart->status !== $status)
                                                     <option value="{{ $status }}">{{ $status }}</option>
                                                     @endif
                                                     @endforeach
                                                 </select>
                                                 <div class="input-group-append">
                                                     <button class="btn btn-outline-secondary" type="submit">Up
                                                         Date</button>
                                                 </div>
                                             </div>
                                         </form>
                                         @endif
                                     </th>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                     <div class="card-footer d-flex align-items-center">
                     </div>
                 </div>
                 <div class="row justify-content-md-center">
                     <div class="col-md-auto">
                         {{ $carts->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

























 <script>
// Filter functionality
document.getElementById('status-filter').addEventListener('change', function() {
    updateFilters();
});

document.getElementById('date-filter').addEventListener('change', function() {
    updateFilters();
});

function updateFilters() {
    const status = document.getElementById('status-filter').value;
    const date = document.getElementById('date-filter').value;

    let url = new URL(window.location.href);
    if (status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');

    if (date) url.searchParams.set('date', date);
    else url.searchParams.delete('date');

    window.location.href = url.toString();
}
 </script>
 @endsection