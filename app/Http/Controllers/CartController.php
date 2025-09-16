<?php

namespace App\Http\Controllers;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show cart page (cart items come from localStorage in frontend JS).
     */
     public function index(Request $request)
    {
        
        $addresses = Auth::check() ? $request->user()->addresses : collect();
        
        $selectedAddress = null;
        if (session()->has('selected_address_id')) {
            $selectedAddress = Address::find(session('selected_address_id'));
        }

        return view('cart', compact( 'addresses', 'selectedAddress'));
    }
}