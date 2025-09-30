@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <h1 class="text-3xl font-bold mb-6">{{ $store->name }}</h1>
    <p class="text-gray-600 mb-8">{{ $store->description }}</p>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✨ ADD THIS SEARCH INPUT ✨ --}}
    

    {{-- PRODUCT GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($store->products as $product)
            {{-- ✨ MODIFIED THIS LINE: Added 'product-card' class and 'data-name' attribute ✨ --}}
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden product-card" data-name="{{ strtolower($product->name) }}">
                
                {{-- Image Container --}}
                <div class="w-full aspect-[4/5] bg-gray-100">
                    @if ($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                
                {{-- Product Info Container --}}
                <div class="p-4 flex-grow flex flex-col">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                    <p class="text-md text-gray-600 mt-1">₹{{ $product->price }}</p>
                    
                    {{-- Buttons Container --}}
                    <div class="mt-auto pt-4 flex items-center space-x-2">
                        <button 
                            onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image }}')" 
                            class="flex-1 bg-[#3A3A3A] text-white px-4 py-2 rounded-lg transition text-sm font-semibold flex items-center justify-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

{{-- ✨ ADD THIS JAVASCRIPT SECTION AT THE END ✨ --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the search input element
        const searchInput = document.getElementById('product-search-input');
        
        // Get all the product card elements
        const products = document.querySelectorAll('.product-card');

        // Add an event listener that fires whenever the user types
        searchInput.addEventListener('keyup', function(event) {
            const searchTerm = event.target.value.toLowerCase();

            // Loop through each product card
            products.forEach(product => {
                // Get the product name from the data-name attribute
                const productName = product.dataset.name;

                // Check if the product name includes the search term
                if (productName.includes(searchTerm)) {
                    // If it matches, make sure the card is visible
                    product.style.display = 'flex';
                } else {
                    // If it doesn't match, hide the card
                    product.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection