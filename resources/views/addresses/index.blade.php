@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Addresses</h1>
        <a href="{{ route('addresses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Add New Address
        </a>
    </div>

    <div id="address-list" class="space-y-4">
        <p>Loading addresses...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = getWithExpiry('token');
        console.log('Using token:', token); // For debugging

        if (!token) {
            alert('You are not logged in. Redirecting to login page.');
            window.location.href = '/login';
            return;
        }

        fetch('/api/addresses', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                console.error('API Response Error:', response.status, response.statusText);
                throw new Error('Failed to fetch addresses');
            }
            return response.json();
        })
        .then(addresses => {
            console.log('Addresses received from API:', addresses); // For debugging
            const addressList = document.getElementById('address-list');
            addressList.innerHTML = ''; // Clear the "Loading..." message

            if (!addresses || addresses.length === 0) {
                addressList.innerHTML = `
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <p class="text-gray-600">You have no saved addresses.</p>
                    </div>
                `;
            } else {
                addresses.forEach(address => {
                    const addressElement = document.createElement('div');
                    addressElement.className = 'bg-white p-4 rounded-lg shadow flex justify-between items-center';
                    addressElement.innerHTML = `
                        <div>
                            <p class="font-semibold">${address.name} - <span class="font-normal">${address.mobile_number}</span></p>
                            <p class="text-gray-600">${address.flat_no}, ${address.street}, ${address.landmark || ''}</p>
                            <p class="text-gray-600">${address.town}, ${address.state} - ${address.pincode}</p>
                        </div>
                        <button onclick="selectAddress(${address.id})" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                            Select
                        </button>
                    `;
                    addressList.appendChild(addressElement);
                });
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            const addressList = document.getElementById('address-list');
            addressList.innerHTML = `<div class="bg-red-100 text-red-700 p-4 rounded-lg">Could not load addresses. Please ensure you are logged in correctly and try again.</div>`;
        });
    });

    function selectAddress(addressId) {
        // Instead of a form post, we save the ID to localStorage
        localStorage.setItem('selected_address_id', addressId);
        alert('Address selected!');
        window.location.href = "{{ route('cart') }}";
    }

</script>
@endsection