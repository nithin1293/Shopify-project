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
        // This view is now fully client-side. No data needs to be passed from the controller.
        return view('cart');
    }
}