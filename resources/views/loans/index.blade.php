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
            LOANS
    </div>
  </div>
    </div>
    <div class="col-2" >
        <a   class="text-decoration-none"  style=" float: right;" 
        data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-square-plus  breadcrumbsicon"></i></a>
    </div>
  </div>
  
</div>


 
<!-- ///////////////// -->
  <div class="row justify-content-center">

    <div class="col-10">

    <div class="collapse" id="collapseExample">
  <div class="card card-body">
     <div class="card-header listtablehead">
  NEW LOAN
  </div>
      <form action="{{ route('loans.store') }}" method="POST">
                        @csrf
 <div class="row">
   


                      <div class="form-group col-md-2">
                            <label for="amount"  class="posinputlable">Loan Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" 
                                  class="form-control posinput" value="{{ old('amount') }}" required>
                            @error('amount')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                       

                      <div class="form-group col-md-2">
                            <label for="loan_date"  class="posinputlable">Loan Date</label>
                            <input type="date" name="loan_date" id="loan_date" 
                                 class="form-control posinput"value="{{ old('loan_date', date('Y-m-d')) }}" required>
                            @error('loan_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-md-2">
                            <label for="due_date"  class="posinputlable">Due Date</label>
                            <input type="date" name="due_date" id="due_date" 
                                 class="form-control posinput" value="{{ old('due_date') }}" required>
                            @error('due_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                      <div class="form-group col-md-6">
                            <label for="lender_name"  class="posinputlable">Lender Name</label>
                            <input type="text" name="lender_name" id="lender_name" 
                                 class="form-control posinput" value="{{ old('lender_name') }}" required>
                            @error('lender_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                       <div class="form-group col-md-12">
                            <label for="purpose"  class="posinputlable">Purpose</label>
                            <textarea name="purpose" id="purpose" rows="3" 
                                  class="form-control posinput" required>{{ old('purpose') }}</textarea>
                            @error('purpose')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                         <div class="form-group col-md-12">
       <button type="submit" class="btn btn-primary formbutton"  >SAVE</button>
    </div> 
 </div>
                    </form>


  </div>
</div>


<div class="card text-center">
  <div class="card-header listtablehead">
   LOANS
  </div>
  <div class="card-body">

  <select id="statusFilter" class="form-control posinput" onchange="window.location.href=this.value">
                            <option value="{{ route('loans.index') }}">All Status</option>
                            @foreach(['pending', 'approved', 'rejected', 'paid'] as $status)
                                <option value="{{ route('loans.status', $status) }}" 
                                    {{ request()->segment(3) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>


        <table class="table table-striped">
       <thead>
        <tr>
             <th >Lender Name</th>
            <th >Date</th>
            <th >Amount</th>
            <th >Remaining</th>
            <th >Status</th>
            <th >Due Date</th>
            <th >Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($loans as $loan)
            <tr>
                                     <td >{{ $loan->lender_name }}</td>
                                     <td >{{ $loan->loan_date->format('M d, Y') }}</td>
                                    <td >Mvr {{ number_format($loan->amount, 2) }}</td>
                                    <td >Mvr {{ number_format($loan->remaining_amount, 2) }}</td>
                                    <td >
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $loan->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($loan->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                               ($loan->status === 'paid' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td  >
                                        
                                        @if($loan->is_overdue)
                                            <span style="color: red; font-weight: 600;">{{ $loan->due_date->format('M d, Y') }}</span>
                                            @else
                                            {{ $loan->due_date->format('M d, Y') }}
                                        @endif
                                    </td>
                                    <td  >
                                        <a href="{{ route('loans.show', $loan) }}"  >View</a> 
                                        @if($loan->status === 'pending')
                                            <a href="{{ route('loans.edit', $loan) }}"  >Edit</a>
                                        @endif
                                        <a href="{{ route('loans.payments', $loan) }}"  >Payments</a>
                                        <a href="{{ route('loan-payments.create', $loan) }}"  >  Make Payment
</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">No loans found</td>
                                </tr>
                            @endforelse
    </tbody>
</table>
  </div>
  <div class="card-footer text-muted">
     {{ $loans->links() }}
  </div>
</div>
    </div>  
  </div>
</main>

@endsection






































