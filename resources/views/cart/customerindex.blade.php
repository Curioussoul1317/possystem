@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>

                @if($cart && $cart->items->count() > 0)
                <div class="space-y-4">
                    {{-- Cart Items --}}
                    @foreach($cart->items as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center space-x-4">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                class="w-16 h-16 object-cover rounded">
                            @endif
                            <div>
                                <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                <p class="text-gray-600">${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            {{-- Quantity Controls --}}
                            <div class="flex items-center space-x-2">
                                <button onclick="updateQuantity({{ $item->id }}, 'decrease')"
                                    class="px-2 py-1 bg-gray-200 rounded">
                                    -
                                </button>
                                <span class="px-4">{{ $item->quantity }}</span>
                                <button onclick="updateQuantity({{ $item->id }}, 'increase')"
                                    class="px-2 py-1 bg-gray-200 rounded">
                                    +
                                </button>
                            </div>

                            {{-- Subtotal --}}
                            <div class="w-24 text-right">
                                ${{ number_format($item->subtotal, 2) }}
                            </div>

                            {{-- Remove Button --}}
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    {{-- Cart Summary --}}
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between text-xl font-semibold">
                            <span>Total:</span>
                            <span>${{ number_format($cart->total, 2) }}</span>
                        </div>

                        <div class="flex justify-between space-x-4">
                            <a href="{{ route('products.index') }}"
                                class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                Continue Shopping
                            </a>
                            <form action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Your cart is empty</p>
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Start Shopping
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
function updateQuantity(itemId, action) {
    const currentQuantity = parseInt(document.querySelector(`#quantity-${itemId}`).textContent);
    let newQuantity = action === 'increase' ? currentQuantity + 1 : currentQuantity - 1;

    if (newQuantity < 1) newQuantity = 1;

    fetch(`/cart/items/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

@endsection