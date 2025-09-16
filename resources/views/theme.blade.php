
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Theme</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">🎨 Create a New Theme</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg p-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('theme.store') }}" method="POST" class="space-y-5" id="theme-form">
            @csrf

            <!-- Theme Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Theme Name</label>
                <input type="text" name="name" class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none bg-gray-50">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Font Size -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Font Size</label>
                <select name="font_size" class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-purple-400 bg-gray-50">
                    <option value="14px">14px</option>
                    <option value="16px" selected>16px</option>
                    <option value="18px">18px</option>
                    <option value="20px">20px</option>
                    <option value="24px">24px</option>
                </select>
            </div>

            <!-- Font Color -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Font Color</label>
                <input type="color" name="font_color" class="mt-1 w-full h-12 px-2 py-1 border rounded-xl cursor-pointer">
            </div>

            <!-- Background Color -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Background Color</label>
                <input type="color" name="background_color" class="mt-1 w-full h-12 px-2 py-1 border rounded-xl cursor-pointer">
            </div>

            <!-- Font Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Font Name</label>
                <select name="font_name" class="mt-1 w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-yellow-400 bg-gray-50">
                    <option value="Arial">Arial</option>
                    <option value="Verdana">Verdana</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="Courier New">Courier New</option>
                    <option value="Georgia">Georgia</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center space-x-4">
                <button type="submit" 
                    class="px-6 py-2 bg-[#FFB07C] hover:bg-[#FF9A66] text-white font-medium rounded-xl shadow transition duration-300">
                    Save Theme
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
