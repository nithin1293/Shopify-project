@extends('layouts.customer')

@section('content')
<div class="container">
    <h1>Manage Addresses</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($addresses->isEmpty())
        <div class="card">
            <div class="card-body">
                <p>You have no saved addresses.</p>
                <a href="{{ route('address.create') }}" class="btn btn-primary">Add a new address</a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($addresses as $address)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $address->name }} ({{ $address->address_type }})</h5>
                            <p class="card-text">
                                {{ $address->flat_no }}, {{ $address->street }}, {{ $address->landmark }}<br>
                                {{ $address->town }}, {{ $address->state }} - {{ $address->pincode }}<br>
                                {{ $address->country }}<br>
                                Phone: {{ $address->mobile_number }}
                            </p>
                            <form action="{{ route('address.select') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="address_id" value="{{ $address->id }}">
                                <button type="submit" class="btn btn-primary">Select Address</button>
                            </form>
                            <a href="{{ route('address.edit', $address->id) }}" class="btn btn-secondary">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        <a href="{{ route('address.create') }}" class="btn btn-primary">Add a new address</a>
    @endif
</div>
@endsection