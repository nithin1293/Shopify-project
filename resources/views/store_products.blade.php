@extends('layouts.app')

@section('title', $store->name)

@section('content')
    <h1 class="text-3xl font-bold mb-6">{{ $store->name }}</h1>
    <p class="text-gray-600 mb-8">{{ $store->description }}</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($store->products as $product)
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-600">₹{{ $product->price }}</p>
                <button 
                    onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                    class="mt-3 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                    Add to Cart
                </button>
            </div>
        @endforeach
    </div>
@endsection