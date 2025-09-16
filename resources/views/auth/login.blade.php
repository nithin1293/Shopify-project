<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-400 via-blue-500 to-purple-600">

    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Welcome Back</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <input type="email" name="email" id="email" placeholder="Email" required
                    class="w-full p-3 border-2 border-transparent focus:border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Password" required
                    class="w-full p-3 border-2 border-transparent focus:border-green-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300">
            </div>

            <button type="submit" id="login-button"
                class="w-full bg-gradient-to-r from-blue-500 via-green-500 to-yellow-500 text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                Login
            </button>
        </form>

        <p class="text-center text-gray-500 mt-4">
            Don’t have an account?
            <a href="{{ route('register.form') }}" class="text-blue-600 font-semibold hover:underline">Register</a>
        </p>
        <!-- <p class="text-center text-gray-500 mt-4">
            Don’t have an account?
            <a href="{{ route('register.form') }}" class="text-blue-600 font-semibold hover:underline">Register</a>
        </p> -->
    </div>

</body>

<!-- Add this in the <head> or before your script tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('login-button').addEventListener('click', function(event) {
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();

        // Remove old error messages
        $('.error-msg').remove();

        let hasError = false;

        if (email == '') {
            $('#email').after('<p class="error-msg text-red-500 text-sm mt-1">Email is required</p>');
            hasError = true;
        }
        if (password == '') {
            $('#password').after('<p class="error-msg text-red-500 text-sm mt-1">Password is required</p>');
            hasError = true;
        }

        if (hasError) return;

        fetch('/api/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        email: email,
        password: password
    })
})
.then(async response => {
    if (!response.ok) {
        const errorData = await response.json(); 
        throw new Error(errorData.message || 'Login failed');
    }
    return response.json(); 
})
.then(data => {
    console.log('Login successful:', data);
    setWithExpiry('token', data.tokendata.token, 3600000);
localStorage.setItem('user_id', data.user.id);
    // Redirect based on user_type
    if (data.user.user_type === 'store_owner') {
        window.location.href = '/dashboard';
    } else if (data.user.user_type === 'customer') {
        window.location.href = '/customerDashboard';
    } else {
        alert('Invalid user type');
    }
})
.catch(error => {
    console.error('Error:', error);
    
    $('.error-msg').remove();
    $('#login-button').before('<p class="error-msg text-red-500 text-sm mb-3">Invalid email or password</p>');
    
});

    });

    function setWithExpiry(key, value, ttl) {
        const now = new Date();
        const item = {
            value: value,
            expiry: now.getTime() + ttl,
        };
        localStorage.setItem(key, JSON.stringify(item));
    }
</script>
</html>