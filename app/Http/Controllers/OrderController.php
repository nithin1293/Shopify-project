<?php



namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- ADD THIS LINE

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id'       => 'required|integer',
            'customer_email' => 'required|email',
            'total'          => 'required|numeric',
            'status'         => 'required|string'
        ]);

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update($request->all());
        return response()->json(['message' => 'Updated Successfully', 'data' => $order], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }

    // --- ADD THIS NEW WEB METHOD ---
    public function indexWeb(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login.form')->with('error', 'You must be logged in to see your orders.');
        }

        $orders = Order::where('customer_email', $user->email)
                       ->with('orderItems.product') // Eager load order items and their products
                       ->orderBy('created_at', 'desc') // Show newest orders first
                       ->get();

        return view('orders.my', compact('orders'));
    }
    // --- END OF NEW WEB METHOD ---
}