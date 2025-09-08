<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\Foods;
use App\Models\HotelRooms;
use App\Models\Hotels;
use App\Models\packageFoods;
use App\Models\Packages;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index()
    {
    $destinations = Destinations::all();
    $hotels = Hotels::with('rooms')->get();
    $packages = Packages::with('destination','hotel','room','foods.food')->get();

    // For initial load, foods for first destination (optional)
    $foods = $destinations->first() ? $destinations->first()->foods : collect();

    return view('AdminPanel.Package.Index', compact('destinations','hotels','packages','foods'));

    }

    public function create()
    {
        $destinations = destinations::all();
        $hotels = Hotels::with('rooms')->get();
        $foods = Foods::all();
        return view('AdminPanel.Package.Index', compact('destinations', 'hotels', 'foods'));
    }

    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:hotel_rooms,id',
            'nights' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Calculate hotel total price
        $room = HotelRooms::findOrFail($request->room_id);
        $hotel_total_price = $room->price_per_night * $request->nights;

        $package = Packages::create([
            'title' => $request->title,
            'destination_id' => $request->destination_id,
            'hotel_id' => $request->hotel_id,
            'room_id' => $request->room_id,
            'nights' => $request->nights,
            'hotel_total_price' => $hotel_total_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'base_price' => $request->base_price ?? 0,
        ]);
        if ($request->has('foods')) {
            foreach ($request->foods as $foodData) {
                if (isset($foodData['food_id'])) {
                    $food = Foods::find($foodData['food_id']);
                    $quantity = $foodData['quantity'] ?? 1;
                    $package->foods()->create([
                        'food_id' => $food->id,
                        'quantity' => $quantity,
                        'total_price' => $food->price * $quantity,
                    ]);
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
    }

    public function edit(Packages $package)
    {
        $destinations = destinations::all();
        $hotels = Hotels::with('rooms')->get();
        $foods = Foods::all();
        $packages = Packages::with('destination', 'hotel', 'room', 'foods.food')->get();

        // Ensure hotel with rooms is loaded for the selected package
        $package->load('hotel.rooms', 'room', 'foods.food');

        return view('AdminPanel.Package.Index', compact('package', 'destinations', 'hotels', 'foods', 'packages'));
    }

    public function update(Request $request, Packages $package)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:hotel_rooms,id',
            'nights' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $room = HotelRooms::findOrFail($request->room_id);
        $hotel_total_price = $room->price_per_night * $request->nights;

        $package->update([
            'title' => $request->title,
            'destination_id' => $request->destination_id,
            'hotel_id' => $request->hotel_id,
            'room_id' => $request->room_id,
            'nights' => $request->nights,
            'hotel_total_price' => $hotel_total_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'base_price' => $request->base_price ?? 0,
        ]);

        // Remove old foods
        $package->foods()->delete();

        if ($request->has('foods')) {
            foreach ($request->foods as $foodData) {
                if (isset($foodData['food_id'])) {
                    $food = Foods::find($foodData['food_id']);
                    $quantity = $foodData['quantity'] ?? 1;
                    $package->foods()->create([
                        'food_id' => $food->id,
                        'quantity' => $quantity,
                        'total_price' => $food->price * $quantity,
                    ]);
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
    }

    public function destroy(Packages $package)
    {
        $package->foods()->delete();
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
    }
}
