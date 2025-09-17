@extends('layouts.app')

@section('title', 'Edit Address')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Edit Address</h1>

    <form id="editAddressForm" class="space-y-4">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
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
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Update</button>
    </form>
</div>

<script>
    const id = "{{ $id }}";
    const token = localStorage.getItem('jwt_token');

    async function loadAddress() {
        const res = await fetch('/api/customer/addresses', {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const addresses = await res.json();
        const addr = addresses.find(a => a.id == id);

        if (addr) {
            document.querySelector('[name="name"]').value = addr.name;
            document.querySelector('[name="mobile_number"]').value = addr.mobile_number;
            document.querySelector('[name="flat_no"]').value = addr.flat_no;
            document.querySelector('[name="street"]').value = addr.street;
            document.querySelector('[name="landmark"]').value = addr.landmark || '';
            document.querySelector('[name="town"]').value = addr.town;
            document.querySelector('[name="state"]').value = addr.state;
            document.querySelector('[name="country"]').value = addr.country;
            document.querySelector('[name="pincode"]').value = addr.pincode;
            document.querySelector('[name="address_type"]').value = addr.address_type;
        }
    }

    document.getElementById('editAddressForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        await fetch('/api/customer/addresses/' + id, {
            method: 'PUT',
            headers: { 'Authorization': 'Bearer ' + token },
            body: formData
        });

        window.location.href = "{{ route('addresses.index') }}";
    });

    loadAddress();
</script>
@endsection
