<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreController extends Controller
{
    public function create()
    {
        $themes = Theme::all(); 
        return view('store', compact('themes'));
    }
    

    public function store(Request $request)
{
    $store = new Store();
    $store->user_id = Auth::id();
    $store->name = $request->name;
    $store->domain = $request->domain;
    $store->theme_id = $request->theme_id;
    $store->save();

    return response()->json(['status' => 'success', 'message' => 'Store created successfully!']);
}

    public function show($id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }
        return response()->json($store);
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }
        $store->update($request->all());
        return response()->json(['message' => 'Updated Successfully', 'data' => $store], 200);
    }

    public function destroy($id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json(['message' => 'Store not found'], 404);
        }
        $store->delete();
        return response()->json(['message' => 'Store deleted successfully']);
    }
}