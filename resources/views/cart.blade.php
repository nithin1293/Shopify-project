@extends('layouts.app')

@section('title', 'Your Shopping Cart')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>
    
    <div id="cart-items" class="space-y-4"></div>

    <div id="cart-summary" class="mt-8 pt-6 border-t border-gray-200 hidden">
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

            <<div class="mt-6" id="address-section">
                <h3 class="text-lg font-semibold mb-2">Your Addresses</h3>
                <div id="address-list" class="space-y-4"></div>
                <a href="{{ route('addresses.create') }}" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Add New Address
                </a>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // -------- CART FUNCTIONS (localStorage only) --------
    function getCartKey() {
        const userId = localStorage.getItem('user_id');
        return userId ? 'cart_' + userId : null;
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
            updateCartCount();
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
            updateCartCount();
        }
    }

    function removeFromCart(id) {
        const cartKey = getCartKey();
        if (!cartKey) return;
        
        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        cart = cart.filter(p => p.id !== id);
        localStorage.setItem(cartKey, JSON.stringify(cart));
        renderCart();
        updateCartCount();
    }

    // -------- ADDRESS FUNCTIONS (via JWT API) --------
    async function loadAddresses() {
    const token = localStorage.getItem('token');
    const addressList = document.getElementById('address-list');

    if (!token) {
        addressList.innerHTML = '<p class="text-red-500">Please log in to view addresses.</p>';
        return;
    }

    try {
        const res = await fetch('/api/customer/addresses', {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const addresses = await res.json();

        if (!addresses.length) {
            addressList.innerHTML = '<p class="text-gray-500">No addresses found. Please add one.</p>';
            return;
        }

        addressList.innerHTML = '';
        addresses.forEach(addr => {
            addressList.innerHTML += `
                <div class="p-4 bg-white rounded-lg shadow">
                    <p><strong>${addr.name}</strong> (${addr.address_type})</p>
                    <p>${addr.flat_no}, ${addr.street}, ${addr.landmark || ''}</p>
                    <p>${addr.town}, ${addr.state}, ${addr.country} - ${addr.pincode}</p>
                    <p>Phone: ${addr.mobile_number}</p>
                </div>
            `;
        });
    } catch (err) {
        console.error('Error fetching addresses:', err);
        addressList.innerHTML = '<p class="text-red-500">Failed to load addresses.</p>';
    }
}
document.addEventListener('DOMContentLoaded', renderCart);
</script>
@endsection
