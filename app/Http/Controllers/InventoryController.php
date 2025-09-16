<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json(Inventory::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|integer',
            'quantity'           => 'required|integer'
        ]);

        $inventory = Inventory::create($request->all());

        return response()->json($inventory, 201);
    }

    public function show($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }
        return response()->json($inventory);
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }
        $inventory->update($request->all());
        return response()->json(['message' => 'Updated Successfully', 'data' => $inventory], 200);
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventory not found'], 404);
        }
        $inventory->delete();
        return response()->json(['message' => 'Inventory deleted successfully']);
    }
}