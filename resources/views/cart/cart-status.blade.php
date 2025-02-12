@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-4 mb-4">
    <h3 class="text-lg font-semibold mb-2">Order Status</h3>
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <span class="w-3 h-3 rounded-full 
                @if($cart->status === 'neworder') bg-blue-500
                @elseif($cart->status === 'processing') bg-yellow-500
                @elseif($cart->status === 'paid') bg-green-500
                @elseif($cart->status === 'delivered') bg-purple-500
                @else bg-red-500
                @endif">
            </span>
            <span class="capitalize">{{ $cart->status }}</span>
        </div>

        @if($cart->status === 'neworder')
        <form action="{{ route('cart.updateStatus', $cart) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="processing">
            <button type="submit" class="text-blue-600 hover:text-blue-800">
                Process Order
            </button>
        </form>
        @endif
    </div>
</div>
@endsection