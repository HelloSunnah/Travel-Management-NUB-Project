<?php

namespace App\Http\Controllers;

use App\Models\Foods;
use App\Models\packageFoods;
use App\Models\Packages;
use Illuminate\Http\Request;

class packageFoodsController extends Controller
{
 public function store(Request $request, Packages $package)
    {
        $request->validate([
            'food_id'  => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $food = Foods::findOrFail($request->food_id);

        $package->foods()->attach($food->id, [
            'quantity'    => $request->quantity,
            'total_price' => $food->price_per_meal * $request->quantity,
        ]);

        return back()->with('success', 'Food added to package successfully!');
    }

    public function update(Request $request, Packages $package, packageFoods $packageFoods)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $food = $packageFoods->food;

        $packageFoods->update([
            'quantity'    => $request->quantity,
            'total_price' => $food->price_per_meal * $request->quantity,
        ]);

        return back()->with('success', 'Package food updated!');
    }

    public function destroy(Packages $package, packageFoods $packageFoods)
    {
        $packageFoods->delete();
        return back()->with('success', 'Food removed from package!');
    }
}
