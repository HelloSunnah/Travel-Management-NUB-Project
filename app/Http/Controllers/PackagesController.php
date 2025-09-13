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
    public function index()
    {
        $packages = Packages::with(['destination', 'hotel', 'room', 'foods'])->latest()->get();
        $destinations = Destinations::all();
        $hotels = Hotels::all();

        return view('AdminPanel.Package.Index', compact('destinations', 'hotels', 'packages'));
    }

    // Store new package
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'hotel_id'       => 'required|exists:hotels,id',
            'room_id'        => 'required|exists:hotel_rooms,id',
            'nights'         => 'required|integer|min:1',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $room = HotelRooms::findOrFail($request->room_id);
        $hotelTotalPrice = $room->price_per_night * $request->nights;
        $perHeadPrice = $room->person_capacity > 0 ? $hotelTotalPrice / $room->person_capacity : $hotelTotalPrice;

        $foodTotal = 0;
        if ($request->has('foods')) {
            foreach ($request->foods as $foodData) {
                $foodTotal += $foodData['total'] ?? 0;
            }
        }

        $grandTotal = $hotelTotalPrice 
                    + ($request->base_price ?? 0) 
                    + ($request->extra_cost ?? 0) 
                    + ($request->transport_cost ?? 0) 
                    + $foodTotal;

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('uploads/packages', 'public');
        }

        // Create package
        $package = Packages::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'destination_id'    => $request->destination_id,
            'hotel_id'          => $request->hotel_id,
            'room_id'           => $request->room_id,
            'nights'            => $request->nights,
            'hotel_total_price' => $hotelTotalPrice,
            'per_head_price'    => $perHeadPrice,
            'base_price'        => $request->base_price ?? 0,
            'extra_cost'        => $request->extra_cost ?? 0,
            'transport_cost'    => $request->transport_cost ?? 0,
            'grand_total'       => $grandTotal,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'image'             => $imageName,
        ]);

        // Save selected foods
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

    // Edit package
    public function edit(Packages $package)
    {
        $destinations = Destinations::all();
        $hotels = Hotels::all();
        $rooms = HotelRooms::where('hotel_id', $package->hotel_id)->get();

        return view('AdminPanel.Package.Index', compact('package', 'destinations', 'hotels', 'rooms'));
    }

    // Update package
    public function update(Request $request, Packages $package)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'hotel_id'       => 'required|exists:hotels,id',
            'room_id'        => 'required|exists:hotel_rooms,id',
            'nights'         => 'required|integer|min:1',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $room = HotelRooms::findOrFail($request->room_id);
        $hotelTotalPrice = $room->price_per_night * $request->nights;
        $perHeadPrice = $room->person_capacity > 0 ? $hotelTotalPrice / $room->person_capacity : $hotelTotalPrice;

        $foodTotal = 0;
        if ($request->has('foods')) {
            foreach ($request->foods as $foodData) {
                $foodTotal += $foodData['total'] ?? 0;
            }
        }

        $grandTotal = $hotelTotalPrice 
                    + ($request->base_price ?? 0) 
                    + ($request->extra_cost ?? 0) 
                    + ($request->transport_cost ?? 0) 
                    + $foodTotal;

        // Update base fields
        $package->update([
            'title'             => $request->title,
            'description'       => $request->description,
            'destination_id'    => $request->destination_id,
            'hotel_id'          => $request->hotel_id,
            'room_id'           => $request->room_id,
            'nights'            => $request->nights,
            'hotel_total_price' => $hotelTotalPrice,
            'per_head_price'    => $perHeadPrice,
            'base_price'        => $request->base_price ?? 0,
            'extra_cost'        => $request->extra_cost ?? 0,
            'transport_cost'    => $request->transport_cost ?? 0,
            'grand_total'       => $grandTotal,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
        ]);

        // Update image if uploaded
        if ($request->hasFile('image')) {
            if ($package->image && file_exists(public_path('uploads/packages/' . $package->image))) {
                unlink(public_path('uploads/packages/' . $package->image));
            }
            $imageName = $request->file('image')->store('uploads/packages', 'public');
            $package->image = $imageName;
            $package->save();
        }

        // Refresh foods
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

    // Delete package
    public function destroy(Packages $package)
    {
        if ($package->image && file_exists(public_path('uploads/packages/' . $package->image))) {
            unlink(public_path('uploads/packages/' . $package->image));
        }
        $package->foods()->delete();
        $package->delete();

        return redirect()->back()->with('success', 'Package deleted successfully!');
    }

    // ========== AJAX APIs ==========

    // Get Hotels by Destination
    public function getHotels($destinationId)
    {
        $hotels = Hotels::where('destination_id', $destinationId)->get();
        return response()->json($hotels);
    }

    // Get Rooms by Hotel
    public function getRooms($hotelId)
    {
        $rooms = HotelRooms::where('hotel_id', $hotelId)->get();
        return response()->json($rooms);
    }

    // Get Foods by Destination
    public function getFoods($destinationId)
    {
        $foods = Foods::where('destination_id', $destinationId)->get();
        return response()->json($foods);
    }
}
