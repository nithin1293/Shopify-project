<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shopify')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'bounce-gentle': 'bounce 1s infinite',
                        'pulse-slow': 'pulse 3s infinite',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen" 
    style="
        background-color: {{ $themeSettings['background_color'] ?? '#f9fafb' }};
        color: {{ $themeSettings['font_color'] ?? '#111827' }};
        font-size: {{ $themeSettings['font_size'] ?? '16px' }};
        font-family: {{ $themeSettings['font_name'] ?? 'sans-serif' }};
    ">

    <header class="bg-gradient-to-r from-white/95 to-gray-50/95 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-gray-200/50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <!-- Main Navigation Row -->
            <div class="flex justify-between items-center">
                <!-- Logo Section -->
                <div class="flex-shrink-0">
                    <a class="text-3xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent hover:scale-105 transition-transform duration-300" 
                       href="{{ route('customerDashboard') }}">
                        <i class="fas fa-shopping-bag mr-2 text-indigo-600"></i>Shopify
                    </a>
                </div>

                <!-- Search Bar Section -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <div class="relative w-full group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200"></i>
                        </div>
                        <input 
                            type="text" 
                            id="product-search-input" 
                            placeholder="Search for amazing products..." 
                            class="w-full pl-10 pr-4 py-3 bg-white/80 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-md placeholder-gray-400"
                        >
                        
                    </div>
                </div>

                <!-- Action Icons Section -->
                <div class="flex items-center space-x-1">
                    <!-- Cart Icon -->
                    <div class="relative group">
                        <a href="{{ route('cart') }}" 
                           class="relative flex items-center justify-center w-12 h-12 text-gray-600 hover:text-indigo-600 rounded-xl hover:bg-indigo-50 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span id="cart-count" 
                                  class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs min-w-[20px] h-5 flex items-center justify-center rounded-full font-semibold shadow-lg animate-bounce-gentle">
                                0
                            </span>
                        </a>
                        <!-- Tooltip -->
                        <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                            Shopping Cart
                        </div>
                    </div>

                    <!-- Wishlist Icon -->
                    <div class="relative group">
                        <a href="#" 
                           class="flex items-center justify-center w-12 h-12 text-gray-600 hover:text-red-500 rounded-xl hover:bg-red-50 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-heart text-xl"></i>
                        </a>
                        <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                            Wishlist
                        </div>
                    </div>

                    <!-- Reviews/Favorites Icon -->
                    <div class="relative group">
                        <a href="#" 
                           class="flex items-center justify-center w-12 h-12 text-gray-600 hover:text-yellow-500 rounded-xl hover:bg-yellow-50 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-star text-xl"></i>
                        </a>
                        <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                            Reviews
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="w-px h-8 bg-gray-300 mx-2"></div>

                    <!-- Logout Button -->
                    <div class="ml-2">
                        <button id="logout-button" 
                                class="group relative bg-gradient-to-r from-gray-800 to-gray-900 text-white px-6 py-3 rounded-xl hover:from-gray-900 hover:to-black transition-all duration-300 font-semibold shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:scale-105">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                                <span>Logout</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="md:hidden mt-4">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200"></i>
                    </div>
                    <input 
                        type="text" 
                        id="product-search-input-mobile" 
                        placeholder="Search products..." 
                        class="w-full pl-10 pr-4 py-3 bg-white/80 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-md"
                    >
                </div>
            </div>
        </nav>

        <!-- Subtle bottom border animation -->
        <div class="h-0.5 bg-gradient-to-r from-transparent via-indigo-500 to-transparent transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @yield('content')
    </main>

    <script>
        // Helper function to get the user-specific cart key
        function getCartKey() {
            const userId = localStorage.getItem('user_id');
            if (!userId) {
                console.error("User is not logged in.");
                return null;
            }
            return 'cart_' + userId;
        }

        function addToCart(id, name, price, image) {
            const cartKey = getCartKey();
            if (!cartKey) return; // Exit if user is not logged in

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            let existing = cart.find(item => item.id === id);

            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ id, name, price, image, quantity: 1 }); // 👈 add image here
            }

            localStorage.setItem(cartKey, JSON.stringify(cart));
            updateCartCount();
            alert(name + " added to cart!");
        }

        function updateCartCount() {
            const cartKey = getCartKey();
            const cartCountEl = document.getElementById('cart-count');
            
            if (!cartKey) {
                cartCountEl.innerText = 0;
                return;
            }
            
            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            // Correctly sum the quantity of all items
            let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCountEl.innerText = totalItems;

            // Add visual feedback when cart count changes
            if (totalItems > 0) {
                cartCountEl.classList.add('animate-bounce-gentle');
            } else {
                cartCountEl.classList.remove('animate-bounce-gentle');
            }
        }
        
        function removeFromCart(id) {
            const cartKey = getCartKey();
            if (!cartKey) return;

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            cart = cart.filter(item => item.id !== id);
            localStorage.setItem(cartKey, JSON.stringify(cart));
            
            updateCartCount();
            // If the renderCart function exists (e.g., on cart.blade.php), call it.
            if (typeof renderCart === "function") {
                renderCart(); 
            }
        }

        function getWithExpiry(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) return null;
            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                return null;
            }
            return item.value;
        }

        document.getElementById('logout-button').addEventListener('click', function() {
            const token = getWithExpiry('token');
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
            })
            .finally(() => {
                localStorage.removeItem('token');
                // ✨ ADD THIS LINE to clear the user ID on logout
                localStorage.removeItem('user_id'); 
                window.location.href = '/login';
            });
        });

        // Sync mobile and desktop search inputs
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            
            const desktopSearch = document.getElementById('product-search-input');
            const mobileSearch = document.getElementById('product-search-input-mobile');
            
            if (desktopSearch && mobileSearch) {
                desktopSearch.addEventListener('input', function() {
                    mobileSearch.value = this.value;
                });
                
                mobileSearch.addEventListener('input', function() {
                    desktopSearch.value = this.value;
                });
            }

            // Add keyboard shortcut for search (Cmd+K / Ctrl+K)
            document.addEventListener('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = window.innerWidth >= 768 ? desktopSearch : mobileSearch;
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>