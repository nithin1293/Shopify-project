@extends('layouts.customer')

@section('content')
<div class="container">
    <h1>Add a new address</h1>
    <form action="{{ route('address.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
        </div>
        <div class="mb-3">
            <label for="flat_no" class="form-label">Flat No</label>
            <input type="text" class="form-control" id="flat_no" name="flat_no" required>
        </div>
        <div class="mb-3">
            <label for="street" class="form-label">Street</label>
            <input type="text" class="form-control" id="street" name="street" required>
        </div>
        <div class="mb-3">
            <label for="landmark" class="form-label">Landmark</label>
            <input type="text" class="form-control" id="landmark" name="landmark" required>
        </div>
        <div class="mb-3">
            <label for="pincode" class="form-label">Pincode</label>
            <input type="text" class="form-control" id="pincode" name="pincode" required>
        </div>
        <div class="mb-3">
            <label for="town" class="form-label">Town</label>
            <input type="text" class="form-control" id="town" name="town" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>
        <div class="mb-3">
            <label for="address_type" class="form-label">Address Type</label>
            <select class="form-select" id="address_type" name="address_type" required>
                <option value="Home">Home</option>
                <option value="Work">Work</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save Address</button>
    </form>
</div>
@endsection