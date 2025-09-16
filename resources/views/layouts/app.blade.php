<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shopify')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="min-h-screen" 
    style="
        background-color: {{ $themeSettings['background_color'] ?? '#f9fafb' }};
        color: {{ $themeSettings['font_color'] ?? '#111827' }};
        font-size: {{ $themeSettings['font_size'] ?? '16px' }};
        font-family: {{ $themeSettings['font_name'] ?? 'sans-serif' }};
    ">

    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-200">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500" href="{{ route('customerDashboard') }}">
                Shopify
            </a>
            <div class="flex items-center space-x-2 sm:space-x-4">
                <a href="{{ route('cart') }}" class="relative text-gray-500 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">0</span>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <i class="fas fa-heart fa-lg"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <i class="fas fa-star fa-lg"></i>
                </a>
                <div class="pl-2">
                    <button id="logout-button" class="bg-gray-800 text-white px-5 py-2 rounded-lg hover:bg-gray-900 transition-colors duration-300 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Logout</button>
                </div>
            </div>
        </nav>
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

        function addToCart(id, name, price) {
            const cartKey = getCartKey();
            if (!cartKey) return; // Exit if user is not logged in

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];
            let existing = cart.find(item => item.id === id);

            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
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

        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>

    @yield('scripts')
</body>
</html>