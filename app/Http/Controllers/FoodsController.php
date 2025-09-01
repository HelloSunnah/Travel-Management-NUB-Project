<?php

namespace App\Http\Controllers;

use App\Models\Foods;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    public function index()
    {
        $foods = Foods::all();
        return view('AdminPanel.Food.index', compact('foods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'price_per_meal' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Foods::create($request->all());

        return redirect()->back()->with('success', 'Food item added successfully.');
    }

    public function update(Request $request, Foods $food)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'price_per_meal' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $food->update($request->all());

        return redirect()->back()->with('success', 'Food item updated successfully.');
    }

    public function destroy(Foods $food)
    {
        $food->delete();
        return redirect()->back()->with('success', 'Food item deleted successfully.');
    }
}
