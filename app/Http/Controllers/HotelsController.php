<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use Illuminate\Http\Request;
use App\Models\Hotels;

class HotelsController extends Controller
{
      /**
     * Display a listing of hotels.
     */
    public function index()
    {
        $hotels = Hotels::with('destination')->latest()->get();
        $location = destinations::all();

        return view('AdminPanel.Hotel.index', compact('hotels', 'location'));
    }

    /**
     * Store a newly created hotel.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'rating'         => 'nullable|integer|min:1|max:5',
            'description'    => 'nullable|string',
            'price_per_night'=> 'nullable|numeric|min:0',
        ]);

        Hotels::create($request->all());

        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    /**
     * Update the specified hotel.
     */
    public function update(Request $request, Hotels $hotel)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'rating'         => 'nullable|integer|min:1|max:5',
            'description'    => 'nullable|string',
            'price_per_night'=> 'nullable|numeric|min:0',
        ]);

        $hotel->update($request->all());

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified hotel.
     */
    public function destroy(Hotels $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }
public function getHotelsByDestination($id)
{
    $hotels = Hotels::where('destination_id', $id)->get(['id','name']);
    return response()->json($hotels);
}
}