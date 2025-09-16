<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-500 via-pink-500 to-red-500">

  <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Create Account</h1>

    <form id="register-form" class="space-y-4">
      <div>
        <input type="text" id="name" placeholder="Full Name" 
               class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-300">
      </div>

      <div>
        <input type="email" id="email" placeholder="Email" 
               class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300">
      </div>

      <div>
        <input type="password" id="password" placeholder="Password" 
               class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300">
      </div>

      <div>
        <input type="password" id="password_confirmation" placeholder="Confirm Password" 
               class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300">
      </div>
       <div>
        <select id="user_type"
                class="w-full p-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
          <option value="" disabled selected>Select User Type</option>
          <option value="customer">Customer</option>
          <option value="store_owner">Store Owner</option>
        </select>
      </div>

      <button type="submit" id="register-button"
              class="w-full bg-gradient-to-r from-pink-500 via-purple-500 to-red-500 text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
        Register
      </button>
    </form>

    <p class="text-center text-gray-500 mt-4">
      Already have an account?
      <a href="{{ route('login.form') }}" class="text-pink-600 font-semibold hover:underline">Login</a>
    </p>
  </div>

  <script>
    localStorage.removeItem('token');
    document.getElementById('register-button').addEventListener('click', function(event) {
      event.preventDefault();

      const name = $('#name').val();
      const email = $('#email').val();
      const password = $('#password').val();
      const password_confirmation = $('#password_confirmation').val();
      const user_type = $('#user_type').val();

      // Remove old error messages and reset borders
      $('.error-msg').remove();
      $('input').removeClass('border-red-500');

      let hasError = false;

      if (!name) {
        $('#name').after('<p class="error-msg text-red-500 text-sm mt-1">Name is required</p>');
        $('#name').addClass('border-red-500');
        hasError = true;
      }

      if (!email) {
        $('#email').after('<p class="error-msg text-red-500 text-sm mt-1">Email is required</p>');
        $('#email').addClass('border-red-500');
        hasError = true;
      }

      if (!password) {
        $('#password').after('<p class="error-msg text-red-500 text-sm mt-1">Password is required</p>');
        $('#password').addClass('border-red-500');
        hasError = true;
      }

      if (!password_confirmation) {
        $('#password_confirmation').after('<p class="error-msg text-red-500 text-sm mt-1">Confirm password is required</p>');
        $('#password_confirmation').addClass('border-red-500');
        hasError = true;
      }

      if (password && password_confirmation && password !== password_confirmation) {
        $('#password_confirmation').after('<p class="error-msg text-red-500 text-sm mt-1">Passwords do not match</p>');
        $('#password_confirmation').addClass('border-red-500');
        hasError = true;
      }
      if (!user_type) {
        $('#user_type').after('<p class="error-msg text-red-500 text-sm mt-1">User type is required</p>');
        $('#user_type').addClass('border-red-500');
        hasError = true;
      }

      if (hasError) return;

      fetch('/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          name: name,
          email: email,
          password: password,
          password_confirmation: password_confirmation,
          user_type: user_type
        })
      })
      .then(async response => {
        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Registration failed');
        }
        return response.json();
      })
      .then(data => {
        console.log('Registration successful:', data);
        setWithExpiry('token', data.token, 3600000); 
        window.location.href = '/login'; 
      })
      .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Something went wrong');
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
</body>
</html>