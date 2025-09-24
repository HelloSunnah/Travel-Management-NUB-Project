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

    // Calculate price per person
    $pricePerPerson = $request->price_per_night / $request->capacity;

    // Store with calculated value
    HotelRooms::create([
        'hotel_id'         => $request->hotel_id,
        'room_type'        => $request->room_type,
        'capacity'         => $request->capacity,
        'price_per_night'  => $request->price_per_night,
        'price_per_person' => $pricePerPerson,
        'description'      => $request->description,
    ]);

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

    // Calculate price per person
    $pricePerPerson = $request->price_per_night / $request->capacity;

    // Update with calculated value
    $hotelRoom->update([
        'hotel_id'         => $request->hotel_id,
        'room_type'        => $request->room_type,
        'capacity'         => $request->capacity,
        'price_per_night'  => $request->price_per_night,
        'price_per_person' => $pricePerPerson,
        'description'      => $request->description,
    ]);

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
