<?php

namespace App\Http\Controllers;

use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $userId = $request->query('user_id');
        // 3. 🛑 THIS IS THE FIX 🛑
        //    Change from OrderDetails::all() to filter by user_id
        $orders = OrderDetails::where('user_id',$userId)
                              ->orderBy('created_at', 'desc') // Show newest first
                              ->get();
        // 🛑 END OF FIX 🛑

        $ordersData = [];

        foreach ($orders as $order) {
            // ... (rest of your processing loop)
            $productDetails = [];

            // Handle both JSON string and array safely
            $decodedProducts = is_array($order->product_details)
                ? $order->product_details
                : json_decode($order->product_details, true);

            if (is_array($decodedProducts)) {
                foreach ($decodedProducts as $item) {
                    if (!is_array($item)) continue;

                    $productId = $item['product_id'] ?? $item['id'] ?? null;
                    if (!$productId) continue;

                    $product = Product::select('id', 'name', 'description', 'price', 'image')
                        ->find($productId);

                    $productDetails[] = [
                        'product_id'   => $productId,
                        'name'         => $product->name ?? 'Unknown Product',
                        'description'  => $product->description ?? 'No description available',
                        'price'        => $product->price ?? $item['price'] ?? 0,
                        'image'        => $product->image ?? 'no-image.png',
                        'quantity'     => $item['quantity'] ?? 1,
                        'total_price'  => ($item['quantity'] ?? 1) * ($product->price ?? $item['price'] ?? 0),
                    ];
                }
            }

            $ordersData[] = [
                'id'             => $order->id,
                'customer_name'  => $order->customer_name,
                'product_details'=> $productDetails,
                'total'          => $order->total,
                'status'         => $order->status,
                'created_at'     => $order->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return view('orders.index', compact('ordersData'));
    }


    
public function all_orders()
    {
        
        
        // 3. 🛑 THIS IS THE FIX 🛑
        //    Change from OrderDetails::all() to filter by user_id
        $orders = OrderDetails::orderBy('created_at', 'desc') // Show newest first
                              ->get();
        // 🛑 END OF FIX 🛑

        $ordersData = [];

        foreach ($orders as $order) {
            // ... (rest of your processing loop)
            $productDetails = [];

            // Handle both JSON string and array safely
            $decodedProducts = is_array($order->product_details)
                ? $order->product_details
                : json_decode($order->product_details, true);

            if (is_array($decodedProducts)) {
                foreach ($decodedProducts as $item) {
                    if (!is_array($item)) continue;

                    $productId = $item['product_id'] ?? $item['id'] ?? null;
                    if (!$productId) continue;

                    $product = Product::select('id', 'name', 'description', 'price', 'image')
                        ->find($productId);

                    $productDetails[] = [
                        'product_id'   => $productId,
                        'name'         => $product->name ?? 'Unknown Product',
                        'description'  => $product->description ?? 'No description available',
                        'price'        => $product->price ?? $item['price'] ?? 0,
                        'image'        => $product->image ?? 'no-image.png',
                        'quantity'     => $item['quantity'] ?? 1,
                        'total_price'  => ($item['quantity'] ?? 1) * ($product->price ?? $item['price'] ?? 0),
                    ];
                }
            }

            $ordersData[] = [
                'id'             => $order->id,
                'customer_name'  => $order->customer_name,
                'product_details'=> $productDetails,
                'total'          => $order->total,
                'status'         => $order->status,
                'created_at'     => $order->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return view('orders.dashboard_orders', compact('ordersData'));
    }


        public function markAsShipped($id)
    {
        $order = OrderDetails::findOrFail($id);
        $order->status = 'shipped';
        $order->save();

        return response()->json(['success' => true, 'status' => 'shipped']);
    }

    public function markAsDelivered($id)
    {
        $order = OrderDetails::findOrFail($id);
        $order->status = 'delivered';
        $order->save();

        return response()->json(['success' => true, 'status' => 'delivered']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // ✅ Validate incoming data
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_details' => 'required|array', // expects an array of product details
            'total' => 'required|integer|min:0',
            'status' => 'nullable|string',
            'user_id' => 'required|exists:users,id'
        ]);

        // ✅ Create a new order
        $order = OrderDetails::create([
            'customer_name' => $validatedData['customer_name'],
            'product_details' => $validatedData['product_details'], // Laravel auto-casts JSON
            'total' => $validatedData['total'],
            'status' => $validatedData['status'] ?? 'pending',
            'user_id' => $validatedData['user_id']
        ]);

        // ✅ Return JSON response
        return response()->json([
            'message' => 'Order created successfully!',
            'data' => $order,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetails $orderDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDetails $orderDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderDetails $orderDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetails $orderDetails)
    {
        //
    }
}
