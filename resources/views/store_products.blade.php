@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <h1 class="text-3xl font-bold mb-6">{{ $store->name }}</h1>
    <p class="text-gray-600 mb-8">{{ $store->description }}</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($store->products as $product)
            {{-- This is the main card container --}}
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden">
                
                {{-- Image Container with a fixed aspect ratio --}}
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
                    
                    {{-- Buttons Container (pushed to the bottom) --}}
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