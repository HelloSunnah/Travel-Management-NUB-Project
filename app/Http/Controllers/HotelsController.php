<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotels;

class HotelsController extends Controller
{
    public function index()
    {
        $hotels = Hotels::latest()->get();
        return view('AdminPanel.Hotel.index', compact('hotels'));
    }

    /**
     * Store a newly created hotel in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'rating'      => 'nullable|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        Hotels::create($request->all());

        return redirect()->route('hotels.index')
                         ->with('success', 'Hotel created successfully!');
    }

    /**
     * Update the specified hotel.
     */
    public function update(Request $request, Hotels $hotel)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'rating'      => 'nullable|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        $hotel->update($request->all());

        return redirect()->route('hotels.index')
                         ->with('success', 'Hotel updated successfully!');
    }

    /**
     * Remove the specified hotel from storage.
     */
    public function destroy(Hotels $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels.index')
                         ->with('success', 'Hotel deleted successfully!');
    }}
