@extends('layouts.store')

@section('title', $store->name)

@section('content')
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
                    
                    
                </div>
            </div>
        @endforeach
    </div>
@endsection
