<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">

    <!-- Centered Card -->
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Add Store</h1>

        <form action="{{ route('store.insert') }}" method="POST" class="space-y-4" id="store-form">
            @csrf

            <!-- Store Name -->
            <div>
                <label class="block font-medium text-gray-700">Name</label>
                <input type="text" name="name" class="border rounded px-3 py-2 w-full focus:ring focus:ring-indigo-300" required>
            </div>

            <!-- Store Domain -->
            <div>
                <label class="block font-medium text-gray-700">Domain</label>
                <input type="text" name="domain" class="border rounded px-3 py-2 w-full focus:ring focus:ring-indigo-300" required>
            </div>

            <!-- Store Theme -->
            <div>
                <label class="block font-medium text-gray-700">Theme</label>
                <select name="theme_id" class="border rounded px-3 py-2 w-full focus:ring focus:ring-indigo-300" required>
                    <option value="">-- Select Theme --</option>
                    @if(isset($themes) && !$themes->isEmpty())
                        @foreach($themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Submit -->
            <div class="flex justify-between space-x-4">
    <button type="submit" 
        class="flex-1 bg-[#FFB07C] hover:bg-[#FF9A66] text-white font-semibold px-4 py-2 rounded-lg shadow">
        Save Store
    </button>

    <a href="{{ route('dashboard') }}" 
        class="flex-1 text-center bg-gray-600 hover:bg-gray-500 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-300">
        Go to Dashboard
    </a>
</div>
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
        document.getElementById('store-form').addEventListener('submit', async function (event) {
            event.preventDefault();

      let storeData = {
        name: document.querySelector('input[name="name"]').value,
        domain: document.querySelector('input[name="domain"]').value,
        theme_id: document.querySelector('select[name="theme_id"]').value
      };

      let res = await fetch('/api/stores', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify(storeData)
      });

      let data = await res.json();

      if (res.ok) {
        alert('Store created successfully!');
        document.getElementById('store-form').reset();
        window.location.href = '/dashboard';
      } else {
        alert('Store creation failed: ' + JSON.stringify(data));
      }
    });
    </script>
    
</body>
</html>