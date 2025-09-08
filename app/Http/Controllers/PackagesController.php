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
{ public function index()
    {
        $destinations = destinations::with('foods')->get();
        $hotels = Hotels::with('rooms')->get();
        $packages = Packages::with(['destination','hotel','room','foods.food'])->get();

        return view('AdminPanel.Package.Index', compact('destinations','hotels','packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'destination_id'=>'required|exists:destinations,id',
            'hotel_id'=>'required|exists:hotels,id',
            'room_id'=>'required|exists:hotel_rooms,id',
            'nights'=>'required|integer|min:1',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date'
        ]);

        $room = HotelRooms::findOrFail($request->room_id);
        $hotel_total_price = $room->price_per_night * $request->nights;

        $package = Packages::create([
            'title'=>$request->title,
            'destination_id'=>$request->destination_id,
            'hotel_id'=>$request->hotel_id,
            'room_id'=>$request->room_id,
            'nights'=>$request->nights,
            'hotel_total_price'=>$hotel_total_price,
            'base_price'=>$request->base_price ?? 0,
            'extra_cost'=>$request->extra_cost ?? 0,
            'transport_cost'=>$request->transport_cost ?? 0,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        ]);

        if($request->has('foods')){
            foreach($request->foods as $f){
                if(isset($f['food_id'])){
                    $food = Foods::find($f['food_id']);
                    $qty = $f['quantity'] ?? 1;
                    $package->foods()->create([
                        'food_id'=>$food->id,
                        'quantity'=>$qty,
                        'total_price'=>$food->price * $qty
                    ]);
                }
            }
        }

        return redirect()->back()->with('success','Package created successfully!');
    }

    public function edit(Packages $package)
    {
        $destinations = destinations::with('foods')->get();
        $hotels = Hotels::with('rooms')->get();
        $packages = Packages::with(['destination','hotel','room','foods.food'])->get();
        $package->load('hotel.rooms','foods.food','room');

        return view('AdminPanel.Package.Index', compact('package','destinations','hotels','packages'));
    }

    public function update(Request $request, Packages $package)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'destination_id'=>'required|exists:destinations,id',
            'hotel_id'=>'required|exists:hotels,id',
            'room_id'=>'required|exists:hotel_rooms,id',
            'nights'=>'required|integer|min:1',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date'
        ]);

        $room = HotelRooms::findOrFail($request->room_id);
        $hotel_total_price = $room->price_per_night * $request->nights;

        $package->update([
            'title'=>$request->title,
            'destination_id'=>$request->destination_id,
            'hotel_id'=>$request->hotel_id,
            'room_id'=>$request->room_id,
            'nights'=>$request->nights,
            'hotel_total_price'=>$hotel_total_price,
            'base_price'=>$request->base_price ?? 0,
            'extra_cost'=>$request->extra_cost ?? 0,
            'transport_cost'=>$request->transport_cost ?? 0,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        ]);

        $package->foods()->delete();
        if($request->has('foods')){
            foreach($request->foods as $f){
                if(isset($f['food_id'])){
                    $food = Foods::find($f['food_id']);
                    $qty = $f['quantity'] ?? 1;
                    $package->foods()->create([
                        'food_id'=>$food->id,
                        'quantity'=>$qty,
                        'total_price'=>$food->price * $qty
                    ]);
                }
            }
        }

        return redirect()->back()->with('success','Package updated successfully!');
    }

    public function destroy(Packages $package)
    {
        $package->foods()->delete();
        $package->delete();
        return redirect()->back()->with('success','Package deleted successfully!');
    }

    // API: Get foods by destination (for AJAX)
    public function foodsByDestination(destinations $destination)
    {
        return response()->json($destination->foods);
    }

    // API: Get rooms by hotel (for AJAX)
    public function roomsByHotel(Hotels $hotel)
    {
        return response()->json($hotel->rooms);
    }
}
