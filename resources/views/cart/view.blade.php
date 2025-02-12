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

     </div>
 </div>

 <div class="page-body">
     <div class="container-xl">
         <!-- CONTENTS -->
         <div class="row justify-content-between">
             <div class="col-lg-8">
                 <div class="card">
                     <div class="table-responsive">
                         <table class="table table-vcenter card-table">
                             <tbody>
                                 <tr>
                                     <td>Name :{{ $cart->customer->first_name }} {{ $cart->customer->last_name }} /
                                         Email : {{ $cart->customer->email }}
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>
                                         {{ $cart->customer->phone }}
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>
                                         {{ $cart->customer->city }} / {{ $cart->customer->state }}
                                         /{{ $cart->customer->address }}
                                     </td>
                                 </tr>

                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-4">
                 <div class="card">
                     <div class="card-body">
                         <h3 class="card-title">
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
                         </h3>
                         @if($cart->status !== 'paid')
                         <form action="{{ route('cart.updateStatus', $cart->id) }}" method="POST">
                             @csrf
                             <div class="input-group">
                                 <select class="form-select" name="status" id="status">
                                     @foreach(['neworder', 'processing', 'paid', 'delivered', 'cancelled'] as $status)
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
                         <table class="table table-sm table-borderless">
                             <thead>
                                 <tr>
                                     <th>Order</th>
                                     <th class="text-end">Detail</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td>
                                         <div class="progressbg">
                                             <div class="progress progressbg-progress">
                                                 <div class="progress-bar bg-primary-lt" style="width: 50%"
                                                     role="progressbar">
                                                 </div>
                                             </div>
                                             <div class="progressbg-text">Order ID</div>
                                         </div>
                                     </td>
                                     <td class=" fw-bold text-end">{{ $cart->cart_number }}</td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="progressbg">
                                             <div class="progress progressbg-progress">
                                                 <div class="progress-bar bg-primary-lt" style="width: 50%"
                                                     role="progressbar">
                                                 </div>
                                             </div>
                                             <div class="progressbg-text">No of Items</div>
                                         </div>
                                     </td>
                                     <td class=" fw-bold text-end">{{ $cart->items->count() }}</td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="progressbg">
                                             <div class="progress progressbg-progress">
                                                 <div class="progress-bar bg-primary-lt" style="width: 50%"
                                                     role="progressbar">
                                                 </div>
                                             </div>
                                             <div class="progressbg-text">Total MRF</div>
                                         </div>
                                     </td>
                                     <td class=" fw-bold text-end">Mrf {{ number_format($cart->total, 2) }} /-</td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="progressbg">
                                             <div class="progress progressbg-progress">
                                                 <div class="progress-bar bg-primary-lt" style="width: 50%"
                                                     role="progressbar">
                                                 </div>
                                             </div>
                                             <div class="progressbg-text">Date</div>
                                         </div>
                                     </td>
                                     <td class=" fw-bold text-end"> {{ $cart->created_at->format('M d, Y H:i') }}</td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
         <div class="row row-cards">

             <div class="col-12">
                 <div class="card">

                     <div class="table-responsive">
                         <table class="table table-vcenter card-table">
                             <thead>
                                 <tr>
                                     <th>Name and Item Code</th>
                                     <th>Barcode</th>
                                     <th>Brand</th>
                                     <th>Category</th>
                                     <th>QTY</th>
                                     <th>Gender</th>
                                     <th>Age</th>
                                     <th>Colour</th>
                                     <th>Volume</th>
                                     <th>Cost</th>
                                     <th>Price</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($cart->items as $item)
                                 <tr>
                                     <td>
                                         <div class="d-flex py-1 align-items-center">
                                             @if($item->product->getPrimaryImage())
                                             <span class="avatar me-2"
                                                 style="background-image: url({{ asset('storage/' . $item->product->getPrimaryImage()->image_path) }})"></span>
                                             @else
                                             @endif
                                             <div class="flex-fill">
                                                 <div class="font-weight-medium"> {{ $item->product->name}}</div>
                                                 <div class="text-secondary"><a href="#"
                                                         class="text-reset">{{ $item->item_code}}</a></div>
                                             </div>
                                         </div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->barcode}}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->brand->name}}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->category->name}}</div>
                                     </td>
                                     <td>
                                         <div>Quantity: {{ $item->quantity }} x
                                             ${{ number_format($item->price, 2) }}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->gender}}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->age}}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->colour}}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->volume}}</div>
                                     </td>
                                     <td>
                                         <div>{{ number_format($item->subtotal, 2) }}</div>
                                     </td>
                                     <td>
                                         <div>{{ $item->product->unit_price}}</div>
                                     </td>
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

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>




 @endsection