@extends('layouts.app')

@section('title', 'Add New Address')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add a New Address</h1>

    <div class="bg-white p-8 rounded-lg shadow">
        <form id="add-address-form" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" id="name" placeholder="Full Name" class="w-full p-3 border-2 rounded-lg">
                <input type="text" id="mobile_number" placeholder="Mobile Number" class="w-full p-3 border-2 rounded-lg">
            </div>
            <input type="text" id="flat_no" placeholder="Flat, House no., Building, Company, Apartment" class="w-full p-3 border-2 rounded-lg">
            <input type="text" id="street" placeholder="Area, Street, Sector, Village" class="w-full p-3 border-2 rounded-lg">
            <input type="text" id="landmark" placeholder="Landmark" class="w-full p-3 border-2 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" id="town" placeholder="Town/City" class="w-full p-3 border-2 rounded-lg">
                <input type="text" id="pincode" placeholder="Pincode" class="w-full p-3 border-2 rounded-lg">
            </div>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" id="state" placeholder="State" class="w-full p-3 border-2 rounded-lg">
                <input type="text" id="country" placeholder="Country" class="w-full p-3 border-2 rounded-lg">
            </div>
            <div>
                <select id="address_type" class="w-full p-3 border-2 rounded-lg">
                    <option value="Home">Home</option>
                    <option value="Work">Work</option>
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('addresses.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save Address</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-address-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const token = getWithExpiry('token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        const addressData = {
            name: document.getElementById('name').value,
            mobile_number: document.getElementById('mobile_number').value,
            flat_no: document.getElementById('flat_no').value,
            street: document.getElementById('street').value,
            landmark: document.getElementById('landmark').value,
            town: document.getElementById('town').value,
            pincode: document.getElementById('pincode').value,
            state: document.getElementById('state').value,
            country: document.getElementById('country').value,
            address_type: document.getElementById('address_type').value,
        };

        fetch('/api/addresses', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            },
            body: JSON.stringify(addressData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            alert('Address saved successfully!');
            window.location.href = "{{ route('addresses.index') }}";
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to save address. Please check the console for details.');
        });
    });

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
@endsection