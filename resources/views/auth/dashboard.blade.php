<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex bg-gray-50 text-gray-800">

    <aside class="w-64 bg-gray-900 text-gray-300 flex flex-col">
        <div class="h-20 flex items-center justify-center border-b border-gray-800">
            <h2 class="text-2xl font-bold text-white">MyStore</h2>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('store.view') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-800 text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                <span>Store</span>
            </a>
            <a href="{{ route('theme.view') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm10 2a1 1 0 10-2 0v2a1 1 0 102 0V4zM4 6h12V4H4v2zm0 4h12V8H4v2zm0 4h12v-2H4v2zm0 4h12v-2H4v2z" clip-rule="evenodd" />
                </svg>
                <span>Theme</span>
            </a>
            <a href="{{ route('products.view') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h.01a1 1 0 100-2H10zm3 0a1 1 0 000 2h.01a1 1 0 100-2H13z" clip-rule="evenodd" />
                </svg>
                <span>Products</span>
            </a>
            <form id="logout-form" class="pt-2 border-t border-gray-800">
                <button id="logout-button" type="button" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">All Stores</h1>
                <p class="mt-2 text-gray-500">Click on a store to view its products with the applied theme.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($stores as $store)
                    <a href="{{ route('customize.view', $store->id) }}" 
                       class="group block bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                        <div class="border-t-4 border-blue-500 w-1/4 mb-4 group-hover:w-full transition-all duration-300"></div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $store->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $store->domain }}</p>
                    </a>
                @endforeach
                 
            </div>
        </div>
    </main>

    <script>
        // Your existing JavaScript remains the same
        var token = getWithExpiry('token');

        document.getElementById('logout-button').addEventListener('click', function () {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Logout successful:', data);
                localStorage.removeItem('token');
                window.location.href = '/login';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Logout failed. Please try again.');
            });
        });

        function getWithExpiry(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) {
                window.location.href = '/login';
                return null; // Return null to prevent further execution
            }
            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                window.location.href = '/login';
                return null; // Return null
            }
            return item.value;
        }
    </script>
</body>
</html>