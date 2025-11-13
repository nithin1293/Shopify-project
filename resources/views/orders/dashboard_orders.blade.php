<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen p-4 md:p-8">

    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 mb-2">Customer Orders</h1>
            <p class="text-gray-600 text-lg">Manage and track your store orders</p>
        </div>

        @forelse($ordersData as $order)
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-6 border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-white mb-3 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $order['customer_name'] }}
                            </h2>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-white/90 text-sm font-medium">Status:</span>
                                <span id="status-{{ $order['id'] }}" 
                                      class="px-4 py-1.5 bg-yellow-400 text-yellow-900 rounded-full text-sm font-bold shadow-lg inline-flex items-center gap-2">
                                    <span class="w-2 h-2 bg-yellow-700 rounded-full animate-pulse"></span>
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-white/20 backdrop-blur-lg rounded-xl px-6 py-4 border border-white/30 shadow-lg">
                            <p class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-1">Order Total</p>
                            <p class="text-3xl font-bold text-white flex items-center gap-1">
                                <span class="text-2xl">₹</span>{{ $order['total'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-800">Order Items</h3>
                        <span class="ml-auto text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ count($order['product_details']) }} items</span>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-slate-100 border-b-2 border-indigo-200">
                                    <th class="p-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Product</th>
                                    <th class="p-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description</th>
                                    <th class="p-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Image</th>
                                    <th class="p-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Price</th>
                                    <th class="p-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Qty</th>
                                    <th class="p-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order['product_details'] as $product)
                                    <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                                        <td class="p-4">
                                            <div class="font-semibold text-gray-900 text-base">{{ $product['name'] }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="text-sm text-gray-600 max-w-xs line-clamp-2">{{ $product['description'] }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex justify-center">
                                                <div class="relative group">
                                                    <div class="w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 shadow-md group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" width="60" class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-colors duration-300"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 text-right">
                                            <span class="text-gray-700 font-semibold">₹{{ $product['price'] }}</span>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex justify-center">
                                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-700 rounded-lg font-bold text-sm shadow-sm">
                                                    {{ $product['quantity'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-right">
                                            <span class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">₹{{ $product['total_price'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gradient-to-br from-gray-50 to-slate-50 px-6 py-5 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="updateOrderStatus({{ $order['id'] }}, 'ship')" 
                                class="flex-1 group relative bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3.5 rounded-xl shadow-lg hover:shadow-xl font-semibold transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                Mark as Shipped
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>

                        <button onclick="updateOrderStatus({{ $order['id'] }}, 'deliver')" 
                                class="flex-1 group relative bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3.5 rounded-xl shadow-lg hover:shadow-xl font-semibold transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mark as Delivered
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white shadow-xl rounded-2xl p-16 text-center border border-gray-100">
                <div class="max-w-md mx-auto">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Orders Yet</h3>
                    <p class="text-gray-500 text-lg">Orders will appear here once customers place them.</p>
                </div>
            </div>
        @endforelse
    </div>

    <script>
    function updateOrderStatus(orderId, action) {
        const url = action === 'ship' 
            ? `/orders/${orderId}/ship` 
            : `/orders/${orderId}/deliver`;

        // ✅ Get the clicked button and make it slightly transparent & disabled
        const button = event.target;
        button.classList.add('opacity-50', 'cursor-not-allowed');
        button.disabled = true;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusEl = document.getElementById(`status-${orderId}`);
                statusEl.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);

                // ✅ Update status color
                if (data.status === 'shipped') {
                    statusEl.className = "px-4 py-1.5 bg-blue-400 text-blue-900 rounded-full text-sm font-bold shadow-lg inline-flex items-center gap-2";
                    statusEl.innerHTML = '<span class="w-2 h-2 bg-blue-700 rounded-full animate-pulse"></span>' + data.status.charAt(0).toUpperCase() + data.status.slice(1);
                } else if (data.status === 'delivered') {
                    statusEl.className = "px-4 py-1.5 bg-green-400 text-green-900 rounded-full text-sm font-bold shadow-lg inline-flex items-center gap-2";
                    statusEl.innerHTML = '<span class="w-2 h-2 bg-green-700 rounded-full animate-pulse"></span>' + data.status.charAt(0).toUpperCase() + data.status.slice(1);
                }
            }
        })
        .catch(err => {
            console.error('Error updating order:', err);
            alert('Failed to update order status.');
            // ✅ Re-enable button on failure
            button.classList.remove('opacity-50', 'cursor-not-allowed');
            button.disabled = false;
        });
    }
</script>

</body>
</html>