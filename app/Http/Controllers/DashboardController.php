<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Theme;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // returns the User model of the logged-in person

        // Fetch only that user's stores
        $stores = Store::where('user_id', $user->id)->get();
        return view('dashboard', compact('stores'));
    }
    public function showStore($id)
{
    $store = Store::with('products')->findOrFail($id);

    return view('front', compact('store'));
}


    public function viewStore($id)
    {
        $store = Store::with('products', 'theme')->findOrFail($id);

        // Decode theme settings (stored as JSON)
        $themeSettings = $store->theme ? json_decode($store->theme->settings, true) : [];

        return view('store_products', compact('store', 'themeSettings'));
    }
    public function orders()
    {
        $user = Auth::user();

        // Step 1: Get store IDs owned by this user
        $storeIds = Store::where('user_id', $user->id)->pluck('id');

        // Step 2: Get all orders that contain products from those stores
        $orders = OrderDetail::latest()->get();
        $ordersData = [];

        foreach ($orders as $order) {
            $decodedProducts = is_string($order->product_details)
                ? json_decode($order->product_details, true)
                : $order->product_details;

            $productDetails = [];
            foreach ($decodedProducts as $item) {
                $product = Product::select('id', 'store_id', 'name', 'description', 'price', 'image')->find($item['product_id']);

                if ($product && $storeIds->contains($product->store_id)) {
                    $productDetails[] = [
                        'product_id'   => $product->id,
                        'name'         => $product->name,
                        'description'  => $product->description,
                        'price'        => $product->price,
                        'image'        => $product->image,
                        'quantity'     => $item['quantity'] ?? 1,
                        'total_price'  => ($item['quantity'] ?? 1) * $product->price,
                    ];
                }
            }

            if (!empty($productDetails)) {
                $ordersData[] = [
                    'customer_name'   => $order->customer_name,
                    'product_details' => $productDetails,
                    'total'           => $order->total,
                    'status'          => ucfirst($order->status),
                ];
            }
        }

       return view('orders.dashboard_orders', compact('ordersData'));
    }
}