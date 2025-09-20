@extends('layouts.app')

@section('title', 'Your Shopping Cart')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
            <p class="mt-2 text-gray-600">Review your items and proceed to checkout</p>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Delivery Address
                        </h2>
                        <a href="{{ route('addresses.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Change
                        </a>
                    </div>
                    <div id="shipping-address-container" class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <div class="flex items-center space-x-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                            <p class="text-gray-600">Loading selected address...</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5l2.5 5M7 13h10"></path>
                            </svg>
                            Cart Items
                        </h2>
                    </div>
                    <div id="cart-items" class="divide-y divide-gray-200">
                        </div>
                </div>
            </div>

            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div class="sticky top-8">
                    <div id="cart-summary" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white">Order Summary</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-gray-600">Total Items</span>
                                <span id="total-items" class="font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded-full text-sm">0</span>
                            </div>
                            <div class="flex justify-between items-center text-lg font-bold text-gray-900">
                                <span>Total Amount</span>
                                <span class="text-green-600">₹<span id="total-price">0</span></span>
                            </div>
                            <button class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                Proceed to Checkout
                            </button>
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Secure checkout guaranteed
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ... (all other functions like getCartKey, incrementQuantity, etc. remain the same) ...
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
            container.innerHTML = `
                <div class="p-8 text-center">
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium">Please log in to view your cart.</p>
                </div>
            `;
            summary.classList.add('hidden');
            return;
        }

        let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
        let totalItems = 0;
        let totalPrice = 0;

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5l2.5 5M7 13h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-600 mb-4">Start adding some items to your cart!</p>
                    <a href="/customerDashboard" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            `;
            summary.classList.add('hidden');
            return;
        }
        
        cart.forEach(item => {
            totalItems += item.quantity;
            totalPrice += item.price * item.quantity;
            
            // --- THIS IS THE MODIFIED SECTION ---
            let imageHtml = `
                <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            `;
            
            if (item.image) {
                imageHtml = `<img src="/storage/${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">`;
            }
            // --- END OF MODIFIED SECTION ---

            container.innerHTML += `
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-start space-x-4">
                        ${imageHtml} {{-- The dynamic image is inserted here --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">${item.name}</h3>
                                    <p class="text-sm text-gray-600 mb-3">Price: ₹${item.price.toLocaleString('en-IN')}</p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                            <button onclick="decrementQuantity(${item.id})" class="w-8 h-8 rounded-md bg-white shadow-sm hover:bg-gray-50 flex items-center justify-center transition-colors duration-200">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="mx-3 font-semibold text-gray-900 min-w-[2rem] text-center">${item.quantity}</span>
                                            <button onclick="incrementQuantity(${item.id})" class="w-8 h-8 rounded-md bg-white shadow-sm hover:bg-gray-50 flex items-center justify-center transition-colors duration-200">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-lg font-bold text-gray-900">₹${(item.price * item.quantity).toLocaleString('en-IN')}</p>
                                    <p class="text-sm text-gray-500">Total</p>
                                </div>
                            </div>
                        </div>
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
    
    function loadSelectedAddress() {
        const addressContainer = document.getElementById('shipping-address-container');
        const selectedAddressId = localStorage.getItem('selected_address_id');
        const token = getWithExpiry('token');

        if (!selectedAddressId) {
            addressContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="mx-auto w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium">No address selected</p>
                    <p class="text-sm text-gray-500 mt-1">Please select a delivery address</p>
                </div>
            `;
            return;
        }

        if (!token) {
            addressContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="mx-auto w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium">Please log in to see your selected address</p>
                </div>
            `;
            return;
        }

        fetch(`/api/addresses/${selectedAddressId}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            if (!response.ok) {
                const errorBody = await response.json().catch(() => ({ message: 'Could not parse error response.' }));
                console.error('API Error Response:', { status: response.status, body: errorBody });
                throw new Error(errorBody.message || 'API request failed');
            }
            return response.json();
        })
        .then(address => {
            addressContainer.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 mb-1">${address.name}</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            ${address.flat_no}, ${address.street}<br>
                            ${address.town}, ${address.state} - ${address.pincode}<br>
                            <span class="font-medium">Mobile:</span> ${address.mobile_number}
                        </p>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error("Error loading address:", error.message);
            addressContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="mx-auto w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-red-600 font-semibold text-sm">Could not load selected address</p>
                    <p class="text-gray-500 text-sm mt-1">Please select one again</p>
                </div>
            `;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCart();
        loadSelectedAddress();
    });
</script>
@endsection