@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Checkout</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Order Summary --}}
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                        @foreach($cart->items as $item)
                        <div class="flex justify-between mb-2">
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span>${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                        @endforeach
                        <div class="border-t mt-4 pt-4">
                            <div class="flex justify-between font-semibold">
                                <span>Total</span>
                                <span>${{ number_format($cart->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Form --}}
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Payment Details</h3>
                        <form action="{{ route('cart.processPayment') }}" method="POST" id="payment-form">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Card Number</label>
                                    <input type="text" id="card-number"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                        <input type="text" id="card-expiry"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">CVC</label>
                                        <input type="text" id="card-cvc"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Pay Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection