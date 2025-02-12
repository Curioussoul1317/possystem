@extends('layouts.app')
@section('content')
 
<main class="container-fluid"> 
  
  

<div class="container breadcrumbs">

  <div class="row justify-content-between" style="font-size: x-large;
    color: #03226a;">
    <div class="col-10">
      <div class="row justify-content-start">
    <div class="col-1">
      <a href="{{ route('loans.index') }}" class="text-decoration-none"><i class="fa-solid fa-backward breadcrumbsicon"></i></a>
    </div>
    <div class="col-4 backicon breadcrumbstext">
            LOANS DETAILS
    </div>
  </div>
    </div>
    <div class="col-2" >
        <a href="{{ route('loans.create') }}" class="text-decoration-none"  style=" float: right;" 
                        ><i class="fa-solid fa-square-plus  breadcrumbsicon"></i></a>
    </div>
  </div>
  
</div>


 
<!-- ///////////////// -->
  <div class="row justify-content-center">

    <div class="col-10">
<div class="card text-center">
  <div class="card-header listtablehead">
   LOANS INFORMATION
  </div>
  <div class="card-body">

  <div class="container">
  <div class="row">
    <div class="col col-6">
           <h3 class="text-lg font-semibold mb-4">Loan Information</h3>
    <ul class="list-group">
    <li class="list-group-item">Amount : Mvr {{ number_format($loan->amount, 2) }}</li>
    <li class="list-group-item">Remaining Amount Mvr {{ number_format($loan->remaining_amount, 2) }}</li>
    <li class="list-group-item">Interest Rate :{{ $loan->interest_rate }}%</li>
    <li class="list-group-item">A fourth item</li>
    <li class="list-group-item">Status :  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $loan->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($loan->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                               ($loan->status === 'paid' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($loan->status) }}
                                        </span> </li>
    </ul>
    </div>
    <div class="col col-6">
         <h3 class="text-lg font-semibold mb-4">Dates and Details</h3>
      <ul class="list-group">
  <li class="list-group-item">Loan Date : {{ $loan->loan_date->format('F j, Y') }}</li>
  <li class="list-group-item"> Due Date  : {{ $loan->due_date->format('F j, Y') }}
                                        @if($loan->is_overdue)
                                            <span class="text-red-600 ml-2">(Overdue)</span>
                                        @endif</li>
  <li class="list-group-item">Lender : {{ $loan->lender_name }}</li>
  <li class="list-group-item">Purpose : {{ $loan->purpose }}</li> 
</ul>
    </div>
  </div>
  <div class="row">
    <div class="col col-12">
         @if($loan->status === 'approved' && $loan->remaining_amount > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Make a Payment</h3>
                            <form action="{{ route('loan-payments.store') }}" method="POST" class="max-w-md">
                                @csrf
                                <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                
                                <div class="mb-4">
                                    <label for="amount" class="posinputlable">Payment Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" 
                                           class="form-control posinput"
                                           max="{{ $loan->remaining_amount }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="payment_date" class="posinputlable">Payment Date</label>
                                    <input type="date" name="payment_date" id="payment_date" 
                                           class="form-control posinput"
                                           value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="payment_method" class="posinputlable">Payment Method</label>
                                    <select name="payment_method" id="payment_method" 
                                            class="form-control posinput" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="check">Check</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="reference_number" class="posinputlable">Reference Number (Optional)</label>
                                    <input type="text" name="reference_number" id="reference_number" 
                                          class="form-control posinput">
                                </div>

                                <button type="submit"  class="btn btn-primary btn-sm">
                                    Submit Payment
                                </button>
                            </form>
                        </div>
                    @endif
    </div>     
     <div class="col col-12">
        <h3 class="text-lg font-semibold mb-4">Payment History</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >Date</th>
                                    <th >Amount</th>
                                    <th >Method</th>
                                    <th >Reference</th>
                                </tr>
                            </thead>
                            <tbody  >
                                @forelse($loan->payments as $payment)
                                    <tr>
                                        <td >{{ $payment->payment_date->format('M d, Y') }}</td>
                                        <td >${{ number_format($payment->amount, 2) }}</td>
                                        <td >{{ ucfirst($payment->payment_method) }}</td>
                                        <td >{{ $payment->reference_number ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" >No payments recorded yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
       </div>  
  </div>
</div>

  
  <div class="card-footer text-muted">
 
  </div>
</div>
    </div>  
  </div>
</main>

@endsection













