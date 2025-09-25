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
// Show all packages
public function index()
{
    $packages = Packages::with(['destination', 'hotel', 'room', 'foods'])->latest()->get();
    return view('AdminPanel.Package.Index', compact('packages'));
}

public function create()
{
    $destinations = Destinations::all();
    $hotels = Hotels::all();
    return view('AdminPanel.Package.create', compact('destinations', 'hotels'));
}
public function store(Request $request)
{
    //dd($request);
    $request->validate([
        'title'          => 'required|string|max:255',
        'description'    => 'nullable|string|max:255',
        'destination_id' => 'required|exists:destinations,id',
        'hotel_id'       => 'required|exists:hotels,id',
        'room_id'        => 'required|exists:hotel_rooms,id',
        'nights'         => 'required|integer|min:1',
        'start_date'     => 'required|date',
        'end_date'       => 'required|date|after_or_equal:start_date',
    ]);

    $room = HotelRooms::findOrFail($request->room_id);

    // Calculate per person price for the package
    $perHeadPrice = $room->price_per_person * $request->nights;

    // Food total
    $foodTotal = 0;
    if ($request->has('foods')) {
        foreach ($request->foods as $foodData) {
            $foodTotal += $foodData['total'] ?? 0;
        }
    }

    // Grand total for 1 person
    $grandTotal = $perHeadPrice
                + ($request->base_price ?? 0)
                + ($request->extra_cost ?? 0)
                + ($request->transport_cost ?? 0)
                + $foodTotal;

    // Handle image upload
    $imageName = $request->hasFile('image')
        ? $request->file('image')->store('uploads/packages', 'public')
        : null;

    // Create package
    $package = Packages::create([
        'title'             => $request->title,
        'description'       => $request->description,
        'destination_id'    => $request->destination_id,
        'hotel_id'          => $request->hotel_id,
        'room_id'           => $request->room_id,
        'nights'            => $request->nights,
        'hotel_total_price' => $perHeadPrice, // price for 1 person
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

return redirect()->route('packages.index')
                 ->with('success', 'Package created successfully!');
}
public function search(Request $request)
{
    $query = Packages::query();

    // Destination filter
    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->destination_id);
    }

    // Date range filter
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
    }

    $searchPackages = $query->latest()->paginate(9);

    // For dropdown list
     $packages = Packages::with('destination', 'hotel', 'room')->paginate(9);
    $destinations = Destinations::all();

    return view('Frontend', compact('searchPackages', 'destinations','packages'));
}

    // Edit package
public function edit(Packages $package)
{
    $destinations = Destinations::all();
    $hotels = Hotels::all();
    $rooms = $package->hotel ? $package->hotel->rooms : collect();
    $foods = $package->destination ? $package->destination->foods : collect();

    return view('AdminPanel.Package.Edit', compact('package', 'destinations', 'hotels', 'rooms', 'foods'));
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
    public function getHotelsByDestination($destinationId)
{
    $hotels = Hotels::where('destination_id', $destinationId)->get();
    return response()->json($hotels);
}

public function getFoodsByDestination($destinationId)
{
    $foods = Foods::where('destination_id', $destinationId)->get();
    return response()->json($foods);
}
}
