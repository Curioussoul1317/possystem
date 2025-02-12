 @extends('layouts.app')

 @section('content')

 <div class="page-header d-print-none">
     <div class="container-xl">
         <div class="row g-2 align-items-center">
             <div class="col">
                 <!-- Page pre-title -->
                 <h2 class="page-title">
                     Sale Details
                 </h2>
             </div>
             <!-- Page title actions -->
             <div class="col-auto ms-auto d-print-none">
                 <div class="btn-list">
                     <a href="{{ route('sales.invoice', $sale) }}" class="btn btn-primary d-none d-sm-inline-block">
                         <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                             <path d="M12 5l0 14"></path>
                             <path d="M5 12l14 0"></path>
                         </svg>
                         View Invoice
                     </a>
                     <a href="{{ route('sales.index') }}" class="btn btn-primary d-sm-none btn-icon">
                         <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                             <path d="M12 5l0 14"></path>
                             <path d="M5 12l14 0"></path>
                         </svg>
                         Back to Sales
                     </a>
                 </div>
             </div>
         </div>
     </div>
 </div>



 <div class="page-body">
     <div class="container-xl">
         <!-- CONTENTS -->
         <div class="card">
             <div class="card-status-top bg-danger"></div>
             <div class="card-body">
                 <div class="badges-list">
                     <span class="badge badge-outline text-blue">Invoice Number : {{ $sale->invoice_number }}</span>
                     <span class="badge badge-outline text-azure">Date :
                         {{ $sale->created_at->format('M d, Y H:i:s') }}</span>
                     <span class="badge badge-outline text-indigo">Payment Method :
                         {{ ucfirst($sale->payment_method) }}</span>
                     <span class=" {{ $sale->payment_status === 'paid' ? 'badge badge-outline text-purple' : 
                               ($sale->payment_status === 'voided' ? 'badge badge-outline text-red' : 
                                'badge badge-outline text-yellow') }}">Status {{ ucfirst($sale->payment_status) }}
                     </span>

                 </div>
             </div>
         </div>
         <!-- //////// -->
         <div class="card">
             <div class="card-status-top bg-danger"></div>
             <div class="card-body">
                 @if($sale->customer)
                 <span class="badge badge-outline text-blue">Name:
                     {{ $sale->customer->first_name }} {{ $sale->customer->last_name }} </span>
                 @if($sale->customer->email)
                 <span class="badge badge-outline text-blue">>Email:{{ $sale->customer->email }} </span>
                 @endif
                 @if($sale->customer->phone)
                 <span class="badge badge-outline text-blue">Phone:{{ $sale->customer->phone }} </span>
                 @endif
                 @if($sale->customer->address)
                 <span class="badge badge-outline text-blue">Address :{{ $sale->customer->address }} </span>
                 @endif
                 @else
                 <span class="badge badge-outline text-blue">Walk-in Customer </span>
                 @endif
             </div>
         </div>


         <div class="card">
             <div class="card-status-top bg-danger"></div>
             <div class="card-body">
                 <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                     Items Purchased
                 </h3>
                 <div class="table-responsive">
                     <table class="table table-vcenter card-table table-striped">
                         <thead>
                             <tr>
                                 <th>
                                     Product
                                 </th>
                                 <th>
                                     Quantity
                                 </th>
                                 <th>
                                     Unit Price
                                 </th>
                                 <th>
                                     Subtotal
                                 </th>
                             </tr>
                         </thead>
                         <tbody>

                             @foreach($sale->items as $item)
                             <tr>
                                 <td>
                                     <div class="d-flex py-1 align-items-center">
                                         @if($item->inventory->getPrimaryImage())
                                         <span class="avatar me-2"
                                             style="background-image: url({{ asset('storage/' . $item->inventory->getPrimaryImage()->image_path) }})"></span>
                                         @endif
                                         <div class="flex-fill">
                                             <div class="font-weight-medium"> {{ $item->inventory->item_code }}
                                             </div>
                                             <div class="text-secondary"><a href="#"
                                                     class="text-reset">{{ $item->inventory->name }}</a></div>
                                         </div>
                                     </div>
                                 </td>
                                 <td>
                                     {{ $item->quantity }}
                                 </td>
                                 <td>
                                     Mrf {{ number_format($item->unit_price, 2) }}
                                 </td>
                                 <td>
                                     Mrf {{ number_format($item->subtotal, 2) }}
                                 </td>
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>


         <div class="table-responsive">
             <table class="table table-vcenter card-table table-striped">
                 <tbody>
                     <tr>
                         <td>Subtotal : Mrf {{ number_format($sale->subtotal, 2) }}</td>
                         <td class="text-secondary">
                             Tax : Mrf {{ number_format($sale->tax, 2) }}
                         </td>
                         <td class="text-secondary"> @if($sale->discount > 0)
                             Discount: - Mrf {{ number_format($sale->discount, 2) }}
                             @endif</td>
                         <td class="text-secondary">
                             Total : Mrf {{ number_format($sale->total, 2) }}
                         </td>
                         <td>
                             @if($sale->payment_status !== 'voided')
                             <form action="{{ route('sales.void', $sale) }}" method="POST" class="inline-block"
                                 onsubmit="return confirm('Are you sure you want to void this sale? This action cannot be undone.')">
                                 @csrf
                                 <button type="submit" class="btn btn-danger btn-sm">
                                     Void Sale
                                 </button>
                             </form>
                             @endif
                         </td>
                     </tr>
                 </tbody>
             </table>
         </div>
     </div>


 </div>
 </div>





 @endsection