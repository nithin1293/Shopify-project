@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mt-8">
    @foreach($stores as $index => $store)
        <a href="{{ route('dashboard.store.view', ['id' => $store->id]) }}"
           class="group block bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl 
                  transform hover:scale-105 transition-all duration-300 ease-out border border-gray-200">
            
            <!-- Store Image/Banner -->
            <div class="relative h-48 bg-gradient-to-br from-{{ $index % 2 == 0 ? 'green' : 'blue' }}-400 to-{{ $index % 2 == 0 ? 'blue' : 'green' }}-600 overflow-hidden">
                <!-- Store Logo/Initial -->
                <div class="absolute top-4 left-4 w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-xl font-bold text-gray-800">{{ substr($store->name, 0, 1) }}</span>
                </div>
                
                
                <!-- Geometric Pattern Overlay -->
                
            </div>
            
            <!-- Store Content -->
            <div class="p-6">
                <!-- Store Name & Rating -->
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $store->name }}
                    </h2>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400 text-sm mr-1">
                            @for($i = 0; $i < 4; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 font-medium">4</span>
                    </div>
                </div>
                
                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">
                             Fashion 
                        </span>
                    
                </div>
                
                <!-- Bottom Section -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-green-600 text-sm font-medium">
                        <i class="fas fa-shield-check mr-1"></i>
                        Verified Store
                    </div>
                    
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg
                                   transform group-hover:scale-105 transition-all duration-200 flex items-center">
                        Browse
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection