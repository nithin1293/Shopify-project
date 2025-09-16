<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display a listing of themes.
     */
    public function index()
    {
        return response()->json(Theme::all());
    }

    /**
     * Store a newly created theme in storage.
     */
    
       public function store(Request $request)
{
    $request->validate([
        'name'             => 'required|string|max:255',
        'font_size'       => 'nullable|string|max:50',
        'font_color'      => 'nullable|string|max:50',
        'background_color'=> 'nullable|string|max:50',
        'font_name'       => 'nullable|string|max:100',
    ]);

    $settings = [
        'font_size'        => $request->font_size,
        'font_color'       => $request->font_color,
        'background_color' => $request->background_color,
        'font_name'        => $request->font_name,
    ];

    $theme = Theme::create([
        'name'     => $request->name,
        'settings' => json_encode($settings), // store as JSON
    ]);

    return redirect()->route('theme.view')->with('success', 'Theme created successfully!');
}

    

    /**
     * Display the specified theme.
     */
    public function show($id)
    {
        $theme = Theme::findOrFail($id);
        return response()->json($theme);
    }

    /**
     * Update the specified theme in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'nullable|string|max:255',
            'settings' => 'nullable|array',
        ]);

        $theme = Theme::findOrFail($id);
        $theme->update($request->only(['name', 'settings']));

        return response()->json([
            'message' => 'Theme updated successfully',
            'theme'   => $theme
        ]);
    }

    /**
     * Remove the specified theme from storage.
     */
    public function destroy($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->delete();

        return response()->json(['message' => 'Theme deleted successfully']);
    }
}