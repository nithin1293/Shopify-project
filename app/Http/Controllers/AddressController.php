<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    

    public function createAddress()
    {
        return view('address.create');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'flat_no' => 'required|string|max:255',
            'address_type' => 'required|in:Home,Work',
        ]);

        $request->user()->addresses()->create($request->all());

        return redirect()->route('cart.index')->with('success', 'Address saved successfully!');
    }

    public function selectAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        session(['selected_address_id' => $request->address_id]);

        return redirect()->route('cart.index')->with('success', 'Address selected successfully!');
    }

    public function addresses(Request $request)
    {
        $addresses = $request->user()->addresses;
        return view('address.index', compact('addresses'));
    }

    public function editAddress(Request $request, $addressId)
    {
        $address = $request->user()->addresses()->findOrFail($addressId);
        return view('address.edit', compact('address'));
    }

    public function updateAddress(Request $request, $addressId)
    {
        $address = $request->user()->addresses()->findOrFail($addressId);

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'flat_no' => 'required|string|max:255',
            'address_type' => 'required|in:Home,Work',
        ]);

        $address->update($request->all());

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully!');
    }
}