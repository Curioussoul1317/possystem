<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;


class LoanController extends Controller
{
     public function index()
    {
        $loans = auth()->user()->loans()
            ->orderBy('loan_date', 'desc')
            ->paginate(15);
            
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        return view('loans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0', 
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'lender_name' => 'required|string|max:255',
            'purpose' => 'required|string'
        ]);

        $validated['remaining_amount'] = $validated['amount'];
        $validated['status'] = 'pending';

        auth()->user()->loans()->create($validated);

        return redirect()->route('loans.index')
            ->with('success', 'Loan request created successfully.');
    }

    public function show(Loan $loan)
    {
        
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
     
        return view('loans.edit', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0', 
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'lender_name' => 'required|string|max:255',
            'purpose' => 'required|string'
        ]);

        $loan->update($validated);

        return redirect()->route('loans.index')
            ->with('success', 'Loan updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        
        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'Loan deleted successfully.');
    }

    public function byStatus($status)
    {
        $loans = auth()->user()->loans()
            ->where('status', $status)
            ->orderBy('loan_date', 'desc')
            ->paginate(15);

        return view('loans.index', compact('loans'));
    }

    // public function approve(Loan $loan)
    // {
        
    //     $loan->update(['status' => 'approved']);

    //     return redirect()->route('loans.show', $loan)
    //         ->with('success', 'Loan approved successfully.');
    // }

    // public function reject(Loan $loan)
    // {
         
    //     $loan->update(['status' => 'rejected']);

    //     return redirect()->route('loans.show', $loan)
    //         ->with('success', 'Loan rejected successfully.');
    // }
}
