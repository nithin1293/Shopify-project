@extends('layouts.app')

@section('title', 'Add Address')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Add New Address</h1>

    <form id="addressForm" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Full Name" class="w-full border p-2 rounded" required>
        <input type="text" name="mobile_number" placeholder="Mobile Number" class="w-full border p-2 rounded" required>
        <input type="text" name="flat_no" placeholder="Flat/House No." class="w-full border p-2 rounded" required>
        <input type="text" name="street" placeholder="Street" class="w-full border p-2 rounded" required>
        <input type="text" name="landmark" placeholder="Landmark" class="w-full border p-2 rounded">
        <input type="text" name="town" placeholder="Town/City" class="w-full border p-2 rounded" required>
        <input type="text" name="state" placeholder="State" class="w-full border p-2 rounded" required>
        <input type="text" name="country" placeholder="Country" class="w-full border p-2 rounded" required>
        <input type="text" name="pincode" placeholder="Pincode" class="w-full border p-2 rounded" required>
        <select name="address_type" class="w-full border p-2 rounded" required>
            <option value="Home">Home</option>
            <option value="Work">Work</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
    </form>
</div>

<script>
    document.getElementById('addressForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const token = localStorage.getItem('jwt_token');
        const formData = new FormData(this);
        const res = await fetch('/api/customer/addresses', {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + token },
            body: formData
        });

        if (res.ok) {
            window.location.href = "{{ route('addresses.index') }}";
        }
    });
</script>
@endsection
