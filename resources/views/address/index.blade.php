@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">My Addresses</h1>

    <div id="address-list" class="space-y-4"></div>

    <a href="{{ route('addresses.create') }}" 
       class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
        Add New Address
    </a>
</div>

<script>
    async function fetchAddresses() {
        const token = localStorage.getItem('jwt_token');
        const res = await fetch('/api/customer/addresses', {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const addresses = await res.json();

        let container = document.getElementById('address-list');
        container.innerHTML = '';

        if (addresses.length === 0) {
            container.innerHTML = '<p class="text-gray-500">No addresses found. Add one!</p>';
            return;
        }

        addresses.forEach(addr => {
            container.innerHTML += `
                <div class="p-4 bg-white shadow rounded-lg">
                    <p><strong>${addr.name}</strong> (${addr.address_type})</p>
                    <p>${addr.flat_no}, ${addr.street}, ${addr.town}, ${addr.state}, ${addr.country} - ${addr.pincode}</p>
                    <p>Mobile: ${addr.mobile_number}</p>
                    <div class="mt-2">
                        <a href="/addresses/${addr.id}/edit" class="text-blue-600">Edit</a> | 
                        <button onclick="deleteAddress(${addr.id})" class="text-red-600">Delete</button>
                    </div>
                </div>
            `;
        });
    }

    async function deleteAddress(id) {
        const token = localStorage.getItem('jwt_token');
        await fetch('/api/customer/addresses/' + id, {
            method: 'DELETE',
            headers: { 'Authorization': 'Bearer ' + token }
        });
        fetchAddresses();
    }

    fetchAddresses();
</script>
@endsection
