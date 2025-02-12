<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanPayment;

class LoanPaymentController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string'
        ]);

        $loan = Loan::findOrFail($validated['loan_id']);
     

        if ($validated['amount'] > $loan->remaining_amount) {
            return back()->withErrors(['amount' => 'Payment amount cannot exceed remaining loan amount.']);
        }

        $payment = LoanPayment::create($validated);
        
        $loan->remaining_amount -= $validated['amount'];
        if ($loan->remaining_amount <= 0) {
            $loan->status = 'paid';
        }
        $loan->save();

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Payment recorded successfully.');
    }

    public function loanPayments(Loan $loan)
    {
                
        $payments = $loan->payments()
            ->orderBy('payment_date', 'desc')
            ->paginate(15);

        return view('loan-payments.index', compact('loan', 'payments'));
    }

    public function create(Loan $loan)
{ 
    return view('loan-payments.create', compact('loan'));
}
}
