<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->addresses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'town' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'flat_no' => 'required|string|max:255',
            'address_type' => 'required|in:Home,Work',
        ]);

        $address = $request->user()->addresses()->create($validated);

        return response()->json($address, 201);
    }

    public function update(Request $request, $id)
    {
        $address = $request->user()->addresses()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'street' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'town' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'flat_no' => 'required|string|max:255',
            'address_type' => 'required|in:Home,Work',
        ]);

        $address->update($validated);

        return response()->json($address);
    }

    public function destroy(Request $request, $id)
    {
        $address = $request->user()->addresses()->findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Address deleted successfully']);
    }
}
