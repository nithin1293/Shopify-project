<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        // Get all orders for the currently authenticated customer
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();

        return view('customer.orders_index', compact('orders'));
    }

    /**
     * Display the tracking page for a specific order.
     */
    public function show(Order $order)
    {
        // Security Check: Ensure the authenticated user owns this order
        if (Auth::user()->email !== $order->customer_email) {
            abort(403, 'You are not authorized to view this order.');
        }

        return view('customer.order_track', compact('order'));
    }
}