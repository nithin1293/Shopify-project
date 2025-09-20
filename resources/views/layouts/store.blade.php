<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Left: Brand -->
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-800">MyStore Admin</h1>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('store.view') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Add Product
                    </a>

                    <form id="logout-form">
                        <button id="logout-button" type="button" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

    <script>
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
                localStorage.removeItem('token');
                window.location.href = '/login';
            })
            .catch(error => {
                alert('Logout failed. Please try again.');
            });
        });

        function getWithExpiry(key) {
            const itemStr = localStorage.getItem(key);
            if (!itemStr) {
                window.location.href = '/login';
                return null;
            }
            const item = JSON.parse(itemStr);
            const now = new Date();
            if (now.getTime() > item.expiry) {
                localStorage.removeItem(key);
                window.location.href = '/login';
                return null;
            }
            return item.value;
        }
    </script>
</body>
</html>
