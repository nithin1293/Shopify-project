@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Stores</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    @foreach($stores as $store)
        <a href="{{ route('dashboard.store.view', ['id' => $store->id]) }}"
           class="group block rounded-xl overflow-hidden shadow-lg 
                  transform hover:scale-105 active:scale-[1.02] active:brightness-90 
                  transition-all duration-300 ease-in-out">
            
            <div class="bg-white h-full">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h2>
                    <p class="text-gray-600 mt-2 mb-4">{{ $store->description }}</p>
                    
                    <span class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg 
                                 group-hover:bg-blue-600 transition-colors">
                        View Products
                    </span>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection