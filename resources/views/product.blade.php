<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">

    <div class="max-w-lg w-full bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">🛒 Add Product</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}" class="space-y-5" enctype="multipart/form-data">
            @csrf

            <!-- Store -->
            <div>
                <label for="store_id" class="block text-gray-700 font-semibold mb-2">Store</label>
                <select name="store_id" id="store_id" required class="w-full border-gray-300 rounded-lg p-2 bg-gray-50">
                    <option value="">-- Select Store --</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Product Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full border-gray-300 rounded-lg p-2 bg-gray-50">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full border-gray-300 rounded-lg p-2 bg-gray-50"></textarea>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-gray-700 font-semibold mb-2">Price</label>
                <input type="number" step="0.01" name="price" id="price" required
                       class="w-full border-gray-300 rounded-lg p-2 bg-gray-50">
            </div>
            <div>
                <label for="image" class="block text-gray-700 font-semibold mb-2">Product Image</label>
                <input type="file" name="image" id="image"
                       class="w-full border-gray-300 rounded-lg p-2 bg-gray-50">
            </div>

            <!-- Submit -->
            <div class="flex justify-center space-x-4">
                <button type="submit"
                        class="px-6 py-2 bg-[#FFB07C] hover:bg-[#FF9966] text-white font-bold rounded-xl transition duration-300">
                    Save Product
                </button>
                <a href="{{ route('dashboard') }}" 
        class="px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-xl shadow transition duration-300">
        Go to Dashboard
    </a>
            </div>
        </form>
    </div>

    <script>
        // Token check
        var token = getWithExpiry('token');
        if (!token) {
            window.location.href = '/login';
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
    </script>
</body>
</html>