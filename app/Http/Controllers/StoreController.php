<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class StoreController extends Controller
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
        $themes = Theme::all(); 
        return view('store', compact('themes'));
    }
    

 public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'domain' => 'required|string|max:255|unique:stores',
        'theme_id' => 'required|exists:themes,id',
        'logo' => 'nullable|image|max:2048',
        'description' => 'nullable|string',
        'multi_channel_sales' => 'nullable|boolean',
    ]);

    $logoUrl = null; // default value

    if ($request->hasFile('logo')) {
        $uploadedFile = $request->file('logo');
        $uploadResults = $this->uploadApi->upload($uploadedFile->getRealPath(), [
            'folder' => 'profiles',
            'resource_type' => 'image',
            'transformation' => [
                ['width' => 300, 'height' => 300, 'crop' => 'fill'],
            ],
        ]);

        $logoUrl = $uploadResults['secure_url']; // store the URL
    }

    Store::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'domain' => $request->domain,
        'theme_id' => $request->theme_id,
        'logo' => $logoUrl, // safe even if null
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Store created successfully!'
    ]);
}

    

   

    
    //  Store::create([
    //         'user_id' => Auth::id(),
    //         'name' => $request->name,
    //         'domain' => $request->domain,
    //         'theme_id' => $request->theme_id,
    //         'logo' => $uploadResult['secure_url'], // Save the image path to the database
    //     ]);

    

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