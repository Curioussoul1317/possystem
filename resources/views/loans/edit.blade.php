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
                EDIT LOAN
                  </h2>
               </div>
               <div class="col-4">
                  <div class="btn-list btn-sm " style=" float: right;">
                     <a href="{{ route('loans.create') }}" class="btn btn-primary d-none d-sm-inline-block btn-sm " >
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                           <path d="M12 5l0 14"></path>
                           <path d="M5 12l14 0"></path>
                        </svg>   NEW LOAN
                      
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <!-- /////////// BOTTOM  -->
         <div class="col-8"> 
             <div class="card">
    

                  <form action="{{ route('loans.update', $loan) }}" method="POST">
                        @csrf
                        @method('PUT')
 <div class="row">
                        <div class="form-group col-md-4">
                            <label for="amount" class="posinputlable">Loan Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" 
                                  class="form-control posinput"
                                   value="{{ old('amount', $loan->amount) }}" required>
                            @error('amount')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
 

                        <div class="form-group col-md-4">
                            <label for="loan_date" class="posinputlable">Loan Date</label>
                            <input type="date" name="loan_date" id="loan_date" 
                                  class="form-control posinput"
                                   value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" required>
                            @error('loan_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="due_date" class="posinputlable">Due Date</label>
                            <input type="date" name="due_date" id="due_date" 
                                  class="form-control posinput"
                                   value="{{ old('due_date', $loan->due_date->format('Y-m-d')) }}" required>
                            @error('due_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="lender_name" class="posinputlable">Lender Name</label>
                            <input type="text" name="lender_name" id="lender_name" 
                                  class="form-control posinput"
                                   value="{{ old('lender_name', $loan->lender_name) }}" required>
                            @error('lender_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="purpose" class="block text-gray-700 text-sm font-bold mb-2">Purpose</label>
                            <textarea name="purpose" id="purpose" rows="3" 
                                   class="form-control posinput"
                                    required>{{ old('purpose', $loan->purpose) }}</textarea>
                            @error('purpose')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                       <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary ">
                                Update Loan
                            </button>
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary">
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
 