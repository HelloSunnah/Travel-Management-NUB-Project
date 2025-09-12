<?php

namespace App\Http\Controllers;

use App\Models\Destinations;
use App\Models\Foods;
use App\Models\Hotels;
use App\Models\HotelRooms;
use App\Models\Packages;
use App\Models\packageFoods;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    // Show packages + form
public function index() {
    $packages = Packages::with(['destination', 'hotel', 'room', 'foods'])->latest()->get();
    $destinations = destinations::all();
    $hotels = Hotels::all();
        return view('AdminPanel.Package.Index', compact('destinations', 'hotels', 'packages'));
}
// Store package
public function store(Request $request)
{
    $request->validate([
        'title'          => 'required|string|max:255',
        'destination_id' => 'required|exists:destinations,id',
        'hotel_id'       => 'required|exists:hotels,id',
        'room_id'        => 'required|exists:hotel_rooms,id',
        'nights'         => 'required|integer|min:1',
        'start_date'     => 'required|date',
        'end_date'       => 'required|date|after_or_equal:start_date',
        'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // --- Calculate hotel total price ---
    $room = HotelRooms::findOrFail($request->room_id);
    $hotelTotalPrice = $room->price_per_night * $request->nights;

    // --- Create Package ---
    $package = Packages::create([
        'title'             => $request->title,
        'destination_id'    => $request->destination_id,
        'hotel_id'          => $request->hotel_id,
        'room_id'           => $request->room_id,
        'nights'            => $request->nights,
        'hotel_total_price' => $hotelTotalPrice,
        'base_price'        => $request->base_price ?? 0,
        'extra_cost'        => $request->extra_cost ?? 0,
        'transport_cost'    => $request->transport_cost ?? 0,
        'start_date'        => $request->start_date,
        'end_date'          => $request->end_date,
    ]);

    // --- Save package image ---
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/packages'), $filename);

        $package->image = $filename;
        $package->save(); // <-- this line is important!
    }

    // --- Save selected foods ---
    if ($request->has('foods')) {
        foreach ($request->foods as $foodId => $foodData) {
            packageFoods::create([
                'package_id' => $package->id,
                'food_id'    => $foodId,
                'quantity'   => $foodData['qty'] ?? 1,
                'total'      => $foodData['total'] ?? 0,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Package created successfully!');
}


// Update package
public function update(Request $request, Packages $package)
{
    $request->validate([
        'title'          => 'required|string|max:255',
        'destination_id' => 'required|exists:destinations,id',
        'hotel_id'       => 'required|exists:hotels,id',
        'room_id'        => 'required|exists:hotel_rooms,id',
        'nights'         => 'required|integer|min:1',
        'start_date'     => 'required|date',
        'end_date'       => 'required|date|after_or_equal:start_date',
        'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // --- Update base fields ---
    $package->update($request->only([
        'title',
        'destination_id',
        'hotel_id',
        'room_id',
        'nights',
        'extra_cost',
        'transport_cost',
        'start_date',
        'end_date',
        'base_price',
    ]));

    // --- Handle image update ---
    if ($request->hasFile('image')) {
        // delete old image if exists
        if ($package->image && file_exists(public_path('uploads/packages/' . $package->image))) {
            unlink(public_path('uploads/packages/' . $package->image));
        }

        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/packages'), $filename);

        $package->image = $filename;
        $package->save();
    }

    // --- Refresh foods ---
    $package->foods()->delete();
    if ($request->has('foods')) {
        foreach ($request->foods as $foodId => $foodData) {
            packageFoods::create([
                'package_id' => $package->id,
                'food_id'    => $foodId,
                'quantity'   => $foodData['qty'] ?? 1,
                'total'      => $foodData['total'] ?? 0,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Package updated successfully!');
}

    public function edit(Packages $package)
{
    $destinations = Destinations::all();
    $hotels = Hotels::all();
    $rooms = HotelRooms::where('hotel_id', $package->hotel_id)->get();

    return view('AdminPanel.Package.Index', compact('package', 'destinations', 'hotels', 'rooms'));
}

    // Delete package
    public function destroy(Packages $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'Package deleted successfully!');
    }

    // ========= AJAX APIs =========

    // Destination → Hotels
    public function getHotels($destinationId)
    {
        $hotels = Hotels::where('destination_id', $destinationId)->get();
        return response()->json($hotels);
    }

    // Hotel → Rooms
    public function getRooms($hotelId)
    {
        $rooms = HotelRooms::where('hotel_id', $hotelId)->get();
        return response()->json($rooms);
    }

    // Destination → Foods
    public function getFoods($destinationId)
    {
        $foods = Foods::where('destination_id', $destinationId)->get();
        return response()->json($foods);
    }
}
