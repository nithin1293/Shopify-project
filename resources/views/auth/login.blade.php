<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-2">Welcome Back</h1>
            <p class="text-gray-600 text-sm">Sign in to your account</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <form method="POST" action="" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <div class="text-sm">
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition-colors duration-200">Forgot password?</a>
                </div>
            </div>

            <button type="submit" id="login-button"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Sign In
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Don't have an account?
                <a href="{{ route('register.form') }}" class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition-colors duration-200">Create account</a>
            </p>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-200">
            <p class="text-xs text-gray-500 text-center">
                Protected by industry-standard security
            </p>
        </div>
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