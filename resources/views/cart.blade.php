@extends('layouts.app')

@section('title', 'Your Shopping Cart')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>
    
    <div id="cart-items" class="space-y-4">
        </div>

    <div id="cart-summary" class="mt-8 pt-6 border-t border-gray-200">
        <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            <div class="flex justify-between text-lg">
                <span>Total Items:</span>
                <span id="total-items" class="font-bold">0</span>
            </div>
            <div class="flex justify-between text-lg mt-2">
                <span>Total Price:</span>
                <span class="font-bold">₹<span id="total-price">0</span></span>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Helper function to get the user-specific cart key
    function getCartKey() {
        const userId = localStorage.getItem('user_id');
        if (!userId) {
            console.error("User ID not found for cart.");
            return null;
        }
        return 'cart_' + userId;
    }

    function renderCart() {
        const cartKey = getCartKey();
        let container = document.getElementById('cart-items');
        let summary = document.getElementById('cart-summary');
        let totalItemsEl = document.getElementById('total-items');
        let totalPriceEl = document.getElementById('total-price');
        
        container.innerHTML = '';

        if (!cartKey) {
            container.innerHTML = '<p class="text-gray-600">Please log in to view your cart.</p>';
            summary.classList.add('hidden');
            return;
        }

        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        let totalItems = 0;
        let totalPrice = 0;

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-gray-600">Your cart is empty.</p>';
            summary.classList.add('hidden');
            return;
        }

        cart.forEach(item => {
            totalItems += item.quantity;
            totalPrice += item.price * item.quantity;

            container.innerHTML += `
                <div class="p-4 bg-white rounded-lg shadow flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold">${item.name}</h2>
                        <p class="text-gray-600">₹${item.price} x ${item.quantity} = <b>₹${(item.price * item.quantity).toLocaleString('en-IN')}</b></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="decrementQuantity(${item.id})" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                        <span class="font-semibold">${item.quantity}</span>
                        <button onclick="incrementQuantity(${item.id})" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                        <button onclick="removeFromCart(${item.id})" class="ml-4 text-red-500 hover:text-red-700">Remove</button>
                    </div>
                </div>
            `;
        });
        
        totalItemsEl.textContent = totalItems;
        totalPriceEl.textContent = totalPrice.toLocaleString('en-IN');
        summary.classList.remove('hidden');
    }

    function incrementQuantity(id) {
        const cartKey = getCartKey();
        if (!cartKey) return;
        
        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        let item = cart.find(p => p.id === id);
        if (item) {
            item.quantity++;
            localStorage.setItem(cartKey, JSON.stringify(cart));
            renderCart();
            updateCartCount(); // Sync header count
        }
    }

    function decrementQuantity(id) {
        const cartKey = getCartKey();
        if (!cartKey) return;

        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        let item = cart.find(p => p.id === id);
        if (item) {
            item.quantity--;
            if (item.quantity <= 0) {
                cart = cart.filter(p => p.id !== id);
            }
            localStorage.setItem(cartKey, JSON.stringify(cart));
            renderCart();
            updateCartCount(); // Sync header count
        }
    }

    // Overriding global function to ensure header is also updated from this page
    function removeFromCart(id) {
        const cartKey = getCartKey();
        if (!cartKey) return;
        
        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        cart = cart.filter(p => p.id !== id);
        localStorage.setItem(cartKey, JSON.stringify(cart));
        renderCart();
        updateCartCount(); // Sync header count
    }

    document.addEventListener('DOMContentLoaded', renderCart);
</script>
@endsection