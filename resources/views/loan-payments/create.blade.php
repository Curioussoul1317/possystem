@extends('layouts.app')
@section('content')
<div class="page-header d-print-none">
   <div class="container-xl">
      <div class="row justify-content-center">
         <!-- ///////// TOP -->
         <div class="col-8" style="margin-bottom: 25px;">
            <div class="row justify-content-between">
               <div class="col-4">
                  <h2 class="page-title">
                PAY LOAN
                  </h2>
               </div>
               <div class="col-4">
                  <div class="btn-list btn-sm " style=" float: right;">
                     <a href="{{ route('loans.index') }}" class="btn btn-primary d-none d-sm-inline-block btn-sm " >
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                           <path d="M12 5l0 14"></path>
                           <path d="M5 12l14 0"></path>
                        </svg>  LOANS
                      
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <!-- /////////// BOTTOM  -->
         <div class="col-10"> 
             <div class="card">

              <div class="row">
    <div class="col">
       <p class="text-sm text-gray-600"><strong>Loan Amount</strong> Mvr {{ number_format($loan->amount, 2) }}</p> 
    </div>
    <div class="col">
      <p class="text-sm text-gray-600"><strong>Remaining Amount</strong> Mvr {{ number_format($loan->remaining_amount, 2) }}</p> 
    </div>
  </div>
    
 



    <form action="{{ route('loan-payments.store') }}" method="POST">
                        @csrf
                         <div class="row">
                        <input type="hidden" name="loan_id" value="{{ $loan->id }}">

                       <div class="form-group col-md-2">
                            <label for="amount" class="posinputlable">Payment Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" 
                                   class="form-control posinput"
                                   max="{{ $loan->remaining_amount }}"
                                   value="{{ old('amount') }}" required>
                            @error('amount')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                       <div class="form-group col-md-2">
                            <label for="payment_date" class="posinputlable">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" 
                                   class="form-control posinput"
                                   value="{{ old('payment_date', date('Y-m-d')) }}" required>
                            @error('payment_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                       <div class="form-group col-md-4">
                            <label for="payment_method" class="posinputlable">Payment Method</label>
                            <select name="payment_method" id="payment_method" 
                                    class="form-control posinput" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                            </select>
                            @error('payment_method')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                       <div class="form-group col-md-4">
                            <label for="reference_number" class="posinputlable">Reference Number (Optional)</label>
                            <input type="text" name="reference_number" id="reference_number" 
                                   class="form-control posinput"
                                   value="{{ old('reference_number') }}">
                            @error('reference_number')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary">
                                Submit Payment
                            </button>
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                          </div>
                    </form>
        
 

                  
                </div>
         </div>
      </div>
   </div>
</div>
 
 
 
    @endsection
 




























