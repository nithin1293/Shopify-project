<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class ProductController extends Controller
{
    protected $uploadApi;

    public function __construct()
    {
        // Configure Cloudinary
        Configuration::instance(env('CLOUDINARY_URL'));

        // Instantiate UploadApi
        $this->uploadApi = new UploadApi();
    }
     public function create()
    {
        
        $stores = Store::all();
        return view('product', compact('stores'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for the image
        ]);


        $uploadedFile = $request->file('image');
        $uploadResult = $this->uploadApi->upload($uploadedFile->getRealPath(), [
                'folder' => 'profiles',
                'resource_type' => 'image',
                'transformation' => [
                    ['width' => 300, 'height' => 300, 'crop' => 'fill'],
                ],
            ]);

        // Handle image upload
   

        Product::create([
            'store_id' => $request->store_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $uploadResult['secure_url'], // Save the image path to the database
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($request->all());
        return response()->json(['message' => 'Updated Successfully', 'data' => $product], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}