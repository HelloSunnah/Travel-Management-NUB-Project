<?php

namespace App\Http\Controllers;

use App\Models\Foods;
use App\Models\PackageFoods;
use App\Models\Packages;
use Illuminate\Http\Request;

class PackageFoodsController extends Controller
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

    public function update(Request $request, Packages $package, PackageFoods $packageFood)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $food = $packageFood->food;

        $packageFood->update([
            'quantity'    => $request->quantity,
            'total_price' => $food->price_per_meal * $request->quantity,
        ]);

        return back()->with('success', 'Package food updated!');
    }

    public function destroy(Packages $package, PackageFoods $packageFood)
    {
        $packageFood->delete();
        return back()->with('success', 'Food removed from package!');
    }
}
