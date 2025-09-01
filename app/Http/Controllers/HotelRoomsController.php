<?php

namespace App\Http\Controllers;

use App\Models\HotelRooms;
use App\Models\Hotels;
use Illuminate\Http\Request;

class HotelRoomsController extends Controller
{
  public function index()
    {
        $rooms = HotelRooms::with('hotel')->latest()->get();
        $hotels = Hotels::all(); // for select dropdown
        return view('AdminPanel.Hotel.HotelRooms', compact('rooms', 'hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id'        => 'required|exists:hotels,id',
            'room_type'       => 'required|string|max:255',
            'capacity'        => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'description'     => 'nullable|string',
        ]);

        HotelRooms::create($request->all());

        return redirect()->route('hotel-rooms.index')
                         ->with('success', 'Room created successfully!');
    }

    public function update(Request $request, HotelRooms $hotelRoom)
    {
        $request->validate([
            'hotel_id'        => 'required|exists:hotels,id',
            'room_type'       => 'required|string|max:255',
            'capacity'        => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'description'     => 'nullable|string',
        ]);

        $hotelRoom->update($request->all());

        return redirect()->route('hotel-rooms.index')
                         ->with('success', 'Room updated successfully!');
    }

    public function destroy(HotelRooms $hotelRoom)
    {
        $hotelRoom->delete();

        return redirect()->route('hotel-rooms.index')
                         ->with('success', 'Room deleted successfully!');
    }
}
