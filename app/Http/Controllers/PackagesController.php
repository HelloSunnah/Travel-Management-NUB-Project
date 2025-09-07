<?php

namespace App\Http\Controllers;

use App\Models\PackageFoods;
use App\Models\Packages;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
     public function index(Request $request)
    {
        $packages = Packages::with('foods')->latest()->get(); // eager load foods
        $editPackage = null;

        if ($request->has('edit')) {
            $editPackage = Packages::with('foods')->find($request->edit);
        }

        return view('AdminPanel.Package.Index', compact('packages', 'editPackage'));
    }

    // Store new package
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'days'          => 'required|integer|min:1',
            'nights'        => 'required|integer|min:1',
            'benefit_type'  => 'required|in:fixed,percent',
            'benefit_value' => 'required|numeric|min:0',
            'status'        => 'required|in:active,inactive',
        ]);

        $package = Packages::create($data);

        // Save related foods (optional input: foods[] = [id, qty, total])
        if ($request->has('foods')) {
            foreach ($request->foods as $food) {
                PackageFoods::create([
                    'package_id'   => $package->id,
                    'food_id'      => $food['id'],
                    'quantity'     => $food['quantity'] ?? 1,
                    'total_price'  => $food['total_price'] ?? 0,
                ]);
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
    }

    // Update package
    public function update(Request $request, Packages $package)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'days'          => 'required|integer|min:1',
            'nights'        => 'required|integer|min:1',
            'benefit_type'  => 'required|in:fixed,percent',
            'benefit_value' => 'required|numeric|min:0',
            'status'        => 'required|in:active,inactive',
        ]);

        $package->update($data);

        // Sync foods
        if ($request->has('foods')) {
            $package->foods()->delete(); // clear old
            foreach ($request->foods as $food) {
                PackageFoods::create([
                    'package_id'   => $package->id,
                    'food_id'      => $food['id'],
                    'quantity'     => $food['quantity'] ?? 1,
                    'total_price'  => $food['total_price'] ?? 0,
                ]);
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
    }

    // Delete package
    public function destroy(Packages $package)
    {
        $package->delete(); // cascade deletes foods
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
    }
}
