<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-50  bg-gradient-to-br">

  <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 w-full max-w-md">
    <div class="text-center mb-8">
      <h1 class="text-2xl font-semibold text-gray-900 mb-2">Create your account</h1>
      <p class="text-gray-600 text-sm">Join thousands of satisfied customers</p>
    </div>

    <form id="register-form" class="space-y-5">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
        <input type="text" id="name" placeholder="Enter your full name" 
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
        <input type="email" id="email" placeholder="Enter your email" 
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input type="password" id="password" placeholder="Create a secure password" 
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
      </div>

      <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
        <input type="password" id="password_confirmation" placeholder="Confirm your password" 
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
      </div>

      <div>
        <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
        <select id="user_type"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
          <option value="" disabled selected>Choose your account type</option>
          <option value="customer">Customer - Shop and browse products</option>
          <option value="store_owner">Store Owner - Sell your products</option>
        </select>
      </div>

      <button type="submit" id="register-button"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Create Account
      </button>
    </form>

    <div class="mt-6 text-center">
      <p class="text-gray-600 text-sm">
        Already have an account?
        <a href="{{ route('login.form') }}" class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition-colors duration-200">Sign in here</a>
      </p>
    </div>

    <div class="mt-6 pt-4 border-t border-gray-200">
      <p class="text-xs text-gray-500 text-center">
        By creating an account, you agree to our 
        <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and 
        <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
      </p>
    </div>
  </div>

  <script>
    // Clear any existing token
    if (typeof(Storage) !== "undefined") {
      localStorage.removeItem('token');
    }

    document.getElementById('register-button').addEventListener('click', function(event) {
      event.preventDefault();

      const name = $('#name').val().trim();
      const email = $('#email').val().trim();
      const password = $('#password').val();
      const password_confirmation = $('#password_confirmation').val();
      const user_type = $('#user_type').val();

      // Remove old error messages and reset styles
      $('.error-msg').remove();
      $('input, select').removeClass('border-red-500 ring-red-500').addClass('border-gray-300');

      let hasError = false;

      // Validation with better UX
      if (!name) {
        $('#name').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Full name is required</p>');
        $('#name').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      }

      if (!email) {
        $('#email').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Email address is required</p>');
        $('#email').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      } else if (!isValidEmail(email)) {
        $('#email').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Please enter a valid email address</p>');
        $('#email').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      }

      if (!password) {
        $('#password').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Password is required</p>');
        $('#password').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      } else if (password.length < 6) {
        $('#password').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Password must be at least 6 characters</p>');
        $('#password').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      }

      if (!password_confirmation) {
        $('#password_confirmation').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Please confirm your password</p>');
        $('#password_confirmation').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      } else if (password && password_confirmation && password !== password_confirmation) {
        $('#password_confirmation').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Passwords do not match</p>');
        $('#password_confirmation').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      }

      if (!user_type) {
        $('#user_type').after('<p class="error-msg text-red-500 text-sm mt-1 flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Please select an account type</p>');
        $('#user_type').removeClass('border-gray-300').addClass('border-red-500 ring-1 ring-red-500');
        hasError = true;
      }

      if (hasError) return;

      // Show loading state
      const button = document.getElementById('register-button');
      const originalText = button.innerHTML;
      button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Creating Account...';
      button.disabled = true;

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
        if (typeof(Storage) !== "undefined") {
          setWithExpiry('token', data.token, 3600000);
        }
        
        // Success feedback
        button.innerHTML = '<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Account Created!';
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        button.classList.add('bg-green-600');
        
        setTimeout(() => {
          window.location.href = '/login';
        }, 1000);
      })
      .catch(error => {
        console.error('Error:', error);
        
        // Reset button
        button.innerHTML = originalText;
        button.disabled = false;
        
        // Show error message
        const form = document.getElementById('register-form');
        const existingError = form.querySelector('.server-error');
        if (existingError) {
          existingError.remove();
        }
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'server-error bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4';
        errorDiv.innerHTML = `
          <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">Registration Failed:</span>
            <span class="ml-1">${error.message || 'Something went wrong. Please try again.'}</span>
          </div>
        `;
        form.insertBefore(errorDiv, form.firstChild);
      });
    });

    function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }

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