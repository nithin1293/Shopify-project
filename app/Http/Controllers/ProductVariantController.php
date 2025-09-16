<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        return response()->json(ProductVariant::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|integer',
            'name'          => 'required|string|max:255',
            'price_modifier'=> 'nullable|numeric'
        ]);

        $variant = ProductVariant::create($request->all());

        return response()->json($variant, 201);
    }

    public function show($id)
    {
        $variant = ProductVariant::find($id);
        if (!$variant) {
            return response()->json(['message' => 'Variant not found'], 404);
        }
        return response()->json($variant);
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::find($id);
        if (!$variant) {
            return response()->json(['message' => 'Variant not found'], 404);
        }
        $variant->update($request->all());
        return response()->json(['message' => 'Updated Successfully', 'data' => $variant], 200);
    }

    public function destroy($id)
    {
        $variant = ProductVariant::find($id);
        if (!$variant) {
            return response()->json(['message' => 'Variant not found'], 404);
        }
        $variant->delete();
        return response()->json(['message' => 'Variant deleted successfully']);
    }
}