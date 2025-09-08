<?php

namespace App\Http\Controllers;

use App\Models\destinations;
use App\Models\Foods;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    public function byDestination($destinationId)
{
    $foods = Foods::where('destination_id', $destinationId)->get();
    return response()->json($foods);
}

  public function index(Request $request)
{
    $foods = Foods::latest()->get();
    $destinations = destinations::all();

    // If editing a food
    $editFood = null;
    if ($request->has('editFood')) {
        $editFood = Foods::find($request->editFood);
    }

    return view('AdminPanel.Food.index', compact('foods', 'destinations', 'editFood'));
}

    // Store new food
    public function store(Request $request)
    {
    $request->validate([
    'destination_id' => 'required|exists:destinations,id',
    'name' => 'required|string|max:255',
    'menu_items' => 'required|string',
    'price' => 'required|numeric|min:0',
]);

Foods::create($request->only(['destination_id', 'name', 'menu_items', 'price']));

        return redirect()->back()->with('success', 'Food added successfully.');
    }

    // Update food
    public function update(Request $request, Foods $food)
    {
      $request->validate([
    'destination_id' => 'required|exists:destinations,id',
    'name' => 'required|string|max:255',
    'menu_items' => 'required|string',
    'price' => 'required|numeric|min:0',
]);


$food->update($request->only(['destination_id', 'name', 'menu_items', 'price']));

        return redirect()->back()->with('success', 'Food updated successfully.');
    }

    // Delete food
    public function destroy(Foods $food)
    {
        $food->delete();
        return redirect()->back()->with('success', 'Food deleted successfully.');
    }
}
