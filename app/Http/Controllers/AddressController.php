<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressController extends Controller
{
    // API Methods
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

    // Web Methods
    public function show(Request $request, $id)
    {
        try {
            // Find the address that belongs ONLY to the authenticated user
            $address = $request->user()->addresses()->findOrFail($id);
            return response()->json($address);
        } catch (ModelNotFoundException $e) {
            // If the address is not found for this user, return a clear 404 JSON response
            return response()->json(['message' => 'Address not found for this user.'], 404);
        }
    }

    // --- Web Methods ---
    public function indexWeb(Request $request)
    {
        return view('addresses.index');
    }

    public function createWeb()
    {
        return view('addresses.create');
    }
}